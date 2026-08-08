<?php
// Core inclusions
include_once '../config/core.php';

// Safe input retrieval helpers
$draw        = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$rowStart    = isset($_POST['start']) ? intval($_POST['start']) : 0;
$rowperpage  = isset($_POST['length']) ? intval($_POST['length']) : 10;

// Access nested DataTables array parameters safely
$columnIndex     = isset($_POST['order'][0]['column']) ? intval($_POST['order'][0]['column']) : 0;
$columnName1     = isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data'] : '';
$columnSortOrder = isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';
$searchValue     = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$inputData = getInputs();
$vId = isset($_GET['v_id']) ? $_GET['v_id'] : '';

if ($vId === $verification_code) {
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    include_once '../objects/employee.php';
    $employee = new Employee($db);

    $stateId  = isset($_GET['state_id']) ? $_GET['state_id'] : '0';
    $regionId = isset($_GET['region_id']) ? $_GET['region_id'] : '';

    // Filter Query Building
    $stateQuery = "";
    if ($stateId !== '0' && ($regionId === '' || $regionId === '0')) {
        $stateQuery = " AND `employees`.`state_id` IN ('" . addslashes($stateId) . "') ";
    } else if ($stateId !== '0' && $regionId !== '0' && $regionId !== '') {
        $stateQuery = " AND `employees`.`state_id` IN ('" . addslashes($stateId) . "') AND `employees`.`region_id` IN ('" . addslashes($regionId) . "') ";
    }

    // Search Query Building
    $searchQuery = "";
    if ($searchValue !== '') {
        $escapedSearch = addslashes($searchValue);
        $searchQuery = " AND ( 
            `employees`.`employees_code` LIKE '%" . $escapedSearch . "%' OR 
            `employees`.`name` LIKE '%" . $escapedSearch . "%' OR 
            `employees`.`mobile_number` LIKE '%" . $escapedSearch . "%' OR 
            `employees`.`email_id` LIKE '%" . $escapedSearch . "%' OR
            `employees`.`license_number` LIKE '%" . $escapedSearch . "%' OR
            `employees__state`.`state_name` LIKE '%" . $escapedSearch . "%' OR
            `region`.`region_name` LIKE '%" . $escapedSearch . "%' OR
            `employees`.`area_token` LIKE '%" . $escapedSearch . "%'
        ) ";
    }

    // Total number of records without filtering
    $stmt = $employee->employeeDetailCheckCount();
    $totalRecords = $stmt ? $stmt->rowCount() : 0;

    // Allowlist Column Mapping for Sorting
    switch ($columnName1) {
        case 'employee_name':
            $columnName = "`employees`.`name`";
            break;
        case 'employees_code':
            $columnName = "`employees`.`employees_code`";
            break;
        case 'mobile_number':
            $columnName = "`employees`.`mobile_number`";
            break;
        default:
            $columnName = "`employees`.`id`";
            break;
    }

    // Bind parameters to Employee instance
    $employee->searchQuery     = $searchQuery;
    $employee->stateQuery      = $stateQuery;
    $employee->rowStart        = $rowStart;
    $employee->rowperpage      = $rowperpage;
    $employee->columnName      = "`employees`.`block_status` ASC, " . $columnName;
    $employee->columnSortOrder = $columnSortOrder;

    // Fetch filtered count & records
    $stmtFilter = $employee->serverEmployeeCheckfilter();
    $totalRecordwithFilter = $stmtFilter ? $stmtFilter->rowCount() : 0;

    $stmtData = $employee->serverEmployeeCheck();
    $data = $employee->serverReadEmployee($stmtData);

    // Output JSON Response
    header('Content-Type: application/json');
    echo json_encode([
        "draw"                 => intval($draw),
        "iTotalRecords"        => intval($totalRecords),
        "iTotalDisplayRecords" => intval($totalRecordwithFilter),
        "aaData"               => $data ?? []
    ]);
} else {
    header('Content-Type: application/json');
    echo json_encode([
        "draw"                 => intval($draw),
        "iTotalRecords"        => 0,
        "iTotalDisplayRecords" => 0,
        "aaData"               => [],
        "error"                => "Unauthorized verification code"
    ]);
}
?>