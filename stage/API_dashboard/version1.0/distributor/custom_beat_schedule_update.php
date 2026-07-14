<?php
$obj=new stdClass();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';
include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$inputData = json_decode(file_get_contents("php://input"));
$salesmanExistArray = [];
$DelivertExistArray = [];
 $schedule->custom_beat_token = $inputData->custom_beat_token;
  $schedule->distributor_token = $inputData->distributor_token;
$array = $inputData->update_array;
$dateTime = new DateTime($indiaDateTime);
$formattedDate = $dateTime->format('Y-m-d');
$checkarrayCount = 0;
foreach($array as $value){
   // print_r($value);
    
       $schedule->day = $value->day_value; 
          $schedule->saleEmployee = $value->sale_employee; 
         $schedule->deliveryEmployee = $value->delivery_employee;
         
        $stmtSales  = $schedule->custom_sales_emp_check();
        $checkCountSales = $stmtSales->rowCount();
       
        
        $stmtDelivery  = $schedule->custom_delevery_emp_check();
        $checkCountDelivery = $stmtDelivery->rowCount();
        
        if($checkCountSales == 0 && $checkCountDelivery == 0){
            $checkarrayCount++;
            $stmt1       = $schedule->custom_dailyScheduleCheck();
            $checkCount = $stmt1->rowCount();

            //$checkCount;
            
            
            if($checkCount==0){
                $schedule->insert_Custom_DailySchedule($indiaDateTime);
            }else{
                $update = $schedule->update_Custom_DailySchedule($indiaDateTime);
                // if(!$update){
                    
                //     echo "something wrong";
                // }
                // else{
                //     echo "correct";
                // }

            }
            if(count($array) == $checkarrayCount){
               $obj->code = 200; 
            }
        }else{
            if($checkCountSales != 0){
                 while ($row = $stmtSales->fetch(PDO::FETCH_ASSOC)) {
                     $obj1 = new stdClass;
                     $obj1->unit_token = $row['custom_unit_name'];
                     $obj1->employee_name = $row['employee_name'];
                     $obj1->schedule_date = $row['schedule_date'];
                     array_push($salesmanExistArray, $obj1);
                 }  
            }
            if($checkCountDelivery != 0){
                 while ($row = $stmtDelivery->fetch(PDO::FETCH_ASSOC)) {
                     $obj2 = new stdClass;
                     $obj2->unit_token = $row['custom_unit_name'];
                     $obj2->employee_name = $row['employee_name'];
                     $obj2->schedule_date = $row['schedule_date'];
                     array_push($DelivertExistArray, $obj2);
                 } 
             }
              $obj->code    = 400;
              $obj->employee_data = array_merge($salesmanExistArray,$DelivertExistArray);
         }
}
echo json_encode($obj);
?>