<?php
// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
include "../../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
//echo "hah",$employee_id;
$home_data=array();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$order_date = date('Y-m-d h:i:s');
$dateonly = $indiaDate;
//echo $dateonly;
 $dayname =  date('l', strtotime($order_date));
 //echo $dayname;

 //$sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token = $employee_id AND date(date_time) = '$dateonly' AND schedule_date = '$dayname'";
 $sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token='$employee_id'  AND schedule_date = '$dayname'";
 $amount = $link->query($sql);
$data= $amount->num_rows;
//echo $data ;

if ($data == 0) {

    //custom unit shop values and order values:  
  $amount_11 = mysqli_query($link,"SELECT
  shop.name,
  SUM(shop__outstanding.bill_amount) AS order_value1,
  COALESCE(SUM(orders.billing_amount),0)AS order_value,
  SUM(shop__outstanding.paid_amt) AS total_coolection,
  SUM(
      shop__outstanding.total_outstanding
  ) AS outstanding,
  COUNT(DISTINCT shop.token) AS shop_count_value,
  shop.unit_token,
  SUM(
      CASE WHEN `orders`.bill_discount_percentage != 0 THEN(
          (
              `orders`.`billing_amount` * `orders`.`bill_discount_percentage`
          ) / 100
      ) ELSE 0
  END
) AS percentage_value,
COALESCE(SUM(orders.bill_discount_amount),0) AS discount
FROM custom_daily_schedule INNER JOIN unit_customise_mapping ON custom_daily_schedule.custom_unit_token = unit_customise_mapping.custom_unit_token
INNER JOIN units__shop_mapping ON unit_customise_mapping.unit_token = units__shop_mapping.unit_group_token
INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
INNER JOIN shop on shop.token=units__shop_mapping.shop_token
LEFT JOIN orders ON units__shop_mapping.shop_token = orders.shop_token
WHERE
                      sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND shop.delete_status=1 AND unit_customise_mapping.delete_status = 1 AND custom_daily_schedule.schedule_date='$dayname'");
                          
                          // while($rows1 = mysqli_fetch_assoc($amount_11)){
                          //     echo  "\n". "name"," ",$rows1['name'] ;
                          //     echo  "\n". "order_value1"," ", $rows1['order_value1'];
                          //     echo  "\n". "order_value"," ", $rows1['order_value'];
                          //     echo  "\n". "total_coolection"," ", $rows1['total_coolection'];
                          //     echo  "\n". "outstanding"," ", $rows1['outstanding'];
                          //     echo  "\n". "shop_count_value"," ",intval($rows1['shop_count_value']-($rows1['percentage_value']+$rows1['discount']));
                          //     echo  "\n". "unit_token"," ", $rows1['unit_token'];
                          //     echo  "\n". "percentage_value"," ", $rows1['percentage_value'];
                          //     echo  "\n". "discount"," ", $rows1['discount'];
                          //  }
                          $amt_value1 = mysqli_fetch_array($amount_11);

                          
                           
//shop count
$shop_data = mysqli_query($link,"SELECT count(shop.token)as shop_count FROM unit_customise_mapping 
INNER JOIN shop ON unit_customise_mapping.unit_token = shop.unit_token
INNER JOIN custom_daily_schedule ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token
INNER JOIN orders ON orders.shop_token = shop.token
WHERE custom_daily_schedule.sales_emp_token=$employee_id AND custom_daily_schedule.schedule_date='$dayname' AND unit_customise_mapping.delete_status=1 AND  orders.delivery IN ('Pending','Completed')
GROUP BY shop.token");
          $shop_value_11 = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `date_time` LIKE '%$dateonly%' AND `sales_token` = $employee_id");

// today collect cash
$today_collection_value = mysqli_query($link,"SELECT SUM(`amount`) as today_amount FROM `shop__order_transaction` WHERE `employee_id` = $employee_id AND `date_time` LIKE '$dateonly%'");
$get_today_amt_val  = mysqli_fetch_array($today_collection_value);
$today_collection_amount  = $get_today_amt_val['today_amount'];

$over_all_amount_val = mysqli_query($link,"SELECT
                          SUM(billing_amount) AS overallamt,
                          SUM(CASE WHEN `orders`.bill_discount_percentage !=0 THEN((`orders`.`billing_amount`*`orders`.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                          SUM(`bill_discount_amount`) as discount_amt
                      FROM
                          `orders`
                      WHERE
                          `employee_token` = '$employee_id' AND date_time LIKE '$dateonly%' AND `order_type` = 'Sales Order' AND delivery != 'Cancelled'");

          $get_all_amount_val = mysqli_fetch_array($over_all_amount_val);
           $overall_item_amt_val = round($get_all_amount_val['overallamt']-($get_all_amount_val['percentage_value']+$get_all_amount_val['discount_amt']));

$shoptake_data = mysqli_fetch_array($shop_data);
$shoptake_value_12 = mysqli_num_rows($shop_value_11);
$check_countvalue_data = $amt_value1['shop_count_value'];




$obj_data = new stdClass;
$obj_data->cover_today_value=$shoptake_value_12;
$obj_data->cover_today_outoff=intval($amt_value1['shop_count_value']);
// percentage_value
// discount
// echo $amt_value1['shop_count_value'];
// echo $amt_value1['percentage_value'];
// echo $amt_value1['discount'];

//echo $today_order = intval($amt_value1['shop_count_value']-($amt_value1['percentage_value']+$amt_value1['discount']));
$obj_data->today_order = intval($amt_value1['order_value']-($amt_value1['percentage_value']+$amt_value1['discount']));
$obj_data->today_cover = 0;
$obj_data->achived_productivity = $shoptake_value_12;
$obj_data->overall_productivity = intval($amt_value1['shop_count_value']);
$obj_data->today_collection_amount = round($today_collection_amount);
$obj_data->overall_item_amount_value = round($overall_item_amt_val);
if($check_countvalue_data > 0){
$obj_data->productivity = round(($shoptake_value_12/$amt_value1['shop_count_value'])*5);
}else{
$obj_data->productivity = 0;
}
$obj_data->unit_token = $amt_value1['unit_token'];


  $amount_val1 = mysqli_query($link,"SELECT
  shop.token AS shop_token,
  shop.name,
  shop__type.name as type_name,
  shop.address,
  shop.city,
  shop.pincode,
  unit_customise_mapping.unit_token AS unit_token,
  units.name AS units_name,
  COALESCE(SUM(orders.billing_amount),
  0) AS bill_amt_val,
  COALESCE(SUM(orders.paid_amount),
  0) AS paid_amt_val,
  shop__outstanding.bill_amount,
  shop__outstanding.paid_amt,
  shop__outstanding.total_outstanding,
  unit_customise_mapping.distributor_token,
  custom_daily_schedule.schedule_date,
  COALESCE( SUM(orders.items) ,0) AS items,
  
  COALESCE(orders.delivery, 'NoOrder') AS delivery,
  COALESCE(SUM(
      discount_order.bill_discount_amount
  ),0) AS bill_discount_amount,
 COALESCE(SUM(
      discount_order.bill_discount_percentage
  ),0) AS bill_discount_percentage
FROM
  shop
INNER JOIN unit_customise_mapping ON shop.unit_token = unit_customise_mapping.unit_token
INNER JOIN units ON unit_customise_mapping.unit_token = units.token 

INNER JOIN custom_daily_schedule ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token 

INNER JOIN shop__outstanding ON shop.token = shop__outstanding.shop_token


LEFT JOIN orders ON orders.shop_token = shop.token AND orders.date_time LIKE '$dateonly%' AND orders.delivery != 'Cancelled' AND custom_daily_schedule.sales_emp_token = $employee_id

LEFT JOIN orders AS discount_order ON discount_order.shop_token = shop.token AND discount_order.date_time < '$dateonly 23:59:59' AND discount_order.delivery != 'Cancelled'
INNER JOIN units__shop_mapping ON unit_customise_mapping.unit_token = units__shop_mapping.unit_group_token
INNER JOIN shop__type on shop__type.token = shop.shop_type_code
WHERE
  custom_daily_schedule.sales_emp_token = $employee_id AND custom_daily_schedule.schedule_date = '$dayname' AND shop.delete_status = '1'  AND unit_customise_mapping.delete_status = '1'
GROUP BY
   shop.token
ORDER BY
  shop.id
DESC");

$shop_array = array();
$discount_amount_finall_11 = 0;
while($shop_rows = mysqli_fetch_array($amount_val1)) {

$delivery_check_data = $shop_rows['delivery'];
  if($delivery_check_data =='Pending' || $delivery_check_data == 'Completed'){
  $delivery_value = 'Completed';
  }
  else
  {
  $delivery_value = 'NoOrder';
  }
//}

$shop_token_data = $shop_rows['shop_token'];
$shop_total_value_count = mysqli_query($link,"SELECT
                                 SUM(`billing_amount`) AS billing_amount1,
                                 SUM(`paid_amount`) AS paid_amount1,
                                 SUM(`bill_discount_amount`) AS bill_discount_amount,
                                 SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                                  COALESCE( SUM(orders.items) ,0) AS items1
                             FROM
                                 `orders`
                             WHERE
                                 `shop_token` = '$shop_token_data' AND `delivery` != 'Cancelled'");
          $get_shop_total_value1 = mysqli_fetch_array($shop_total_value_count);
          $shop_bill_value1 = $get_shop_total_value1['billing_amount1'];
          $shop_paid_value1 = $get_shop_total_value1['paid_amount1'];
          $percentage_value1 = $get_shop_total_value1['percentage_value'];


            $bill_discount_amount1 = $get_shop_total_value1['bill_discount_amount'];
            

              if($bill_discount_amount1 > 0) {
                     $discount_amount_finall_11 = round($bill_discount_amount1);
                  } 
                  else {
                     $discount_amount_finall_11 = 0;
                  }

                  $discount_amount_finall_11 = $discount_amount_finall_11  + $percentage_value1;





 $obj_shop = new stdClass;
 $obj_shop->shop_id = $shop_rows['shop_token'];
 $obj_shop->shop_name = $shop_rows['name'];

 $obj_shop->shop_total = round($get_shop_total_value1['billing_amount1'] - $discount_amount_finall_11);
 $obj_shop->paid_amt = round($shop_rows['paid_amt']);
 $obj_shop->balance_amt = round(($get_shop_total_value1['billing_amount1']) - ($discount_amount_finall_11 + $get_shop_total_value1['paid_amount1']));
 $get_balance_amt1 = round(($get_shop_total_value1['billing_amount1'] )- ($discount_amount_finall_11 + $get_shop_total_value1['paid_amount1']));

 
 $obj_shop->target_amount =round($get_shop_total_value1['billing_amount1'] - $discount_amount_finall_11);
 $obj_shop->achived_amount = round($get_shop_total_value1['paid_amount1']);
 $obj_shop->balance_amount = $get_balance_amt1;
 $obj_shop->category_name = $shop_rows['type_name'];
 $obj_shop->delivery = $delivery_value;
 $obj_shop->items = $get_shop_total_value1['items1'];
 $obj_shop->address = $shop_rows['address'];
 $obj_shop->city = $shop_rows['city'];
 $obj_shop->pincode = $shop_rows['pincode'];
 $obj_shop->shop_distance = rand(1,10);
 $obj_shop->units_name = $shop_rows['units_name'];
 array_push($shop_array,$obj_shop);
              }   
 
$home_screen = new stdClass;
$home_screen->summary_details = $obj_data;
$home_screen->shop_details = $shop_array;


$obj = new stdClass;
if($employee_id){
 $obj->status_code=200; 
 $obj->message='Product found';
 $obj->title='Success';
 $obj->data = $home_screen;
 
} else {
 $obj->status_code=400; 
 $obj->message='Product not found';
 $obj->title='Success';
 
}

echo json_encode($obj);
}
else{
 // shop values and order values:                      
$amount = mysqli_query($link,"SELECT
                       SUM(shop__outstanding.bill_amount) as order_value1,
                        SUM(orders.billing_amount) as order_value,
                       SUM(shop__outstanding.paid_amt) as total_coolection,
                       SUM(shop__outstanding.total_outstanding) as outstanding,
                        COUNT(DISTINCT shop.token) as count_value,
                        daily_schedule.unit_token,
                        SUM(CASE WHEN `orders`.bill_discount_percentage !=0 THEN((`orders`.`billing_amount`*`orders`.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                        SUM(orders.bill_discount_amount) as discount
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                    INNER JOIN shop on shop.token=units__shop_mapping.shop_token
                    LEFT JOIN orders ON units__shop_mapping.shop_token = orders.shop_token
                    WHERE
                        sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND daily_schedule.schedule_date='$dayname'");
                            
                            $amt_value = mysqli_fetch_array($amount);
//shop count
$shop_value = mysqli_query($link,"SELECT
                    COUNT(shop.token) AS count_value1
                FROM
                    `daily_schedule`
                INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
                INNER JOIN orders ON orders.shop_token = shop.token
                WHERE
                    sales_emp_token = $employee_id AND units__shop_mapping.delete_status = 1 AND daily_schedule.schedule_date = '$dayname' AND delivery in('Pending','Completed') GROUP BY orders.shop_token");
            $shop_value1 = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `date_time` LIKE '%$dateonly%' AND `sales_token` = $employee_id");

// today collect cash
            $today_collection = mysqli_query($link,"SELECT SUM(`amount`) as today_amount FROM `shop__order_transaction` WHERE `employee_id` = $employee_id AND `date_time` LIKE '$dateonly%'");
            $get_today_amt  = mysqli_fetch_array($today_collection);
            $today_collection_amount  = $get_today_amt['today_amount'];


            // $over_all_amount = mysqli_query($link,"SELECT SUM(billing_amount) as overallamt FROM `orders` WHERE `employee_token` ='$employee_id' AND date_time LIKE '$dateonly%' AND `order_type`='Sales Order' and delivery != 'Cancelled' ");
            $over_all_amount = mysqli_query($link,"SELECT
                            SUM(billing_amount) AS overallamt,
                            SUM(CASE WHEN `orders`.bill_discount_percentage !=0 THEN((`orders`.`billing_amount`*`orders`.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                            SUM(`bill_discount_amount`) as discount_amt
                        FROM
                            `orders`
                        WHERE
                            `employee_token` = '$employee_id' AND date_time LIKE '$dateonly%' AND `order_type` = 'Sales Order' AND delivery != 'Cancelled'");

            $get_all_amount = mysqli_fetch_array($over_all_amount);
             $overall_item_amt = round($get_all_amount['overallamt']-($get_all_amount['percentage_value']+$get_all_amount['discount_amt']));


$shoptake_value = mysqli_fetch_array($shop_value);
 $shoptake_value12 = mysqli_num_rows($shop_value1);
  $check_countvalue = $amt_value['count_value'];

  


$obj_data = new stdClass;
$obj_data->cover_today_value=$shoptake_value12;//intval($shoptake_value['count_value1']) ;
$obj_data->cover_today_outoff=intval($amt_value['count_value']);
// percentage_value
// discount
$obj_data->today_order = intval($amt_value['order_value']-($amt_value['percentage_value']+$amt_value['discount']));
$obj_data->today_cover = 0;//intval($amt_value['total_coolection']);
$obj_data->achived_productivity = $shoptake_value12;//intval($shoptake_value['count_value1']);
$obj_data->overall_productivity = intval($amt_value['count_value']);
$obj_data->today_collection_amount = round($today_collection_amount);
$obj_data->overall_item_amount_value = round($overall_item_amt);
if($check_countvalue > 0){
$obj_data->productivity = round(($shoptake_value12/$amt_value['count_value'])*5);
}else{
$obj_data->productivity = 0;//round(($shoptake_value12/$amt_value['count_value'])*5);
}
$obj_data->unit_token = $amt_value['unit_token'];


$shop_query = mysqli_query($link,"SELECT
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
                           units.name as units_name,
                            COALESCE( SUM(orders.items) ,0) AS items,
                           COALESCE(orders.delivery,'NoOrder') as delivery,
                           SUM(discount_order.bill_discount_amount) as bill_discount_amount,
                           SUM(discount_order.bill_discount_percentage) as bill_discount_percentage
                        FROM
                            `daily_schedule`
                        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                        INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                        LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token AND orders.date_time LIKE '$dateonly%' and orders.delivery != 'Cancelled' AND employee_token = $employee_id
                        LEFT JOIN orders AS discount_order ON discount_order.shop_token = units__shop_mapping.shop_token AND discount_order.date_time < '$dateonly 23:59:59' and discount_order.delivery != 'Cancelled' 
                        INNER JOIN shop on shop.token = units__shop_mapping.shop_token
                        INNER JOIN shop__type on shop__type.token = shop.shop_type_code
                        INNER JOIN units ON units.token = daily_schedule.unit_token
                        WHERE
                            sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND   daily_schedule.schedule_date='$dayname' GROUP BY shop.token ORDER BY shop.id Desc");

$shop_array = array();
$discount_amount_finall = 0;
while($shop_row = mysqli_fetch_array($shop_query)) {

$delivery_check = $shop_row['delivery'];
    if($delivery_check =='Pending' || $delivery_check == 'Completed'){
    $delivery_value = 'Completed';
    }
    else
    {
    $delivery_value = 'NoOrder';
    }



 $shop_token = $shop_row['token'];
 $shop_total_value = mysqli_query($link,"SELECT
                                    SUM(`billing_amount`) AS billing_amount1,
                                    SUM(`paid_amount`) AS paid_amount1,
                                    SUM(`bill_discount_amount`) AS bill_discount_amount,
                                    SUM(CASE WHEN bill_discount_percentage !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value,
                                     COALESCE( SUM(orders.items) ,0) AS items1
                                FROM
                                    `orders`
                                WHERE
                                    `shop_token` = '$shop_token' AND `delivery` != 'Cancelled'");
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
    $obj_shop->shop_id = $shop_row['token'];
    $obj_shop->shop_name = $shop_row['name'];

    $obj_shop->shop_total = round($get_shop_total_value['billing_amount1'] - $discount_amount_finall);
     $obj_shop->paid_amt = round($shop_row['paid_amt_val']);
     $obj_shop->balance_amt = round(($get_shop_total_value['billing_amount1']) - ($discount_amount_finall + $get_shop_total_value['paid_amount1']));
     $get_balance_amt = round(($get_shop_total_value['billing_amount1'] )- ($discount_amount_finall + $get_shop_total_value['paid_amount1']));

    // $obj_shop->target_amount =round($shop_row['bill_amt_val'] - $discount_amount_finall);// round($shop_row['bill_amount']);
    // $obj_shop->achived_amount = round($shop_row['paid_amt_val']);//round($shop_row['paid_amt']);
    // $obj_shop->balance_amount = round(($shop_row['bill_amt_val'] - $discount_amount_finall) - $shop_row['paid_amt_val']);//round($shop_row['bill_amount'] - $shop_row['paid_amt']);
    
    $obj_shop->target_amount =round($get_shop_total_value['billing_amount1'] - $discount_amount_finall);// round($shop_row['bill_amount']);
    $obj_shop->achived_amount = round($get_shop_total_value['paid_amount1']);//round($shop_row['paid_amt']);
    $obj_shop->balance_amount = $get_balance_amt;//round(($get_shop_total_value['billing_amount1'] - $discount_amount_finall) - $get_shop_total_value['paid_amount1']);//round($shop_row['bill_amount'] - $shop_row['paid_amt']);

    $obj_shop->category_name = $shop_row['type_name'];
    $obj_shop->delivery = $delivery_value;
    $obj_shop->items = $get_shop_total_value['items1'];
    $obj_shop->address = $shop_row['address'];
    $obj_shop->city = $shop_row['city'];
    $obj_shop->pincode = $shop_row['pincode'];
    $obj_shop->shop_distance = rand(1,10);
    $obj_shop->units_name = $shop_row['units_name'];
    array_push($shop_array,$obj_shop);
}


$home_screen = new stdClass;
$home_screen->summary_details = $obj_data;
$home_screen->shop_details = $shop_array;


$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found ';
    $obj->title='Success';
    $obj->data = $home_screen;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
}
?>