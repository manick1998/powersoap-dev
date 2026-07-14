<?php

include "../../config.php";
$json_input=getInputs();
$obj = new stdClass;
$sales_rep_token = $json_input->sales_rep_token;

$state =array();
$region = array();
$area = array();
$division = array();
$data = array();

//state_token
$sql1=mysqli_query($link,"SELECT `state_token`,`state_name` FROM `employees__state`");
while($row = mysqli_fetch_array($sql1)) {
    $state_obj = new stdClass;
    $state_obj->state_token = $row["state_token"];
    $state_obj->state_name = $row["state_name"];
    array_push($state,$state_obj);
}

//region_token
$sql1=mysqli_query($link,"SELECT `token`,`region_name`,`state_id` FROM `region`");
while($row = mysqli_fetch_array($sql1)) {
    $region_obj = new stdClass;
    $region_obj->token = $row["token"];
    $region_obj->region_name = $row["region_name"];
    $region_obj->state_token = $row["state_id"];
    array_push($region,$region_obj);
}
//area_token
$sql1=mysqli_query($link,"SELECT `state_token`,`region_token`,`area_token`,`area_name` FROM `area`");
while($row = mysqli_fetch_array($sql1)) {
    $area_obj = new stdClass;
    $area_obj->state_token = $row["state_token"];
    $area_obj->region_token = $row["region_token"];
    $area_obj->area_token = $row["area_token"];
    $area_obj->area_name = $row["area_name"];
    array_push($area,$area_obj);
}





//division_list
$sql1=mysqli_query($link,"SELECT `token`,`name` FROM `products__category` where `delete_status`='1'");
while($row = mysqli_fetch_array($sql1)) {
    $division_obj = new stdClass;
    $division_obj->token = $row["token"];
    $division_obj->name = $row["name"];
    array_push($division,$division_obj);
}



$obj1 = new stdClass;
$obj1->state = $state;
$obj1->region = $region;
$obj1->area = $area;
$obj1->division = $division;

array_push($data,$obj1);


if($sales_rep_token) {
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