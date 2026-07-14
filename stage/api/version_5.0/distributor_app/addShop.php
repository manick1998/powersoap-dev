<?php
include "../../config.php";
$json_input = getInputs();
$distributorToken = $json_input->distributor_token;
$token  = genToken('token','shop');
$retailcode = genToken('retail_code','shop');
$obj1 = new stdClass;

$shop_name = $json_input->shop_name;
$contact_name = $json_input->contact_name;
$contact_number = $json_input->contact_number;
$shop_type = $json_input->shop_type;
$licence_number = $json_input->licence_number;
$upload_url = $json_input->upload_url;
$address = $json_input->address;
$city = $json_input->city;
//$state_token = $json_input->state_token;
$pincode = $json_input->pincode;
$coordinates = $json_input->coordinates;
$date = $currnetDateTime;

    if($shop_name != "" && $contact_number != "" && $shop_type != "" && $address != "" && $city != "" && $pincode != "" && $distributorToken != ""){

        $insert_shop = mysqli_query($link,"INSERT INTO `shop`(`token`,`name`,`date_time`,`unit_token`,`retail_code`,`shop_type_code`,`slot`,`distributor_token`,`mobile_number`,`contact_person`,`join_date`,`license_number`,`license_image`,`delete_status`,`address`,`city`,`state_id`,`pincode`,`coordinates`,`created_by`) VALUES('$token','$shop_name','$date','','$retailcode','$shop_type','0%','$distributorToken','$contact_number','$contact_name','$date','$licence_number','$upload_url','1','$address','$city','',$pincode','$coordinates','$distributorToken')");

        $obj1->status_code=200; 
        $obj1->message='Data inserted';
        $obj1->title='Success';
    }else{
        $obj1->status_code=400; 
        $obj1->message='Error';
        $obj1->title='failed';
    }

echo json_encode($obj1);
?>