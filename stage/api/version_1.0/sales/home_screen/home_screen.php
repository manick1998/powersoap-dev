<?php
include "../../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$home_data=array();
date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$order_date = date('Y-m-d h:i:s');
 $dayname =  date('l', strtotime($order_date));
// $amount = mysqli_query($link,"SELECT
//                             shop.name,
//                           sum( orders.billing_amount) as order_value,
//                             sum(orders.paid_amount) as total_coolection
//                         FROM
//                             shop
//                         INNER JOIN orders ON shop.token = orders.shop_token
//                         WHERE
//                             orders.employee_token = $employee_id");
                            
$amount = mysqli_query($link,"SELECT
                       SUM(shop__outstanding.bill_amount) as order_value,
                       SUM(shop__outstanding.paid_amt) as total_coolection,
                       SUM(shop__outstanding.total_outstanding) as outstanding,
                        COUNT(shop.token) as count_value
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                    INNER JOIN shop on shop.token=units__shop_mapping.shop_token
                    WHERE
                        sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND daily_schedule.schedule_date='$dayname'");
                            
                            $amt_value = mysqli_fetch_array($amount);

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

$shoptake_value = mysqli_fetch_array($shop_value);
$shoptake_value12 = mysqli_num_rows($shop_value);

$obj_data = new stdClass;
$obj_data->cover_today_value=$shoptake_value12;//intval($shoptake_value['count_value1']) ;
$obj_data->cover_today_outoff=intval($amt_value['count_value']);
$obj_data->today_order = intval($amt_value['order_value']);
$obj_data->today_cover = 0;//intval($amt_value['total_coolection']);
$obj_data->achived_productivity = intval($shoptake_value['count_value1']);
$obj_data->overall_productivity = intval($amt_value['count_value']);


$shop_query = mysqli_query($link,"SELECT
                           shop.name,
                           shop.token,
                           shop__outstanding.bill_amount,
                           shop__outstanding.paid_amt,
                           shop__outstanding.total_outstanding,
                           shop__type.name as type_name
                        FROM
                            `daily_schedule`
                        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                        INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                        INNER JOIN shop on shop.token = units__shop_mapping.shop_token
                        INNER JOIN shop__type on shop__type.token = shop.shop_type_code
                        WHERE
                            sales_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND daily_schedule.schedule_date='$dayname'");

$shop_array = array();
while($shop_row = mysqli_fetch_array($shop_query)) {
    $obj_shop = new stdClass;
    $obj_shop->shop_id = $shop_row['token'];
    $obj_shop->shop_name = $shop_row['name'];
    $obj_shop->target_amount = $shop_row['bill_amount'];
    $obj_shop->achived_amount = 0;//$shop_row['paid_amt'];
    $obj_shop->balance_amount = $shop_row['bill_amount'];
    $obj_shop->category_name = $shop_row['type_name'];
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
?>