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
$obj = new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
if ($_GET['v_id'] == $verification_code) {
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/orders.php';
    $order = new OrderList($db);
    $order->distributor_token = $_GET['dist_id'];
    $retailer_id = $_GET['retail_id'];
    $stmt4 = $order->getShopToken($retailer_id);
    $order->retailer_id = $stmt4;
    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " AND ( 
        `shop`.`retail_code` LIKE '%" . $searchValue . "%' OR 
        `shop`.`name` LIKE '%" . $searchValue . "%' OR 
        `shop__type`.`name` LIKE '%" . $searchValue . "%' OR 
        `shop`.`mobile_number` LIKE '%" . $searchValue . "%' OR 
        `shop`.`contact_person` LIKE '%" . $searchValue . "%'
        ) ";
    }

    ## Total number of records without filtering
    $stmt = $order->outstandingOrderCount();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $order->searchQuery    = $searchQuery;
    $order->rowStart       = $rowStart;
    $order->rowperpage     = $rowperpage;
    switch ($columnName1) {
        case "shop_token":
            $columnName = "`shop`.`token`";
            break;
        case "retail_code":
            $columnName = "`shop`.`retail_code`";
            break;
        case "retailer_name":
            $columnName = "`shop`.`name`";
            break;
        case "shop_type":
            $columnName = "`shop__type`.`name`";
            break;
        case "mobile_number":
            $columnName = "`shop`.`mobile_number`";
            break;
        case "contact_person":
            $columnName = "`shop`.`contact_person`";
            break;
        default:
            $columnName = "`shop`.`id`";
    }
    $order->columnName     = $columnName;
    $order->columnSortOrder = $columnSortOrder;
    ## filer count check
    $stmt1 = $order->serverOutstandingOrderCheckfilter();
    $totalRecordwithFilter = $stmt1->rowCount();
    //    ## pick limit datas
    $stmt2 = $order->serverOutstandingOrderCheck();
    $data = $order->serverReadOutstandingOrderCheck($stmt2);
    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
}
