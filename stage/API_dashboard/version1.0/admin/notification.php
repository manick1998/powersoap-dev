<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
        $notification->noti_content = $inputData->noti_content;
        $state_id = $inputData->state_id;
        if(in_array(0,$state_id)){
            $state_data_id = '';
        }else{
            $state_data = implode(',',$state_id);
            $state_data_id =  "AND `state_id` IN ($state_data)"; 
        }
        $dist_token = $notification->selectAllDistributor($state_data_id);
        // print_r($dist_token);
        $notification_array = [];
        for ($i = 0; $i < count($dist_token); $i++) {
            $token = $dist_token[$i]->token;
            $state_id = $dist_token[$i]->state_id;
            $notification_array[] = "('$notify_token', '$token', '$inputData->noti_title', '$inputData->noti_content', '$indiaDateTime', '0', '1', '$state_id')";
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
        $stmt5 = $notification->state_id_query();
        $state_arr=[];
        // $obj1 = new stdClass();
        // echo $stmt5->rowCount();
        while($row = $stmt5->fetch(PDO::FETCH_ASSOC)){
            $obj1 = new stdClass();
            $obj1->state_id = $row['state_token'];
            $obj1->state_name = $row['state_name'];
            array_push($state_arr,$obj1);
        }
        
        $num = $stmt->rowCount();
        if($num > 0){
             $data = $notification->readSelectNotification($stmt);
             $obj->code=201;
             $obj->data=$data;
             $obj->state_data=$state_arr;
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