<?php

include "../../config.php";

$json_input=getInputs();
$mobile = $json_input->phone_number;
// $token = $json_input->token;

$obj = new stdClass;
// $sql1 = mysqli_query($link,"SELECT 1 FROM `employees` WHERE `mobile_number`= $mobile AND block_status='1'");

$sql1 = mysqli_query($link,"SELECT
                                *
                            FROM
                                `employees`
                            INNER JOIN deparment ON deparment.token=employees.deparment_token WHERE `mobile_number` = $mobile AND block_status = '1' AND deparment.token= '72602780'");

$check_status = mysqli_num_rows($sql1);

if($check_status  > 0) {
    $result = sendOTP($mobile);
    
    if($result) {
        $obj->status_code=200; 
        $obj->message='OTP sent successfully';
        $obj->title='Success';
    }
    else {
        $obj->status_code=400; 
        $obj->message='OTP not sent';
        $obj->title='failure';
    }
}
else {
    $obj->status_code=400; 
    $obj->message='Mobile number not exist';
    $obj->title='Failure';
}

echo json_encode($obj);
?>