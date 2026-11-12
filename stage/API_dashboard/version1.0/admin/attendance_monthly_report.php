<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
ini_set('memory_limit', '2048M');
ini_set('max_execution_time', '300');
date_default_timezone_set('Asia/kolkata');

$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/order.php';
$order = new Order($db);

$stateId = $inputData->state_id;
$fromDate = $inputData->fromDate;
$toDate = $inputData->toDate;

if (empty($stateId) || empty($fromDate) || empty($toDate)) {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "State, From Date and To Date are required";
    echo json_encode($obj);
    exit;
}

// 1) ACTIVE WORKING sales rep mattum (resigned / deactive / deleted rep report-la varaadhu)
//
//    ENNA MAATHINOM:
//    - `resignation_date` fill aagi irundhaal -> avar resigned. So report-la varakoodadhu.
//      NULL illa '0000-00-00' (zero date) irundhaal mattum "still working".
//    - `block_status` = '1' -> Active. '2' -> Deactive (admin Sales Rep page-la
//      "Deactive" button press panni irundhaal avar report-la vara maattar).
//    - `delete_status` = '1' -> delete aagala.
//
//    IDHU ENNA FILE-A MATTUM AFFECT PANNUM:
//    Intha API (attendance_monthly_report.php) "Attendance Download Report" page
//    mattum thaan call pannudhu. Vera edhuvum ithu use pannala.
$rep_query = "SELECT `employees`.`token` AS employee_token, `employees`.`name` AS employee_name
    FROM `employees`
    INNER JOIN `region` ON `employees`.`region_id` = `region`.`token`
    LEFT JOIN `employees__state` ON `employees`.`state_id` = `employees__state`.`state_token`
    WHERE `employees`.`deparment_token` IN (72602780,98765433,98765434)
    AND `employees`.`state_id` = '$stateId'
    AND `employees`.`delete_status` = '1'
    AND `employees`.`block_status` = '1'
    AND (`employees`.`resignation_date` IS NULL OR `employees`.`resignation_date` = '0000-00-00')
    ORDER BY `employees`.`name` ASC";
$rep_stmt = $db->prepare($rep_query);
$rep_stmt->execute();
$reps = $rep_stmt->fetchAll(PDO::FETCH_ASSOC);

// 2) Government holiday list (SAME as attendance_report page JS)
$holiday_mmdd = array('01-26', '05-01', '08-15', '10-02');

// 3) Day range
$days = array();
$cur = new DateTime($fromDate);
$end = new DateTime($toDate);
while ($cur <= $end) {
    $days[] = $cur->format('Y-m-d');
    $cur->modify('+1 day');
}

$report = array();
$sl = 0;
foreach ($reps as $rep) {
    $sl++;
    $token = $rep['employee_token'];
    $order->toDate = $toDate;
    $order->fromDate = $fromDate;
    $order->salesRep = $token;

    // schedule-based presence (same object function as Attendance Report)
    $stmt = $order->attendanceReport();
    $data = $order->readAttendanceReport($stmt);

    // order-based presence (same object function as Attendance Report)
    $stmt_orders = $order->orderPresenceReport();
    $data_orders = $order->readOrderPresence($stmt_orders);

    // leave rows (same object function as Attendance Report)
    $stmt1 = $order->attendance_leave_Report();
    $stmt2 = $order->attendance_leave_Report_read($stmt1);

    // merge: present if schedule row OR orders row on that day
    $present_map = array();
    foreach ($data as $row) {
        if (isset($row['date'])) $present_map[substr($row['date'], 0, 10)] = 1;
    }
    foreach ($data_orders as $row) {
        $d = isset($row['date']) ? substr($row['date'], 0, 10) : '';
        if ($d !== '' && !isset($present_map[$d])) $present_map[$d] = 1;
    }

    // leave date ranges
    $leave_dates = array();
    foreach ($stmt2 as $lv) {
        $s = substr($lv->start_date, 0, 10);
        $e = substr($lv->end_date, 0, 10);
        if ($s === '' || $e === '' || $e < $s) $e = $s;
        $d1 = new DateTime($s);
        $d2 = new DateTime($e);
        while ($d1 <= $d2) {
            $leave_dates[$d1->format('Y-m-d')] = 1;
            $d1->modify('+1 day');
        }
    }

    // day-wise mark: P / H / S / L  (same rules as Attendance Report screen)
    $marks = array();
    $absent = 0;
    foreach ($days as $d) {
        if (isset($present_map[$d])) {
            $m = 'P';
        } elseif (in_array(substr($d, 5), $holiday_mmdd)) {
            $m = 'H';
        } elseif (isset($leave_dates[$d])) {
            $m = 'L';
        } elseif (date('N', strtotime($d)) == 7) {
            $m = 'S';
        } else {
            $m = 'L';
        }
        if ($m == 'L') $absent++;
        $marks[] = array('day' => (int)date('j', strtotime($d)), 'mark' => $m);
    }

    $row_out = new stdClass();
    $row_out->sl = $sl;
    $row_out->name = $rep['employee_name'];
    $row_out->designation = 'Sales Rep';
    $row_out->days = $marks;
    $row_out->absent = $absent;
    $row_out->working = count($days) - $absent;
    $report[] = $row_out;
}

$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "Monthly attendance report ready";
$obj->data = $report;
echo json_encode($obj);
?>
