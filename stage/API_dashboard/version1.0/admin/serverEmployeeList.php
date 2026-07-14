<?php
## Read value
$draw        = $_POST['draw'];
$rowStart    = $_POST['start'];
$rowperpage  = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName1 = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value'];
## oops conncetivity
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
if($_GET['v_id'] == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/employee.php';
    $employee = new Employee($db);
    $stateId = $_GET['state_id'];
    $regionId = $_GET['region_id'];
    if($stateId != '0' && $regionId==''){
        $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."') ";
    }else if ($stateId != '0' && $regionId != '0'){
    $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."') AND `employees`.`region_id` IN ('".$regionId."')  ";
}else{
        $stateQuery = " ";
    }
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `employees`.`employees_code` LIKE '%".$searchValue."%' OR 
        `employees`.`name` LIKE '%".$searchValue."%' OR 
        `employees`.`mobile_number` LIKE '%".$searchValue."%' OR 
        `employees`.`email_id` LIKE '%".$searchValue."%' OR
        `employees`.`license_number` LIKE '%".$searchValue."%' OR
        `employees__state`.`state_name` LIKE '%".$searchValue."%' OR
        `region`.`region_name` LIKE '%".$searchValue."%' OR
        `employees`.`area_token` LIKE '%".$searchValue."%'
        ) ";
    }
    # Total number of records without filtering
    $stmt=$employee->employeeDetailCheckCount();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $employee->searchQuery    = $searchQuery;
    $employee->stateQuery    = $stateQuery;
    $employee->rowStart       = $rowStart;
    $employee->rowperpage     = $rowperpage;
    // switch ($columnName1) {
    //     case "employee_name":
    //         $columnName = "`employees`.`name`";
    //     break;
    //     default:    $columnName = "`employees`.`id`";
    // }
    // $employee->columnName     = $columnName;
    // $employee->columnSortOrder= $columnSortOrder;

    switch ($columnName1) {
        case "employee_name":
            $columnName = "`employees`.`name`";
        break;
        default:    $columnName = "`employees`.`id`";
    }
    
    $employee->columnName     = "`employees`.`block_status` ASC, " . $columnName;
    $employee->columnSortOrder= $columnSortOrder;
    ## filer count check
    $stmt = $employee->serverEmployeeCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $employee->serverEmployeeCheck();
    $data = $employee->serverReadEmployee($stmt);
    # Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
}
?>