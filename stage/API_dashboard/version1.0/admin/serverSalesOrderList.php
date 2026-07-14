<?php
ini_set('memory_limit', '2048M'); 
ini_set('max_execution_time', '300'); 
error_reporting(0); 

 $draw = isset($_POST['draw']) ? $_POST['draw'] : 0;
 $rowStart = isset($_POST['start']) ? $_POST['start'] : 0;
 $rowperpage = isset($_POST['length']) ? $_POST['length'] : 10;

 $columnIndex = $_POST['order'][0]['column']; 
 $columnName1 = $_POST['columns'][$columnIndex]['data']; 
 $columnSortOrder = $_POST['order'][0]['dir']; 
 $searchValue = $_POST['search']['value'];

## oops connectivity
 $obj=new stdClass();
include_once '../config/core.php';
 $inputData = getInputs();

if($_GET['v_id'] == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    
    $stateId = isset($_GET["state_id"]) ? $_GET["state_id"] : '';
    $region_change = isset($_GET["region_token"]) ? $_GET["region_token"] : '';
    $dist_change = isset($_GET["dist_token"]) ? $_GET["dist_token"] : '';
    $order_by_val = isset($_GET["order_by"]) ? $_GET["order_by"] : '';
    
    // Order By Logic Optimized
    if($order_by_val == 'Salesrep'){
        $order->order_by = "AND `orders`.`sales_rep_token` IS NOT NULL AND `orders`.`sales_rep_token` != ''";      
    } else if($order_by_val == 'Salesman'){
        $order->order_by = "AND `orders`.`employee_token` != '$dist_change' ";    
    } else if($order_by_val == 'Distributor'){
        $order->order_by = "AND `orders`.`employee_token` = '$dist_change' AND (`orders`.`sales_rep_token` = '' OR `orders`.`sales_rep_token` IS NULL)";      
    } else {
        $order->order_by = "";
    }
     
    // State Query Logic Fixed (Now works properly)
    $stateQuery = " ";
    if($stateId != '0' && $stateId != '') {
        $stateQuery .= " AND `distributor`.`state_id` IN ('".$stateId."') ";
    }
    if($region_change != '0' && $region_change != '') {
        $stateQuery .= " AND `distributor`.`region_id` IN ('".$region_change."') ";
    }
    if($dist_change != '0' && $dist_change != '') {
        $stateQuery .= " AND `distributor`.`token` IN ('".$dist_change."') ";
    }
    
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `orders`.`order_number` LIKE '%$searchValue%' OR 
        `shop`.`name` LIKE '%$searchValue%' OR 
        `salesman`.`name` LIKE '%$searchValue%' OR 
        `distributor`.`name` LIKE '%$searchValue%' OR 
        `orders`.`items` LIKE '%$searchValue%' OR 
        `orders`.`delivery` LIKE '%$searchValue%' OR
        `orders`.`date_time` LIKE '%$searchValue%' OR
        `orders`.`delivered_on` LIKE '%$searchValue%'
        ) ";
    }
    
    // Date Query Optimized - REMOVED date() function to use Database Index
    $dateQuery = " ";
    if($_GET['from_date'] != "" && $_GET['to_date'] != ""){
        $from_date = date("Y-m-d 00:00:00", strtotime($_GET['from_date'])); 
        $to_date   = date("Y-m-d 23:59:59", strtotime($_GET['to_date']));
        $dateQuery = " AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' ";
    }
    
    $order->stateQuery    = $stateQuery;
    
    // Fetch Total Records using COUNT() - Much Faster
    $stmt=$order->orderCheckCount();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = $row['total'];
    
    $order->dateQuery     = $dateQuery;
    $order->searchQuery   = $searchQuery;
    $order->rowStart      = $rowStart;
    $order->rowperpage    = $rowperpage;
    
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
            $columnName = "`salesman`.`name`";
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
        default:    
            $columnName = "`orders`.`id`";
    }
    
    $order->columnName     = $columnName;
    $order->columnSortOrder= $columnSortOrder;
    
    // Fetch Filtered Records Count using COUNT()
    if($searchQuery != " "){
        $stmt1 = $order->orderCheckFilterSearchNew();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $totalRecordwithFilter = $row1['total'];  
    } else if($dateQuery != " "){
        $stmt = $order->orderCheckFilterNew();
        $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalRecordwithFilter = $row2['total'];
    } else {
        $totalRecordwithFilter = $totalRecords;  
    }
    
    $stmt = $order->serverOrderCheckNew();
    $data = $order->serverReadOrderNew($stmt);
    
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>