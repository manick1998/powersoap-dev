<?php
include "../../config.php";
$json_input = getInputs();
$distributor_token = $json_input->distributor; 
$sales_rep_token = $json_input->sales_rep_token;
$retailcode = genToken('retail_code','shop');
$shop_name = $json_input->shop_name;
$contact_number = $json_input->mobile_number;
$licence_number = $json_input->gst;
$upload_url = $json_input->license_img;
$address = $json_input->address;
$city = '';//$json_input->city;
$state = $json_input->state;
$pincode = $json_input->pincode;
$date = $currnetDateTime;


//$mobile_numberCheck =mysqli_query($link,"SELECT COUNT(mobile_number) as count,token FROM `shop`  WHERE mobile_number='$contact_number'");
$arrayMobileExist = [];
$arrayCount = 0;
    foreach($distributor_token as $distributor){
            $mobile_numberCheck = mysqli_query($link,"SELECT COUNT(mobile_number) as count,token FROM `shop` 
            INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
            WHERE `shop_mapping`.`distributor_token`='$distributor' AND `shop`.`mobile_number`='$contact_number'"); 
            $row =mysqli_fetch_array($mobile_numberCheck);
            $count = $row["count"];
            if($count==0){
                $arrayCount++;
                $token  = genToken('token','shop');
                $insert_shop = mysqli_query($link,"INSERT INTO `shop`( `token`, `name`, `date_time`, `unit_token`,  `retail_code`, `shop_type_code`, `slot`, `mobile_number`,`contact_person`, `join_date`, `license_number`,license_image,  `delete_status`, `shop_show_status`,`address`, `city`,`state_id`, `pincode`, `coordinates`,`created_by`) VALUES ('$token','$shop_name','$date','' , '$retailcode','80189244','0%','$contact_number','','$date','$licence_number','$upload_url', '1','Active','$address','$city','$state','$pincode','','$sales_rep_token')");

                $insert_shopOutStanding = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$token','0','0','0','0')");

                $insert_shop_mapping = mysqli_query($link,"INSERT INTO `shop_mapping`(`shop_token`, `distributor_token`, `date_time`, `status`) VALUES ('$token','$distributor','$currnetDateTime','0')");
            }else{
                $distCheck = mysqli_query($link,"SELECT `name` FROM `employees` WHERE `token`='$distributor' AND `deparment_token`='18028120'");
                $row1 =mysqli_fetch_array($distCheck);
                array_push($arrayMobileExist, $row1["name"]); 
            }
    }
//else{
//    foreach($distributor_token as $distributor)
//    {
//
//      $insert_shop_mapping = mysqli_query($link,"INSERT INTO `shop_mapping`(`shop_token`, `distributor_token`, `date_time`, `status`) VALUES ('$token1','$distributor','$currnetDateTime','0')");
//
//    }
//}
$obj1 = new stdClass;
if(count($distributor_token) == $arrayCount){
    $obj1->status_code=200; 
    $obj1->message='Shop Added Successfully';
    $obj1->title='Success';
}else if(count($arrayMobileExist) > 0){
    $obj1->status_code=400; 
    $obj1->message = 'Mobile No Already exist - '.implode(", ",$arrayMobileExist); 
    $obj1->title='Error';
}
//if($contact_number!="" && $sales_rep_token){
//    $obj1->status_code=200; 
//    $obj1->message='Shop Added Successfully';
//    $obj1->title='Success';
//    
 else {
    $obj1->status_code=400; 
    $obj1->message='Mobile No doesnt empty';
    $obj1->title='Error';
    
} 
echo json_encode($obj1);
?>