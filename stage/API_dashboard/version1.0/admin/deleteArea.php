<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';

$admin = new Employee($db);

$admin->area_token = $inputData->area_token;

$stmt = $admin->deleteAreaData();

if($stmt){
     $obj->code = 201;
     $obj->status_code = 200; 
     $obj->title = "success";
     $obj->message = "Area Deleted Successfully";
}else{
    $obj->code = 400;
    $obj->status_code = 400;
    $obj->title = "error";
    $obj->message = "Error deleting area";
}
echo json_encode($obj);
?>