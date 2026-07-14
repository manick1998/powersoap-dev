<?php
## Read value safely to avoid undefined warnings
$draw        = isset($_POST['draw']) ? $_POST['draw'] : 1;
$rowStart    = isset($_POST['start']) ? $_POST['start'] : 0;
$rowperpage  = isset($_POST['length']) ? $_POST['length'] : 10; // Rows display per page
$columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0; // Column index
$columnName1 = isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data'] : ''; // Column name
$columnSortOrder = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc'; // asc or desc
$searchValue = isset($_POST['search']['value']) ? $_POST['search']['value'] : '';

## oops conncetivity
$obj = new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();

if (isset($_GET['v_id']) && $_GET['v_id'] == $verification_code) {
    
    $unit_token = isset($_GET['unitToken']) ? $_GET['unitToken'] : '';
    
    // 🚨 THE 504 TIMEOUT FIX 🚨
    // If unitToken is empty, stop processing and return empty JSON for DataTables.
    // This saves the database from massive, unfiltered queries.
    if (empty($unit_token)) {
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => array()
        );
        echo json_encode($response);
        exit;
    }

    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/retailer_distributor.php';
    
    $retailer = new Retailer($db);
    $retailer->distributor_token = $_GET['dist_id'];
    $retailer->unitToken = $unit_token;

    // We no longer need the if() check here because we already exit if it is empty above
    $unitQuery = "AND `shop_mapping`.`unit_token` = '".$unit_token."'";
    $retailer->unitQuery = $unitQuery;

    # Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " AND ( 
        `shop`.`retail_code` LIKE '%$searchValue%' OR
        `shop`.`name` LIKE '%$searchValue%' OR
        `shop__type`.`name` LIKE '%$searchValue%' OR
        `shop`.`mobile_number` LIKE '%$searchValue%' OR
        `shop`.`contact_person` LIKE '%$searchValue%' OR
        `shop`.`license_number` LIKE '%$searchValue%'
        ) ";
    }
    
    ## Total number of records without filtering
    $stmt = $retailer->retailerDetailCountCheck();
    $totalRecordsRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecords = (int)$totalRecordsRow['total_count'];
    
    ## filter query values
    $retailer->searchQuery    = $searchQuery;
    $retailer->rowStart       = $rowStart;
    $retailer->rowperpage     = $rowperpage;
    
    switch ($columnName1) {
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
        case "join_date":
            $columnName = "`shop`.`join_date`";
        break;
        case "license_number":
            $columnName = "`shop`.`license_number`";
        break;
        default:    $columnName = "`shop`.`id`";
    }
    $retailer->columnName     = $columnName;
    $retailer->columnSortOrder= $columnSortOrder;

    ## filter count check
    $stmt = $retailer->serverRetailerCheckfilter();
    $totalRecordwithFilterRow = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalRecordwithFilter = (int)$totalRecordwithFilterRow['total_count'];
    
    ## pick limit datas
    $stmt = $retailer->serverRetailerCheck();
    $data = $retailer->serverReadRetailer($stmt);
    
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