<?php
include "../../config.php";
$json_input = getInputs();
$date_filter = $json_input->date_filter;
 // $date_filter;

$array = array();

$detail = new stdClass;
// order_taken
$order_item = mysqli_query($link,"SELECT COUNT(`id`) as order_taken FROM `orders` WHERE `order_type` in ('Sales Order','Spot Order') AND `delivery` != 'Cancelled'");
$get_order_taken = mysqli_fetch_array($order_item);
 $detail->order_taken_value = $get_order_taken['order_taken'];

 // distributor_data
 $distributor_data = mysqli_query($link,"SELECT 1 FROM `employees` WHERE `deparment_token`=18028120 AND `block_status`=1");
  $detail->get_distributor = mysqli_num_rows($distributor_data);

  // sales and delivery
  $salesDelivery = mysqli_query($link,"SELECT 1 FROM `employees` WHERE `deparment_token`in (45916684)");
   $detail->get_salesDelivery = mysqli_num_rows($salesDelivery);

   // shop data
   $shop = mysqli_query($link,"SELECT COUNT(`id`) as shop_value FROM `shop` WHERE `delete_status`=1");
   $get_shop = mysqli_fetch_array($shop);
    $detail->shop_count_value = $get_shop['shop_value'];


if($date_filter == ' ') {
$product_details = mysqli_query($link,"SELECT
   products__category.name as catname,
    (SUM( CASE WHEN orders__items.units = 'Box' THEN( orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) * orders__items.price_per_unit) AS product_amt,
    (SUM( CASE WHEN orders__items.units = 'Box' THEN( orders__items.quantity * products.piece_count) ELSE orders__items.quantity END)) AS product_qty,
    products__category.token
    
FROM
    `orders`
INNER JOIN orders__items ON orders__items.order_token = orders.token
INNER JOIN products ON products.token = orders__items.product_token
INNER JOIN products__category ON products__category.token = products.category_token
WHERE
    `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'
GROUP BY
    products__category.token");
} else {
    $product_details = mysqli_query($link,"SELECT
   products__category.name as catname,
    (SUM( CASE WHEN orders__items.units = 'Box' THEN( orders__items.quantity * products.piece_count) ELSE orders__items.quantity END) * orders__items.price_per_unit) AS product_amt,
    (SUM( CASE WHEN orders__items.units = 'Box' THEN( orders__items.quantity * products.piece_count) ELSE orders__items.quantity END)) AS product_qty,
    products__category.token
    
FROM
    `orders`
INNER JOIN orders__items ON orders__items.order_token = orders.token
INNER JOIN products ON products.token = orders__items.product_token
INNER JOIN products__category ON products__category.token = products.category_token
WHERE
    `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` like '$date_filter%'
GROUP BY
    products__category.token");
}
// product_list


while($product_row = mysqli_fetch_array($product_details)){

	 $obj = new stdClass;
	 $obj->category_name = utf8_encode($product_row['catname']);
	 $obj->product_amount = round($product_row['product_amt']);
	 $obj->product_qty = intval(($product_row['product_qty']));
	  
	 array_push($array, $obj);

}


   
$homescreen = new stdClass;
$homescreen->dashboard_details = $detail;
$homescreen->product_details_value = $array;

$obj1 = new stdClass;
    $obj1->status_code=200; 
    $obj1->message='Product found';
    $obj1->title='Success';
    $obj1->data=$homescreen;





echo json_encode($homescreen);

?>