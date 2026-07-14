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
    if($inputData->type == "all"){
        $dayName = date('l', strtotime($indiaDate));
        $stmt=$schedule->unitCheck($dayName);
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $schedule->readUnit($stmt,$indiaDate);
        }
    }else if($inputData->type=="single"){
        $schedule->token   = $inputData->token;
        $stmt=$schedule->selectedShop();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $schedule->readSelectedShop($stmt);
        }
    }
    echo json_encode($obj);
}
?>