<?php

include "../../config.php";
$json_input=getInputs();
$employee_id = $json_input->employee_id;
$obj = new stdClass;

$data = array();

//percentage
$sql1=mysqli_query($link,"SELECT `percentage` FROM `discount` WHERE `status`='0' ORDER BY `percentage` ASC");
while($row = mysqli_fetch_array($sql1)) {
    $percentage = $row["percentage"];
    array_push($data,$percentage);
}

$dataValue = new stdClass;
$dataValue->discount = $data;

if($data) {
        $obj->status_code=200; 
        $obj->message='Data show successfully';
        $obj->title='Success';
        $obj->data=$dataValue;
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
    }


echo json_encode($obj);

?>