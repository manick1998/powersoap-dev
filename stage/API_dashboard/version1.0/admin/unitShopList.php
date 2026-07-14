<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/schedule.php';
    $schedule = new Schedule($db);
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