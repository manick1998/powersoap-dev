<?php

include "../../config.php";
$json_input=getInputs();
$currentDate =$indiaDate;
$sales_rep_token = $json_input->sales_rep_token;
$token = $json_input->expense_token;

if($token){
    $update_expense = mysqli_query($link,"UPDATE
    `sales_rep__expense__details`
SET
    `status` = '2'
WHERE
    `sales_rep__token` = '$sales_rep_token' AND `token` = '$token' AND  date(`date_time`)='$currentDate'");
}
$obj = new stdClass;
		if($update_expense) {
        $obj->status_code=200; 
        $obj->message='Data updated successfully';
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