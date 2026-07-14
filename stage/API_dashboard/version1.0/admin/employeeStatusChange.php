<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
// if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee.php';
    $employee = new Employee($db);
    $employee->employeeToken = $inputData->employee_token;
    $employee->employee_name = $inputData->name;
    $employee->mobile_numbr = $inputData->mobile_numbr;
    $employee->employee_gmail = $inputData->gmail;
    $employee->employee_licens = $inputData->licens;
    $employee->admin_token = $inputData->admin_token;
    $division_areay = $inputData->division_token;
    $stmt = $employee->employeeCheckToken();
    $checkCount = $stmt->rowCount();
    if($checkCount==0){
        $employee->statusValue = $inputData->employee_status;
        $employee->employeeStatusUpdate();
        // foreach ($division_areay as $division_token) {
        //     $employee->employeeStatusUpdate_log($indiaDateTime,$division_token);
        // }
        $employee->addEmployee_log_status($indiaDateTime,$division_areay);

    }
    $obj->code=201;
    $obj->message = "Success";
    echo json_encode($obj);
    $db = null;

//}
?>