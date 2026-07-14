<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
    if($inputData->type == 'get_Control'){
        $getStmt = $inventory->getStatus();
        $data = $inventory->viewStatus($getStmt);
        $obj->code=201;
        $obj->data=$data;
    }else if($inputData->type == 'checkedStatus'){
            $inventory->status = $inputData->status;
            $inventory->token = $inputData->token;
            $getStmt = $inventory->updateStatus();
            $obj->code=201;
            $obj->message="Updated status";       
    }else{
        $obj->code=503;
        $obj->message="Status code exist!";
    }
    echo json_encode($obj);
    $db = null;

}
?>