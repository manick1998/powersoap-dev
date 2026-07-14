<?php
class Offers{

    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function offerCountCheck(){
        $query = "SELECT `admin_offers`.`id` 
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token` = `admin_offers`.`division_token`
        WHERE `admin_offers`.`status`='1'AND `admin_offers`.`state_id`=? AND `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status` = 1";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->bindParam(1,$this->state_id);
        $stmt->execute();
        return $stmt;
    }
    function serverOfferCheckfilter(){
        $searchQuery = $this->searchQuery;
        $query = "SELECT `admin_offers`.`id` 
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token` = `admin_offers`.`division_token`
        WHERE `admin_offers`.`status`='1' AND `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status` = 1
        $searchQuery";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function serverOfferCheck(){
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `admin_offers`.`id`,
        `admin_offers`.`token`,
        `admin_offers`.`offer_name`,
        `admin_offers`.`offer_percentage`,
        `admin_offers`.`division_token`,
        `admin_offers`.`minimum_purchase_amount`,
        `admin_offers`.`created_date`,
        `products__category`.`name` AS division
        FROM `admin_offers`
        INNER JOIN `products__category` ON `products__category`.`token`=`admin_offers`.`division_token`
        INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token` = `admin_offers`.`division_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token`=`admin_offers`.`state_id`
        WHERE `admin_offers`.`status`='1' AND `admin_offers`.`state_id`=? AND `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status` = 1
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(1,$this->state_id);
        $stmt->execute();
        return $stmt;
    }
    function serverReadOffer($stmt) {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $data[] = array(
                "token"=>$row['token'],
                "name"=> $row['offer_name'],
                "division"=>$row['division'],
                "offer"=>$row['offer_percentage']."%",
                "amount"=>"Rs. ".$row['minimum_purchase_amount'] 
            );
        }
        // \n (h:i A)
        return $data;
    }
}
?>