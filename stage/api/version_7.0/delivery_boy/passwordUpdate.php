<?php

include "../../config.php";

$json_input=getInputs();
$mobile = $json_input->phone_number;
$password = $json_input->password;

$obj = new stdClass;
$passwords = hash('sha512', $password);
$update = mysqli_query($link,"UPDATE `employees` SET `password`='$passwords' WHERE `mobile_number`='$mobile'");
    
    if($update) {
        $obj->status_code=200; 
        $obj->message='Password Updated successfully';
        $obj->title='Success';
 }
else {
    $obj->status_code=400; 
    $obj->message='Mobile number not exist';
    $obj->title='Failure';
}

echo json_encode($obj);
?>