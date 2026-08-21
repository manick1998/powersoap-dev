<?php
class Order
{
    public $conn;
    public $stateQuery;
    public $orderType;
    public $fromDate;
    public $toDate;
    public $dateQuery;
    public $searchQuery;
    public $order_token;
    public $product_token;
    public $admin_token;
    public $distributorToken;
    public $category_token;
    public $price_per_unit;
    public $piece_count;
    public $order_array;
    public $old_quantity;
    public $boxCount;
    public $discount_value;
    public $total_amount;
    public $gst_amount;
    public $offer_percentage;
    public $offer_value;
    public $billAmount;
    public $discount_distributor;
    public $item_count;
    public $division_token;
    public $distributor_quantity;
    public $box_price;
    public $orderToken;
    public $quantity;
    public $productToken;
    public $rowStart;
    public $rowperpage;
    public $columnName;
    public $columnSortOrder;
    public $order_by;
    public $gstAmount;
    public $state_id;
    public $region_id;
    public $from_date;
    public $to_date;
    public $state;
    public $status;
    public $distributor;
    public $region;
    public $selectState;
    public $salesRep;
    public $repToken;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    // function orderCheckCount()
    // {
    //     $stateQuery = $this->stateQuery;
    //     $query = "SELECT  `orders`.`id`
    //     FROM `orders`
    //     INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    //     INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
    //     WHERE `orders`.order_type='Sales Order'";
    //     $stmt = $this->conn->prepare($query);
    //     //$stmt->bindParam(1, $this->orderType);
    //     $stmt->execute();
    //     return $stmt;
    // }
    
