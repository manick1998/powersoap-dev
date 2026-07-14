<?php
$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    $checkarrayCount = 0;
    include_once '../objects/schedule_distributor.php';
    $schedule = new Schedule($db);
    $salesmanExistArray = [];
    $DelivertExistArray = [];
    $schedule->token = $inputData->unit_token;
    $schedule->distributor_token = $inputData->distributor_token;
    $array = $inputData->update_array;
    foreach($array as $value){
         $schedule->day = $value->day_value; 
         $schedule->saleEmployee = $value->sale_employee; 
         $schedule->deliveryEmployee = $value->delivery_employee;
        $stmtSales  = $schedule->checkSalesmanAssign();
        $checkCountSales = $stmtSales->rowCount();
        $stmtDelivery  = $schedule->checkDeliveryAssign();
        $checkCountDelivery = $stmtDelivery->rowCount();
        if($checkCountSales == 0 && $checkCountDelivery == 0){
            $checkarrayCount++;
            $stmt       = $schedule->dailyScheduleCheck();
            $checkCount = $stmt->rowCount();
            if($checkCount==0){
                $schedule->insertDailySchedule($indiaDateTime);
            }else{
                $schedule->updateDailySchedule($indiaDateTime);
            }
            if(count($array) == $checkarrayCount){
               $obj->code = 200; 
            }
        }else{
           if($checkCountSales != 0){
                while ($row = $stmtSales->fetch(PDO::FETCH_ASSOC)) {
                    $obj1 = new stdClass;
                    $obj1->unit_token = $row['unit_name'];
                    $obj1->employee_name = $row['employee_name'];
                    $obj1->schedule_date = $row['schedule_date'];
                    array_push($salesmanExistArray, $obj1);
                }  
           }
           if($checkCountDelivery != 0){
                while ($row = $stmtDelivery->fetch(PDO::FETCH_ASSOC)) {
                    $obj2 = new stdClass;
                    $obj2->unit_token = $row['unit_name'];
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
}
?>