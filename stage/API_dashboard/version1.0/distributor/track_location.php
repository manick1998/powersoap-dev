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
    $employee->employee_token = $inputData->employee_token;
    if($inputData->type == 'TrackLocation'){
        $stmt = $employee->getEmployeeLocation();
        $checkCount = $stmt->rowCount();
        if($checkCount > 0){
            $data = $employee->viewEmployeeLocation($stmt);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Employee Location"; 
            $obj->data = $data;
        }else{
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Employee Not Available"; 
        }
    }else if($inputData->type == 'VisitShopLog'){
        $stmt1 = $employee->getVisitedShopLog();
        $checkCount = $stmt1->rowCount();
        if($checkCount > 0){
            $data = $employee->viewVisitedShopLog($stmt1);
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Employee Location"; 
            $obj->data = $data;
        }else{
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "No Shop List Found"; 
        }
    }
    
echo json_encode($obj);
}
?>