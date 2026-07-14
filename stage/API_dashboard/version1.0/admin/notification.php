<?php
$obj = new stdClass();
include_once "../config/core.php";
$inputData = getInputs();
include_once "../config/database.php";
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/notification.php';
    $notification = new Notification($db);
    if($inputData->type == 'create_new_notify'){
        $notify_token = token_generate('admin_notification','token');
        $notification->notify_token = $notify_token;
        $notification->noti_title = $inputData->noti_title;
        $notification->noti_content= $inputData->noti_content;
        $dist_token = $notification->selectAllDistributor();
        $notification_array = [];
        for($i=0; $i<count($dist_token); $i++){
            $notification_array[] = "('$notify_token','$dist_token[$i]','$inputData->noti_title','$inputData->noti_content','$indiaDateTime','0','1')";
        }
        if($notification->creteNewNotification($notification_array)){
            $obj->code=201;
            $obj->message="Notification Created Successfully";
        }else{
            $obj->code=503;
            $obj->message="Notification not Created";
        }
    }else if($inputData->type == 'selectAll_notify'){
        $stmt = $notification->selectNotification();
        $num = $stmt->rowCount();
        if($num > 0){
             $data = $notification->readSelectNotification($stmt);
             $obj->code=201;
             $obj->data=$data;
             $obj->message="List of Notification";
        }else{
             $obj->code=201;
             $obj->message="Notification not found";
        }
    }else if($inputData->type == 'delete_notify'){
        $notification->notification_token = $inputData->notification_token;
        if($stmt = $notification->deleteNotification()){
             $obj->code=201;
             $obj->message="Deleted Notification";
        }else{
             $obj->code=201;
             $obj->message="Not Deleted Notification";
        }
    }
    echo json_encode($obj);
    $db = null;

}
?>