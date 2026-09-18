<?php
class Inventory
{
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }

    public function stockCheckCount()
    {
        $query = "SELECT `products`.`id`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `stock__admin` ON `stock__admin`.`product_token`=`products`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function stockCheck()
    {
        $query = "SELECT `products`.`token`,
        `products`.`item_code`,
        `products`.`name`,
        `products__category`.`name` AS `type`,
        COALESCE(`stock__admin`.`stock_in_hand`,0) AS `stock_in_hand`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `stock__admin` ON `stock__admin`.`product_token`=`products`.`token`
        ORDER BY `products`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readStock($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_token = $row['token'];
            $obj->item_code = $row['item_code'];
            $obj->item_name = $row['name'];
            $obj->item_type = $row['type'];
            $obj->monthly_avg = "0";
            $obj->stock_in_hand = $row['stock_in_hand'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function serverStockCheck()
    {
        $rowStart = $this->rowStart;
        $rowperpage = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `stock__admin`.`id`,
        `products`.`token`,
        `products`.`item_code`,
        `products`.`name`,
        `products__category`.`name` AS `type`,
        `products`.`delete_status`,
        COALESCE(`stock__admin`.`stock_in_hand`,0) AS `stock_in_hand`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `stock__admin` ON `stock__admin`.`product_token`=`products`.`token`
        WHERE 1
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readServerStock($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $data[] = array(
                "token" => $row['token'],
                "item_code" => '<a class="view_link item_code_view" >' . $row['item_code'] . '</a>',
                "item_name" => $row['name'],
                "item_type" => $row['type'],
                "stock_in_hand" => $row['stock_in_hand'] . ' Box',
                "delete_status" => $row['delete_status'],
                "action" => '<a><img src="assets/edit.png" class="edit_input item_code_edit" alt=""></a>',
            );
        }
        return $data;
    }

    public function productCheck()
    {
        $query = "SELECT `products`.`token`,
        `products`.`item_code`,
        `products`.`name`,
        `products__category`.`name` AS `type`,
        `products`.`category_token`,
        `products`.`mrp`,
        `products`.`total_cost`,
        `products`.`manufacturer`,
        `products`.`location`,
        `products`.`origin`,
        `products`.`batch_number`,
        `products`.`net_weight`,
        `products`.`description`,
        `products`.`image`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        ORDER BY `products`.`delete_status` ASC, `products`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readProduct($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_token = $row['token'];
            $obj->item_code = $row['item_code'];
            $obj->item_name = $row['name'];
            $obj->item_type = $row['type'];
            $obj->item_mrp = $row['mrp'];
            $obj->item_price = $row['total_cost'];
            $obj->manufacturer = $row['manufacturer'];
            $obj->invoice_number = "Need Content";
            $obj->location = $row['location'];
            $obj->transporter = "Need Content";
            $obj->origin = $row['origin'];
            $obj->batch_number = $row['batch_number'];
            $obj->net_weight = $row['net_weight'];
            $obj->description = $row['description'];
            $obj->image = $row['image'];
            $obj->category_token = $row['category_token'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function serverProductCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $divisionQuery = $this->divisionQuery;
        $query = "SELECT `products`.`id`
        FROM `products`
        LEFT JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `products__scheme` ON `products__scheme`.`product_token`=`products`.`token` AND `products__scheme`.`is_scheme` = '1'
        WHERE 1 $divisionQuery
        $searchQuery GROUP BY `products`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function activeproductcount()
    {
        $query = "SELECT `products`.`id`
        FROM `products`
        WHERE delete_status = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function serverProductCheck()
    {
        $rowStart = $this->rowStart;
        $rowperpage = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $divisionQuery = $this->divisionQuery;
        $columnName = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `products`.`token`,
        `products`.`image`,
        `products`.`item_code`,
        `products`.`name`,
        `products__category`.`name` AS `type`,
        `products`.`total_cost`,
        `products`.`mrp`,
        `products`.`gst`,
        `products`.`hsn_code`,
        `products`.`piece_count`,
        `products__scheme`.`is_scheme`,
        `products`.`delete_status`
        FROM `products`
        LEFT JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `products__scheme` ON `products__scheme`.`product_token`=`products`.`token` AND `products__scheme`.`is_scheme` = '1'
        WHERE 1 $divisionQuery
        $searchQuery
        GROUP BY `products`.`token`
        ORDER BY `products`.`delete_status` ASC, $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function serverReadProduct($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['is_scheme'] == 1) {
                $scheme = '<a class="view_link2 item_code_view1" data-toggle="modal" data-target="#addscheme">View Scheme</a>';
            } else {
                $scheme = '-';
            }
            $slno++;
            $data[] = array(
                "delete_status" => $row['delete_status'],
                "token" => $row['token'],
                "item_code" => '<a class="view_link item_code_view" id="item_code_color" >' . $row['item_code'] . '</a>',
                "image" => $row['image'],
                "name" => $row['name'],
                "type" => $row['hsn_code'],
                "hsn_code" => $row['type'],
                "total_cost" => $row['total_cost'],
                "mrp" => $row['mrp'],
                "gst" => $row['gst'],
                "piece_count" => $row['piece_count'],
                "Agent_Rate" => round($row['total_cost'] * $row['piece_count']),
                "scheme" => $scheme,
                "action" => '<a><img src="assets/edit.png" class="edit_input item_code_edit" alt=""></a>',
            );
        }
        return $data;
    }

    public function singleProductCheck()
    {
        $query = "SELECT `products`.`token`,
        `products`.`item_code`,
        `products`.`name`,
        `products`.`name_short`,
        `products`.`hsn_code`,
        `products__category`.`name` AS `type`,
        `products__category`.`token` AS `category_token`,
        `products`.`gst`,
        `products`.`mrp`,
        `products`.`total_cost`,
        `products`.`manufacturer`,
        `products`.`location`,
        `products`.`origin`,
        `products`.`batch_number`,
        `products`.`net_weight`,
        `products`.`description`,
        `products`.`image`,
        `products`.`piece_count`,
        `products`.`additional_offer`,
        `products`.`delete_status`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        WHERE `products`.`token`=?
        ORDER BY `products`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function readSingleProduct($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_token = $row['token'];
            $obj->item_code = $row['item_code'];
            $obj->item_name = $row['name'];
            $obj->item_nameshort = $row['name_short'];
            $obj->item_hsnCode = $row['hsn_code'];
            $obj->item_type = $row['type'];
            $obj->category_token = $row['category_token'];
            $obj->item_gst = $row['gst'];
            $obj->item_mrp = $row['mrp'];
            $obj->item_price = $row['total_cost'];
            $obj->manufacturer = $row['manufacturer'];
            $obj->invoice_number = "Need Content";
            $obj->location = $row['location'];
            $obj->transporter = "Need Content";
            $obj->origin = $row['origin'];
            $obj->batch_number = $row['batch_number'];
            $obj->net_weight = $row['net_weight'];
            $obj->description = $row['description'];
            $obj->image = $row['image'];
            $obj->piece_count = $row['piece_count'];
            $obj->additional_offer = $row['additional_offer'];
            $obj->delete_status = $row['delete_status'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function addProductCheck()
    {
        $this->productCode = htmlspecialchars(strip_tags($this->productCode));
        $query = "SELECT `id` FROM `products` WHERE `item_code`=:productCode";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('productCode', $this->productCode);
        $stmt->execute();
        return $stmt;
    }

    public function editProductCheck()
    {
        return true;
    }

    public function check($token)
    {
        $query = "SELECT `category_token` FROM `products` WHERE `token`='$token'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $category_token = (int) $row['category_token'];
        return $category_token;
    }

    public function changeStatus($token, $category)
    {
        $query = "UPDATE stock__distributor SET is_active='1' WHERE product_token='$token' AND pro_cat_token='$category'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function tokenGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `products` WHERE `token`=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $random);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $val = false;
            } else {
                $random = rand(10000000, 99999999);
            }
        } while ($val);
        return $random;
    }

    public function divisionTokenGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `products__category` WHERE `token`=?";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $random);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                $val = false;
            } else {
                $random = rand(10000000, 99999999);
            }
        } while ($val);
        return $random;
    }

    public function getProductTypeToken()
    {
        $query = "SELECT `token` FROM `products__category` WHERE `name`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productTypeName);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['token'];
    }

    public function addProduct($indiaDateTime)
    {
        $query = "INSERT INTO `products` SET 
            `date_time`='$indiaDateTime',
            `category_token`=:category_token,
            `token`=:token,
            `item_code`=:item_code,
            `name`=:name,
            `name_short`=:name_short,
            `hsn_code`=:hsn_code,
            `image`=:image,
            `gst`=:gst,
            `mrp`=:mrp,
            `total_cost`=:total_cost,
            `retailer_price`=:retailer_price,
            `piece_count`=:piece_count,
            `batch_number`=:batch_number,
            `net_weight`=:net_weight,
            `additional_offer`='',
            `location`=:location,
            `description`=:description,
            `manufacturer`='Power Soap',
            `origin`='India'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('item_code', $this->productCode);
        $stmt->bindParam('name', $this->productName);
        $stmt->bindParam('image', $this->productImage);
        $stmt->bindParam('gst', $this->productGst);
        $stmt->bindParam('mrp', $this->productMrp);
        $stmt->bindParam('total_cost', $this->productTotalCost);
        $stmt->bindParam('retailer_price', $this->retailerPrice);
        $stmt->bindParam('piece_count', $this->productPieceCount);
        $stmt->bindParam('batch_number', $this->productBatchNumber);
        $stmt->bindParam('net_weight', $this->productWeight);
        $stmt->bindParam('location', $this->productLocation);
        $stmt->bindParam('description', $this->productDescription);
        $stmt->bindParam('name_short', $this->name_short);
        $stmt->bindParam('hsn_code', $this->hsn_code);
        $stmt->bindParam('category_token', $this->productType);
        return $stmt->execute();
    }

    public function addProductLog($indiaDateTime)
    {
        $query = "INSERT INTO `product_log` SET 
            `date_time`='$indiaDateTime',
            `product_token`=:token,
            `old_productname`=:name,
            `new_productname`=:name,
            `old_item_code`=:item_code,
            `new_item_code`=:item_code,
            `old_mrp`=:mrp,
            `new_mrp`=:mrp,
            `old_total_cost`=:total_cost,
            `new_total_cost`=:total_cost,
            `old_piece_count`=:piece_count,
            `new_piece_count`=:piece_count,
            `old_net_weight`=:net_weight,
            `new_net_weight`=:net_weight,
            `created_by`=:admin_token,
            `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('item_code', $this->productCode);
        $stmt->bindParam('name', $this->productName);
        $stmt->bindParam('mrp', $this->productMrp);
        $stmt->bindParam('total_cost', $this->productTotalCost);
        $stmt->bindParam('piece_count', $this->productPieceCount);
        $stmt->bindParam('net_weight', $this->productWeight);
        $stmt->bindParam('admin_token', $this->admin_token);
        return $stmt->execute();
    }

    public function addDistributorStockInHand()
    {
        $product_token = $this->token;
        $category_token = $this->productType;
        $distQuery = "SELECT `employee_token`,`division_token` FROM `employees__division_mapping` WHERE `division_token`=?";
        $distStmt = $this->conn->prepare($distQuery);
        $distStmt->bindParam(1, $this->productType);
        $distStmt->execute();
        $distributor_stock = [];
        while ($distrow = $distStmt->fetch(PDO::FETCH_ASSOC)) {
            $distributor_stock[] = "('$product_token','$category_token'," . $distrow['employee_token'] . ",'0','0','0','0','Added','0')";
        }
        if (empty($distributor_stock)) {
            return true;
        }
        $stockInsert = "INSERT INTO `stock__distributor`(`product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs`, `aog`, `status`,`is_active`) VALUES " . implode(", ", $distributor_stock);
        $intStmt = $this->conn->prepare($stockInsert);
        return $intStmt->execute();
    }

    public function allitemTaken($indiaDate)
    {
        $query = "SELECT `product_token`,`stock_in_hand` FROM `stock__admin` WHERE date(`date_time`)='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readallitemTaken($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->token = $row['product_token'];
            $obj->stock = $row['stock_in_hand'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function insertStockReports($indiaDate, $token, $opening, $closing, $sales_stock)
    {
        $query = "INSERT INTO `stock__report` SET
            `product_token`='$token',
            `sales_stock`='$sales_stock',
            `opening_stock`='$opening',
            `closing_stock`='$closing',
            `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function updateReport($indiaDate, $token, $opening, $closing, $sales_stock)
    {
        $query = "UPDATE `stock__report` SET
            `product_token`='$token',
            `sales_stock`='$sales_stock',
            `opening_stock`='$opening',
            `closing_stock`='$closing',
            `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function checkProduct()
    {
        $query = "SELECT `token` FROM `products` WHERE `item_code`=? AND `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productCode);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['token'] : 0;
    }

    public function oldstock($token)
    {
        $query = "SELECT `stock_in_hand` FROM `stock__admin` WHERE `product_token`='$token'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['stock_in_hand'] : 0;
    }

    public function updateStockUpload($token, $stockValue)
    {
        $query = "UPDATE `stock__admin` SET `stock_in_hand`='$stockValue' WHERE `product_token`='$token'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function stockReports()
    {
        $dateQuery = $this->dateQuery;
        $query = "SELECT 
            stock__report.product_token,
            products.item_code,
            products.name,
            SUM(stock__report.opening_stock) AS opening_stock,
            SUM(stock__report.closing_stock) AS closing_stock,
            SUM(stock__report.sales_stock) AS sales_stock
        FROM stock__report
        INNER JOIN products ON products.token = stock__report.product_token
        WHERE stock__report.status = 1 $dateQuery 
        GROUP BY stock__report.product_token
        ORDER BY stock__report.id DESC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readstockReports($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->item_code = $row['item_code'];
            $obj->name = $row['name'];
            $obj->opening_stock = $row['opening_stock'];
            $obj->closing_stock = $row['closing_stock'];
            $obj->sales_stock = $row['sales_stock'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function updateStockCheck($indiaDateTime)
    {
        $query = "SELECT `id` FROM `stock__admin` WHERE `product_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function insertStock()
    {
        $query = "INSERT INTO `stock__admin` SET `product_token`=?,`stock_in_hand`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->bindParam(2, $this->stockInHand);
        $stmt->execute();
        return $stmt;
    }

    public function insertStockAdd($indiaDateTime)
    {
        $query = "INSERT INTO `stock__admin` SET `product_token`=?,`stock_in_hand`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function insertStock_log($indiaDateTime)
    {
        $query = "INSERT INTO `adminStockLog` SET `product_token`=?,`before_stock`=?,`updated_stock`=?,`created_by`=?,`add_date_time`= '$indiaDateTime',`update_date_time`='$indiaDateTime',`status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->bindParam(2, $this->beforestack);
        $stmt->bindParam(3, $this->stockInHand);
        $stmt->bindParam(4, $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    public function checkProductScheme($indiaDate)
    {
        $query = "SELECT * FROM `stock__report` WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function oldstockSales($indiaDate)
    {
        $query = "SELECT `sales_stock` FROM `stock__report` WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['sales_stock'] : 0;
    }

    public function oldstockOpen($indiaDate)
    {
        $query = "SELECT `opening_stock` FROM `stock__report` WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam(1, $this->productToken);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        return $row1 ? (int) $row1['opening_stock'] : 0;
    }

    public function oldstockclose($indiaDate)
    {
        $query = "SELECT `closing_stock` FROM `stock__report` WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam(1, $this->productToken);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        return $row1 ? (int) $row1['closing_stock'] : 0;
    }

    public function updateReports($indiaDate, $opening, $closing)
    {
        $query = "UPDATE `stock__report` SET `closing_stock`='$closing',`opening_stock`='$opening' WHERE `product_token`=? AND `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function insertStockReportsNew($token, $indiaDate)
    {
        $query = "INSERT INTO `stock__report` SET
            `product_token`='$token',
            `sales_stock`='0',
            `opening_stock`='0',
            `closing_stock`='0',
            `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function insert($indiaDate)
    {
        $query = "INSERT INTO `stock__report` SET
            `product_token`=:token,
            `sales_stock`='0',
            `opening_stock`=:stock,
            `closing_stock`='0',
            `date`='$indiaDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->productToken);
        $stmt->bindParam('stock', $this->stockInHand);
        return $stmt->execute();
    }

    public function updateStock($stockValue)
    {
        $query = "UPDATE `stock__admin` SET `stock_in_hand`='$stockValue' WHERE `product_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function check_log()
    {
        $query = "SELECT * FROM `adminStockLog` WHERE `product_token` = ? AND `status` = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function updatestocksDistributor()
    {
        $query = "UPDATE `stock__distributor` SET `stock_in_hand`=?,`mfs`=? WHERE `product_token`=? AND `employee_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->stocks);
        $stmt->bindParam(2, $this->mfscount);
        $stmt->bindParam(3, $this->token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    public function updateProduct()
    {
        $query = "UPDATE `products` SET 
            `category_token`=:category_token,
            `item_code`=:item_code,
            `name`=:name,
            `name_short`=:product_name_short,
            `hsn_code`=:hsn_code,
            `image`=:image,
            `gst`=:gst,
            `mrp`=:mrp,
            `total_cost`=:total_cost,
            `retailer_price`=:retailer_price,
            `piece_count`=:piece_count,
            `batch_number`=:batch_number,
            `net_weight`=:net_weight,
            `additional_offer`='',
            `location`=:location,
            `description`=:description
        WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('item_code', $this->productCode);
        $stmt->bindParam('name', $this->productName);
        $stmt->bindParam('image', $this->productImage);
        $stmt->bindParam('gst', $this->productGst);
        $stmt->bindParam('mrp', $this->productMrp);
        $stmt->bindParam('total_cost', $this->productTotalCost);
        $stmt->bindParam('retailer_price', $this->retailerPrice);
        $stmt->bindParam('piece_count', $this->productPieceCount);
        $stmt->bindParam('batch_number', $this->productBatchNumber);
        $stmt->bindParam('net_weight', $this->productWeight);
        $stmt->bindParam('location', $this->productLocation);
        $stmt->bindParam('description', $this->productDescription);
        $stmt->bindParam('product_name_short', $this->product_name_short);
        $stmt->bindParam('hsn_code', $this->hsn_code);
        $stmt->bindParam('category_token', $this->productType);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function fetchDetails()
    {
        $query = "SELECT * FROM `products` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function readfetchDetails($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->product_name = $row['name'];
            $obj->item_code = $row['item_code'];
            $obj->net_weight = $row['net_weight'];
            $obj->mrp = $row['mrp'];
            $obj->total_cost = $row['total_cost'];
            $obj->piece_count = $row['piece_count'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function updateProductLog($indiaDateTime)
    {
        $query = "INSERT INTO `product_log` SET 
            `date_time`='$indiaDateTime',
            `product_token`=:token,
            `old_productname`=:productname,
            `new_productname`=:name,
            `old_item_code`=:itemcode,
            `new_item_code`=:item_code,
            `old_mrp`=:old_mrp,
            `new_mrp`=:mrp,
            `old_total_cost`=:totalcost,
            `new_total_cost`=:total_cost,
            `old_piece_count`=:piececount,
            `new_piece_count`=:piece_count,
            `old_net_weight`=:netweight,
            `new_net_weight`=:net_weight,
            `created_by`=:admin_token,
            `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('productname', $this->productname);
        $stmt->bindParam('name', $this->productName);
        $stmt->bindParam('itemcode', $this->itemcode);
        $stmt->bindParam('item_code', $this->productCode);
        $stmt->bindParam('old_mrp', $this->old_mrp);
        $stmt->bindParam('mrp', $this->productMrp);
        $stmt->bindParam('totalcost', $this->totalcost);
        $stmt->bindParam('total_cost', $this->productTotalCost);
        $stmt->bindParam('piececount', $this->piececount);
        $stmt->bindParam('piece_count', $this->productPieceCount);
        $stmt->bindParam('netweight', $this->netweight);
        $stmt->bindParam('net_weight', $this->productWeight);
        $stmt->bindParam('admin_token', $this->admin_token);
        return $stmt->execute();
    }

    public function divisionCheck()
    {
        $query = "SELECT `id` FROM `products__category`
        WHERE `delete_status`='1'
        ORDER BY `products__category`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function serverDivisionCheck()
    {
        $rowStart = $this->rowStart;
        $rowperpage = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $columnName = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `token`,`name`,(SELECT GROUP_CONCAT(`name` SEPARATOR ', ') FROM `products` WHERE `category_token` = `products__category`.`token` AND `delete_status` = '1') as product_list FROM `products__category`
        WHERE 1
        $searchQuery
        AND `delete_status`='1'
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function divisionCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $query = "SELECT `products__category`.`id`
        FROM `products__category`
        WHERE 1
        AND `delete_status`='1'
        $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readDivision($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $data[] = array(
                "division_token" => $row['token'],
                "sl_no" => $slno,
                "division_name" => $row['name'],
                "product_list" => $row['product_list'],
                "action" => '<a><img src="assets/edit.png" class="edit_input item_code_edit" alt=""></a>',
                "delete" => '<a href="javascript:void(0)" style="color:red !important;" class="division_delete">Delete</a>',
            );
        }
        return $data;
    }

    public function divisionCheckAll()
    {
        $query = "SELECT `token`,`name` FROM `products__category`
        WHERE `delete_status`='1'
        ORDER BY `products__category`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readDivisionAll($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->division_token = $row['token'];
            $obj->division_name = $row['name'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function division_products($division_token)
    {
        $tokens = implode(',', array_map('intval', (array)$division_token));
        if (empty($tokens)) $tokens = "''";
        $query = "SELECT `token` AS products_token,`name` AS products_name FROM `products`
        WHERE `delete_status`='1' AND category_token IN ($tokens)
        ORDER BY `products`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function division_products_read($stmt1)
    {
        $array = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->products_token = $row['products_token'];
            $obj->products_name = $row['products_name'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function productCheckAll()
    {
        $query = "SELECT `token`,`name` FROM `products`
        WHERE `delete_status`='1'
        ORDER BY `products`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readProductAll($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row['token'];
            $obj->name = $row['name'];
            array_push($array, $obj);
        }
        return $array;
    }

    // 💡 500 Error Fix 1: Guarded against empty Division Tokens + Safe SELECT
    public function selectDivision()
    {
        $divisionToken = $this->divisionToken;
        if(empty($divisionToken)) {
            $divisionToken = "''";
        }
        $query = "SELECT `token`,`name`, COALESCE(`delete_status`, 1) AS `delete_status` FROM `products` WHERE `category_token` IN ($divisionToken) ORDER BY delete_status ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 💡 500 Error Fix 2: Re-added the missing function that singleDivisionDetails.php looks for!
    public function selectDivision_for_distributorPurchaseReport()
    {
        $divisionToken = $this->divisionToken;
        if(empty($divisionToken)) {
            $divisionToken = "''";
        }
        $query = "SELECT `token`,`name`, COALESCE(`delete_status`, 1) AS `delete_status` FROM `products` WHERE `category_token` IN ($divisionToken) AND `delete_status`='2'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function fetchDivision($stmt)
    {
        $dist = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row["token"];
            $obj->name = $row["name"];
            $obj->delete_status = isset($row["delete_status"]) ? $row["delete_status"] : '1';
            array_push($dist, $obj);
        }
        return $dist;
    }

    public function singleDivisionCheck()
    {
        $query = "SELECT `token`,`name` FROM `products__category`
        WHERE `delete_status`='1'
        AND `products__category`.`token`=?
        ORDER BY `products__category`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->divisionToken);
        $stmt->execute();
        return $stmt;
    }

    public function addDivisionCheck()
    {
        $this->divisionName = htmlspecialchars(strip_tags($this->divisionName));
        $query = "SELECT `id` FROM `products__category` WHERE `name`=:name and delete_status='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->execute();
        return $stmt;
    }

    public function updateDivisionCheck()
    {
        $this->divisionName = htmlspecialchars(strip_tags($this->divisionName));
        $query = "SELECT `id`
        FROM `products__category`
        WHERE ( `name`=:name AND `token`!=:token )";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function addDivision($indiaDateTime)
    {
        $query = "INSERT INTO `products__category` SET 
            `date_time`='$indiaDateTime',
            `token`=:token,
            `name`=:name,
            `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->execute();
        return $stmt;
    }

    public function addDivisionLog($indiaDateTime)
    {
        $query = "INSERT INTO `division_log` SET 
            `date_time`='$indiaDateTime',
            `division_token`=:token,
            `before_division`=:name,
            `after_division`=:name,
            `created_by`=:admin_token,
            `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    public function divisionName()
    {
        $query = "SELECT `name` FROM `products__category` WHERE token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        $row1 = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row1 ? $row1['name'] : '';
    }

    public function divisionNameDel()
    {
        $query = "SELECT `name` FROM `products__category` WHERE token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->divisionToken);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['name'] : '';
    }

    public function deleteDivisionLog($indiaDateTime)
    {
        $query = "INSERT INTO `division_log` SET 
            `date_time`='$indiaDateTime',
            `division_token`=:divisionToken,
            `before_division`=:division,
            `after_division`=:division,
            `created_by`=:admin_token,
            `delete_status`='2'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('divisionToken', $this->divisionToken);
        $stmt->bindParam('division', $this->division);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    public function updateDivisionLog($indiaDateTime)
    {
        $query = "INSERT INTO `division_log` SET 
            `date_time`='$indiaDateTime',
            `division_token`=:token,
            `before_division`=:division,
            `after_division`=:name,
            `created_by`=:admin_token,
            `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('division', $this->division);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    public function updateDivision()
    {
        $query = "UPDATE `products__category` SET `name`=:name WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('name', $this->divisionName);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function getStatus()
    {
        $query = "SELECT `token`, `name`, `active_status` FROM `admin_controls`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function viewStatus($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->control_token = $row['token'];
            $obj->control_name = $row['name'];
            $obj->active_status = $row['active_status'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function updateStatus()
    {
        $query = "UPDATE `admin_controls` SET `active_status`=:status where `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('status', $this->status);
        $stmt->bindParam('token', $this->token);
        return $stmt->execute();
    }

    public function productCheckToken()
    {
        $query = "SELECT `id` FROM `products` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function fetchDetail()
    {
        $query = "SELECT * FROM `products` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->productToken);
        $stmt->execute();
        return $stmt;
    }

    public function readfetchDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->product_name = $row['name'];
            $obj->item_code = $row['item_code'];
            $obj->net_weight = $row['net_weight'];
            $obj->mrp = $row['mrp'];
            $obj->total_cost = $row['total_cost'];
            $obj->piece_count = $row['piece_count'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function deleteProductLog($indiaDateTime)
    {
        $query = "INSERT INTO `product_log` SET 
            `date_time`='$indiaDateTime',
            `product_token`=:token,
            `old_productname`=:productname,
            `new_productname`=:productname,
            `old_item_code`=:itemcode,
            `new_item_code`=:itemcode,
            `old_mrp`=:old_mrp,
            `new_mrp`=:old_mrp,
            `old_total_cost`=:totalcost,
            `new_total_cost`=:totalcost,
            `old_piece_count`=:piececount,
            `new_piece_count`=:piececount,
            `old_net_weight`=:netweight,
            `new_net_weight`=:netweight,
            `created_by`=:admin_token,
            `delete_status`='2'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->productToken);
        $stmt->bindParam('productname', $this->productname);
        $stmt->bindParam('itemcode', $this->itemcode);
        $stmt->bindParam('old_mrp', $this->old_mrp);
        $stmt->bindParam('totalcost', $this->totalcost);
        $stmt->bindParam('piececount', $this->piececount);
        $stmt->bindParam('netweight', $this->netweight);
        $stmt->bindParam('admin_token', $this->admin_token);
        return $stmt->execute();
    }

    public function productStatusUpdate()
    {
        $query = "UPDATE `products` SET `delete_status`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->statusValue);
        $stmt->bindParam(2, $this->productToken);
        $stmt->execute();
        return true;
    }

    public function addProductScheme($indiaDateTime)
    {
        $token = $this->token;
        $buy_product_box = $this->buy_product_box;
        $get_product_box = $this->get_product_box;
        $additional_offer = $this->additional_offer;
        $product_token = $this->product_token;
        $differproducttoken = $this->differproducttoken;
        $from_date = $this->from_Date;
        $to_date = $this->to_Date;
        $date = $indiaDateTime;
        $is_scheme = 1;
        $scheme_image = $this->scheme_image;
        $inserts = [];
        $inserts[] = "('$token','$product_token','$additional_offer','$buy_product_box','$get_product_box','$differproducttoken','$from_date','$to_date','$is_scheme','$date','$scheme_image')";
        $query = "INSERT INTO `products__scheme`(`token`,`product_token`,`scheme_name`,`limit_box`,`free_box`,`free_product`,`start_date`,`end_date`,`is_scheme`,`date_time`,`image`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function readProductDetails()
    {
        $query21 = "SELECT
            `products__scheme`.`product_token`,
            `products__scheme`.`scheme_name`,
            `products__scheme`.`limit_box`,
            `products__scheme`.`free_box`,
            `products__scheme`.`start_date`,
            `products__scheme`.`end_date`,
            `products__scheme`.`is_scheme`,
            `products__scheme`.`date_time`,
            `products`.`name` AS `free_product`
        FROM `products__scheme`
        INNER JOIN `products` ON `products__scheme`.`free_product` = `products`.`token`
        WHERE `products__scheme`.`product_token` = ? AND `products__scheme`.`is_scheme` = '1'";
        $stmt = $this->conn->prepare($query21);
        $stmt->bindParam(1, $this->product_token);
        $stmt->execute();
        return $stmt;
    }

    public function readProductDetailsData($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->product_token = $row["product_token"];
            $obj->scheme_name = $row["scheme_name"];
            $obj->limit_box = $row["limit_box"];
            $obj->free_box = $row["free_box"];
            $obj->start_date = date("d/m/Y", strtotime($row["start_date"]));
            $obj->end_date = date("d/m/Y", strtotime($row["end_date"]));
            $obj->is_scheme = $row["is_scheme"];
            $obj->free_product = $row["free_product"];
            array_push($array, $obj);
        }
        return $array;
    }

    public function productListPdf()
    {
        $query = "SELECT `products`.`token`,
            `products`.`item_code`,
            `products`.`name`,
            `products__category`.`name` AS `type`,
            `products`.`total_cost`,
            `products`.`mrp`,
            `products`.`piece_count`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token` 
        WHERE `products`.`delete_status`='1' ORDER BY products.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function deactivate_scheme()
    {
        $product_token = $this->product_token;
        $token = join("','", (array)$product_token);
        $query = "UPDATE `products__scheme`
                  SET `is_scheme` = '0'
                  WHERE `product_token` IN ('$token') AND `is_scheme` = '1'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function stack_total_amount()
    {
        $query = "SELECT
            stock__distributor.product_token,
            stock__distributor.stock_in_hand,
            products.total_cost,
            products.piece_count,
            SUM(
                CASE WHEN stock__distributor.stock_in_hand > 0 THEN stock__distributor.stock_in_hand *(
                    products.total_cost * products.piece_count
                ) ELSE 0
                END
            ) AS total
        FROM stock__distributor
        JOIN products ON stock__distributor.product_token = products.token
        WHERE stock__distributor.employee_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    public function divisionAssignCheck()
    {
        $query = "SELECT `products__category`.`token` FROM `products__category` INNER JOIN `products` ON `products__category`.`token`=`products`.`category_token` WHERE `products__category`.`token`=? GROUP BY `products__category`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->divisionToken);
        $stmt->execute();
        return $stmt;
    }

    public function deleteDivision()
    {
        $query = "UPDATE `products__category` SET `delete_status`='2' WHERE token=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->divisionToken);
        $stmt->execute();
        return $stmt;
    }

    public function schemeList()
    {
        $query = "SELECT `products__scheme`.`token`, `products__scheme`.`product_token`,
            `products`.`name`,
            `products__scheme`.`scheme_name`,
            `products__scheme`.`limit_box`,
            `products__scheme`.`free_box`,
            `products__scheme`.`image`,
            `products__scheme`.`free_product` AS `free_token`,
            `free_product`.`name` AS `free_product`,
            CONCAT(DATE(`products__scheme`.`start_date`), ' to ', DATE(`products__scheme`.`end_date`)) AS `Date_Range`
        FROM `products__scheme`
        INNER JOIN `products` ON `products__scheme`.`product_token` = `products`.`token`
        INNER JOIN `products` AS `free_product` ON `free_product`.`token` = `products__scheme`.`free_product`
        WHERE `products__scheme`.`is_scheme` = '1'
        ORDER BY `products__scheme`.`date_time` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readschemeList($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->product_token = $row["product_token"];
            $obj->product_name = $row["name"];
            $obj->scheme_name = $row["scheme_name"];
            $obj->limit_box = $row["limit_box"];
            $obj->free_box = $row["free_box"];
            $obj->image = $row["image"];
            $obj->free_product_token = $row["free_token"];
            $obj->free_product = $row["free_product"];
            $obj->Date_Range = $row['Date_Range'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function schemeDist()
    {
        $query = "SELECT  
            `products__category`.`token`,
            `products__category`.`name` AS `cat_name`,
            `products__scheme`.`product_token`,
            `products`.`name`,
            `products__scheme`.`scheme_name`,
            `products__scheme`.`limit_box`,
            `products__scheme`.`free_box`,
            COALESCE(NULLIF(`products__scheme`.`image`, ''), `products`.`image`) AS `image`,
            `free_product`.`name` AS `free_product`
        FROM `products__scheme`
        INNER JOIN `products` ON `products__scheme`.`product_token` = `products`.`token`
        INNER JOIN `products` AS `free_product` ON `free_product`.`token` = `products__scheme`.`free_product`
        INNER JOIN products__category ON products__category.`token` = products.category_token
        WHERE `products__scheme`.`is_scheme` = '1'
        ORDER BY `products__scheme`.`date_time` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readschemeDist($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->product_token = $row["product_token"];
            $obj->product_name = $row["name"];
            $obj->scheme_name = $row["scheme_name"];
            $obj->cat_name = isset($row["cat_name"]) ? $row["cat_name"] : '';
            $obj->limit_box = $row["limit_box"];
            $obj->free_box = $row["free_box"];
            $obj->image = $row["image"];
            $obj->free_product = $row["free_product"];
            array_push($array, $obj);
        }
        return $array;
    }

    public function singleSchemeCheck($indiaDate)
    {
        $query = "SELECT `scheme_name`,`limit_box`,`free_box`,`start_date`,`end_date` FROM `products__scheme` WHERE `product_token`=? AND `free_product`=? AND `token`=?  AND `is_scheme`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->product_token);
        $stmt->bindParam(2, $this->free_token);
        $stmt->bindParam(3, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function readsingleSchemeCheck($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->scheme_name = $row["scheme_name"];
            $obj->limit_box = $row["limit_box"];
            $obj->free_box = $row["free_box"];
            $obj->start_date = $row["start_date"];
            $obj->end_date = $row["end_date"];
            array_push($array, $obj);
        }
        return $array;
    }

    public function updateScheme($indiaDate)
    {
        $query = "UPDATE `products__scheme` SET `scheme_name`=?,`limit_box`=?,`free_box`=?,`start_date`=?,`end_date`=? WHERE `product_token`=? AND `free_product`=? AND `token`=? AND date(date_time)='$indiaDate' AND `is_scheme`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->scheme_name);
        $stmt->bindParam(2, $this->buy_product_box);
        $stmt->bindParam(3, $this->get_product_box);
        $stmt->bindParam(4, $this->fromStatDateScheme);
        $stmt->bindParam(5, $this->toEndDateScheme);
        $stmt->bindParam(6, $this->product_token);
        $stmt->bindParam(7, $this->free_token);
        $stmt->bindParam(8, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function schemeCheck($token)
    {
        $query = "SELECT `id` FROM `products__scheme` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function deleteScheme($token)
    {
        $query = "UPDATE `products__scheme` SET `is_scheme`='0',`admin_tokens`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->admin_tokens);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function itemoverallReport()
    {
        $divisionQuery = $this->divisionQuery;
        $dateQuery = $this->dateQuery;
        $query = "SELECT
            products.token,
            products.name,
            SUM(orders__items.quantity) AS `total_quantity`,
            (orders__items.price_per_unit * orders__items.piece_count) AS total_piece,
            SUM(orders__items.offer_amount) AS total_amount,
            SUM(orders__items.offer_percentage) AS discount
        FROM `orders__items`
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN orders ON orders__items.order_token = orders.token
        WHERE orders__items.is_free != 1 AND `orders`.`delivery`='Completed' AND `products`.`delete_status`='1' $divisionQuery $dateQuery
        GROUP BY products.token";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 💡 500 Error Fix 3: Protected against empty tokens in particular division
    public function partculoar_division_product($divisionToken)
    {
        if(empty($divisionToken)) {
            $divisionToken = "''";
        }
        $query = "SELECT token, name FROM `products` WHERE category_token IN ($divisionToken)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function partculoar_division_product_read($division_data)
    {
        $array = [];
        while ($row = $division_data->fetch(PDO::FETCH_ASSOC)) {
            $obj_product = new stdClass();
            $obj_product->token = $row["token"];
            $obj_product->name = $row["name"];
            array_push($array, $obj_product);
        }
        return $array;
    }

    public function readitemoverallReport($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->token = $row["token"];
            $obj->name = $row["name"];
            $obj->total_quantity = $row["total_quantity"];
            $obj->total_piece = round($row["total_piece"]);
            $obj->total_amount = round($row["total_amount"]);
            $obj->discount = $row['discount'];
            array_push($array, $obj);
        }
        return $array;
    }

    public function totalsales()
    {
        $query = "SELECT
            SUM(orders__items.price_per_unit * orders__items.piece_count * orders__items.quantity) AS total_amount
        FROM `orders__items`
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN orders ON orders__items.order_token = orders.token
        WHERE orders__items.is_free != 1 AND `orders`.`delivery` = 'Completed' AND `products`.`delete_status` = '1' AND DATE(`orders__items`.`date_time`) BETWEEN '2024-01-01' AND '2024-01-17'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total_amount'] : 0;
    }

    public function stateWise()
    {
        $from_date = $this->from_date;
        $to_date = $this->to_date;
        $state = $this->state;
        $query = "SELECT
            `products__category`.`name`,
            `employees__state`.`state_name`,
            COALESCE(SUM(orders__items.quantity),0) AS `total_quantity`,
            COALESCE(SUM(orders__items.price_per_unit * orders__items.quantity*orders__items.piece_count),0)AS `total_amount`
        FROM orders__items
        RIGHT JOIN products ON orders__items.product_token = products.token
        INNER JOIN products__category ON products__category.token = products.category_token
        INNER JOIN orders ON orders.token = orders__items.order_token
        INNER JOIN employees ON employees.token = orders.employee_token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        WHERE (date(`orders__items`.`date_time`) BETWEEN '$from_date' AND '$to_date') $state AND orders__items.is_free != '1' AND orders.delivery = 'Completed'
        GROUP BY products__category.token,employees__state.state_token";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readstateWise($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->name = $row["name"];
            $obj->state_name = $row["state_name"];
            $obj->total_quantity = round($row["total_quantity"]);
            $obj->total_amount = round($row["total_amount"]);
            array_push($array,$obj);
        }
        return $array;
    }

    public function stateSales()
    {
        $from_date =$this->from_date;
        $to_date   =$this->to_date;
        $delivery_filter = "orders.delivery <> 'Cancelled'";

        $query = "SELECT
            `products__category`.`name` AS `division_name`,
            COALESCE(NULLIF(TRIM(`employees__state`.`state_name`), ''), 'NO STATE') AS `state_name`,
            SUM(`orders__items`.`quantity`) AS `total_quantity`,
            SUM(`orders__items`.`quantity` * `orders__items`.`price_per_unit` * `orders__items`.`piece_count`) AS `total_price`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token` = `products`.`category_token`
        INNER JOIN `orders__items`      ON `orders__items`.`product_token` = `products`.`token`
        INNER JOIN `orders`             ON `orders`.`token` = `orders__items`.`order_token`
        LEFT JOIN `shop_mapping`        ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop`                ON `shop`.`token` = COALESCE(`shop_mapping`.`shop_token`, `orders`.`shop_token`)
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token`
        LEFT JOIN `employees` AS `sales_man`   ON `sales_man`.`token`   = `orders`.`employee_token`
        LEFT JOIN `employees__state` ON `employees__state`.`state_token` = NULLIF(NULLIF(NULLIF(UPPER(TRIM(CASE
            WHEN `orders`.`order_type` = 'Distributor Order'
                 THEN COALESCE(NULLIF(TRIM(`distributor`.`state_id`), ''), NULLIF(TRIM(`shop`.`state_id`), ''), NULLIF(TRIM(`sales_man`.`state_id`), ''))
            ELSE COALESCE(NULLIF(TRIM(`shop`.`state_id`), ''), NULLIF(TRIM(`distributor`.`state_id`), ''), NULLIF(TRIM(`sales_man`.`state_id`), ''))
        END)), ''), '0'), 'EMPTY')
        WHERE $delivery_filter
          AND `products`.`delete_status` = '1'
          AND DATE(`orders__items`.`date_time`) BETWEEN '$from_date' AND '$to_date'
        GROUP BY `products__category`.`name`, COALESCE(NULLIF(TRIM(`employees__state`.`state_name`), ''), 'NO STATE')
        ORDER BY `products__category`.`name` ASC";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }

    public function readstateSales($stmt)
    {
        $array = [];
        $rows  =$stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT TRIM(`state_name`) AS `state_name` FROM `employees__state`
                  WHERE `state_token` NOT IN ('0','97467334')
                    AND `state_name` NOT LIKE 'All State%'
                    AND `state_name` NOT LIKE '%Abirami%'
                  ORDER BY `state_name`";
        $stmt1 =$this->conn->prepare($query);$stmt1->execute();
        $masterStates = array_column($stmt1->fetchAll(PDO::FETCH_ASSOC), 'state_name');

        $divisions = [];$keys      = [];
        foreach ($rows as$row) {
            $div   =$row['division_name'];
            $sname = trim((string)$row['state_name']);
            if ($sname === '') {$sname = 'NO STATE';
            }
            $key = strtoupper($sname);

            if (!isset($divisions[$div])) {
                $divisions[$div] = [];
            }
            if (isset($divisions[$div][$key])) {
                $divisions[$div][$key]['total_quantity'] += (float)$row['total_quantity'];
                $divisions[$div][$key]['total_price']    += (float)$row['total_price'];
            } else {
                $divisions[$div][$key] = [
                    'total_quantity' => (float) $row['total_quantity'],
                    'total_price'    => (float) $row['total_price']
                ];
            }
            if (!isset($keys[$key])) {$keys[$key] =$sname;
            }
        }

        $columns = [];
        foreach ($masterStates as $s) {$columns[strtoupper(trim($s))] = trim($s);
        }
        foreach ($keys as $key =>$display) {
            if (!isset($columns[$key])) {$columns[$key] =$display;
            }
        }

        foreach ($divisions as$div => $vals) {$obj       = new stdClass();
            $obj->name =$div;
            $stateArr  = [];
            foreach ($columns as$key => $display) {$o        = new stdClass();
                $o->state =$display;
                if (isset($vals[$key])) {
                    $o->total_quantity = round($vals[$key]['total_quantity']);$o->total_price    = round($vals[$key]['total_price']);
                } else {
                    $o->total_quantity = '';$o->total_price    = '';
                }
                $stateArr[] =$o;
            }
            $obj->state =$stateArr;
            $array[]    =$obj;
        }
        return $array;
    }

    public function overallsalesValue()
    {
        $from_date =$this->from_date;
        $to_date   =$this->to_date;
        $state     = isset($this->state) ? $this->state : '';$delivery_filter = "orders.delivery <> 'Cancelled'";

        $query = "SELECT
            SUM(`orders__items`.`quantity`) AS `overallQuantity`,
            SUM(`orders__items`.`quantity` * `orders__items`.`price_per_unit` * `orders__items`.`piece_count`) AS `overallPrice`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token` = `products`.`category_token`
        INNER JOIN `orders__items`      ON `orders__items`.`product_token` = `products`.`token`
        INNER JOIN `orders`             ON `orders`.`token` = `orders__items`.`order_token`
        LEFT JOIN `shop_mapping`        ON `shop_mapping`.`token` = `orders`.`shop_token`
        LEFT JOIN `shop`                ON `shop`.`token` = COALESCE(`shop_mapping`.`shop_token`, `orders`.`shop_token`)
        LEFT JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token`
        LEFT JOIN `employees` AS `sales_man`   ON `sales_man`.`token`   = `orders`.`employee_token`
        LEFT JOIN `employees__state` ON `employees__state`.`state_token` = NULLIF(NULLIF(NULLIF(UPPER(TRIM(CASE
            WHEN `orders`.`order_type` = 'Distributor Order'
                 THEN COALESCE(NULLIF(TRIM(`distributor`.`state_id`), ''), NULLIF(TRIM(`shop`.`state_id`), ''), NULLIF(TRIM(`sales_man`.`state_id`), ''))
            ELSE COALESCE(NULLIF(TRIM(`shop`.`state_id`), ''), NULLIF(TRIM(`distributor`.`state_id`), ''), NULLIF(TRIM(`sales_man`.`state_id`), ''))
        END)), ''), '0'), 'EMPTY')
        WHERE $delivery_filter
          AND `products`.`delete_status` = '1'
          AND DATE(`orders__items`.`date_time`) BETWEEN '$from_date' AND '$to_date'$state";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        $row =$stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass();$obj->overallquantity = $row ? $row['overallQuantity'] : 0;
        $obj->overallsales    = $row ? round($row['overallPrice']) : 0;
        return $obj;
    }

    public function regionWise()
    {
        $from_date =$this->from_date;
        $to_date =$this->to_date;
        $state =$this->state;
        $region =$this->region;
        $query = "SELECT
            `products__category`.`name`,
            `region`.`region_name`,
            COALESCE(SUM(orders__items.quantity)) AS `total_quantity`,
            SUM(orders__items.price_per_unit * orders__items.quantity*orders__items.piece_count)AS `total_amount`
        FROM orders__items
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN products__category ON products__category.token = products.category_token
        INNER JOIN orders ON orders.token = orders__items.order_token
        INNER JOIN employees ON employees.token = orders.employee_token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        INNER JOIN region ON region.token = employees.region_id
        WHERE employees.state_id IN (" . implode(',', (array)$state) . ") AND employees.region_id IN (" . implode(',', (array)$region) . ") AND (date(`orders__items`.`date_time`) BETWEEN '$from_date' AND '$to_date') AND orders__items.is_free != '1' AND orders.delivery = 'Completed'
        GROUP BY products__category.token,employees__state.state_token";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }

    public function readregionWise($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {$obj = new stdClass();
            $obj->name =$row["name"];
            $obj->region_name =$row["region_name"];
            $obj->total_quantity = round($row["total_quantity"]);
            $obj->total_amount = round($row["total_amount"]);
            array_push($array,$obj);
        }
        return $array;
    }

    public function overallWise()
    {
        $from_date =$this->from_date;
        $to_date =$this->to_date;
        $state =$this->state;
        $region =$this->region;
        $division =$this->division;
        $product =$this->product;
        $query1 = "SELECT
            `products__category`.`name`,
            `products__category`.`token`,
            `products`.`name` AS `product_name`,
            `products`.`token` AS `product_token`,
            `employees__state`.`state_name`,
            `region`.`region_name`,
            COALESCE(SUM(orders__items.quantity)) AS `total_quantity`,
            SUM(orders__items.price_per_unit * orders__items.quantity*orders__items.piece_count)AS `total_amount`
        FROM orders__items
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN products__category ON products__category.token = products.category_token
        INNER JOIN orders ON orders.token = orders__items.order_token
        INNER JOIN employees ON employees.token = orders.employee_token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        INNER JOIN region ON region.token = employees.region_id
        WHERE employees.state_id IN (" . implode(',', (array)$state) . ") AND employees.region_id IN (" . implode(',', (array)$region) . ") AND products__category.token IN (" . implode(',', (array)$division) . ") AND products.token IN (" . implode(',', (array)$product) . ") AND (date(`orders__items`.`date_time`) BETWEEN '$from_date' AND '$to_date') AND orders__items.is_free != '1' AND orders.delivery = 'Completed'
        GROUP BY products__category.token,orders__items.product_token,employees__state.state_token";
        $stmt1 =$this->conn->prepare($query1);$stmt1->execute();
        return $stmt1;
    }

    public function readoverallWise($stmt1)
    {
        $array1 = [];
        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {$obj1 = new stdClass();
            $obj1->division_token =$row1["token"];
            $obj1->name =$row1["name"];
            $obj1->product_name =$row1["product_name"];
            $obj1->product_token =$row1["product_token"];
            $obj1->state_name =$row1["state_name"];
            $obj1->region_name =$row1["region_name"];
            $obj1->total_quantity = round($row1["total_quantity"]);
            $obj1->total_amount = round($row1["total_amount"]);
            array_push($array1,$obj1);
        }
        return $array1;
    }

    // 💡 500 Error Fix 4: Protected against empty Array mapping
    public function partculoar_division_product1()
    {
        $division =$this->division;
        $tokens = implode(',', array_map('intval', (array)$division));
        if(empty($tokens)) {$tokens = "''";
        }
        $query1 = "SELECT
            products.category_token AS division_token,
            products__category.name AS name,
            products.token AS product_token,
            products.name AS product_name
        FROM `products`
        INNER JOIN products__category ON products__category.token = products.category_token
        WHERE products.category_token IN ($tokens) AND products__category.delete_status = '1'";
        $stmt1 =$this->conn->prepare($query1);$stmt1->execute();
        return $stmt1;
    }

    public function partculoar_division_product1_read($stmt3)
    {
        $array = [];
        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {$obj_product = new stdClass();
            $obj_product->division_token =$row["division_token"];
            $obj_product->name =$row["name"];
            $obj_product->product_token =$row["product_token"];
            $obj_product->product_name =$row["product_name"];
            array_push($array,$obj_product);
        }
        return $array;
    }

    public function distributor_salesStock()
    {
        $dateQuery =$this->dateQuery;
        $dataQuery =$this->dataQuery;
        $query = "SELECT
            distributor.name AS distributor,
            products.name,
            SUM(CASE WHEN orders__items.units='Box' THEN orders__items.quantity * orders__items.piece_count ELSE orders__items.quantity END) AS `total_quantity`,
            (orders__items.price_per_unit * orders__items.piece_count) AS total_piece,
            SUM(orders__items.offer_amount) AS total_amount
        FROM `orders__items`
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN orders ON orders__items.order_token = orders.token
        INNER JOIN `employees` AS `salesman` ON `orders`.`employee_token` = `salesman`.`token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token` = `orders`.`distributor_token`
        INNER JOIN `employees__state` ON `distributor`.`state_id` = `employees__state`.`state_token`
        WHERE `orders`.`delivery`!='Cancelled' AND orders__items.is_free != '1' AND `orders`.`order_type`!='Distributor Order' AND orders__items.delete_status='1' $dateQuery$dataQuery
        GROUP BY products.token";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }

    public function readdistributor_salesStock($stmt)
    {
        $array1 = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {$obj1 = new stdClass();
            $obj1->distributor_name =$row1["distributor"];
            $obj1->product_name =$row1["name"];
            $obj1->total_piece = round($row1["total_piece"]);
            $obj1->total_quantity = round($row1["total_quantity"]);
            $obj1->total_amount = round($row1["total_amount"]);
            array_push($array1,$obj1);
        }
        return $array1;
    }

    function schemeSameMsg($product_name, $buy_product_box,$get_product_box)
    {
        $mobile_number = 9787808084;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apii.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"65fbb11ad6fc0576035d72f2\",\n  \"sender\": \"ASWSMS\",\n  \"mobiles\": \"91$mobile_number\",\n  \"name\": \"$product_name\",\n  \"buy\": \"$buy_product_box\",\n \"get\":\"$get_product_box\"\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 380803AF0dsqJz8g62f75785P1",
                "content-type: application/json"
            ],
        ]);
        curl_exec($curl);
        curl_close($curl);
    }

    function schemedifferMsg($product_name,$buy_product_box, $get_product_box,$differproductname)
    {
        $mobile_number = 9360957658;
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apii.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"65fbf717d6fc054a521038a3\",\n  \"sender\": \"ASWSMS\",\n  \"mobiles\": \"91$mobile_number\",\n  \"name\": \"$product_name\",\n  \"buy\": \"$buy_product_box\",\n \"get\":\"$get_product_box\",\n \"differ\":\"$differproductname\"\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 380803AF0dsqJz8g62f75785P1",
                "content-type: application/json"
            ],
        ]);
        curl_exec($curl);
        curl_close($curl);
    }

    function distributorOrderReport($filters)
    {
        $query = "SELECT
            employees.name,
            products.name as product_name,
            products__category.name as category_name,
            SUM(orders__items.quantity) AS total_quantity,
            SUM(orders__items.offer_amount) AS total_amount
        FROM orders__items
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN products__category ON products__category.token = products.category_token
        INNER JOIN orders ON orders.token = orders__items.order_token
        INNER JOIN employees ON employees.token = orders.employee_token
        WHERE 1=1 $filters
          AND orders.order_type = 'Distributor Order' AND orders.delivery = 'Completed'
        GROUP BY products.token";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }

    function readOrderReport($stmt)
    {
        $array1 = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {$obj1 = new stdClass();
            $obj1->distributor_name =$row1["name"];
            $obj1->product_name =$row1["product_name"];
            $obj1->division_name =$row1["category_name"];
            $obj1->total_quantity = round($row1["total_quantity"]);
            $obj1->total_amount = round($row1["total_amount"]);
            array_push($array1,$obj1);
        }
        return $array1;
    }

    function distributorPurchaseReport($filters)
    {
        $query = "SELECT
            employees.name,
            products.name AS product_name,
            products__category.name AS category_name,
            region.region_name,
            employees__state.state_name,
            SUM(orders__items.quantity) AS total_quantity,
            SUM(
                CASE 
                    WHEN orders__items.units = 'Box' THEN orders__items.quantity * orders__items.piece_count * orders__items.price_per_unit 
                    ELSE orders__items.quantity * orders__items.price_per_unit
                END
            ) AS total_amount,
            DATE(orders.date_time) AS order_date,
            products.delete_status,
            products.date_time AS products_date
        FROM orders__items
        INNER JOIN products ON orders__items.product_token = products.token
        INNER JOIN products__category ON products__category.token = products.category_token
        INNER JOIN orders ON orders.token = orders__items.order_token
        INNER JOIN employees ON employees.token = orders.employee_token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        INNER JOIN region ON region.token = employees.region_id
        WHERE 1=1 $filters
          AND orders.delivery = 'Completed'
          AND orders.order_type = 'Distributor Order'
        GROUP BY 
            employees.token,
            products.token,
            DATE(orders.date_time)
        ORDER BY products.delete_status ASC";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }

    function readPurchaseReport($stmt)
    {
        $array1 = [];
        while ($row1 =$stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass();$obj1->order_date = isset($row1["order_date"]) ? $row1["order_date"] : '';
            $obj1->products_date = isset($row1["products_date"]) ? $row1["products_date"] : '';
            $obj1->delete_status = isset($row1["delete_status"]) ? $row1["delete_status"] : '1';
            $obj1->distributor_name =$row1["name"];
            $obj1->product_name =$row1["product_name"];
            $obj1->division_name =$row1["category_name"];
            $obj1->state =$row1['state_name'];
            $obj1->region =$row1['region_name'];
            $obj1->total_quantity = round($row1["total_quantity"]);
            $obj1->total_amount = round($row1["total_amount"]);
            array_push($array1,$obj1);
        }
        return $array1;
    }

    function stockalert()
    {
        $query = "SELECT `stock__admin`.`id`,
            `products`.`token`,
            `products`.`item_code`,
            `products`.`name`,
            `products__category`.`name` AS `type`,
            `products`.`delete_status`,
            COALESCE(`stock__admin`.`stock_in_hand`,0) AS `stock_in_hand`
        FROM `products`
        INNER JOIN `products__category` ON `products__category`.`token`=`products`.`category_token`
        LEFT JOIN `stock__admin` ON `stock__admin`.`product_token`=`products`.`token`
        WHERE products.delete_status = '1'";
        $stmt =$this->conn->prepare($query);$stmt->execute();
        return $stmt;
    }
}
?>