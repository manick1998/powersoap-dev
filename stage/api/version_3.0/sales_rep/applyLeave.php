<?php

include "../../config.php";
$json_input=getInputs();
$currentDate =$indiaDateTime;
$sales_rep_token = $json_input->sales_rep_token;
$start_date = $json_input->start_date;
$end_date = $json_input->end_date;
$reason = $json_input->reason;
$token  = genToken('token','sales_rep__leave');

$newstartDate = date("Y-m-d", strtotime($start_date));  
$newendDate = date("Y-m-d", strtotime($end_date));  


if($sales_rep_token){
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