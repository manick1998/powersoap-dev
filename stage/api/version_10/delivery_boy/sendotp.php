<?php
include "../../config.php";
$json_input = getInputs();
$mobile = $json_input->phone_number;


 $obj=new stdClass;
 $sql1 = mysqli_query($link,"SELECT `mobile_number` FROM `employees` WHERE mobile_number = '$mobile' AND `block_status`='1' AND `deparment_token`=93402780");
 $count = mysqli_num_rows($sql1);
 if($count > 0){
    $result = sendOTP($mobile);
    if($result){
    $obj->status_code=200; 
    $obj->message='OTP Send Successfully';
    $obj->title='Success';
}
else {
    $obj->status_code=400; 
    $obj->message='OTP not Send';
    $obj->title='Failure';
}
 }else{
    $obj->status_code=400; 
    $obj->message='Mobile Number Not Exist';
    $obj->title='Failure';
 }

echo json_encode($obj);
?>