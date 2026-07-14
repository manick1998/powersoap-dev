<?php
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
if($input_data->type == "Allexpense"){
            $stateId = $input_data->state_id;
            $from_date=$input_data->from_date;
            $to_date = $input_data->to_date;
            $salesRep = $input_data->salesRep;
            if($stateId != '0'){
                $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
            }else{
                $stateQuery = " ";
            }
            $salesQuery='';
            if($salesRep != ''){
                $salesQuery = " AND `sales_rep__expense__details`.`sales_rep__token` IN ('".$salesRep."')";
            }else{
                $salesQuery = " ";
            }
            $dateQuery = " ";
            if($from_date!="" && $to_date!=""){
                $dateQuery = "AND date(`sales_rep__expense__details`.`date_time`) BETWEEN '".$from_date."' AND '".$to_date."'";
            }   
            $employee->stateQuery = $stateQuery;
            $employee->salesQuery = $salesQuery;
            $employee->dateQuery=$dateQuery; 
            $stmt = $employee->expensemangement();
            $nums = $stmt->rowCount();
            if($nums > 0){
                $data = $employee->readexpenseMangement($stmt);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Data listed"; 
                $obj->data = $data; 
            }else{
                $obj->status_code = 400;
                $obj->header = "Error";
                $obj->message = "Sales Rep not available";
            } 
}
echo json_encode($obj);
$db = null;

?>