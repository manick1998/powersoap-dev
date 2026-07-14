<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;
$dateonly = $indiaDate;
//  $box_value;
$dayname =  date('l', strtotime($date));
$summary_product = mysqli_query($link,"SELECT
                             SUM(CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) as quantity,
                            -- SUM((orders__items.quantity *( orders__items.price_per_unit ) )) AS sales_amt,
                             orders__items.price_per_unit  AS sales_amt,
                            products.name,
                            orders__items.units
                        FROM
                            `daily_schedule`
                        INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
                        INNER JOIN shop__outstanding ON shop__outstanding.shop_token = units__shop_mapping.shop_token
                        INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
                        INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
                        INNER JOIN orders ON orders.shop_token = shop.token
                        INNER JOIN orders__items ON orders.token = orders__items.order_token
                        INNER JOIN products ON products.token = orders__items.product_token
                        WHERE
                            orders.employee_token = $employee_id  AND orders.`date_time` LIKE '%$dateonly%' AND orders__items.delete_status = 1 AND units__shop_mapping.delete_status = 1 AND orders.delivery='Pending' AND daily_schedule.schedule_date = '$dayname' GROUP BY products.token");
                // AND orders.shop_token = $shop_id
$product_array = array();
while($product = mysqli_fetch_array($summary_product)) {
    $obj = new stdClass;
     $obj->product_name = $product['name'] ;
     $obj->sales_amt = round($product['sales_amt']*$product['quantity']);
     $obj->box_value = intval($product['nos_box_type']);
     $obj->quantity_value = $product['quantity'];
    $obj->quantity_units = 'Nos';//$product['units'];
    
    array_push($product_array,$obj);
    
}
 

$count_query = mysqli_query($link,"SELECT
    SUM(CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) AS count_product
FROM
    `daily_schedule`
INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
INNER JOIN shop ON shop.token = units__shop_mapping.shop_token
INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
INNER JOIN orders ON orders.shop_token = shop.token
INNER JOIN orders__items ON orders.token = orders__items.order_token
INNER JOIN products ON products.token = orders__items.product_token
WHERE
    orders.employee_token = $employee_id AND orders.`date_time` LIKE '%$dateonly%' AND units__shop_mapping.delete_status = 1 AND orders.delivery = 'Pending' AND daily_schedule.schedule_date = '$dayname'");
$count_query = mysqli_fetch_array($count_query);
 $obj_count = new stdClass;
 $obj_count->product_count = $count_query['count_product'];

 $home_screen = new stdClass;
        $home_screen->product_count = $obj_count;
        $home_screen->product_details = $product_array;

 
 
    $obj_final = new stdClass;
if($employee_id != '') {
    $obj_final->status_code=200; 
    $obj_final->message='stock data found';
    $obj_final->title='Success';
    $obj_final->data = $home_screen;
    
} else {
    $obj_final->status_code=400; 
    $obj_final->message='stock data not found';
    $obj_final->title='Success';
    
}
echo json_encode($obj_final);
?>