          function orderCheckCount()
    {
        $stateQuery = $this->stateQuery;
        // JOINs removed for count, using COUNT(id) for fast execution
        $query = "SELECT COUNT(`orders`.`id`) as total
        FROM `orders`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.order_type='Sales Order'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    function orderCheckCountRetailer()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.order_type=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function orderCheck()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckAll()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckDateRange()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`date_time` BETWEEN ? AND ?
        AND `orders`.order_type=?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->fromDate);
        $stmt->bindParam(2, $this->toDate);
        $stmt->bindParam(3, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckDateRangeAll()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`date_time` BETWEEN ? AND ?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->fromDate);
        $stmt->bindParam(2, $this->toDate);
        $stmt->execute();
        return $stmt;
    }
    function readOrder($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->order_token    = $row['token'];
            $obj->employee_token = $row['employee_token'];
            $obj->date_time      = nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time'])));
            $obj->date_value     = date("Y-m-d", strtotime($row['date_time']));
            $obj->shop_name      = $row['shop_name'];
            $obj->sales_man      = $row['sales_man'];
            $obj->items          = $row['items'];
            $obj->billing_amount = $row['billing_amount'];
            if ($row['delivery'] == "Completed") {
                $obj->delivery       = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $obj->delivery       = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else {
                $obj->delivery       = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            $obj->delivery_value     = $row['delivery'];
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $obj->delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $obj->delivered_on   = "-";
            }
            $obj->delivered_on_value = $row['delivered_on'];
            $obj->outstanding    = round((float)$row['billing_amount'] - (float)$row['paid_amount'], 2);
            array_push($array, $obj);
        }
        return $array;
    }

    function orderCheckFilter()
    {
        $dateQuery   = $this->dateQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.`order_type`=?
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    //    function orderCheckFilterSearch(){
    //        $searchQuery   = $this->searchQuery;
    //        $query = "SELECT  `orders`.`id`
    //        FROM `orders`
    //        INNER JOIN `shop` ON `shop`.`token` = `orders`.`shop_token`
    //        RIGHT JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
    //        WHERE 1
    //        $searchQuery AND `orders`.`order_type`=?
    //        ORDER BY `orders`.`id` DESC";
    //        $stmt = $this->conn->prepare( $query );
    //        $stmt->bindParam(1, $this->orderType);
    //        $stmt->execute();
    //        return $stmt;
    //    }    
    function orderCheckFilterSearch()
    {
        $searchQuery   = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE 1
        $searchQuery AND `orders`.`order_type`=?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    // function orderCheckFilterNew()
    // {
    //     $dateQuery   = $this->dateQuery;
    //     $stateQuery = $this->stateQuery;
    //     $query = "SELECT  `orders`.`id`
    //     FROM `orders`
    //     INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    //     INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token` = `salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token` $stateQuery
    //     WHERE `orders`.`order_type`='Sales Order'
    //     $dateQuery
    //     ORDER BY `orders`.`id` DESC";
    //     $stmt = $this->conn->prepare($query);
    //     //$stmt->bindParam(1, $this->orderType);
    //     $stmt->execute();
    //     return $stmt;
    // }
    
    
    function orderCheckFilterNew()
    {
        $dateQuery   = $this->dateQuery;
        $stateQuery = $this->stateQuery;
        // JOINs removed for count, using COUNT(id) for fast execution
        $query = "SELECT COUNT(`orders`.`id`) as total
        FROM `orders`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.`order_type`='Sales Order'
        $dateQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    
    function orderCheckFilterNewRetailer()
    {
        $dateQuery   = $this->dateQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token` = `salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token` $stateQuery
        WHERE `orders`.`order_type`=?
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    // function orderCheckFilterSearchNew()
    // {
    //     $searchQuery   = $this->searchQuery;
    //     $stateQuery = $this->stateQuery;
    //     $query = "SELECT  `orders`.`id`
    //     FROM `orders`
    //     INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    //     INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
    //     WHERE 1
    //     $searchQuery AND `orders`.`order_type`='Sales Order'
    //     ORDER BY `orders`.`id` DESC";
    //     $stmt = $this->conn->prepare($query);
    //     // $stmt->bindParam(1, $this->orderType);
    //     $stmt->execute();
    //     return $stmt;
    // }
   
   
    function orderCheckFilterSearchNew()
    {
        $searchQuery   = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        // Here we need all joins because search has shop_name, salesman_name etc.
        $query = "SELECT COUNT(`orders`.`id`) as total
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE 1
        $searchQuery AND `orders`.`order_type`='Sales Order'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
   
   
    function orderCheckFilterSearchNewRetailer()
    {
        $searchQuery   = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE 1
        $searchQuery AND `orders`.`order_type`=?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function orderHistoryCheckCount()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.order_type!='Distributor Order'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function orderHistoryCheckFilter()
    {
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.`order_type`!='Distributor Order'
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function orderHistoryCheckSearch()
    {
        $stateQuery = $this->stateQuery;
        $searchQuery   = $this->searchQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        INNER JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE `orders`.`order_type`!='Distributor Order'
        $searchQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverOrderCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `sales_man`.`name` AS `sales_man_name`,
        `sales_man`.`admin_distributor_token` AS `distributor_token`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE 1
        $searchQuery
        $dateQuery
        AND `orders`.order_type=?
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    // function serverOrderCheckNew()
    // {
    //     $rowStart    = $this->rowStart;
    //     $rowperpage  = $this->rowperpage;
    //     $searchQuery = $this->searchQuery;
    //     $stateQuery = $this->stateQuery;
    //     $dateQuery   = $this->dateQuery;
    //     $columnName  = $this->columnName;
    //     $columnSortOrder = $this->columnSortOrder;
    //     $order_by = $this->order_by;
    //     $query = "SELECT  `orders`.`token`,
    //     `orders`.`order_number`,
    //     `orders`.`date_time`,
    //     `shop`.`name` AS `shop_name`,
    //     `salesman`.`name` AS `sales_man_name`,
    //     `distributor`.`name` AS `distributor_name`,
    //     `orders`.`items`,
    //     `orders`.`delivery`,
    //     `orders`.`delivered_on`,
    //     `orders`.`is_slaes_rep_admin`,
    //     `orders`.`sales_rep_token`,
    //     `orders`.`billing_amount`
    //     FROM
    //     `orders`
    //     INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    //     INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
    //     WHERE `orders`.order_type ='Sales Order' $dateQuery  $stateQuery  $order_by
    //     $searchQuery
    //     GROUP BY `orders`.`token`
    //     ORDER BY $columnName $columnSortOrder
    //     LIMIT $rowStart,$rowperpage";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    //     return $stmt;
    // }

       function serverOrderCheckNew()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $order_by = $this->order_by;
        
        // Removed GROUP BY orders.token to prevent temporary table creation and filesort
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `salesman`.`name` AS `sales_man_name`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`is_slaes_rep_admin`,
        `orders`.`sales_rep_token`,
        `orders`.`billing_amount`
        FROM
        `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        WHERE `orders`.order_type ='Sales Order' $dateQuery  $stateQuery  $order_by
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    
    
    
    //     function serverReadOrderNew($stmt) {
    //        $data = array();
    //        $slno = $this->rowStart;
    //
    //        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //            
    //            $slno++;
    //            if($row['delivery']=="Completed"){
    //                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
    //            }else if($row['delivery']=="Pending"){
    //                $delivery  = '<button class="tb-btn voliet">'.$row['delivery'].'</button>';
    //            }else if($row['delivery']=="Approved"){
    //                $delivery  = '<button class="tb-btn nav-blue">'.$row['delivery'].'</button>';
    //            }else{
    //                $delivery  = '<button class="tb-btn red">'.$row['delivery'].'</button>'; 
    //            }
    //            if($row['delivered_on']!=null && $row['delivered_on']!="0000-00-00 00:00:00"){
    //                $delivered_on   = nl2br(date("d/m/Y \n h:i A",strtotime($row['delivered_on'])));
    //            }else{
    //                $delivered_on   = "-";
    //            }
    //            if($row['is_slaes_rep_admin']=='1'){
    //                $query20 = "SELECT `employees`.`name` AS `salesRepName` FROM `orders` INNER JOIN `employees` ON `orders`.`sales_rep_token` = `employees`.`token` WHERE `orders`.`sales_rep_token`=".$row['sales_rep_token'];
    //                $stmt20 = $this->conn->prepare( $query20 );
    //                $stmt20->execute();
    //                $row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
    //                $sales_rep = $row20["salesRepName"];
    //                $query21 = "SELECT `employees`.`name` AS `dist_name` FROM `orders` INNER JOIN `employees` ON `orders`.`distributor_token` = `employees`.`token` WHERE `orders`.`token`=".$row['token'];
    //                $stmt21 = $this->conn->prepare( $query21 );
    //                $stmt21->execute();
    //                $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
    //                $distributor_name = $row21["dist_name"];
    //            }else{
    //                $sales_rep = $row["sales_man_name"];
    //                $distributor_name = $row["distributor_name"];
    //            }
    //            $data[] = array(
    //                "order_token"=>$row['token'],
    //                "order_number"=>'<a class="view_link" >'.$row['order_number'].'</a>',
    //                "distributor_name"=>$distributor_name,
    //                "date_time"=>nl2br(date("d/m/Y \n h:i A",strtotime($row['date_time']))),
    //                "shop_name"=>$row['shop_name'],
    //                "sales_man"=>$sales_rep,
    //                "items"=>$row['items'],
    //                "delivery"=>$delivery,
    //                "delivered_on"=>$delivered_on,
    //                "billing_amount"=>$row['billing_amount']
    //            );
    //        }
    //        return $data;
    //    }

    //Retailer server details
    function serverOrderCheckNewRetailer()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
    `orders`.`order_number`,
    `orders`.`date_time`,
    `shop`.`name` AS `shop_name`,
    `salesman`.`name` AS `sales_man_name`,
    `distributor`.`name` AS `distributor_name`,
    `orders`.`items`,
    `orders`.`delivery`,
    `orders`.`delivered_on`,
    `orders`.`billing_amount`
    FROM
    `orders`
    INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
    INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
    WHERE `orders`.order_type =?
    $searchQuery
    $dateQuery
    GROUP BY `orders`.`token`
    ORDER BY $columnName $columnSortOrder
    LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function orderCheckFilterForDistributor()
    {
        $dateQuery   = $this->dateQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token` $stateQuery
        WHERE `orders`.`order_type`=?
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckFilterFroDistributorSearch()
    {
        $searchQuery   = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token` $stateQuery
        WHERE 1
        $searchQuery AND `orders`.`order_type`=?
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function serverDistributorOrderCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`billing_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token` {$stateQuery}
        WHERE 1
        {$searchQuery}
        {$dateQuery}
        AND `orders`.order_type=?
        ORDER BY {$columnName} {$columnSortOrder}
        LIMIT {$rowStart},{$rowperpage}";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function serverOrderHistoryCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `sales_man`.`name` AS `sales_man_name`,
        `sales_man`.`admin_distributor_token` AS `distributor_token`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`
        FROM `orders`
        INNER JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        WHERE 1
        $searchQuery
        $dateQuery
        AND `orders`.order_type!='Distributor Order'
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverReadOrder($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $delivery  = '<button class="tb-btn nav-blue">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "distributor_name" => $row['distributor_name'],
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $row['sales_man_name'],
                "items" => $row['items'],
                "billing_amount" => $row['billing_amount'] == '' ? ' - ' : moneyFormatIndia($row['billing_amount']),
                "delivery" => $delivery,
                "delivered_on" => $delivered_on
            );
        }
        return $data;
    }
    function serverReadDistributorOrder($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $delivery  = '<button class="tb-btn nav-blue">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $row['sales_man'],
                "items" => $row['items'],
                "delivery" => $delivery,
                "delivered_on" => $delivered_on,
                "billing_amount" => $row['billing_amount'] == '' ? ' - ' : ($row['billing_amount'])
            );
        }
        return $data;
    }
    function readOrderDist($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->order_token    = $row['token'];
            $obj->employee_token = $row['employee_token'];
            $obj->date_time      = nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time'])));
            $obj->date_value     = date("Y-m-d", strtotime($row['date_time']));
            $obj->shop_name      = $row['shop_name'];
            $obj->sales_man      = $row['sales_man'];
            $obj->items          = $row['items'];
            $obj->billing_amount = $row['billing_amount'];

            if ($row['delivery'] == "Completed") {
                $obj->delivery       = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $obj->delivery       = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn greenbtn status-widget">' . $row['delivery'] . '</button>';
            } else {
                $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn red status-widget">' . $row['delivery'] . '</button>';
            }
            $obj->delivery_value     = $row['delivery'];
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $obj->delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $obj->delivered_on   = "-";
            }
            $obj->delivered_on_value = $row['delivered_on'];
            $obj->outstanding    = round((float)$row['billing_amount'] - (float)$row['paid_amount'], 2);
            array_push($array, $obj);
        }
        return $array;
    }

    function singleOrderDetail()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `orders`.`distributor_token`,
        `orders`.`order_type`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`,
        `orders`.`invoice_name`,
        `orders`.`approved_on`,
        `orders__items`.`offer_amount`
        FROM `orders`
        LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        LEFT JOIN `orders__items` ON `orders__items`.`order_token` = `orders`.`token`
        WHERE `orders`.token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function readSingleOrder($stmt, $baseUrlPath)
    {
        $total_tcs_amount =0;
        $total_final_amount=0;
        $total_final=0;
    
        $date = new DateTime('2023-04-01');
        $parts = explode('-', '2023-04-01');
        $year1 = $parts[0];
        $year = date('Y');
        if($year!=$year1){
        $date->modify('+1 years');
    }else{
        $date = new DateTime('2023-04-01');
    }
        $value =$date->format('Y-m-d');
    
        $date1 = new DateTime('2024-03-01');
        $parts = explode('-', '2024-03-01');
        $year1 = $parts[0];
        $year = date('Y');
        if($year!=$year1){
        $date1 = new DateTime('2024-03-01');
    }else{
        $date1->modify('+1 years');
    }
        $value1 =$date1->format('Y-m-d');
        
        
        $array = [];
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $query2=("SELECT SUM(billing_amount)AS `total` FROM `orders` WHERE date(date_time) BETWEEN '$value' AND '$value1' AND employee_token='".$row["employee_token"]."' AND order_type='Distributor Order'");
        $stmt21 = $this->conn->prepare( $query2 );
        $stmt21->execute();
        $row23 = $stmt21->fetch(PDO::FETCH_ASSOC);
        $total_tcs=$row23["total"];
        $total_final = $row["offer_amount"];
        if($total_tcs > 5000000){
            $total_tcs_amount =  ($total_final)/1000;
            $total_final_amount = $total_final+$total_tcs_amount;
            $total_final_amount= $row['billing_amount']*0.001;
        }
        $obj = new stdClass;
        $obj->order_token    = $row['token'];
        $obj->employee_token = $row['employee_token'];
        $obj->order_number   = $row['order_number'];
        $obj->date_time      = date("d/m/Y (h:i A)", strtotime($row['date_time']));
        $obj->date_value     = date("Y-m-d", strtotime($row['date_time']));
        $obj->shop_name      = $row['shop_name'];
        $obj->sales_man      = $row['sales_man'];
        $obj->items          = $row['items'];
        $obj->tcs_amount =$total_final_amount;
        if ($row['invoice_name'] == "") {
            $obj->invoice_url    = "";
        } else {
            $obj->invoice_url    = $baseUrlPath . "invoice_pdf/" . $row['invoice_name'];
        }
        $obj->invoice_name = $row['invoice_name'];
        $gst_query = "SELECT SUM(`misc_price`) AS `total_gst` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1'";
        $stmt_gst_sum = $this->conn->prepare($gst_query);
        $stmt_gst_sum->bindParam(1, $row['token']);
        $stmt_gst_sum->execute();
        $gst_row = $stmt_gst_sum->fetch(PDO::FETCH_ASSOC);
        $exact_gst_amount = isset($gst_row['total_gst']) ? round((float)$gst_row['total_gst'], 2) : 0;

        $obj->billing_amount = round($row['billing_amount']);
        $obj->gst_amount     = $exact_gst_amount;
        $mrp_amount          = round((float)$row['billing_amount'] - $exact_gst_amount, 2);
        $obj->mrp_amount     = $mrp_amount;
        if ($row['delivery'] == "Completed") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn greenbtn status-widget">Completed</button>';
            //'.$row['delivery'].'
        } else if ($row['delivery'] == "Pending") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn voliet status-widget">' . $row['delivery'] . '</button>';
        } else if ($row['delivery'] == "Approved") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn nav-blue status-widget">' . $row['delivery'] . '</button>';
        } else {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn red status-widget">' . $row['delivery'] . '</button>';
        }
        $obj->delivery_value     = $row['delivery'];
        if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
            $obj->delivered_on   = nl2br(date("d/m/Y (h:i A)", strtotime($row['delivered_on'])));
        } else {
            $obj->delivered_on   = "-";
        }
        $obj->delivered_on_value = $row['delivered_on'];

        if ($row['approved_on'] != null && $row['approved_on'] != "0000-00-00 00:00:00") {
            $obj->approved_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['approved_on'])));
        } else {
            $obj->approved_on   = "-";
        }
        $obj->approved_on_value = $row['approved_on'];

        $obj->paid_amount    = $row['paid_amount'];
        $obj->outstanding    = round((float)$row['billing_amount'] - (float)$row['paid_amount'], 2);

        array_push($array, $obj);
        return $array;
    }
    function singleOrderItemDetail()
    {
        $query = "SELECT
        `products`.`item_code` AS `item_code`,
        `products`.`name` AS `item_name`,
        `products`.`category_token` AS `category_token`,
        `orders__items`.`quantity`,
        `orders__items`.`price_per_unit`,
        `orders__items`.`misc_price`,
        `orders__items`.`units`,
        `orders__items`.`product_token`,
        `orders__items`.`offer_amount`,
        `orders__items`.`offer_percentage`,
        `orders__items`.`discount_distributor`,
        `products`.`piece_count`,
        `orders__items`.`is_free`,
        `products`.`gst`
    FROM
        `orders`
    INNER JOIN `orders__items` ON `orders__items`.`order_token` = `orders`.`token`
    INNER JOIN `products` ON `products`.`token` = `orders__items`.`product_token`
    WHERE
        `orders`.`token` = ? AND `orders__items`.`delete_status` = '1'
    ORDER BY
        `products`.`name`,
        `orders__items`.`is_free` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function readSingleOrderItemDetail($stmt)
    {
       
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->product_token = $row['product_token'];
            $obj->item_code     = $row['item_code'];
            $obj->item_name     = $row['item_name'];
            $obj->distributor_quantity  = $row['quantity'];
            $obj->price_per_unit = $row['price_per_unit'];
            $obj->misc_price    = $row['misc_price'];
            $obj->offer_percentage    = $row['offer_percentage'];
            $obj->discount_distributor    = $row['discount_distributor'];
            //$obj->quantity_plus_piece = $row['quantity']*$row['piece_count'];
            $obj->quantity_plus_piece = $row['quantity'];
            $obj->category_token = $row['category_token'];
            $obj->piece_count = $row['piece_count'];
            $obj->is_free = $row['is_free'];
            $obj->gst = isset($row['gst']) && $row['gst'] !== '' ? floatval($row['gst']) : 18;
            $gst_multiplier = 1 + ($obj->gst / 100);
            
            $misc_price_val = isset($row['misc_price']) ? floatval($row['misc_price']) : 0.0;
            $offer_amount_val = isset($row['offer_amount']) ? floatval($row['offer_amount']) : 0.0;
            
            $obj->gst_rupee = number_format($misc_price_val, 2, '.', '');
            $obj->amount    = number_format($offer_amount_val - $misc_price_val, 2, '.', '');
            $obj->total     = number_format($offer_amount_val, 2, '.', '');

            // $obj->scheme_name = $row['scheme_name'];
            if ($row['units'] == "Box") {
                $obj->quantity      = $row['quantity'];
                $box_price_incl     = $row['piece_count'] * $row['price_per_unit'];
                $box_price_taxable  = $box_price_incl / $gst_multiplier;
                $obj->box_price     = number_format($box_price_taxable, 2, '.', '');
                $obj->total_amount  = round((float)$row['piece_count'], 2);
                $obj->units         = $row['units'] . "(" . $row['piece_count'] . " Nos)";
            } else {
                $obj->quantity      = $row['quantity'];
                $box_price_incl     = $row['piece_count'] * $row['price_per_unit'];
                $box_price_taxable  = $box_price_incl / $gst_multiplier;
                $obj->box_price     = number_format($box_price_taxable, 2, '.', '');
                $obj->total_amount  = round((float)$row['piece_count'], 2);
                $obj->units         = $row['units'];
            }
            array_push($array, $obj);
        }
        return $array;
    }
    function readSingleOrderPayment()
    {
        $array = [];
        //        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //        $obj = new stdClass;
        //        $obj->date_time     = "06/25/2022 11:48 PM";
        //        $obj->mode          = "Cash";
        //        $obj->paid_amout    = "1000";
        //        array_push($array, $obj);
        //        array_push($array, $obj);
        //        }
        return $array;
    }
    function approveDistributorOrder($indiaDateTime)
    {
        $query = "UPDATE `orders` SET
        `delivery`='Approved',
        `approved_on`='$indiaDateTime'
        WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function deliverDistributorOrder($indiaDateTime)
    {
        $query = "UPDATE `orders` SET
        `delivery`='Completed',
        `delivered_on`='$indiaDateTime'
        WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function productStockCheck()
    {
        $query = "SELECT `id` FROM `stock__admin` 
        WHERE `product_token`=:product_token 
        AND `stock_in_hand`>=:stock_in_hand";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->bindParam('stock_in_hand', $this->quantity);
        $stmt->execute();
        return $stmt;
    }
    function stockProductQuantity()
    {
        $query = "SELECT `stock_in_hand` FROM `stock__admin` 
        WHERE `product_token`=:product_token ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['stock_in_hand'];
    }
    function distributorProductQuantity()
    {
        $query = "SELECT `stock_in_hand` FROM `stock__distributor` 
        WHERE `product_token`=:product_token 
        AND `employee_token`=:employee_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->bindParam('employee_token', $this->distributorToken);
        $stmt->execute();
        $checkCount = $stmt->rowCount();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($checkCount == 0) {
            return false;
        } else {
            return $row['stock_in_hand'];
        }
    }

    function updateAdminStock($updateQuantity)
    {
        $query = "UPDATE `stock__admin` SET `stock_in_hand`=? WHERE `product_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $updateQuantity);
        $stmt->bindParam(2, $this->productToken);
        $stmt->execute();
        return $stmt;
    }


    //stock reports
    function updateAdminStockReports($updateQuantity)
    {
        $query = "UPDATE `stock__report` SET `closing_stock`=? WHERE `product_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $updateQuantity);
        $stmt->bindParam(2, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    function stockClose($indiaDate)
    {
        $query = "SELECT `closing_stock` FROM `stock__report` 
        WHERE `product_token`=:product_token AND `date`='$indiaDate' ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['closing_stock'];
    }

    function stockOpen($indiaDate)
    {
        $query = "SELECT `opening_stock` FROM `stock__report` 
        WHERE `product_token`=:product_token AND `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['opening_stock'];
    }

    function StockReports($salesStock, $indiaDate)
    {
        $query = "UPDATE `stock__report` SET `sales_stock`=? WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $salesStock);
        $stmt->bindParam(2, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    function updateDistributorStock($updateQuantity)
    {
        $query = "UPDATE `stock__distributor` SET `stock_in_hand`=? WHERE `product_token`=? AND `employee_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $updateQuantity);
        $stmt->bindParam(2, $this->productToken);
        $stmt->bindParam(3, $this->distributorToken);
        $stmt->execute();
        return $stmt;
    }
    function insertDistributorStock($updateQuantity, $indiaDateTime)
    {
        $query = "INSERT INTO `stock__distributor` SET `product_token`=:product_token,
        `pro_cat_token`='',
        `employee_token`=:employee_token,
        `stock_in_hand`=:stock_in_hand,
        `monthly_avg`='',
        `mfs`='',
        `status`=''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $this->productToken);
        $stmt->bindParam('employee_token', $this->distributorToken);
        $stmt->bindParam('stock_in_hand', $updateQuantity);
        $stmt->execute();
        return $stmt;
    }
    function cancelOrder($indiaDateTime)
    {
        $query = "UPDATE `orders` SET `delivery`='Cancelled', `delivered_on`='$indiaDateTime' WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function getDivisionByDistributor()
    {
        $divisionQuery = "SELECT
        `products__category`.`token` AS `division_token`,
        `products__category`.`name` AS `division_name`,
        GROUP_CONCAT(concat(`products`.`token`,'&&&&',`products`.`name`,'&&&&',`products`.`item_code`,'&&&&',`products`.`piece_count`),'****') AS `products_details`
        FROM
        `orders`
        INNER JOIN `employees__division_mapping` ON `orders`.`employee_token` = `employees__division_mapping`.`employee_token`
        INNER JOIN `products__category` ON `employees__division_mapping`.`division_token` = `products__category`.`token`
        INNER JOIN `products` ON `products__category`.`token` = `products`.`category_token`
        WHERE
        `orders`.`token` =? AND `employees__division_mapping`.`delete_status`='1' AND products.delete_status='1' GROUP BY `products__category`.`token`";
        $stmtDivision = $this->conn->prepare($divisionQuery);
        $stmtDivision->bindParam(1, $this->orderToken);
        $stmtDivision->execute();
        return $stmtDivision;
    }
    function readDivisionCount($divisions)
    {
        $divsion = [];
        while ($row1 = $divisions->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->division_token = $row1["division_token"];
            $obj->division_name = $row1["division_name"];
            $product_string  = rtrim($row1["products_details"], '****');
            $product_details = explode("****,", $product_string);
            $details      = [];
            foreach ($product_details as $productData) {
                $prod_data = explode("&&&&", $productData);
                $obj2 = new stdClass();
                $obj2->product_token = $prod_data[0];
                $obj2->product_name = $prod_data[1];
                $obj2->product_item_code = $prod_data[2];
                $obj2->product_piece_count = $prod_data[3];
                array_push($details, $obj2);
            }
            $obj->product_list = $details;
            array_push($divsion, $obj);
        }
        return $divsion;
    }
    function addDiscountDistributor()
    {
        $updatequery = "UPDATE `orders__items` SET `misc_price`=?, `discount_distributor`=?,`offer_amount`=? WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1'";
        $stmt1 = $this->conn->prepare($updatequery);
        $stmt1->bindParam(1, $this->gst_amount);
        $stmt1->bindParam(2, $this->discount_value);
        $stmt1->bindParam(3, $this->total_amount);
        $stmt1->bindParam(4, $this->order_token);
        $stmt1->bindParam(5, $this->product_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function deleteDistributorOrderItem()
    {
        $updatequery = "UPDATE `orders__items` SET `delete_status`='2' WHERE `order_token`=? AND `product_token`=?";
        $stmt1 = $this->conn->prepare($updatequery);
        $stmt1->bindParam(1, $this->order_token);
        $stmt1->bindParam(2, $this->product_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function selectOrderItemCount()
    {
        $querysel = "SELECT count(`order_token`) AS `item_count`  FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1' AND `is_free`='0'";
        $stmtsel = $this->conn->prepare($querysel);
        $stmtsel->bindParam(1, $this->order_token);
        $stmtsel->execute();
        $row1 = $stmtsel->fetch(PDO::FETCH_ASSOC);
        $itemCount = $row1["item_count"];
        return $itemCount;
    }
    function updateOrderItemCount()
    {
        $updatequery = "UPDATE `orders` SET `items`=? WHERE `token`=?";
        $stmt1 = $this->conn->prepare($updatequery);
        $stmt1->bindParam(1, $this->item_count);
        $stmt1->bindParam(2, $this->order_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function addItemInDistributorOrder($indiaDateTime)
    {
        $addquery = "INSERT INTO `orders__items`
        SET `order_token`=:order_token,
        `product_token`=:product_token,
        `price_per_unit`='0',
        `piece_count`='0',
        `misc_price`='0',
        `quantity`=:boxCount,
        `return_qty`='0',
        `offer_token`='0',
        `offer_percentage`='0',
        `offer_amount`='0',
        `free_product`='0',
        `discount_distributor`='0',
        `units`='Box',
        `delete_status`='1',
        `date_time`='$indiaDateTime'";
        $addstmt = $this->conn->prepare($addquery);
        $addstmt->bindParam('order_token', $this->order_token);
        $addstmt->bindParam('product_token', $this->product_token);
        $addstmt->bindParam('boxCount', $this->boxCount);
        $addstmt->execute();
        return $addstmt;
    }
    // function updateDivisionOfferAmount($indiaDateTime, $state)
    // {
    //     $array = $this->order_array;
    //     $order_token = $this->order_token;
    //     $total_final_amount = 0;
    //     $productsArray = [];
    //     foreach ($array as $value) {
    //         array_push($productsArray, $value->product_token);
    //     }

    //     $productQuery = implode("','", $productsArray);
    //     $query21 = "SELECT `products__category`.`token` AS `division_token`,
    //     `products__category`.`name` AS `division_name`,
    //     GROUP_CONCAT(	CONCAT(
    //     `products`.`name`,'&&&&',
    //     `products`.`token`,'&&&&',
    //     `products`.`mrp`,'&&&&',
    //     `products`.`total_cost`,'&&&&',
    //     `products`.`piece_count`,'&&&&',
    //     `products`.`item_code`,'&&&&',
    //     `products`.`batch_number`,'&&&&',
    //     `products`.`gst`
    //     ),	'****') AS `product_details`
    //     FROM `products__category`
    //     INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
    //     WHERE `products`.`token` IN ('$productQuery')
    //     GROUP BY `products__category`.`token`";
    //     $stmt21 = $this->conn->prepare($query21);
    //     $stmt21->execute();
    //     while ($row21 = $stmt21->fetch(PDO::FETCH_ASSOC)) {
    //         $division_token  = $row21['division_token'];
    //         $product_string  = rtrim($row21["product_details"], '****');
    //         $product_details = explode("****,", $product_string);
    //         $details      = [];
    //         $total_amount = 0;
    //         foreach ($product_details as $productData) {
    //             $prod_data = explode("&&&&", $productData);
    //             foreach ($array as $value) {
    //                 if ($value->product_token == $prod_data[1]) {
    //                     $quantity  = $value->quantity;
    //                 }
    //             }
    //             $amount        = $quantity * $prod_data[3] * $prod_data[4];
    //             $total_amount += $amount;
    //             $obj2 = new stdClass();
    //             $obj2->product_token     = $prod_data[1];
    //             $obj2->product_total_cost = $prod_data[3];
    //             $obj2->piece_count       = $prod_data[4];
    //             $obj2->quantity          = $quantity;
    //             $obj2->amount            = number_format($amount, 2, '.', '');
    //             $obj2->final_amount      = number_format($amount, 2, '.', '');
    //             $obj2->gst_percent       = isset($prod_data[7]) && $prod_data[7] !== '' ? $prod_data[7] : 0;
    //             array_push($details, $obj2);
    //         }
    //         $resultOffer = "SELECT `admin_offers`.`token`,
    //         `admin_offers`.`offer_percentage`,
    //         `admin_offers`.`offer_name`
    //         FROM `admin_offers` 
    //         WHERE `division_token`='$division_token'
    //         AND `minimum_purchase_amount`<='$total_amount'
    //         AND `status`='1' AND `state_id` ='$state'
    //         ORDER BY `minimum_purchase_amount` DESC
    //         LIMIT 0,1";
    //         $stmtOffer1 = $this->conn->prepare($resultOffer);
    //         $stmtOffer1->execute();
    //         $row22 = $stmtOffer1->fetch(PDO::FETCH_ASSOC);
    //         $obj = new stdClass();
    //         if ($stmtOffer1->rowCount() > 0) {
    //             $offer_percentage = $row22["offer_percentage"];
    //             $offer_token = $row22["token"];
    //             $offer_name = $row22["offer_name"];
    //         } else {
    //             $offer_percentage = 0;
    //             $offer_token     = '';
    //             $offer_name      = '';
    //         }

    //         $div_discount_amount   = $total_amount * $offer_percentage / 100;
    //         $final_amount          = $total_amount - $div_discount_amount;
    //         $units = 'Box';
    //         foreach ($details as $value) {
    //             $product_discount_amount = $value->amount * $offer_percentage / 100;
    //             $product_final_amount    = number_format($value->amount - $product_discount_amount, 2, '.', '');
    //             $value->discount_percent = $offer_percentage;

    //             $gst_rate = $value->gst_percent;
    //             $gst_multiplier = 1 + ($gst_rate / 100);
    //             $gst_amount = number_format($product_final_amount / $gst_multiplier * $gst_rate / 100, 2, '.', '');
    //             //echo 'haii',$value->product_token;
    //             $order_product = "UPDATE `orders__items` SET `product_token`='$value->product_token', `price_per_unit`='$value->product_total_cost', `piece_count`='$value->piece_count', `misc_price`='$gst_amount', `quantity`='$value->quantity', `offer_token`='$offer_token', `offer_percentage`='$value->discount_percent', `offer_amount`='$product_final_amount', `units`='$units', `date_time`='$indiaDateTime' WHERE `order_token`='$order_token' AND `product_token`='$value->product_token' AND `delete_status`='1' AND `is_free`='0'";
    //             $stmt_order = $this->conn->prepare($order_product);
    //             $stmt_order->execute();
    //         }
    //         $total_final_amount += number_format($final_amount, 2, '.', '');
    //     }
    //     $update_order = "UPDATE `orders` SET `billing_amount`='$total_final_amount' WHERE `token`='$order_token'";
    //     $stmt_update = $this->conn->prepare($update_order);
    //     if ($stmt_update->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

   
    

    function updateDivisionOfferAmount($indiaDateTime, $state)
    {
        $array = $this->order_array;
        $order_token = $this->order_token;
        $total_final_amount = 0;
        $productsArray = [];
        
        if (empty($array)) {
            return false;
        }

        foreach ($array as $value) {
            array_push($productsArray, $value->product_token);
        }

        $productQuery = implode("','", $productsArray);

        // Fetch products directly without fragile GROUP_CONCAT
        $queryProducts = "SELECT 
            `products`.`token` AS `product_token`,
            `products`.`category_token` AS `division_token`,
            `products`.`total_cost` AS `product_total_cost`,
            `products`.`piece_count`,
            `products`.`gst`
            FROM `products`
            WHERE `products`.`token` IN ('$productQuery') AND `products`.`delete_status`='1'";
            
        $stmtProd = $this->conn->prepare($queryProducts);
        $stmtProd->execute();
        $productsData = $stmtProd->fetchAll(PDO::FETCH_ASSOC);

        // Group products by division
        $divisionGroups = [];
        foreach ($productsData as $prod) {
            $pToken = $prod['product_token'];
            $qty = 0;
            foreach ($array as $val) {
                if ($val->product_token == $pToken) {
                    $qty = (float)$val->quantity;
                    break;
                }
            }

            $divToken = $prod['division_token'];
            $cost = (float)$prod['product_total_cost'];
            $piece = (float)$prod['piece_count'];
            $gst = (isset($prod['gst']) && $prod['gst'] !== '') ? (float)$prod['gst'] : 0;
            $amt = $qty * $cost * $piece;

            $itemObj = new stdClass();
            $itemObj->product_token = $pToken;
            $itemObj->product_total_cost = $cost;
            $itemObj->piece_count = $piece;
            $itemObj->quantity = $qty;
            $itemObj->amount = $amt;
            $itemObj->gst_percent = $gst;

            if (!isset($divisionGroups[$divToken])) {
                $divisionGroups[$divToken] = [
                    'total_amount' => 0,
                    'items' => []
                ];
            }
            $divisionGroups[$divToken]['total_amount'] += $amt;
            $divisionGroups[$divToken]['items'][] = $itemObj;
        }

        // Process Offer and Update for each Division
        foreach ($divisionGroups as $division_token => $divData) {
            $div_total_amount = $divData['total_amount'];

            $resultOffer = "SELECT `admin_offers`.`token`,
                `admin_offers`.`offer_percentage`,
                `admin_offers`.`offer_name`
                FROM `admin_offers` 
                WHERE `division_token`=:division_token
                AND `minimum_purchase_amount`<=:total_amount
                AND `status`='1' AND `state_id` =:state
                ORDER BY `minimum_purchase_amount` DESC
                LIMIT 0,1";
            $stmtOffer1 = $this->conn->prepare($resultOffer);
            $stmtOffer1->bindParam(':division_token', $division_token);
            $stmtOffer1->bindParam(':total_amount', $div_total_amount);
            $stmtOffer1->bindParam(':state', $state);
            $stmtOffer1->execute();
            $row22 = $stmtOffer1->fetch(PDO::FETCH_ASSOC);

            if ($row22) {
                $offer_percentage = (float)$row22["offer_percentage"];
                $offer_token = $row22["token"];
                $offer_name = $row22["offer_name"];
            } else {
                $offer_percentage = 0;
                $offer_token = '';
                $offer_name = '';
            }

            $div_discount_amount = $div_total_amount * $offer_percentage / 100;
            $final_amount = $div_total_amount - $div_discount_amount;
            $units = 'Box';

            foreach ($divData['items'] as $value) {
                $product_discount_amount = $value->amount * $offer_percentage / 100;
                $product_final_amount = number_format($value->amount - $product_discount_amount, 2, '.', '');
                $gst_rate = $value->gst_percent;
                $gst_multiplier = 1 + ($gst_rate / 100);
                if ($gst_multiplier <= 0) { $gst_multiplier = 1; }
                $gst_amount = number_format($product_final_amount / $gst_multiplier * $gst_rate / 100, 2, '.', '');

                $order_product = "UPDATE `orders__items` SET 
                    `price_per_unit`=:cost, 
                    `piece_count`=:piece, 
                    `misc_price`=:gst_amount, 
                    `quantity`=:quantity, 
                    `offer_token`=:offer_token, 
                    `offer_percentage`=:discount_percent, 
                    `offer_amount`=:product_final_amount, 
                    `units`=:units, 
                    `delete_status`='1',
                    `date_time`=:indiaDateTime 
                    WHERE `order_token`=:order_token 
                    AND `product_token`=:product_token 
                    AND `is_free`='0'";
                
                $stmt_order = $this->conn->prepare($order_product);
                $stmt_order->bindParam(':cost', $value->product_total_cost);
                $stmt_order->bindParam(':piece', $value->piece_count);
                $stmt_order->bindParam(':gst_amount', $gst_amount);
                $stmt_order->bindParam(':quantity', $value->quantity);
                $stmt_order->bindParam(':offer_token', $offer_token);
                $stmt_order->bindParam(':discount_percent', $offer_percentage);
                $stmt_order->bindParam(':product_final_amount', $product_final_amount);
                $stmt_order->bindParam(':units', $units);
                $stmt_order->bindParam(':indiaDateTime', $indiaDateTime);
                $stmt_order->bindParam(':order_token', $order_token);
                $stmt_order->bindParam(':product_token', $value->product_token);
                $stmt_order->execute();
            }

            $total_final_amount += (float)$final_amount;
        }

        $update_order = "UPDATE `orders` SET `billing_amount`=:total_final_amount WHERE `token`=:order_token";
        $stmt_update = $this->conn->prepare($update_order);
        $stmt_update->bindParam(':total_final_amount', $total_final_amount);
        $stmt_update->bindParam(':order_token', $order_token);
        
        return $stmt_update->execute();
    }
   
   
    function selectOrderData()
    {
        $query_order = "SELECT `product_token`, `quantity` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1' AND `is_free`='0'";
        $stmt_order = $this->conn->prepare($query_order);
        $stmt_order->bindParam(1, $this->order_token);
        $stmt_order->execute();
        $order_array1 = [];
        while ($row = $stmt_order->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->product_token = $row["product_token"];
            $obj->quantity = $row["quantity"];
            array_push($order_array1, $obj);
        }
        return $order_array1;
    }

    function updateBillAmts()
    {
        $query1 = "SELECT SUM(`offer_amount`) AS `bill_Amount`, SUM(`misc_price`) AS `gst_total` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->order_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $billingAmount = number_format($row1['bill_Amount'], 2, '.', '');
        $gstTotal = isset($row1['gst_total']) ? number_format($row1['gst_total'], 2, '.', '') : '0.00';
        $query2 = "UPDATE `orders` SET `billing_amount`=" . $billingAmount . ", `gst`=" . $gstTotal . " WHERE `token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->order_token);
        if ($stmt2->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function isProductAlreadyExistsForOrder()
    {
        $query1 = "SELECT `id`, `order_token` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->order_token);
        $stmt1->bindParam(2, $this->product_token);
        $stmt1->execute();
        return $stmt1;
    }
    function updateExistProductData()
    {
        $updatequery = "UPDATE `orders__items` SET `quantity`=? WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1'";
        $addstmt = $this->conn->prepare($updatequery);
        $addstmt->bindParam(1, $this->boxCount);
        $addstmt->bindParam(2, $this->order_token);
        $addstmt->bindParam(3, $this->product_token);
        $addstmt->execute();
        return $addstmt;
    }
    function insertFreeProduct($indiaDateTime)
    {
        $quantity = $this->boxCount;
        $is_offer_product = "SELECT `token`,`product_token`, `scheme_name`, `limit_box`, `free_box`, `start_date`, `end_date`, `is_scheme`,`free_product` 
        FROM `products__scheme` 
        WHERE `product_token`=? AND `is_scheme`='1'";
        $stmt_offer = $this->conn->prepare($is_offer_product);
        $stmt_offer->bindParam(1, $this->product_token);
        $stmt_offer->execute();
        if ($stmt_offer->rowCount() > 0) {
            $array1 = [];
            $free1 = 0;
            $free2 = 0;
            $limit1 = 0;
            $limit2 = 0;
            $freeproduct1 = 0;
            $freeproduct2 = 0;
            $scheme_token1 = 0;
            $scheme_token2 = 0;
            while ($row1 = $stmt_offer->fetch(PDO::FETCH_ASSOC)) {
                $obj = new stdClass();
                $obj->scheme_token = $row1["token"];
                $obj->product_token = $row1["product_token"];
                $obj->free_box = $row1["free_box"];
                $obj->free_product = $row1["free_product"] == 0 ? 0 : $row1["free_product"];
                $obj->limit_box = $row1["limit_box"];
                array_push($array1, $obj);
            }
            $scheme_token = (array_column($array1, 'scheme_token'));
            $counts = count($scheme_token);
            if ($counts == 1) {
                $scheme_token1 = $scheme_token[0];
            } else {
                $scheme_token1 = $scheme_token[0];
                $scheme_token2 = $scheme_token[1];
            }
            $free_product = (array_column($array1, 'free_product'));
            $count = count($free_product);
            if ($count == 1) {
                $freeproduct1 = $free_product[0];
            } else {
                $freeproduct1 = $free_product[0];
                $freeproduct2 = $free_product[1];
            }
            $data = (array_column($array1, 'limit_box'));
            $count1 = count($data);
            if ($count1 == 1) {
                $limit1 = $data[0];
            } else {
                $limit1 = $data[0];
                $limit2 = $data[1];
            }
            $free = (array_column($array1, 'free_box'));
            $count2 = count($free);
            if ($count2 == 1) {
                $free1 = $free[0];
            } else {
                $free1 = $free[0];
                $free2 = $free[1];
            }
            if ($quantity == $limit1) {
                $free_box_val = (int)($quantity / $limit1);
                if ($free_box_val > 0) {
                    if ($freeproduct1 == 0 && $freeproduct2 == 0) {
                        $free_box_val1 = $quantity / $limit1;
                        $freeProduct_count = $free_box_val1 * $free1;
                        $freeProduct = (int)$freeProduct_count;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`='$freeproduct1' AND `is_free`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->order_token);
                        $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                       `quantity`='$freeProduct',
                       `date_time`='$indiaDateTime',`scheme_token`='$scheme_token1', `delete_status`='1'  WHERE `order_token`=? AND `product_token`='$freeproduct1' AND `is_free`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->order_token);
                            $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                        `order_token`=:order_token, 
                        `product_token`=:product_token, 
                        `price_per_unit`=:price_per_unit, 
                        `piece_count`=:piece_count, 
                        `misc_price`='0', 
                        `quantity`='$freeProduct', 
                        `return_qty`='0', 
                        `offer_token`='0', 
                        `offer_percentage`='0', 
                        `offer_amount`='0', 
                        `units`='Box', 
                        `is_free`='1', 
                        `scheme_token`='$scheme_token1',
                        `is_discount_enable`='0', 
                        `product_dis_price`='0', 
                        `product_price`='0', 
                        `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->order_token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                        }
                    } else {
                        $free_box_val1 = $quantity / $limit1;
                        $freeProduct_count = $free_box_val1 * $free1;
                        $freeProduct = (int)$freeProduct_count;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->order_token);
                        // $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                       `quantity`='$freeProduct',
                       `date_time`='$indiaDateTime', `scheme_token`='$scheme_token1',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->order_token);
                            // $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                        `order_token`=:order_token, 
                        `product_token`=:product_token, 
                        `price_per_unit`=:price_per_unit, 
                        `piece_count`=:piece_count, 
                        `misc_price`='0', 
                        `quantity`='$freeProduct', 
                        `return_qty`='0', 
                        `offer_token`='0', 
                        `offer_percentage`='0', 
                        `offer_amount`='0', 
                        `units`='Box', 
                        `is_free`='1', 
                        `scheme_token`='$scheme_token1',
                        `is_discount_enable`='0', 
                        `product_dis_price`='0', 
                        `product_price`='0', 
                        `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->order_token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                        }
                    }
                }
            } elseif ($quantity == $limit2) {
                $free_box_val = (int)($quantity / $limit2);
                if ($free_box_val > 0) {
                    if ($freeproduct1 == 0 && $freeproduct2 == 0) {
                        $free_box_val1 = $quantity / $limit2;
                        $freeProduct_count = $free_box_val1 * $free2;
                        $freeProduct = (int)$freeProduct_count;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->order_token);
                        $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                       `quantity`='$freeProduct',
                       `date_time`='$indiaDateTime', `scheme_token`='$scheme_token2',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->order_token);
                            $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                        `order_token`=:order_token, 
                        `product_token`=:product_token, 
                        `price_per_unit`=:price_per_unit, 
                        `piece_count`=:piece_count, 
                        `misc_price`='0', 
                        `quantity`='$freeProduct', 
                        `return_qty`='0', 
                        `offer_token`='0', 
                        `offer_percentage`='0', 
                        `offer_amount`='0', 
                        `units`='Box', 
                        `is_free`='1', 
                        `scheme_token`='$scheme_token2',
                        `is_discount_enable`='0', 
                        `product_dis_price`='0', 
                        `product_price`='0', 
                        `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->order_token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                        }
                    } else {
                        $free_box_val1 = $quantity / $limit1;
                        $freeProduct_count = $free_box_val1 * $free1;
                        $freeProduct = (int)$freeProduct_count;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct2 AND `is_free`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->order_token);
                        // $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                       `quantity`='$freeProduct',
                       `date_time`='$indiaDateTime',`scheme_token`='$scheme_token2', `delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct2 AND `is_free`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->order_token);
                            // $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                        `order_token`=:order_token, 
                        `product_token`=:product_token, 
                        `price_per_unit`=:price_per_unit, 
                        `piece_count`=:piece_count, 
                        `misc_price`='0', 
                        `quantity`='$freeProduct', 
                        `return_qty`='0', 
                        `offer_token`='0', 
                        `offer_percentage`='0', 
                        `offer_amount`='0', 
                        `units`='Box', 
                        `is_free`='1', 
                        `scheme_token`='$scheme_token2',
                        `is_discount_enable`='0', 
                        `product_dis_price`='0', 
                        `product_price`='0', 
                        `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->order_token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                        }
                    }
                }
            } elseif ($quantity > $limit1 && $quantity > $limit2 && $freeproduct1 == 0 && $freeproduct2 == 0) {
                $free_box_val2 = intdiv($quantity, $limit1);
                $free_box_val3 = fmod($quantity, $limit1);
                if ($free_box_val3 == 0) {
                    $freeProduct_count1 = $free_box_val2 * $free1;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    $stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                `quantity`='$freeProduct',
                `date_time`='$indiaDateTime', `scheme_token`='$scheme_token1',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
                 `order_token`=:order_token, 
                 `product_token`=:product_token, 
                 `price_per_unit`=:price_per_unit, 
                 `piece_count`=:piece_count, 
                 `misc_price`='0', 
                 `quantity`='$freeProduct', 
                 `return_qty`='0', 
                 `offer_token`='0', 
                 `offer_percentage`='0', 
                 `offer_amount`='0', 
                 `units`='Box', 
                 `is_free`='1',
                 `scheme_token`='$scheme_token1', 
                 `is_discount_enable`='0', 
                 `product_dis_price`='0', 
                 `product_price`='0', 
                 `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                } elseif ($free_box_val3 > 0 && $limit2 == 0) {
                    $freeProduct_count1 = $free_box_val2 * $free1;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    $stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                    `quantity`='$freeProduct',
                    `date_time`='$indiaDateTime', `scheme_token`='$scheme_token1',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
                     `order_token`=:order_token, 
                     `product_token`=:product_token, 
                     `price_per_unit`=:price_per_unit, 
                     `piece_count`=:piece_count, 
                     `misc_price`='0', 
                     `quantity`='$freeProduct', 
                     `return_qty`='0', 
                     `offer_token`='0', 
                     `offer_percentage`='0', 
                     `offer_amount`='0', 
                     `units`='Box', 
                     `is_free`='1',
                     `scheme_token`='$scheme_token1', 
                     `is_discount_enable`='0', 
                     `product_dis_price`='0', 
                     `product_price`='0', 
                     `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                } else {
                    $free_box_val4 = intdiv($free_box_val3, $limit2);
                    $freeProduct = ($free_box_val2 * $free1) + ($free_box_val4 * $free2);
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    $stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                `quantity`='$freeProduct',
                `date_time`='$indiaDateTime', `scheme_token`='$scheme_token1',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
             `order_token`=:order_token, 
             `product_token`=:product_token, 
             `price_per_unit`=:price_per_unit, 
             `piece_count`=:piece_count, 
             `misc_price`='0', 
             `quantity`='$freeProduct', 
             `return_qty`='0', 
             `offer_token`='0', 
             `offer_percentage`='0', 
             `offer_amount`='0', 
             `units`='Box', 
             `is_free`='1',
             `scheme_token`='$scheme_token1', 
             `is_discount_enable`='0', 
             `product_dis_price`='0', 
             `product_price`='0', 
             `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                }
            } elseif ($quantity > $limit2 && $limit2 != 0 && $quantity < $limit1 && $freeproduct1 == 0 && $freeproduct2 == 0) {
                $free_box_val4 = intdiv($quantity, $limit2);
                $free_box_val5 = fmod($quantity, $limit2);
                if ($free_box_val4 > 0) {
                    $freeProduct_count1 = $free_box_val4 * $free2;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    $stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                `quantity`='$freeProduct',
                `date_time`='$indiaDateTime',`scheme_token`='$scheme_token2', `delete_status`='1'  WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
             `order_token`=:order_token, 
             `product_token`=:product_token, 
             `price_per_unit`=:price_per_unit, 
             `piece_count`=:piece_count, 
             `misc_price`='0', 
             `quantity`='$freeProduct', 
             `return_qty`='0', 
             `offer_token`='0', 
             `offer_percentage`='0', 
             `offer_amount`='0', 
             `units`='Box', 
             `is_free`='1', 
             `scheme_token`='$scheme_token2',
             `is_discount_enable`='0', 
             `product_dis_price`='0', 
             `product_price`='0', 
             `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                }
            } elseif ($quantity > $limit1 && $freeproduct1 != 0) {
                $free_box_val2 = intdiv($quantity, $limit1);
                $free_box_val3 = fmod($quantity, $limit1);
                if ($free_box_val3 == 0) {
                    $freeProduct_count1 = $free_box_val2 * $free1;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    //$stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
        `quantity`='$freeProduct',
        `date_time`='$indiaDateTime',`scheme_token`='$scheme_token1', `delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        // $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
         `order_token`=:order_token, 
         `product_token`=:product_token, 
         `price_per_unit`=:price_per_unit, 
         `piece_count`=:piece_count, 
         `misc_price`='0', 
         `quantity`='$freeProduct', 
         `return_qty`='0', 
         `offer_token`='0', 
         `offer_percentage`='0', 
         `offer_amount`='0', 
         `units`='Box', 
         `is_free`='1',
         `scheme_token`='$scheme_token1', 
         `is_discount_enable`='0', 
         `product_dis_price`='0', 
         `product_price`='0', 
         `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                } elseif ($free_box_val3 > 0 && $limit2 == 0) {
                    $free_box_val2 = intdiv($quantity, $limit1);
                    $freeProduct_count1 = $free_box_val2 * $free1;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    //$stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
        `quantity`='$freeProduct',
        `date_time`='$indiaDateTime',`scheme_token`='$scheme_token1', `delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        // $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
         `order_token`=:order_token, 
         `product_token`=:product_token, 
         `price_per_unit`=:price_per_unit, 
         `piece_count`=:piece_count, 
         `misc_price`='0', 
         `quantity`='$freeProduct', 
         `return_qty`='0', 
         `offer_token`='0', 
         `offer_percentage`='0', 
         `offer_amount`='0', 
         `units`='Box', 
         `is_free`='1',
         `scheme_token`='$scheme_token1', 
         `is_discount_enable`='0', 
         `product_dis_price`='0', 
         `product_price`='0', 
         `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                } else {
                    $free_box_val4 = intdiv($free_box_val3, $limit2);
                    $freeProduct = ($free_box_val2 * $free1) + ($free_box_val4 * $free2);
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    //$stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
        `quantity`='$freeProduct',
        `date_time`='$indiaDateTime', `scheme_token`='$scheme_token1',`delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct1 AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        // $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
     `order_token`=:order_token, 
     `product_token`=:product_token, 
     `price_per_unit`=:price_per_unit, 
     `piece_count`=:piece_count, 
     `misc_price`='0', 
     `quantity`='$freeProduct', 
     `return_qty`='0', 
     `offer_token`='0', 
     `offer_percentage`='0', 
     `offer_amount`='0', 
     `units`='Box', 
     `is_free`='1', 
     `scheme_token`='$scheme_token1',
     `is_discount_enable`='0', 
     `product_dis_price`='0', 
     `product_price`='0', 
     `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                }
            } elseif ($quantity > $limit2  && $freeproduct2 != 0) {
                $free_box_val4 = intdiv($quantity, $limit2);
                $free_box_val5 = fmod($quantity, $limit2);
                if ($free_box_val4 > 0) {
                    $freeProduct_count1 = $free_box_val4 * $free2;
                    $freeProduct = $freeProduct_count1;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=$freeproduct2 AND `is_free`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->order_token);
                    //$stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                `quantity`='$freeProduct',
                `date_time`='$indiaDateTime',`scheme_token`='$scheme_token2', `delete_status`='1'  WHERE `order_token`=? AND `product_token`=$freeproduct2 AND `is_free`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->order_token);
                        //$stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
             `order_token`=:order_token, 
             `product_token`=:product_token, 
             `price_per_unit`=:price_per_unit, 
             `piece_count`=:piece_count, 
             `misc_price`='0', 
             `quantity`='$freeProduct', 
             `return_qty`='0', 
             `offer_token`='0', 
             `offer_percentage`='0', 
             `offer_amount`='0', 
             `units`='Box', 
             `is_free`='1',
             `scheme_token`='$scheme_token2', 
             `is_discount_enable`='0', 
             `product_dis_price`='0', 
             `product_price`='0', 
             `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->order_token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                    }
                }
            } else {
                $offerRemove = "UPDATE `orders__items` SET 
                `delete_status`='2' 
                WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                $stmt_offer4 = $this->conn->prepare($offerRemove);
                $stmt_offer4->bindParam(1, $this->order_token);
                $stmt_offer4->bindParam(2, $this->product_token);
                $stmt_offer4->execute();
            }
        }
    }

    function updateOfferPercentage()
    {
        $update = "UPDATE `orders__items` SET `misc_price`=? ,`offer_token`='', `offer_percentage`=?,`offer_value`=?,`offer_amount`=?  WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1' AND `is_free`='0'";
        $stmt_offer = $this->conn->prepare($update);
        $stmt_offer->bindParam(1, $this->gstAmount);
        $stmt_offer->bindParam(2, $this->offer_percentage);
        $stmt_offer->bindParam(3, $this->offer_value);
        $stmt_offer->bindParam(4, $this->billAmount);
        $stmt_offer->bindParam(5, $this->order_token);
        $stmt_offer->bindParam(6, $this->product_token);
        if ($stmt_offer->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //order approve msg 
    function orderApproveMsg($mobile_number, $name, $order_number, $billing_amount)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apii.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"63b3f51eca1dd02ba80f0fc2\",\n  \"sender\": \"ASWSMS\",\n  \"mobiles\": \"91$mobile_number\",\n  \"name\": \"$name\",\n  \"id\": \"$order_number\",\n   \"value\":\"RS.$billing_amount\"\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 380803AF0dsqJz8g62f75785P1",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    }
    //deliver msg
    function orderDeliverMsg($mobile_number, $name, $order_number, $billing_amount)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apii.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"63b3f71b2f98e8793e135972\",\n  \"sender\": \"ASWSMS\",\n  \"mobiles\": \"91$mobile_number\",\n  \"name\": \"$name\",\n  \"id\": \"$order_number\",\n   \"value\":\"RS.$billing_amount\"\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 380803AF0dsqJz8g62f75785P1",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    }
    //scheme edit 
    function editScheme()
    {
        $query = "SELECT
        orders__items.order_token,
        orders__items.product_token
    FROM
        `orders__items`
    INNER JOIN products ON orders__items.product_token = products.token
    WHERE
        `order_token` = ? AND NOT is_free='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function editSchemeData($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $order_token = $row["order_token"];
            $product_token = $row["product_token"];
            array_push($array, $order_token);
            array_push($array, $product_token);
        }
        return $array;
    }
    function schemeProduct($product_token)
    {
        $query = "SELECT products.name,products.token FROM `products__scheme` INNER JOIN products ON products__scheme.free_product=products.token WHERE products__scheme.product_token=:product_token AND products__scheme.is_scheme='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $product_token);
        $stmt->execute();
        return $stmt;
    }
    function editSchemeProduct($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->product_name = $row["name"];
            array_push($array, $obj);
        }
        return $array;
    }
    function updateScheme($token, $indiaDateTime)
    {
        $query = "UPDATE `orders__items` SET `product_token`=:product_token,`date_time`='$indiaDateTime' where `order_token`=:order_token and `is_free`='1' and `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('product_token', $token);
        $stmt->bindParam('order_token', $this->orderToken);
        $stmt->execute();
        return true;
    }

    function stateRegion()
    {
        $state_id = $this->state_id;
        $query = "SELECT `token`, `region_name` FROM `region` $state_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->region_name = $row["region_name"];
            array_push($array, $obj);
        }
        return $array;
    }

    function regionDistributor()
    {
        $query = "SELECT `token`, `name` FROM `employees` 
        WHERE `region_id`=? AND `deparment_token`='18028120' AND `delete_status`='1' AND `block_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->region_id);
        $stmt->execute();
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->dist_name = $row["name"];
            array_push($array, $obj);
        }
        return $array;
    }

    function distributorOrderReportCount()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $query = "SELECT `orders`.`token`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        -- LEFT JOIN `shop` ON `shop`.`token`=`orders`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        INNER JOIN `employees__state` ON `employees`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND `orders`.`order_type`=? $state $status";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function distributorOrderReportSearch()
    {
        $searchQuery   = $this->searchQuery;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $query = "SELECT `orders`.`token`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        INNER JOIN `employees__state` ON `employees`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND `orders`.`order_type`=? $state $status $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function serverDistributorOrderReport()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $query = "SELECT `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        INNER JOIN `employees__state` ON `employees`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' AND `orders`.`order_type`=? $state $status $searchQuery ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function salesOrderReportCount()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $distributor = $this->distributor;
        $query = "SELECT  `orders`.`token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' $state OR `distributor`.`region_id`=?  $status  $distributor $order_by
        GROUP BY `orders`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }

    function salesOrderReportSearch()
    {
        $searchQuery = $this->searchQuery;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $distributor = $this->distributor;
        $query = "SELECT  `orders`.`token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' $state AND `distributor`.`region_id`=?  $status  $distributor $order_by $searchQuery
        GROUP BY `orders`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }

    function serverSalesOrderReport()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $distributor = $this->distributor;
        $query = "SELECT  `orders`.`token`,
		`orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `salesman`.`name` AS `sales_man_name`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`is_slaes_rep_admin`,
        `orders`.`sales_rep_token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' $state AND `distributor`.`region_id`=? $distributor $status $order_by
        $searchQuery
        GROUP BY `orders`.`token`
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }


    function serverReadOrderNewRetailer($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $delivery  = '<button class="tb-btn nav-blue">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            $distributor_name = $row["distributor_name"];
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $distributor_name,
                "items" => $row['items'],
                "delivery" => $delivery,
                "delivered_on" => $delivered_on,
                "billing_amount" => moneyFormatIndia($row['billing_amount'])
            );
        }
        return $data;
    }

    function serverReadOrderNew($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $delivery  = '<button class="tb-btn nav-blue">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            if ($row['is_slaes_rep_admin'] == '1') {
                $query20 = "SELECT `employees`.`name` AS `salesRepName` FROM `orders` INNER JOIN `employees` ON `orders`.`sales_rep_token` = `employees`.`token` WHERE `orders`.`sales_rep_token`='" . $row['sales_rep_token'] . "'";
                $stmt20 = $this->conn->prepare($query20);
                $stmt20->execute();
                $row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
                $sales_rep = $row20["salesRepName"];
                $query21 = "SELECT `employees`.`name` AS `dist_name` FROM `orders` INNER JOIN `employees` ON `orders`.`distributor_token` = `employees`.`token` WHERE `orders`.`token`='" . $row['token'] . "'";
                $stmt21 = $this->conn->prepare($query21);
                $stmt21->execute();
                $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
                $distributor_name = $row21["dist_name"];
            } else {
                $sales_rep = $row["sales_man_name"];
                $distributor_name = $row["distributor_name"];
            }
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "distributor_name" => $distributor_name,
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $sales_rep,
                "items" => $row['items'],
                "delivery" => $delivery,
                "delivered_on" => $delivered_on,
                "billing_amount" => $row['billing_amount']
            );
        }
        return $data;
    }

    //retailer order
    function retailerOrderReportCount()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $query = "SELECT  `orders`.`token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND date(`orders`.`date_time`) BETWEEN '$from_date' AND '$to_date' $state AND `distributor`.`region_id`=?  $status $order_by
        GROUP BY `orders`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }

    function RetailerOrderReportSearch()
    {
        $searchQuery = $this->searchQuery;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $query = "SELECT  `orders`.`token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' $state AND `distributor`.`region_id`=? $status $order_by $searchQuery
        GROUP BY `orders`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }


    function serverRetailerOrderReport()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $status = $this->status;
        $order_by = $this->order_by;
        $query = "SELECT  `orders`.`token`,
		`orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.order_type=? AND `orders`.`date_time` BETWEEN '$from_date' AND '$to_date' $state AND `distributor`.`region_id`=? $status $order_by
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->region);
        $stmt->execute();
        return $stmt;
    }


    function serverReadOrderRetailer($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else if ($row['delivery'] == "Approved") {
                $delivery  = '<button class="tb-btn nav-blue">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            $distributor_name = $row["distributor_name"];
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "shop_name" => $row['shop_name'],
                "sales_man" => $distributor_name,
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "items" => $row['items'],
                "delivery" => $delivery,
                "delivered_on" => $delivered_on,
                "billing_amount" => moneyFormatIndia($row['billing_amount'])
            );
        }
        return $data;
    }

    function stateWiseSalesRep()
    {
        $state_query = $this->state_id;
        $query = "SELECT `token`, `name` FROM `employees` 
        WHERE `deparment_token`IN ('72602780','98765433','98765434') AND `delete_status`='1' AND `block_status`='1' $state_query";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->sales_rep_name = $row["name"];
            array_push($array, $obj);
        }
        return $array;
    }

    // function salesRepReportCount()
    // {
    //     $fromDate = $this->fromDate;
    //     $toDate = $this->toDate;
    //     $selectState = $this->selectState;
    //     $salesRep = $this->salesRep;
    //     $query = "SELECT 
    //     COUNT(DISTINCT `orders`.`token`) AS `total_count`
    //     FROM `orders`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`sales_rep_token`=`salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
    //     INNER JOIN `area` ON `area`.`area_token`=`distributor`.`area_token`
    //     WHERE `orders`.order_type='Sales Order' AND `orders`.`date_time` BETWEEN '$fromDate' AND '$toDate' $selectState $salesRep AND `orders`.`is_slaes_rep_admin`='1'
    //     GROUP BY CAST(`orders`.`date_time` AS DATE),`orders`.`distributor_token`";
    //     $stmt = $this->conn->prepare($query);
    //     if (!$stmt->execute()) {
    //         print_r($stmt->errorInfo());
    //     }
    //     return $stmt->rowCount(); // Use rowCount for grouped queries
    // }



