<?php

include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
$array = array();
$year    = date("Y");
if($json_data->type == 'TopRetailer'){ 
    $state_id = $json_data->state_id;
    $region_id = $json_data->region_id;
	$year_month =$json_data->year_and_month;
    $date_between="AND `employees`.`state_id` = '$state_id' AND employees.region_id = '$region_id' AND `orders`.`date_time` LIKE '$year_month%'";
}else{
	$date_between = "AND YEAR(`orders`.`date_time`)='$year'";
}


$shop_list = mysqli_query($link,"SELECT
products.token,
products.name,
SUM(orders__items.quantity) AS productSellingCost
FROM
`orders`
INNER JOIN orders__items ON orders__items.order_token = orders.token
INNER JOIN products ON products.token = orders__items.product_token
INNER JOIN employees ON employees.token = orders.employee_token
INNER JOIN employees__state ON employees__state.state_token = employees.state_id
WHERE
`orders`.`order_type` = 'Distributor Order' AND `orders`.`delivery` = 'Completed' AND `orders__items`.`delete_status` = '1' $date_between
GROUP BY
products.token
ORDER BY
`productSellingCost`
ASC LIMIT 10
");

while($products_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->products_name = $products_row['name'];
	 $obj->products_token = $products_row['token'];
	 $obj->top_productSellingCost = round($products_row['productSellingCost']);
	 array_push($array,$obj);
}
//==================== States
$state_list = mysqli_query($link,"SELECT * FROM `employees__state`");
$state_array = [];
while($state_row = mysqli_fetch_array($state_list)){
	$state_obj = new stdClass;
	 $state_obj->state_name = $state_row['state_name'];
	 $state_obj->state_token = $state_row['state_token'];
	 array_push($state_array,$state_obj);
}
//==================== Region
if ($json_data->type == 'Topregion') {
    $state_id = $json_data->state_id;
    $region_list = mysqli_query($link,"SELECT
region.token AS region_token,
region.region_name
FROM
`region`
WHERE
state_id = '$state_id'");
$region_array = [];
while($region_row = mysqli_fetch_array($region_list)){
	$region_obj = new stdClass;
	 $region_obj->region_name = $region_row['region_name'];
	 $region_obj->region_token = $region_row['region_token'];
	 array_push($region_array,$region_obj);
}
}


$obj_final = new stdClass;

    $obj_final->status_code=200; 
    $obj_final->message='Products found';
    $obj_final->title='Success';
    $obj_final->data = $array;
    $obj_final->state_data = $state_array;
    $obj_final->region_data = $region_array;

echo json_encode($obj_final);



?>