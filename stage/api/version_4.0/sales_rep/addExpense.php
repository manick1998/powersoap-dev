<?php
include "../../config.php";
$json_input=getInputs();
$current =$indiaDate;
$currentDate =$indiaDateTime;
$sales_rep_token = $json_input->sales_rep_token;
$category_module = $json_input->category_module;
$amount = $json_input->amount;
$image = $json_input->image;
$expense_token = $json_input->expense_token;
$token  = genToken('token','sales_rep__expense__details');
$cattoken  = genToken('category_token','sales_rep__expense__details');

$sql=mysqli_query($link,"SELECT  `rep_schedule_token` FROM `schedule_sales_rep` WHERE `sales_rep_token`='$sales_rep_token' and date(date_time)='$indiaDate'");
$row = mysqli_fetch_array($sql);
$schedule_token = $row["rep_schedule_token"];

$imageList = [];
foreach($image as $key => $value){
    array_push($imageList,$value);
}
$imageData = implode(",",$imageList);

if($sales_rep_token && $expense_token!=''){
    $update_expense = mysqli_query($link,"UPDATE
    `sales_rep__expense__details`
SET
    `amount` = '$amount',
    `category_module` = '$category_module',
    `image` = '$imageData',
    `date_time` = '$indiaDateTime'
WHERE
    `sales_rep__token` = '$sales_rep_token' AND `token` = '$expense_token' AND DATE(`date_time`) = '$current'");
}else{
if($sales_rep_token && $schedule_token!=""){
 $insert_expense = mysqli_query($link,"INSERT INTO `sales_rep__expense__details`(
        `token`,
        `category_token`,
        `sales_rep__token`,
        `date_time`,
        `category_module`,
        `amount`,
        `image`,
        `status`
    )
    VALUES('$token','$cattoken','$sales_rep_token','$currentDate','$category_module','$amount','$imageData','1')");
}
}
$obj = new stdClass;
		if($schedule_token) {
        $obj->status_code=200; 
        $obj->message='Data Inserted successfully';
        $obj->title='Success';
        $obj->data="";
    }else if($update_expense){
        $obj->status_code=200; 
        $obj->message='Data Updated successfully';
        $obj->title='Success';
        $obj->data="";
    }
    else {
        $obj->status_code=400; 
        $obj->message='Today schedule not assign';
        $obj->title='error';
    }
echo json_encode($obj);

?>