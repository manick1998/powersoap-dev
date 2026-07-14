<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$emp->state_token = $data->state_token;
$func = $emp->individual_state_rep();
$count = $func->rowCount();
$obj = new stdClass;
if ($count > 0) {
    $individual_state_rep_read = $emp->individual_state_rep_read($func);
    $obj->status_code = '200';
    $obj->message = 'success';
    $obj->individual_state_rep_read = $individual_state_rep_read; 
    
}else{
    $obj->status_code = '400';
    $obj->message = 'Error';
}
echo json_encode($obj);
$db = null;

?>