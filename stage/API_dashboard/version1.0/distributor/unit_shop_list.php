<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/schedule_distributor.php';
    $schedule = new Schedule($db);
    $schedule->distributor_token = $inputData->distributor_token;
    $stmt=$schedule->unitShopCheck();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $obj->code=503;
        $obj->data=[];
    }else{
        $obj->code = 201;
        $obj->data = $schedule->readUnitShop($stmt);
    }
    echo json_encode($obj);
}
?>