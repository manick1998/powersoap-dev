<?php
// required headers
ini_set('display_errors', 1);
error_reporting(E_ALL);
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
   
        if($input_data->type == "count_check"){
            $stmtrep = $employee->salesRepCount();
            $num_count = $stmtrep->rowCount();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Region List";
            $obj->data = $num_count;
        }else if($input_data->type == "AllSalesRep"){
            $stateId = $input_data->state_id;
            if($stateId != '0'){
                $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
            }
            $employee->stateQuery = $stateQuery; 
            $stmt = $employee->serverSalesRepCheck();
            $nums = $stmt->rowCount();
            if($nums > 0){
                $data = $employee->readSalesRepCheck($stmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Added New Region"; 
                $obj->data = $data; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Sales Rep not available";
            } 
       }else if($input_data->type == "AddNewSalesRep"){
            $employee->mobileNumber = $input_data->sales_rep_mobilenumber;
            $stmt_mobile = $employee->employeeMobileNumberCheck();
            $checkCountMobileNo = $stmt_mobile->rowCount();

            $employee->emaiId = $input_data->sales_rep_mailid;
            $stmt_emaiId = $employee->emailValidation();
            $checkCountemaiId = $stmt_emaiId->rowCount();

            if ($checkCountMobileNo==0 && $checkCountemaiId==0) {
                $token = token_generate("employees","token");
                $employee->token = $token;
                $employee->employee_code = 'REP'.$token;
                $employee->sales_rep_name = $input_data->sales_rep_name;
                $employee->sales_rep_mailid = $input_data->sales_rep_mailid;
                $employee->region_token = $input_data->region_token;
                $employee->state_token = $input_data->state_token;
                $employee->salesrep_image=$input_data->salesrep_image;
                $employee->rolls_token = $input_data->rolls_token;
                $employee->admin_token = $input_data->admin_token;
                if($employee->insertNewSalesRep($indiaDateTime)){
                    $employee->insertSalesRepLog($indiaDateTime);
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Added Sales Rep Successfully"; 
                }else{
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "Not Able To Add Sales Rep";
                }
            }else{
                if($checkCountMobileNo!=0){
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message="Mobile Number already exist!";
                }
                if($checkCountemaiId!=0){
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message="Email Id already exist!";
                }
            }
        }else if($input_data->type == "SelectSingleSalesRep"){
            $employee->employee_token = $input_data->employee_token;
            $stmtsales = $employee->selectSingleSalesRep();
            if($stmtsales->rowCount() > 0){
                $array = $employee->readSingleSalesRep($stmtsales);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Sales Rep"; 
                $obj->data = $array;
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Not Able To select Sales Rep";
            }
        }else if($input_data->type == "UpdateSalesRep"){
            $employee->mobileNumber = trim($input_data->sales_rep_mobilenumber);
            $employee->token = $input_data->sales_rep_token;
            $stmt_mobile = $employee->employeeUpdateMobileNumberCheck();
            $checkCountMobileNo = $stmt_mobile->rowCount();

            $employee->emaiId = $input_data->sales_rep_mailid;
            $employee->token = $input_data->sales_rep_token;
            $stmt_emaiId = $employee->employeeUpdateEmailCheck();
            $checkCountemaiId = $stmt_emaiId->rowCount();

            if($checkCountMobileNo ==0 && $checkCountemaiId== 0){
                $employee->sales_rep_name = $input_data->sales_rep_name;
                $employee->region_token = $input_data->region_token;
                $employee->sales_rep_mailid = $input_data->sales_rep_mailid;
                $employee->state_token = $input_data->state_token;
                $employee->employee_image=$input_data->employee_image;
                $employee->rolls_token = $input_data->rolls_token;
                $employee->admin_token = $input_data->admin_token;
                
                // ⬇️ HERE IS THE FIX: BINDING RESIGNATION DATE ⬇️
                $employee->resignation_date = isset($input_data->resignation_date) ? $input_data->resignation_date : null;

                $stmt1 = $employee->fetchDetails();
                $data = $employee->readfetchDetails($stmt1);
                $employee->old_name = $data->old_name;
                $employee->old_mobile=$data->old_mobile;
                if($employee->updateSalesRep()){
                    if($data->old_mobile!=$input_data->sales_rep_mobilenumber || $data->old_name!=$input_data->sales_rep_name){
                        $employee->updateSalesRepLog($indiaDateTime);
                    }
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Sales Rep Updated"; 
                }else{
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "Not Able To update Sales Rep";
                }
            }else{
                if($checkCountMobileNo!=0){
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message="Mobile Number already exist!";
                }
                if($checkCountemaiId!=0){
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message="EmailId already exist!";
                }
            }
        }else if($input_data->type == "SalesRepLocation"){
               $employee->employee_token = $input_data->employee_token;
                $stmt = $employee->getSalesRepVisitedLocation();
                $checkCount = $stmt->rowCount();
                if($checkCount > 0){
                    $data = $employee->viewSalesRepVisitedLocation($stmt);
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Sales Rep Visied Location"; 
                    $obj->data = $data;
                }else{
                    $obj->status_code = 400;
                    $obj->header = "Error";
                    $obj->message = "Not Found Sales Rep Visited Location"; 
                }
        }else if($input_data->type =="VisitShopLog"){
            $employee->employee_token = $input_data->employee_token;
            $date = $input_data->date;
            $stmt1 = $employee->getVisitedShopLog($date);
            $checkCount = $stmt1->rowCount();
            if($checkCount > 0){
                $data = $employee->viewVisitedShopLog($stmt1);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Sales Rep Daily Log"; 
                $obj->data = $data;
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Not Available Sales Rep Log"; 
            }
        }
        else if($input_data->type =="designation") {
           $stmt = $employee->rollFunction();
           $count =$stmt->rowCount();
           if ($count > 0) {
                $roll_data = $employee->rollslist($stmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "rolls list"; 
                $obj->rollsdata = $roll_data;
           }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "rolls list data not found"; 
           }
        }
        else if($input_data->type == "block_unblock") {
           
            $employee->employee_token = $input_data->employee_token;
            $employee->block_status = $input_data->block_status;
            if($employee->blockUnblockSalesRep()){
                $employee->updateBlockSalesRepLog($indiaDateTime);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Sales Rep Block/Unblock Successfully"; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Not Able To Block/Unblock Sales Rep";
            }
        }
        else{
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "Provide the valid details for Region";
        }

echo json_encode($obj);
$db = null;
}
?>