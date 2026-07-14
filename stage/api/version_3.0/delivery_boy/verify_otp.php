<?php
include "../../config.php";
$json_input = getInputs();

$mobile = $json_input->phone_number;
$otp = $json_input->otp;


$result1 =  otpVerify($mobile,$otp);
$obj_emp=new stdClass;
 $obj=new stdClass;
 // echo $result1;
if($result1) {
    $sql = mysqli_query($link,"SELECT employees.`id`, employees.`token`, employees.`name`, employees.`employees_code`, employees.`deparment_token`, employees.`gender`, employees.`mobile_number`, deparment.name as dept_name FROM `employees` INNER JOIN deparment ON deparment.token = employees.deparment_token WHERE employees.mobile_number= $mobile AND deparment.token= '93402780'" );
    $row = mysqli_fetch_array($sql);
            $obj_emp->id=$row['id'];
            $obj_emp->token=$row['token'];
            $obj_emp->name=$row['name'];
            $obj_emp->employees_code=$row['employees_code'];
            $obj_emp->deparment_token=$row['deparment_token'];
            $obj_emp->gender=$row['gender'];
            $obj_emp->mobile_number=$row['mobile_number'];
           
            $obj_emp->dep_name=$row['dept_name'];
   
    $obj->status_code=200; 
    $obj->message='OTP verified';
    $obj->title='Success';
    $obj->data=$obj_emp;
    
    
}
else {
    $obj->status_code=400; 
    $obj->message='OTP not verified';
    $obj->title='Failure';
}

echo json_encode($obj);
?>