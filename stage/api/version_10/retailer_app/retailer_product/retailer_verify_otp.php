<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
include '../../../config.php';

$database = new Database();
$db = $database->getConnection();
$retailer_app =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$mobile = $input->phone_number;

$otp = $input->otp;

$result1 =  otpVerify($mobile,$otp);
$obj=new stdClass;
 if($result1) {
    $retailer_app->mobile = $mobile;

    $obj->status_code=200; 
    $obj->message='OTP verified';
    $obj->title='Success';
}
else {
    $obj->status_code=400; 
    $obj->message='OTP not verified';
    $obj->title='Failure';
}

echo json_encode($obj);

?>