//    function salesRepReportCount()
//     {
//         $fDate = date('Y-m-d', strtotime($this->fromDate));
//         $tDate = date('Y-m-d', strtotime($this->toDate));
        
//         $stateFilter = $this->selectState;
//         // Bypassing state filter explicitly if distributor state is missing
//         if (trim($stateFilter) != '') {
//             $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
//             $stateFilter = rtrim($stateFilter) . ")";
//         }
        
//         $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
        
//         $query = "SELECT `schedule_sales_rep`.`id`
//         FROM `schedule_sales_rep`
//         LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
//         LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
//         LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
//         LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
//             AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
//             AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
//             AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
//         WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
//         $stateFilter $repFilter 
//         AND `schedule_sales_rep`.`status` = '1'
//         GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`";
        
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//         return $stmt->rowCount(); 
//     }



        function salesRepReportCount()
    {
        $fDate = date('Y-m-d', strtotime($this->fromDate));
        $tDate = date('Y-m-d', strtotime($this->toDate));
        
        $stateFilter = $this->selectState;
        // Bypassing state filter explicitly if distributor state is missing
        if (trim($stateFilter) != '') {
            $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
            $stateFilter = rtrim($stateFilter) . ")";
        }
        
        $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
        
        $query = "SELECT `schedule_sales_rep`.`id`
        FROM `schedule_sales_rep`
        LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
        LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
            AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
            AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
            AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
        WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
        $stateFilter $repFilter 
        GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount(); 
    }







    // function salesRepReportSearch()
    // {
    //     $searchQuery = $this->searchQuery;
    //     $fromDate = $this->fromDate;
    //     $toDate = $this->toDate;
    //     $selectState = $this->selectState;
    //     $salesRep = $this->salesRep;
    //     $query = "SELECT 
    //     `orders`.`token`
    //     FROM `orders`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`sales_rep_token`=`salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
    //     INNER JOIN `area` ON `area`.`area_token`=`distributor`.`area_token`
    //     WHERE `orders`.order_type='Sales Order' AND `orders`.`date_time` BETWEEN '$fromDate' AND '$toDate' $selectState $salesRep AND `orders`.`is_slaes_rep_admin`='1' $searchQuery
    //     GROUP BY CAST(`orders`.`date_time` AS DATE),`orders`.`distributor_token`";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    //     return $stmt->rowCount(); // Return the count of rows
    // }





    //   function salesRepReportSearch()
