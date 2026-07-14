<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$draw        = $_POST['draw'];
$rowStart    = $_POST['start'];
$rowperpage  = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName1 = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value'];
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$admin = new Employee($db);

$resdata = json_decode(file_get_contents("php://input"));

// try {s
    // Fixed: Changed $data->data_token to $resdata->data_token
   if (isset($resdata->data_token)) {
    $admin->data_token = $resdata->data_token; 
    
    // 1. Initialize your response object if you haven't already
    $obj = new \stdClass(); 

    if ($admin->deleteleave()) {
        $obj->status = true;
        $obj->message = "success";
        $obj->code = 200;
    } else {
        $obj->status = false;
        $obj->message = "not working";
        $obj->code = 404; // Consider 500 for a query failure
    }
    
    // 2. Output the response so AJAX can read it
    echo json_encode($obj);
    exit();
}
// } catch (\Throwable $th) {
//     // Fixed: Do not leave this completely empty, or you won't know if it crashed
//     print_r($th->getMessage()); 
// }

$stateId = $_GET['state_id'];
if($stateId != '0'){
    $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
}else{
    $stateQuery = " ";
}
 ## Search 
 $searchQuery = " ";
 if($searchValue != ''){
     $searchQuery = " AND ( 
     `employees`.`name` LIKE '%".$searchValue."%' OR 
     `sales_rep__leave`.`reason` LIKE '%".$searchValue."%' 
     ) ";
 }
 # Total number of records without filtering
$stmt=$admin->countLeave();
$totalRecords = $stmt->rowCount();
 ## filet query values
 $admin->searchQuery    = $searchQuery;
 $admin->stateQuery    = $stateQuery;
 $admin->rowStart       = $rowStart;
 $admin->rowperpage     = $rowperpage;
 switch ($columnName1) {
     case "employee_name":
         $columnName = "`employees`.`name`";
     break;
     default:    $columnName = "`sales_rep__leave`.`id`";
 }
 $admin->columnName     = $columnName;
 $admin->columnSortOrder= $columnSortOrder;
 ## filer count check
 $stmt = $admin->leaveFilter();
 $totalRecordwithFilter = $stmt->rowCount();
 ## pick limit datas
$stmt = $admin->leaveManagement();
$data = $admin->readLeaveMangement($stmt);
# Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);
echo json_encode($response);
$db = null;


?>