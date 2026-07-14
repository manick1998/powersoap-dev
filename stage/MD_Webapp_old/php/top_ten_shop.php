<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
$array = array();

if($json_data->type == 'TopRetailer'){ 
    $state_id = $json_data->state_id;
    $date_between="AND employees__state.state_token ='$state_id'";
}else{
    $date_between=='';
}

$shop_list = mysqli_query($link,"SELECT
	
orders.order_type,
`shop`.`token`,
`shop`.`name`,
SUM(`orders`.`billing_amount`) AS `billing_amt`
FROM
`orders`
INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
INNER JOIN employees__state ON employees__state.state_token = shop.state_id
WHERE 
`orders`.`order_type` IN('Sales Order','Spot Order','Retailer order') AND `orders`.`delivery` = 'Completed'  $date_between
GROUP BY
`orders`.`shop_token`
ORDER BY
`billing_amt`
DESC
LIMIT 10");

while($shop_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->shop_name = $shop_row['name'];
	//  $obj->beat_name = $shop_row['unit_name'];
	 $obj->bill_amount = round($shop_row['billing_amt']);
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

$obj_final = new stdClass;
    $obj_final->status_code=200; 
    $obj_final->message='shop found';
    $obj_final->title='Success';
    $obj_final->data = $array;
    $obj_final->state_data = $state_array;

echo json_encode($obj_final);



?>