//     {
//         $fDate = date('Y-m-d', strtotime($this->fromDate));
//         $tDate = date('Y-m-d', strtotime($this->toDate));
        
//         $stateFilter = $this->selectState;
//         if (trim($stateFilter) != '') {
//             $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
//             $stateFilter = rtrim($stateFilter) . ")";
//         }
        
//         $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
//         $searchFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->searchQuery);
        
//         $query = "SELECT `schedule_sales_rep`.`id`
//         FROM `schedule_sales_rep`
//         LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
//         LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
//         LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
//         LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
//             AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
//             AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
//             AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
//         WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
//         $stateFilter $repFilter 
//         AND `schedule_sales_rep`.`status` = '1' $searchFilter
//         GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`";
        
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
//         return $stmt->rowCount(); 
//     }





        function salesRepReportSearch()
    {
        $fDate = date('Y-m-d', strtotime($this->fromDate));
        $tDate = date('Y-m-d', strtotime($this->toDate));
        
        $stateFilter = $this->selectState;
        if (trim($stateFilter) != '') {
            $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
            $stateFilter = rtrim($stateFilter) . ")";
        }
        
        $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
        $searchFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->searchQuery);
        
        $query = "SELECT `schedule_sales_rep`.`id`
        FROM `schedule_sales_rep`
        LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
        LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
            AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
            AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
            AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
        WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
        $stateFilter $repFilter 
        $searchFilter
        GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->rowCount(); 
    }



    // function salesRepReport()
    // {
    //     $rowStart    = $this->rowStart;
    //     $rowperpage  = $this->rowperpage;
    //     $searchQuery = $this->searchQuery;
    //     $columnName  = $this->columnName;
    //     $columnSortOrder = $this->columnSortOrder;
    //     $fromDate = $this->fromDate;
    //     $toDate = $this->toDate;
    //     $selectState = $this->selectState;
    //     $salesRep = $this->salesRep;
    //     $query = "SELECT
    //     `orders`.`token`,
    //     `orders`.`order_number`,
    //     date(`orders`.`date_time`) AS `date_time`,
    //     `salesman`.`name` AS `sales_rep_name`,
    //     `orders`.`sales_rep_token`,
    //     `distributor`.`name` AS `distributor_name`,
    //     `distributor`.`token` AS `distributor_token`,
    //     COUNT(DISTINCT `orders`.`shop_token`) AS `order_taken_shop`,
    //     COUNT(DISTINCT `orders`.`id`) AS `order_count`,
    //     (SELECT COUNT(`shop_mapping`.`id`) FROM `shop_mapping` WHERE `shop_mapping`.`distributor_token`=`distributor`.`token` AND `shop_mapping`.`status`='1') AS `total_Shop`,
    //     COALESCE((SELECT SUM(`sales_rep__expense__details`.`amount`) AS `add` FROM `sales_rep__expense__details` WHERE `sales_rep__expense__details`.`sales_rep__token` = `orders`.`sales_rep_token` AND date(`sales_rep__expense__details`.`date_time`)=date(`orders`.`date_time`)),'0') AS `expense_amount`,
    //     `area`.`area_name`
    //     FROM
    //     `orders`
    //     INNER JOIN `employees` AS `salesman` ON `orders`.`sales_rep_token` = `salesman`.`token`
    //     INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token`
        
    //     -- INNER JOIN `shop_mapping` AS `shop_data` ON `shop_data`.`distributor_token` =`orders`.`distributor_token`
    //     INNER JOIN `area` ON `area`.`area_token` = `distributor`.`area_token`
    //     WHERE `orders`.order_type = 'Sales Order' AND `orders`.`date_time` BETWEEN '$fromDate' AND '$toDate'  $selectState $salesRep  AND `orders`.`is_slaes_rep_admin` = '1'$searchQuery
    //     GROUP BY CAST(`orders`.`date_time` AS DATE),`orders`.`distributor_token`
    //     ORDER BY $columnName $columnSortOrder
    //     LIMIT $rowStart,$rowperpage";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    //     //$stmt->debugDumpParams(); 
    //     //return $stmt;
    //     $data = array();
    //     $salesRep = $this->salesRep;
    //     $fromDate = $this->fromDate;
    //     $toDate = $this->toDate;
    //     $repToken = $this->repToken;
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //         $query1 = "SELECT SUM(`billing_amount`) AS `order_value`  FROM `orders` WHERE  `is_slaes_rep_admin` = '1'  $salesRep  AND `distributor_token`='" . $row['distributor_token'] . "' AND `date_time` LIKE'%" . $row['date_time'] . "%'";
    //         $stmt1 = $this->conn->prepare($query1);
    //         $stmt1->execute();
    //         $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //         // Count shop visits per sales rep per date (scoped to each row)
    //         $rowRepToken = "AND `live_locationmap`.`rep_token` = '" . $row['sales_rep_token'] . "'";
    //         $rowDate = $row['date_time']; // already DATE cast in main query
    //         $query2 = "SELECT COUNT(`live_locationmap`.`id`) AS `count_visit`
    //                    FROM `live_locationmap`
    //                    WHERE date(`live_locationmap`.`date_time`) = '$rowDate'
    //                    $rowRepToken
    //                    AND `live_locationmap`.`type` = '3'";
    //         $stmt2 = $this->conn->prepare($query2);
    //         $stmt2->execute();
    //         $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    //         $data[] = array(
    //             "token" => $row['token'],
    //             "order_number" => $row['order_number'],
    //             "date_time" => $row['date_time'],
    //             "sales_rep_name" => $row['sales_rep_name'],
    //             "distributor_name" => $row['distributor_name'],
    //             "area_name" => $row['area_name'],
    //             "oder_taken_shop" => $row['order_taken_shop'],
    //             "count_visit" => $row2['count_visit'] ?? 0,
    //             "order_value" => number_format($row1['order_value'], 2, '.', ''),
    //             "total_Shop" => $row['total_Shop'],
    //             "expense_amount" => $row['expense_amount']
    //         );
    //     }
    //     return $data;
    // }


