<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
include_once '../config/core.php';
$input_data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$obj = new stdClass;
date_default_timezone_set('Asia/kolkata');
$date = date("Y-m-d");
if($input_data->type == 'salesRep'){
    $stmt = $employee->serverSalesRepCheck();
    $nums = $stmt->rowCount();
    if($nums > 0){
        $data = $employee->readSalesRepCheck($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Data listed"; 
        $obj->data = $data; 
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Sales Rep not available";
    }
}else if($input_data->type == 'allstate'){
    $stmt1 = $employee->selectAllState();
    $state = $employee->fetchState($stmt1);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $state; 
}else if($input_data->type == 'allregion'){
    $stmt1 = $employee->selectAllRegion();
    $region = $employee->fetchAllRegion($stmt1);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $region; 
}else if($input_data->type == 'allareas'){
    $stmt1 = $employee->selectAllAreas();
    $area = $employee->fetchAllAreas($stmt1);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $area; 
}else if($input_data->type == 'alldistributor'){
    $stmt1 = $employee->area_distributors();
    $dist = $employee->fetchAll($stmt1);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $dist;
}else if($input_data->type == 'stateToken'){
    $employee->stateToken = $input_data->stateToken;
    $stmt = $employee->selectRegion();
    $region = $employee->fetchRegion($stmt);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $region; 
}else if($input_data->type == 'regionToken'){
    $employee->regionToken = $input_data->regionToken;
    $stmt = $employee->selectArea();
    $area = $employee->fetchArea($stmt);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $area; 
}else if($input_data->type == 'areaToken'){
    $employee->regionToken = $input_data->regionToken;
    $stmt = $employee->selectAreaDist();
    $dist = $employee->fetchAreaDist($stmt);
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->data = $dist; 
}else if($input_data->type == 'scheduleSaleRep'){
    $employee->sales_rep_name = $input_data->sales_rep_name;
    $date = $input_data->date;
    $employee->travelAllowance=$input_data->travelAllowance;
    $time = strtotime($date);
    $newformat = date('Y-m-d',$time);
    $employee->schedule_date = $newformat;
    // $employee->schedule_date = date("Y-m-d", strtotime($date));
    $employee->regionToken = $input_data->regionToken;
    $employee->stateToken = $input_data->stateToken;

    $employee->areaToken = $input_data->areaToken;
    $employee->areaDisToken =$input_data->areaDisToken;
    $schedule_token = $employee->tokenGenerate();
    $employee->schedule_token = $schedule_token;
    $stmt = $employee->checkSchedule();
    $count = $stmt->rowCount();
    if($count == 0){
        $schedule = $employee->sales_rep_schedule($schedule_token,$indiaDateTime);
        if ($schedule) {
            $insert = $employee->salesRepschedule($indiaDateTime);
            if($insert){
                $obj->status_code = 200;
                $obj->message = "Success";
            }else{
                $obj->status_code = 400;
                $obj->message = "oops";
            }
        }
        else{
            
            $obj->code=401;
            $obj->message="File";
        }
       
    }
    else{
        $obj->status_code = 400;
        $obj->message = "Already scheduled or Leave Applied";
    }
    
}else if($input_data->type == "AlltodayScheduledSalesRep"){
            $stateId = $input_data->state_id;
            if($stateId != '0'){
                $stateQuery = " AND `employees__state`.`state_token` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
            }
            $employee->stateQuery = $stateQuery; 
            $stmt = $employee->todayallScheduledSaleRep();
            $nums = $stmt->rowCount();
            if($nums > 0){
                $data = $employee->fetchtodayAllScheduledSaleRep($stmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Data listed"; 
                $obj->data = $data; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Sales Rep not available";
            } 
}else if($input_data->type == "AllScheduledSalesRep"){
    $stateId = $input_data->state_id;
    $from_date =$input_data->from_date;
    $to_date = $input_data->to_date;
    
    if($stateId != '0'){
        $stateQuery = " AND `employees__state`.`state_token` IN ('".$stateId."')";
    }else{
        $stateQuery = " ";
    }
    $dateQuery = " ";
    if($from_date!="" && $to_date!=""){
        $dateQuery = " AND ( 
            `schedule_sales_rep`.`schedule_date` BETWEEN '".$from_date."' AND '".$to_date."'
        ) ";
    }   
    $employee->stateQuery = $stateQuery; 
    $employee->dateQuery=$dateQuery;
    $stmt = $employee->allScheduledSaleRep();
    $nums = $stmt->rowCount();
    if($nums > 0){
        $data = $employee->fetchAllScheduledSaleRep($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Data listed"; 
        $obj->data = $data; 
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Sales Rep not available";
    } 
}else if($input_data->type == "repAreas"){
    $employee->salesReoToken = $input_data->salesReoToken;
    $date = $input_data->date;
    $time = strtotime($date);
    $newformat = date('Y-m-d',$time);
    $employee->schedule_date = $newformat;
    $area_module = $employee->salesRepArea();
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "data List";
    $obj->data = $area_module;
}else if($input_data->type == "updateScheduleSaleRep"){
    //  $settime  = strtotime('10:00am');
    //   $time = time();
    // if($indiaDate >= $input_data->date && time() >= $settime){
    //     $obj->status_code = 400;
    //     $obj->header = "Error";
    //     $obj->message = "Time out";
   // }else{
        $employee->salesRepToken = $input_data->salesRepToken;
        $date = $input_data->date;
        $time = strtotime($date);
        $newformat = date('Y-m-d',$time);
        $employee->schedule_date = $newformat;
        $employee->travelAllowance = $input_data->travelAllowance;
        $employee->stateToken = $input_data->stateToken;
        $employee->regionToken = $input_data->regionToken;
        $employee->areaToken = $input_data->areaToken;
        $employee->areaDisToken=$input_data->areaDisToken;
        $rep_schedule_token = $input_data->rep_schedule_token;
        $employee->rep_schedule_token = $rep_schedule_token;
        //echo  'edit',$schedule_token;
        $update_status = $employee->updateSalesRepStatus();    
        if($update_status == true){
            $updateSchedule = $employee->updateSalesRepSchedule($indiaDateTime);
            if($updateSchedule){
                $obj->status_code = 200;
                $obj->header = "Success";
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "data not inserted";
            }
        }else{
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "something went wrong";
        } 
//    //}
}else if($input_data->type == "rep_requeast"){
    $stmt = $employee->sales_rep_req($date);  
    $count = $stmt->rowCount();
    if($count > 0){
        $data = $employee->sales_rep_req_list($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Data listed"; 
        $obj->rq_data = $data; 
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Sales Rep not available";
    } 
}else if($input_data->type == "rep_requeast_details"){

    $employee->salesReoToken = $input_data->salesReoToken;
    date_default_timezone_set('Asia/kolkata');
    $timestamp = date("Y-m-d");
    $stmt = $employee->sales_rep_req_details($timestamp);  
    $count = $stmt->rowCount();
    if($count > 0){
        $data = $employee->sales_rep_req_details_list($stmt);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "sales_rep_req_details listed"; 
        $obj->rq_data = $data; 
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "sales_rep_req_details not available";
    } 
}else if($input_data->type == "status_updated"){
    $employee->status_change_value = $input_data->status_change_value;
    $employee->schedule_token = $input_data->schedule_token;
    $employee->sales_rep_token = $input_data->sales_rep_token;
    $employee->distributor_token = $input_data->distributor_token;
    $stmt = $employee->schedul_status_update();
    if ($stmt) {
        $stmt = $employee->schedule_sales_rep_status_update();
        $obj->code = 200;
        $obj->header = "Success";
    }
    else{
        $obj->code = 400;
        $obj->header = "Error";
    }
}

echo json_encode($obj);
$db = null;

?>