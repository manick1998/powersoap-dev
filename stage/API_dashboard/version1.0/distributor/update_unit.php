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
    $schedule->edit_unit_name   = $inputData->edit_unit_name;
    $schedule->token   = $inputData->unit_token;
    $schedule->distributor_token = $inputData->distributor_token;
    $shopTokens        = $inputData->shop_tokens;
    $shopToken_uniq = $inputData->shop_token_uniq1;
    $schedule->shopToken_uniq  = $shopToken_uniq;
    #=================== unit name change
    $stmt1       = $schedule->unit_name_check();
    $checkCount = $stmt1->rowCount();
   if ($checkCount > 0) {
    $stmt3       = $schedule->unit_name_update();
   }
    $stmt       = $schedule->selectedShop();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $existData=[];
    }else{
        $existData = $schedule->readSelectedShopToken($stmt);
    }
    // print_r($existData);
    // foreach($existData as $existToken){
        // echo $existToken;
        // if(in_array($existToken,$shopToken_uniq)){
                    $schedule->token   = $inputData->unit_token;
                    $schedule->removeShopUnit();
            // $schedule->removeToken   = $existToken;

        // }
    //}
    $schedule->token   = $inputData->unit_token;
    $schedule -> remove_shop_unit_token();
    
    $array = [];
    foreach($shopTokens as $shopToken){
        if(!in_array($shopToken, $existData)){
            $schedule->shopToken  = $shopToken;
            $stmt=$schedule->shopMappingCheck();
            $checkCount = $stmt->rowCount();
            if($checkCount==1){
                foreach ($shopToken_uniq as  $shopToken_uniq) {
                    $schedule->token   = $inputData->unit_token;
                    $schedule->distributor_token = $inputData->distributor_token;
                    $schedule->shopToken_uniq  = $shopToken_uniq;
                    $schedule->addUnitMapping($indiaDateTime);

                }
                array_push($array,$shopToken);
            }
        }
    }
    foreach ($shopTokens as $shopTokens) {
        $schedule->shopTokens =$shopTokens;
        $schedule->token   = $inputData->unit_token;
        $schedule->distributor_token = $inputData->distributor_token;
        $schedule -> update_shop_unit_token();
    }
    $obj->code=201;
    $obj->message="success";
    echo json_encode($obj);
}
?>