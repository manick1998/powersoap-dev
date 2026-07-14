<?php
include "../../config.php";

$json_input = getInputs();
$employee_id = $json_input->emplyee_id;
$shop_id  = $json_input->shop_id;
$array= array();
$shop_detail = mysqli_query($link,"SELECT
				    shop.`name` as shop_name,
				    `join_date`,
				    `mobile_number`,
				    `license_number`,
				    `license_image`,
				    `address`,
				    `city`,
				    `pincode`,
				    shop__type.name as shop_type,
				     `coordinates`,
				     contact_person
				FROM
				    `shop` INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
				WHERE
				    shop.`token` = $shop_id");


$shop_row = mysqli_fetch_array($shop_detail);
	$obj = new stdClass;
 $obj->shop_name = $shop_row['shop_name'];
 $obj->contact_person = $shop_row['contact_person'];
 $obj->join_date= date('j,M Y', strtotime($shop_row['join_date']));
 $obj->mobile_number= $shop_row['mobile_number'];
 $obj->license_number= $shop_row['license_number'];
 $obj->license_image= $shop_row['license_image'];
 $obj->address= $shop_row['address'];
 $obj->city= $shop_row['city'];
 $obj->pincode= $shop_row['pincode'];
 $obj->shop_type= $shop_row['shop_type'];
 $obj->coordinates= utf8_encode($shop_row['coordinates']);


$obj1= new stdClass; 
if($shop_id !='') {
	$obj1->status_code=200; 
    $obj1->message='Shop found';
    $obj1->title='Success';
    $obj1->data=$obj;
    
    
}
else {
    $obj1->status_code=400; 
    $obj1->message='Shop not found';
    $obj1->title='Failure';
}

echo json_encode($obj1);
?>