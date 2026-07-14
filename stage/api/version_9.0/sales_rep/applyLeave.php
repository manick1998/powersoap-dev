<?php

include "../../config.php";
$json_input=getInputs();
$currentDate =$indiaDateTime;
$current =date("Y-m-d");
$sales_rep_token = $json_input->sales_rep_token;
$start_date = $json_input->start_date;
$end_date = $json_input->end_date;
$reason = $json_input->reason;
$token  = genToken('token','sales_rep__leave');

$newstartDate = date("Y-m-d", strtotime($start_date));  
$newendDate = date("Y-m-d", strtotime($end_date));

// $schedule = mysqli_query($link,"SELECT `id` FROM `schedule_sales_rep` WHERE `sales_rep_token`='$sales_rep_token' AND `schedule_date`='$current' AND `status`='1'");
// $count1=mysqli_num_rows($schedule);

$leave_check = mysqli_query($link,"SELECT `id` FROM `sales_rep__leave` WHERE `sales_rep_token`='$sales_rep_token' AND `start_date`='$newstartDate' AND `end_date`='$newendDate' AND `status`='1'");
$count = mysqli_num_rows($leave_check);


if($sales_rep_token && $count==0){
    $insert_leave = mysqli_query($link,"INSERT INTO `sales_rep__leave`(
        `token`,
        `sales_rep_token`,
        `date_time`,
        `start_date`,
        `end_date`,
        `reason`
    )
    VALUES('$token','$sales_rep_token','$indiaDateTime','$newstartDate','$newendDate','$reason')");
}


$obj = new stdClass;
		if($insert_leave) {
        $obj->status_code=200; 
        $obj->message='Data Inserted successfully';
        $obj->title='Success';
        $obj->data="";
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
    }


echo json_encode($obj);

?>