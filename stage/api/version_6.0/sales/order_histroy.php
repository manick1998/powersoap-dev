<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

$array = array();

//distributor_token
$stmt = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` WHERE token='$employee_id'");
$gettoken = mysqli_fetch_array($stmt);
$distributor_token = $gettoken['admin_distributor_token'];

$outstanding_amount = mysqli_query($link,"SELECT
                    SUM(orders.billing_amount - orders.paid_amount) AS outstanding_amt,
                    SUM(orders.bill_discount_amount) as bill_discount_amount,
                    SUM(orders.bill_discount_percentage) as bill_discount_percentage,
                    SUM(CASE WHEN orders.bill_discount_percentage !=0 THEN((orders.`billing_amount`*orders.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
                FROM
                    orders
                    INNER JOIN shop_mapping ON shop_mapping.token = orders.shop_token 
                WHERE
                    shop_mapping.shop_token = '$shop_id' and shop_mapping.distributor_token = '$distributor_token' and orders.delivery != 'Cancelled'");
$get_outstanding_amt = mysqli_fetch_array($outstanding_amount);
$amount_val = new stdClass;
      $bill_discount_amount = $get_outstanding_amt['bill_discount_amount'];
      $bill_discount_percentage = $get_outstanding_amt['bill_discount_percentage'];
      $percentage_value = $get_outstanding_amt['percentage_value'];

     if($bill_discount_amount > 0) {
                    $discount_amount_finall1 = round($bill_discount_amount);
                 } 
                
                  else {
                    $discount_amount_finall1 = 0;
                 }
$discount_amount_finall = $discount_amount_finall1+$percentage_value;

    $amount_val->outstanding_amount_value = round($get_outstanding_amt['outstanding_amt']-$discount_amount_finall);


$order_hisyory = mysqli_query($link,"SELECT
orders.date_time as schedule_date,
orders.token,
orders.items,
orders.shop_token,
orders.billing_amount,
orders.paid_amount,
shop.name AS shop_name,
(orders.billing_amount - orders.paid_amount) AS outstanding_amt,
orders.delivery,
orders.employee_token,
orders.bill_discount_amount,
orders.bill_discount_percentage,
(CASE WHEN orders.bill_discount_percentage !=0 THEN((orders.`billing_amount`*orders.`bill_discount_percentage`)/100) ELSE 0 END) as percentage_value
FROM
orders
INNER JOIN shop_mapping ON shop_mapping.token = orders.shop_token 
INNER JOIN shop ON shop_mapping.shop_token = shop.token 
WHERE
shop_mapping.shop_token = '$shop_id' and shop_mapping.distributor_token = '$distributor_token' ORDER BY orders.id DESC");

while($order_row = mysqli_fetch_array($order_hisyory)) {
    $obj_order = new stdClass;
        $schedule_date12= $order_row['schedule_date'];
        $convert_date= date('j,M Y', strtotime($schedule_date12));

        $bill_discount_amount = $order_row['bill_discount_amount'];
        $bill_discount_percentage = $order_row['percentage_value'];


         if($bill_discount_amount > 0) {
                        $discount_amount_finall1 = round($bill_discount_amount);
                     } 
                      
                     else {
                        $discount_amount_finall1 = 0;
                     }

        $discount_amount_finall = $discount_amount_finall1+$bill_discount_percentage;


        $obj_order->schedule_date= $convert_date;
        $obj_order->order_token= $order_row['token'];
        $obj_order->shop_token= $order_row['shop_token'];
        $obj_order->shop_name= $order_row['shop_name'];
        $obj_order->status= $order_row['delivery'];
        $obj_order->billing_amount= round($order_row['billing_amount'] - $discount_amount_finall);
        $obj_order->paid_amount= round($order_row['paid_amount']);
        if($order_row['delivery'] == 'Cancelled'){
        $obj_order->outstanding_amt= 0;//round($order_row['outstanding_amt'] - $discount_amount_finall);
    }else{
        $obj_order->outstanding_amt= round($order_row['outstanding_amt'] - $discount_amount_finall);
    }
        $obj_order->items= $order_row['items'];
        array_push($array,$obj_order);
}


$obj_data = new stdClass;
$obj_data->outstanding_value = $amount_val;
$obj_data->order_hisyory_data = $array;




$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $obj_data;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Failed';
    
}
echo json_encode($obj);
?>