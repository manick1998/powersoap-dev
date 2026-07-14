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
    $token                = $schedule->tokenGenerate();
    $schedule->token      = $token;
    $schedule->unitName   = $inputData->unit_name;
    $insert               = $schedule->addUnit($indiaDateTime);
    $shopTokens = $inputData->shop_tokens;
    $count = 0;
    $array = [];
    foreach($shopTokens as $shopToken){
        $schedule->shopToken  = $shopToken;
        $stmt=$schedule->shopMappingCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==1){
            $schedule->addUnitMapping($indiaDateTime);
            $count++;
            array_push($array,$shopToken);
        }
    }
    $obj->code=201;
    $obj->message=$array;
    echo json_encode($obj);
    $db = null;
}
?>