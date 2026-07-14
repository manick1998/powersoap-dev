<?php 
class Report{
    public $conn;
    public $distributor_token;
    public $fromDate;
    public $toDate;
    public $cur_year;
    
    public function __construct($db) {
        $this->conn = $db;
    }

    public function getDashboardSummary() {
        $summary = new stdClass();
        
        // 1. Box Data
        $summary->box_Data = $this->getReportDetailsForAdmin();
        
        // 2. Pie Chart
        $unitSt = $this->unitSaleForAdmin();
        $unit_data = $this->readUnitSaleForAdmin($unitSt);
        $summary->pie_chart = [
            "unit_names" => array_column($unit_data, 'unit_name'),
            "unit_sales" => array_column($unit_data, 'unit_sales'),
            "random_color" => array_column($unit_data, 'random_color')
        ];
        
        // 3. Top Distributor
        $distSt = $this->top10Distributor();
        $summary->dist_Data = $this->readTop10Distributor($distSt);
        
        // 4. Top Selling
        $productSt = $this->top10SellingProductForAmin();
        $summary->top_product_Data = $this->readTop10SellingProductForAmin($productSt);
        
        // 5. Bot Selling
        $productSt1 = $this->bottom10SellingProductForAmin();
        $summary->bottom_product_Data = $this->readbottom10SellingProductForAmin($productSt1);
        
        return $summary;
    }
    
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    
    function getReportDetails(){
        $obj = new stdClass();
        $query = "SELECT count(`orders`.`id`) AS `order_count` FROM `orders` 
        INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
        WHERE `employees`.`admin_distributor_token` =? AND `order_type` in ('Sales Order','Spot Order') AND `orders`.`delivery` != 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj->order_count = $row["order_count"];
        $query1 = "SELECT COUNT(`id`) AS `employees_count` 
        FROM `employees` 
        WHERE `admin_distributor_token` = ? AND `delete_status` = '1' AND `block_status` = '1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1,$this->distributor_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj->employees_count = $row1["employees_count"];
        $query2 = "SELECT
 		`orders`.`shop_token`,
         SUM(`orders`.`bill_discount_amount`) AS `bill_discount_amount`,
         SUM(CASE WHEN `bill_discount_percentage` !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as `percentage_value`,
         SUM(`orders`.`billing_amount` -`orders`.`paid_amount`) AS `outstanding_amt`
        FROM
            `orders`
        INNER JOIN `employees` ON `employees`.`token` = `orders`.`employee_token`
        WHERE `employees`.`admin_distributor_token` =? AND `orders`.`delivery` != 'Cancelled'";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1,$this->distributor_token);
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            if($row2['bill_discount_amount'] > 0){
               $newOutstanding = round($row2['outstanding_amt']-$row2['bill_discount_amount'],0);
            }
            if($row2['bill_discount_amount'] > 0 && $row2['percentage_value'] > 0){
               $newOutstanding = round($newOutstanding-$row2['percentage_value'],0);
            }
            if($row2['bill_discount_amount'] == 0 && $row2['percentage_value'] > 0){
               $newOutstanding = round($row2['outstanding_amt']-$row2['percentage_value'],0);
            }
            if($row2['bill_discount_amount'] == 0 && $row2['percentage_value'] == 0){
               $newOutstanding = round($row2['outstanding_amt'],0);
            }
       $obj->Outstanding_amt = $newOutstanding;
       $query3 = "SELECT
       COUNT(shop.`id`) AS `shop_count`
   FROM
       `shop`
   INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token
   WHERE
       shop_mapping.`distributor_token` = ? AND shop.`delete_status` = 1";
       $stmt3 = $this->conn->prepare($query3);
       $stmt3->bindParam(1,$this->distributor_token);
       $stmt3->execute();
       $row3 = $stmt3->fetch(PDO::FETCH_ASSOC); 
       $obj->shop_count = $row3["shop_count"]; 
       return $obj;
    }
    
    function unitSale(){
        $unitQuery = "SELECT 
        `units`.`name` AS `unit_name`,
        `units`.`token` AS `unit_token`,
        SUM(`orders`.`billing_amount`) AS `unit_sales`
       	FROM `orders` 
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` =  `orders`.`shop_token`
        INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `employees`.`admin_distributor_token` =? GROUP BY `units`.`name`";
        $unitSt = $this->conn->prepare($unitQuery);
        $unitSt->bindParam(1,$this->distributor_token);
        $unitSt->execute();
        return $unitSt;
    }
    
    function readUnitSale($unitSt){
        $unitArray = [];
        while($row = $unitSt->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->unit_name = $row["unit_name"];
           $obj->unit_token = $row["unit_token"];
           $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
           $obj->random_color = '#'.$rand;
           $obj->unit_sales = round($row["unit_sales"],2);
            array_push($unitArray, $obj);
        }
      return $unitArray;
    }
    
   //Starts Bar Graph
    
   function categorySale(){
        $curr_years = $this->cur_year;
        $categoryQuery = "SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
        MONTHNAME(`orders`.`date_time`) AS `Month`, 
        CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
        FROM `orders`
        INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        where `employees`.`admin_distributor_token` =? AND `orders`.`date_time` LIKE '$curr_years%' GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)";
        $categorySt = $this->conn->prepare($categoryQuery);
        $categorySt->bindParam(1,$this->distributor_token);
        $categorySt->execute();
        return $categorySt;
    }
    
   function monthAndYearofCategory($categorySt){
        $categoryMonth = [];
        while($row = $categorySt->fetch(PDO::FETCH_ASSOC)){
            $monthlyYear = $row['MonthlyYear'];
            array_push($categoryMonth, $monthlyYear);
        }
        return $categoryMonth;
   }
    
   function readProductCategory($categorySt, $catTok){
       $obj = new stdClass();
       $washingSoaps=[];
        while($row = $categorySt->fetch(PDO::FETCH_ASSOC)){
            $YearMonth = $row['year_and_month'];
            $catName = "SELECT
            `products__category`.`name` AS `category_name`
             FROM `products__category`
             WHERE `products__category`.`token` ='$catTok'";
            $catSt1 = $this->conn->prepare($catName);
            $catSt1->execute();
            $row21 = $catSt1->fetch(PDO::FETCH_ASSOC);
            $obj->catName = $row21["category_name"];
            $categoryMonQuery1 = "SELECT
            MONTHNAME(`orders`.`date_time`) AS `Monthly`,
            COALESCE(`products__category`.`name`,'0') AS `category_name`,
            COALESCE(SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                        WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                        Else 0
                        END),'0') AS `total_quantity`
             FROM `orders__items`
            INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
            INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
            INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
            INNER JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
            WHERE `employees`.`admin_distributor_token` =? AND `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` LIKE '$YearMonth%' AND `products__category`.`token` ='$catTok'";
            $categoryMonSt1 = $this->conn->prepare($categoryMonQuery1);
            $categoryMonSt1->bindParam(1, $this->distributor_token);
            $categoryMonSt1->execute();
           
                 while($row1 = $categoryMonSt1->fetch(PDO::FETCH_ASSOC)){
                        $total_quantity = $row1["total_quantity"];
                        array_push($washingSoaps, $total_quantity);
                }
            
           $obj->CategorySales = $washingSoaps;
        }
        return $obj;
    }
    
    //Ends Bar Graph
    
    function top10ShopUnderDistributor(){
        $shopQuery = "SELECT `shop`.`token`, `shop`.`name`, sum(`orders`.`billing_amount`) AS `billing_amt`
         FROM `orders` 
         INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
         INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        --  INNER JOIN `shop` ON `orders`.`shop_token` = `shop`.`token`
         INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
         WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `employees`.`admin_distributor_token` =? GROUP BY `orders`.`shop_token` order by `billing_amt` desc limit 10";
        $shopSt = $this->conn->prepare($shopQuery);
        $shopSt->bindParam(1,$this->distributor_token);
        $shopSt->execute();
        return $shopSt;
    }
    
    function top10ShopUnderDistributorDateFilter(){
        $shopQuery = "SELECT `shop`.`token`, `shop`.`name`, sum(`orders`.`billing_amount`) AS `billing_amt`
         FROM `orders` 
         INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
         INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
         INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
         WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` BETWEEN ? AND ? AND `employees`.`admin_distributor_token` =? GROUP BY `orders`.`shop_token` order by `billing_amt` desc limit 10";
        $shopSt = $this->conn->prepare($shopQuery);
        $shopSt->bindParam(1, $this->fromDate);
        $shopSt->bindParam(2, $this->toDate);
        $shopSt->bindParam(3, $this->distributor_token);
        $shopSt->execute();
        return $shopSt;
    }
    
    function readTop10ShopUnderDistributor($shopSt){
        $shopArray = [];
        while($row = $shopSt->fetch(PDO::FETCH_ASSOC)){
            $obj = new stdClass();
            $obj->shop_token = $row["token"]; 
            $obj->shop_name = $row["name"]; 
            $obj->billing_amt = round($row["billing_amt"],2);
            array_push($shopArray, $obj);
        }
        return $shopArray;
    }
    
    function top10SellingProduct(){
        $selQuery = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        where `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `employees`.`admin_distributor_token`=? GROUP BY `orders__items`.`product_token` ORDER BY `productSellingCost` DESC LIMIT 10";
        $productSt = $this->conn->prepare($selQuery);
        $productSt->bindParam(1, $this->distributor_token);
        $productSt->execute();
        return $productSt;
    }
    
    function top10SellingProductDateFilter(){
        $selQuery = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        where `orders`.`date_time` BETWEEN ? AND ? AND `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `employees`.`admin_distributor_token`=? GROUP BY `orders__items`.`product_token` ORDER BY `productSellingCost` DESC LIMIT 10";
        $productSt = $this->conn->prepare($selQuery);
        $productSt->bindParam(1, $this->fromDate);
        $productSt->bindParam(2, $this->toDate);
        $productSt->bindParam(3, $this->distributor_token);
        $productSt->execute();
        return $productSt;
    }
    
    function readTop10SellingProduct($productSt){
        $selArray = [];
       while($row = $productSt->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->top_product_token = $row["token"];
           $obj->top_product_name = $row["name"];
           $obj->top_productSellingCost = round($row["productSellingCost"],2);
           array_push($selArray, $obj);
       }
        return $selArray;
    }
    
    function bottom10SellingProduct(){
        $selQuery1 = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        where `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `employees`.`admin_distributor_token`=? GROUP BY `orders__items`.`product_token` ORDER BY `productSellingCost` asc LIMIT 10";
        $productSt1 = $this->conn->prepare($selQuery1);
        $productSt1->bindParam(1, $this->distributor_token);
        $productSt1->execute();
        return $productSt1;
    } 
    
    function bottom10SellingProductDateFilter(){
             $selQuery1 = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        where `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` BETWEEN ? AND ? AND `employees`.`admin_distributor_token`=? GROUP BY `orders__items`.`product_token` ORDER BY `productSellingCost` asc LIMIT 10";
        $productSt1 = $this->conn->prepare($selQuery1);
        $productSt1->bindParam(1, $this->fromDate);
        $productSt1->bindParam(2, $this->toDate);
        $productSt1->bindParam(3, $this->distributor_token);
        $productSt1->execute();
        return $productSt1;
    }
    
    function readbottom10SellingProduct($productSt1){
        $selArray = [];
       while($row = $productSt1->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->bottom_product_token = $row["token"];
           $obj->bottom_product_name = $row["name"];
           $obj->bottom_productSellingCost = round($row["productSellingCost"],2);
           array_push($selArray, $obj);
       }
        return $selArray;
    }
    
    //Admin Dashboard
    
    function getReportDetailsForAdmin(){
        $date_filter = "";
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $date_filter = " AND `date_time` BETWEEN '$this->fromDate' AND '$this->toDate'";
        }
        
        $obj = new stdClass();
        $query = "SELECT 
            (SELECT COUNT(`id`) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` != 'Cancelled' $date_filter) AS `order_count`,
            (SELECT COUNT(`id`) FROM `employees` WHERE `deparment_token` IN ('45916684','93402780') AND `delete_status` ='1' AND `block_status` = '1') AS `employees_count`,
            (SELECT COUNT(`id`) FROM `employees` WHERE `deparment_token`='18028120' AND `delete_status` = '1' AND `block_status` = '1') AS `distributor_count`,
            (SELECT COUNT(`id`) FROM `shop` WHERE `delete_status` = '1') AS `shop_count`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj->order_count = $row["order_count"];
        $obj->employees_count = $row["employees_count"];
        $obj->Outstanding_amt = $row["distributor_count"]; 
            $obj->shop_count = $row["shop_count"]; 
        return $obj;
    }

