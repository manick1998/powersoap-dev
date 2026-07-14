<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$home_data=array();



$amount = mysqli_query($link,"SELECT
    SUM(orders.items) AS order_items,
    SUM(orders.paid_amount) AS total_coolection,
    SUM(orders.billing_amount) AS total_amt,
    SUM(CASE WHEN orders.delivery='Pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN orders.delivery='Completed' THEN 1 ELSE 0 END) as Completed_count,
    SUM(CASE WHEN orders.delivery = 'Pending' THEN orders.items ELSE 0 END) AS pending_items,
    SUM(CASE WHEN orders.delivery = 'Completed' THEN orders.items ELSE 0 END) as completed_items
    
FROM
    `daily_schedule`
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
WHERE
    daily_schedule.delivery_emp_token = $employee_id AND orders.order_type='Sales Order'");
                            
 $amt_value = mysqli_fetch_array($amount);



$obj_data = new stdClass;
$obj_data->cover_today_value=intval($amt_value['Completed_count']);
$obj_data->cover_today_outoff=intval($amt_value['pending_count']+$amt_value['Completed_count']);
$obj_data->today_items_value = intval($amt_value['completed_items']);
$obj_data->today_outoff_items = intval($amt_value['pending_items'] + $amt_value['completed_items']);
$obj_data->today_collection = intval($amt_value['total_amt']);
$obj_data->achived_productivity = 3;
$obj_data->overall_productivity = 5;
$shop_array = array();
$shop_list = mysqli_query($link,"SELECT
                            shop.name,
                            shop.token,
                            SUM(orders.items) as items,
                            SUM(orders.billing_amount) as bill_amt ,
                            shop__type.name as shop_type,
                            orders.delivery
                        FROM
                            `daily_schedule`
                        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                        INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                        INNER JOIN shop ON shop.token=orders.shop_token
                        INNER JOIN shop__type on  shop__type.token= shop.shop_type_code
                        WHERE
                            daily_schedule.delivery_emp_token = $employee_id GROUP BY orders.shop_token");
                            
while($row_shop = mysqli_fetch_array($shop_list)) {
    
    $shop_obj = new stdClass;
     $shop_obj->shop_name = $row_shop['name'];
    $shop_obj->shop_items = $row_shop['items'];
    $shop_obj->shop_total = number_format($row_shop['bill_amt'],2);
    $shop_obj->shop_type = $row_shop['shop_type'];
     $shop_obj->shop_token = $row_shop['token'];
    $shop_obj->shop_distance = '4km';
    $shop_obj->shop_status = $row_shop['delivery'];
    array_push($shop_array,$shop_obj);
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
?>