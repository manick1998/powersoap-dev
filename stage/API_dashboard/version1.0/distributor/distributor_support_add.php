<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/employee.php';
include_once '../config/core_distributor.php';

$data = json_decode(file_get_contents("php://input"));
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
$random_token=rand(10000000,99999999);
if ($data->type == 'distributor_issue') {
     $emp->Distributor_token = $employee_token ;
        $employee_token = $data->Distributor_token;
        
        $result = mysqli_query($link,"SELECT * FROM `employees` WHERE token = $employee_token");
        $row = mysqli_fetch_assoc($result);
        $deparment_token = $row["deparment_token"];
        
    
     $emp->Distributor_token = $data->Distributor_token;
     $emp->Distributor_name = $data->Distributor_name;
     $emp->distributor_mobilenumber = $data->distributor_mobilenumber;
     $emp->text = $data->text;
     $emp->distributor_image = $data->distributor_image;
    $fun_call =  $emp->distributor_add_issue($currentDate,$random_token,$deparment_token);
    if (!$fun_call) {
        $obj-> code ='404';
        $obj->message = 'Something went to wronge';
    }else{
        $obj-> code ='200';
        $obj->message = 'Requested Successfully';  
    } 
} 
echo  json_encode($obj);
?>