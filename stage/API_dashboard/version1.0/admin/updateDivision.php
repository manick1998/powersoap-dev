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
    $inventory->token        = $inputData->division_token;
    $inventory->divisionName = $inputData->division_name;
    $inventory->admin_token = $inputData->admin_token;
    $stmt=$inventory->updateDivisionCheck();
    $checkCount = $stmt->rowCount();
    $stmt1 = $inventory->divisionName();
    $inventory->division = $stmt1;
    if($checkCount==0){
        $insert = $inventory->updateDivision();
        if($stmt1!=$inputData->division_name){
        $insertLod = $inventory->updateDivisionLog($indiaDateTime);
        }
        $obj->code=201;
        $obj->message="Sucess";
    }else{
        $obj->code=503;
        $obj->message="Division name already exist!";
    }
    echo json_encode($obj);
}
?>