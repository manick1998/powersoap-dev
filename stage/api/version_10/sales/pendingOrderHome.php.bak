<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shopId = $json_input->shopId;
$home_data=array();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$order_date = date('Y-m-d h:i:s');
$dateonly = $indiaDate;
 $dayname =  date('l', strtotime($order_date));

 
 if($shopId==0){
    $shopQuery='';
   }else{
    $shopQuery=" AND shop.id < $shopId";
   }


 //distributor_token
$get_distributor_id = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$distributor_id = $row_id['admin_distributor_token'];

$sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token = $employee_id  AND schedule_date = '$dayname'";
$amount = $link->query($sql);
$data= $amount->num_rows;


$sql1 = "SELECT * FROM custom_daily_schedule WHERE sales_emp_token =$employee_id AND schedule_date = '$dayname'";
$amount1 = $link->query($sql1);
$data1= $amount1->num_rows;



$shop_query = mysqli_query($link,"SELECT shop.id,
shop.name,
shop.token,
shop.address,
shop.city,
shop.pincode,
COALESCE(SUM(orders.billing_amount),0) AS bill_amt_val,
 COALESCE(SUM(orders.paid_amount),0) AS paid_amt_val,
shop__outstanding.bill_amount,
shop__outstanding.paid_amt,
shop__outstanding.total_outstanding,
shop__type.name as type_name,
 COALESCE( SUM(orders.items) ,0) AS items,
COALESCE(orders.delivery) as delivery
FROM
 `orders`
INNER JOIN shop_mapping on shop_mapping.token = orders.shop_token
INNER JOIN shop on shop_mapping.shop_token = shop.token
INNER JOIN shop__outstanding ON shop__outstanding.shop_token = orders.shop_token
INNER JOIN shop__type on shop__type.token = shop.shop_type_code
WHERE
(orders.employee_token = '$employee_id' OR orders.distributor_token='$distributor_id') $shopQuery AND orders.delivery='Pending' AND date(orders.date_time)!='$dateonly' AND orders.order_type!='Distributor Order' GROUP BY shop.token ORDER BY shop.id DESC limit 10");

$shop_array = array();
$discount_amount_finall = 0;
$total_shop =0;
while($shop_row = mysqli_fetch_array($shop_query)) {
    $total_shop++;

 $shop_token = $shop_row['token'];
 $shop_mapToken = mysqli_query($link,"SELECT `token` FROM `shop_mapping` WHERE `shop_token`='$shop_token' AND `distributor_token`='$distributor_id'");
 $row = mysqli_fetch_array($shop_mapToken);
 $token_map = $row['token'];
 $shop_total_value = mysqli_query($link,"SELECT
                                    SUM(`billing_amount`) AS billing_amount1,
                                    SUM(`paid_amount`) AS paid_amount1,
                                    SUM(`bill_discount_amount`) AS bill_discount_amount,
                                    SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                                     COALESCE( SUM(orders.items) ,0) AS items1
                                FROM
                                    `orders`
                                WHERE
                                    `shop_token` = '$token_map' AND `delivery` != 'Cancelled'");
             $get_shop_total_value = mysqli_fetch_array($shop_total_value);
             $shop_bill_value = $get_shop_total_value['billing_amount1'];
             $shop_paid_value = $get_shop_total_value['paid_amount1'];
             $percentage_value = $get_shop_total_value['percentage_value'];


               $bill_discount_amount = $get_shop_total_value['bill_discount_amount'];
               

                 if($bill_discount_amount > 0) {
                        $discount_amount_finall1 = round($bill_discount_amount);
                     } 
                     else {
                        $discount_amount_finall1 = 0;
                     }

                     $discount_amount_finall = $discount_amount_finall1  + $percentage_value;





    $obj_shop = new stdClass;
    $obj_shop->shopId = (int)$shop_row['id'];
    $obj_shop->shop_id = $shop_row['token'];
    $obj_shop->shop_name = $shop_row['name'];

    $obj_shop->shop_total = round($get_shop_total_value['billing_amount1'] - $discount_amount_finall);
     $obj_shop->paid_amt = round($shop_row['paid_amt_val']);
     $obj_shop->balance_amt = round(($get_shop_total_value['billing_amount1']) - ($discount_amount_finall + $get_shop_total_value['paid_amount1']));
     $get_balance_amt = round(($get_shop_total_value['billing_amount1'] )- ($discount_amount_finall + $get_shop_total_value['paid_amount1']));

     $obj_shop->delivery = $shop_row['delivery'];

    // $obj_shop->target_amount =round($shop_row['bill_amt_val'] - $discount_amount_finall);// round($shop_row['bill_amount']);
    // $obj_shop->achived_amount = round($shop_row['paid_amt_val']);//round($shop_row['paid_amt']);
    // $obj_shop->balance_amount = round(($shop_row['bill_amt_val'] - $discount_amount_finall) - $shop_row['paid_amt_val']);//round($shop_row['bill_amount'] - $shop_row['paid_amt']);
    
    $obj_shop->target_amount =round($get_shop_total_value['billing_amount1'] - $discount_amount_finall);// round($shop_row['bill_amount']);
    $obj_shop->achived_amount = round($get_shop_total_value['paid_amount1']);//round($shop_row['paid_amt']);
    $obj_shop->balance_amount = $get_balance_amt;//round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall) - $get_shop_total_value['paid_amount1']);//round($shop_row['bill_amount'] - $shop_row['paid_amt']);

    $obj_shop->category_name = $shop_row['type_name'];
    $obj_shop->items = $get_shop_total_value['items1'];
    $obj_shop->address = $shop_row['address'];
    $obj_shop->city = $shop_row['city'];
    $obj_shop->pincode = $shop_row['pincode'];
    $obj_shop->shop_distance = rand(1,10);
    array_push($shop_array,$obj_shop);
}


$home_screen = new stdClass;
$home_screen->total_shop = $total_shop;
$home_screen->shop_details = $shop_array;

$obj = new stdClass;
if($employee_id && ($shop_array)){
    $obj->status_code=200; 
    $obj->message='Product found ';
    $obj->title='Success';
    $obj->data = $home_screen;
}else if(count($shop_array)==0 && $shopId!=0){
$obj->status_code=200; 
$obj->message='Product found ';
$obj->title='Success';
$obj->data = $home_screen;
}else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
?>