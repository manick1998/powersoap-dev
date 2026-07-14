<?php
include "../config.php";




$division = array();

$sql1=mysqli_query($link,"SELECT `token`,`name` FROM `products__category` where `delete_status`='1'");
while($row = mysqli_fetch_array($sql1)) {
    $division_obj = new stdClass;
    $division_obj->token = $row["token"];
    $division_obj->name = $row["name"];
    array_push($division,$division_obj);
}


$obj1 = new stdClass;
    $obj1->status_code=200; 
    $obj1->message='Division Data';
    $obj1->title='Success';
    $obj1->division_data=$division;





echo json_encode($obj1);
?>