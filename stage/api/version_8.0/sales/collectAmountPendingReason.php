<?php
include "../../config.php";
$json_input = getInputs();
$employee_token = $json_input->employee_token;
$order_id  =$json_input->order_id;
$reason =$json_input->reason;
$date = $currnetDateTime;
$obj = new stdClass;
$collectAmountReason = mysqli_query($link,
    "SELECT
    `id`
FROM
    `orders__pendingreson`
WHERE
     `order_token` = '$order_id' AND `employee_token` = '$employee_token' AND `date_time` LIKE '%$indiaDate%'");

$check_status = mysqli_num_rows($collectAmountReason);

if($check_status > 0){
   $update = mysqli_query($link,"UPDATE `orders__pendingreson` SET `reson`='$reason' WHERE `order_token` = '$order_id' AND `employee_token` = '$employee_token' AND `date_time` LIKE '%$indiaDate%'");
}else{
   $insert =mysqli_query($link,"INSERT INTO `orders__pendingreson`(`date_time`, `order_token`, `reson`, `employee_token`) VALUES ('$currnetDateTime','$order_id','$reason','$employee_token')");
}

    if($update){
        $obj->status_code = 200;
        $obj->message = "Updated Successfully";
        $obj->header = "success";
    }else if($insert){
        $obj->status_code = 201;
        $obj->message = "Inserted Successfully";
        $obj->header = "success";
    }else{
        $obj->status_code = 400;
        $obj->message = "data not found";
        $obj->header = "Error";
    }
    echo json_encode($obj);
?>