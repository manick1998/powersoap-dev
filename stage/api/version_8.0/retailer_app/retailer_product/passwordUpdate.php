<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include "../../../config.php";
include '../retailer_object/retailer_home_page.php';
$database = new Database();
$db = $database->getConnection();
$retailer_home_page =new home_page($db);
$input = json_decode(file_get_contents("php://input"));


$mobile_number = $input->mobile_number;
$retailer_home_page->mobile_number=$mobile_number;
$password = hash('sha512', $input->password);
$retailer_home_page->password = $password;

if($mobile_number!=""&& $password!=""){
$Update = mysqli_query($link,"UPDATE `shop` SET `password`='$password' WHERE `mobile_number`='$mobile_number'");
}
$obj = new stdClass;
if($Update){
    $obj->status_code=200; 
    $obj->message='Data Updated';
    $obj->title='Success';
    
}else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='failure';
    
}
echo json_encode($obj);
?>