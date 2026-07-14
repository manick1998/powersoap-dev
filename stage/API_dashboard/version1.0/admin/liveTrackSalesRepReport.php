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
if($_POST['v_id'] == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `salesman`.`name` LIKE '%$searchValue%' OR 
        `distributor`.`name` LIKE '%$searchValue%' OR 
        `orders`.`date_time` LIKE '%$searchValue%' OR 
        `area`.`area_name` LIKE '%$searchValue%' ) ";
    }
    $order->fromDate     = date("Y-m-d 00:00:00", strtotime($_POST['from_date'])); 
    $order->toDate       = date("Y-m-d 23:59:59", strtotime($_POST['to_date']));
    $order->salesRep     = $_POST['salesRep'];
    $order->selectState  = $_POST['selectState'];
    ## Total number of records without filtering
    $stmt=$order->salesRepReportCount();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $order->searchQuery    = $searchQuery;
    $order->rowStart       = $rowStart;
    $order->rowperpage     = $rowperpage;
    switch ($columnName1) {  
        case "sales_rep_name":
            $columnName = " `salesman`.`name`";
        break;
        case "distributor_name":
            $columnName = "`distributor`.`name`";
        break;
        case "date_time":
            $columnName = "`orders`.`date_time`";
        break;
        case "area_name":
            $columnName = "`area`.`area_name`";
        break;
        default: $columnName = "`orders`.`id`";
    }
    $order->columnName     = $columnName;
    $order->columnSortOrder= $columnSortOrder;
    ## filer count check
    $stmt2 = $order->salesRepReportSearch();
    $totalRecordwithFilter = $stmt2->rowCount();   
    ## pick limit datas
    $stmt = $order->salesRepReport();
    $data = $order->readSalesRepReport($stmt);
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