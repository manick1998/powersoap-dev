<?php
class Offers{

    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function addOfferCheck(){
        $query = "SELECT `id` FROM `admin_offers` 
        WHERE `division_token`=:offerDivision AND `state_id`=:offerState
        AND `minimum_purchase_amount`=:minimum_purchase_amount AND `status`='1'";
        $stmt  = $this->conn->prepare( $query );
        $stmt->bindParam('offerDivision', $this->offerDivision);
        $stmt->bindParam('minimum_purchase_amount', $this->purchaseAmount);
        $stmt->bindParam('offerState', $this->offerState);
        $stmt->execute();
        return $stmt;
    }
    function addOffer($indiaDateTime){
        $query = "INSERT INTO `admin_offers` SET `token`=:token,
        `offer_name`=:offer_name,
        `state_id`=:offerState,
        `offer_percentage`=:offer_percentage,
        `division_token`=:division_token,
        `minimum_purchase_amount`=:minimum_purchase_amount,
        `created_date`='$indiaDateTime',
        `status`='1'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('offer_name', $this->offerName);
        $stmt->bindParam('offerState', $this->offerState);
        $stmt->bindParam('offer_percentage', $this->offerPercentage);
        $stmt->bindParam('division_token', $this->offerDivision);
        $stmt->bindParam('minimum_purchase_amount', $this->purchaseAmount);
        $stmt->execute();
        return $stmt;
    }
    function updateOffer($indiaDateTime){
    // 1. Replaced '$indiaDateTime' with a ? placeholder
    $query = "UPDATE `admin_offers` SET 
            `offer_name` = ?,
            `state_id` = ?,
            `offer_percentage` = ?,
            `division_token` = ?,
            `minimum_purchase_amount` = ?,
            `created_date` = ?,
            `status` = '1'
            WHERE `token` = ?";

    $stmt = $this->conn->prepare($query);
    
    // 2. Bound all 7 parameters sequentially
    $stmt->bindParam(1, $this->offerName);
    $stmt->bindParam(2, $this->offerState);
    $stmt->bindParam(3, $this->offerPercentage);
    $stmt->bindParam(4, $this->offerDivision);
    $stmt->bindParam(5, $this->purchaseAmount);
    $stmt->bindParam(6, $indiaDateTime); // Correctly bound to position 6
    $stmt->bindParam(7, $this->offer_token);          // Correctly bound to position 7
    $stmt->execute();
    // $stmt->debugDumpParams(); 
    return $stmt;
}

