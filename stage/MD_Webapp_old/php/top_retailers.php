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
						    shop.name,
						    orders.`shop_token`,
						    SUM(`billing_amount`) as billing_amount,
						    units.name as unit_name
						FROM
						    `orders`
						INNER JOIN shop ON shop.token = orders.shop_token
						INNER JOIN units__shop_mapping ON units__shop_mapping.shop_token = shop.token
						INNER JOIN units ON units.token = units__shop_mapping.unit_group_token
						WHERE
    					$date_between `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'
						GROUP BY
						    `shop_token`
						    ORDER BY `billing_amount` DESC
						LIMIT 10");

while($shop_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->shop_name = $shop_row['name'];
	 $obj->beat_name = $shop_row['unit_name'];
	 $obj->bill_amount = round($shop_row['billing_amount']);
	 array_push($array,$obj);
}

$obj_final = new stdClass;

    $obj_final->status_code=200; 
    $obj_final->message='shop found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);



?>