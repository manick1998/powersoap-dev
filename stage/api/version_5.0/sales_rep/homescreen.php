<?php

include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDate;
$sales_rep_employee_token = $json_input->sales_rep_employee_token;

$distributor_array= array();
$retailer_array= array();

$sql = mysqli_query($link,"SELECT GROUP_CONCAT(DISTINCT CONCAT('\'', distributor_token, '\'')) as distributor FROM schedule_sales_rep WHERE sales_rep_token = '$sales_rep_employee_token' AND schedule_sales_rep.schedule_date = '$currentDate' and schedule_sales_rep.status='1' GROUP BY sales_rep_token");
$query = mysqli_fetch_array($sql);
$distributor_token = $query['distributor'];

$sql1 = mysqli_query($link,"SELECT
`employees`.`token`,
`employees`.`name`,
`employees`.`address`,
`employees`.`pincode`,
`employees`.`street`,
`employees`.`city`,
`employees`.`mobile_number`,
COUNT(DISTINCT `orders`.`shop_token`) AS `shop_count`,
COUNT(DISTINCT `orders`.`id`) AS `order_count`,
COALESCE(
	ROUND(SUM(`orders`.`billing_amount`)),
	0
) AS `billAmount`
FROM
`employees`
LEFT JOIN `orders` ON `orders`.`distributor_token` = `employees`.`token` 
WHERE
employees.token IN($distributor_token) AND employees.delete_status='1'
GROUP BY
`employees`.`token`");


		while($row1 = mysqli_fetch_array($sql1)){
			$distributor_obj = new stdClass;


			// check dsitributor
			$distributor_token1 = $row1['token'];
			$distributordata = mysqli_query($link,"SELECT *  FROM `orders` WHERE `employee_token` = '$distributor_token1' AND `order_type`='Distributor Order' AND YEAR(date_time) = YEAR(CURRENT_DATE()) AND 
			MONTH(date_time) = MONTH(CURRENT_DATE())");
			$check_distributor = mysqli_num_rows($distributordata);
			if($check_distributor>0){
				 $distributor_obj->Ordered = 1;

			}else{
				 $distributor_obj->Ordered = 0;

			}

			 $distributor_obj->distributor_token = $row1['token'];
			 $distributor_obj->distributor_name = $row1['name'];
			 $distributor_obj->shop_count = $row1['shop_count'];
			 $distributor_obj->order_count = $row1['order_count'];
			 $distributor_obj->billAmount = $row1['billAmount'];
			  $distributor_obj->address = $row1['address'];
			   $distributor_obj->pincode = $row1['pincode'];
			    $distributor_obj->street = $row1['street'];
			     $distributor_obj->city = $row1['city'];
			     $distributor_obj->mobile_number = $row1['mobile_number'];
			 array_push($distributor_array,$distributor_obj);
		}

		$sql2 = mysqli_query($link,"SELECT
				    `shop`.`token`,
				    `shop`.`name`,
				    `shop`.`address`,
				    `shop`.`city`,
				    `shop`.`pincode`,
				     COALESCE(`shop`.`unit_token`,0) AS unit_token,
				   COALESCE(SUM(orders.billing_amount),0) as total_amount,
				   COUNT(orders.token) as total_count ,
				   shop__type.name as shop_type
				FROM
				    `employees` SR
				INNER JOIN `employees` ON `employees`.`region_id` = SR.`region_id` AND `employees`.`deparment_token` = 18028120
                INNER JOIN `shop_mapping` ON `shop_mapping`.`distributor_token` = `employees`.`token`
				INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token` AND `shop`.`shop_type_code`!=0
				LEFT JOIN `orders` ON `orders`.`shop_token` = `shop`.`token`
				INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
				WHERE
				    SR.`token` = '$sales_rep_employee_token'  AND shop.shop_show_status = 'Active' AND shop_mapping.status='1'");
// AND shop.unit_token !=''

		while($row2 = mysqli_fetch_array($sql2)){
			$retailer_obj = new stdClass;
			$retailer_obj->shop_token = $row2['token'];
			$retailer_obj->shop_name = $row2['name'];
			$retailer_obj->total_amount = round($row2['total_amount']);
			$retailer_obj->total_count = $row2['total_count'];
			$retailer_obj->shop_type = $row2['shop_type'];
			$retailer_obj->address = $row2['address'];
			$retailer_obj->city = $row2['city'];
			$retailer_obj->pincode = $row2['pincode'];
			
			$retailer_obj->unit_token = $row2['unit_token'];
			 array_push($retailer_array,$retailer_obj);

		}

$obj = new stdClass;
		if(sizeof($distributor_array)) {
			$data = new stdClass;
			$data->distributor_array = $distributor_array;
			$data->retailer_array = $retailer_array;
        $obj->status_code=200; 
        $obj->message='OTP sent successfully';
        $obj->title='Success';
        $obj->data=$data;
    }
    else {
        $obj->status_code=400; 
        $obj->message='Today schedule not available';
        $obj->title='failure';
    }


echo json_encode($obj);

?>