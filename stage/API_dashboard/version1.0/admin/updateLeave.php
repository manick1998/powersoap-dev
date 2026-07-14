<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$employee = new Employee($db);
    $employee->token = $inputData->token;
    $employee->sales_rep_token = $inputData->sales_rep_token;
    $employee->admin_token = $inputData->admin_token;
    $employee->leave_status = $inputData->leave_status;
        $insert = $employee->updateLeave($indiaDateTime);
        $logInsert =$employee->leaveLog($indiaDateTime);
        if($insert){
                $obj->code   = 201;
                $obj->message= "Success";
        }else{
            $obj->code   = 400;
            $obj->message= "data not inserted";
        }
   echo json_encode($obj); 
   $db = null;


?>