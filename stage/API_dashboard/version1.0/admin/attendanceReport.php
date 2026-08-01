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
    // get schedule-based attendance
    $stmt = $order->attendanceReport($indiaDate);
    $data = $order->readAttendanceReport($stmt);

    // get order-based presence (treat as present if they have orders that day)
    $order->toDate    = $inputData->toDate;
    $order->fromDate  = $inputData->fromDate;
    $order->salesRep  = $inputData->salesRep;
    $stmt_orders = $order->orderPresenceReport();
    $data_orders = $order->readOrderPresence($stmt_orders);

    // merge schedule and order presence, preferring schedule data when duplicate
    $merged_map = array();
    foreach ($data as $row) {
        $merged_map[$row['date']] = $row;
    }
    foreach ($data_orders as $row) {
        if (!isset($merged_map[$row['date']])) {
            $merged_map[$row['date']] = $row;
        }
    }
    $merged = array_values($merged_map);

    // fetch leave info
    $stmt1 = $order->attendance_leave_Report();
    $stmt2 = $order->attendance_leave_Report_read($stmt1);

    if (count($merged) > 0) {
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "List show updated";
        $obj->data = $merged;
        $obj->data1 = $stmt2;
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "No records found";
    }
    echo json_encode($obj);
//}
?>

