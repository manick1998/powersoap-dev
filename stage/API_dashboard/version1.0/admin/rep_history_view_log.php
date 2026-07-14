<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$input_data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$obj = new stdClass;
if ($input_data->type == "VisitShopLog") {
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
}else if($input_data->type == "SalesRepLocation"){
    $employee->employee_token = $input_data->employee_token;
    $date = $input_data->date;
     $stmt = $employee->getSalesRepVisitedLocation($date);
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
}
echo json_encode($obj);
?>