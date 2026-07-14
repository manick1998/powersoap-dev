<?php

include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$array = array();

$sql1 = mysqli_query($link,"SELECT
			    `employees`.`token` as emp_token,
			    `employees`.`employees_code`,
			    `employees`.`name`,
			    `employees`.`mobile_number`,
			    `employees`.`email_id`,
			    `employees`.`join_date`,
			     COALESCE(`orders`.`billing_amount`,0) as billAmount,
			    `orders`.`delivery` as status,
			    COALESCE(`orders`.`items`,0) AS items,
			    `orders`.`order_number`,
			    `orders`.`date_time`,
			    `orders`.`token`
			FROM
			    `employees`
			    INNER JOIN `orders` ON `orders`.`employee_token` = `employees`.`token`
			WHERE
			    `delete_status` = '1' AND `employees`.`deparment_token` = '18028120' AND `employees`.`token`=$employee_id and orders.order_type='Distributor Order' ORDER BY orders.id DESC");

			while($distributor_data = mysqli_fetch_array($sql1)){
				$obj = new stdClass;

			    $obj->emp_token = $distributor_data['emp_token'];
			    $obj->billAmount = $distributor_data['billAmount'];
			    $obj->status = $distributor_data['status'];
			    $obj->order_number = $distributor_data['order_number'];
			    $obj->order_token = $distributor_data['token'];
			    $obj->order_date = $distributor_data['date_time'];
			    $obj->items = $distributor_data['items'];
			    array_push($array,$obj);

			}

			$obj_new = new stdClass;
if($employee_id != ''){
    $obj_new->status_code=200; 
    $obj_new->message='Product found';
    $obj_new->title='Success';
    $obj_new->data = $array;
    
} else {
    $obj_new->status_code=400; 
    $obj_new->message='Product not found';
    $obj_new->title='Success';
    
}


			echo json_encode($obj_new);


?>