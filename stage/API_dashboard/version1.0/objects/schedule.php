<?php
class Schedule{

    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function unitCheck(){
        $stateQuery = $this->stateQuery;
        $query = "SELECT `units`.`token`,
        `units`.`name`,
        COUNT(`units__shop_mapping`.`id`) AS `shop_count`,
        COALESCE(GROUP_CONCAT(`shop`.`name`),'') AS `shop_name`,
         `units`.`distributor_token`,
        COALESCE(`employees`.`name`,'Admin') AS `distributor`
        FROM `units`
        INNER JOIN `units__shop_mapping` ON (
            `units__shop_mapping`.`unit_group_token`=`units`.`token`
            AND `units__shop_mapping`.`delete_status`='1'
        )
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `units__shop_mapping`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token`=`shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `units`.`distributor_token`=`employees`.`token` $stateQuery
		GROUP BY `units`.`token`
        ORDER BY `units`.`id` DESC";
        $stmt = $this->conn->prepare( $query ); 
        $stmt->execute();
        return $stmt;
    }
    function readUnit($stmt,$indiaDate) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            $obj->shop_count = $row['shop_count'];
            $obj->shop_name  = $row['shop_name'];
            $obj->distributor= $row['distributor'];
            
            $day  = date('l',strtotime($indiaDate));
            $token= $row['token'];
            $query1 = "SELECT `id` FROM `daily_schedule` 
            WHERE `unit_token`='$token' 
            AND `schedule_date`='$day'
            AND (sales_emp_token!=''
            OR delivery_emp_token!='')";
            $stmt1  = $this->conn->prepare( $query1 );
            $stmt1->execute();
            $checkCount = $stmt1->rowCount();
           
            if($checkCount==0){
                $obj->status = '<button class="tb-btn red">Not scheduled</button>';
            }else{
                $obj->status = '<button class="tb-btn greenbtn">Scheduled</button>';
            }
            array_push($array, $obj);
        }
        return $array;
    }
    function unitShopCheck(){
        $query = "SELECT `token`,`name` FROM `shop` WHERE unit_token=''";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function readUnitShop($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            array_push($array, $obj);
        }
        return $array;
    }
    function tokenGenerate(){
        $random = rand(10000000,99999999);
        $val=true;
        do{
            $query = "SELECT `id` FROM `units` WHERE `token`=?";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $random);
            $stmt->execute();
            if($stmt->rowCount()==0){
                $val = false;
            }else{
                $random = rand(10000000,99999999);
            }
        }while($val);
        return $random;
    }
    function addUnit($indiaDateTime){
        $query = "INSERT INTO `units` SET `date_time`='$indiaDateTime',
        `token`=:token,
        `name`=:name,
        `distributor_token`=''";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->unitName); 
        $stmt->execute();
        return $stmt;
    }
    function shopMappingCheck(){
        $query = "SELECT `id` FROM `shop` WHERE `token`=? AND `unit_token`=''";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->shopToken);
        $stmt->execute();
        return $stmt;
    }
    function addUnitMapping($indiaDateTime){
        $query = "INSERT INTO `units__shop_mapping` SET `unit_group_token`=:unit_group_token,
        `distributor_token`='',
        `shop_token`=:shop_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unit_group_token', $this->token);
        $stmt->bindParam('shop_token', $this->shopToken);
        $stmt->execute();
        $query1 = "UPDATE `shop` SET `unit_token`=? WHERE `token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->shopToken);
        $stmt1->execute();
        return $stmt1;
    }
    function selectedShop(){
        $query = "SELECT `shop`.`token`,
        `shop`.`name`,
        CONCAT(`shop`.`address`,', ',`shop`.`city`,', ',`shop`.`pincode`) AS `address`
        FROM `units__shop_mapping`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `units__shop_mapping`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token`=`shop_mapping`.`shop_token`
        -- INNER JOIN `shop` ON `shop`.`token`=`units__shop_mapping`.`shop_token`
        WHERE  `units__shop_mapping`.`unit_group_token`=?
        AND `units__shop_mapping`.delete_status='1'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function readSelectedShop($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            $obj->address    = $row['address'];
            array_push($array, $obj);
        }
        return $array;
    }
    function readSelectedShopToken($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($array, $row['token']);
        }
        return $array;
    }
    function removeShopUnit(){
        $query = "UPDATE `units__shop_mapping` 
        SET `delete_status`='2' 
        WHERE `unit_group_token`=:unit_group_token 
        AND `shop_token`=:shop_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unit_group_token', $this->token);
        $stmt->bindParam('shop_token', $this->removeToken);
        $stmt->execute();
        $query1 = "UPDATE `shop` SET `unit_token`='' WHERE `token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->removeToken);
        $stmt1->execute();
        return $stmt1;
    }
    function salesEmployeeCheck(){
        $query = "SELECT `token`,
        `name` 
        FROM `employees` 
        WHERE `deparment_token`='45916684' 
        AND `admin_distributor_token`=''";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function deliveryEmployeeCheck(){
        $query = "SELECT `token`,
        `name` 
        FROM `employees` 
        WHERE `deparment_token`='93402780' 
        AND `admin_distributor_token`=''";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }
    function readSalesemployee($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            array_push($array, $obj);
        }
        return $array;
    }
    function dailyScheduleCheck(){
        $query = "SELECT `id` FROM `daily_schedule` WHERE `unit_token`=? AND `schedule_date`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->day);
        $stmt->execute();
        return $stmt;
    }
    function insertDailySchedule($indiaDateTime){
        $query = "INSERT INTO `daily_schedule` SET `unit_token`=:unit_token,
        `distributor_token`='',
        `sales_emp_token`=:sales_emp_token,
        `delivery_emp_token`=:delivery_emp_token,
        `schedule_date`=:schedule_date,
        `date_time`='$indiaDateTime'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unit_token', $this->token);
        $stmt->bindParam('sales_emp_token', $this->saleEmployee); 
        $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee);
        $stmt->bindParam('schedule_date', $this->day); 
        $stmt->execute();
        return $stmt;
    }
    function updateDailySchedule(){
        $query = "UPDATE `daily_schedule` SET
        `sales_emp_token`=:sales_emp_token,
        `delivery_emp_token`=:delivery_emp_token
        WHERE `schedule_date`=:schedule_date 
        AND `unit_token`=:unit_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('sales_emp_token', $this->saleEmployee);
        $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee); 
        $stmt->bindParam('schedule_date', $this->day);
        $stmt->bindParam('unit_token', $this->token); 
        $stmt->execute();
        return $stmt;
    }
    function scheduledEmployeeCheck(){
        $query = "SELECT `daily_schedule`.`sales_emp_token`,
        COALESCE(`sales_employees`.`name`,'') AS `sales_emp_name`,
        `daily_schedule`.`delivery_emp_token`,
        COALESCE(`dist_employees`.`name`,'') AS `delivery_emp_name`
        FROM `daily_schedule` 
        LEFT  JOIN `employees` AS `sales_employees` ON `sales_employees`.`token`=`daily_schedule`.`sales_emp_token`
        LEFT  JOIN `employees` AS `dist_employees` ON `dist_employees`.`token`=`daily_schedule`.`delivery_emp_token`
        WHERE `unit_token`=? 
        AND `schedule_date`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->day);
        $stmt->execute();
        return $stmt;
    }
    function readEmpToken($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->sales_emp_token   = $row['sales_emp_token'];
        $obj->sales_emp_name    = $row['sales_emp_name'];
        $obj->delivery_emp_token= $row['delivery_emp_token'];
        $obj->delivery_emp_name = $row['delivery_emp_name'];
        return $obj;
    }
}
?>