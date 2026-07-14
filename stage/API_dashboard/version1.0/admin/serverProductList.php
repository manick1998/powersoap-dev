<?php
$obj = new stdClass();
include_once '../config/core.php';
$inputData = getInputs();

## Read value
$draw        = $_POST['draw'] ?? 0;
$rowStart    = $_POST['start'] ?? 0;
$rowperpage  = $_POST['length'] ?? 10; // Rows display per page
$columnIndex = $_POST['order'][0]['column'] ?? 0; // Column index
$columnName1 = $_POST['columns'][$columnIndex]['data'] ?? ''; // Column name
$columnSortOrder = $_POST['order'][0]['dir'] ?? 'desc'; // asc or desc
$searchValue = $_POST['search']['value'] ?? '';
## oops conncetivity
if ($_GET['v_id'] == $verification_code) {
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
    $division_token = $_GET['division'];
    $divisionQuery = " ";
    if ($division_token != '') {
        $divisionQuery = " AND `products`.`category_token` IN ('" . $division_token . "')";
    }
    ## Search 
    $searchQuery = " ";
    if ($searchValue != '') {
        $searchQuery = " AND ( 
        `products`.`item_code` LIKE '%" . $searchValue . "%' OR 
        `products`.`name` LIKE '%" . $searchValue . "%' OR 
        `products`.`total_cost` LIKE '%" . $searchValue . "%' OR 
        `products`.`mrp` LIKE '%" . $searchValue . "%' OR 
        `products`.`piece_count` LIKE '%" . $searchValue . "%' OR 
        `products__category`.`name` LIKE '%" . $searchValue . "%' ) ";
    }
    ## Total number of records without filtering
    $stmt = $inventory->productCheck();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $inventory->searchQuery    = $searchQuery;
    $inventory->divisionQuery    = $divisionQuery;
    $inventory->rowStart       = $rowStart;
    $inventory->rowperpage     = $rowperpage;
    switch ($columnName1) {
        case "item_code":
            $columnName = "`products`.`item_code`";
            break;
        case "image":
            $columnName = "`products`.`image`";
            break;
        case "name":
            $columnName = "`products`.`name`";
            break;
        case "type":
            $columnName = "`products__category`.`name`";
            break;
        case "total_cost":
            $columnName = "`products`.`total_cost`";
            break;
        case "mrp":
            $columnName = "`products`.`mrp`";
            break;
        case "piece_count":
            $columnName = "`products`.`piece_count`";
            break;
        default:
            $columnName = "`products`.`id`";
    }
    $inventory->columnName     = $columnName;
    $inventory->columnSortOrder = $columnSortOrder;

    ## filer count check
    $stmt = $inventory->serverProductCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $inventory->serverProductCheck();
    $data = $inventory->serverReadProduct($stmt);
    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
}
