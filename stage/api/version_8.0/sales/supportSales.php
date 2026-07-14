<?php
include "../../config.php";
$json_input = getInputs();
$current = $indiaDateTime;
$sales_token = $json_input->sales_token;
$description = $json_input->description;
$attach_image = $json_input->attach;
$token  = genToken('status_token','support_table');

$sql = mysqli_query($link,"SELECT `name`,`mobile_number`,`deparment_token` from `employees` WHERE `token`='$sales_token'");
while($row = mysqli_fetch_array($sql)){
$name = $row['name'];
$mobile_number = $row['mobile_number'];
$department_token = $row['deparment_token'];
}

if($sales_token!=""&& $description!=""){
$insert_support = mysqli_query($link,"INSERT INTO `support_table`(
    `status_token`,
    `emp_token`,
    `name`,
    `mobile_number`,
    `deparment_token`,
    `description`,
    `attachment`,
    `status_code`,
    `date_time`
)
VALUES('$token','$sales_token','$name','$mobile_number','$department_token','$description','$attach_image','0','$current')");
}
$obj = new stdClass;
if($insert_support){
    $obj->status_code=200; 
    $obj->message='Data Inserted';
    $obj->title='Success';
    
} else {
    $obj->status_code=400; 
    $obj->message='error';
    $obj->title='failure';
    
}



    echo json_encode($obj);

?>