<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$obj_emp=new stdClass;
$obj=new stdClass;
 if($result1) {
    $retailer_app->mobile = $mobile;
    $call_back = $retailer_app->login();
    $num =$call_back->rowCount();
        $array =[];
        while($row = $call_back->fetch(PDO::FETCH_ASSOC)){
            //$obj=new stdClass;
            $obj_emp->shop_token=$row['shop_token'];
            $obj_emp->shop_name=$row['shop_name'];
            $obj_emp->mobile_number=$row['mobile_number'];
            $obj_emp->distributor_token=$row['distributor_token'];
            $obj_emp->distributor_name=$row['distributor_name'];
            array_push($array,$obj_emp);
        }

    $obj->status_code=200; 
    $obj->message='OTP verified';
    $obj->title='Success';
    $array=$obj_emp;
    $obj->data=$obj_emp;
}
else {
    $obj->status_code=400; 
    $obj->message='OTP not verified';
    $obj->title='Failure';
}

echo json_encode($obj);

?>