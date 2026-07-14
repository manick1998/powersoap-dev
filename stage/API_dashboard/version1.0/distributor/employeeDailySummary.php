<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
// if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee_distributor.php';
    $employee = new Employee($db);
    $employee->distributor_token = $inputData->distributor_token;
    if($inputData->type=="particular_date_detail"){
        $selected_date            = $inputData->selected_date;
        $employee->selectedDate   = date("Y-m-d", strtotime($selected_date));
        $employee->employeeToken  = $inputData->employee_token;
        $employee->order_token  = $inputData->order_token;
        $employee->unit_token  = $inputData->unit_token;
        $obj->invoice_file = $employee->getLoadingSheetInvoice();
        $stmt=$employee->employeeDateDetail();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
             $obj->code=503;
        }else{
            $obj->data = $employee->readEmployeeDateDetail($stmt);
        }
        $orderconcat_token = $employee->employeeDateOrdertoken();
        $stmt = $employee->employeeDateItemDetail($orderconcat_token);
        $checkCount1 = $stmt->rowCount();
        if($checkCount1==0){
            //$obj->data_item=[];
             $obj->code1=503;
        }else{
            $obj->data_item = $employee->readEmployeeDateItemDetail($stmt);
        }
    }else if($inputData->type=="particular_date_detail_shop"){
        $selected_date            = $inputData->selected_date;
        $employee->selectedDate   = date("Y-m-d", strtotime($selected_date));
        $employee->employeeToken  = $inputData->employee_token;
        $employee->shopToken      = $inputData->shop_token;
        $employee->orderToken     = $inputData->order_token;

        $stmt = $employee->employeeDateItemDetailShop();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->data=[];
        }else{
            $obj->data = $employee->readEmployeeDateItemDetailShop($stmt);
        }
    }
    else if ($inputData->type=="visted") {
        $employee->date = $inputData->date;
        $employee->emp_token = $inputData->emp_token;
        $stmt = $employee->visitequery();
        if ($stmt->rowCount() > 0) {
            $obj->data = $employee->visitequeryread($stmt);
        }else{
            $obj->data=[];
        }
    }
    echo json_encode($obj);
//}

?>