//   function salesRepReport()
//     {
//         $rowStart    = $this->rowStart;
//         $rowperpage  = $this->rowperpage;
        
//         $fDate = date('Y-m-d', strtotime($this->fromDate));
//         $tDate = date('Y-m-d', strtotime($this->toDate));
        
//         $stateFilter = $this->selectState;
//         if (trim($stateFilter) != '') {
//             $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
//             $stateFilter = rtrim($stateFilter) . ")";
//         }
        
//         $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
//         $searchFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->searchQuery);
//         $colName = str_replace('`orders`.', '`schedule_sales_rep`.', $this->columnName);
//         $columnSortOrder = $this->columnSortOrder;
        
//         $query = "SELECT
//         COALESCE(`orders`.`token`, '') AS `token`,
//         COALESCE(`orders`.`order_number`, '-') AS `order_number`,
//         DATE(`schedule_sales_rep`.`date_time`) AS `date_time`,
//         COALESCE(`salesman`.`name`, '-') AS `sales_rep_name`,
//         `schedule_sales_rep`.`sales_rep_token`,
//         COALESCE(`distributor`.`name`, `schedule_sales_rep`.`distributor_token`) AS `distributor_name`,
//         `schedule_sales_rep`.`distributor_token`,
//         COUNT(DISTINCT `orders`.`shop_token`) AS `order_taken_shop`,
//         COUNT(DISTINCT `orders`.`id`) AS `order_count`,
//         COALESCE((SELECT COUNT(`shop_mapping`.`id`) FROM `shop_mapping` WHERE `shop_mapping`.`distributor_token`=`schedule_sales_rep`.`distributor_token` AND `shop_mapping`.`status`='1'), 0) AS `total_Shop`,
//         COALESCE((SELECT SUM(`sales_rep__expense__details`.`amount`) FROM `sales_rep__expense__details` WHERE `sales_rep__expense__details`.`sales_rep__token` = `schedule_sales_rep`.`sales_rep_token` AND DATE(`sales_rep__expense__details`.`date_time`)=DATE(`schedule_sales_rep`.`date_time`) AND `sales_rep__expense__details`.`status`='1'),'0') AS `expense_amount`,
//         COALESCE(`area`.`area_name`, '-') AS `area_name`
//         FROM `schedule_sales_rep`
//         LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
//         LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
//         LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
//         LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
//             AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
//             AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
//             AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
//         WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
//         $stateFilter $repFilter 
//         AND `schedule_sales_rep`.`status` = '1' $searchFilter
//         GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`
//         ORDER BY $colName $columnSortOrder
//         LIMIT $rowStart,$rowperpage";
        
