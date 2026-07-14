<?php
include "../../config.php";
$json_input = getInputs();
$currnetDateTime = $indiaDateTime;
$indiaDate     = date("Y-m-d");
$sales_rep_employee_id = $json_input->sales_rep_employee_id;
$token  = genToken('token','employees');
$employee_code =  genToken('employees_code','employees');
$employees_code = "DIST".$employee_code;

$profile_image = $json_input->profile_image;
$distributor_name = $json_input->name;
$mobile_number = $json_input->number;
$email_address = $json_input->email_address;
$joining_date = $json_input->joining_date;
$gst_number = $json_input->gst_number;
$region = $json_input->region;
$state = $json_input->state;
$area = $json_input->area;
$division_data = $json_input->division;
$date = $currnetDateTime;
$address_proof=$json_input->address_proof;
$address=$json_input->address;
$city=$json_input->city;
$pincode=$json_input->pincode;
$other_attachements = $json_input->other_attach;


foreach( $division_data as $division) {
    $insert_mapping = mysqli_query($link,"INSERT INTO `employees__division_mapping`( `employee_token`, `division_token`, `delete_status`, `datetime`) VALUES ('$token','$division','1','$currnetDateTime')");
}


//mobile_number check
$sql = mysqli_query($link,"SELECT COUNT(*)as count FROM `employees` WHERE `mobile_number`='$mobile_number' AND `deparment_token`='18028120'");
$row = mysqli_fetch_array($sql);
$count =$row["count"];

//gst_number check
$sql1 = mysqli_query($link,"SELECT COUNT(*)as count FROM `employees` WHERE `license_number`='$gst_number' AND `deparment_token`='18028120'");
$row1 = mysqli_fetch_array($sql1);
$gst_count =$row1["count"];


//email_check
$sql2 = mysqli_query($link,"SELECT COUNT(*)as count FROM `employees` WHERE  `email_id`='$email_address' AND `deparment_token`='18028120'");
$row2 = mysqli_fetch_array($sql2);
$email_count =$row2["count"];

$obj1 = new stdClass;
if($count == 0 && $gst_count==0 && $email_count==0){
    $insert_employee = mysqli_query($link,"INSERT INTO `employees`(
    `token`,
    `name`,
    `date_time`,
    `employees_code`,
    `email_id`,
    `password`,
    `deparment_token`,
    `admin_distributor_token`,
    `region_id`,
    `gender`,
    `mobile_number`,
    `device_token`,
    `join_date`,
    `dob`,
    `blood_group`,
    `address`,
    `pincode`,
    `street`,
    `area_token`,
    `city`,
    `address_proof`,
    `license_number`,
    `state_id`,
    `delete_status`,
    `block_status`,
    `employee_image`,
    `otp`,
    `latitude`,
    `longitude`,
    `last_date_time`,
    `send_otp`
    )
    VALUES('$token','$distributor_name','$currnetDateTime','$employees_code','$email_address','','18028120','','$region','','$mobile_number','','$joining_date','','','$address','$pincode','','$area','$city','$address_proof','$gst_number','$state','0','1','$profile_image','','','','','1')");

    $insert_onboard = mysqli_query($link,"INSERT INTO `sales_rep_add_distributor`(
        `rep_token`,
        `distributor_token`,
        `status_code`,
        `date_time`
    )
    VALUES('$sales_rep_employee_id','$token','0','$currnetDateTime')");
   
    $obj1->status_code=200; 
    $obj1->message='Data Inserted';
    $obj1->title='Success';
}
 else if($count==1 && $gst_count==0 && $email_count==0) {
    $obj1->status_code=400; 
    $obj1->message='Mobile number aleady exist';
    $obj1->title='Error';
    
}else if($gst_count==1 && $count==0 && $email_count==0) {
    $obj1->status_code=400; 
    $obj1->message='GST number aleady exist';
    $obj1->title='Error';
}else if($gst_count==0 && $count==0 && $email_count==1) {
    $obj1->status_code=400; 
    $obj1->message='Email  aleady exist';
    $obj1->title='Error';
}else{
    $obj1->status_code=400; 
    $obj1->message='Email,GST,Mobile  aleady exist';
    $obj1->title='Error';
}
echo json_encode($obj1);
?>