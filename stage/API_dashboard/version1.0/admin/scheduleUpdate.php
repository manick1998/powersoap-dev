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
    $schedule->token = $inputData->unit_token;
    $array = $inputData->update_array;
    foreach($array as $value){
        $schedule->day = $value->day_value;
        $schedule->saleEmployee = $value->sale_employee;
        $schedule->deliveryEmployee = $value->delivery_employee;
//        if($value->sale_employee!="" || $value->delivery_employee!=""){
            $stmt       = $schedule->dailyScheduleCheck();
            $checkCount = $stmt->rowCount();
            if($checkCount==0){
                $schedule->insertDailySchedule($indiaDateTime);
            }else{
                $schedule->updateDailySchedule();
            }
//        }
    }
    $obj->code        = 201;
    echo json_encode($obj);
}
?>