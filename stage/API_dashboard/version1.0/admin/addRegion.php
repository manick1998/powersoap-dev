<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
include_once '../config/core.php';
$input_data = json_decode(file_get_contents("php://input"));
if($input_data->dashboard_code == $verification_code){
    $database = new Database();
    $db = $database->getConnection();
    $employee = new Employee($db);
    $obj = new stdClass;
        if($input_data->type == "All"){
            $stateId = $input_data->state_id;
            if($stateId != '0'){
                $stateQuery = " AND `region`.`state_id` IN ('".$stateId."')";
                $state_token = " AND `state_token` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
                $state_token = " ";
            }
            $employee->stateQuery = $stateQuery;   
            $employee->state_token = $state_token;   
            $array = $employee->getAllRegion();
            $array_region = $employee->getRegions();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->data_region = $array_region;
            $array_state = $employee->getAllStates();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Region List";
            $obj->data = $array;
            $obj->data_state = $array_state;
        }else if($input_data->type == "AddRegionName"){
            $employee->region_name = $input_data->region_name;
            $employee->state_token = $input_data->state_token;
            $res_region = $employee->regionExists();
            if($res_region->rowCount() == 0){
                $token = token_generate("region","token");
                $employee->token = $token;
                if($employee->addRegion($indiaDateTime)){
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Added New Region"; 
                }else{
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "Not Able To Add Region";
                } 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Region already exists on same state"; 
            }
        }else if($input_data->type == "UpdateRegionName"){
            $employee->region_token = $input_data->region_token;
            $employee->region_name = $input_data->region_name;
            $employee->state_token = $input_data->state_token;
            $res_region = $employee->regionExists();
            $regionCount = $res_region->rowCount();
            if($employee->updateRegionName($indiaDateTime) && $regionCount == 0){
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Updated Region Name"; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Not Able To Update Region Name";
                if ($regionCount!=0) {
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "Region Name Already Exist On Some State";
                }
            }
        }else if($input_data->type == "DeleteRegionName"){
            $employee->region_token = $input_data->region_token;
            if($employee->deleteRegion() ){
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Deleted Region Name"; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Not Able To Delete Region Name";
            }
        } else {
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "Provide the valid details for Region";
        }
echo json_encode($obj);
$db = null;
}

?>
