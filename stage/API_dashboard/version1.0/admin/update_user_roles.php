<?php

$obj = new StdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);

$token = $inputData->token;
$name =$inputData->name;
$email=$inputData->email;
$modules = $inputData->module_id;

$admin->token = $token;
$admin->name=$name;
$admin->email=$email;
$admin->modules = $modules;
$admin->currentdate = date("Y-m-d H:i:s");

if($token !="" && $modules !=""){
    $module = $admin->updateNewData();
    $module2 = $admin->updateInsertData();
    $currentdate = date("Y-m-d H:i:s");
    $module3 =$admin->updateName();
    if($module && $module2 && $module3){
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Updated Success";
    }else{
        $obj->status_code = 500;
        $obj->header = "Error";
        $obj->message = "Failed";
    }
    
}else{
    $obj->status_code = 500;
    $obj->header = "Error";
    $obj->message = "All fields are mandatroy";
}

echo json_encode($obj);
?>