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
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$mobile = $input->phone_number;
$retailer->mobile = $mobile;
$stmt=$retailer->login();
$count = $stmt->rowCount();
$obj = new stdClass();
if($count > 0) {
    
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