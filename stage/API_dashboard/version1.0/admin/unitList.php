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
    if($inputData->type=="all"){
        $stateId = $inputData->state_id;
            if($stateId != '0'){
                $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
            }
        $schedule->stateQuery = $stateQuery; 
        $stmt=$schedule->unitCheck();
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