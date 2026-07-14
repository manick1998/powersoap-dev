<?php
$obj = new stdClass();
include_once "../config/core_distributor.php";
$inputData = getInputs();
include_once "../config/database.php";
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/notification.php';
    $notification = new Notification($db);
    if($inputData->type == 'selectAll_notify'){
        $notification->distributor_token = $inputData->distributor_token;
        $stmt = $notification->updateSeenNotification();
        $stmt = $notification->selectIndividualDistributor();
        $num = $stmt->rowCount();
        if($num > 0){
             $data = $notification->readSelectIndividualDistributor($stmt);
             $obj->code=201;
             $obj->data=$data;
             $obj->message="List of Notification";
        }else{
             $obj->code=201;
             $obj->message="Notification not found";
        }
    } else if($inputData->type == 'count_unseen'){
        $notification->distributor_token = $inputData->distributor_token;
        $count = $notification->countUnseenNotification();
        $obj->code = 200;
        $obj->count = $count;
        $obj->message = "Unseen Notification Count";
    }
    echo json_encode($obj);
}
?>