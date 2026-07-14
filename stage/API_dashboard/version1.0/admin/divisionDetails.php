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
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " AND ( 
        `products__category`.`name` LIKE '%".$searchValue."%' ) ";
    }
    ## Total number of records without filtering
    $stmt=$inventory->divisionCheck();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $inventory->searchQuery    = $searchQuery;
    $inventory->rowStart       = $rowStart;
    $inventory->rowperpage     = $rowperpage;
    switch ($columnName1) {
        case "division_name":
            $columnName = "`products__category`.`name`";
        break;
        default:    $columnName = "`products__category`.`id`";
    }
    $inventory->columnName     = $columnName;
    $inventory->columnSortOrder= $columnSortOrder;

    ## filer count check
    $stmt = $inventory->divisionCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $inventory->serverDivisionCheck();
    $data = $inventory->readDivision($stmt);
    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );
    echo json_encode($response);
    $db = null;

}
?>