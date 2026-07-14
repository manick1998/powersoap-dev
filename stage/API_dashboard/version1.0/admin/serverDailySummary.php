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
    if($stateId != '0'){
        $stateQuery = " AND `distributor`.`state_id` IN ('".$stateId."')";
    }else{
        $stateQuery = " ";
    }
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `orders`.`date_time` LIKE '%".$searchValue."%' OR 
        `distributor`.`name` LIKE '%".$searchValue."%' OR 
        `sales_man`.`name` LIKE '%".$searchValue."%' OR 
        `deparment`.`name` LIKE '%".$searchValue."%' OR 
        `units`.`name` LIKE '%".$searchValue."%'
        ) ";
    }
    $from_date         = date("Y-m-d 00:00:00", strtotime($_GET['from_date'])); 
    $to_date           = date("Y-m-d 23:59:59", strtotime($_GET['to_date']));
    $dateQuery = " ";
    if($_GET['from_date']!="" && $_GET['to_date']!=""){
        $dateQuery = " AND ( 
            `orders`.`date_time` BETWEEN '$from_date' AND '$to_date'
        ) ";
    }
    $employee->stateQuery    = $stateQuery;
    ## Total number of records without filtering
    $stmt=$employee->employeeDailyCount();
    $totalRecords = $stmt->rowCount(); 
    ## filet query values
    $employee->dateQuery    = $dateQuery;
    $employee->searchQuery    = $searchQuery;
    $employee->rowStart       = $rowStart;
    $employee->rowperpage     = $rowperpage;
    switch ($columnName1) {  
        case "date_time":
            $columnName = "`orders`.`date_time`";
        break;
        case "distributor_name":
            $columnName = "`distributor`.`name`";
        break;
        case "employee_name":
            $columnName = "`sales_man`.`name`";
        break;
        case "deparment_name":
            $columnName = "`deparment`.`name`";
        break;
        case "location_name":
            $columnName = "`units`.`name`";
        break;
        default: $columnName = "`orders`.`id`";
    }
    $employee->columnName     = $columnName;
    $employee->columnSortOrder= $columnSortOrder;
    ## filer count check
    if($dateQuery != " "){
    $stmt = $employee->employeeDaliyCheckFilter();
    $totalRecordwithFilter = $stmt->rowCount();
    }
    if($searchQuery != " "){
    $stmt1 = $employee->employeeDaliyCheckSearch();
    $totalRecordwithFilter = $stmt1->rowCount();   
    }
    if($dateQuery == " " && $searchQuery == " "){
    $stmt2 = $employee->employeeDaliyCheckFilter();
    $totalRecordwithFilter = $stmt2->rowCount();    
    }
    ## pick limit datas
    $stmt = $employee->serverEmployeeDailySummaryCheck();
    $data = $employee->readEmployeeDailySummary($stmt);
    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
}
?>