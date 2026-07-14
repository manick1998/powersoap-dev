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
    if($inputData->type=="count_check"){
        $stmt=$offers->offerCountCheck();
        $obj->code  = 201;
        $obj->Count = $stmt->rowCount();
    }else if($inputData->type=="delete"){
        $offers->token           = $inputData->token;
        $offers->admin_token = $inputData->admin_token;
        $stmt=$offers->offerDetails();
        $data=$offers->readofferDetails($stmt);
        $offers->offerName = $data[0]->offer_name;
        $offers->offerPercentage = $data[0]->offer_percentage;
        $offers->offerDivision = $data[0]->division_token;
        $offers->purchaseAmount=$data[0]->minimum_purchase_amount;
        $offers->offerState = $data[0]->state_id;
        $offers->deleteOffer($indiaDateTime);
        $offers->deleteOfferLog($indiaDateTime);
        $obj->code = 201;
        $obj->data = "Success";
    }
    echo json_encode($obj);
    $db = null;

}
?>