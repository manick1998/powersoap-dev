<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

$obj_items = new stdClass;
$obj= new stdClass;




// $monthly  = mysqli_query($link,"SELECT
// 					    SUM(`items`) as items
// 					FROM
// 					    orders
// 					WHERE
// 					    MONTH(`date_time`) = MONTH(CURRENT_DATE()) AND `shop_token` = '$shop_id'");
$monthly  = mysqli_query($link,"SELECT
					    SUM( CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) AS completed_items1
					FROM
					    orders
					INNER JOIN orders__items ON orders__items.order_token = orders.token
					INNER JOIN products ON products.token = orders__items.product_token
					WHERE
					    orders.delivery = 'Completed' AND orders.shop_token = '$shop_id' AND MONTH(orders.`date_time`) = MONTH(CURRENT_DATE())");
$monthly_row = mysqli_fetch_array($monthly);
 $obj_items->monthly_items = $monthly_row['completed_items1'];

$full_count  = mysqli_query($link,"SELECT
					    SUM( CASE WHEN orders__items.units = 'Box' THEN(orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) AS completed_items
					FROM
					    orders
					INNER JOIN orders__items ON orders__items.order_token = orders.token
					INNER JOIN products ON products.token = orders__items.product_token
					WHERE
					    orders.delivery = 'Completed' AND orders.shop_token = '$shop_id'");
$full_count_row = mysqli_fetch_array($full_count);
 $obj_items->full_count_items = $full_count_row['completed_items'];


if($shop_id){
    $obj->status_code=200; 
    $obj->message='shop found';
    $obj->title='Success';
    $obj->data=$obj_items;
    
} else {
    $obj->status_code=400; 
    $obj->message='shop not found';
    $obj->title='Success';
    
}
echo json_encode($obj);

?>