<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
include_once '../config/core.php';
$input_data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$obj = new stdClass;

$state_name = $input_data->stateName;
$employee->state_name = $state_name;

$stmt = $employee->selectState();
$count = $stmt->rowCount();

if($count == 0){
    $employee->state_token = token_generate("employees__state","state_token");
    $insert = $employee->insertState($indiaDateTime);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "State inserted"; 
}else{
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "State All ready Exits";
}
echo json_encode($obj);
$db = null;
?>