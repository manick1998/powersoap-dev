<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/order.php';
    $order = new Order($db);
    $order->orderToken  = $inputData->order_token;
    $order->distributorToken  = $inputData->distributor_token;
    $order->admin_token  = $inputData->admin_token;
    $stmt=$order->singleOrderDetail();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $obj->code=503;
    }else{
        $obj->code=201;
        $obj->data =$order->cancelOrder($indiaDateTime);
        $order->cancelInsertLog($indiaDateTime);
    }
    echo json_encode($obj);
    $db = null;

}
?>