<?php 

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$obj = new stdClass;
date_default_timezone_set('Asia/Kolkata');
$beforemin = date('Y-m-d H:i',strtotime('-30 minutes'));
$date = date('Y-m-d H:i',strtotime('now'));
 if ($data->type == "custom_unit_summery") {
    if($data->from_date != '' && $data->to_date != ''){
        $fromdate = new DateTime($data->from_date);
        $formattedDate = $fromdate->format('Y-m-d');
        $todate = new DateTime($data->to_date);
        $toattedDate = $todate->format('Y-m-d');
        $dateQuery = "AND orders.date_time BETWEEN '$formattedDate 00:00:00' AND '$toattedDate 23:59:59'";
    }
    else{
        $dateQuery = "";
    }    
    $stmt = $emp->customEmployeeDailySummaryCheck($dateQuery);
    $count = $stmt->rowCount();
    if($count >0){
        $data = $emp->customreadEmployeeDailySummary($stmt);
        $obj->status_code = 200;
       $obj->header = "success";
       $obj->message = "success"; 
       $obj->data1 = $data ;
    }
    else{
      $obj->status_code = 400;
       $obj->header = "Error";
       $obj->message = "Custom Summery Report Not found"; 
       $obj->data1 = [];
   }
}
echo json_encode($obj);
?>