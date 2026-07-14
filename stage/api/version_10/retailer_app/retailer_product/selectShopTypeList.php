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
$result = $retailer->shopType();
$count = $result->rowCount();

$obj = new stdClass();
$data = [];
if ($count == 0) {
    $obj->status_code = 400;
    $obj->message = 'data  not found';
}
else{
    $result = $retailer->shopType();
        $shopList = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $obj2 = new stdClass();
        $obj2->token = $row['token'];
        $obj2->name = $row['name'];
        array_push($shopList,$obj2);
    }
    $obj->status_code= 200;
    $obj->message = 'success';
    $obj->datas = $shopList;
}
echo json_encode($obj);
?>