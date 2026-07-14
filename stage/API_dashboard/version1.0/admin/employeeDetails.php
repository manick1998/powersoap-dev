<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/employee.php';
    $employee = new Employee($db);
    // if($inputData->type=="count"){
    //     $stateId = $inputData->state_id;
    //         if($stateId != '0'){
    //             $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
    //         }else{
    //             $stateQuery = " ";
    //         }
    //     $employee->stateQuery    = $stateQuery;
        
    //     // Total Count
    //     $stmt=$employee->employeeDetailCheckCount();
        
    //     // Active Count Edukka
    //     $activeQuery = "SELECT `employees`.`id` 
    //     FROM `employees` 
    //     WHERE `delete_status`='1' AND `employees`.`area_token`!='' 
    //     AND `employees`.`deparment_token`='18028120' 
    //     AND `employees`.`block_status` = '1' $stateQuery"; // block_status = 1 for active
        
    //     $stmtActive = $db->prepare($activeQuery);
    //     $stmtActive->execute();
    //     $activeCount = $stmtActive->rowCount();
        
    //     $obj->code = 201;
    //     $obj->data = $stmt->rowCount();
    //     $obj->active_count = $activeCount; 

    // }

    if($inputData->type=="count"){
        $stateId = isset($inputData->state_id) ? $inputData->state_id : '0';
        $regionId = isset($inputData->region_id) ? $inputData->region_id : '';

        $stateQuery = " ";
        if($stateId != '0' && $stateId != ''){
            $stateQuery .= " AND `employees`.`state_id` IN ('".$stateId."') ";
        }
        if($regionId != '0' && $regionId != ''){
            $stateQuery .= " AND `employees`.`region_id` IN ('".$regionId."') ";
        }
        $employee->stateQuery = $stateQuery;
        
        // Total Count
        $stmt=$employee->employeeDetailCheckCount();
        
        $activeQuery = "SELECT `employees`.`id` 
        FROM `employees` 
        WHERE `delete_status`='1' AND `employees`.`area_token`!='' 
        AND `employees`.`deparment_token`='18028120' 
        AND `employees`.`block_status` = '1' $stateQuery"; 
        
        $stmtActive = $db->prepare($activeQuery);
        $stmtActive->execute();
        $activeCount = $stmtActive->rowCount();
        
        $obj->code = 201;
        $obj->data = $stmt->rowCount();
        $obj->active_count = $activeCount; 

    }
    
    
    else if($inputData->type=="all"){
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
        $employee->employeeToken= $inputData->employee_token; 
        $employee->indiaDate    = $indiaDate;
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
    $db = null;
}
?>