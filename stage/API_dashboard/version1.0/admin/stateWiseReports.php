<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
date_default_timezone_set('Asia/Kolkata');
$currentDate  = date("Y-m-d H:i:s");
include_once '../objects/inventory.php';
    $inventory = new inventory($db);
    if($inputData->type == "state_wise"){
        $inventory->from_date=$inputData->from_date;
        $inventory->to_date = $inputData->to_date;
        if($inputData->state[0] == 0){
            $inventory->state = ''; 
         }else{
            $inventory->state = " AND employees.state_id IN (".implode(',',$inputData->state).")";
         }
        $stmt = $inventory->stateWise();
        $array= $inventory->readstateWise($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "State Wise List";
        $obj->data = $array;
    }if($inputData->type == "region_wise"){
        $inventory->from_date=$inputData->from_date;
        $inventory->to_date = $inputData->to_date;
        $inventory->state = $inputData->state;
        $inventory->region = $inputData->region;
        $stmt1 = $inventory->regionWise();
        $array1= $inventory->readregionWise($stmt1);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Region Wise List";
        $obj->data = $array1;
    }if($inputData->type == "allover_wise"){
        $inventory->from_date=$inputData->from_date;
        $inventory->to_date = $inputData->to_date;
        $inventory->state = $inputData->state;
        $inventory->region = $inputData->region;
        $inventory->division = $inputData->division;
        $inventory->product = $inputData->product;
        $stmt2 = $inventory->overallWise();
        $array2= $inventory->readoverallWise($stmt2);
        $stmt3 = $inventory->partculoar_division_product1();
        $division_data = $inventory->partculoar_division_product1_read($stmt3);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "overall Wise List";
        $obj->data = $array2;
        $obj->product  = $division_data;
    }
    
    echo json_encode($obj);
     $db = null;


?>
