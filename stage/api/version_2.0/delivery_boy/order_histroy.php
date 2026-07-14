<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

$array = array();
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
                                        orders.employee_token
                                    FROM
                                       orders
                                    INNER JOIN shop ON shop.token=orders.shop_token
                                    WHERE
                                     shop.token = $shop_id");

while($order_row = mysqli_fetch_array($order_hisyory)) {
    $obj_order = new stdClass;
        $schedule_date12= $order_row['schedule_date'];
        $convert_date= date('j,M Y', strtotime($schedule_date12));
        $obj_order->schedule_date= $convert_date;
        $obj_order->order_token= $order_row['token'];
        $obj_order->shop_token= $order_row['shop_token'];
        $obj_order->shop_name= $order_row['shop_name'];
        $obj_order->billing_amount= $order_row['billing_amount'];
        $obj_order->paid_amount= $order_row['paid_amount'];
        $obj_order->outstanding_amt= $order_row['outstanding_amt'];
        $obj_order->items= $order_row['items'];
        array_push($array,$obj_order);
}
$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $array;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Failed';
    
}
echo json_encode($obj);
?>