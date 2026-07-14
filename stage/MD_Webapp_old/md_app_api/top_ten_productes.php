<?php

include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
$array = array();
if($json_data->type == 'TopRetailer'){ 
    $date_between="`orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND ";
}else{
    $date_between=='';
}

$shop_list = mysqli_query($link,"SELECT
`products`.`token`,
`products`.`name`,
SUM(
    CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count` WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity` ELSE 0
END * `price_per_unit`
) AS `productSellingCost`
FROM
`orders__items`
INNER JOIN `orders` ON `orders__items`.`order_token` = `orders`.`token`
INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
WHERE $date_between
`orders`.`order_type` IN(
    'Sales Order',
    'Spot Order',
    'Retailer order'
) AND `orders`.`delivery` != 'Cancelled'
GROUP BY
`orders__items`.`product_token`
ORDER BY
`productSellingCost`
DESC
LIMIT 10");

while($products_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->products_name = $products_row['name'];
	 $obj->products_token = $products_row['token'];
	// $obj->bill_amount = round($shop_row['billing_amt']);
	 array_push($array,$obj);
}

$obj_final = new stdClass;

    $obj_final->status_code=200; 
    $obj_final->message='Products found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);



?>