<?php

class StockOrder
{
    public $products_token;
    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    function getDistributorStock()
    {
        $query = "SELECT `products`.`token` AS `product_token`,
     `products`.`item_code`,
     `products`.`name` AS `product_name`,
     `products`.`piece_count`,
     `products__category`.`name` AS `product_category`,
     `products__category`.`token` AS `product_category_token`,
     `products`.`total_cost`,
     `products`.`retailer_price`,
     `orders__items`.`units`,
     `stock__distributor`.`mfs`,
     `stock__distributor`.`aog`,
     `stock__distributor`.`stock_in_hand`,
     `stock__distributor`.`sold_pieces`,
     `stock__distributor`.`monthly_avg`
    FROM  `products` 
    LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
    INNER JOIN `orders__items` ON `orders__items`.`product_token`=`products`.`token`
    LEFT JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token`=`products__category`.`token`
    LEFT JOIN `stock__distributor` ON (`stock__distributor`.`employee_token`=`employees__division_mapping`.`employee_token` AND `stock__distributor`.`product_token`= `products`.`token`)
    WHERE `employees__division_mapping`.`employee_token` = ? AND `employees__division_mapping`.`delete_status`=1 AND ((`products`.`delete_status`='2' AND `stock__distributor`.`stock_in_hand` > '0') ||  `products`.`delete_status`='1') GROUP BY `products`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewGetDistributorStock($stmts)
    {
        $array = [];
        while ($row = $stmts->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $pice = $row['piece_count'];
            $stock = $row['stock_in_hand'];
            $sold_pieces = $row['sold_pieces'];

            $total_stock = $stock * $pice - $sold_pieces;
            // if($row['units'] ==='Box'){
            // $total_stock =  $stock-$pice;
            // }else{
            //     $total_stock=$stock;
            // }
            $obj->item_code = $row['item_code'];
            $obj->units = $row['units'];
            $obj->product_token = $row['product_token'];
            $obj->product_name = $row['product_name'];
            $obj->product_category = $row['product_category'];
            $obj->retailer_price = $row['retailer_price'];
            $obj->stock_in_hand = $total_stock == '' ? '0' : $total_stock;
            $obj->monthly_avg = $row['monthly_avg'] == '' ? '0' : $row['monthly_avg'];
            $obj->mfs = $row['mfs'] == '' ? '0' : $row['mfs'];
            $obj->aog = $row['aog'] == '' ? '0' : $row['aog'];
            array_push($array, $obj);
        }
        return $array;
    }

    function getDistributorProductDetail()
    {
        $query = "SELECT 
  `products`.`item_code`,
  `products`.`name` AS `product_name`, 
  `products`.`image`,
  `products`.`mrp`,
  `products`.`hsn_code`,
  `products`.`gst`,
  `products`.`total_cost`,
  `products`.`batch_number`,
  `products`.`net_weight`,
  `products`.`location`,
  `products`.`manufacturer`,
  `products`.`origin`,
  `products`.`piece_count`,
  `products__category`.`name` AS product_category_name,
  `products`.`description`, 
  `products`.`additional_offer` 
  FROM `products` 
  LEFT JOIN `products__category` ON  `products__category`.`token` = `products`.`category_token`
  where `products`.`token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->product_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewGetDistributorProductDetail($stmtView)
    {
        $row = $stmtView->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->item_code = $row['item_code'];
        $obj->product_name = $row['product_name'];
        $obj->image = $row['image'];
        $obj->mrp = $row['mrp'];
        $obj->gst = $row['gst'];
        $obj->hsn_code = $row['hsn_code'];
        $obj->total_cost = $row['total_cost'];
        $obj->batch_number = $row['batch_number'];
        $obj->net_weight = $row['net_weight'];
        $obj->location = $row['location'];
        $obj->manufacturer = $row['manufacturer'];
        $obj->origin = $row['origin'];
        $obj->product_token = $this->product_token;
        $obj->piece_count = $row['piece_count'];
        $obj->product_category = $row['product_category_name'];
        $obj->description = $row['description'];
        $obj->additional_offer = $row['additional_offer'];
        $obj->transporter = 'Power Soap';
        return $obj;
    }

    function stockOrderDistributor()
    {
        $query = "SELECT `token`, `order_number`, `date_time`, `items`, `billing_amount`, `delivery`, `delivered_on`, `approved_on` FROM `orders` WHERE `employee_token` = ? AND `order_type`='Distributor Order'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewstockOrderDistributor($stmts1)
    {
        $array = [];
        while ($row = $stmts1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->order_id = $row['token'];
            $obj->order_number = $row['order_number'];
            $obj->order_date_time =  nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time'])));
            $obj->items = $row['items'];
            $obj->amount = round($row['billing_amount']);
            $obj->order_status = $row['delivery'];
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $obj->delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $obj->delivered_on   = "-";
            }
            if ($row['approved_on'] != null && $row['approved_on'] != "0000-00-00 00:00:00") {
                $obj->approved_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['approved_on'])));
            } else {
                $obj->approved_on   = "-";
            }
            array_push($array, $obj);
        }
        return $array;
    }

    function stockOrderDetail()
    {
        $query1 = "SELECT 
    DISTINCT `orders`.`token`,
    `orders`.`order_number`,
    `orders`.`delivery`, 
    `orders`.`date_time`, 
    `orders`.`items`, 
    `orders__items`.`misc_price`, 
    `orders`.`billing_amount`,
    `orders`.`gst`,
    `orders`.`paid_amount`, 
    `orders`.`delivered_on`,
    `orders`.`invoice_name`
    FROM `orders` 
    LEFT JOIN `orders__items` ON `orders`.`token` = `orders__items`.`order_token` 
    WHERE `orders`.`token`=?";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->order_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewStockOrderDetail($stmt, $invoicepath)
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->order_id = $row['token'];
        $obj->order_number = $row['order_number'];
        $obj->product_token = $row['product_token'];
        $obj->items = $row['items'];
        $obj->billing_amount = round($row['billing_amount']);
        $totalGst = isset($row['gst']) ? $row['gst'] : 0;
        $obj->gst = number_format($totalGst, 2, '.', '');
        $obj->amount = number_format($row['billing_amount'] - $totalGst, 2, '.', '');
        $obj->order_status = $row['delivery'];
        $obj->paid_amount = $row['paid_amount'];
        $obj->delivered_on = $row['delivered_on'];
        $obj->order_date_time = date("d/m/Y (h:i A)", strtotime($row['date_time']));
        $obj->invoice_strtotime = strtotime($row['date_time']);
        if ($row['invoice_name'] == "") {
            $obj->invoice_url    = "";
        } else {
            $obj->invoice_url    = $invoicepath  . $row['invoice_name'];
        }
        return $obj;
    }

    function stockOrderProductList()
    {
        $query1 = "SELECT 
    `products`.`item_code`, 
    `products`.`name`, 
    `orders__items`.`quantity`, 
    `orders__items`.`offer_amount`, 
    `orders__items`.`units`,
    `orders__items`.`is_free`,
    `orders__items`.`offer_percentage`,
    `orders__items`.`price_per_unit`*`orders__items`.`piece_count` AS `box_price`
    FROM `orders__items` 
    LEFT JOIN `products` ON `orders__items`.`product_token` = `products`.`token` 
    WHERE `orders__items`.`order_token`=? AND `orders__items`.`delete_status`='1' ORDER BY `products`.`name`, `orders__items`.`is_free` ASC";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->order_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewStockOrderProductList($stmts)
    {
        $array = [];
        while ($row = $stmts->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_code = $row['item_code'];
            $obj->product_name = $row['name'];
            $obj->quantity = $row['quantity'];
            //$obj->amount = number_format($row['offer_amount'], 2, '.', '');
            $obj->amount = round($row['offer_amount'], 2);
            $obj->units = $row['units'];
            $obj->is_free = $row['is_free'];
            $obj->offer_percentage = $row['offer_percentage'];
            $obj->box_price = number_format($row['box_price'], 2, '.', '');
            array_push($array, $obj);
        }
        return $array;
    }

    function orderProductList()
    {
        $query1 = "SELECT `products`.`token` AS `product_token`,
     `products`.`item_code`,
     `products`.`image`,
     `products`.`name`,
     `products`.`piece_count`,
     `products__category`.`name` AS `product_category_name`,
     `products__category`.`token` AS `product_category_token`,
     `products`.`total_cost`,
     `stock__distributor`.`mfs`,
     `products__scheme`.`scheme_name`,
     `products__scheme`.`limit_box`
    FROM  `products` 
    LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
    LEFT JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token`=`products__category`.`token`
    LEFT JOIN `stock__distributor` ON (`stock__distributor`.`employee_token`=`employees__division_mapping`.`employee_token` AND `stock__distributor`.`product_token`= `products`.`token`)
    LEFT JOIN `products__scheme` on `products`.`token` = `products__scheme`.`product_token` AND `products__scheme`.`is_scheme`='1'
    WHERE `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status`=1 AND `products`.`delete_status` = 1 group by products.token order by products__category.token";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function  vieworderProductList($stmts1)
    {
        $array = [];
        while ($row = $stmts1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_code = $row['item_code'];
            $obj->product_token = $row['product_token'];
            $obj->product_image = $row['image'];
            $obj->product_name = $row['name'];
            $obj->piece_count = $row['piece_count'];
            $obj->product_category_name = $row['product_category_name'];
            $obj->product_category_token = $row['product_category_token'];
            $obj->total_cost = $row['total_cost'];
            $obj->mfs = $row['mfs'] == '' ? '0' : $row['mfs'];
            $obj->scheme_name = $row['scheme_name'] == null ? '' : $row['scheme_name'];
            $obj->limit_box = $row['limit_box'];
            array_push($array, $obj);
        }
        return $array;
    }

    function productDetail()
    {
        $query = "SELECT `products`.`category_token`, `products`.`token` AS `product_token`, `products`.`item_code`, `products`.`name` AS `product_name`, `products`.`image`, `products`.`mrp`, `products`.`gst`, `products`.`total_cost`, `products`.`batch_number`, `products`.`net_weight`, `products`.`location`, `products`.`description`, `products`.`manufacturer`, `products`.`origin`, `products__category`.`name` AS `product_category_name`, `stock__distributor`.`stock_in_hand`, `stock__distributor`.`mfs`
  FROM `products` 
  LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
  LEFT JOIN `stock__distributor` ON `products`.`token` = `stock__distributor`.`product_token` where `products`.`token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->product_token);
        $stmt->execute();
        return $stmt;
    }

    function  viewProductDetail($stmtView1)
    {
        $row = $stmtView1->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->category_token = $row['category_token'];
        $obj->product_token = $row['product_token'];
        $obj->item_code = $row['item_code'];
        $obj->product_name = $row['product_name'];
        $obj->image = $row['image'];
        $obj->mrp = $row['mrp'];
        $obj->gst = $row['gst'];
        $obj->total_cost = $row['total_cost'];
        $obj->batch_number = $row['batch_number'];
        $obj->net_weight = $row['net_weight'];
        $obj->location = $row['location'];
        $obj->manufacturer = $row['manufacturer'];
        $obj->origin = $row['origin'];
        $obj->product_category_name = $row['product_category_name'];
        $obj->transporter = 'Power Soap';
        $obj->stock_in_hand = $row['stock_in_hand'];
        $obj->description = $row['description'];
        $obj->mfs = $row['mfs'];
        return $obj;
    }

    function deleteStockOrderList()
    {
        $query = "DELETE FROM `dist__stock_order` WHERE `order_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->order_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function stockOrderDateRange()
    {
        $query = "SELECT `token`, `order_number`, `date_time`, `items`, `billing_amount`, `delivery` FROM `orders` WHERE `date_time` BETWEEN ? AND ? AND `employee_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->fromDate);
        $stmt->bindParam(2, $this->toDate);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    //take order
    function takeOrderDistributor()
    {
        $query = "SELECT 
    `products`.`image` AS `product_image`,
    `products`.`token` AS `product_token`,
     `products`.`item_code`,
     `products`.`name`,
     `products`.`retailer_price`,
     `products`.`piece_count`,
     `products`.`mrp`,
     `products__category`.`name`AS `division`,

    --  `products__scheme`.`scheme_name`,
    --  `products__scheme`.`limit_box`,
     products__category.token
    FROM  `products`
    LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
    LEFT JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token`=`products__category`.`token`
    LEFT JOIN `shop_mapping` ON `shop_mapping`.`distributor_token`=`employees__division_mapping`.`employee_token`
    LEFT JOIN shop ON shop.token = shop_mapping.shop_token
    -- LEFT JOIN `products__scheme` on `products`.`token` = `products__scheme`.`product_token` AND `products__scheme`.`is_scheme`='1'
    WHERE `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status`=1 AND `products`.`delete_status` = 1 AND `shop`.`shop_show_status`='Active' AND `shop`.`token`=? group by products.token
     order by products__category.token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }

    function viewtakeOrderDistributor($stmt)
    {
        $array = [];
        $array1 = [];
        $query = "SELECT `percentage` FROM `discount` WHERE `status`='0' order by `percentage` asc";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->execute();

        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->percentage = $row1['percentage'];
            array_push($array1, $obj1);
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->product_image = $row['product_image'];
            $obj->product_token = $row['product_token'];
            $obj->item_code = $row['item_code'];
            $obj->name = $row['name'];
            $obj->division = $row['division'];
            $obj->total_cost = $row['retailer_price'];
            $obj->piece_count = $row['piece_count'];
            $obj->mrp = $row['mrp'];
            $obj->scheme_name =  $row['scheme_name'] == null ? '' : $row['scheme_name'];
            $obj->limit_box = $row['limit_box'];
            array_push($array, $obj);
        }

        return ['array' => $array, 'array1' => $array1];
    }

    //product amount count
    function product_amoun_count()
    {
        $query = "SELECT products.name,products.total_cost * products.piece_count AS totel FROM `products` 
    INNER JOIN stock__distributor  ON products.token =stock__distributor.product_token
    WHERE products.token =? AND stock__distributor.employee_token =?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->products_token);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function update_pre_stock()
    {
        $query = "UPDATE
    stock__distributor
SET
    stock__distributor.stock_in_hand = stock_in_hand + ?
WHERE
    stock__distributor.employee_token = ? AND stock__distributor.product_token = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->stock_count);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->bindParam(3, $this->product_token);
        $stmt->execute();
        return $stmt;
    }
}
