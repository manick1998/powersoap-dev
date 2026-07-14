<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/schedule_distributor.php';
    $schedule = new Schedule($db);
    $token                = $schedule->tokenGenerate();
    $schedule->token      = $token;
    $schedule->unitName   = $inputData->unit_name;
    $schedule->distributor_token = $inputData->distributor_token;
    $insert               = $schedule->addUnit($indiaDateTime);
    $shopTokens = $inputData->shop_tokens;
    $shopToken_uniq = $inputData->shop_token_uniq;
    
    $count = 0;
    $array = [];
    foreach($shopTokens as $shopToken){
        $schedule->shopToken  = $shopToken;
        $stmt=$schedule->shopMappingCheck();
        $checkCount = $stmt->rowCount();
        foreach ($shopToken_uniq as  $shopToken_uniq) {
            $schedule->shopToken_uniq  = $shopToken_uniq;
            $schedule->addUnitMapping($indiaDateTime);
        }
        if($checkCount==1){
            $schedule->add_shop_in_unit();
            $count++;
            array_push($array,$shopToken);
        }
    }
    $obj->code=201;
    $obj->message=$array;
    echo json_encode($obj);
}
?>