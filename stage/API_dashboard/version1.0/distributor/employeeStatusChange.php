<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee_distributor.php';
    $employee = new Employee($db);
    $employee->employeeToken = $inputData->employee_token;
    $stmt = $employee->employeeCheckToken();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $employee->statusValue = $inputData->employee_status;
        $employee->employeeStatusUpdate();
    }
    $obj->code=201;
    $obj->message = "Success";
    echo json_encode($obj);
}
?>