    //log offers
    function addOfferLog($indiaDateTime){
        $query = "INSERT INTO `offers_log` SET 
        `offer_name`=:offer_name,
        `state`=:offerState,
        `offer_percentage`=:offer_percentage,
        `division_token`=:division_token,
        `minimum_purchase_amount`=:minimum_purchase_amount,
        `created_by`=:admin_token,
        `date_time`='$indiaDateTime',
        `status`='1'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('offer_name', $this->offerName);
        $stmt->bindParam('offerState', $this->offerState);
        $stmt->bindParam('offer_percentage', $this->offerPercentage);
        $stmt->bindParam('division_token', $this->offerDivision);
        $stmt->bindParam('minimum_purchase_amount', $this->purchaseAmount);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    //delete log
    function deleteOfferLog($indiaDateTime){
        $query = "INSERT INTO `offers_log` SET 
        `offer_name`=:offer_name,
        `state`=:offerState,
        `offer_percentage`=:offer_percentage,
        `division_token`=:division_token,
        `minimum_purchase_amount`=:minimum_purchase_amount,
        `created_by`=:admin_token,
        `date_time`='$indiaDateTime',
        `status`='2'";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('offer_name', $this->offerName);
        $stmt->bindParam('offerState', $this->offerState);
        $stmt->bindParam('offer_percentage', $this->offerPercentage);
        $stmt->bindParam('division_token', $this->offerDivision);
        $stmt->bindParam('minimum_purchase_amount', $this->purchaseAmount);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    //offer details
    function offerDetails(){
        $query="SELECT
        `offer_name`,
        `offer_percentage`,
        `division_token`,
        `minimum_purchase_amount`,
        `state_id`
    FROM
        `admin_offers`
    WHERE
        `token` = ?";
       $stmt = $this->conn->prepare( $query );
       $stmt->bindParam(1, $this->token);
       $stmt->execute();
       return $stmt;
    }

    function readofferDetails($stmt){
        $data = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->offer_name = $row['offer_name'];
            $obj->offer_percentage = $row['offer_percentage'];
            $obj->division_token = $row['division_token'];
            $obj->minimum_purchase_amount = $row['minimum_purchase_amount'];
            $obj->state_id = $row['state_id'];
            array_push($data,$obj);
        }
        return $data;
    }

    function deleteOffer($indiaDateTime){
        $query = "UPDATE `admin_offers` SET 
        `status`='2',
        `deleted_datetime`='$indiaDateTime'
        WHERE `token`=:token";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    function tokenGenerate(){
        $random = rand(10000000,99999999);
        $val=true;
        do{
            $query = "SELECT `id` FROM `admin_offers` WHERE `token`=?";
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

    function offerCountCheck(){
        $query = "SELECT `admin_offers`.`id` 
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token`=`admin_offers`.`state_id`
        WHERE `admin_offers`.`status`='1'";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function serverOfferCheckfilter(){
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT `admin_offers`.`id` 
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token`=`admin_offers`.`state_id`
        WHERE `admin_offers`.`status`='1' $stateQuery
        $searchQuery";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function serverOfferCheck(){
        $rowStart        = $this->rowStart;
        $rowperpage      = $this->rowperpage;
        $searchQuery     = $this->searchQuery;
        $stateQuery      = $this->stateQuery;
        $columnName      = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `admin_offers`.`id`,
        `admin_offers`.`token`,
        `admin_offers`.`offer_name`,
        `employees__state`.`state_name`,
        `admin_offers`.`offer_percentage`,
        `admin_offers`.`division_token`,
        `admin_offers`.`state_id`,
        `admin_offers`.`minimum_purchase_amount`,
        `admin_offers`.`created_date`,
        `products__category`.`name` AS division
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token`=`admin_offers`.`state_id`
        WHERE `admin_offers`.`status`='1' $stateQuery
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function serverReadOffer($stmt) {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $safe_token      = htmlspecialchars($row['token'], ENT_QUOTES, 'UTF-8');
        $safe_name       = htmlspecialchars($row['offer_name'], ENT_QUOTES, 'UTF-8');
        $safe_state      = htmlspecialchars($row['state_name'], ENT_QUOTES, 'UTF-8');
        $safe_division   = htmlspecialchars($row['division'], ENT_QUOTES, 'UTF-8');
        $safe_percentage = htmlspecialchars($row['offer_percentage'], ENT_QUOTES, 'UTF-8');
        $safe_amount     = htmlspecialchars($row['minimum_purchase_amount'], ENT_QUOTES, 'UTF-8');
        $division_token = $row['division_token'];
         $state_id = $row['state_id'];
            $data[] = array(
                "token"  => $row['token'],
                "name"   => $row['offer_name'],
                "state_name" => $row['state_name'],
                "division"   => $row['division'],
                "offer"      => $row['offer_percentage']."%",
                "amount"     => "Rs. ".$row['minimum_purchase_amount'],
                "date"       => nl2br(date("d/m/Y",strtotime($row['created_date']))),
                "edit"       => '<a style="color:#11b8f4; cursor: pointer;" class="edite-off" ' .
                            'data-off_token="' . $safe_token . '" ' .
                            'data-off_name="' . $safe_name . '" ' .
                            'data-off_state_name="' . $safe_state . '" ' .
                            'data-off_division="' . $safe_division . '" ' .
                            'data-off_division_token="' . $division_token . '" ' .
                            'data-off_state_id="' . $state_id . '" ' .
                            'data-off_offer_percentage="' . $safe_percentage . '" ' .
                            'data-off_minimum_purchase_amount="' . $safe_amount . '">' .
                            'Edit</a>',
                "action"     => '<a class="delete-cls" style="color:red">Delete</a>'
            );
        }
        return $data;
    }

    //offer log
    function offerLog(){
        $query = "SELECT
        `offers_log`.`offer_name`,
        `offers_log`.`offer_percentage`,
        `employees__state`.`state_name`,
        `products__category`.`name`,
        `offers_log`.`minimum_purchase_amount`,
        `admin_login`.`name` as `loginName`,
        `offers_log`.`date_time`,
        `offers_log`.`status`
    FROM
        `offers_log`
    INNER JOIN `employees__state` ON `employees__state`.`state_token` = `offers_log`.`state`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `offers_log`.`created_by`
    INNER JOIN `products__category` ON `products__category`.`token` = `offers_log`.`division_token`
    ORDER BY `offers_log`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readofferLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->offer_name             = $row['offer_name'];
            $obj->offer_percentage       = $row['offer_percentage'];
            $obj->state_name             = $row['state_name'];
            $obj->division_name          = $row['name'];
            $obj->minimum_purchase_amount= $row['minimum_purchase_amount'];
            $obj->created_by             = $row['loginName'];
            $obj->date_time              = $row['date_time'];
            if($row['status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Active</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Deactive</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //sales rep Log
    function salesrepLog(){
        $query = "SELECT
        `employees`.`name`,
        `sales_repLog`.`old_mobile`,
        `sales_repLog`.`new_mobile`,
        `sales_repLog`.`old_name`,
        `sales_repLog`.`new_name`,
        `admin_login`.`name` AS `loginName`,
        `sales_repLog`.`date_time`,
        `sales_repLog`.`delete_status`
    FROM
        `sales_repLog`
    INNER JOIN `employees` ON `employees`.`token` = `sales_repLog`.`sales_rep__token`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `sales_repLog`.`created_by`
    ORDER BY `sales_repLog`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readsalesrepLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->name       = $row['name'];
            $obj->old_mobile = $row['old_mobile'];
            $obj->new_mobile = $row['new_mobile']==$row['old_mobile'] ? '-' : $row['new_mobile'];
            $obj->old_name   = $row['old_name'];
            $obj->new_name   = $row['new_name']==$row['old_name'] ? '-' : $row['new_name'];
            $obj->created_by = $row['loginName'];
            $obj->date_time  = $row['date_time'];
            if($row['delete_status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Active</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Deactive</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //product_log
    function productLog(){
        $query = "SELECT
        `product_log`.`old_productname`,
        `product_log`.`new_productname`,
        `product_log`.`old_item_code`,
        `product_log`.`new_item_code`,
        `product_log`.`old_net_weight`,
        `product_log`.`new_net_weight`,
        `product_log`.`old_mrp`,
        `product_log`.`new_mrp`,
        `product_log`.`old_total_cost`,
        `product_log`.`new_total_cost`,
        `product_log`.`old_piece_count`,
        `product_log`.`new_piece_count`,
        `admin_login`.`name` AS `loginName`,
        `product_log`.`date_time`,
        `product_log`.`delete_status`
    FROM
        `product_log`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `product_log`.`created_by`
    ORDER BY `product_log`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readproductLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->old_productname  = $row['old_productname'];
            $obj->new_productname  = $row['new_productname']==$row['old_productname'] ? '-' : $row['new_productname'];
            $obj->old_item_code    = $row['old_item_code'];
            $obj->new_item_code    = $row['new_item_code']==$row['old_item_code'] ? '-' : $row['new_item_code'];
            $obj->old_net_weight   = $row['old_net_weight'];
            $obj->new_net_weight   = $row['new_net_weight']==$row['old_net_weight'] ? '-' : $row['new_net_weight'];
            $obj->old_mrp          = $row['old_mrp'];
            $obj->new_mrp          = $row['new_mrp']==$row['old_mrp'] ? '-' : $row['new_mrp'];
            $obj->old_total_cost   = $row['old_total_cost'];
            $obj->new_total_cost   = $row['new_total_cost']==$row['old_total_cost'] ? '-' : $row['new_total_cost'];
            $obj->old_piece_count  = $row['old_piece_count'];
            $obj->new_piece_count  = $row['new_piece_count']==$row['old_piece_count'] ? '-' : $row['new_piece_count'];
            $obj->created_by       = $row['loginName'];
            $obj->date_time        = $row['date_time'];
            if($row['delete_status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Active</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Deactive</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //leaveLog
    function leaveLog(){
        $query = "SELECT
        `employees`.`name`,
        `admin_login`.`name` AS `loginName`,
        `leave_log`.`date_time`,
        `leave_log`.`status`
    FROM
        `leave_log`
    INNER JOIN `employees` ON `employees`.`token` = `leave_log`.`sales_rep__token`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `leave_log`.`status_updatedby`
    ORDER BY `leave_log`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readleaveLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->name       = $row['name'];
            $obj->created_by = $row['loginName'];
            $obj->date_time  = $row['date_time'];
            if($row['status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Approved</button>';
            } elseif($row['status']==='0'){
                $obj->status = '<button class="tb-btn bg-primary">Pending</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Rejected</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //divisionLog
    function divisionLog(){
        $query = "SELECT
        `products__category`.`name`,
        `division_log`.`before_division`,
        `division_log`.`after_division`,
        `admin_login`.`name` as `loginName`,
        `division_log`.`date_time`,
        `division_log`.`delete_status`
    FROM
        `division_log`
    INNER JOIN `products__category` ON `products__category`.`token` = `division_log`.`division_token`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `division_log`.`created_by`
    ORDER BY `division_log`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readdivisionLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->name            = $row['name'];
            $obj->before_division = $row['before_division'];
            $obj->after_division  = $row['after_division']==$row['before_division'] ? '-' : $row['after_division'];
            $obj->created_by      = $row['loginName'];
            $obj->date_time       = $row['date_time'];
            if($row['delete_status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Active</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Deactive</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //schedule Log
    function scheduleLog(){
        $query = "SELECT 
        COALESCE(`schedule_log`.`new_region_token`,0) AS `region_token`,
        `employees`.`name`,
        `employees`.`token`,
        DATE(`schedule_log`.`date_time`) AS `date`,
        `admin_login`.`name` AS `loginName`,
        `schedule_log`.`date_time`,
        `schedule_log`.`status`
    FROM
        `schedule_log`
    INNER JOIN `employees` ON `employees`.`token` = `schedule_log`.`sales_rep_token`
    LEFT JOIN `region` ON `region`.`token` = `schedule_log`.`new_region_token`
    INNER JOIN `admin_login` ON `admin_login`.`token` = `schedule_log`.`created_by`
    ORDER BY `schedule_log`.`id` DESC";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        return $stmt;
    }

    function readscheduleLog($stmt){
        $array=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->name           = $row['name'];
            $obj->region_token   = $row['region_token'];
            $obj->sales_rep_token= $row['token'];
            $obj->date           = $row['date'];
            $obj->created_by     = $row['loginName'];
            $obj->date_time      = $row['date_time'];
            if($row['status']==='1'){
                $obj->status = '<button class="tb-btn greenbtn">Active</button>';
            } else {
                $obj->status = '<button class="tb-btn red">Deactive</button>';
            }
            array_push($array,$obj);
        }
        return $array;
    }

    //selectareaValues
    function areaSelect(){
        $query = "SELECT `old_area_token` FROM `schedule_log` WHERE `sales_rep_token`=? AND date(date_time)=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $areaToken = $row['old_area_token'];
        return $areaToken;
    }

    function areaData($areaToken){
        $query = "SELECT `area_name` FROM `area` WHERE `area_token` IN ($areaToken)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $areaData = $row['area_name'];
            array_push($array,$areaData);
        }
        return $array;
    }

    //selectdistValues
    function distSelect(){
        $query = "SELECT `old_distributor_token` FROM `schedule_log` WHERE `sales_rep_token`=? AND date(date_time)=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $distToken = $row['old_distributor_token'];
        return $distToken;
    }

    function distData($distToken){
        $query = "SELECT `name` FROM `employees` WHERE `token` IN ($distToken)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $distData = $row['name'];
            array_push($array,$distData);
        }
        return $array;
    }

    //oldData schedule
    function scheduleold_data(){
        $query = "SELECT
        `employees__state`.`state_name`,
        `region`.`region_name`,
        `schedule_log`.`rep_schedule_token`
    FROM
        `employees__state`
    INNER JOIN `schedule_log` ON `employees__state`.`state_token` = `schedule_log`.`old_state_token`
    INNER JOIN `region` ON `region`.`token` = `schedule_log`.`old_region_token`
    WHERE
        `schedule_log`.`sales_rep_token` =? AND `schedule_log`.`status` = '1'
        AND date(`schedule_log`.`date_time`) =?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $obj1 = new StdClass();
            $obj1->rep_schedule_token = $row["rep_schedule_token"];
            $obj1->state_name         = $row["state_name"];
            $obj1->region_name        = $row["region_name"];
        }
        return $obj1;
    }

    //selectareaValues new
    function areanewSelect(){
        $query = "SELECT `new_area_token` FROM `schedule_log` WHERE `sales_rep_token`=? AND new_area_token!='' AND date(date_time)=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $areaNew = $row['new_area_token'];
        return $areaNew;
    }

    function areanewData($areanew){
        $query = "SELECT `area_name` FROM `area` WHERE `area_token` IN ($areanew)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array1=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $areanewData = $row['area_name'];
            array_push($array1,$areanewData);
        }
        return $array1;
    }

    //selectdistValues new
    function distnewSelect(){
        $query = "SELECT `new_distributor_token` FROM `schedule_log` WHERE `sales_rep_token`=? AND new_distributor_token!='' AND date(date_time)=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $distnewToken = $row['new_distributor_token'];
        return $distnewToken;
    }

    function distnewData($distnewToken){
        $query = "SELECT `name` FROM `employees` WHERE `token` IN ($distnewToken)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array=[];
        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $distnewData = $row['name'];
            array_push($array,$distnewData);
        }
        return $array;
    }

    //new data schedule
    function schedulenew_data(){
        $query = "SELECT
        `employees__state`.`state_name`,
        `region`.`region_name`,
        `schedule_log`.`rep_schedule_token`
    FROM
        `employees__state`
    INNER JOIN `schedule_log` ON `employees__state`.`state_token` = `schedule_log`.`new_state_token`
    INNER JOIN `region` ON `region`.`token` = `schedule_log`.`new_region_token`
    WHERE
        `schedule_log`.`sales_rep_token` =? AND `schedule_log`.`status` = '1'
        AND date(`schedule_log`.`date_time`) =?";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1,$this->salesReoToken);
        $stmt->bindParam(2,$this->date);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $obj1 = new StdClass();
            $obj1->rep_schedule_token = $row["rep_schedule_token"];
            $obj1->state_name         = $row["state_name"];
            $obj1->region_name        = $row["region_name"];
        }
        return $obj1;
    }

    // ═══════════════════════════════════════════════════════════════════════════
    // ORDER LOG — FULLY FIXED
    // Fix 1: LIMIT 2000 was cutting today's records → Now uses 60-day window
    //         with fallback to last 5000 rows via id range so today always shows
    // Fix 2: INNER JOIN was dropping Cancelled orders with NULL product/admin
    //         → All joins changed to LEFT JOIN with COALESCE for safe NULLs
    // Fix 3: ORDER BY date_time DESC on VARCHAR was unreliable
    //         → Changed to ORDER BY id DESC (integer, always reliable)
    // Fix 4: Delivery status 'Cancelled' was not handled
    //         → stripos('Cancel') catches all variants case-insensitively
    // ═══════════════════════════════════════════════════════════════════════════
    function orderLog(){
        $query = "SELECT
            `orders_log`.`id`,
            `orders_log`.`order_token`,
            COALESCE(`products`.`name`, '-')          AS `name`,
            COALESCE(`employees`.`name`, '-')         AS `distributor`,
            `orders_log`.`old_quantity`,
            `orders_log`.`new_quantity`,
            `orders_log`.`old_discount`,
            `orders_log`.`new_discount`,
            `orders_log`.`delete_status`,
            COALESCE(`orders_log`.`delivery`, '')     AS `delivery`,
            `orders_log`.`date_time`,
            COALESCE(`admin_login`.`name`, 'System')  AS `loginName`
        FROM
            `orders_log`
        LEFT JOIN `products`
            ON `products`.`token` = `orders_log`.`product_token`
        LEFT JOIN `employees`
            ON `employees`.`token` = `orders_log`.`distributor_token`
        LEFT JOIN `admin_login`
            ON `admin_login`.`token` = `orders_log`.`created_by`
        WHERE
            `orders_log`.`date_time` >= DATE_SUB(NOW(), INTERVAL 60 DAY)
            OR `orders_log`.`id` >= (
                SELECT COALESCE(MAX(id) - 4999, 0) FROM `orders_log`
            )
        ORDER BY
            `orders_log`.`id` DESC
        LIMIT 5000";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function readorderLog($stmt){
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();

            // ── Order Token ───────────────────────────────────────────────
            $obj->order_token = !empty($row['order_token'])
                ? $row['order_token']
                : '-';

            // ── Product Name (LEFT JOIN safe) ─────────────────────────────
            $obj->name = (!empty($row['name']) && $row['name'] !== '0')
                ? $row['name']
                : '-';

            // ── Distributor Name (LEFT JOIN safe) ─────────────────────────
            $obj->distributor_name = (!empty($row['distributor']) && $row['distributor'] !== '0')
                ? $row['distributor']
                : '-';

            // ── Old Quantity ──────────────────────────────────────────────
            $oldQty = $row['old_quantity'];
            $newQty = $row['new_quantity'];
            $obj->old_quantity = ($oldQty === null || $oldQty === '' || $oldQty == '0')
                ? '-'
                : $oldQty;

            // ── New Quantity ──────────────────────────────────────────────
            $obj->new_quantity = ($newQty === null || $newQty === '' || $newQty == '0' || $newQty == $oldQty)
                ? '-'
                : $newQty;

            // ── Old Discount ──────────────────────────────────────────────
            $oldDis = $row['old_discount'];
            $newDis = $row['new_discount'];
            $obj->old_discount = ($oldDis === null || $oldDis === '' || $oldDis == '0')
                ? '-'
                : $oldDis;

            // ── New Discount ──────────────────────────────────────────────
            $obj->new_discount = ($newDis === null || $newDis === '' || $newDis == '0' || $newDis == $oldDis)
                ? '-'
                : $newDis;

            // ── Created By (LEFT JOIN safe, system actions = 'System') ────
            $obj->created_by = !empty($row['loginName'])
                ? $row['loginName']
                : 'System';

            // ── Date Time ─────────────────────────────────────────────────
            $obj->date_time = !empty($row['date_time'])
                ? $row['date_time']
                : '-';

            // ── Active / Delete Status ────────────────────────────────────
            $obj->status = ($row['delete_status'] == '1')
                ? '<button class="tb-btn greenbtn">Active</button>'
                : '<button class="tb-btn red">Delete</button>';

            // ── Delivery Status ───────────────────────────────────────────
            // stripos used for case-insensitive matching
            // Handles: Completed, Approved, Pending, Cancelled, Cancel, etc.
            $delivery = trim((string)($row['delivery'] ?? ''));

            if (stripos($delivery, 'Complet') !== false) {
                $obj->delivery =
                    '<button style="margin-left:0px;margin-top:0px;"
                        class="tb-btn greenbtn status-widget">Completed</button>';

            } elseif (stripos($delivery, 'Approv') !== false) {
                $obj->delivery =
                    '<button style="margin-left:0px;margin-top:0px;"
                        class="tb-btn bg-primary status-widget">Approved</button>';

            } elseif (stripos($delivery, 'Pending') !== false) {
                $obj->delivery =
                    '<button style="margin-left:0px;margin-top:0px;"
                        class="tb-btn voliet status-widget">Pending</button>';

            } elseif (stripos($delivery, 'Cancel') !== false) {
                // Catches: Cancel / Cancelled / CANCELLED / cancelled
                $obj->delivery =
                    '<button style="margin-left:0px;margin-top:0px;"
                        class="tb-btn red status-widget">Cancelled</button>';

            } else {
                // Any other unknown or empty value
                $displayVal = ($delivery !== '')
                    ? htmlspecialchars($delivery)
                    : '-';
                $obj->delivery =
                    '<button style="margin-left:0px;margin-top:0px;"
                        class="tb-btn red status-widget">' . $displayVal . '</button>';
            }

            array_push($array, $obj);
        }
        return $array;
    }

}
?>
