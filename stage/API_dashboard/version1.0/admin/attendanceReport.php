<?php
## oops conncetivity
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
//$inputData->dashboard_code = $verification_code;
// if($inputData->dashboard_code == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    $order->toDate    = $inputData->toDate;
    $order->fromDate     =  $inputData->fromDate; 
    $order->salesRep     = $inputData->salesRep;
    $stmt = $order->attendanceReport($indiaDate); 
    $data = $order->readAttendanceReport($stmt);
    if(count($data)>0){
        $order->toDate    = $inputData->toDate;
        $order->fromDate     =  $inputData->fromDate; 
        $order->salesRep     = $inputData->salesRep;
        $stmt1 = $order->attendance_leave_Report(); 
        // echo 'count',$stmt1->rowCount();
        // if ($stmt1->rowCount()>0) {
        //     # code...
        // }
        $stmt2 = $order->attendance_leave_Report_read($stmt1);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "List show updated"; 
        $obj->data = $data;
        $obj->data1 = $stmt2;
    }else{
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Error"; 
    }
    echo json_encode($obj);
//}
?>

