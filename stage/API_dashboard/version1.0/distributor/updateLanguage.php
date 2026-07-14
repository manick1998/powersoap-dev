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
    $employee->employeeToken = $inputData->distributor_token;
    $employee->languageValue = $inputData->language;
    
    if($employee->updateLanguage()){
        $_SESSION['language'] = $inputData->language;
        $obj->code = 200;
        $obj->message = "Language updated successfully";
    } else {
        $obj->code = 400;
        $obj->message = "Failed to update language";
    }
    echo json_encode($obj);
}
?>
