<?php
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$obj = new stdClass();
if ($inputData->dashboard_code == $verification_code) {
    $token = $inputData->order_token;
    $admin_token = $inputData->admin_token;

    $stmt = $db->prepare("SELECT `employee_token` FROM `orders` WHERE `token`=:token AND `order_type`='Distributor Order'");
    $stmt->bindParam('token', $token);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $obj->code = 503;
        $obj->message = "Order not found";
    } else {
        // 1) ORDER LOG - yaaru delete pannaanga
        $log = $db->prepare("INSERT INTO `orders_log` SET
            `order_token`=:order_token,
            `product_token`='0',
            `distributor_token`=:distributor_token,
            `old_quantity`='0',
            `new_quantity`='0',
            `old_discount`='0',
            `new_discount`='0',
            `delete_status`='1',
            `delivery`='Deleted',
            `date_time`='$indiaDateTime',
            `created_by`=:admin_token");
        $log->bindParam('order_token', $token);
        $log->bindParam('distributor_token', $row['employee_token']);
        $log->bindParam('admin_token', $admin_token);
        $log->execute();

        // 2) delete order items + order
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
}
echo json_encode($obj);
?>