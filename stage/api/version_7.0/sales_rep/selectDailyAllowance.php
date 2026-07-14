<?php

include "../../config.php";
$json_input=getInputs();
$sales_rep_token = $json_input->sales_rep_token;
$obj = new stdClass;

$sql=mysqli_query($link,"SELECT `deparment_token`,`state_id`  FROM `employees` WHERE `token`='$sales_rep_token'");
$row1 = mysqli_fetch_array($sql);
$department_token = $row1['deparment_token'];
$state_id = $row1['state_id'];


$data = array();





//Allowance_list
$sql1=mysqli_query($link,"SELECT `amount_outside_roaming`,`amount_inside_roaming` FROM `sales_rep__allowance` WHERE `dep_token`='$department_token' AND `state_id`='$state_id'");
while($row = mysqli_fetch_array($sql1)) {
    $daily_obj = new stdClass;
    $daily_obj->amount = $row["amount_outside_roaming"];
    $daily_obj1 = new stdClass;
    $daily_obj1->amount = $row["amount_inside_roaming"];
    array_push($data,$daily_obj);
    array_push($data,$daily_obj1);
}




if($data) {
        $obj->status_code=200; 
        $obj->message='Data show successfully';
        $obj->title='Success';
        $obj->data=$data;
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
    }


echo json_encode($obj);

?>