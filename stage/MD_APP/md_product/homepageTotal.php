<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
include_once '../md_object/homepage.php';
$admin = new Admin($db);
if($inputData->type=="all"){
    $stmt=$admin->getReportDetailsForAdmin();
    if(!$stmt){
        $obj->code=503;
        $obj->data=[];
    }else{
        $obj->code = 201;
        $obj->data = $stmt;
    }
}
}
echo json_encode($obj);
$db = null;

?>