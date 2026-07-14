<?php
// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
include "../../config.php";
$json_data = getInputs();
$array = array();
$product = mysqli_query($link,"SELECT
			    products.name,
			    (sum(CASE WHEN orders__items.units = 'Box' THEN( orders__items.quantity * products.piece_count ) ELSE orders__items.quantity END)* orders__items.price_per_unit) AS product_amt
			FROM
			    `orders`
			INNER JOIN orders__items ON orders__items.order_token = orders.token
			INNER JOIN products ON products.token = orders__items.product_token
			WHERE
    		`orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'
			GROUP BY products.token  
			ORDER BY `product_amt` Asc
			LIMIT 10");
while($product_row = mysqli_fetch_array($product)){
	$obj = new stdClass;
	$obj->product_name = $product_row['name'];
	$obj->product_amt = round($product_row['product_amt']);
 array_push($array,$obj);
}
$obj_final = new stdClass;

$obj_final->status_code=200; 
    $obj_final->message='shop found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);
?>