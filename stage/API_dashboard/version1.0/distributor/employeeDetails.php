<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee_distributor.php';
    $distributor_token = $inputData->distributor_token;
    $employee = new Employee($db);
    $employee->distributor_token = $distributor_token;
    if($inputData->type=="all"){
        $stmt=$employee->employeeDetailCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $employee->readEmployeeDetails($stmt);
        }
    }else{
        $employee->employeeToken=$inputData->employee_token;    
        $stmt=$employee->employeeDetailCheckSingle();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $employee->readEmployeeDetailsSingle($stmt);
        }
    }
    echo json_encode($obj);
}
?>