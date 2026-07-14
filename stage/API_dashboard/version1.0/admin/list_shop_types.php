<?php

$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer.php';
$retailer = new Retailer($db);
$statement = $retailer->insert_shoptypes();
$count = $statement->rowCount();
if($inputData->dashboard_code == $verification_code){
if($count >0){
    $arr=[];
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        $obj1 = new stdClass();
        $obj1 -> shop_type =$row['name'];
        $obj1 -> shop_token =$row['token'];
        array_push($arr,$obj1);
    }
    $obj->status=200;
    $obj->message="success";
    $obj=$arr;
}else{
    $obj->status=400;
    $obj->message="No record found";
}
}
echo json_encode($obj);
$db = null;

?>