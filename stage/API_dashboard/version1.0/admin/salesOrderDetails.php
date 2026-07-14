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
    if($inputData->type=="count"){
        $order->orderType   = "Sales Order";
        $stmt=$order->orderCheckCount();
        $obj->code = 201;
        $obj->data = $stmt->rowCount();
    }else if($inputData->type=="all"){
        $order->orderType   = "Sales Order";
        $stmt=$order->orderCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $order->readOrder($stmt);
        }
    }else if($inputData->type=="date_range"){
        $order->orderType  = "Sales Order";
        $from_date         = $inputData->from_date;
        $order->fromDate   = date("Y-m-d 00:00:00", strtotime($from_date));
        $to_date           = $inputData->to_date;
        $order->toDate     = date("Y-m-d 23:59:59", strtotime($to_date));
        $stmt=$order->orderCheckDateRange();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $order->readOrder($stmt);
        }
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
        
        $obj->data_payment =  $order->readSingleOrderPayment();
        
    }
    echo json_encode($obj);
    $db = null;

}
?>