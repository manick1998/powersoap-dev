<?php
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$obj = new stdClass();
if ($inputData->dashboard_code == $verification_code) {
    $token = $inputData->order_token;
    $d1 = $db->prepare("DELETE FROM `orders__items` WHERE `order_token`=:token");
    $d1->bindParam('token', $token);
    $d1->execute();
    $d2 = $db->prepare("DELETE FROM `orders` WHERE `token`=:token AND `order_type`='Distributor Order'");
    $d2->bindParam('token', $token);
    $d2->execute();
    if ($d2->rowCount() > 0) {
        $obj->code = 201;
        $obj->message = "Order deleted successfully";
    } else {
        $obj->code = 503;
        $obj->message = "Order not found";
    }
    $db = null;
}
echo json_encode($obj);
?>