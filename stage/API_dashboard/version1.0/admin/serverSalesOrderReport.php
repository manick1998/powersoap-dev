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
if($_POST['v_id'] == $verification_code){
    include_once '../config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    include_once '../objects/order.php';
    $order = new Order($db);
    $order->orderType = $_POST['orderType'];
    $order->from_date  = date("Y-m-d 00:00:00", strtotime($_POST['from_date'])); 
    $order->to_date    = date("Y-m-d 23:59:59", strtotime($_POST['to_date']));
    if($_POST["status"] == 'Overall'){
       $order->status  = " "; 
    }else{
       $order->status  = "AND `orders`.`delivery`='".$_POST['status']."' ";    
    }
    if($order->orderType == "Distributor Order"){
        ## Search 
        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " AND ( 
            `orders`.`order_number` LIKE '%".$searchValue."%' OR 
            `employees`.`name` LIKE '%".$searchValue."%' OR 
            `orders`.`items` LIKE '%".$searchValue."%' OR 
            `orders`.`delivery` LIKE '%".$searchValue."%'
            ) ";
        }
        if($_POST["state"] == '0'){
           $order->state  = " "; 
        }else{
           $order->state  = "AND `employees`.`state_id`='".$_POST['state']."' ";    
        }
        ## Total number of records without filtering
        $stmt=$order->distributorOrderReportCount();
        $totalRecords = $stmt->rowCount();
        ## filet query values
        $order->searchQuery    = $searchQuery;
        $order->rowStart       = $rowStart;
        $order->rowperpage     = $rowperpage;
        switch ($columnName1) {  
            case "order_number":
                $columnName = "`orders`.`order_number`";
            break;
            case "date_time":
                $columnName = "`orders`.`date_time`";
            break;
            case "sales_man":
                $columnName = "`employees`.`name`";
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
        $stmt1 = $order->distributorOrderReportSearch();
        $totalRecordwithFilter = $stmt1->rowCount();  
        ## pick limit datas
        $stmt = $order->serverDistributorOrderReport();
        $data = $order->serverReadDistributorOrder($stmt);
       
    }else if($order->orderType == "Sales Order" || $order->orderType == "Spot Order"){
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
        $order->region      = $_POST["region"];
        if($_POST["distributor"]!=''){
            $order->distributor = "AND orders.`distributor_token`='".$_POST["distributor"]."'"; 
        }else{
            $order->distributor =" "; 
        }
        if($_POST["state"] == '0'){
           $order->state  = " "; 
        }else{
           $order->state  = "AND `distributor`.`state_id`='".$_POST['state']."' ";    
        }
        
        if($_POST["orderBy"] == 'Salesrep'){
           $order->order_by  = "AND `orders`.`sales_rep_token` != ' '";      
        }else if($_POST["orderBy"] == 'Salesman'){
           $order->order_by  = "AND `orders`.`employee_token` != '".$_POST['distributor']."' ";    
        }else if($_POST["orderBy"] == 'Distributor'){
          $order->order_by   = "AND `orders`.`employee_token` = '".$_POST['distributor']."' AND `orders`.`sales_rep_token` = ''";     
        }else if($_POST["orderBy"] == 'Salesman'){
        $order->order_by  = "AND `orders`.`employee_token` != '".$_POST['distributor']."' "; 
        }else{
          $order->order_by   = " ";   
        }
        ## Total number of records without filtering
        $stmt=$order->salesOrderReportCount();
        $totalRecords = $stmt->rowCount();
        ## filet query values
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
            default:    $columnName = "`orders`.`id`";
        }
        $order->columnName     = $columnName;
        $order->columnSortOrder= $columnSortOrder;
        ## filer count check
      
        $stmt1 = $order->salesOrderReportSearch();
        $totalRecordwithFilter = $stmt1->rowCount(); 

        ## pick limit datas
        $stmt = $order->serverSalesOrderReport(); 
        $data = $order->serverReadOrderNew($stmt);
    }else{
        ## Search 
        $searchQuery = " ";
        if($searchValue != ''){
            $searchQuery = " AND ( 
            `orders`.`order_number` LIKE '%$searchValue%' OR 
            `shop`.`name` LIKE '%$searchValue%' OR 
            `orders`.`items` LIKE '%$searchValue%' OR 
            `orders`.`delivery` LIKE '%$searchValue%' OR
            `orders`.`date_time` LIKE '%$searchValue%' OR
            `orders`.`delivered_on` LIKE '%$searchValue%'
            ) ";
        }
        $order->region      = $_POST["region"];
        if($_POST["state"] == '0'){
           $order->state  = " "; 
        }else{
           $order->state  = "AND `distributor`.`state_id`='".$_POST['state']."' ";    
        }
        
        ## Total number of records without filtering
        $stmt=$order->retailerOrderReportCount();
        $totalRecords = $stmt->rowCount();
        ## filet query values
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
      
        $stmt1 = $order->retailerOrderReportSearch();
        $totalRecordwithFilter = $stmt1->rowCount(); 

        ## pick limit datas
        $stmt = $order->serverRetailerOrderReport(); 
        $data = $order->serverReadOrderRetailer($stmt);
    }
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