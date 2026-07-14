<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/offers.php';
    $offers = new Offers($db);
    // $stateId = $_GET["state_id"];
    // if($stateId != '0'){
    //     $stateQuery = " AND `admin_offers`.`state_id` IN ('".$stateId."')";
    // }else{
    //     $stateQuery = " ";
    // }
    // $offers->stateQuery    = $stateQuery;
    $offers->offerDivision = $inputData->offer_division;
    $offers->offerState    =$inputData->offer_state;
    $offers->purchaseAmount= $inputData->purchase_amount;
    $offers->admin_token = $inputData->admin_token;
    $stmt=$offers->addOfferCheck();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $offers->token           = $offers->tokenGenerate();
        $offers->offerName       = $inputData->offer_name;
        $offers->offerPercentage = $inputData->offer_percentage;
        
        $insert = $offers->addOffer($indiaDateTime);
        $insertLog = $offers->addOfferLog($indiaDateTime);
        $obj->code=201;
        $obj->message=$insert;
    }else{
        $obj->code=503;
        $obj->message="Offer already exist for this division and amount";
    }
    echo json_encode($obj);
    $db = null;
}
?>