//         $stmt = $this->conn->prepare($query);
//         $stmt->execute();
        
//         $data = array();
        
//         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//             $distToken = $row['distributor_token'];
//             $repToken = $row['sales_rep_token'];
//             $rowDate = $row['date_time']; 
            
//             // --- Custom Formatting Name for Society / New Agencies / Meetings ---
//             $display_name = trim($row['distributor_name']);
//             if (strcasecmp($display_name, 'NEW AGENCIE') == 0 || strcasecmp($display_name, 'NEW AGENCY') == 0 || strcasecmp($display_name, 'NEW AGENCIES') == 0 || strcasecmp($display_name, 'New Agencies Visited') == 0) {
//                 $display_name = 'New Agencies Visited';
//             } else if (strcasecmp($display_name, 'SOCIETY') == 0) {
//                 $display_name = 'Society';
//             } else if (stripos($display_name, 'Sales Rep M') !== false) {
//                 // Ithu 'Sales Rep M' ennum 'Sales Rep Meeting' ennum ulla randineyum cover cheyyum
//                 $display_name = 'Sales Rep Meeting';
//             }
//             // ---------------------------------------------------------
            
//             // Calculating exact order value for that day
//             $query1 = "SELECT SUM(`billing_amount`) AS `order_value` FROM `orders` WHERE `is_slaes_rep_admin` = '1' AND `sales_rep_token`='$repToken' AND `distributor_token`='$distToken' AND DATE(`date_time`) = '$rowDate'";
//             $stmt1 = $this->conn->prepare($query1);
//             $stmt1->execute();
//             $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
//             $orderValue = $row1['order_value'] ? number_format($row1['order_value'], 2, '.', '') : '0.00';
            
