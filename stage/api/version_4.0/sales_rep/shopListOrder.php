<?php
include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDate;
$sales_rep_employee_token = $json_input->sales_rep_employee_token;
$distributor_token = $json_input->distributor_token;
$obj1 = new stdClass;
date_default_timezone_set('Asia/Kolkata');
$currentDate =  date('Y-m-d');
                    $sql = mysqli_query($link,"SELECT
                    `shop`.`token`,
                    `shop`.`name`,
                    `shop`.`address`,
                    `shop`.`city`,
                    `shop`.`pincode`,
                    COALESCE(`shop`.`unit_token`, 0) AS unit_token,
                    COALESCE(orders.delivery,'-')AS delivery,
                    shop__type.name AS shop_type,
                    COALESCE(units.name,'No Unit') AS unit_name
                    FROM
                    `employees`
                    INNER JOIN shop_mapping ON shop_mapping.distributor_token = `employees`.`token`
                    INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
                    left JOIN orders ON orders.shop_token = shop.token
                    INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
                    LEFT JOIN units ON units.token = shop.unit_token
                    WHERE
                    shop_mapping.`distributor_token` = '$distributor_token' AND shop.shop_show_status = 'Active' 
                    GROUP BY
                    `shop`.`token`");

//fetching list
$array = [];
while($row = mysqli_fetch_array($sql)){
    $obj = new stdClass;
    $shopToken = $row['token'];
    $sql2 = mysqli_query($link,"SELECT
                            COALESCE(date_time,0) as last_date,
                            COALESCE(orders.is_slaes_rep_admin,0) AS salesTaken,
                            COALESCE(orders.billing_amount,0)as amount
                            FROM
                            `orders`
                            WHERE
                            shop_token = '$shopToken' AND date(`date_time`)='$currentDate'
                            ORDER BY
                            id
                            DESC
                            LIMIT 1");

    $row2 = mysqli_fetch_array($sql2);
    $get_lastDate = $row2['last_date'];
    $amount = $row2['amount']==""?0:$row2["amount"];
    $timestamp = $get_lastDate;
    $splitTimeStamp = current(explode(" ",$timestamp));
   if($splitTimeStamp == $currentDate && $shopToken!=""){
    $salesRep_taken = $row2['salesTaken'];
   }else{
    $salesRep_taken = 0;
   }
    $shop_date = date('d M Y', strtotime($get_lastDate));
    $obj->orderdate = $shop_date;
    $obj->salesRep_taken = $salesRep_taken;
    $obj->token = $row['token'];
    $obj->name = $row['name'];
    $obj->address = $row['address'];
    $obj->city = $row['city'];
    $obj->pincode = $row['pincode'];
    $obj->shop_type = $row['shop_type'];
    $obj->unit_token = $row['unit_token'];
    $obj->unit_name = $row['unit_name'];
    $obj->total_amount = $amount;
    $obj->order_status = $row['delivery'];
    array_push($array,$obj);
}

if($distributor_token !=""){ 
    $obj1->status_code=200; 
    $obj1->message='Data Listed';
    $obj1->title='Success';
    $obj1->data=$array;
}else{
    $obj1->status_code=400; 
    $obj1->message='No data found';
    $obj1->title='Error';
}
echo json_encode($obj1);
?>