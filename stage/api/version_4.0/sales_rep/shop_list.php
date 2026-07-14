<?php
ini_set('display_errors', 1);// show error reporting
 error_reporting(E_ALL);

include "../../config.php";
$json_input=getInputs();
$sales_rep_employee_token = $json_input->sales_rep_employee_token;
$distributor_token = $json_input->distributor_token;
$retailer_array=array();

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
				INNER JOIN shop_mapping ON shop_mapping.distributor_token = `employees`.`token`
				INNER JOIN shop ON shop.token = shop_mapping.shop_token 
				LEFT JOIN orders ON orders.shop_token = shop.token
				INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
				WHERE
				    SR.`token` = $sales_rep_employee_token  AND shop.shop_show_status = 'Active' 
				GROUP BY
				    `shop`.`token`");
// AND shop.unit_token !=''

		while($row2 = mysqli_fetch_array($sql2)){
			$retailer_obj = new stdClass;

			$shop_tken = $row2['token'];

			$last_date = mysqli_query($link,"SELECT
							     COALESCE(date_time,0) as last_date
							FROM
							    `orders`
							WHERE
							    `shop_token` = '$shop_tken'
							ORDER BY
							    `orders`.`id` desc
							LIMIT 1");

			$get_last_date = mysqli_fetch_array($last_date);
			echo $getDate = ($get_last_date['last_date']);
			$shop_date = date('d M Y', strtotime($getDate));
			// $shop_date = ($get_last_date['last_date']);
			if($shop_date == null){
			$shop_date = '-';
			}
			$retailer_obj->shop_token = $row2['token'];
			$retailer_obj->shop_name = $row2['name'];
			$retailer_obj->total_amount = round($row2['total_amount']);
			$retailer_obj->total_count = $row2['total_count'];
			$retailer_obj->shop_type = $row2['shop_type'];
			$retailer_obj->address = $row2['address'];
			$retailer_obj->city = $row2['city'];
			$retailer_obj->pincode = $row2['pincode'];
			$retailer_obj->last_date = $shop_date;//$get_last_date['last_date'];
			$retailer_obj->unit_token = $row2['unit_token'];
			 array_push($retailer_array,$retailer_obj);

		}
		$obj = new stdClass;
		if($sales_rep_employee_token) {
			$data = new stdClass;
			$data->retailer_array = $retailer_array;
        $obj->status_code=200; 
        $obj->message='OTP sent successfully';
        $obj->title='Success';
        $obj->data=$data;
    }
    else {
        $obj->status_code=400; 
        $obj->message='No Data Found';
        $obj->title='failure';
        // $obj->data=new stdClass;
    }


echo json_encode($obj);

?>