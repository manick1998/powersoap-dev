<?php
class Admin{
    public $userEmail;
    public $userPassword;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    function loginEmailCheck(){
        $query = "SELECT `id`,`name`,`token`,`email`,`phone_number` FROM `admin_login` WHERE `email`=:email";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('email', $this->userEmail);
        $stmt->execute();
        return $stmt;
    }
    function loginStatusCheck(){
        $query = "SELECT `id`,`name`,`token`,`email`,`phone_number` FROM `admin_login` WHERE `email`=:email AND `status`=1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('email', $this->userEmail);
        $stmt->execute();
        return $stmt;
    }
    function employeeLoginCheck(){
        $user_password  = hash('sha512', $this->userPassword);
        $query = "SELECT `id`,`name`,`token`,`email`,`phone_number` FROM `admin_login` WHERE `email`=:email AND `password`=:password AND `status` =1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('email', $this->userEmail);
        $stmt->bindParam('password', $user_password);
        $stmt->execute();
        return $stmt;
    }
    function readToken($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = (int)$row['token'];
        return $token;
    }
    
    function getReportDetailsForAdmin(){
        $obj = new stdClass();
        $query = "SELECT COUNT(`orders`.`id`) AS `order_count` 
        FROM `orders` 
        where `order_type` in ('Distributor Order') AND `orders`.`delivery` != 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj->order_count = $row["order_count"];
        $query1 = "SELECT COUNT(`id`) AS `employees_count` 
        FROM `employees` 
        WHERE `deparment_token` IN ('18028120') AND `delete_status` ='1' AND `block_status` = '1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj->employees_count = $row1["employees_count"];
        $query2 = "SELECT COUNT(`id`) AS `employees_count` FROM `employees` WHERE `deparment_token` in ('72602780','98765433','98765434') AND `delete_status` = '1' AND `block_status` = '1'";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $obj->salesRepTotal = $row2["employees_count"]; 
           
           $query3 = "SELECT COUNT(`id`) AS `shop_count` 
           FROM `shop` 
           WHERE `delete_status` = '1'";
           $stmt3 = $this->conn->prepare($query3);
           $stmt3->execute();
           $row3 = $stmt3->fetch(PDO::FETCH_ASSOC); 
           $obj->shop_count = $row3["shop_count"]; 
           return $obj;
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
    
    function incomeDetails(){
        $curr_years = $this->cur_year;
        $query = "SELECT COALESCE(SUM(`billing_amount`),0)AS total  FROM `orders` WHERE `date_time` LIKE '%$curr_years%'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $overAllTotal = $row['total'];
        return $overAllTotal;
    }

    function incomeDetailsMonth(){
        $curr = $this->cur;
        $query = "SELECT COALESCE(SUM(`billing_amount`),0)AS total  FROM `orders` WHERE `date_time` LIKE '$curr%'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $overAllMonth = $row['total'];
        return $overAllMonth;
    }

    

}
