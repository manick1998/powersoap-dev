<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';
//include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$input = json_decode(file_get_contents("php://input"));
$obj=new stdClass();
$schedule->distributor_token = $input->distributor_token;
$array=[];
$startDay = "sunday";
for($i=1;$i<=7;$i++){
    $obj1=new stdClass();
    $nextDay  = date('l', strtotime($startDay . " +$i day"));
    $obj1->day_val = $nextDay;
     $schedule->custom_beat_token = $input->custom_beat_token;
     $schedule->day     = $nextDay;
    //return;
    $stmt = $schedule->custom_scheduledEmployeeCheck();
    $checkCount = $stmt->rowCount();
            if($checkCount==0){
                $obj1->sales_employee_token   = "";
                $obj1->delivery_employee_token= "";
            }else{
                $objToken = $schedule->custom_readEmpToken($stmt);
                $obj1->sales_employee_token   = $objToken->sales_emp_token;
                $obj1->delivery_employee_token= $objToken->delivery_emp_token;
            }
            array_push($array,$obj1);
}
        $stmt = $schedule->salesEmployeeCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $salesData=[];
        }else{
            $salesData = $schedule->readSalesemployee($stmt);
        }
        $stmt       = $schedule->deliveryEmployeeCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $deiveryData=[];
        }else{
            $deiveryData = $schedule->readSalesemployee($stmt);
        }
        $obj->code        = 201;
        $obj->data1        = $array;
        $obj->salesData   = $salesData;
        $obj->deliveryData= $deiveryData;
    
echo json_encode($obj);
?>