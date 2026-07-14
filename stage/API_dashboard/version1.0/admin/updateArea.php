<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$admin = new Employee($db);
// $admin->state_token=$inputData->state_token;
// $admin->region_token=$inputData->region_token;
$admin->area_token =$inputData->area_token;
$admin->area_name=$inputData->area_name;
$stmt = $admin->updateAreaData();
if($stmt){
     $obj->code = 201;
     $obj->title = "success";
     $obj->message = "Updated Area";
}else{
    $obj->code = 400;
    $obj->title = "error";
    $obj->message = "Error";

}
echo json_encode($obj);

?>