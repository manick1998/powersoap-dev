<?php

include "../../config.php";
$json_input=getInputs();
$obj = new stdClass;
$currentDate =$indiaDateTime;
$schedule_date =$indiaDate;
$sales_rep_token = $json_input->sales_rep_token;
$region_name=$json_input->region_name;
$area_name=$json_input->area_name;
$distributor_name=$json_input->distributor_name;

//schedule_token
$sql=mysqli_query($link,"SELECT  `rep_schedule_token` FROM `schedule_sales_rep` WHERE `sales_rep_token`='$sales_rep_token' AND `schedule_date`='$schedule_date'");
$row = mysqli_fetch_array($sql);
$schedule_token = $row["rep_schedule_token"];


//state_token
$sql1=mysqli_query($link,"SELECT  `state_id` FROM `region` WHERE `region_name`='$region_name'");
$row1 = mysqli_fetch_array($sql1);
$state_token = $row1["state_id"];


//region_token
$sql4=mysqli_query($link,"SELECT  `token` FROM `region` WHERE `region_name`='$region_name'");
$row4 = mysqli_fetch_array($sql4);
$region_token = $row4["token"];


//area_token
$sql2=mysqli_query($link,"SELECT  `area_token` FROM `area` WHERE `area_name`='$area_name'");
$row2 = mysqli_fetch_array($sql2);
$area_token = $row2["area_token"];

//distributor_token
$sql3=mysqli_query($link,"SELECT  `token` FROM `employees` WHERE `name`='$distributor_name'");
$row3= mysqli_fetch_array($sql3);
$distributor_token = $row3["token"];

$insert = mysqli_query($link,"INSERT INTO `schedule_sales_rep`(
    `rep_schedule_token`,
    `sales_rep_token`,
    `schedule_date`,
    `state_token`,
    `region_token`,
    `area_token`,
    `distributor_token`,
    `date_time`,
    `status`
)
VALUES('$schedule_token','$sales_rep_token','$schedule_date','$state_token','$region_token','$area_token','$distributor_token','$currentDate','2')");

$insert_request = mysqli_query($link,"INSERT INTO `schedule_salesRep_request`(
    `schedule_token`,
    `sales_rep_token`,
    `distributor_token`,
    `status`
)
VALUES('$schedule_token','$sales_rep_token','$distributor_token','0')");


if($insert) {
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