//             // Calculating visits
//             $query2 = "SELECT COUNT(`live_locationmap`.`id`) AS `count_visit`
//                        FROM `live_locationmap`
//                        WHERE date(`live_locationmap`.`date_time`) = '$rowDate'
//                        AND `live_locationmap`.`rep_token` = '$repToken'
//                        AND `live_locationmap`.`type` = '3'";
//             $stmt2 = $this->conn->prepare($query2);
//             $stmt2->execute();
//             $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            
//             $data[] = array(
//                 "token" => $row['token'],
//                 "order_number" => $row['order_number'],
//                 "date_time" => $row['date_time'],
//                 "sales_rep_name" => $row['sales_rep_name'],
//                 "distributor_name" => $display_name, // Dynamic Formatted Name with Sales Rep Meeting included
//                 "area_name" => $row['area_name'],
//                 "oder_taken_shop" => $row['order_taken_shop'] ?? 0,
//                 "count_visit" => $row2['count_visit'] ?? 0,
//                 "order_value" => $orderValue,
//                 "total_Shop" => $row['total_Shop'] ?? 0,
//                 "expense_amount" => $row['expense_amount'] ?? 0
//             );
//         }
//         return $data;
//     }



    function salesRepReport()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        
        $fDate = date('Y-m-d', strtotime($this->fromDate));
        $tDate = date('Y-m-d', strtotime($this->toDate));
        
        $stateFilter = $this->selectState;
        if (trim($stateFilter) != '') {
            $stateFilter = str_replace("AND `distributor`.`state_id`=", "AND (`distributor`.`state_id` IS NULL OR `distributor`.`state_id`='' OR `distributor`.`state_id`=", $stateFilter);
            $stateFilter = rtrim($stateFilter) . ")";
        }
        
        $repFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->salesRep);
        $searchFilter = str_replace('`orders`.', '`schedule_sales_rep`.', $this->searchQuery);
        $colName = str_replace('`orders`.', '`schedule_sales_rep`.', $this->columnName);
        $columnSortOrder = $this->columnSortOrder;
        
        $query = "SELECT
        COALESCE(`orders`.`token`, '') AS `token`,
        COALESCE(`orders`.`order_number`, '-') AS `order_number`,
        DATE(`schedule_sales_rep`.`date_time`) AS `date_time`,
        COALESCE(`salesman`.`name`, '-') AS `sales_rep_name`,
        `schedule_sales_rep`.`sales_rep_token`,
        COALESCE(`distributor`.`name`, `schedule_sales_rep`.`distributor_token`) AS `distributor_name`,
        `schedule_sales_rep`.`distributor_token`,
        COUNT(DISTINCT `orders`.`shop_token`) AS `order_taken_shop`,
        COUNT(DISTINCT `orders`.`id`) AS `order_count`,
        COALESCE((SELECT COUNT(`shop_mapping`.`id`) FROM `shop_mapping` WHERE `shop_mapping`.`distributor_token`=`schedule_sales_rep`.`distributor_token` AND `shop_mapping`.`status`='1'), 0) AS `total_Shop`,
        COALESCE((SELECT SUM(`sales_rep__expense__details`.`amount`) FROM `sales_rep__expense__details` WHERE `sales_rep__expense__details`.`sales_rep__token` = `schedule_sales_rep`.`sales_rep_token` AND DATE(`sales_rep__expense__details`.`date_time`)=DATE(`schedule_sales_rep`.`date_time`) AND `sales_rep__expense__details`.`status`='1'),'0') AS `expense_amount`,
        COALESCE(`area`.`area_name`, '-') AS `area_name`
        FROM `schedule_sales_rep`
        LEFT JOIN `employees` AS `salesman` ON `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
        LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        LEFT JOIN `orders` ON `orders`.`sales_rep_token` = `schedule_sales_rep`.`sales_rep_token` 
            AND `orders`.`distributor_token` = `schedule_sales_rep`.`distributor_token` 
            AND DATE(`orders`.`date_time`) = DATE(`schedule_sales_rep`.`date_time`) 
            AND `orders`.`order_type` = 'Sales Order' AND `orders`.`is_slaes_rep_admin` = '1'
        WHERE DATE(`schedule_sales_rep`.`date_time`) BETWEEN '$fDate' AND '$tDate' 
        $stateFilter $repFilter 
        $searchFilter
        GROUP BY DATE(`schedule_sales_rep`.`date_time`), `schedule_sales_rep`.`distributor_token`, `schedule_sales_rep`.`sales_rep_token`
        ORDER BY $colName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $data = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $distToken = $row['distributor_token'];
            $repToken = $row['sales_rep_token'];
            $rowDate = $row['date_time']; 
            
            $display_name = trim($row['distributor_name']);
            if (strcasecmp($display_name, 'NEW AGENCIE') == 0 || strcasecmp($display_name, 'NEW AGENCY') == 0 || strcasecmp($display_name, 'NEW AGENCIES') == 0 || strcasecmp($display_name, 'New Agencies Visited') == 0) {
                $display_name = 'New Agencies Visited';
            } else if (strcasecmp($display_name, 'SOCIETY') == 0) {
                $display_name = 'Society';
            } else if (stripos($display_name, 'Sales Rep M') !== false) {
                $display_name = 'Sales Rep Meeting';
            }
            // ---------------------------------------------------------
            
            // Calculating exact order value for that day
            $query1 = "SELECT SUM(`billing_amount`) AS `order_value` FROM `orders` WHERE `is_slaes_rep_admin` = '1' AND `sales_rep_token`='$repToken' AND `distributor_token`='$distToken' AND DATE(`date_time`) = '$rowDate'";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute();
            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
            $orderValue = $row1['order_value'] ? number_format($row1['order_value'], 2, '.', '') : '0.00';
            
            // Calculating visits
            $query2 = "SELECT COUNT(`live_locationmap`.`id`) AS `count_visit`
                       FROM `live_locationmap`
                       WHERE date(`live_locationmap`.`date_time`) = '$rowDate'
                       AND `live_locationmap`.`rep_token` = '$repToken'
                       AND `live_locationmap`.`type` = '3'";
            $stmt2 = $this->conn->prepare($query2);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            
            $data[] = array(
                "token" => $row['token'],
                "order_number" => $row['order_number'],
                "date_time" => $row['date_time'],
                "sales_rep_name" => $row['sales_rep_name'],
                "distributor_name" => $display_name, // Dynamic Formatted Name
                "area_name" => $row['area_name'],
                "oder_taken_shop" => $row['order_taken_shop'] ?? 0,
                "count_visit" => $row2['count_visit'] ?? 0,
                "order_value" => $orderValue,
                "total_Shop" => $row['total_Shop'] ?? 0,
                "expense_amount" => $row['expense_amount'] ?? 0
            );
        }
        return $data;
    }


    // function readSalesRepReport($stmt) {
    //     $data = array();
    //     $salesRep = $this->salesRep;
    //     $fromDate = $this->fromDate;
    //     $toDate = $this->toDate;
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
    //       $query1 = "SELECT SUM(`billing_amount`) AS `order_value`  FROM `orders` WHERE  `is_slaes_rep_admin` = '1'  $salesRep  AND `distributor_token`='".$row['distributor_token']."' AND `date_time` LIKE'%".$row['date_time']."%'";  
    //       $stmt1 = $this->conn->prepare( $query1 );
    //       $stmt1->execute();
    //       //$stmt1->debugDumpParams();
    //       $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    //       $query2 = "SELECT count(live_locationmap.`rep_token`) AS `count_visit`  FROM `live_locationmap` INNER JOIN orders ON live_locationmap.rep_token=orders.sales_rep_token WHERE  live_locationmap.`date_time` BETWEEN '$fromDate' AND '$toDate' $salesRep and live_locationmap.type='3'";  
    //       $stmt2 = $this->conn->prepare( $query2 );
    //       $stmt2->execute();
    //       $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    //       $data[] = array(
    //             "token"=>$row['token'],
    //             "order_number"=>$row['order_number'],
    //             "date_time"=>$row['date_time'],
    //             "sales_rep_name"=>$row['sales_rep_name'],
    //             "distributor_name"=>$row['distributor_name'],
    //             "area_name"=>$row['area_name'],
    //             "oder_taken_shop"=>$row['order_taken_shop'],
    //             "count_visit"=>$row2['count_visit'],
    //             "order_value"=>number_format($row1['order_value'], 2, '.', ''),
    //             "total_Shop"=>$row['total_Shop'],
    //             "expense_amount"=>$row['expense_amount']
    //         );
    //     }
    //     return $data;
    // }

    function livetrackReport()
    {
        $fromDate = $this->fromDate;
        $fromDateStart = $fromDate . ' 00:00:00';
        $fromDateEnd = $fromDate . ' 23:59:59';
        

        // (SELECT `area_name` FROM `live_location` WHERE `rep_token` = `orders`.`sales_rep_token` AND `date_time` BETWEEN '$fromDateStart' AND '$fromDateEnd' AND `area_name` != '' LIMIT 1) AS `area_name`

        $query = "SELECT
            `employees`.`name`,
            DATE(`orders`.`date_time`) AS `date_time`,
            SUM(CASE WHEN `orders`.`is_slaes_rep_admin` = '1' THEN `orders`.`billing_amount` ELSE 0 END) AS `total_amount`,
             `shop`.`name` AS `shop_name`,
             /* (SELECT `area_name` FROM `live_locationmap` WHERE `rep_token` = `orders`.`sales_rep_token` AND `type` = '2' AND `date_time` BETWEEN '$fromDateStart' AND '$fromDateEnd' LIMIT 1) AS `area_name` */
             `shop`.`city` AS `area_name`
        FROM
            `orders`
        INNER JOIN `employees` ON `employees`.`token` = `orders`.`sales_rep_token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        WHERE `orders`.`sales_rep_token` = ? 
          AND `orders`.`date_time` BETWEEN '$fromDateStart' AND '$fromDateEnd'
        GROUP BY `shop`.`name`, `employees`.`name`, DATE(`orders`.`date_time`), `orders`.`sales_rep_token` ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesRep);
        $stmt->execute();
        return $stmt;
    }





    function readlivetrackReport($stmt)
    {
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = array(
                "name" => $row['name'],
                "shop_name" => $row['shop_name'],
                "date_time" => $row['date_time'],
                "total_amount" => $row['total_amount'],
                "area_name" => $row['area_name']
            );
        }
        return $data;
    }
    //attendance report
    function attendanceReport()
    {
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        $salesRep = $this->salesRep;
        $query = "SELECT
        `schedule_sales_rep`.`schedule_date` AS scheduled_dates,
        `salesman`.`name` AS `sales_rep_name`,
        GROUP_CONCAT( DISTINCT COALESCE(`distributor`.`name`, `schedule_sales_rep`.`distributor_token`)) AS distributor_name,
        COALESCE(
            (
            SELECT
                SUM(
                    `sales_rep__expense__details`.`amount`
                ) AS `add`
            FROM
                `sales_rep__expense__details`
            WHERE
                `sales_rep__expense__details`.`sales_rep__token` = `schedule_sales_rep`.`sales_rep_token` AND DATE(
                    `sales_rep__expense__details`.`date_time`
                ) = `schedule_sales_rep`.`schedule_date` AND `sales_rep__expense__details`.`status` = '1'
        ),
        '0'
        ) AS `expense_amount`,
        `area`.`area_name`,
        `region`.`region_name`
    FROM
        `schedule_sales_rep`
    INNER JOIN `employees` AS `salesman`
    ON
        `schedule_sales_rep`.`sales_rep_token` = `salesman`.`token`
    LEFT JOIN `employees` AS `distributor`
    ON
        `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
    LEFT JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
    LEFT JOIN `sales_rep__expense__details` ON `sales_rep__expense__details`.`sales_rep__token` = `schedule_sales_rep`.`sales_rep_token`
    LEFT JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
    WHERE
        DATE(`schedule_sales_rep`.`schedule_date`) BETWEEN '$fromDate' AND '$toDate' AND `schedule_sales_rep`.`sales_rep_token` ='$salesRep' AND `schedule_sales_rep`.`status`='1'
    GROUP BY  `schedule_sales_rep`.`schedule_date`
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readAttendanceReport($stmt)
    {
        $data = array();
        $data_value = array();
        $salesRep = $this->salesRep;
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //     $query1 = "SELECT `start_date` AS `date` FROM `sales_rep__leave` WHERE start_date BETWEEN '$fromDate' AND '$toDate'  UNION  SELECT schedule_sales_rep.schedule_date AS `date` FROM schedule_sales_rep WHERE sales_rep_token='$salesRep' AND schedule_sales_rep.schedule_date BETWEEN '$fromDate' AND '$toDate' ORDER BY date ASC";  
            //     $stmt1 = $this->conn->prepare( $query1 );
            //     $stmt1->execute();
            //    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
            //       $date = $row1['date'];
            //    }
            $data[] = array(
                "date" => $row['scheduled_dates'],
                "sales_rep_name" => $row['sales_rep_name'] == "" ? "-" : $row["sales_rep_name"],
                "region_name" => $row['region_name'] == "" ? "-" : $row["region_name"],
                "distributor_name" => $row['distributor_name'] == "" ? "-" : $row["distributor_name"],
                "area_name" => $row['area_name'] == "" ? "-" : $row["area_name"],
                "expense_amount" => $row['expense_amount'] == "" ? "-" : $row["expense_amount"]
            );
        }

        return $data;
    }
    function attendance_leave_Report()
    {
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        $salesRep = $this->salesRep;
        $query = "SELECT
        `start_date`,
        `end_date`
    FROM
        `sales_rep__leave`
    WHERE
        `start_date` BETWEEN '$fromDate' AND  '$toDate' AND end_date BETWEEN '$fromDate' AND '$toDate' AND sales_rep_token = '$salesRep' AND
        `status`
        = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function attendance_leave_Report_read($stmt1)
    {
        $data1 = [];
        while ($rows = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->start_date = $rows['start_date'];
            $obj1->end_date = $rows['end_date'];
            array_push($data1, $obj1);
        }
        return $data1;
    }

    // presence based on orders (treat as present if orders exist for the rep on the date)
    function orderPresenceReport()
    {
        $fromDate = $this->fromDate;
        $toDate = $this->toDate;
        $salesRep = $this->salesRep;

        $fromDateStart = $fromDate . ' 00:00:00';
        $fromDateEnd = $toDate . ' 23:59:59';

        $query = "SELECT
            DATE(`orders`.`date_time`) AS scheduled_dates,
            `employees`.`name` AS sales_rep_name,
            GROUP_CONCAT(DISTINCT COALESCE(`distributor`.`name`, `orders`.`distributor_token`)) AS distributor_name,
            COALESCE((
                SELECT SUM(`sales_rep__expense__details`.`amount`)
                FROM `sales_rep__expense__details`
                WHERE `sales_rep__expense__details`.`sales_rep__token` = `orders`.`sales_rep_token`
                    AND DATE(`sales_rep__expense__details`.`date_time`) = DATE(`orders`.`date_time`)
                    AND `sales_rep__expense__details`.`status` = '1'
            ), '0') AS expense_amount,
            COALESCE(`shop`.`city`, '-') AS area_name,
            '-' AS region_name
        FROM `orders`
        INNER JOIN `employees` ON `employees`.`token` = `orders`.`sales_rep_token`
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        WHERE `orders`.`sales_rep_token` = ?
            AND DATE(`orders`.`date_time`) BETWEEN '$fromDate' AND '$toDate'
        GROUP BY DATE(`orders`.`date_time`)
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesRep);
        $stmt->execute();
        return $stmt;
    }

    function readOrderPresence($stmt)
    {
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = array(
                "date" => $row['scheduled_dates'],
                "sales_rep_name" => $row['sales_rep_name'] == "" ? "-" : $row['sales_rep_name'],
                "region_name" => $row['region_name'] == "" ? "-" : $row['region_name'],
                "distributor_name" => $row['distributor_name'] == "" ? "-" : $row['distributor_name'],
                "area_name" => $row['area_name'] == "" ? "-" : $row['area_name'],
                "expense_amount" => $row['expense_amount'] == "" ? "-" : $row['expense_amount']
            );
        }
        return $data;
    }

    //orderLog
    function getDetails()
    {
        $query = "SELECT `orders__items`.`quantity`,`orders__items`.`offer_percentage` FROM `orders__items` WHERE `order_token`=?  AND `product_token`= ? AND `is_free`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->order_token);
        $stmt->bindParam(2, $this->product_token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->quantity = $row["quantity"];
        $obj->discount_distributor = $row["offer_percentage"];
        return $obj;
    }

    function getDetail()
    {
        $query = "SELECT `orders__items`.`quantity` FROM `orders__items` WHERE `order_token`=?  AND `product_token`= ? AND `is_free`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->order_token);
        $stmt->bindParam(2, $this->product_token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->quantity = $row["quantity"];
        return $obj;
    }

    function updateboxInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `product_token`=:product_token,
    `distributor_token`=:distributor_token,
    `old_quantity`=:old_quantity,
    `new_quantity`=:boxCount,
    `old_discount`='0',
    `new_discount`='0',
    `delete_status`='1',
    `delivery`='Pending',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->order_token);
        $stmt->bindParam('product_token', $this->product_token);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('old_quantity', $this->old_quantity);
        $stmt->bindParam('boxCount', $this->boxCount);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updatediscountInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `product_token`=:product_token,
    `distributor_token`=:distributor_token,
    `old_quantity`=:old_quantity,
    `new_quantity`=:old_quantity,
    `old_discount`=:discount_distributor,
    `new_discount`=:offer_percentage,
    `delete_status`='1',
    `delivery`='Pending',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->order_token);
        $stmt->bindParam('product_token', $this->product_token);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('old_quantity', $this->old_quantity);
        $stmt->bindParam('discount_distributor', $this->discount_distributor);
        $stmt->bindParam('offer_percentage', $this->offer_percentage);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function addProductInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `product_token`=:product_token,
    `distributor_token`=:distributor_token,
    `old_quantity`=:boxCount,
    `new_quantity`=:boxCount,
    `old_discount`='0',
    `new_discount`='0',
    `delete_status`='1',
    `delivery`='Pending',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->order_token);
        $stmt->bindParam('product_token', $this->product_token);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('boxCount', $this->boxCount);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteProductInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `product_token`=:product_token,
    `distributor_token`=:distributor_token,
    `old_quantity`=:old_quantity,
    `new_quantity`=:old_quantity,
    `old_discount`=:discount_distributor,
    `new_discount`=:discount_distributor,
    `delete_status`='2',
    `delivery`='Pending',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->order_token);
        $stmt->bindParam('product_token', $this->product_token);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('old_quantity', $this->old_quantity);
        $stmt->bindParam('discount_distributor', $this->discount_distributor);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function approveInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `distributor_token`=:distributor_token,
    `product_token`='0',
    `old_quantity`='0',
    `new_quantity`='0',
    `old_discount`='0',
    `new_discount`='0',
    `delete_status`='1',
    `delivery`='Approved',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->orderToken);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function cancelInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `distributor_token`=:distributor_token,
    `product_token`='0',
    `old_quantity`='0',
    `new_quantity`='0',
    `old_discount`='0',
    `new_discount`='0',
    `delete_status`='1',
    `delivery`='Cancelled',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->orderToken);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function deliverInsertLog($indiaDateTime)
    {
        $query = "INSERT INTO `orders_log` SET 
    `order_token`=:order_token,
    `product_token`='0',
    `distributor_token`=:distributor_token,
    `old_quantity`='0',
    `new_quantity`='0',
    `old_discount`='0',
    `new_discount`='0',
    `delete_status`='1',
    `delivery`='Completed',
    `date_time`='$indiaDateTime',
    `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('order_token', $this->orderToken);
        $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}