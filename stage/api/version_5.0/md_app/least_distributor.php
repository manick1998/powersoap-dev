<?php
// ini_set('display_errors', 1);// show error reporting
//  error_reporting(E_ALL);
include "../../config.php";
$json_data = getInputs();
$array = array();
$ditributor = mysqli_query($link,"SELECT
					    SUM(`billing_amount`) as amount,
					    distrubutor_value.name,
					    units.name as unitName
					FROM
					    `orders`
					    INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token` = `orders`.`employee_token`
					    INNER JOIN `employees` AS `distrubutor_value` ON `distrubutor_value`.`token` = `sales_man`.`admin_distributor_token`
					    INNER JOIN `units` ON `units`.`distributor_token` = `distrubutor_value`.`token`
					WHERE
					    `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'  GROUP BY `distrubutor_value`.`token`
					ORDER BY `amount` asc LIMIT 10");
while($distributor_row = mysqli_fetch_array($ditributor)){
	$obj = new stdClass;
	$obj->distributor_name = $distributor_row['name'];
	$obj->distributor_amt = round($distributor_row['amount']);
	$obj->distributor_unitName = $distributor_row['unitName'];
 array_push($array,$obj);
}
$obj_final = new stdClass;

$obj_final->status_code=200; 
    $obj_final->message='distributor found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);
?>