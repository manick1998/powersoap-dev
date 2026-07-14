<?php
class home_page{
    public $conn ;
    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function retailer_order_home_page(){
        $query = "SELECT
        shop_mapping.distributor_token,
        employees.name AS distributor_name,
        employees.mobile_number AS distributor_ph_number,
        shop.token AS shop_token,
        shop.name AS shop_name,
        shop.mobile_number AS phone_number,
        COALESCE(
            ROUND(SUM(`orders`.`billing_amount`)),
            0
        ) AS `billing_amount`,
        COALESCE(
            ROUND(SUM(`orders`.`paid_amount`)),
            0
        ) AS `paid_amt`,
        COALESCE(
            ROUND(SUM(`orders`.`outstanding_amount`)),
            0
        ) AS `total_outstanding`,
        employees.address,
        employees.city,
        employees.pincode
    FROM
        shop
    INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token
    INNER JOIN employees ON employees.token = shop_mapping.distributor_token
    LEFT JOIN `orders` ON `orders`.`shop_token` = `shop_mapping`.`token` AND YEAR(orders.date_time) = YEAR(CURRENT_DATE()) AND MONTH(`orders`.`date_time`) = MONTH(CURRENT_DATE())
    LEFT JOIN shop__outstanding ON shop__outstanding.shop_token = shop_mapping.token
    WHERE
        shop.mobile_number = ? AND shop.shop_show_status = 'Active' AND  shop_mapping.status='1'
    GROUP BY
        employees.token";

        $stmt = $this->conn->prepare( $query );
        $stmt ->bindParam(1,$this->phone_number);
        $stmt->execute();
        return $stmt;
    }

    
}
?>