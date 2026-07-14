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
include_once '../config/core_distributor.php';
$inputData = getInputs();
if($_GET['v_id'] == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/offer_distributor.php';
    $offers = new Offers($db);
    $offers->distributor_token = $_GET["dist_id"];
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
            `admin_offers`.`offer_name` LIKE '%".$searchValue."%' OR
            `products__category`.`name` LIKE '%".$searchValue."%' OR
            `admin_offers`.`offer_percentage` LIKE '%".$searchValue."%' OR
            `admin_offers`.`minimum_purchase_amount` LIKE '%".$searchValue."%'
        ) ";
    }
    ## Total number of records without filtering
    $stmt=$offers->offerCountCheck();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $offers->searchQuery    = $searchQuery;
    $offers->rowStart       = $rowStart;
    $offers->rowperpage     = $rowperpage;
    switch ($columnName1) {
        case "name":
            $columnName = "`admin_offers`.`offer_name`";
        break;
        case "division":
            $columnName = "`products__category`.`name`";
        break;
        case "offer":
            $columnName = "`admin_offers`.`offer_percentage`";
        break;
        case "amount":
            $columnName = "`admin_offers`.`minimum_purchase_amount`";
        break;  
        default:    $columnName = "`admin_offers`.`id`";
    }
    $offers->columnName     = $columnName;
    $offers->columnSortOrder= $columnSortOrder;
    ## filer count check
    $stmt = $offers->serverOfferCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $offers->serverOfferCheck();
    $data = $offers->serverReadOffer($stmt);
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