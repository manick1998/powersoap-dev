<?php

include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$order_date = date('Y-m-d h:i:s');
 $dayname =  date('l', strtotime($order_date));
$home_data=array();
$dateonly = $indiaDate;

$amount = mysqli_query($link,"SELECT
    SUM(CASE WHEN orders.delivery='Pending' THEN 1 ELSE 0 END) as pending_count,
    SUM(CASE WHEN orders.delivery='Completed' THEN 1 ELSE 0 END) as Completed_count,
    SUM(CASE WHEN orders.delivery = 'Pending' THEN orders.items ELSE 0 END) AS pending_items,
    SUM(CASE WHEN orders.delivery = 'Completed' THEN orders.items ELSE 0 END) as completed_items
    
FROM
    `daily_schedule`
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
WHERE
    daily_schedule.delivery_emp_token = $employee_id AND orders.order_type='Sales Order' AND daily_schedule.schedule_date='$dayname'");
                            
 $amt_value = mysqli_fetch_array($amount);

$overallCount  = mysqli_query($link,"SELECT
                        COUNT(shop.token) as count_value
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                    INNER JOIN shop on shop.token=units__shop_mapping.shop_token
                    WHERE
                        delivery_emp_token = $employee_id AND units__shop_mapping.delete_status =1 AND daily_schedule.schedule_date='$dayname'");
                            
                            $overallCount_row = mysqli_fetch_array($overallCount);

             $shop_value1 = mysqli_query($link,"SELECT * FROM `sales__log` WHERE `date_time` LIKE '%$dateonly%' AND `sales_token` = $employee_id");
             $shoptake_value12 = mysqli_num_rows($shop_value1);

$pending_items = mysqli_query($link,"SELECT
                       SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS pending_items
                        
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders__items.order_token = orders.token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                        daily_schedule.delivery_emp_token = $employee_id AND orders.order_type='Sales Order' AND daily_schedule.schedule_date='$dayname' AND orders.delivery='Pending'");

$pending_items_row = mysqli_fetch_array($pending_items);
$get_pending_items = $pending_items_row['pending_items'];

$completed_items = mysqli_query($link,"SELECT
                       SUM(CASE WHEN orders__items.units = 'Box' THEN (orders__items.quantity*products.piece_count )ELSE orders__items.quantity END) AS completed_items
                        
                    FROM
                        `daily_schedule`
                    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                    INNER JOIN orders ON orders.shop_token = units__shop_mapping.shop_token
                    INNER JOIN orders__items ON orders__items.order_token = orders.token
                    INNER JOIN products ON products.token = orders__items.product_token
                    WHERE
                        daily_schedule.delivery_emp_token = $employee_id AND orders.order_type='Sales Order' AND daily_schedule.schedule_date='$dayname' AND orders.delivery='Completed'");

$completed_items_row = mysqli_fetch_array($completed_items);
$get_completed_items = $completed_items_row['completed_items'];



$obj_data = new stdClass;
$obj_data->cover_today_value= intval($shoptake_value12);// intval($amt_value['Completed_count']);
$obj_data->cover_today_outoff= intval($overallCount_row['count_value']);//intval($amt_value['pending_count']+$amt_value['Completed_count']);


$obj_data->today_items_value = intval($get_completed_items);//intval($amt_value['completed_items']);
$obj_data->today_outoff_items =  intval( $get_completed_items+$get_pending_items );//intval($amt_value['pending_items'] + $amt_value['completed_items']);
$obj_data->today_collection = 0;//intval($amt_value['total_amt']);
$obj_data->achived_productivity = intval($shoptake_value12);//3;
$obj_data->overall_productivity = intval($overallCount_row['count_value']);//5;

if($shoptake_value12 > 0){
$obj_data->overall = round(($shoptake_value12/$overallCount_row['count_value'])*5);
}else{
$obj_data->overall = 0;//round(($shoptake_value12/$amt_value['count_value'])*5);
}
$shop_array = array();


// shopDetails
$shop_list = mysqli_query($link,"SELECT
                                orders.id,
                                shop.name,
                                shop.token,
                               COALESCE( SUM(orders.items) ,0) AS items,
                                 COALESCE(SUM(orders.billing_amount),0) AS bill_amt,
                                shop__type.name AS shop_type,
                                COALESCE(GROUP_CONCAT(DISTINCT orders.delivery ORDER by orders.delivery),'NoOrder') as delivery
                                -- COALESCE(orders.delivery,'NoOrder') as delivery
                            FROM
                                `daily_schedule`
                            INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                            LEFT JOIN orders ON orders.shop_token = units__shop_mapping.shop_token  AND orders.date_time LIKE '$dateonly%'
                            INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
                            INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
                            WHERE
                                daily_schedule.delivery_emp_token = $employee_id AND daily_schedule.schedule_date='$dayname' AND units__shop_mapping.delete_status =1
                                GROUP BY shop.token
                                ORDER BY orders.id DESC");
                            
while($row_shop = mysqli_fetch_array($shop_list)) {
    
     $shop_obj = new stdClass;
     $shop_obj->shop_name = $row_shop['name'];
     $shop_obj->shop_items = $row_shop['items'];
     $shop_obj->shop_total = number_format($row_shop['bill_amt'],2);
     $shop_obj->shop_type = $row_shop['shop_type'];
     $shop_obj->shop_token = $row_shop['token'];
     $shop_obj->shop_distance = '4km';
     // $shop_obj->shop_status = $row_shop['delivery'];
     $shop_obj->shop_status = explode(',', $row_shop['delivery'])[0];
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