<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$employee = new Employee($db);
    $employee->sales_rep_token = $inputData->sales_rep_token;
    $employee->start_date             = $inputData->start_date;
    $employee->end_date               =$inputData->end_date;
    $employee->admin_token               =$inputData->admin_token;
    $employee->reason = $inputData->reason;
    $employee->leave_shift = $inputData->leave_shift;
        $token                    = $employee->leaveTokenGenerate();
        $employee->token = $token;
        // $check = $employee->scheduleCheck();
        // $count = $check->rowCount();
        $leavecheck =$employee->leaveCheck();
        $count1 = $leavecheck->rowCount();
        if($count1==0){
               $insert = $employee->insertLeave($indiaDateTime);
               $employee->insertleaveLog($indiaDateTime);
               if($insert){
                $obj->code   = 201;
                $obj->message= "Success";
        }else{
            $obj->code   = 400;
            $obj->message= "data not inserted";
        }
    }else{
        $obj->code   = 400;
        $obj->message= "can't apply leave already scheduled";
    }
    
   echo json_encode($obj); 
   $db = null;


?>