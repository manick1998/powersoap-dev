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
    include_once '../objects/retailer.php';
    $retailer = new Retailer($db);
    $stateId = $_GET["state_id"];
    $distributor_token = $_GET["distributor_token"];
        if($stateId != '0'){
            $stateQuery = " AND `shop`.`state_id` IN ('".$stateId."')";
        }else{
            $stateQuery = " ";
        }
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `shop`.`retail_code` LIKE '%$searchValue%' OR
        `shop`.`name` LIKE '%$searchValue%' OR
        `employees`.`name` LIKE '%$searchValue%' OR
        `shop__type`.`name` LIKE '%$searchValue%' OR
        `shop`.`mobile_number` LIKE '%$searchValue%' OR
        `shop`.`contact_person` LIKE '%$searchValue%' OR
        `shop`.`city` LIKE '%$searchValue%' OR
        `employees__state`.`state_name` LIKE '%$searchValue%' OR
        `shop`.`license_number` LIKE '%$searchValue%' 
        ) ";
    }
    ## filet query values
    $retailer->stateQuery    = $stateQuery;
    $retailer->searchQuery    = $searchQuery;
    $retailer->rowStart       = $rowStart;
    $retailer->rowperpage     = $rowperpage;
    $retailer->distributor_token = $distributor_token;
    ## Total number of records without filtering
    $stmt=$retailer->distributor_retailerDetailCountCheck();
    $totalRecords = $stmt->rowCount();
    switch ($columnName1) {
        case "retail_code":
            $columnName = "`shop`.`retail_code`";
        break;
        case "retailer_name":
            $columnName = "`shop`.`name`";
        break;
        case "distributor":
            $columnName = "`employees`.`name`";
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
        case "city":
            $columnName = "`shop`.`city`";
        break;
        case "state_name":
            $columnName = "`employees__state`.`state_name`";
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

    ## filer count check
    $stmt = $retailer->serverDistribtorRetailerCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $retailer->serverDistributorRetailerCheck();
    $data = $retailer->serverDistributorReadRetailer($stmt);
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