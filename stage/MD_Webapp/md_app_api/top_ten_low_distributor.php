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
`distributor`.`name` AS `distributor_name`,
SUM(`orders`.`billing_amount`) AS `distributor_sales`,
`distributor`.`token` AS `distributor_token`
FROM
`orders`
INNER JOIN `employees` AS `sales_man`
ON
`sales_man`.`token` = `orders`.`employee_token`
INNER JOIN `employees` AS `distributor`
ON
`distributor`.`token` = `sales_man`.`admin_distributor_token`
WHERE
$date_between `orders`.`order_type` IN(
    'Sales Order',
    'Spot Order',
    'Retailer order'
) AND `orders`.`delivery` != 'Cancelled'
GROUP BY
`distributor`.`token`
ORDER BY
`distributor_sales`
ASC
LIMIT 10");

while($distributor_row = mysqli_fetch_array($shop_list)){
	$obj = new stdClass;
	 $obj->distributor_name = $distributor_row['distributor_name'];
	 $obj->distributor_token = $distributor_row['distributor_token'];
	 $obj->bill_amount = round($distributor_row['distributor_sales']);
	 array_push($array,$obj);
}

$obj_final = new stdClass;

    $obj_final->status_code=200; 
    $obj_final->message='Distributor found';
    $obj_final->title='Success';
    $obj_final->data = $array;

echo json_encode($obj_final);



?>