<?php
## Read value
$draw        = $_POST['draw'];
$rowStart    = $_POST['start'];
$rowperpage  = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName1 = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = trim($_POST['search']['value']); // Trim empty spaces

## oops conncetivity
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();

$v_id = isset($_POST['v_id']) ? $_POST['v_id'] : (isset($_GET['v_id']) ? $_GET['v_id'] : '');

if($v_id == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    $order->orderType   = "Distributor Order";
    
    $stateId = isset($_POST['state_id']) ? $_POST['state_id'] : (isset($_GET['state_id']) ? $_GET['state_id'] : '0');
    
    if($stateId != '0' && $stateId != ''){
        $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."') ";
    }else{
        $stateQuery = " ";
    }
    
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchSafe = addslashes($searchValue); // Prevent SQL breaking
        $searchQuery = " AND ( 
        `orders`.`order_number` LIKE '%".$searchSafe."%' OR 
        `shop`.`name` LIKE '%".$searchSafe."%' OR 
        `employees`.`name` LIKE '%".$searchSafe."%' OR 
        `orders`.`items` LIKE '%".$searchSafe."%' OR 
        `orders`.`delivery` LIKE '%".$searchSafe."%'
        ) ";
    }
    
    $raw_from = isset($_POST['from_date']) ? $_POST['from_date'] : (isset($_GET['from_date']) ? $_GET['from_date'] : '');
    $raw_to = isset($_POST['to_date']) ? $_POST['to_date'] : (isset($_GET['to_date']) ? $_GET['to_date'] : '');
    
    $dateQuery = " ";
    if($raw_from != "" && $raw_to != ""){
        $from_date         = date("Y-m-d 00:00:00", strtotime($raw_from)); 
        $to_date           = date("Y-m-d 23:59:59", strtotime($raw_to));
        $dateQuery = " AND ( `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' ) ";
        $order->fromDate = $from_date;
        $order->toDate = $to_date;
    }   
    
    $order->dateQuery    = $dateQuery;
    $order->stateQuery   = $stateQuery;
    $order->searchQuery  = $searchQuery;
    $order->rowStart     = $rowStart;
    $order->rowperpage   = $rowperpage;
    
    switch ($columnName1) {  
        case "order_number": $columnName = "`orders`.`order_number`"; break;
        case "date_time":    $columnName = "`orders`.`date_time`"; break;
        case "sales_man":    $columnName = "`employees`.`name`"; break;
        case "items":        $columnName = "`orders`.`items`"; break;
        case "delivery":     $columnName = "`orders`.`delivery`"; break;
        case "delivered_on": $columnName = "`orders`.`delivered_on`"; break;    
        default:             $columnName = "`orders`.`id`";
    }
    $order->columnName     = $columnName;
    $order->columnSortOrder= $columnSortOrder;

    // ==========================================
    // EXTREME SPEED OPTIMIZATION FOR COUNT QUERY
    // ==========================================
    
    // 1. Base Count (No unnecessary JOINs, directly counting the orders table)
    if(trim($stateQuery) == "") {
        $countBase = "SELECT COUNT(id) as total FROM `orders` WHERE `order_type`='Distributor Order'";
        $stmtBase = $db->prepare($countBase);
        $stmtBase->execute();
        $totalRecords = $stmtBase->fetch(PDO::FETCH_ASSOC)['total'];
    } else {
        $countBase = "SELECT COUNT(`orders`.`id`) as total FROM `orders` INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token` $stateQuery WHERE `orders`.`order_type`='Distributor Order'";
        $stmtBase = $db->prepare($countBase);
        $stmtBase->execute();
        $totalRecords = $stmtBase->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // 2. Filter Count (Only runs JOINs if Search or Date is active)
    if(trim($searchQuery) != "" || trim($dateQuery) != ""){
        $countFilter = "SELECT COUNT(`orders`.`id`) as total 
                        FROM `orders` 
                        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token` 
                        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token` $stateQuery 
                        WHERE `orders`.`order_type`='Distributor Order' $dateQuery $searchQuery";
        $stmtFilter = $db->prepare($countFilter);
        $stmtFilter->execute();
        $totalRecordwithFilter = $stmtFilter->fetch(PDO::FETCH_ASSOC)['total'];
    } else {
        $totalRecordwithFilter = $totalRecords;
    }

    // ==========================================

    ## Pick limit datas
    $stmt = $order->serverDistributorOrderCheck();
    $data = $order->serverReadDistributorOrder($stmt);

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => intval($totalRecords),
        "iTotalDisplayRecords" => intval($totalRecordwithFilter),
        "aaData" => $data
    );
    echo json_encode($response);
}
?>