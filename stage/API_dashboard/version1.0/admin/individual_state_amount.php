<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
$data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$date = date("Y-m-d");
$emp->state_token = $data->state_token;
$state_amount = $emp->individual_state_amount($date);
$count = $state_amount->rowCount();
if ($count == 0) {
    $obj = new stdClass;
    $obj->status_code = '400';
    $obj->msg = 'Error';
}else{
    $arr=[];
    while($row = $state_amount->fetch(PDO::FETCH_ASSOC)){
            $obj = new stdClass;
            $obj->state_amount = $row['state_total_amount']==""?"-":$row['state_total_amount'];
            array_push($arr,$obj);
    };
    $obj->status_code = '200';
    $obj->msg = 'success';
    $obj = $arr;
}
echo json_encode($obj);
$db = null;

?>