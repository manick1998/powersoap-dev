<?php
class Retailer
{

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    public function indianNumbeFormat($num)
    {
        return $num = preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $num);
    }
    function retailerDetail()
    {
        $query = "SELECT `shop`.`token` FROM `shop`
        WHERE `shop`.`delete_status`='1' AND `shop`.`distributor_token`= ? AND `shop`.`shop_type_code` != '0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function singleRetailer()
    {
        $query = "SELECT
        `shop`.`token` AS `shop_token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`slot`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`join_date`,
        `shop`.`license_number`,
        `shop`.`license_image`,
        `shop`.`address`,
        `shop`.`city`,
        `shop`.`pincode`,
        `shop`.`coordinates`,
        `shop`.`shop_type_code`,
        `shop`.`shop_show_status`
        FROM
            `shop`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        WHERE
        `shop`.`delete_status` = '1' AND `shop`.`token` = ? AND `shop_mapping`.`distributor_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->shop_token = (int)$row['shop_token'];
        $obj->shop_code  = $row['retail_code'];
        $obj->shop_name  = $row['retailer_name'];
        $obj->shop_type  = $row['shop_type'];
        $obj->slot  = $row['slot'];
        $obj->shop_mobile_number = $row['mobile_number'];
        $obj->contact_person  = $row['contact_person'] == "" ? "-" : $row['contact_person'];
        $obj->shop_join_date  = date("d/m/Y", strtotime($row['join_date']));
        $obj->license_number  = $row['license_number'];
        $obj->license_image  = $row['license_image'];
        $obj->address  = $row['address'];
        $obj->city = $row['city'];
        $obj->pincode = $row['pincode'];
        $obj->coordinates = $row['coordinates'];
        $obj->shop_type_code = $row['shop_type_code'];
        $obj->shop_show_status = $row['shop_show_status'];
        return $obj;
    }

    function checkRetailerMobileNumber()
    {
        $query = "SELECT `token`,`mobile_number` FROM `shop` WHERE `mobile_number`=? AND `mobile_number`!=''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->mobile_number);
        $stmt->execute();
        return $stmt;
    }
    function readcheckRetailer($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            //$obj = new stdClass;
            $token = $row['token'];
            $mobile  = $row['mobile_number'];
            // $obj->shop_count = $row['shop_count'];
            array_push($array, $token);
        }
        return $array;
    }
    function checkRetailerLicenseNumber()
    {
        $query = "SELECT `id` FROM `shop` WHERE `license_number`=? AND `license_number` !=''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->license_number);
        $stmt->execute();
        return $stmt;
    }
    function checkRetailerMobileNumberAlreadyExist()
    {
        $query = "SELECT `id` FROM `shop` WHERE `mobile_number`=? AND `mobile_number`!='' AND `token` not in (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->mobile_number);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function checkRetailerLicenseNumberAlreadyExist()
    {
        $query = "SELECT `id` FROM `shop` WHERE `license_number`=? AND `license_number` !='' AND `token` not in (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->license_number);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function addNewRetailer($indiaDateTime)
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $query = "INSERT INTO `shop` 
        SET `token`=:token,
        `name`=:name,
        `date_time`='$indiaDateTime',
        `retail_code`=:retail_code,
        `shop_type_code`=:shop_type_code,
        `slot`='',
        `mobile_number`=:mobile_number,
        `contact_person`=:contact_person,
        `join_date`='$indiaDateTime',
        `license_number`=:license_number,
        `license_image`=:license_image,
        `delete_status`='1',
        `address`=:address,
        `city`=:city,
        `state_id`=:state_token,
        `pincode`=:pincode,
        `coordinates`=:coordinates";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('retail_code', $this->retail_code);
        $stmt->bindParam('shop_type_code', $this->shop_type_code);
        //        $stmt->bindParam('slot_type', $this->slot_type);
        $stmt->bindParam('mobile_number', $this->mobile_number);
        $stmt->bindParam('contact_person', $this->contact_person);
        $stmt->bindParam('license_number', $this->license_number);
        $stmt->bindParam('license_image', $this->license_image);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('city', $this->city);
        $stmt->bindParam('state_token', $this->state_token);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('coordinates', $this->coordinates);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function add_shop_mapping($rondam1, $shop_token, $indiaDateTime)
    {
        $query1 = "INSERT INTO `shop_mapping` SET
            `token`='$rondam1',
            `shop_token`='$shop_token',
            `distributor_token`=:distributorToken,
            `unit_token`='',
            `date_time`='$indiaDateTime',
            `status`= '1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam('distributorToken', $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }

    function addNewRetailerOutstanding($rondam1, $indiaDateTime)
    {
        $query = "INSERT INTO `shop__outstanding`
       SET `date_time`='$indiaDateTime',
       `shop_token`='$rondam1',
       `bill_amount`='0',
       `paid_amt`='0',
       `total_outstanding`='0',
       `receiver_token`='0'";
        $stmt = $this->conn->prepare($query);
        //  $stmt->bindParam('token', $this->token); 
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function getShopTypeToken()
    {
        $query = "SELECT `token` FROM `shop__type` WHERE `name`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shopTypeName);
        $stmt->execute();
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = (int)$row['token'];
        return $token;
    }
    function updateRetailer()
    {
        $query = "UPDATE `shop` 
        SET `name`=:name,
        `shop_type_code`=:shop_type_code,
        `mobile_number`=:mobile_number,
        `contact_person`=:contact_person,
        `license_image`=:image,
        `address`=:address,
        `city`=:city,
        `pincode`=:pincode,
        `coordinates`=:coordinates,
        `license_number`=:license_number
        WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('name', $this->shopName);
        $stmt->bindParam('shop_type_code', $this->shopType);
        $stmt->bindParam('mobile_number', $this->mobile_number);
        $stmt->bindParam('contact_person', $this->contactPerson);
        $stmt->bindParam('image', $this->retailerImage);
        $stmt->bindParam('address', $this->shopAddress);
        $stmt->bindParam('city', $this->shopCity);
        $stmt->bindParam('pincode', $this->shopPincode);
        $stmt->bindParam('coordinates', $this->shopCoordinates);
        $stmt->bindParam('license_number', $this->license_number);
        $stmt->bindParam('token', $this->token);
        // $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function getShopType()
    {
        $query = "SELECT
        `token`,
        `name`
        FROM
        `shop__type`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->shop_type  = $row['name'];
            $obj->shop_token = (int)$row['token'];
            $query1 = "SELECT COUNT(*)as value FROM `shop` WHERE shop_type_code=$obj->shop_token";
            $stmt1 = $this->conn->prepare($query1);
            $stmt1->execute();
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $obj->value = $row['value'];
                array_push($array, $obj);
            }
        }
        return $array;
    }

    function shopTypeVerify()
    {
        $query = "SELECT `name` FROM `shop__type` WHERE `name`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->name);
        $stmt->execute();
        return $stmt;
    }

    function addShopType($indiaDateTime)
    {
        $query = "INSERT INTO `shop__type`
        SET `date_time`='$indiaDateTime',
       `token`=:token,
       `name`=:name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //addshopLog
    function addShopTypeLog($indiaDateTime)
    {
        $query = "INSERT INTO `shop_typeLog`
        SET `date_time`='$indiaDateTime',
       `token`=:token,
       `old_name`=:name,
       `new_name`='',
       `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }



    function updateShopType($indiaDateTime)
    {
        $query = "UPDATE `shop__type`
        SET `date_time` = '$indiaDateTime',
        `name` =:name 
        WHERE  `token` =:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('token', $this->token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // function updateShopTypecolumn(){
    //     $query = "UPDATE `shop_typeLog`
    //     SET `new_name` = ?, `status` = '2'
    //     WHERE `token` = ? AND  `status` = '1'";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(1,$this->name);
    //     $stmt->bindParam(2,$this->token);
    //     $stmt->execute();
    //     return $stmt;
    // }

    function updateShopTypeLog($indiaDateTime)
    {
        $query = "INSERT INTO `shop_typeLog`
        SET `date_time`='$indiaDateTime',
       `token`=:token,
       `old_name`=:old_name,
       `new_name`=:name,
       `created_by`=:admin_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('old_name', $this->old_name);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function retailerDetailCountCheck()
    {
        $unitQuery = $this->unitQuery;
        $query = "SELECT COUNT(DISTINCT `shop`.`token`) AS `total_count`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token`
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`distributor_token` = ? AND `shop`.`shop_type_code` != '0' $unitQuery AND `shop_mapping`.`status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function serverRetailerCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $unitQuery = $this->unitQuery;
        $query = "SELECT COUNT(DISTINCT `shop`.`token`) AS `total_count`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token`
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`distributor_token` = ? AND `shop`.`shop_type_code` != '0' $unitQuery AND `shop_mapping`.`status`='1'
        $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function serverRetailerCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $unitQuery = $this->unitQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `shop`.`token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`join_date`,
        `shop`.`license_number`,
        `employees`.`name` AS `distributor`,
        IFNULL(`units`.`name`, '') AS `unit_name`,
        IFNULL(`order_totals`.`paid_amounts`, 0) AS `paid_amounts`,
        IFNULL(`order_totals`.`outstanding_amount`, 0) AS `outstanding_amount`,
        `shop`.`shop_show_status`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token`
        LEFT JOIN `units` ON `units`.`token`=`shop_mapping`.`unit_token`
        LEFT JOIN (
            SELECT `shop_token`, SUM(`billing_amount`)-SUM(`paid_amount`) AS `outstanding_amount`, SUM(`paid_amount`) AS `paid_amounts`
            FROM `orders`
            GROUP BY `shop_token`
        ) AS `order_totals` ON `order_totals`.`shop_token`=`shop`.`token`
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`distributor_token` = ? AND `shop`.`shop_type_code` != '0' $unitQuery AND `shop_mapping`.`status`='1'
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function serverReadRetailer($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $data[] = array(
                "token" => $row['token'],
                "retail_code" => '<a class="view_link item_code_view">' . $row['retail_code'] . '</a>',
                "retailer_name" => $row['retailer_name'],
                "shop_type" => $row['shop_type'],
                "unit_name" => $row['unit_name'],
                "mobile_number" => $row['mobile_number'],
                "contact_person" => $row['contact_person'] == "" ? "-" : $row['contact_person'],
                "join_date" => date("d/m/Y", strtotime($row['join_date'])),
                "license_number" => $row['license_number'],
                "paid_amount" => $this->indianNumbeFormat($row['paid_amounts']),
                "outstanding_amt" => $this->indianNumbeFormat(round($row['outstanding_amount'])),
                "shop_show_status" => $row['shop_show_status'],
                "action" => '<a><img src="assets/edit.png" class="edit_input item_code_edit" data-toggle="tooltip" title="Edit" alt="">&nbsp;<img src="assets/Artboard.svg" class="edit_input item_code_viewSingle" data-toggle="tooltip" title="View" alt=""></a>'
            );
        }
        return $data;
    }

    function shopCheckToken()
    {
        $query = "SELECT `id` FROM `shop` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }

    function shopStatusUpdate()
    {
        $query = "UPDATE `shop` SET `shop_show_status`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_show_status);
        $stmt->bindParam(2, $this->shop_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function shopMappingStatusUpdate()
    {
        $query = "UPDATE `shop_mapping` SET `status`=? WHERE `distributor_token`=? AND `shop_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_mapping_status);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->bindParam(3, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }

    function selectUnitList()
    {
        $query21 = "SELECT 
        `token` AS `unit_token`,
        `name` AS `unit_name` 
        FROM `units` WHERE `distributor_token`=?";
        $stmt = $this->conn->prepare($query21);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function readUnitList($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->unit_token = (int)$row['unit_token'];
            $obj->unit_name  = $row['unit_name'];
            array_push($array, $obj);
        }
        return $array;
    }

    function unitWiseRetailerList()
    {
        $query = "SELECT `shop`.`token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`join_date`,
        `shop`.`license_number`,
        `employees`.`name` AS `distributor`,
        IFNULL(`units`.`name`, '') AS `unit_name`,
        IFNULL(`order_totals`.`paid_amount`, 0) AS `paid_amount`,
        IFNULL(`order_totals`.`outstanding_amount`, 0) AS `outstanding_amount`
        FROM `shop`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token`
        LEFT JOIN `units` ON `units`.`token`=`shop_mapping`.`unit_token`
        LEFT JOIN (
            SELECT `shop_token`, SUM(`paid_amount`) AS `paid_amount`, SUM(`billing_amount`)-SUM(`paid_amount`) AS `outstanding_amount`
            FROM `orders`
            GROUP BY `shop_token`
        ) AS `order_totals` ON `order_totals`.`shop_token`=`shop`.`token`
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`distributor_token` = ? AND `shop`.`shop_type_code` != '0' AND `shop_mapping`.`unit_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->unit_token);
        $stmt->execute();
        return $stmt;
    }
    function takeOrderRetailerView()
    {
        $query = "SELECT 
        `shop`.`token`,
        `products`.`item_code`,
        `products`.`name`,
        `products`.`total_cost`,
        `products__scheme`.`scheme_name`
       FROM  `products` 
       LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
       LEFT JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token`=`products__category`.`token`
       LEFT JOIN `shop` ON `shop`.`distributor_token`=`employees__division_mapping`.`employee_token`
       LEFT JOIN `products__scheme` on `products`.`token` = `products__scheme`.`product_token` AND `products__scheme`.`is_scheme`='1'
       WHERE `employees__division_mapping`.`employee_token`=? AND `employees__division_mapping`.`delete_status`=1 AND `products`.`delete_status` = 1 AND `shop`.`token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->token);
        $stmt->execute();
        return $stmt;
    }
    function isMobileNoExistUnderDistributor()
    {
        $query = "SELECT `mobile_number` FROM `shop` 
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        WHERE `shop_mapping`.`distributor_token`=? AND `shop`.`mobile_number`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->mobile_number);
        $stmt->execute();
        return $stmt;
    }

    //========distributor check in shop
    function checkshop_distributor()
    {
        $query = "SELECT `shop`.`mobile_number`,`shop_mapping`.`distributor_token` FROM `shop` 
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        WHERE `shop_mapping`.`distributor_token`=? AND `shop`.`mobile_number`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->mobile_number);
        $stmt->execute();
        return $stmt;
    }

    function shopmapping_add_distributor($random_token, $shops_token, $indiaDateTime)
    {
        $query1 = "INSERT INTO `shop_mapping` SET
                `token`='$random_token',
                `shop_token`='$shops_token',
                `distributor_token`=:distributorToken,
                `unit_token`='',
                `date_time`='$indiaDateTime',
                `status`= '1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam('distributorToken', $this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }


    //add discount
    function discountVerify()
    {
        $query = "SELECT `percentage` FROM `discount` WHERE `percentage`=? AND `status`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->discount);
        $stmt->execute();
        return $stmt;
    }

    function addDiscount($indiaDateTime)
    {
        $query = "INSERT INTO `discount`
        SET `date_time`='$indiaDateTime',
       `token`=:token,
       `percentage`=:percentage,
       `status`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('percentage', $this->discount);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function getDiscount()
    {
        $query = "SELECT
        `token`,
        `percentage`
        FROM
        `discount` where `status`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->percentage  = $row['percentage'];
            $obj->token = (int)$row['token'];
            array_push($array, $obj);
        }
        return $array;
    }

    function discountDelete()
    {
        $query = "UPDATE `discount` SET `status`='1' WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }
}
