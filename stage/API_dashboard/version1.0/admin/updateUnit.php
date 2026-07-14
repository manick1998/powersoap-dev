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
    $schedule->token   = $inputData->unit_token;
    $shopTokens        = $inputData->shop_tokens;
    $stmt       = $schedule->selectedShop();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $existData=[];
    }else{
        $existData = $schedule->readSelectedShopToken($stmt);
    }
    foreach($existData as $existToken){
        if(!in_array($existToken, $shopTokens)){
            $schedule->removeToken   = $existToken;
            $schedule->removeShopUnit();
        }
    }
    $array = [];
    foreach($shopTokens as $shopToken){
        if(!in_array($shopToken, $existData)){
            $schedule->shopToken  = $shopToken;
            $stmt=$schedule->shopMappingCheck();
            $checkCount = $stmt->rowCount();
            if($checkCount==1){
                $schedule->addUnitMapping($indiaDateTime);
                array_push($array,$shopToken);
            }
        }
    }
    $obj->code=201;
    $obj->message="";
    echo json_encode($obj);
}
?>