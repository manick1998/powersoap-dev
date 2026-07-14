<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$order_id = $json_input->order_id;
$array = array();
$order_obj = new stdClass;

$order_query = mysqli_query($link,"SELECT
								    `orders`.`token`,
								    `orders`.`order_number`,
								    `shop_token`,
								    `shop`.`name`,
								    `orders`.`date_time`
								FROM
								    `orders`
								    INNER JOIN `shop`ON `shop`.`token` = `orders`.`shop_token`
								WHERE
								    `orders`.`token` = $order_id");
$order_row = mysqli_fetch_array($order_query);
$order_obj->order_number = $order_row['order_number'];
$order_obj->shop_token = $order_row['shop_token'];
$order_obj->shop_name = $order_row['name'];
$order_obj->date_time = $order_row['date_time'];

$order_items = mysqli_query($link,"SELECT
						    `product_token`,
						    `quantity`,
						    `units`,
						    `products`.`name`
						FROM
						    `orders__items`
						INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
						WHERE
						    `order_token` = '$order_id'");

while($order_item_row = mysqli_fetch_array($order_items)){
	$order_items_obj = new stdClass;
$order_items_obj->product_token = $order_item_row['product_token'];
$order_items_obj->quantity = $order_item_row['quantity'];
$order_items_obj->units = $order_item_row['units'];
$order_items_obj->product_name = $order_item_row['name'];
array_push($array, $order_items_obj);

}

$obj_final = new stdClass;
$obj_final->order_data = $order_obj;
$obj_final->order_items_data = $array;




$obj = new stdClass;
if($employee_id){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data = $obj_final;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}



echo json_encode($obj);
?>