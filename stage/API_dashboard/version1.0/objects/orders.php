<?php

class OrderList
{

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function indianNumbeFormat($num)
    {
        return $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
    }
    function orderCheckCount()
    {
        $query = "SELECT `orders`.`id`
        FROM `orders`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`order_type`=? AND `employees`.`admin_distributor_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckCountSal()
    {
        $query = "SELECT COUNT(`orders`.`id`)
        FROM `orders`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`order_type`=? AND `orders`.`distributor_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    function orderCheckCountRetailer()
    {
        $query = "SELECT `orders`.`id`
        FROM `orders`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`order_type`=? AND `orders`.`distributor_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckFilterSal()
    {
        $dateQuery   = $this->dateQuery;
        $query = "SELECT COUNT(`orders`.`id`)
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `orders`.`distributor_token`=?
        $dateQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function orderCheckFilterRetailer()
    {
        $dateQuery   = $this->dateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `orders`.`distributor_token`=?
        $dateQuery 
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function orderCheckFilter()
    {
        $dateQuery   = $this->dateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `employees`.`admin_distributor_token`=?
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function orderCheckSearchSal()
    {
        $searchQuery   = $this->searchQuery;
        $query = "SELECT  COUNT(`orders`.`id`)
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `orders`.`distributor_token`=?
        $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function orderCheckSearchRetailer()
    {
        $searchQuery   = $this->searchQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `orders`.`distributor_token`=?
        $searchQuery 
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function orderCheckSearch()
    {
        $searchQuery   = $this->searchQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.order_type=? AND `employees`.`admin_distributor_token`=?
        $searchQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function serverOrderCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `shop`.`token` AS `shop_token`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`,
        `orders`.`outstanding_amount`,
        `orders`.`billing_amount`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE 1
        $searchQuery
        $dateQuery
        AND `orders`.order_type=? AND `employees`.`admin_distributor_token`=?
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderType);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function serverReadOrder($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            $outstanding = round($row["billing_amount"] - $row["paid_amount"]);

            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $row['sales_man'],
                "items" => $row['items'],
                "paid_amount" => $row['paid_amount'],
                "outstanding_amount" => '<span style="color:red !important;">' . $outstanding . '</span>',
                "delivery" => $delivery,
                "delivered_on" => $delivered_on
            );
        }
        return $data;
    }

    function serverOrderCheckNew()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT
        `sr`.`name` AS `salesman`,
        `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `salesman`.`name` AS `sales_man_name`,
        `distributor`.`name` AS `distributor_name`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`billing_amount`,
        `orders`.`paid_amount`,
        `orders`.`outstanding_amount`,
        `orders`.`is_slaes_rep_admin`,
        `orders`.`sales_rep_token`,
        `orders`.delivery_emp_token AS order_give,
        `orders`.`employee_token`,
        `orders`.`distributor_token`
        FROM
        `shop`
        INNER JOIN `shop_mapping` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `orders` ON `shop_mapping`.`token` = `orders`.`shop_token`
        RIGHT  JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` 
        INNER JOIN employees sr on sr.token = orders.employee_token 
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token`=`salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        WHERE 1
        $searchQuery
        $dateQuery  AND `orders`.`distributor_token`=?
        AND `orders`.order_type=? GROUP BY
        orders.token
        ORDER BY $columnName $columnSortOrder, `orders`.`is_slaes_rep_admin` DESC
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->orderType);
        $stmt->execute();
        return $stmt;
    }

    function serverReadOrderNew($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet" id="statusbtn" data-toggle="modal" data-target="#status-view"  data-token="' . $row['token'] . '">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            // if($row["is_slaes_rep_admin"] == 1){
            //     $sales_name = "Power Soap Sales Rep";
            // }else{
            //     $employee_token = $row['employee_token'];
            //     $distributor_token = $row['distributor_token'];
            //     $sales_name = $employee_token==$distributor_token ? $row['shop_name'] : $row["salesman"];
            // }
            if ($row['is_slaes_rep_admin'] == '1') {
                $query20 = "SELECT `name` AS `salesRepName` FROM `employees` WHERE `token`=" . $row['sales_rep_token'];
                $stmt20 = $this->conn->prepare($query20);
                $stmt20->execute();
                $row20 = $stmt20->fetch(PDO::FETCH_ASSOC);
                $sales_rep = $row20["salesRepName"];
                $query21 = "SELECT `name` AS `dist_name` FROM `employees` WHERE `token`=" . $row['distributor_token'];
                $stmt21 = $this->conn->prepare($query21);
                $stmt21->execute();
                $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
                $distributor_name = $row21["dist_name"];
            } else {
                $sales_rep = $row["sales_man_name"];
                $distributor_name = $row["distributor_name"];
            }
            $outstanding = round($row["billing_amount"] - $row["paid_amount"]);
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                $shop = $row['shop_name'],
                // $s_sales_name =  $row['order_give']=='0'? $shop :$sales_name,
                //"sales_man"=>$s_sales_name,
                "sales_man" => $sales_rep,
                "items" => $row['items'],
                "paid_amount" => $this->indianNumbeFormat($row['paid_amount']),
                "outstanding_amount" => '<span style="color:red !important;" id="outAmt">' . $this->indianNumbeFormat($outstanding) . '</span>',
                "delivery" => $delivery,
                "delivered_on" => $delivered_on
            );
        }
        return $data;
    }

    //retailer order
    function serverOrderCheckNewRetailer()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT
        `sr`.`name` AS `salesman`,
        `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`billing_amount`,
        `orders`.`paid_amount`,
        `orders`.`outstanding_amount`,
        `orders`.`is_slaes_rep_admin`,
        `orders`.delivery_emp_token AS order_give,
        `orders`.`employee_token`,
        `orders`.`distributor_token`
        FROM
        `shop`
        INNER JOIN `shop_mapping` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `orders` ON `shop_mapping`.`token` = `orders`.`shop_token`
        RIGHT  JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` 
        INNER JOIN employees sr on sr.token = orders.employee_token 
        WHERE 1
        $searchQuery
        $dateQuery  AND `orders`.`distributor_token`=?
        AND `orders`.order_type=? GROUP BY
        orders.token
        ORDER BY $columnName $columnSortOrder, `orders`.`is_slaes_rep_admin` DESC
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->orderType);
        $stmt->execute();
        return $stmt;
    }
    function serverReadOrderNewRetailer($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }
            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }
            if ($row["is_slaes_rep_admin"] == 1) {
                $sales_name = "Power Soap Sales Rep";
            } else {
                $employee_token = $row['employee_token'];
                $distributor_token = $row['distributor_token'];
                $sales_name = $employee_token == $distributor_token ? $row['shop_name'] : $row["salesman"];
            }
            $outstanding = round($row["billing_amount"] - $row["paid_amount"]);
            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                $shop = $row['shop_name'],
                $s_sales_name =  $row['order_give'] == '0' ? $shop : $sales_name,
                "sales_man" => $s_sales_name,
                "items" => $row['items'],
                "paid_amount" => $this->indianNumbeFormat($row['paid_amount']),
                "outstanding_amount" => '<span style="color:red !important;" id="outAmt">' . $this->indianNumbeFormat($outstanding) . '</span>',
                "delivery" => $delivery,
                "delivered_on" => $delivered_on
            );
        }
        return $data;
    }

    function individualShopDetail()
    {
        $query1 = "SELECT 
            `orders`.`token`, 
            `orders`.`date_time`, 
            `shop`.`name` AS `shop_name`, 
            `employees`.`name` AS `employee_name`, 
            `employees`.`token` AS `employee_token`, 
            `orders`.`items`, 
            `orders`.`billing_amount`, 
            `orders`.`bill_discount_amount`, 
            `orders`.`bill_discount_percentage`, 
            `orders`.`paid_amount`, 
            `orders`.`delivery`, 
            `orders`.`delivered_on`,
            `orders`.`invoice_name`,
            `shop_mapping`.`token` AS `shop_token`
        FROM 
        `orders` 
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
            LEFT JOIN `employees` ON `employees`.`token` = `orders`.`employee_token` 
            LEFT JOIN `shop__outstanding` ON `shop__outstanding`.`shop_token` = `orders`.`shop_token` 
            where  `orders`.`token`=?";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    function  viewIndividualShopDetail($stmt)
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->order_token = $row['token'];
        $obj->date_time = date("d/m/Y (h:i A)", strtotime($row['date_time']));
        $obj->date_value = date("Y-m-d", strtotime($row['date_time']));
        $obj->shop_name = $row['shop_name'];
        $obj->employee_name = $row['employee_name'];
        $obj->employee_token = $row['employee_token'];
        $obj->items = $row['items'];
        $obj->billing_amount = number_format($row['billing_amount'], 2, '.', '');
        $obj->bill_discount_amount = number_format($row['bill_discount_amount'], 2, '.', '');
        $obj->bill_discount_percentage = $row['bill_discount_percentage'];
        $order_gst_amt      =  $row['billing_amount'] / 1.18 * 18 / 100;
        $obj->mrp_amount     = number_format($row['billing_amount'] / 1.18, 2, '.', '');
        $obj->delivery = $row['delivery'];
        if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
            $obj->delivered_on   = date("d/m/Y (h:i A)", strtotime($row['delivered_on']));
        } else {
            $obj->delivered_on   = "-";
        }
        if ($row['bill_discount_amount'] != 0) {
            $discountFromBill = $row['billing_amount'] - $row['bill_discount_amount'];
            $obj->total_outstanding = number_format($discountFromBill - $row['paid_amount'], 2, '.', '');
        } else if ($row['bill_discount_percentage'] != 0) {
            $getdisAmtBill = $row['billing_amount'] * $row['bill_discount_percentage'] / 100;
            $discountFromBill = $row['billing_amount'] - $getdisAmtBill;
            $obj->total_outstanding = number_format($discountFromBill - $row['paid_amount'], 2, '.', '');
        } else {
            $obj->total_outstanding = number_format($row['billing_amount'] - $row['paid_amount'], 2, '.', '');
        }
        $obj->paid_amount = $row['paid_amount'];
        $obj->gst_amount     = number_format($row['billing_amount'] / 1.18 * 18 / 100, 2, '.', '');
        $obj->shop_token     = $row['shop_token'];
        $obj->invoice_name     = $row['invoice_name'];
        return $obj;
    }

    function individualShopOrderDetail()
    {
        $query1 = "SELECT
                    `products`.`token`,
                    `products`.`name`,
                    `products`.`gst`,
                    `products`.`hsn_code`,
                    `products`.`item_code`,
                    `products`.`mrp`,
                    `products`.`net_weight`,
                    `products`.`retailer_price` AS price_per_unit,
                    `orders__items`.`order_token`,
                    `orders__items`.`quantity`,
                    `orders__items`.`units`,
                    `orders__items`.`free_product`,
                    `orders__items`.`is_discount_enable`,
                    `orders__items`.`discount_value`,
                    `products`.`piece_count`,
                    COALESCE(
                        `stock__distributor`.`sold_pieces`,
                        0
                    ) AS sold_pieces,
                    `products`.`retailer_price`,
                    `orders__items`.`is_free`
                FROM
                    `orders__items`
                LEFT JOIN `orders` ON `orders`.`token` = `orders__items`.`order_token`
                LEFT JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
                LEFT JOIN `stock__distributor` ON `stock__distributor`.`product_token` = `products`.`token` AND `stock__distributor`.`employee_token` = ?
                LEFT JOIN `employees` ON `employees`.`token` = `stock__distributor`.`employee_token`
                WHERE
                    `orders__items`.`order_token` = ? AND `orders__items`.`delete_status` = '1' AND (`orders`.`employee_token` = ? OR `orders`.`distributor_token`= ?)
                ORDER BY
                    `products`.`name`,
                    `orders__items`.`is_free` ASC";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->token);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function individualShopOrder()
    {
        $query1 = "SELECT
        `products`.`token`,
        `products`.`name`,
        `products`.`gst`,
        `products`.`item_code`,
        `products`.`mrp`,
        `products`.`hsn_code`,
        `products`.`retailer_price` as price_per_unit,
        `orders__items`.`order_token`,
        `orders__items`.`quantity`,
        `orders__items`.`units`,
        `orders__items`.`free_product`,
        `orders__items`.`is_discount_enable`,
        `orders__items`.`discount_value`,
        `products`.`piece_count`,
        `products`.`retailer_price`,
        `orders__items`.`is_free`
    FROM
        `orders__items`
    LEFT JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
    WHERE
        `orders__items`.`order_token` = ? AND `orders__items`.`delete_status` = '1' 
    ORDER BY
        `products`.`name`,
        `orders__items`.`is_free` ASC";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function  viewIndividualShopOrderDetail($stmts)
    {
        $total_dis = 0;
        $array = [];
        while ($row = $stmts->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_name = $row['name'];
            $obj->product_token = $row['token'];
            $obj->item_code = $row['item_code'];
            $obj->piece_count = $row['piece_count'];
            $obj->sold_pieces = $row['sold_pieces'];
            $obj->box_price = number_format($row["retailer_price"] * $row['piece_count'], 2, '.', '');
            $obj->per_unit_price = $row["retailer_price"];
            if ($row['units'] == "Box") {
                $obj->quantity      = $row['quantity'] . ' Box';
                $totalsamount  = $row['quantity'] * $row['piece_count'] * $row['price_per_unit'];
                $obj->amount = number_format($totalsamount, 2, '.', '');
                if ($row["is_discount_enable"] == 1) {
                    $discounted = number_format($totalsamount * $row["discount_value"] / 100, 2, '.', '');
                    $obj->discount = $discounted;
                    $total_dis += $discounted;
                    $obj->dicount_total_value = $total_dis;
                } else {
                    $obj->discount = 0;
                    $obj->dicount_total_value = 0;
                }
                $obj->units         = $row['units'];
            } else {
                $obj->quantity = $row['quantity'] . ' Nos';
                $totalsamount  = $row['quantity'] * $row['price_per_unit'];
                $obj->amount = number_format($totalsamount, 2, '.', '');
                if ($row["is_discount_enable"] == 1) {
                    $discounted = number_format($totalsamount * $row["discount_value"] / 100, 2, '.', '');
                    $obj->discount = $discounted;
                    $total_dis += $discounted;
                    $obj->dicount_total_value = $total_dis;
                } else {
                    $obj->discount = 0;
                    $obj->dicount_total_value = 0;
                }
                $obj->units         = $row['units'];
            }
            $obj->free_product = $row['free_product'];
            $obj->discount_percentage = $row['discount_value'];
            $obj->is_free = $row['is_free'];
            array_push($array, $obj);
        }
        return $array;
    }

    function getTotalBillAndPaidAmt()
    {
        $query1 = "SELECT `billing_amount`, `paid_amount`, `outstanding_amount` FROM `orders` WHERE `token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $leftedAmt1 = number_format($row1["billing_amount"] - $row1["paid_amount"], 2, '.', '');
        $discount_val = $this->dis_val;
        $oustanding = number_format($leftedAmt1 - $discount_val, 2, '.', '');
        $query2 = "UPDATE `orders` SET `outstanding_amount`=$oustanding WHERE `token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->token);
        $stmt2->execute();
        return $stmt2;
    }

    function individualShopPaymentDetail()
    {
        // $query1 = "SELECT `date_time`,`payment_mode`,`amount` FROM `shop__order_transaction` WHERE `order_token`=?";
        $query1 = "SELECT
        shop__order_transaction.`date_time`,
        shop__order_transaction.`payment_mode`,
        shop__order_transaction.`amount`,
        employees.name AS emp_name
    FROM
        `shop__order_transaction`
    INNER JOIN employees ON employees.token = shop__order_transaction.employee_id
    WHERE
        shop__order_transaction.`order_token` = ?";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    function viewIndividualShopPaymentDetail($stmt2)
    {
        $array = [];

        while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->date_time = nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time'])));
            $obj->payment_mode = $row['payment_mode'];
            $obj->amount = $row['amount'];
            $obj->emp_name = $row['emp_name'] == "" ? "-" : $row['emp_name'];
            array_push($array, $obj);
        }
        return $array;
    }

    function selectStockOrderDistributor($distributor, $productToken)
    {
        $query1 = "SELECT `product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand` FROM `stock__distributor` WHERE `employee_token`='$distributor' AND `product_token`='$productToken'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $stock_in_hand = $row1['stock_in_hand'];
        return $stock_in_hand;
    }

    function selectStockOrderDistributorsold($distributor, $productToken)
    {
        $query1 = "SELECT `sold_pieces` FROM `stock__distributor` WHERE `employee_token`='$distributor' AND `product_token`='$productToken'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $sold_pieces = $row1['sold_pieces'];
        return $sold_pieces;
    }

    function productPieceCount($productToken)
    {
        $query1 = "SELECT `piece_count` FROM products WHERE token='$productToken'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $piece_count = $row1['piece_count'];
        return $piece_count;
    }

    function returnStockOnCancel($productToken, $newStockInHand, $balanace_pieces, $distributor)
    {
        $query = "UPDATE `stock__distributor` 
        SET  `stock_in_hand`='$newStockInHand', `sold_pieces`='$balanace_pieces' 
        where  `product_token`= '$productToken' AND  `employee_token`= '$distributor'";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updateSalesLog()
    {
        $OrderedDate = $this->orderDate;
        $query1 = "UPDATE `sales__log` 
        SET `status`='Cancelled'
        where `date_time`LIKE '$OrderedDate%' AND `distributor_token`=? AND `sales_token`=? AND `shop_token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->distributor_token);
        $stmt1->bindParam(2, $this->employee_token);
        $stmt1->bindParam(3, $this->shop_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function selectBillingAmount()
    {
        $query1 = "SELECT `shop_token`, `bill_amount`, `total_outstanding` FROM `shop__outstanding` WHERE `shop_token`=?";
        $stmt2 = $this->conn->prepare($query1);
        $stmt2->bindParam(1, $this->shop_token);
        $stmt2->execute();
        $row1 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->shop_token = $row1['shop_token'];
        $obj->old_bill_amount = $row1['bill_amount'];
        $obj->old_total_outstanding = $row1['total_outstanding'];
        return $obj;
    }

    function updateBillingAmount()
    {
        $query = "UPDATE `shop__outstanding` SET `bill_amount`=?, `total_outstanding`=? WHERE `shop_token`=?";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam(1, $this->total_billing_amount);
        $stmt1->bindParam(2, $this->total_outstanding);
        $stmt1->bindParam(3, $this->shop_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function cancelOrder($indiaDateTime)
    {
        $query = "UPDATE `orders` SET `delivery`='Cancelled', `delivered_on`='$indiaDateTime' WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->orderToken);
        if ($stmt->execute()) {
            return "Successfully Order Cancelled";
        } else {
            return "Error on Cancel";
        }
    }

    function singleOrderDetail()
    {
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `orders`.`employee_token`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`billing_amount`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`,
        `orders`.`invoice_name`,
        `orders`.`approved_on`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function readSingleOrder($stmt, $baseUrlPath)
    {
        $array = [];
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->order_token    = $row['token'];
        $obj->employee_token = $row['employee_token'];
        $obj->order_number   = $row['order_number'];
        $obj->date_time      = nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time'])));
        $obj->date_value     = date("Y-m-d", strtotime($row['date_time']));
        $obj->shop_name      = $row['shop_name'];
        $obj->sales_man      = $row['sales_man'];
        $obj->items          = $row['items'];
        if ($row['invoice_name'] == "") {
            $obj->invoice_url    = "";
        } else {
            $obj->invoice_url    = $baseUrlPath . "invoice_pdf/" . $row['invoice_name'];
        }
        $obj->billing_amount = $row['billing_amount'];
        $obj->gst_amount     = round((float)$row['billing_amount'] / 1.18 * 0.18, 2);
        $mrp_amount          = round((float)$row['billing_amount'] / 1.18, 2);
        $obj->mrp_amount     = $mrp_amount;
        if ($row['delivery'] == "Completed") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn greenbtn status-widget">Completed</button>';
            //'.$row['delivery'].'
        } else if ($row['delivery'] == "Pending") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn voliet status-widget">' . $row['delivery'] . '</button>';
        } else if ($row['delivery'] == "Approved") {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn greenbtn status-widget">' . $row['delivery'] . '</button>';
        } else {
            $obj->delivery       = '<button style="margin-left: 0px; margin-top: 0px;" class="tb-btn red status-widget">' . $row['delivery'] . '</button>';
        }
        $obj->delivery_value     = $row['delivery'];
        if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
            $obj->delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
        } else {
            $obj->delivered_on   = "-";
        }
        $obj->delivered_on_value = $row['delivered_on'];

        if ($row['approved_on'] != null && $row['approved_on'] != "0000-00-00 00:00:00") {
            $obj->approved_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['approved_on'])));
        } else {
            $obj->approved_on   = "-";
        }
        $obj->approved_on_value = $row['approved_on'];

        $obj->paid_amount    = $row['paid_amount'];
        $obj->outstanding    = round((float)$row['billing_amount'] - (float)$row['paid_amount'], 2);

        array_push($array, $obj);
        return $array;
    }
    function singleOrderItemDetail()
    {
        $query = "SELECT 
        `products`.`item_code` AS `item_code`,
        `products`.`name` AS `item_name`,
        `orders__items`.`quantity`,
        `orders__items`.`price_per_unit`,
        `orders__items`.`misc_price`,
        `orders__items`.`units`,
        `orders__items`.`product_token`,
        `orders__items`.`offer_amount`,
        `orders__items`.`offer_percentage`,
        `products`.`piece_count`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        WHERE `orders`.`token`=? AND `orders__items`.`delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function readSingleOrderItemDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->product_token = $row['product_token'];
            $obj->item_code     = $row['item_code'];
            $obj->item_name     = $row['item_name'];
            $obj->distributor_quantity  = $row['quantity'];
            $obj->price_per_unit = $row['price_per_unit'];
            $obj->misc_price    = $row['misc_price'];
            $obj->offer_percentage    = $row['offer_percentage'];
            $obj->quantity_plus_piece = $row['quantity'] * $row['piece_count'];
            if ($row['units'] == "Box") {
                $obj->quantity      = $row['quantity'] * $row['piece_count'];
                //$obj->quantity      = $row['quantity'].' Box';
                $obj->total_amount  = round((float)$row['offer_amount'], 2);
                $obj->units         = $row['units'] . "(" . $row['piece_count'] . " Nos)";
            } else {
                $obj->quantity      = $row['quantity'];
                $obj->total_amount  = round((float)$row['offer_amount'], 2);
                $obj->units         = $row['units'];
            }
            array_push($array, $obj);
        }
        return $array;
    }
    function orderHistoryCheckCount()
    {
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        LEFT  JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE `orders`.order_type!='Distributor Order' AND `orders`.`shop_token` =?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }
    function orderHistoryCheckFilter()
    {
        $dateQuery   = $this->dateQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE `orders`.order_type!='Distributor Order' AND `orders`.`shop_token` =?
        $dateQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }

    function orderHistoryCheckSearch()
    {
        $searchQuery   = $this->searchQuery;
        $query = "SELECT  `orders`.`id`
        FROM `orders`
        LEFT JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE `orders`.order_type!='Distributor Order' AND `orders`.`shop_token` =?
        $searchQuery
        ORDER BY `orders`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }

    function serverOrderHistoryCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT  `orders`.`token`,
        `orders`.`order_number`,
        `orders`.`date_time`,
        `shop`.`name` AS `shop_name`,
        `employees`.`name` AS `sales_man`,
        `orders`.`items`,
        `orders`.`delivery`,
        `orders`.`delivered_on`,
        `orders`.`paid_amount`,
        `orders`.`outstanding_amount`,
        `orders`.`billing_amount`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` AND `employees`.`token`=? 
        WHERE 1
        $searchQuery
        $dateQuery
        AND `orders`.order_type!='Distributor Order' AND `orders`.`shop_token` =?
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }
    function serverReadOrderHistory($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['delivery'] == "Completed") {
                $delivery  = '<button class="tb-btn greenbtn">Completed</button>';
            } else if ($row['delivery'] == "Pending") {
                $delivery  = '<button class="tb-btn voliet">' . $row['delivery'] . '</button>';
            } else {
                $delivery  = '<button class="tb-btn red">' . $row['delivery'] . '</button>';
            }

            if ($row['delivered_on'] != null && $row['delivered_on'] != "0000-00-00 00:00:00") {
                $delivered_on   = nl2br(date("d/m/Y \n h:i A", strtotime($row['delivered_on'])));
            } else {
                $delivered_on   = "-";
            }

            if ($row["is_slaes_rep_admin"] == 1) {
                $sales_name = "Power Soap Sales Rep";
            } else {
                $sales_name = $row["sales_man"];
            }
            $outstanding = round($row["billing_amount"] - $row["paid_amount"]);

            $data[] = array(
                "order_token" => $row['token'],
                "order_number" => '<a class="view_link" >' . $row['order_number'] . '</a>',
                "date_time" => nl2br(date("d/m/Y \n h:i A", strtotime($row['date_time']))),
                "shop_name" => $row['shop_name'],
                "sales_man" => $sales_name,
                "items" => $row['items'],
                "paid_amount" => $this->indianNumbeFormat($row['paid_amount']),
                "outstanding_amount" => '<span style="color:red !important;">' . $this->indianNumbeFormat($outstanding) . '</span>',
                "delivery" => $delivery,
                "delivered_on" => $delivered_on
            );
        }
        return $data;
    }
    function salesOrderInvoice()
    {
        $query12 = "SELECT `orders`.`token` AS `order_token`,
        `orders`.`order_number` AS `order_id`,
        `orders`.`billing_amount`,
        `orders`.`paid_amount`,
        `orders`.`bill_discount_amount`,
        `orders__items`.`is_discount_enable`,
        `orders`.`bill_discount_percentage`,
        `shop`.`name` AS `shop_name`,
        `shop`.`token` AS `shop_token`,
        `units`.`name` AS `unit_name`,
            CONCAT(`shop`.`address`,', ',
                    `shop`.`city`,', ',
                    `shop`.`pincode`) AS `shop_address`,
        `shop`.`mobile_number` AS `shop_mobile_number`, 
        `shop`.`license_number` AS `shop_license_number`,
        `employees`.`admin_distributor_token`,
        `employees`.`email_id`
        FROM `orders`
          INNER JOIN `orders__items` ON `orders__items`.`order_token` = `orders`.`token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `orders`.`distributor_token` = `employees`.`token`
        LEFT JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        where `orders`.`token` = ?";
        $stmt1 = $this->conn->prepare($query12);
        $stmt1->bindParam(1, $this->order_id);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->order_token = $row1['order_token'];
        $obj->order_id = $row1['order_id'];
        $obj->outstanding_amount = $row1['billing_amount'] - $row1['paid_amount'];
        $obj->paid_amount = $row1['paid_amount'];
        $obj->shop_name = $row1['shop_name'];
        $obj->shop_token = $row1['shop_token'];
        $obj->shop_address = $row1['shop_address'];
        $obj->shop_mobile_number = $row1['shop_mobile_number'];
        $obj->shop_license_number = $row1['shop_license_number'];
        $obj->billing_amount = $row1['billing_amount'];
        $obj->bill_discount_amount = $row1['bill_discount_amount'];
        $obj->bill_discount_percentage = $row1['bill_discount_percentage'];
        $obj->is_discount_enable = $row1['is_discount_enable'];
        $obj->email = $row1['email_id'];
        $obj->unit_name = $row1['unit_name'];
        if ($row1['admin_distributor_token'] != '') {
            $newquery = "SELECT 
            `name` AS `distributor_name`, 
            CONCAT(`employees`.`address`,', ',
                    `employees`.`city`,', ', 
                    `employees`.`pincode`) AS `distributor_address`,
            `mobile_number` AS `distributor_mobile_number`,
            `license_number` AS `distributor_license` 
            FROM `employees` 
            WHERE `token`= " . $row1['admin_distributor_token'] . "";
            $stmt21 = $this->conn->prepare($newquery);
            $stmt21->execute();
            $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
            $obj->distributor_name = $row21['distributor_name'];
            $obj->distributor_address = $row21['distributor_address'];
            $obj->distributor_mobile_number = $row21['distributor_mobile_number'];
            $obj->distributor_license = $row21['distributor_license'];
        } else {
            $getDistToken = "SELECT `employee_token` FROM `orders` WHERE `token`=?";
            $stmt2 = $this->conn->prepare($getDistToken);
            $stmt2->bindParam(1, $this->order_id);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $newquery = "SELECT 
            `name` AS `distributor_name`, 
            CONCAT(`employees`.`address`,', ',
                    `employees`.`city`,', ', 
                    `employees`.`pincode`) AS `distributor_address`,
            `mobile_number` AS `distributor_mobile_number`,
            `license_number` AS `distributor_license` 
            FROM `employees` 
            WHERE `token`= " . $row2["employee_token"] . "";
            $stmt21 = $this->conn->prepare($newquery);
            $stmt21->execute();
            $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
            $obj->distributor_name = $row21['distributor_name'];
            $obj->distributor_address = $row21['distributor_address'];
            $obj->distributor_mobile_number = $row21['distributor_mobile_number'];
            $obj->distributor_license = $row21['distributor_license'];
        }
        return $obj; //json_encode($obj);    
    }
    //new pdf invoice
    function salesOrderInvoiceNew()
    {
        $query12 = "SELECT `orders`.`token` AS `order_token`,
        `orders`.`order_number` AS `order_id`,
        `orders`.`billing_amount`,
        `orders`.`paid_amount`,
        `orders`.`bill_discount_amount`,
        `orders`.`bill_discount_percentage`,
        `shop`.`name` AS `shop_name`,
        `shop`.`token` AS `shop_token`,
            CONCAT(`shop`.`address`,', ',
                    `shop`.`city`,', ',
                    `shop`.`pincode`) AS `shop_address`,
        `shop`.`mobile_number` AS `shop_mobile_number`, 
        `shop`.`license_number` AS `shop_license_number`,
        `employees`.`admin_distributor_token`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `employees` ON `orders`.`employee_token` = `employees`.`token`
        LEFT JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        where `orders`.`token` = ?";
        $stmt1 = $this->conn->prepare($query12);
        $stmt1->bindParam(1, $this->order_id);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->order_token = $row1['order_token'];
        $obj->order_id = $row1['order_id'];
        $obj->outstanding_amount = $row1['billing_amount'] - $row1['paid_amount'];
        $obj->paid_amount = $row1['paid_amount'];
        $obj->shop_name = $row1['shop_name'];
        $obj->shop_token = $row1['shop_token'];
        $obj->shop_address = $row1['shop_address'];
        $obj->shop_mobile_number = $row1['shop_mobile_number'];
        $obj->shop_license_number = $row1['shop_license_number'];
        $obj->billing_amount = $row1['billing_amount'];
        $obj->bill_discount_amount = $row1['bill_discount_amount'];
        $obj->bill_discount_percentage = $row1['bill_discount_percentage'];
        if ($row1['admin_distributor_token'] != '') {
            $newquery = "SELECT 
            `name` AS `distributor_name`, 
            CONCAT(`employees`.`address`,', ',
                    `employees`.`city`,', ', 
                    `employees`.`pincode`) AS `distributor_address`,
            `mobile_number` AS `distributor_mobile_number`,
            `license_number` AS `distributor_license` 
            FROM `employees` 
            WHERE `token`= " . $row1['admin_distributor_token'] . "";
            $stmt21 = $this->conn->prepare($newquery);
            $stmt21->execute();
            $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
            $obj->distributor_name = $row21['distributor_name'];
            $obj->distributor_address = $row21['distributor_address'];
            $obj->distributor_mobile_number = $row21['distributor_mobile_number'];
            $obj->distributor_license = $row21['distributor_license'];
        } else {
            $getDistToken = "SELECT `employee_token` FROM `orders` WHERE `token`=?";
            $stmt2 = $this->conn->prepare($getDistToken);
            $stmt2->bindParam(1, $this->order_id);
            $stmt2->execute();
            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $newquery = "SELECT 
            `name` AS `distributor_name`, 
            CONCAT(`employees`.`address`,', ',
                    `employees`.`city`,', ', 
                    `employees`.`pincode`) AS `distributor_address`,
            `mobile_number` AS `distributor_mobile_number`,
            `license_number` AS `distributor_license` 
            FROM `employees` 
            WHERE `token`= " . $row2["employee_token"] . "";
            $stmt21 = $this->conn->prepare($newquery);
            $stmt21->execute();
            $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
            $obj->distributor_name = $row21['distributor_name'];
            $obj->distributor_address = $row21['distributor_address'];
            $obj->distributor_mobile_number = $row21['distributor_mobile_number'];
            $obj->distributor_license = $row21['distributor_license'];
        }
        return $obj; //json_encode($obj);    
    }


    function discountBillAmount()
    {
        $query1 = "UPDATE `orders` SET `bill_discount_amount`=?, `bill_discount_percentage`=? WHERE `token` = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->bill_discount_amount);
        $stmt1->bindParam(2, $this->discount_percentage);
        $stmt1->bindParam(3, $this->token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function selectSingleProduct()
    {
        $query1 = "SELECT `quantity`, `free_product`, `units` FROM `orders__items` WHERE `order_token` =? AND `product_token` =? AND is_free='0' AND `delete_status`='1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->product_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj = new StdClass();
        $obj->quantity = $row1['quantity'];
        $obj->free_product = $row1['free_product'];
        $obj->units = $row1['units'];
        return $obj;
    }

    function addFreeForproduct()
    {
        $query1 = "UPDATE `orders__items` SET `free_product`=? WHERE `order_token`=? AND `product_token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->free_quantitys);
        $stmt1->bindParam(2, $this->token);
        $stmt1->bindParam(3, $this->product_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function outstandingOrderCount()
    {
        $query = "SELECT
        `shop`.`token`
        FROM
            `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        INNER JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE
        `orders`.`shop_token` =? AND `employees`.`delete_status`='1' GROUP BY `orders`.`shop_token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }

    function serverOutstandingOrderCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $query = "SELECT
        `shop`.`token`
        FROM
            `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        INNER JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE 1
        $searchQuery AND
        `orders`.`delivery` != 'Cancelled' AND `orders`.`shop_token` =? AND `employees`.`delete_status`='1' GROUP BY `orders`.`shop_token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }
    function  serverOutstandingOrderCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT
        `shop_mapping`.`token` AS `shop_mapping_token`,
        `shop`.`token` AS `shop_token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `shop_name`,
        `shop__type`.`name` AS `shop_type_name`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
         SUM(`orders`.`bill_discount_amount`) AS `bill_discount_amount`,
         SUM(CASE WHEN `bill_discount_percentage` !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as `percentage_value`,
         SUM(`orders`.`billing_amount` -`orders`.`paid_amount`) AS `outstanding_amt`
        FROM
            `orders`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        INNER JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` AND `employees`.`token`=?
        WHERE 1
        $searchQuery
        AND `orders`.`delivery` != 'Cancelled' AND `orders`.`shop_token` =? AND `employees`.`delete_status`='1' GROUP BY `orders`.`shop_token`
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->retailer_id);
        $stmt->execute();
        return $stmt;
    }
    function  serverReadOutstandingOrderCheck($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['bill_discount_amount'] > 0) {
                $newOutstanding = round($row['outstanding_amt'] - $row['bill_discount_amount'], 0);
            }
            if ($row['bill_discount_amount'] > 0 && $row['percentage_value'] > 0) {
                $newOutstanding = round($newOutstanding - $row['percentage_value'], 0);
            }
            if ($row['bill_discount_amount'] == 0 && $row['percentage_value'] > 0) {
                $newOutstanding = round($row['outstanding_amt'] - $row['percentage_value'], 0);
            }
            if ($row['bill_discount_amount'] == 0 && $row['percentage_value'] == 0) {
                $newOutstanding = round($row['outstanding_amt'], 0);
            }
            $data[] = array(
                "slno" => $slno,
                "shop_token" => $row['shop_token'],
                "retail_code" => '<a class="view_link" data-shop_mapping_token="' . $row['shop_mapping_token'] . '">' . $row['retail_code'] . '</a>',
                "retailer_name" => $row['shop_name'],
                "shop_type" => $row['shop_type_name'],
                "mobile_number" => $row['mobile_number'],
                "contact_person" => $row['contact_person'],
                "outstanding" => $this->indianNumbeFormat($newOutstanding)
            );
        }
        return $data;
    }
    function individualOutstandingShop()
    {
        $query = "SELECT `shop`.`name`, 
        `orders`.`shop_token`, 
        `shop_mapping`.`token` AS `shop_mapping_token`,
        SUM(`orders`.`billing_amount`) AS `billing_amount`, 
        SUM(`orders`.`paid_amount`) AS `paid_amount`
        FROM `orders` 
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        WHERE `orders`.`delivery`!='Cancelled' AND `orders`.`shop_token`= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_mapping_token);
        $stmt->execute();
        $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new StdClass();
        $obj->shop_name = $row1['name'];
        $obj->shop_token = $row1['shop_token'];
        $obj->billing_amount = (int)$row1['billing_amount'];
        $obj->paid_amount = (int)$row1['paid_amount'];
        $obj->total_outstanding = (int)$row1['billing_amount'] - $row1['paid_amount'];
        return $obj;
    }
    function individualOutstandingShopDetail()
    {
        $query = "SELECT `date_time`, 
        `payment_mode`, 
        `amount` 
        FROM `shop__order_transaction` 
        WHERE `shop_token`= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }

    function readIndividualOutstandingShopDetail($stmt)
    {
        $array = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new StdClass();
            $obj->date_time =  nl2br(date("d/m/Y \n h:i A", strtotime($row1['date_time'])));
            $obj->payment_mode = $row1['payment_mode'];
            $obj->amount = $row1['amount'];
            array_push($array, $obj);
        }
        return $array;
    }

    function addQuantityForproduct()
    {
        $query1 = "UPDATE `orders__items` SET `quantity`=?,`units`=? WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1' AND `is_free`='0'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->quantitys);
        $stmt1->bindParam(2, $this->units);
        $stmt1->bindParam(3, $this->token);
        $stmt1->bindParam(4, $this->product_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // function updateBillAmts()
    // {
    //     $discountAmount = 0;
    //     $billingAmount = 0;
    //     $query3 = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `quantity`, `units`, `discount_value`,`offer_amount` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1' AND (`is_discount_enable`='1' OR `is_discount_enable`='0')";
    //     $stmt3 = $this->conn->prepare($query3);
    //     $stmt3->bindParam(1, $this->token);
    //     $stmt3->execute();
    //     while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
    //         if ($row3["units"] == 'Box') {
    //             $itemAmount = $row3["price_per_unit"] * $row3["piece_count"] * $row3["quantity"];
    //             $itemDiscountAmt = number_format($itemAmount * $row3["discount_value"] / 100, 2, '.', '');
    //         } else {
    //             $itemAmount = $row3["price_per_unit"] * $row3["quantity"];
    //             $itemDiscountAmt = number_format($itemAmount * $row3["discount_value"] / 100, 2, '.', '');
    //         }
    //         $discountAmount += $itemDiscountAmt;
    //         $billingAmount += $itemAmount;
    //         $query4 = "UPDATE `orders__items` SET `offer_amount`=" . $itemAmount . " WHERE `order_token`=" . $row3['order_token'] . " AND `product_token`=" . $row3['product_token'] . "";
    //         $stmt4 = $this->conn->prepare($query4);
    //         $stmt4->execute();
    //     }
    //     $newBillAmount = number_format($billingAmount - $discountAmount, 2, '.', '');
        
    //     $queryGst = "SELECT SUM(`misc_price`) as `gst_total` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1'";
    //     $stmtGst = $this->conn->prepare($queryGst);
    //     $stmtGst->bindParam(1, $this->token);
    //     $stmtGst->execute();
    //     $rowGst = $stmtGst->fetch(PDO::FETCH_ASSOC);
    //     $gstTotal = isset($rowGst['gst_total']) ? number_format($rowGst['gst_total'], 2, '.', '') : '0.00';

    //     $query2 = "UPDATE `orders` SET `billing_amount`=" . round($newBillAmount) . ", `gst`=" . $gstTotal . " WHERE `token`=?";
    //     $stmt2 = $this->conn->prepare($query2);
    //     $stmt2->bindParam(1, $this->token);
    //     if ($stmt2->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

        function updateBillAmts()
    {
        $discountAmount = 0;
        $billingAmount = 0;
        $query3 = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `quantity`, `units`, `discount_value`,`offer_amount` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1' AND (`is_free`='0' OR `is_free` IS NULL) AND (`is_discount_enable`='1' OR `is_discount_enable`='0')";
        $stmt3 = $this->conn->prepare($query3);
        $stmt3->bindParam(1, $this->token);
        $stmt3->execute();
        while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            if ($row3["units"] == 'Box') {
                $itemAmount = $row3["price_per_unit"] * $row3["piece_count"] * $row3["quantity"];
                $itemDiscountAmt = number_format($itemAmount * $row3["discount_value"] / 100, 2, '.', '');
            } else {
                $itemAmount = $row3["price_per_unit"] * $row3["quantity"];
                $itemDiscountAmt = number_format($itemAmount * $row3["discount_value"] / 100, 2, '.', '');
            }
            $discountAmount += $itemDiscountAmt;
            $billingAmount += $itemAmount;
            $query4 = "UPDATE `orders__items` SET `offer_amount`=" . $itemAmount . " WHERE `order_token`=" . $row3['order_token'] . " AND `product_token`=" . $row3['product_token'] . "";
            $stmt4 = $this->conn->prepare($query4);
            $stmt4->execute();
        }
        $newBillAmount = number_format($billingAmount - $discountAmount, 2, '.', '');

        $queryGst = "SELECT SUM(`misc_price`) as `gst_total` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1'";
        $stmtGst = $this->conn->prepare($queryGst);
        $stmtGst->bindParam(1, $this->token);
        $stmtGst->execute();
        $rowGst = $stmtGst->fetch(PDO::FETCH_ASSOC);
        $gstTotal = isset($rowGst['gst_total']) ? number_format($rowGst['gst_total'], 2, '.', '') : '0.00';

        $query2 = "UPDATE `orders` SET `billing_amount`=" . round($newBillAmount) . ", `gst`=" . $gstTotal . " WHERE `token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->token);
        if ($stmt2->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function updateOutstandingAmts()
    {
        $query1 = "SELECT
 		`orders`.`token`,
        `orders`.`bill_discount_amount` AS `bill_discount_amount`,
        CASE WHEN `bill_discount_percentage` !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END as `percentage_value`,
        `orders`.`billing_amount` -`orders`.`paid_amount` AS `outstanding_amt`
        FROM
            `orders`
        INNER JOIN `employees` ON `employees`.`token` = `orders`.`employee_token`
        WHERE `orders`.`delivery` != 'Cancelled' AND `orders`.`token` = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        if ($row1['bill_discount_amount'] > 0) {
            $newOutstanding = round($row1['outstanding_amt'] - $row1['bill_discount_amount'], 0);
        }
        if ($row1['bill_discount_amount'] > 0 && $row1['percentage_value'] > 0) {
            $newOutstanding = round($newOutstanding - $row1['percentage_value'], 0);
        }
        if ($row1['bill_discount_amount'] == 0 && $row1['percentage_value'] > 0) {
            $newOutstanding = round($row1['outstanding_amt'] - $row1['percentage_value'], 0);
        }
        if ($row1['bill_discount_amount'] == 0 && $row1['percentage_value'] == 0) {
            $newOutstanding = round($row1['outstanding_amt'], 0);
        }
        $query2 = "UPDATE `orders` SET `outstanding_amount`=" . round($newOutstanding) . " WHERE `token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->token);
        if ($stmt2->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function updateBillAmtsShopWise()
    {
        $query1 = "SELECT SUM(`billing_amount`) AS `bill_Amount` FROM `orders` WHERE `shop_token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->shop_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $billingAmount = $row1['bill_Amount'];
        $query2 = "UPDATE `shop__outstanding` SET `bill_amount`=" . round($billingAmount) . " WHERE `shop_token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->shop_token);
        if ($stmt2->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function singleShopOutstanding()
    {
        $query21 = "SELECT
 		`orders`.`shop_token`,
         SUM(`orders`.`bill_discount_amount`) AS `bill_discount_amount`,
         SUM(CASE WHEN `bill_discount_percentage` !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as `percentage_value`,
         SUM(`orders`.`billing_amount` -`orders`.`paid_amount`) AS `outstanding_amt`
        FROM
            `orders`
        INNER JOIN `employees` ON `employees`.`token` = `orders`.`employee_token`
        WHERE `orders`.`delivery` != 'Cancelled' AND `orders`.`shop_token` = ?";
        $stmt21 = $this->conn->prepare($query21);
        $stmt21->bindParam(1, $this->shop_token);
        $stmt21->execute();
        $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
        if ($row21['bill_discount_amount'] > 0) {
            $newOutstanding = round($row21['outstanding_amt'] - $row21['bill_discount_amount'], 0);
        }
        if ($row21['bill_discount_amount'] > 0 && $row21['percentage_value'] > 0) {
            $newOutstanding = round($newOutstanding - $row21['percentage_value'], 0);
        }
        if ($row21['bill_discount_amount'] == 0 && $row21['percentage_value'] > 0) {
            $newOutstanding = round($row21['outstanding_amt'] - $row21['percentage_value'], 0);
        }
        if ($row21['bill_discount_amount'] == 0 && $row21['percentage_value'] == 0) {
            $newOutstanding = round($row21['outstanding_amt'], 0);
        }
        $query42 = "UPDATE `shop__outstanding` SET `total_outstanding`=" . round($newOutstanding) . " WHERE `shop_token`=?";
        $stmt42 = $this->conn->prepare($query42);
        $stmt42->bindParam(1, $this->shop_token);
        $stmt42->execute();

        return $newOutstanding;
    }

    function unitShopList()
    {
        $date_value = $this->date_value;
        $query21 = "SELECT `shop`.`retail_code` AS `shop_code`,
        `orders`.`order_number`,
        `orders`.`date_time` AS `order_date`,
        `orders`.`paid_amount`,
        `shop`.`name` AS `shop_name`,
        SUM(`orders`.`bill_discount_amount`) AS `bill_discount_amount`,
        SUM(CASE WHEN `bill_discount_percentage` !=0 THEN((`billing_amount`*`bill_discount_percentage`)/100) ELSE 0 END) as `percentage_value`,
        `orders`.`billing_amount` 
        FROM `orders` 
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `units` ON `units`.`token` = `shop`.`unit_token`
        WHERE `orders`.`date_time` LIKE '$date_value%' AND `units`.`name`=? AND `orders`.`order_type` IN ('Sales Order') AND `orders`.`delivery` != 'Cancelled' GROUP BY `shop`.`retail_code`";
        $stmt21 = $this->conn->prepare($query21);
        $stmt21->bindParam(1, $this->location_name);
        $stmt21->execute();
        return $stmt21;
    }

    function updateOrderItem()
    {
        $query21 = "SELECT COUNT(id) AS `itemCount` FROM `orders__items` WHERE `order_token`=? AND `delete_status`='1' AND `is_free`='0'";
        $stmt21 = $this->conn->prepare($query21);
        $stmt21->bindParam(1, $this->token);
        $stmt21->execute();
        $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
        $itemCount = $row21["itemCount"];
        $afterDeleteItemCount = $itemCount - 1;
        $query1 = "UPDATE `orders` SET `items`='$afterDeleteItemCount' WHERE `token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->execute();
        $query1 = "UPDATE `orders__items` SET `delete_status`='2' WHERE `order_token`=? AND `product_token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->token);
        $stmt1->bindParam(2, $this->product_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function insertFreeProduct($indiaDateTime, $total_stockInHand, $distributor_token)
    {
        $is_offer_product = "SELECT `product_token`, `scheme_name`, `limit_box`, `free_box`, `start_date`, `end_date`, `is_scheme` 
        FROM `products__scheme` 
        WHERE `product_token`=? AND `is_scheme`='1' ORDER BY `limit_box` DESC LIMIT 0,1";
        $stmt_offer = $this->conn->prepare($is_offer_product);
        $stmt_offer->bindParam(1, $this->product_token);
        $stmt_offer->execute();
        if ($stmt_offer->rowCount() > 0) {
            $row1 = $stmt_offer->fetch(PDO::FETCH_ASSOC);
            $unit_category = $this->units;
            if ($unit_category == "Box") {
                $quantity = $this->quantitys;
                if ($row1["limit_box"] <= $quantity) {
                    $free_box_val = (int)($quantity / $row1["limit_box"]);
                    if ($free_box_val > 0) {
                        $free_box_val1 = $quantity / $row1["limit_box"];
                        $freeProduct_count = $free_box_val1 * $row1["free_box"];
                        $freeProduct = (int)$freeProduct_count;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->token);
                        $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                               `quantity`='$freeProduct',
                               `date_time`='$indiaDateTime', `units`='Box' WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->token);
                            $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                            $row12 = $stmt_offer1->fetch(PDO::FETCH_ASSOC);
                            $freeProductCount = $row12["piece_count"] * $freeProduct;
                            $proToken = $this->product_token;
                            $stock_count = $total_stockInHand - $freeProductCount;
                            // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                            $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                                `order_token`=:order_token, 
                                `product_token`=:product_token, 
                                `price_per_unit`=:price_per_unit, 
                                `piece_count`=:piece_count, 
                                `misc_price`='0', 
                                `quantity`='$freeProduct', 
                                `return_qty`='0', 
                                `offer_token`='0', 
                                `offer_percentage`='0', 
                                `offer_amount`='0', 
                                `units`='Box', 
                                `is_free`='1', 
                                `is_discount_enable`='0', 
                                `product_dis_price`='0', 
                                `product_price`='0',
                                `delete_status`='1',
                                `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                            $row12 = $stmt_offer1->fetch(PDO::FETCH_ASSOC);
                            $freeProductCount = $row12["piece_count"] * $freeProduct;
                            $proToken = $this->product_token;
                            $stock_count = $total_stockInHand - $freeProductCount;
                            // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                            $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                        }
                    }
                } else {
                    $pieceCount1 = $this->piece_count;
                    $singleBoxPieces = $row1["free_box"] * $pieceCount1;
                    $free_box_val = $quantity / $row1["limit_box"] * $singleBoxPieces;
                    if ($free_box_val > 0) {
                        $freeProduct = (int)$free_box_val;
                        $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                        $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                        $stmt_offer1->bindParam(1, $this->token);
                        $stmt_offer1->bindParam(2, $this->product_token);
                        $stmt_offer1->execute();
                        if ($stmt_offer1->rowCount() > 0) {
                            $updateFree = "UPDATE `orders__items` SET 
                               `quantity`='$freeProduct',
                               `date_time`='$indiaDateTime', `units`='Nos' WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                            $stmt_offer2 = $this->conn->prepare($updateFree);
                            $stmt_offer2->bindParam(1, $this->token);
                            $stmt_offer2->bindParam(2, $this->product_token);
                            $stmt_offer2->execute();
                            $row12 = $stmt_offer1->fetch(PDO::FETCH_ASSOC);
                            $freeProductCount = $row12["piece_count"] * $freeProduct;
                            $proToken = $this->product_token;
                            $stock_count = $total_stockInHand - $freeProductCount;
                            // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                            $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                        } else {
                            $insertFree = "INSERT INTO `orders__items` SET 
                                `order_token`=:order_token, 
                                `product_token`=:product_token, 
                                `price_per_unit`=:price_per_unit, 
                                `piece_count`=:piece_count, 
                                `misc_price`='0', 
                                `quantity`='$freeProduct', 
                                `return_qty`='0', 
                                `offer_token`='0', 
                                `offer_percentage`='0', 
                                `offer_amount`='0', 
                                `units`='Nos', 
                                `is_free`='1', 
                                `is_discount_enable`='0', 
                                `product_dis_price`='0', 
                                `product_price`='0', 
                                `delete_status`='1',
                                `date_time`='$indiaDateTime'";
                            $stmt_offer3 = $this->conn->prepare($insertFree);
                            $stmt_offer3->bindParam('order_token', $this->token);
                            $stmt_offer3->bindParam('product_token', $this->product_token);
                            $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                            $stmt_offer3->bindParam('piece_count', $this->piece_count);
                            $stmt_offer3->execute();
                            $row12 = $stmt_offer1->fetch(PDO::FETCH_ASSOC);
                            $freeProductCount = $row12["piece_count"] * $freeProduct;
                            $proToken = $this->product_token;
                            $stock_count = $total_stockInHand - $freeProductCount;
                            // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                            $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                        }
                    } else {
                        $offerRemove = "UPDATE `orders__items` SET 
                        `delete_status`='2' 
                        WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                        $stmt_offer4 = $this->conn->prepare($offerRemove);
                        $stmt_offer4->bindParam(1, $this->token);
                        $stmt_offer4->bindParam(2, $this->product_token);
                        $stmt_offer4->execute();
                    }
                }
            } else {
                $queryQty = "SELECT `token`, `name`, `retailer_price`, `piece_count` FROM `products` WHERE `token`=?";
                $stmtQty = $this->conn->prepare($queryQty);
                $stmtQty->bindParam(1, $this->product_token);
                $stmtQty->execute();
                $row2 = $stmtQty->fetch(PDO::FETCH_ASSOC);
                $limitBoxIntoQty = $row1["limit_box"] * $row2["piece_count"];
                $freeBoxIntoQty = $row1["free_box"] * $row2["piece_count"];
                $orderQty = $this->quantitys;
                $free_qty_val = $freeBoxIntoQty * $orderQty / $limitBoxIntoQty;
                if ($free_qty_val >= 1) {
                    $freeProduct = (int)$free_qty_val;
                    $isfreeColumnExist = "SELECT `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`, `is_free` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                    $stmt_offer1 = $this->conn->prepare($isfreeColumnExist);
                    $stmt_offer1->bindParam(1, $this->token);
                    $stmt_offer1->bindParam(2, $this->product_token);
                    $stmt_offer1->execute();
                    if ($stmt_offer1->rowCount() > 0) {
                        $updateFree = "UPDATE `orders__items` SET 
                           `quantity`='$freeProduct',
                           `date_time`='$indiaDateTime', `units`='Nos' WHERE `order_token`=? AND `product_token`=? AND `is_free`='1' AND `delete_status`='1'";
                        $stmt_offer2 = $this->conn->prepare($updateFree);
                        $stmt_offer2->bindParam(1, $this->token);
                        $stmt_offer2->bindParam(2, $this->product_token);
                        $stmt_offer2->execute();
                        $proToken = $this->product_token;
                        $stock_count = $total_stockInHand - $freeProduct;
                        // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                        $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                    } else {
                        $insertFree = "INSERT INTO `orders__items` SET 
                            `order_token`=:order_token, 
                            `product_token`=:product_token, 
                            `price_per_unit`=:price_per_unit, 
                            `piece_count`=:piece_count, 
                            `misc_price`='0', 
                            `quantity`='$freeProduct', 
                            `return_qty`='0', 
                            `offer_token`='0', 
                            `offer_percentage`='0', 
                            `offer_amount`='0', 
                            `units`='Nos', 
                            `is_free`='1', 
                            `is_discount_enable`='0', 
                            `product_dis_price`='0', 
                            `product_price`='0',
                            `delete_status`='1',
                            `date_time`='$indiaDateTime'";
                        $stmt_offer3 = $this->conn->prepare($insertFree);
                        $stmt_offer3->bindParam('order_token', $this->token);
                        $stmt_offer3->bindParam('product_token', $this->product_token);
                        $stmt_offer3->bindParam('price_per_unit', $this->price_per_unit);
                        $stmt_offer3->bindParam('piece_count', $this->piece_count);
                        $stmt_offer3->execute();
                        $proToken = $this->product_token;
                        $stock_count = $total_stockInHand - $freeProduct;
                        // $this->returnStockOnCancel($proToken, $stock_count, $distributor_token);
                        $this->returnStockOnCancel($proToken, $stock_count, 0, $distributor_token);
                    }
                } else {
                    $offerRemove = "UPDATE `orders__items` SET 
                    `delete_status`='2' 
                    WHERE `order_token`=? AND `product_token`=? AND `is_free`='1'";
                    $stmt_offer4 = $this->conn->prepare($offerRemove);
                    $stmt_offer4->bindParam(1, $this->token);
                    $stmt_offer4->bindParam(2, $this->product_token);
                    $stmt_offer4->execute();
                }
            }
        }
    }

    function selectFreeQunatityCount()
    {
        $query = "SELECT `order_token`, `product_token`, `quantity`, `units`, `piece_count` FROM `orders__items` WHERE `order_token`=? AND `product_token`=? AND `delete_status`='1' AND `is_free`='1'";
        $stmt_count4 = $this->conn->prepare($query);
        $stmt_count4->bindParam(1, $this->token);
        $stmt_count4->bindParam(2, $this->product_token);
        $stmt_count4->execute();
        $row213 = $stmt_count4->fetch(PDO::FETCH_ASSOC);
        if ($row213) {
            if ($row213["units"] == 'Box') {
                $quantity = $row213["quantity"] * $row213["piece_count"];
            } else {
                $quantity = $row213["quantity"];
            }
        } else {
            $quantity = 0;
        }
        return $quantity; //$row213["quantity"] == ''?'0':$row213["quantity"];
    }
    //checkOderCompleted
    function checkOrerComplete()
    {
        $query = "SELECT
                    orders.order_number,
                    employees.device_token,
                    e.name AS disname,
                    shop.name,
                    orders.sales_rep_token
                FROM
                    `orders`
                INNER JOIN employees ON employees.token = orders.sales_rep_token
                INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
                INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
                INNER JOIN employees e ON
                shop_mapping.distributor_token = e.token
                WHERE
                    orders.token = ? AND orders.shop_token = ? AND orders.delivery = 'Completed' AND orders.is_slaes_rep_admin = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->order_token);
        $stmt->bindParam(2, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }
    //distributorOrderDelivery
    function distributorOrderDelivery()
    {
        $query = "UPDATE
        `orders`
        SET
            `delivery` = 'Completed',
            `delivered_on` = ?,
            `delivery_emp_token` = ?
        WHERE
        `token`= ? AND `shop_token` = ? AND delivery != 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->current_date);
        $stmt->bindParam(2, $this->employee_token);
        $stmt->bindParam(3, $this->order_token);
        $stmt->bindParam(4, $this->shop_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function notificationInsert()
    {
        $query = "INSERT INTO `push_notification`(`shop_token`,`order_id`, `delivered_token`, `distributor_token`, `sales_rep_token`, `date_time`) 
        VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->bindParam(2, $this->order_token);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->bindParam(5, $this->saleRepToken);
        $stmt->bindParam(6, $this->current_date);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //check shop
    function checkShop()
    {
        $query = "SELECT token FROM `orders` WHERE `shop_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }

    //shop_token
    function getShopToken($retailer_id)
    {
        $query = "SELECT token FROM `shop_mapping` WHERE `shop_token`='$retailer_id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = $row1['token'];
        return $token;
    }
    //update saleslog
    function checkSalesLog()
    {
        $query = "SELECT * FROM `sales__log` WHERE `distributor_token`= ? AND `sales_token`=? AND  `shop_token` =? AND status != 'Cancelled'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->employee_token);
        $stmt->bindParam(3, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }

    function updateSalesLogDistributor($date)
    {
        //$date = date('Y-m-d H:i:s');
        //$OrderedDate =$date;
        //$OrderedDate = $this->orderDate;
        $query1 = "UPDATE `sales__log` 
        SET `status`='Completed'
        where `date_time`LIKE '$date%' AND `distributor_token`=? AND `sales_token`=? AND `shop_token`=?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->distributor_token);
        $stmt1->bindParam(2, $this->employee_token);
        $stmt1->bindParam(3, $this->shop_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function salesLogInsert()
    {
        $query = "INSERT INTO `sales__log`(
                    `date_time`,
                    `distributor_token`,
                    `sales_token`,
                    `department`,
                    `shop_token`,
                    `status`
                )
                VALUES(
                    ?,
                    ?,
                    ?,
                    'Delivery',
                    ?,
                    'Completed'
                )";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->current_date);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->bindParam(3, $this->employee_token);
        $stmt->bindParam(4, $this->shop_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //update discount value
    function updateDiscuntvalue()
    {
        $query = "UPDATE
        `orders__items`
        SET
            `discount_value` = ?,
            `is_discount_enable` = '1'
        WHERE
        `order_token` = ? AND `product_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->discountValue);
        $stmt->bindParam(2, $this->order_token);
        $stmt->bindParam(3, $this->selcted_product_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function updateDiscountStatus()
    {
        $query = "UPDATE
        `orders`
        SET
            `bill_discount_amount` = '1',
            `bill_discount_percentage`=?
        
        WHERE
        `token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->discountValue);
        $stmt->bindParam(2, $this->order_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function updateTotalAmountvalue()
    {
        $query = "UPDATE
        `orders`
        SET
            `billing_amount` = ?
        WHERE
        `token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->totalDisCountAmount);
        $stmt->bindParam(2, $this->order_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function updateDisableDiscount()
    {
        $query = "UPDATE
        `orders__items`
        SET
            `discount_value` = ?,
            `is_discount_enable` = '0'
        WHERE
        `order_token` = ? AND `product_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->discountValue);
        $stmt->bindParam(2, $this->order_token);
        $stmt->bindParam(3, $this->selcted_product_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //pdf bank
    function BankDetails()
    {
        $query12 = "SELECT * FROM `employees_payment_details` WHERE distributor_token=?";
        $stmt1 = $this->conn->prepare($query12);
        $stmt1->bindParam(1, $this->distributor_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();
        $obj->bank_name = $row1['bank_name'];
        $obj->account_number = $row1['account_number'];
        $obj->bank_code = $row1['bank_code'];
        $obj->holder_name = $row1['holder_name'];
        $obj->gpay = $row1['gpay'];
        $obj->paytm = $row1['paytm'];
        return $obj;
    }

    //discount
    function discount()
    {
        $query = "SELECT `token`,`percentage` FROM `discount` WHERE `status`='0' ORDER BY `percentage` ASC";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->execute();
        return  $stmt1;
    }

    function readDiscount($stmt1)
    {
        $discount = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row["token"];
            $obj->discount = $row["percentage"];
            array_push($discount, $obj);
        }
        return $discount;
    }
}