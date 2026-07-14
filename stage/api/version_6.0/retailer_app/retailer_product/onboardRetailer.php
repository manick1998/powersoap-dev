<?php
include "../../../config.php";
$json_input = getInputs();
$retailcode = genToken('retail_code','shop');
$shop_name = $json_input->name;
$contact_person = $json_input->contactperson;
$contact_number = $json_input->mobileNumber;
$shop_type = $json_input->shop_type;
$licence_number = $json_input->gst;
$upload_url = $json_input->license_img;
$address = $json_input->address;
$city = $json_input->city;
$state = $json_input->stateToken;
$region = $json_input->regionToken;
$pincode = $json_input->pinCode;
$division_token = $json_input->checkedDivision; 
$date = $currnetDateTime;
$obj1 = new stdClass;
            $mobile_numberCheck = mysqli_query($link,"SELECT COUNT(mobile_number) as count FROM `shop` 
            WHERE  `shop`.`mobile_number`='$contact_number'"); 
            $row =mysqli_fetch_array($mobile_numberCheck);
            $count = $row["count"];
            if($count==0){
                $token  = genToken('token','shop');
                $insert_shop = mysqli_query($link,"INSERT INTO `shop`( `token`, `name`, `date_time`,   `retail_code`, `shop_type_code`, `slot`, `mobile_number`,`contact_person`, `join_date`, `license_number`,license_image,  `delete_status`, `shop_show_status`,`address`, `city`,`state_id`, `pincode`,`onboard_shop`) VALUES ('$token','$shop_name','$date', '$retailcode','$shop_type','0%','$contact_number','$contact_person','$date','$licence_number','$upload_url', '1','Active','$address','$city','$state','$pincode','1')");

                $insert_shopOutStanding = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$token','0','0','0','0')");
                
                foreach($division_token as $division){
                $insert_shop_division = mysqli_query($link,"INSERT INTO `shop_product_division`(`shop_token`, `division_token`, `date_time`, `delete_status`) VALUES ('$token','$division','$date','1')");
                }

    $obj1->status_code=200; 
    $obj1->message='Shop Added Successfully';
    $obj1->title='Success';
}else {
    $obj1->status_code=400; 
    $obj1->message ='Mobile number already exist'; 
    $obj1->title='Error';
}   
echo json_encode($obj1);
?>