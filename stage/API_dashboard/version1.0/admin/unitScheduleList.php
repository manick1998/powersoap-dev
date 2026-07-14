<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/schedule.php';
    $schedule = new Schedule($db);
    if($inputData->type=="schedule_list"){
        $array = [];
        $startDay  = "Sunday";
        for($i=1;$i<=7;$i++){
            $nextDay  = date('l', strtotime($startDay . " +$i day"));
            $obj1=new stdClass();
            $obj1->sl_no   = $i;
            $obj1->day_val = $nextDay;
            $schedule->token   = $inputData->unit_token;
            $schedule->day     = $nextDay;
            $stmt       = $schedule->scheduledEmployeeCheck();
            $checkCount = $stmt->rowCount();
            if($checkCount==0){
                $obj1->sales_employee_token   = "";
                $obj1->delivery_employee_token= "";
            }else{
                $objToken = $schedule->readEmpToken($stmt);
                $obj1->sales_employee_name    = $objToken->sales_emp_name;
                $obj1->sales_employee_token   = $objToken->sales_emp_token;
                $obj1->delivery_employee_name = $objToken->delivery_emp_name;
                $obj1->delivery_employee_token= $objToken->delivery_emp_token;
                
            }
            array_push($array,$obj1);
        }
        $stmt       = $schedule->salesEmployeeCheck();
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
        $obj->data        = $array;
        $obj->salesData   = $salesData;
        $obj->deliveryData= $deiveryData;
    }
    echo json_encode($obj);
}
?>