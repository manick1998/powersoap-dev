<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
$database = new Database();
$db = $database->getConnection();
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$usertype = $input->user_type;
$result = $retailer->stateList();
$count = $result->rowCount();

$obj = new stdClass();
$data = [];
if ($count == 0) {
    $obj->status_code = 400;
    $obj->message = 'data  not found';
}
else{
    $result = $retailer->stateList();
        $state = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $obj2 = new stdClass();
        $obj2->state_token = $row['state_token'];
        $obj2->state_name = $row['state_name'];
        array_push($state,$obj2);
    }
    $result1 = $retailer->regionList();
    $region=[];
    while ($rows = $result1->fetch(PDO::FETCH_ASSOC)) {
        $obj1 = new stdClass();
        $obj1->state_id = $rows['state_id'];
        $obj1->token = $rows['token'];
        $obj1->region_name = $rows['region_name'];
        array_push($region,$obj1);
    }
    $obj3 = new stdClass;
    $obj3->state = $state;
    $obj3->region = $region;
    array_push($data,$obj3);
    $obj->status_code= 200;
    $obj->message = 'success';
    $obj->dataStates = $data;
}
echo json_encode($obj);
?>