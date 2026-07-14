<?php

include "../config.php";
$json_data = getInputs();
$from_date = date("Y-m-d 00:00:00", strtotime($json_data->from_date));
$to_date = date("Y-m-d 23:59:59", strtotime($json_data->to_date));
$array = array();
if($json_data->type == 'TopRetailer'){ 
    $state_id = $json_data->state_id;
    $date_between="AND `employees`.`state_id` = '$state_id'";
}else{
    $date_between=='';
}

$shop_list = mysqli_query($link,"SELECT
orders.employee_token AS distributor_token,
employees.name AS distributor_name,
SUM(`orders`.`billing_amount`) AS `distributor_sales`
FROM
`orders`
INNER JOIN employees ON employees.token = orders.employee_token
WHERE
orders.order_type = 'Distributor Order' AND `orders`.`delivery` != 'Cancelled' $date_between
GROUP BY
orders.employee_token
ORDER BY
distributor_sales
ASC
LIMIT 10");

while($distributor_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->distributor_name = $distributor_row['distributor_name'];
	 $obj->distributor_token = $distributor_row['distributor_token'];
	 $obj->bill_amount = round($distributor_row['distributor_sales']);
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