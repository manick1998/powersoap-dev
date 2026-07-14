<?php
include "../../config.php";
$json_data = getInputs();
$current_date = $indiaDateTime;
$current = $indiaDate;
$sales_rep_token = $json_data->sales_rep_token;
$token = $json_data->token;
$amount = $json_data->amount;
$category_module = $json_data->category_module;
$image = $json_data->image;
$imageList = [];
foreach($image as $value){
    array_push($imageList,$value);
}
$imageData = implode(",",$imageList);

if($sales_rep_token){
    $update_expense = mysqli_query($link,"UPDATE
    `sales_rep__expense__details`
SET
    `amount` = '$amount',
    `category_module` = '$category_module',
    `image` = '$imageData',
    `date_time` = '$indiaDateTime'
WHERE
    `sales_rep__token` = '$sales_rep_token' AND `token` = '$token' AND DATE(`date_time`) = '$current'");
}
$obj = new stdClass;
if($update_expense){
    $obj->status_code=200; 
    $obj->message='updated';
    $obj->title='Success';
    $obj->data='';
} else {
    $obj->status_code=400; 
    $obj->message='expense not updated';
    $obj->title='Failed';
    
}

echo json_encode($obj);



?>