    function getAdminOverviewStats(){
        $obj = new stdClass();
        $todayStart = date("Y-m-d 00:00:00");
        $todayEnd = date("Y-m-d 23:59:59");
        $yesterdayStart = date("Y-m-d 00:00:00", strtotime("-1 day"));
        $yesterdayEnd = date("Y-m-d 23:59:59", strtotime("-1 day"));

        $query = "SELECT
            (SELECT COUNT(`id`) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` != 'Cancelled' AND `date_time` BETWEEN ? AND ?) AS `today_orders`,
            (SELECT COUNT(`id`) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` != 'Cancelled' AND `date_time` BETWEEN ? AND ?) AS `yesterday_orders`,
            (SELECT COALESCE(SUM(`billing_amount`), 0) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` != 'Cancelled' AND `date_time` BETWEEN ? AND ?) AS `today_sales`,
            (SELECT COALESCE(SUM(`billing_amount`), 0) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` != 'Cancelled' AND `date_time` BETWEEN ? AND ?) AS `yesterday_sales`,
            (SELECT COUNT(`id`) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` NOT IN ('Completed','Cancelled') AND `date_time` BETWEEN ? AND ?) AS `active_deliveries`,
            (SELECT COUNT(`id`) FROM `orders` WHERE `order_type` IN ('Sales Order','Spot Order','Retailer order') AND `delivery` NOT IN ('Completed','Cancelled') AND `date_time` BETWEEN ? AND ?) AS `yesterday_active_deliveries`,
            (SELECT COUNT(`id`) FROM `shop` WHERE `delete_status` = '1') AS `active_retailers`,
            (SELECT COUNT(`id`) FROM `shop` WHERE `delete_status` = '1' AND `date_time` <= ?) AS `yesterday_active_retailers`";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            $todayStart, $todayEnd,
            $yesterdayStart, $yesterdayEnd,
            $todayStart, $todayEnd,
            $yesterdayStart, $yesterdayEnd,
            $todayStart, $todayEnd,
            $yesterdayStart, $yesterdayEnd,
            $yesterdayEnd
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $obj->today_orders = (int) $row["today_orders"];
        $obj->yesterday_orders = (int) $row["yesterday_orders"];
        $obj->today_sales = round((float) $row["today_sales"], 2);
        $obj->yesterday_sales = round((float) $row["yesterday_sales"], 2);
        $obj->active_deliveries = (int) $row["active_deliveries"];
        $obj->yesterday_active_deliveries = (int) $row["yesterday_active_deliveries"];
        $obj->active_retailers = (int) $row["active_retailers"];
        $obj->yesterday_active_retailers = (int) $row["yesterday_active_retailers"];
        return $obj;
    }
    
    function unitSaleForAdmin(){
        $date_filter = "";
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $date_filter = " AND `orders`.`date_time` BETWEEN '$this->fromDate' AND '$this->toDate'";
        }

        $unitQuery = "SELECT 
        `units`.`name` AS `unit_name`,
        SUM(`orders`.`billing_amount`) AS `unit_sales`
        FROM `orders`
        JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `orders`.`order_type` IN ('Sales Order','Spot Order','Retailer order') 
        AND `orders`.`delivery` != 'Cancelled' $date_filter
        GROUP BY `units`.`name` 
        ORDER BY `unit_sales` DESC LIMIT 10";
        $unitSt = $this->conn->prepare($unitQuery);
        $unitSt->execute();
        return $unitSt;
    }
    
    function readUnitSaleForAdmin($unitSt){
        $unitArray = [];
        while($row = $unitSt->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->unit_name = $row["unit_name"];
           $obj->unit_token = $row["unit_token"];
           $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
           $obj->random_color = '#'.$rand;
           $obj->unit_sales = round($row["unit_sales"],2);
            array_push($unitArray, $obj);
        }
      return $unitArray;
    }
    
    function categorySaleForAdmin(){
        $curr_years = $this->cur_year;
        $categoryQuery = "SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
        MONTHNAME(`orders`.`date_time`) AS `Month`, 
        CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
        FROM `orders` WHERE `orders`.`date_time` LIKE '$curr_years%'
        GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)";
        $categorySt = $this->conn->prepare($categoryQuery);
        $categorySt->execute();
        return $categorySt;
    }
    
    function readCategorySaleForAdmin($categorySt, $catTok){
       $obj = new stdClass();
       $washingSoaps=[];
        while($row = $categorySt->fetch(PDO::FETCH_ASSOC)){
            $YearMonth = $row['year_and_month'];
            $catName = "SELECT
            `products__category`.`name` AS `category_name`
             FROM `products__category`
             WHERE `products__category`.`token` ='$catTok'";
            $catSt1 = $this->conn->prepare($catName);
            $catSt1->execute();
            $row21 = $catSt1->fetch(PDO::FETCH_ASSOC);
            $obj->catName = $row21["category_name"];
            $categoryMonQuery1 = "SELECT
            MONTHNAME(`orders`.`date_time`) AS `Monthly`,
            COALESCE(`products__category`.`name`,'0') AS `category_name`,
            COALESCE(SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                        WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                        Else 0
                        END),'0') AS `total_quantity`
             FROM `orders__items`
            INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
            INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
            INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
            INNER JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
            WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order','Retailer order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` LIKE '$YearMonth%' AND `products__category`.`token` ='$catTok'";
            $categoryMonSt1 = $this->conn->prepare($categoryMonQuery1);
            $categoryMonSt1->execute();
                 while($row1 = $categoryMonSt1->fetch(PDO::FETCH_ASSOC)){
                        $total_quantity = $row1["total_quantity"];
                        array_push($washingSoaps, $total_quantity);
                }
           $obj->CategorySales = $washingSoaps;
        }
        return $obj;
    }
      
