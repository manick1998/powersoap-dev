<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/offer_distributor.php';
    $offers = new Offers($db);
    if($inputData->type=="count_check"){
        $offers->distributor_token = $inputData->distributor_token;
        $offers->admin_state_id=$inputData->state_id;
        $stmt=$offers->offerCountCheck();
        $obj->code  = 201;
        $obj->Count = $stmt->rowCount();
    }
    echo json_encode($obj);
}
?>