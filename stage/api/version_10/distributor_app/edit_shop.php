<?php
include "../../config.php";
$json_input = getInputs();
    $distributor_token = $json_input->distributor_token;
    $units_id = $json_input->units_id;
    $shop_name = $json_input->shop_name;
    $shop_id = $json_input->shop_id;
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

    $insert_shop = mysqli_query($link,"UPDATE `shop` SET `name`='$shop_name',`date_time`='$date',`unit_token`='$units_id',`shop_type_code`='$shop_type',`mobile_number`='$contact_number',`contact_person`='$contact_name',`license_number`='$licence_number',`license_image`= '$upload_url',`address`='$address',`city`= '$city',`pincode`='$pincode',`coordinates`='$coordinates'  WHERE `token` ='$shop_id' AND `distributor_token`='$distributor_token'");

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