<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
$obj = new stdClass;

try {
    $date = date('Y-m-d');
    $query = "SELECT DISTINCT `sales_rep_token` FROM `sales_rep__leave` WHERE (leave_status = 'Approved' OR leave_status = 'approved' OR `status`='1') AND DATE(start_date) <= :date AND DATE(end_date) >= :date";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':date', $date);
    $stmt->execute();
    $tokens = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tokens[] = $row['sales_rep_token'];
    }

    $obj->status_code = 200;
    $obj->message = 'Today leave tokens';
    $obj->leave_tokens = $tokens;
} catch (Exception $e) {
    $obj->status_code = 500;
    $obj->message = 'Error fetching leave tokens';
    $obj->leave_tokens = [];
}

echo json_encode($obj);
$db = null;

?>