<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer.php';
$retailer = new Retailer($db);
if($inputData->dashboard_code == $verification_code){
    $retailer->distributor_token  = $inputData->distributor_token;
    $data = $retailer->selectState_id();

}
echo json_encode($data);
$db = null;

?>