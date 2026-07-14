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
    if($inputData->type == 'region'){
        if($inputData->state_id == '0' || $inputData->state_id == 'all'){
           $order->state_id = ''; 
        }else{
           $order->state_id = "WHERE `state_id`='$inputData->state_id'";
        }
        $data = $order->stateRegion();
        if(count($data)==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $data;
        }
    }else if($inputData->type == 'distributor'){
        $order->region_id = $inputData->region_id;
        $data = $order->regionDistributor();
        if(count($data)==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $data;
        }
    }else if($inputData->type == 'salesRep'){
        if($inputData->state_id =="0" || $inputData->state_id == "all"){
           $order->state_id = " "; 
        }else{
           $order->state_id = "AND `state_id`='$inputData->state_id'";
        }
        $data = $order->stateWiseSalesRep();
        if(count($data)==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $data;
        }
    }
    echo json_encode($obj);
}
?>