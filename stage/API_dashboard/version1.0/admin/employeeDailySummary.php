<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
 //if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee.php';
    $employee = new Employee($db);
if($inputData->type=="particular_date_detail"){
        $selected_date            = $inputData->selected_date;
        $employee->selectedDate   = date("Y-m-d", strtotime($selected_date));
        $employee->employeeToken  = $inputData->employee_token;
        $stmt=$employee->employeeDateDetail();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->data=[];
        }else{
            $obj->data = $employee->readEmployeeDateDetail($stmt);
        }
        $stmt = $employee->employeeDateItemDetail();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->data_item=[];
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
    else if($inputData->type =="visted") {
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
    $db = null;

//}
?>