<?php
class Schedule{
    
    public $distributor_token;
    public $token;
    public $unitName;
    public $shopToken;
    public $shopToken_uniq;
    public $beat_tokens;
    public $custom_token;
    public $edit_unit_name;
    public $day;
    public $saleEmployee;
    public $deliveryEmployee;
    public $custom_beat_token;
    public $unit_token;
    public $shopTokens;
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function unitCheck($day = ''){
        $query = "SELECT
        u.token, u.name,
        (SELECT COUNT(*) FROM units__shop_mapping m WHERE m.unit_group_token = u.token AND m.delete_status = '1') AS shop_count,
        (SELECT COALESCE(GROUP_CONCAT(DISTINCT s.name ORDER BY s.id), '-') 
         FROM units__shop_mapping m 
         JOIN shop_mapping sm ON sm.token = m.shop_token 
         JOIN shop s ON s.token = sm.shop_token 
         WHERE m.unit_group_token = u.token AND m.delete_status = '1'
        ) AS shop_name,
        COALESCE(e.name, 'Distributor') AS distributor,
        u.status AS active_status,
        EXISTS(SELECT 1 FROM daily_schedule ds 
               WHERE ds.unit_token = u.token 
               AND ds.schedule_date = ? 
               AND (ds.sales_emp_token != '' OR ds.delivery_emp_token != '')
        ) as is_scheduled
    FROM
        `units` u
    LEFT JOIN `employees` e ON u.distributor_token = e.token
    WHERE
        u.distributor_token = ? AND (u.status != '0' OR u.status IS NULL)
    ORDER BY
        u.id
    DESC
        ";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $day);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readUnit($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            $obj->shop_count = $row['shop_count'];
            $obj->shop_name  = $row['shop_name'];
            $obj->distributor= $row['distributor'];
            $obj->active_status= $row['active_status'];
            
            if(!$row['is_scheduled']){
                $obj->status = '<button class="tb-btn red">Not scheduled</button>';
            }else{
                $obj->status = '<button class="tb-btn greenbtn">Scheduled</button>';
            }
            array_push($array, $obj);
        }
        return $array;
    }

    // custom daily schedule
    function custom_daily_schedule_table(){
        $query = "SELECT
        unit_customise.token,
        unit_customise.customunit_name,
        COUNT(
            unit_customise_mapping.unit_token
        ) AS total_unit,
        unit_customise.distributor_token
    FROM
        `unit_customise`
    INNER JOIN unit_customise_mapping ON unit_customise.token = unit_customise_mapping.custom_unit_token
    WHERE
        unit_customise_mapping.delete_status = 1  AND unit_customise.distributor_token = ?
    GROUP BY
        unit_customise.token";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function custom_read_unit($call_func,$indiaDate){
        $array = [];
        while ($row = $call_func->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row['token'];
            $obj->customunit_name = $row['customunit_name'];
            $obj->total_unit = $row['total_unit'];
            $obj->distributor= $row['distributor_token'];
            
            $day  = date('l',strtotime($indiaDate));
            $token= $row['token'];
            $query1 = "SELECT `id` FROM `custom_daily_schedule` 
            WHERE `custom_unit_token`='$token' 
            AND `schedule_date`='$day'
            AND (sales_emp_token !=''
            OR delivery_emp_token !='')";
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
        $query = "SELECT
        `shop`.`token`,
        `shop`.`name`,
        `shop`.`mobile_number`,
        `shop_mapping`.token AS shop_uniq_token
    FROM
        `shop`
    INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = shop.token
    WHERE
        shop_mapping.`distributor_token` = ? AND shop_mapping.unit_token = '' and `shop_mapping`.`status`='1' ";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function readUnitShop($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->name       = $row['name'];
            $obj->mobile       = $row['mobile_number'];
            $obj->shop_uniq_token = $row['shop_uniq_token'];
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
        `distributor_token`=:distributor_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->unitName); 
        $stmt->bindParam('distributor_token', $this->distributor_token); 
        $stmt->execute();
        return $stmt;
    }
    function shopMappingCheck(){
        $query = "SELECT shop.id FROM `shop` INNER JOIN shop_mapping ON shop.token = shop_mapping.shop_token WHERE shop.token = ? AND shop_mapping.distributor_token= ?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->shopToken);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function addUnitMapping($indiaDateTime){
        $query = "INSERT INTO `units__shop_mapping` SET `unit_group_token`=:unit_group_token,
        `distributor_token`=:distributor_token,
        `shop_token`=:shopToken_uniq";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unit_group_token', $this->token);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('shopToken_uniq', $this->shopToken_uniq);
        $stmt->execute();
        return $stmt;
    }
    function  add_shop_in_unit(){
        $query1 = "UPDATE shop_mapping INNER JOIN  shop SET shop_mapping.unit_token = ? WHERE shop_mapping.shop_token = ? AND shop_mapping.distributor_token = ?";
        //UPDATE `shop` SET `unit_token`=? WHERE `token`=? AND `distributor_token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->shopToken);
        $stmt1->bindParam(3, $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }
    
    // function unit__custom_unit(){
    //     $currentDate=date("Y-m-d H:i:s");
    //     $token=$this->token;
    //     $distributor_token=$this->distributor_token;
    //     $beat_tokens =$this->beat_tokens;
    //     foreach ($beat_tokens as $beat_token) {
    //         $arr[]="('$token','$distributor_token','$beat_token','$currentDate')";
    //       }
    //         $query="INSERT INTO `unit__custom_unit`(`custom_unit_token`,`distributor_token`,`unit_token`)VALUES ". implode(",",$arr);
    //         $stmt = $this->conn->prepare( $query );
    //         $stmt->execute();
    //         return $stmt;
    // }
    function unit_customise($indiaDateTime,$token){
        $query = "INSERT INTO `unit_customise` SET `date_time`='$indiaDateTime',
        `token`=$token,
        `customunit_name`=:unitName,
        `distributor_token`=:distributor_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unitName', $this->unitName); 
        $stmt->bindParam('distributor_token', $this->distributor_token); 
        $stmt->execute();
        return $stmt;
    }

    function unit_customise_mapping(){
        $token =$this->token;
        $beat_tokens=$this->beat_tokens;
        $distributor_token=$this->distributor_token;
        $arr=[];
       // $beat_unit_token = array_flip(array_flip(implode(',', $beat_tokens)));
       // echo "hai",$beat_unit_token;
        foreach ($beat_tokens as $beat_token){
            //$unit_token = intval($beat_token);
            // $unit_token=explode(",",$key);
            // //echo $unit_token;
            // foreach ($unit_token as  $value =>$key1) {
            //     // echo "hello",$key;
            //      array_push($arr,$key);
            //     //$unit[] ="('$token','$distributor_token','$key1')";

            //     // $query = "INSERT INTO `unit_customise_mapping`(`custom_unit_token`,`distributor_token`,`unit_token`) VALUES ".implode($unit);
            //     // $stmt = $this->conn->prepare( $query ); 
            //     // $stmt->execute();
            //     // return $stmt;         
            // }
          // $beat_unit_token = array_flip(array_flip(explode(',',$unit_token)));
              // echo "hai",$unit_token;
                    
              //echo "kk",$arr;
             //echo $beat_token;
             $unit[] ="('$token','$distributor_token','$beat_token')";
             //array_push($arr,$beat_tokens);
        }
        //echo json_encode($unit);
           $query = "INSERT INTO `unit_customise_mapping`(`custom_unit_token`,`distributor_token`,`unit_token`) VALUES ".implode(",",$unit);
           $stmt = $this->conn->prepare( $query ); 
           $stmt->execute();
           return $stmt;    
    }
    //custom unit table data
    function custom_unit_table_data(){
        $query = "SELECT
        unit_customise.token,
        unit_customise.customunit_name,
        units__shop_mapping.shop_token,
        COUNT(units__shop_mapping.shop_token) AS total_shops,
       
        GROUP_CONCAT(DISTINCT unit_customise_mapping.unit_token)as unit_token,
        GROUP_CONCAT(DISTINCT units.name) as unit_name
    FROM
        `unit_customise_mapping`
    INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = unit_customise_mapping.unit_token
    INNER JOIN unit_customise ON unit_customise.token = unit_customise_mapping.custom_unit_token
    INNER JOIN units ON units.token = unit_customise_mapping.unit_token
    WHERE 
    unit_customise.distributor_token = ? AND  units__shop_mapping.delete_status = 1  AND unit_customise_mapping.delete_status = 1
    GROUP BY
        unit_customise.token";
        $stmt = $this->conn->prepare($query);
        $stmt ->bindParam(1,$this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function custom_unit_table_data_list($fun){
        $arr=[];
    while ($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
        $obj1 = new stdClass();
        $obj1->unit_customise_token = $rows['token'];
        $obj1->customunit_name = $rows['customunit_name'];
        $obj1->shop_token = $rows['shop_token'];
        $obj1->total_shops = $rows['total_shops'];
        $obj1->unit_token = $rows['unit_token'];
        $obj1->unit_name = $rows['unit_name'];
        array_push($arr,$obj1);
    }
    return $arr;
    }

    // edit custom unit
    function edit_custom_unit(){
        $query = "SELECT
        unit_customise.token,
        unit_customise.customunit_name,
        unit_customise_mapping.unit_token,
         units.name as unit_name
    FROM
        `unit_customise_mapping`
    
    INNER JOIN unit_customise ON unit_customise.token = unit_customise_mapping.custom_unit_token
    INNER JOIN units ON units.token = unit_customise_mapping.unit_token
    WHERE
        unit_customise_mapping.delete_status = '1' AND unit_customise.token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->custom_token);
        $stmt->execute();
        return $stmt;
    }
    function edit_custom_unit_data($fun){
        $arr=[];
        while ($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass();
            $obj1->unit_customise_token = $rows['token'];
            $obj1->customunit_name = $rows['customunit_name'];
            $obj1->unit_token = $rows['unit_token'];
            $obj1->unit_name = $rows['unit_name'];
            array_push($arr,$obj1);
        }
        return $arr;
    }
    // update check 
    function update_select_unit(){
        $query = "SELECT * FROM unit_customise_mapping WHERE custom_unit_token = :unit_customise_token AND distributor_token = :distributor_token";
          $stmt=$this->conn->prepare($query);
          $stmt->bindParam(':unit_customise_token',$this->token);
          $stmt->bindParam(':distributor_token',$this->distributor_token);
          $stmt->execute();
          return $stmt;
    }
    function update_customiz_beat(){
                //echo $unit_token;
            // $edit_arr=$this->edit_arr;
            $token=$this->token;
            
            // $unit_tokens=[];
            // foreach($edit_arr as $unit_token){
                
                //array_push($arr_data,$edit_arr);
                // $integerIDs = array_map('intval', explode(',', $unit_token));
                 //$arr_data[]="('$unit_token')";
                //array_push($unit_tokens,$unit_token);
               
                //var_dump($integerIDs);
                
            //}
           //$data = implode(',',$edit_arr);
                 
        //    array_push($unit_tokens,$data);
        //     $integerIDs = explode(',',$edit_arr);
           //echo $edit_arr;
            //var_dump($unit_token);
           // array_flip(array_flip(implode(',', $beat_tokens)));
            //echo count($unit_token);
        //    // echo $unit_customise_token;
                  // $unoit=implode(',',$edit_arr);
        //     //echo count($edit_arr);
            //  $fields = '`' . implode(', ', $arr_data) . '`';
            //     echo $fields;
            $query="UPDATE unit_customise_mapping SET delete_status = '2' WHERE custom_unit_token = $token" ;
        // $query = "UPDATE `unit_customise_mapping` SET `unit_token` = '".implode(',',$arr_data)."' WHERE `custom_unit_token` = '".$unit_customise_token."'";
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            return $stmt;

    } 
        function update_customiz_beat_date($indiaDateTime){
           // $indiaDateTime = $this->indiaDateTime;
            $token=$this->token;
            $query="UPDATE unit_customise SET date_time = '$indiaDateTime' WHERE token = $token" ;
            $stmt = $this->conn->prepare($query); 
            $stmt->execute();
            return $stmt;
        } 
    function unit_name_check(){
        $query = "SELECT * FROM `units` WHERE token = ?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function unit_name_update(){
        $query = "UPDATE units SET name = ? WHERE token = ? ";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->edit_unit_name);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function selectedShop(){
        $query = "SELECT
        `shop`.`token`,
        `shop`.`name`,
        `shop`.`address`,
        `shop_mapping`.`token` AS uniq_token
    FROM
        `units__shop_mapping`
    INNER JOIN shop_mapping ON shop_mapping.token = units__shop_mapping.shop_token
    INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
    WHERE
        `units__shop_mapping`.`unit_group_token` = ? AND `units__shop_mapping`.delete_status = '1' AND `units__shop_mapping`.`distributor_token` = ?
    GROUP BY
        shop.token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readSelectedShop($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token      = $row['token'];
            $obj->uniq_token      = $row['uniq_token'];
            $obj->name       = $row['name'];
            $obj->address       = $row['address'];
            array_push($array, $obj);
        }
        return $array;
    }
    function readSelectedShopToken($stmt) {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($array, $row['uniq_token']);
        }
        return $array;
    }
    function removeShopUnit(){
        $query = "UPDATE `units__shop_mapping` 
        SET `delete_status`='2' 
        WHERE `unit_group_token`= ?";
        // AND `shop_token`=:shop_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        // $stmt->bindParam('shop_token', $this->removeToken);
        $stmt->execute();
        return $stmt;
    }
    function check_shop_mapping(){
        $query1 = "SELECT * FROM `shop_mapping` WHERE `distributor_token`=? and `unit_token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->distributor_token);
        $stmt1->bindParam(2, $this->token);
        $stmt1->execute();
        return $stmt1;
    }
    function check_unit_grouping(){
        $query1 = "SELECT * FROM `units__shop_mapping` WHERE unit_group_token = ? AND distributor_token = ? AND delete_status = '1' AND Active = '0'";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }
    function update_unit_grouping(){
        $query1 = "UPDATE `units__shop_mapping` SET Active = '1'  WHERE unit_group_token = ? AND distributor_token = ? AND delete_status = '1' AND Active = '0'";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }

    function remove_shop_unit_token(){
        $query1 = "UPDATE `shop_mapping` SET `unit_token`='' WHERE `unit_token`=? AND `distributor_token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }
    function update_shop_unit_token(){
        $query1 = "UPDATE `shop_mapping` SET `unit_token`=? WHERE `shop_token`=? AND `distributor_token`=?";
        $stmt1 = $this->conn->prepare( $query1 );
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->shopTokens);
        $stmt1->bindParam(3, $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }

    function deleteUnit(){
        // 1. Update units status to 0
        $query1 = "UPDATE `units` SET `status` = '0' WHERE `token` = ? AND `distributor_token` = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->distributor_token);
        $stmt1->execute();

        // 2. Remove from daily_schedule
        $query2 = "DELETE FROM `daily_schedule` WHERE `unit_token` = ? AND `distributor_token` = ?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->token);
        $stmt2->bindParam(2, $this->distributor_token);
        $stmt2->execute();

        // 3. Unlink shops from unit in shop_mapping
        $query3 = "UPDATE `shop_mapping` SET `unit_token` = '' WHERE `unit_token` = ? AND `distributor_token` = ?";
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->bindParam(1, $this->token);
        $stmt3->bindParam(2, $this->distributor_token);
        $stmt3->execute();

        // 4. Mark units__shop_mapping as deleted
        $query4 = "UPDATE `units__shop_mapping` SET `delete_status` = '2' WHERE `unit_group_token` = ? AND `distributor_token` = ?";
        $stmt4 = $this->conn->prepare($query4);
        $stmt4->bindParam(1, $this->token);
        $stmt4->bindParam(2, $this->distributor_token);
        $stmt4->execute();

        return true;
    }
    //Daily Schedule
    
    
    function salesEmployeeCheck(){
        $query = "SELECT `token`,
        `name` 
        FROM `employees` 
        WHERE `deparment_token`='45916684' 
        AND `admin_distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function deliveryEmployeeCheck(){
        $query = "SELECT `token`,
        `name` 
        FROM `employees` 
        WHERE `deparment_token`='93402780' 
        AND `admin_distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
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
        $query = "SELECT `id` FROM `daily_schedule` WHERE `unit_token`=? AND `schedule_date`=? AND `distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function checkSalesmanAssign(){
        $query = "SELECT `daily_schedule`.`unit_token`, `daily_schedule`.`distributor_token`, `schedule_date`, `units`.`name` AS `unit_name`,`sales_emp_token`,`employees`.`name` AS `employee_name`
        FROM `daily_schedule` 
        INNER JOIN `units__shop_mapping` ON `daily_schedule`.`distributor_token`=`units__shop_mapping`.`distributor_token`
        INNER JOIN `units` ON `daily_schedule`.`unit_token` = `units`.`token` 
        INNER JOIN `employees` ON `daily_schedule`.`sales_emp_token`=`employees`.`token`
        where `daily_schedule`.`distributor_token`=? AND `daily_schedule`.`schedule_date`=? AND `sales_emp_token`=? AND `daily_schedule`.`unit_token` != ? GROUP BY `daily_schedule`.`unit_token`";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->saleEmployee);
        $stmt->bindParam(4, $this->token);
        $stmt->execute();
        return $stmt; 
    }
    function checkDeliveryAssign(){
        $query1 = "SELECT `daily_schedule`.`unit_token`, `daily_schedule`.`distributor_token`, `schedule_date`, `units`.`name` AS `unit_name`, `delivery_emp_token`,`employees`.`name` AS `employee_name` 
        FROM `daily_schedule` 
        INNER JOIN `units__shop_mapping` ON `daily_schedule`.`distributor_token`=`units__shop_mapping`.`distributor_token`
        INNER JOIN `units` ON `daily_schedule`.`unit_token` = `units`.`token`
        INNER JOIN `employees` ON `daily_schedule`.`delivery_emp_token`=`employees`.`token`
        where `daily_schedule`.`distributor_token`= ? AND `daily_schedule`.`schedule_date`=? AND `delivery_emp_token`=? AND `daily_schedule`.`unit_token` != ? GROUP BY `daily_schedule`.`unit_token`";
        $stmt = $this->conn->prepare( $query1 );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->deliveryEmployee);
        $stmt->bindParam(4, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function insertDailySchedule($indiaDateTime){
        $query = "INSERT INTO `daily_schedule` SET `unit_token`=:unit_token,
        `distributor_token`=:distributor_token,
        `sales_emp_token`=:sales_emp_token,
        `delivery_emp_token`=:delivery_emp_token,
        `schedule_date`=:schedule_date,
        `date_time`='$indiaDateTime'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('unit_token', $this->token);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('sales_emp_token', $this->saleEmployee); 
        $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee);
        $stmt->bindParam('schedule_date', $this->day); 
        $stmt->execute();
        return $stmt;
    }
    function updateDailySchedule($indiaDateTime){
        $query = "UPDATE `daily_schedule` SET
        `sales_emp_token`=:sales_emp_token,
        `delivery_emp_token`=:delivery_emp_token,
        `date_time`='$indiaDateTime'
        WHERE `schedule_date`=:schedule_date 
        AND `unit_token`=:unit_token AND `distributor_token`=:distributor_token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('sales_emp_token', $this->saleEmployee);
        $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee); 
        $stmt->bindParam('schedule_date', $this->day);
        $stmt->bindParam('unit_token', $this->token); 
        $stmt->bindParam('distributor_token', $this->distributor_token); 
        $stmt->execute();
        return $stmt;
    }
    function custom_dailyScheduleCheck(){
        $query = "SELECT `id` FROM `custom_daily_schedule` WHERE `custom_unit_token`=? AND `schedule_date`=? AND `distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->custom_beat_token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
        function custom_sales_emp_check(){
            $query="SELECT
            `custom_daily_schedule`.`custom_unit_token`,
            `custom_daily_schedule`.`distributor_token`,
            `schedule_date`,
            `unit_customise`.customunit_name AS `custom_unit_name`,
            `sales_emp_token`,
            `employees`.`name` AS `employee_name`
        FROM
            `custom_daily_schedule`
        INNER JOIN `unit_customise_mapping` ON `custom_daily_schedule`.`distributor_token` = `unit_customise_mapping`.`distributor_token`
        INNER JOIN `unit_customise` ON `custom_daily_schedule`.`custom_unit_token` = `unit_customise`.`token`
        INNER JOIN `employees` ON `custom_daily_schedule`.`sales_emp_token` = `employees`.`token`
        WHERE
            `custom_daily_schedule`.`distributor_token` = ? AND `custom_daily_schedule`.`schedule_date` = ? AND `sales_emp_token` = ? AND `custom_daily_schedule`.`custom_unit_token` != ?
        GROUP BY
            `custom_daily_schedule`.`custom_unit_token`";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->distributor_token);
            $stmt->bindParam(2, $this->day);
            $stmt->bindParam(3, $this->saleEmployee);
            $stmt->bindParam(4, $this->custom_beat_token);
            $stmt->execute();
            return $stmt; 
        }

        function custom_delevery_emp_check(){
            $query1="SELECT
            `custom_daily_schedule`.`custom_unit_token`,
            `custom_daily_schedule`.`distributor_token`,
            `schedule_date`,
            `unit_customise`.customunit_name AS `custom_unit_name`,
            `delivery_emp_token`,
            `employees`.`name` AS `employee_name`
        FROM
            `custom_daily_schedule`
        INNER JOIN `unit_customise_mapping` ON `custom_daily_schedule`.`distributor_token` = `unit_customise_mapping`.`distributor_token`
        INNER JOIN `unit_customise` ON `custom_daily_schedule`.`custom_unit_token` = `unit_customise`.`token`
        INNER JOIN `employees` ON `custom_daily_schedule`.`delivery_emp_token` = `employees`.`token`
        WHERE
            `custom_daily_schedule`.`distributor_token` = ? AND `custom_daily_schedule`.`schedule_date` = ? AND `delivery_emp_token` = ? AND `custom_daily_schedule`.`custom_unit_token`!= ?
        GROUP BY
            `custom_daily_schedule`.`custom_unit_token`";
            $stmt = $this->conn->prepare($query1);
            $stmt->bindParam(1, $this->distributor_token);
            $stmt->bindParam(2, $this->day);
            $stmt->bindParam(3, $this->deliveryEmployee);
            $stmt->bindParam(4, $this->custom_beat_token);
            $stmt->execute();
            return $stmt; 
        }

        function insert_Custom_DailySchedule($indiaDateTime){
            $query = "INSERT INTO `custom_daily_schedule` SET `custom_unit_token`=:custom_beat_token,
            `distributor_token`=:distributor_token,
            `sales_emp_token`=:sales_emp_token,
            `delivery_emp_token`=:delivery_emp_token,
            `schedule_date`=:schedule_date,
            `date_time`='$indiaDateTime'";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam('custom_beat_token', $this->custom_beat_token);
            $stmt->bindParam('distributor_token', $this->distributor_token);
            $stmt->bindParam('sales_emp_token', $this->saleEmployee); 
            $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee);
            $stmt->bindParam('schedule_date', $this->day); 
            $stmt->execute();
            return $stmt;
        }
        function update_Custom_DailySchedule($indiaDateTime){
            $query = "UPDATE `custom_daily_schedule` SET
            `sales_emp_token`=:sales_emp_token,
            `delivery_emp_token`=:delivery_emp_token,
            `date_time`='$indiaDateTime'
            WHERE `schedule_date`=:schedule_date 
            AND `custom_unit_token`=:custom_beat_token AND `distributor_token`=:distributor_token";
            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam('sales_emp_token', $this->saleEmployee);
            $stmt->bindParam('delivery_emp_token', $this->deliveryEmployee); 
            $stmt->bindParam('schedule_date', $this->day);
            $stmt->bindParam('custom_beat_token', $this->custom_beat_token); 
            $stmt->bindParam('distributor_token', $this->distributor_token); 
            $stmt->execute();
            return $stmt;
        }

    function scheduledEmployeeCheck(){
        $query = "SELECT `sales_emp_token`,`delivery_emp_token` FROM `daily_schedule` WHERE `unit_token`=? AND `schedule_date`=? AND `distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readEmpToken($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->sales_emp_token   = $row['sales_emp_token'];
        $obj->delivery_emp_token= $row['delivery_emp_token'];
        return $obj;
    }
    function customize_unit_list(){
    $query = "SELECT * FROM `units` WHERE distributor_token =?";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1,$this->distributor_token);
    $stmt->execute();
    return $stmt;
    }
    function customize_unit_list_data($fun_call){
        $arr = [];
        while($row = $fun_call->fetch(PDO::FETCH_ASSOC)){
            $obj_arr = new stdClass();
            $obj_arr->beat_name = $row['name'];
            $obj_arr->beat_token = $row['token'];
            array_push($arr,$obj_arr);
        }
        return $arr;
    }
    //custom_hide_data
    // function scheduledEmployeeCheck(){
    //     $query = "SELECT `sales_emp_token`,`delivery_emp_token` FROM `daily_schedule` WHERE `unit_token`=? AND `schedule_date`=? AND `distributor_token`=?";
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->bindParam(1, $this->distributor_token);
    //     $stmt->execute();
    //     return $stmt;
    // }

    //custom_daily_beat_token_verify

    function custom_scheduledEmployeeCheck(){
        $query = "SELECT `sales_emp_token`,`delivery_emp_token` FROM `custom_daily_schedule` WHERE `custom_unit_token`=? AND `schedule_date`=? AND `distributor_token`=?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->custom_beat_token);
        $stmt->bindParam(2, $this->day);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function custom_readEmpToken($stmt) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->sales_emp_token   = $row['sales_emp_token'];
        $obj->delivery_emp_token= $row['delivery_emp_token'];
        return $obj;
    }

    function custom_beat_units_list(){
        $query ="SELECT
        unit_customise.token,
        unit_customise.customunit_name,
        unit_customise_mapping.unit_token,
        units.name,
        unit_customise.distributor_token,
        count(shop_mapping.shop_token) AS shop_count
    FROM
        unit_customise
    INNER JOIN unit_customise_mapping ON unit_customise.token = unit_customise_mapping.custom_unit_token
    INNER JOIN units ON unit_customise_mapping.unit_token = units.token 
    INNER JOIN shop_mapping ON shop_mapping.unit_token = units.token
    WHERE
        unit_customise_mapping.custom_unit_token = ? AND unit_customise_mapping.distributor_token = ? AND unit_customise_mapping.delete_status= '1'
        GROUP BY unit_customise_mapping.unit_token";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1,$this->custom_beat_token);
    $stmt->bindParam(2,$this->distributor_token);
    $stmt->execute();
    return $stmt;
    }
    function custom_beat_units_list_data($stmt1){
        $arr=[];
        while ($rows = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass();
            $arr_obj->customunit_name = $rows['customunit_name'];
            $arr_obj->beat_tokens = $rows['unit_token'];
            $arr_obj->beat_tokens = $rows['unit_token'];
            $arr_obj->beat_names = $rows['name'];
            $arr_obj->shop_count = $rows['shop_count'];
            array_push($arr,$arr_obj);
        }
        return $arr;
    }
    function get_shops(){
        $query = "SELECT
        shop.token,
        shop.name,
        shop.address
    FROM
        shop
    INNER JOIN `shop_mapping` ON shop.token = shop_mapping.shop_token
    WHERE
        shop_mapping.unit_token =?";
        $stmt3= $this->conn->prepare($query);
        $stmt3->bindParam(1,$this->unit_token);
        $stmt3->execute();
        return $stmt3;
    }
}
?>