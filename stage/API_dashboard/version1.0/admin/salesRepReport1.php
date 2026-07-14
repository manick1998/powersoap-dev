<?php
## oops conncetivity
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
//$inputData->dashboard_code = $verification_code;
// if($inputData->dashboard_code == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    // $stateId = $inputData->stateId;
    // if($stateId != '0'){
    //     $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
    // }else{
    //     $stateQuery = " ";
    // }
    // $order->stateQuery    = $stateQuery;
    $order->fromDate     =  $inputData->fromDate; 
    $order->salesRep     = $inputData->salesRep;
    // $order->selectState  = $inputData->selectState;
    $stmt = $order->livetrackReport(); 
    $data = $order->readlivetrackReport($stmt);
    if(count($data)>0){
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "List show updated"; 
        $obj->data = $data;
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Error"; 
    }
    echo json_encode($obj);
// }
?>

