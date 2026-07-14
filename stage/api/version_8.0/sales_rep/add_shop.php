<?php
include "../../config.php";
$json_input = getInputs();
$distributor_token = $json_input->distributor; 
$sales_rep_token = $json_input->sales_rep_token;
$retailcode = genToken('retail_code','shop');
$shop_mapToken = genToken('token','shop_mapping');
$token  = genToken('token','shop');
$shop_name = $json_input->shop_name;
$contact_number = $json_input->mobile_number;
$licence_number = $json_input->gst;
$upload_url = $json_input->license_img;
$address = $json_input->address;
$city = $json_input->city;
$state = $json_input->state;
$pincode = $json_input->pincode;
$date = $currnetDateTime;
//shop_token
$query = mysqli_query($link,"SELECT `token` FROM `shop` WHERE `mobile_number`='$contact_number'");
$row = mysqli_fetch_array($query);
$token1 = $row['token'];


$mobile_numberCheck =mysqli_query($link,"SELECT shop.mobile_number FROM `shop` INNER JOIN shop_mapping ON shop.token=shop_mapping.shop_token WHERE mobile_number='$contact_number' AND shop_mapping.distributor_token!='$distributor_token'");
$mobile_count = mysqli_num_rows($mobile_numberCheck);
if($mobile_count==0){
    $insert_shop = mysqli_query($link,"INSERT INTO `shop`( `token`, `name`, `date_time`,`retail_code`, `shop_type_code`, `slot`, `mobile_number`,`contact_person`, `join_date`, `license_number`,license_image,  `delete_status`, `shop_show_status`,`address`, `city`,`state_id`, `pincode`, `coordinates`,`created_by`) VALUES ('$token','$shop_name','$date', '$retailcode','80189244','0%','$contact_number','','$date','$licence_number','$upload_url', '1','Active','$address','$city','$state','$pincode','','$sales_rep_token')");
    foreach($distributor_token as $distributor)
    {
    $shop_mapToken = genToken('token','shop_mapping');
    $insert_shop_mapping = mysqli_query($link,"INSERT INTO `shop_mapping`(`token`,`shop_token`, `distributor_token`,`unit_token`, `date_time`, `status`) VALUES ('$shop_mapToken','$token','$distributor','','$currnetDateTime','0')");
    $shop_outstanding_amt = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$shop_mapToken','0','0','0','0')");
}
}else{
   foreach($distributor_token as $distributor)
   {
    $query = mysqli_query($link,"SELECT `shop_token` FROM `shop_mapping` WHERE `distributor_token`='$distributor' AND `shop_token`='$token1'");
    $count = mysqli_num_rows($query);
    if($count==0){
     $shop_mapToken = genToken('token','shop_mapping');
     $insert_shop_mapping = mysqli_query($link,"INSERT INTO `shop_mapping`(`token`,`shop_token`, `distributor_token`,`unit_token`, `date_time`, `status`) VALUES ('$shop_mapToken','$token1','$distributor','','$currnetDateTime','0')");
     $shop_outstanding_amt = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$shop_mapToken','0','0','0','0')");
    }
   }
}
$obj1 = new stdClass;
if($mobile_count==0){
    $obj1->status_code=200; 
    $obj1->message='Shop Added Successfully';
    $obj1->title='Success';
}else if($count){
    $obj1->status_code=400; 
    $obj1->message='Mobile Number Already Exist';
    $obj1->title='Error';
}
else {
    $obj1->status_code=400; 
    $obj1->message='Error';
    $obj1->title='Error';
    
} 
echo json_encode($obj1);
?>