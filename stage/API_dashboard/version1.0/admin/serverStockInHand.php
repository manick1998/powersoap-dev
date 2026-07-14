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
        `products`.`item_code` LIKE '%".$searchValue."%' OR 
        `products`.`name` LIKE '%".$searchValue."%' OR 
        `products__category`.`name` LIKE '%".$searchValue."%'
        ) ";
    }
    ## Total number of records without filtering
    $stmt=$inventory->productCheck();
    $totalRecords = $stmt->rowCount();
    ## filet query values
    $inventory->searchQuery    = $searchQuery;
    $inventory->rowStart       = $rowStart;
    $inventory->rowperpage     = $rowperpage;
   

//
    switch ($columnName1) {
        case "item_code":
            $columnName = "`products`.`item_code`";
        break;
        case "item_name":
            $columnName = "`products`.`name`";
        break;
        case "item_type":
            $columnName = "`products__category`.`name`";
        break;
        case "stock_in_hand":
            $columnName = "`stock__admin`.`stock_in_hand`";
        break;
        default:    $columnName = "`products`.`id`";
    }
    
    $inventory->columnName     = "`products`.`delete_status` ASC, `products__category`.`name` ASC, " . $columnName;
    $inventory->columnSortOrder= $columnSortOrder;

    ## filer count check
    $stmt = $inventory->serverProductCheckfilter();
    $totalRecordwithFilter = $stmt->rowCount();
    ## pick limit datas
    $stmt = $inventory->serverStockCheck();
    $data = $inventory->readServerStock($stmt);
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