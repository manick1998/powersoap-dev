<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/orders.php';
    $order = new OrderList($db);
    if($inputData->type=="count"){
        $order->distributor_token = $inputData->distributor_token;
        $stmt=$order->historyOrderCheckCount();
        $obj->code = 201;
        $obj->data = $stmt->rowCount();
    }else if($inputData->type=="particular_order_detail"){
        $order->orderToken  = $inputData->order_token;
        $stmt=$order->singleOrderDetail();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->data=[];
        }else{
            $obj->data =$order->readSingleOrder($stmt,$baseUrlPath);
        }
        $stmt=$order->singleOrderItemDetail();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->data_item=[];
        }else{
            $obj->data_item = $order->readSingleOrderItemDetail($stmt);
        }
        //$obj->data_payment =  $order->readSingleOrderPayment();
    }else if($inputData->type == "shop_redirect_status"){
        $_SESSION["is_redirect_retailer_sub_page"] = $inputData->is_redirect_retailer_sub_page;
        $obj->data = [];
    }
    echo json_encode($obj);
}
?>