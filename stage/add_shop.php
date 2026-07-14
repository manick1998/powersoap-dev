<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$units_id = $json_input->units_id;
$token  = genToken('token','shop');
$retailcode = genToken('retail_code','shop');

$shop_name = $json_input->shop_name;
$contact_name = $json_input->contact_name;
$contact_number = $json_input->contact_number;
$shop_type = $json_input->shop_type;
$licence_number = $json_input->licence_number;
$upload_url = $json_input->upload_url;
$address = $json_input->address;
$city = $json_input->city;
$pincode = $json_input->pincode;
$coordinates = $json_input->coordinates;
$date = $currnetDateTime;
$get_distributor_id = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$ditributor_id = $row_id['admin_distributor_token'];



if($employee_id){
$insert_shop = mysqli_query($link,"INSERT INTO `shop`( `token`, `name`, `date_time`, `unit_token`,  `retail_code`, `shop_type_code`, `slot`, `distributor_token`, `mobile_number`,
							 `contact_person`, `join_date`, `license_number`,license_image,  `delete_status`, `address`, `city`, `pincode`, `coordinates`,`created_by`) VALUES ('$token','$shop_name','$date','$units_id' , '$retailcode','$shop_type','0%','$ditributor_id','$contact_number','$contact_name','$date','$licence_number','$upload_url', '1','$address','$city','$pincode','$coordinates','$employee_id')");


if($insert_shop){
$units_mapping = mysqli_query($link,"INSERT INTO `units__shop_mapping`( `unit_group_token`, `distributor_token`, `shop_token`, `delete_status`) VALUES ('$units_id','$ditributor_id','$token','1')");
$shop_outstanding_amt = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$token','0','0','0','0')");

}
}



$obj1 = new stdClass;
if($insert_shop){
    $obj1->status_code=200; 
    $obj1->message='Product found';
    $obj1->title='Success';
    
} else {
    $obj1->status_code=400; 
    $obj1->message='Product not found';
    $obj1->title='failed';
    
}
echo json_encode($obj1);
?>