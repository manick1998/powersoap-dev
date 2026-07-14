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
        $token   = $employee->tokenGenerate();
        $employee->token  = $token;
        $employee->distributor_token=$inputData->distributor_token;
        $employee->bank_name = $inputData->bank_name;
        $employee->account_number       = $inputData->account_number;
        $employee->bank_code = $inputData->bank_code;
        $employee->holder_name = $inputData->holder_name;
        $employee->gpay = $inputData->gpay;
        $employee->paytm = $inputData->paytm;
        if($inputData->bank_name != '' && $inputData->account_number != '' && $inputData->bank_code != '' && $inputData->holder_name!='' && $inputData->gpay != '' && $inputData->paytm != '' ){
            $insert = $employee->editPaymentDetails($indiaDateTime);
            $obj->code=200;
            $obj->message="Success"; 
        }else{
            $obj->code=500;
            $obj->message="error";  
        }
        echo json_encode($obj);
           
}
?>