<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);
if($inputData->type == 'all_admin_details'){
    $module_data = $admin->allfetchmodulelist();
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "module List";
    $obj->data = $module_data;
}else if($inputData->type == 'edit_admin_module'){
    $admin->admin_token = $inputData->admin_token;
    $module = $admin->fetchmodulelist();
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "module List";
    $obj->data = $module;
}else if($inputData->type == 'status'){
    $admin->admin_token = $inputData->admin_token;
    if($admin->statusupdate()){
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Updated Successfully";
    }else{
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "oops";
    }
}else if($inputData->type == 'statusUpdate'){
    $admin->admin_token = $inputData->admin_token;
    if($admin->statusrechange()){
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Updated Successfully";
    }else{
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "oops";
    }
}
echo json_encode($obj);
$db = null;

?>