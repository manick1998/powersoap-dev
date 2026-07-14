<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
// $YearMonth = $json_data->year_and_month;
// echo '$YearMonth',$YearMonth;
$array = array();

if($json_data->type == 'TopRetailer'){ 
	$state_id = $json_data->state_id;
	$YearMonth = $json_data->year_and_month;
    $date_between="AND `employees`.`state_id` = '$state_id' AND `orders`.`date_time` LIKE '$YearMonth%'";
}else{
    $date_between ='';
}
//echo  $date_between;

$shop_list = mysqli_query($link,"SELECT
SUM(orders.billing_amount) AS distributor_sales,
MONTHNAME(`orders`.`date_time`) AS `monthNumber`,
`region`.`region_name`
FROM
orders
INNER JOIN employees ON employees.token = orders.employee_token
LEFT JOIN region ON region.token = employees.region_id
WHERE
orders.`delivery` = 'Completed' AND orders.`order_type` = 'Distributor Order' $date_between 
GROUP BY
region.region_name
ORDER BY
region.region_name
DESC
LIMIT 10");

//echo count($shop_list);

while($region_row = mysqli_fetch_array($shop_list)){
	// $monthName = date('F', mktime(0, 0, 0, $region_row['monthNumber'], 1));
	// echo '$monthName',$monthName;
	$obj = new stdClass;
	 $obj->region_name = $region_row['region_name'];
	 $obj->monthName = $region_row['monthNumber'];
	 //$obj->bill_amount = $region_row['distributor_sales'];
	 $obj->bill_amount = round($region_row['distributor_sales']);
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
    $obj_final->message='Distributor found';
    $obj_final->title='Success';
    $obj_final->data = $array;
    $obj_final->state_data = $state_array;

echo json_encode($obj_final);



?>