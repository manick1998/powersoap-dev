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
    $date_between="`orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND ";
}else{
    $date_between=='';
}

$shop_list = mysqli_query($link,"SELECT
    `shop`.`token`,
    `shop`.`name`,
    SUM(`orders`.`billing_amount`) AS `billing_amt`
FROM
    `orders`
INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
WHERE $date_between
    `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'
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

$obj_final = new stdClass;

    $obj_final->status_code=200; 
    $obj_final->message='shop found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);



?>