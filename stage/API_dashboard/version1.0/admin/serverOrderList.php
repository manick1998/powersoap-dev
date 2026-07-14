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
    include_once '../objects/order.php';
    $order = new Order($db);
    $stateId = $_GET["state_id"];
    $region_change=$_GET["region_token"];
    $dist_change=$_GET["dist_token"];
    if($stateId != '0'&& $region_change == '' && $dist_change == ''){
        $stateQuery = " AND `distributor`.`state_id` IN ('".$stateId."')";
    }else if ($stateId != '0' && $region_change != '0' && $dist_change != '0') {
        $stateQuery = " AND `distributor`.`state_id` IN ('".$stateId."') AND `distributor`.`region_id` IN ('".$region_change."') AND `distributor`.`token` IN ('".$dist_change."')";
    }
    else{
        $stateQuery = " ";
    }
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `orders`.`order_number` LIKE '%".$searchValue."%' OR 
        `shop`.`name` LIKE '%".$searchValue."%' OR 
        `sales_man`.`name` LIKE '%".$searchValue."%' OR 
        `distributor`.`name` LIKE '%".$searchValue."%' OR 
        `orders`.`items` LIKE '%".$searchValue."%' OR 
        `orders`.`delivery` LIKE '%".$searchValue."%'
        ) ";
    }
    $from_date         = date("Y-m-d 00:00:00", strtotime($_GET['from_date'])); ; 
    $to_date           = date("Y-m-d 23:59:59", strtotime($_GET['to_date']));
    $dateQuery = " ";
    if($_GET['from_date']!="" && $_GET['to_date']!=""){
        $dateQuery = " AND ( 
            `orders`.`date_time` BETWEEN '$from_date' AND '$to_date'
        ) ";
    }   
    ## Total number of records without filtering
    $stmt=$order->orderHistoryCheckCount();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $order->dateQuery      = $dateQuery;
    $order->stateQuery = $stateQuery;
    $order->searchQuery    = $searchQuery;
    $order->rowStart       = $rowStart;
    $order->rowperpage     = $rowperpage;
    switch ($columnName1) {  
        case "order_number":
            $columnName = "`orders`.`order_number`";
        break;
        case "distributor_name":
            $columnName = "`distributor`.`name`";
        break;
        case "date_time":
            $columnName = "`orders`.`date_time`";
        break;
        case "shop_name":
            $columnName = "`shop`.`name`";
        break;
        case "sales_man":
            $columnName = "`sales_man`.`name`";
        break;
        case "items":
            $columnName = "`orders`.`items`";
        break;
        case "delivery":
            $columnName = "`orders`.`delivery`";
        break;
        case "delivered_on":
            $columnName = "`orders`.`delivered_on`";
        break;    
        default:    $columnName = "`orders`.`id`";
    }
    $order->columnName     = $columnName;
    $order->columnSortOrder= $columnSortOrder;
    ## filer count check
    if($dateQuery != " "){
    $stmt = $order->orderHistoryCheckFilter();
    $totalRecordwithFilter = $stmt->rowCount();
    }
    if($searchQuery != " "){
    $stmt1 = $order->orderHistoryCheckSearch();
    $totalRecordwithFilter = $stmt1->rowCount();  
    }
    if($searchQuery == " " && $dateQuery == " "){
    $stmt2 = $order->orderHistoryCheckFilter();
    $totalRecordwithFilter = $stmt2->rowCount();  
    }
    ## pick limit datas
    $stmt = $order->serverOrderHistoryCheck();
    $data = $order->serverReadOrder($stmt);
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