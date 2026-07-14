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
    $inventory->divisionName=$inputData->division_name;
    $inventory->admin_token = $inputData->admin_token;
    $stmt=$inventory->addDivisionCheck();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $token                    = $inventory->divisionTokenGenerate();
        $inventory->token         = $token;
        $insert = $inventory->addDivision($indiaDateTime);
        $insertLog = $inventory->addDivisionLog($indiaDateTime);
        $obj->code=201;
        $obj->message="Sucess";
    }else{
        $obj->code=503;
        $obj->message="Division name already exist!";
    }
    echo json_encode($obj);
    $db = null;  
}
?>