    function top10Distributor(){
        $date_filter = "";
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $date_filter = " AND `orders`.`date_time` BETWEEN '$this->fromDate' AND '$this->toDate'";
        }

        $distQuery = "SELECT 
        `distributor`.`name` AS `distributor_name`,
        SUM(`orders`.`billing_amount`) AS `distributor_sales`
        FROM `orders`
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token` = `orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `sales_man`.`admin_distributor_token`        
        WHERE `orders`.`order_type` IN ('Sales Order','Spot Order','Retailer order') 
        AND `orders`.`delivery` != 'Cancelled'
        AND `sales_man`.`deparment_token` IN (45916684,93402780) $date_filter
        GROUP BY `distributor`.`name` 
        ORDER BY `distributor_sales` DESC LIMIT 10";
        $distSt = $this->conn->prepare($distQuery);
        $distSt->execute();
        return $distSt;
    }
    
    function top10DistributorDateRange(){
        $distQuery = "SELECT `distributor`.`name` AS `distributor_name`, 
        SUM(`orders`.`billing_amount`) AS `distributor_sales`,
        `distributor`.`token` AS `distributor_token`
        from `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token` = `orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `sales_man`.`admin_distributor_token`
        WHERE `orders`.`date_time` BETWEEN ? AND ? AND `sales_man`.`deparment_token` IN (45916684,93402780) AND `orders`.`delivery` != 'Cancelled' GROUP BY `distributor`.`name` order by `distributor_sales` desc LIMIT 10";
        $distSt = $this->conn->prepare($distQuery);
        $distSt->bindParam(1, $this->fromDate);
        $distSt->bindParam(2, $this->toDate);
        $distSt->execute();
        return $distSt;
    }
    
    function readTop10Distributor($distSt){
        $distArray = [];
        while($row = $distSt->fetch(PDO::FETCH_ASSOC)){
            $obj = new stdClass();
            $obj->distributor_name = $row["distributor_name"]; 
            $obj->distributor_sales = round($row["distributor_sales"],2); 
            $obj->distributor_token = $row["distributor_token"];
            array_push($distArray, $obj);
        }
        return $distArray;
    }
    
    function top10SellingProductForAmin(){
        $date_filter = "";
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $date_filter = " AND `orders`.`date_time` BETWEEN '$this->fromDate' AND '$this->toDate'";
        }

        $productQuery = "SELECT 
        `products`.`token`,
        `products`.`name`,
        SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                 WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                 Else 0
            END*`price_per_unit`) AS `productSellingCost`
        FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        WHERE `orders`.`order_type` IN ('Sales Order','Spot Order','Retailer order') 
        AND `orders`.`delivery` != 'Cancelled' $date_filter
        GROUP BY `products`.`token`, `products`.`name` 
        ORDER BY `productSellingCost` DESC LIMIT 10";
        $productSt = $this->conn->prepare($productQuery);
        $productSt->execute();
        return $productSt;
    }
    
    function top10SellingProductForAminDateRange(){
        $selQuery = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        WHERE `orders`.`date_time` BETWEEN ? AND ? AND `orders`.`order_type` IN('Sales Order', 'Spot Order','Retailer order') AND `orders`.`delivery` != 'Cancelled'
        GROUP BY `products`.`token`, `products`.`name` ORDER BY `productSellingCost` DESC LIMIT 10";
        $productSt = $this->conn->prepare($selQuery);
        $productSt->bindParam(1, $this->fromDate);
        $productSt->bindParam(2, $this->toDate);
        $productSt->execute();
        return $productSt;
    }
    
    function readTop10SellingProductForAmin($productSt){
        $selArray = [];
       while($row = $productSt->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->top_product_token = $row["token"];
           $obj->top_product_name = $row["name"];
           $obj->top_productSellingCost = round($row["productSellingCost"],2);
           array_push($selArray, $obj);
       }
        return $selArray;
    }
    
    function bottom10SellingProductForAmin(){
        $date_filter = "";
        if(!empty($this->fromDate) && !empty($this->toDate)){
            $date_filter = " AND `orders`.`date_time` BETWEEN '$this->fromDate' AND '$this->toDate'";
        }

        $selQuery1 = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END * `orders__items`.`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order','Retailer order') AND `orders`.`delivery` != 'Cancelled' $date_filter
        GROUP BY `products`.`token`, `products`.`name` ORDER BY `productSellingCost` asc LIMIT 10";
        $productSt1 = $this->conn->prepare($selQuery1);
        $productSt1->execute();
        return $productSt1;
    } 
    
     function bottom10SellingProductForAminDateRange(){
        $selQuery1 = "SELECT
        `products`.`token`,
        `products`.`name`,
         SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                    WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                    Else 0
                    END*`price_per_unit`) AS `productSellingCost`
         FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        WHERE `orders`.`date_time` BETWEEN ? AND ? AND `orders`.`order_type` IN('Sales Order', 'Spot Order','Retailer order') AND `orders`.`delivery` != 'Cancelled'
        GROUP BY `products`.`token`, `products`.`name` ORDER BY `productSellingCost` asc LIMIT 10";
        $productSt1 = $this->conn->prepare($selQuery1);
        $productSt1->bindParam(1, $this->fromDate);
        $productSt1->bindParam(2, $this->toDate); 
        $productSt1->execute();
        return $productSt1;
    } 
    
    function readbottom10SellingProductForAmin($productSt1){
        $selArray = [];
       while($row = $productSt1->fetch(PDO::FETCH_ASSOC)){
           $obj = new stdClass();
           $obj->bottom_product_token = $row["token"];
           $obj->bottom_product_name = $row["name"];
           $obj->bottom_productSellingCost = round($row["productSellingCost"],2);
           array_push($selArray, $obj);
       }
        return $selArray; 
    }
    
    function getProductCategory(){
        $query = "SELECT * FROM `products__category` WHERE 	`delete_status` = '1'";
        $stmd = $this->conn->prepare($query);
        $stmd->execute();
        $array = [];
        while($row = $stmd->fetch(PDO::FETCH_ASSOC)){
            extract($row);
               $product_item=array(
                "token" => $token,
                "name" => $name
            );
            array_push($array, $product_item);
        }
        return $array;
    }
    
}

?>
