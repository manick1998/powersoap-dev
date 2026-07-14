<?php
class retailer{
    //public $conn;
    public $mobile;
    public $order_token;
    public $shop_token;
    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }


function login(){
        $query = "SELECT
        COALESCE(`shop`.`token`,0) as `shop_token`,
        COALESCE(`shop`.`name`,0) as `shop_name`,
        COALESCE(`shop`.`mobile_number`,0) as `mobile_number`,
        COALESCE(`employees`.`token`,0) as `distributor_token`,
        COALESCE(`employees`.`name`,0) as `distributor_name`
    FROM
        `shop`
    INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.`token`
    INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` 
    WHERE
        `shop`.`mobile_number` = ?  AND `shop`.`shop_show_status`='Active'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->mobile);
        $stmt->execute();
        return $stmt;
    }

    function distributor_orders_details(){
        $query = "SELECT
        shop_mapping.distributor_token,
        employees.name AS distributor_name,
        employees.mobile_number AS distributor_ph_number,
        shop.token AS shop_token,
        shop.name AS shop_name,
        COALESCE(shop.mobile_number,0) as mobile_number,
        orders.items,
        orders.token AS orders_id,
        COALESCE(SUM(orders.billing_amount),
      0) AS bill_amt_val,
      COALESCE(SUM(orders.paid_amount),
      0) AS paid_amt_val,
      COALESCE(orders.outstanding_amount,0)AS outstanding_amount,
        orders.delivery,
        shop.address,
        orders.date_time AS schedule_date
    FROM
        shop
        INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token
    INNER JOIN employees ON shop_mapping.distributor_token = employees.token
    INNER JOIN orders ON shop.token = orders.shop_token
    INNER JOIN shop__outstanding ON shop.token = shop__outstanding.shop_token
    WHERE
        shop.mobile_number = ? AND shop_mapping.distributor_token = ?  AND shop.delete_status = 1
    GROUP BY
       orders.token
       ORDER BY
        orders.id
    DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->phone_number);
        $stmt->bindParam(2,$this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function order_product_details(){
        $query = "SELECT
        shop.name,
        orders.token,
        orders.items,
        orders__items.product_token,
        orders__items.quantity,
        orders__items.units,
        orders__items.misc_price AS gst,
        orders__items.price_per_unit,
        orders__items.is_discount_enable,
        orders__items.discount_value,
        orders__items.is_free,
        products.name AS product_name,
        orders.date_time AS schedule_date,
        orders.delivery,
        COALESCE(SUM(orders.billing_amount),
      0) AS bill_amt_val,
      COALESCE(orders.paid_amount,
      0) AS paid_amt_val,
      COALESCE(shop__outstanding.total_outstanding,0)AS outstanding_amount,
        COALESCE(employees.name,0) as employee_name,
        orders.delivered_on,
        (
            CASE WHEN orders__items.units = 'Nos' THEN orders__items.quantity * orders__items.price_per_unit ELSE orders__items.quantity * orders__items.price_per_unit * orders__items.piece_count
        END
    ) AS amount,
        SUM(
            CASE WHEN orders__items.units = 'Box' THEN(
                orders__items.quantity * products.piece_count
            ) ELSE orders__items.quantity
        END
    ) AS qty
    FROM
        orders
       
    INNER JOIN orders__items ON orders__items.order_token = orders.token
    INNER JOIN products ON orders__items.product_token = products.token
    INNER JOIN shop ON shop.token = orders.shop_token
    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = shop.token
    left JOIN employees ON employees.token=orders.delivery_emp_token
    WHERE
        orders.token = ? AND `orders__items`.`delete_status` = 1
        GROUP BY
        `orders__items`.`id`";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->order_token);
        $stmt->execute();
        return $stmt;
    }

    function  total_payment_details(){
        $query = "SELECT
        orders.token,
        COALESCE(SUM(orders.billing_amount),0)as billing_amount,
        COALESCE(orders.paid_amount,0)as paid_amount,
        COALESCE(orders.outstanding_amount,0) as total_outstanding
        
    FROM
        `shop`
    INNER JOIN orders ON orders.shop_token = shop.token
    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = shop.token
    WHERE
        orders.token = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->order_token);
        $stmt->execute();
        return $stmt;
    }
    function payment_details($order_token){
        $query= "SELECT date_time,COALESCE(payment_mode,0)as payment_mode,COALESCE(amount,0)as amount FROM shop__order_transaction  WHERE order_token = $order_token";
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(1,$this->order_token);
        $stmt->execute();
        return $stmt;

    }
    function orderval(){
        $query="SELECT `token` FROM orders  WHERE  `shop_token` = ? ORDER BY id DESC LIMIT 1";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(1,$this->shop_token);
        $stmt->execute();
        return $stmt;
    }
    function previousOrderList(){
        $query ="SELECT
        orders__items.product_token,
        products.name AS product_name,
        orders__items.quantity,
        orders__items.units,
        orders__items.piece_count,
        (
            CASE WHEN orders__items.units = 'Nos' THEN orders__items.quantity * orders__items.price_per_unit ELSE orders__items.quantity * orders__items.price_per_unit * orders__items.piece_count
        END
    ) AS amount
    FROM
        `orders`
    INNER JOIN orders__items ON orders__items.order_token = orders.token AND orders__items.is_free = 0 AND orders__items.delete_status = 1
    INNER JOIN products ON products.token = orders__items.product_token
    WHERE
        orders.token = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(1,$this->order_token);
        $stmt->execute();
        return $stmt;
    }
    function orderTotal(){
        $query="SELECT
        SUM(
            orders__items.quantity * orders__items.price_per_unit
        ) AS total_amount,
        orders.token AS order_token,
        SUM(orders__items.quantity) AS quantity
    FROM
        `orders`
    INNER JOIN orders__items ON orders__items.order_token = orders.token
    INNER JOIN products ON products.token = orders__items.product_token
    WHERE
        orders.token = ?";
        $stmt=$this->conn->prepare($query);
        $stmt->bindParam(1,$this->order_token);
        $stmt->execute();
        return $stmt;

    }
    function productList(){
        $query="SELECT
        products.`token`,
        products.`category_token`,
        products.`piece_count`,
        products.`item_code`,
        products.`name`,
        products.`image`,
        products.`total_cost`,
        products.`gst`,
        products.`batch_number`,
        products.`net_weight`,
        COALESCE(products__scheme.scheme_name, 0) AS additional_offer,
        COALESCE(products__scheme.`limit_box`, 0) AS limit_box,
        COALESCE(products__scheme.`free_box`, 0) AS free_box,
        COALESCE(products__scheme.`is_scheme`, 0) AS is_scheme,
        products.retailer_price,
        products__category.name AS pro_cat,
        COALESCE(
            stock__distributor.stock_in_hand,
            0
        ) AS stock_in_hand
    FROM
        `products`
    INNER JOIN products__category ON products__category.token = products.category_token
    LEFT JOIN products__scheme ON products__scheme.product_token = products.token AND products__scheme.is_scheme = '1'
    INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
    LEFT JOIN stock__distributor ON(
            stock__distributor.product_token = products.token AND stock__distributor.employee_token = employees__division_mapping.employee_token
        )
    WHERE
        employees__division_mapping.employee_token = ? AND employees__division_mapping.delete_status = '1' AND ((`products`.`delete_status`='2' AND `stock__distributor`.`stock_in_hand` > '0') ||  `products`.`delete_status`='1')
    GROUP BY
        products.token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->distributor_token);
        $stmt->execute();
        return $stmt;

    }

}
?>