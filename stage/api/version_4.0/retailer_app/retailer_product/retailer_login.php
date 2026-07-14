<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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
$retailer_app->mobile = $mobile;
$fun_call = $retailer_app->login();
$num = $fun_call->rowcount();
$obj = new stdClass();
if($num  > 0) {
    
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
}else {
    $obj->status_code=400; 
    $obj->message='Mobile number not exist';
    $obj->title='Failure';
}

echo json_encode($obj);


?>