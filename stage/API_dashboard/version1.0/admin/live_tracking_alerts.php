<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$obj = new stdClass();
$obj->code = 400;
$obj->message = "Invalid request";
$obj->created_count = 0;

include_once "../config/core.php";
$inputData = getInputs();

if (!$inputData || !isset($inputData->dashboard_code) || $inputData->dashboard_code != $verification_code) {
    echo json_encode($obj);
    exit;
}

include_once "../config/database.php";
include_once "../objects/employee.php";
include_once "../objects/notification.php";

$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$notification = new Notification($db);
$recipientToken = isset($token) && $token != "" ? $token : "00000000";
$createdCount = 0;
$staleBefore = date('Y-m-d H:i:s', strtotime($indiaDateTime . ' -30 minutes'));
$duplicateSince = date('Y-m-d H:i:s', strtotime($indiaDateTime . ' -30 minutes'));

function createAutoAlert($notification, $recipientToken, $title, $message, $indiaDateTime, $duplicateSince)
{
    $notification->distributor_token = $recipientToken;
    $notification->noti_title = $title;
    $notification->noti_content = $message;
    if ($notification->autoNotificationExistsSince($duplicateSince)) {
        return false;
    }

    $notification->notification_token = token_generate('admin_notification', 'token');
    return $notification->createSingleNotification($indiaDateTime);
}

$stationaryStmt = $employee->stationarySalesRepAlerts($indiaDateTime, 30);
while ($row = $stationaryStmt->fetch(PDO::FETCH_ASSOC)) {
    $stateName = !empty($row['state_name']) ? $row['state_name'] : '-';
    $message = $row['rep_name'] . ' is staying in the same place for more than 30 minutes. '
        . 'State: ' . $stateName . '. Last location: ' . $row['latitud'] . ', ' . $row['langitud'] . '.';
    if (createAutoAlert($notification, $recipientToken, 'Sales Rep Same Place Alert', $message, $indiaDateTime, $duplicateSince)) {
        $createdCount++;
    }
}

$offlineStmt = $employee->offlineSalesRepAlerts($indiaDateTime, $staleBefore);
while ($row = $offlineStmt->fetch(PDO::FETCH_ASSOC)) {
    $lastSeenText = $row['last_time'] ? date('d/m/Y h:i A', strtotime($row['last_time'])) : 'No live location today';
    $stateName = !empty($row['state_name']) ? $row['state_name'] : '-';
    $message = $row['rep_name'] . ' has not updated live location for more than 30 minutes. '
        . 'Live location may be off or network may be disconnected. '
        . 'State: ' . $stateName . '. Last update: ' . $lastSeenText . '.';
    if (createAutoAlert($notification, $recipientToken, 'Sales Rep Live Location Alert', $message, $indiaDateTime, $duplicateSince)) {
        $createdCount++;
    }
}

$obj->code = 200;
$obj->message = "Live tracking alerts checked";
$obj->created_count = $createdCount;

echo json_encode($obj);
?>
