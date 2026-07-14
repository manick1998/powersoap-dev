<?php
include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
$array = array();
if($json_data->type == 'TopDistributor'){
   $date_between="`orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND "; 
}else{
   $date_between='';
}
$ditributor = mysqli_query($link,"SELECT
					    SUM(`billing_amount`) as amount,
					    distrubutor_value.name
					FROM
					    `orders`
					    INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token` = `orders`.`employee_token`
					    INNER JOIN `employees` AS `distrubutor_value` ON `distrubutor_value`.`token` = `sales_man`.`admin_distributor_token`
					WHERE
					    $date_between `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'  GROUP BY `distrubutor_value`.`token`
					ORDER BY `amount` DESC LIMIT 10");

while($distributor_row = mysqli_fetch_array($ditributor)){
	$obj = new stdClass;
	$obj->distributor_name = $distributor_row['name'];
	$obj->distributor_amt = round($distributor_row['amount']);
	$obj->distributor_unitName = ($distributor_row['unitName']);
 array_push($array,$obj);
}
$obj_final = new stdClass;

$obj_final->status_code=200; 
    $obj_final->message='distributor found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);
?>