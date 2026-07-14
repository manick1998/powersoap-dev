<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$admin = new Employee($db);
$admin->state_token=$inputData->state_token;
$admin->region_token=$inputData->region_token;
$area_token                = $admin->tokenGenerate();
$admin->area_token =$area_token;
$admin->area=$inputData->area;
// $check = $admin->validateArea();
// $count = $check->rowCount();
//$count == 0
// if($count){
    $stmt = $admin->areaview_Insert($indiaDateTime);
    if($stmt){
        $obj->code = 201;
        $obj->title = "success";
        $obj->message = "Area Inserted";
   }else{
       $obj->code = 400;
       $obj->title = "error";
       $obj->message = "Error";
   
   }
//  }
//  else{
//     $obj->code = 400;
//     $obj->title = "error";
//     $obj->message = "Area already exists";
   

echo json_encode($obj);
$db = null;

?>