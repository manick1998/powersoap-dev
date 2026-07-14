<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$home_data=array();

// $delivery1 = mysqli_query($link,"SELECT `sales_emp_token` FROM `daily_schedule` WHERE `delivery_emp_token` = $employee_id");
// $delivery_row = mysqli_fetch_array($delivery1);
//   $sales_empId = $delivery_row['sales_emp_token'];
date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d h:i:s');
$dayname =  date('l', strtotime($order_date));

$amount = mysqli_query($link,"SELECT
                                SUM(orders.items) as order_items,
                                SUM(orders.paid_amount) as total_coolection
                            FROM
                                `daily_schedule`
                            INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                            INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                            WHERE
                                daily_schedule.delivery_emp_token = $employee_id AND daily_schedule.schedule_date='$dayname'");
                            
 $amt_value = mysqli_fetch_array($amount);

$obj_data = new stdClass;
$obj_data->cover_today_value=0;//18;
$obj_data->cover_today_outoff=0;//45;
$obj_data->today_items_value = 0;//intval($amt_value['order_items']);
$obj_data->today_outoff_items=0;
$obj_data->today_collection = 0;//intval($amt_value['total_coolection']);
$obj_data->achived_productivity = 0;//3;
$obj_data->overall_productivity = 0;//5;

$home_screen = new stdClass;
$home_screen->summary_details = $obj_data;
// $home_screen->shop_details = $shop_array;


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
?>