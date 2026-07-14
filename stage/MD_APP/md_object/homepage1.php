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
        $obj->Outstanding_amt = $row2["employees_count"]; 
           
           $query3 = "SELECT COUNT(`id`) AS `shop_count` 
           FROM `shop` 
           WHERE `delete_status` = '1'";
           $stmt3 = $this->conn->prepare($query3);
           $stmt3->execute();
           $row3 = $stmt3->fetch(PDO::FETCH_ASSOC); 
           $obj->shop_count = $row3["shop_count"]; 
           return $obj;
    }
    // TOP 10 SHOPS
    function top10Shop(){
        $shopQuery = "SELECT
        `shop`.`token`,
        `shop`.`name`,
        SUM(`orders`.`billing_amount`) AS `billing_amt`
    FROM
        `orders`
    INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
    INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        --  INNER JOIN `shop` ON `orders`.`shop_token` = `shop`.`token`
    INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
    WHERE
        `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled'
    GROUP BY
        `orders`.`shop_token`
    ORDER BY
        `billing_amt`
    DESC
    LIMIT 10";
        $shopSt = $this->conn->prepare($shopQuery);
        $shopSt->execute();
        return $shopSt;
    }
    function readTop10Shop($shopSt){
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
    

}
