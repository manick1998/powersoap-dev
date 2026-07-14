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
    function retailerDetailCountCheck()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT `shop`.`id`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery
        INNER JOIN `region` ON `region`.`token`=`employees`.`region_id`
        INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token` 
        WHERE `shop`.`delete_status`='1' GROUP BY `shop`.`token`
        ORDER BY `shop`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function distributor_retailerDetailCountCheck()
    {
        $stateQuery = $this->stateQuery;
        $distributor_token = $this->distributor_token;
        // $query = "SELECT `shop`.`id`
        // FROM `shop`
        // INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        // INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        // INNER JOIN `employees` ON `employees`.`token`=`shop`.`distributor_token` $stateQuery
        // WHERE `shop`.`delete_status`='1' AND `shop`.`distributor_token` = $distributor_token
        // ORDER BY `shop`.`id` DESC";

        $query = "SELECT
            `shop`.`id`
        FROM
            `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token` = `shop_mapping`.`distributor_token` $stateQuery
        WHERE
            `shop`.`delete_status` = '1' AND `shop_mapping`.`distributor_token` = $distributor_token
        ORDER BY
            `shop`.`id`
        DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function retailerDetailCheck()
    {
        $query = "SELECT `shop`.`token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`token` AS `shop_type_token`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`address`,
        `shop`.`city`,
        `shop`.`pincode`,
        `shop`.`coordinates`,
        `shop`.`license_image`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`join_date`,
        `shop`.`license_number`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        WHERE `shop`.`delete_status`='1'
        AND `shop_mapping`.`distributor_token`=''
        ORDER BY `shop`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readRetailerDetails($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->shop_token = (int)$row['token'];
            $obj->shop_code  = $row['retail_code'];
            $obj->shop_name  = $row['retailer_name'];
            $obj->shop_type  = $row['shop_type'];
            $obj->shop_type_token    = $row['shop_type_token'];
            $obj->shop_mobile_number = $row['mobile_number'];
            $obj->contact_person  = $row['contact_person'];
            $obj->shop_join_date  = date("d/m/Y", strtotime($row['join_date']));
            $obj->license_number  = $row['license_number'];

            $obj->address         = $row['address'];
            $obj->city            = $row['city'];
            $obj->pincode         = $row['pincode'];
            $obj->coordinates     = $row['coordinates'];
            $obj->license_image   = $row['license_image'];

            array_push($array, $obj);
        }
        return $array;
    }
    function serverRetailerCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT `shop`.`id`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery
        INNER JOIN `region` ON `region`.`token`=`employees`.`region_id`
        INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
        WHERE `shop`.`delete_status`='1'
        $searchQuery GROUP BY `shop`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverDistribtorRetailerCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $distributor_token = $this->distributor_token;
        $query = "SELECT `shop`.`id`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`distributor_token`= $distributor_token
        $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverRetailerCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $stateQuery = $this->stateQuery;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT `shop`.`token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`license_number`,
        `region`.`region_name`,
        `employees__state`.`state_name` AS `state`,
        `area`.`area_name`,
        `employees`.`name` AS `distributor`,
        `shop_mapping`.`distributor_token`,
         `shop`.`reason`,
        `shop`.`shop_show_status`,
        `shop`.`address`,
        `shop`.`pincode`,
        `shop`.`city`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery $searchQuery
        INNER JOIN `region` ON `region`.`token`=`employees`.`region_id`
        INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
        WHERE `shop`.`delete_status`='1'  GROUP BY `shop`.`token`
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
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
                "retail_code" => '<a class="view_link item_code_view" >' . $row['retail_code'] . '</a>',
                "retailer_name" => $row['retailer_name'],
                "shop_type" => $row['shop_type'],
                "mobile_number" => $row['mobile_number'],
                "contact_person" => $row['contact_person'],
                "region_name" => $row['region_name'],
                "state" => $row['state'],
                "area_name" => $row['area_name'],
                "license_number" => $row['license_number'],
                "distributor" => $row['distributor'],
                "distributor_token" => $row['distributor_token'],
                "shop_show_status" => $row['shop_show_status'],
                "shop_address" => $row['address'],
                "pincode" => $row['pincode'],
                "shop_city" => $row['city'],
                "action" => '<a><img src="assets/edit.png" class="edit_input item_code_edit" alt=""></a>',
                "reason" => $row['reason']
            );
        }
        return $data;
    }
    //serverdistributorretailerlist
    function serverDistributorRetailerCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $stateQuery = $this->stateQuery;
        $searchQuery = $this->searchQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $distributor_token = $this->distributor_token;
        $query = "SELECT `shop`.`token`,
        `shop`.`retail_code`,
        `shop`.`name` AS `retailer_name`,
        `shop__type`.`name` AS `shop_type`,
        `shop`.`mobile_number`,
        `shop`.`contact_person`,
        `shop`.`join_date`,
        `shop`.`license_number`,
        `shop`.`city`,
        `shop`.`created_by` AS `created_by_token`,
        `employees__state`.`state_name` AS `state`,
        `employees`.`name` AS `distributor`,
        `shop_mapping`. `distributor_token` AS `distributor_token`
        FROM `shop`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
        INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery
        WHERE `shop`.`delete_status`='1' AND `shop_mapping`.`status` = '1' AND `shop_mapping`.`distributor_token`= $distributor_token
        $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverDistributorReadRetailer($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $data[] = array(
                "token" => $row['token'],
                "retail_code" => '<a class="view_link item_code_view" >' . $row['retail_code'] . '</a>',
                "retailer_name" => $row['retailer_name'],
                "shop_type" => $row['shop_type'],
                "mobile_number" => $row['mobile_number'],
                "contact_person" => $row['contact_person'],
                "created_by_token" => $row['created_by_token'],
                "city" => $row['city'],
                "state" => $row['state'],
                "join_date" => date("d/m/Y", strtotime($row['join_date'])),
                "license_number" => $row['license_number'],
                "remove_btn" => '<button class="button3" data-distributor_token ="' . $row['distributor_token'] . '" data-shop_token ="' . $row['token'] . '" style="background-color:#cc2121; color:white; border-radius:4px; padding:10px; text-decoration:none; border:1px solid #cc2121; cursor: pointer;">Remove</button>',
                "distributor" => $row['distributor']
            );
        }
        return $data;
    }

    function tokenGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `shop` WHERE `token`=?";
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
    function codeGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `shop` WHERE `retail_code`=?";
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
    function addRetailer($indiaDateTime)
    {
        $query = "INSERT INTO `shop` 
        SET `token`=:token,
        `name`=:name,
        `date_time`='$indiaDateTime',
        `retail_code`=:retail_code,
        `shop_type_code`=:shop_type_code,
        `mobile_number`=:mobile_number,
        `contact_person`=:contact_person,
        `join_date`='$indiaDateTime',
        `delete_status`='1',
        `license_image`=:image,
        `address`=:address,
        `city`=:city,
        `pincode`=:pincode,
        `coordinates`=:coordinates,
        `license_number`=:license_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->shopName);
        $stmt->bindParam('retail_code', $this->retailCode);
        $stmt->bindParam('shop_type_code', $this->shopType);
        $stmt->bindParam('mobile_number', $this->contactNumber);
        $stmt->bindParam('contact_person', $this->contactPerson);
        $stmt->bindParam('image', $this->retailerImage);
        $stmt->bindParam('address', $this->shopAddress);
        $stmt->bindParam('city', $this->shopCity);
        $stmt->bindParam('pincode', $this->shopPincode);
        $stmt->bindParam('coordinates', $this->shopCoordinates);
        $stmt->bindParam('license_number', $this->licenseNumber);
        $stmt->execute();
        return $stmt;
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
        $stmt->bindParam('mobile_number', $this->contactNumber);
        $stmt->bindParam('contact_person', $this->contactPerson);
        $stmt->bindParam('image', $this->retailerImage);
        $stmt->bindParam('address', $this->shopAddress);
        $stmt->bindParam('city', $this->shopCity);
        $stmt->bindParam('pincode', $this->shopPincode);
        $stmt->bindParam('coordinates', $this->shopCoordinates);
        $stmt->bindParam('license_number', $this->licenseNumber);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }
    // function updateRetailername_shopedit_log(){
    //     $query = "UPDATE `shopedit_log` 
    //     SET `new_shop_name`=:name,
    //     `new_mobile`=:mobile_number,
    //     `new_licens_number`=:new_licens_number,
    //     `new_address`=:address,
    //     `new_city`=:new_city,
    //     `new_pincode`=:new_pincode,
    //     `delete_status`='0'
    //     WHERE `shop_token`=:token AND `status`='1'";
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->bindParam('name', $this->shopName);
    //     $stmt->bindParam('mobile_number', $this->contactNumber);
    //     $stmt->bindParam('new_licens_number', $this->licenseNumber);
    //     $stmt->bindParam('address', $this->shopAddress);
    //     $stmt->bindParam('new_city', $this->shopCity);
    //     $stmt->bindParam('new_pincode', $this->shopPincode);
    //     $stmt->bindParam('token', $this->token);
    //     $stmt->execute();
    //     return $stmt;
    // }

    function shopEditNewRetailer_log($currentDate)
    {
        $query = "INSERT INTO `shopedit_log` 
        SET `shop_token`=:token,
        `old_shop_name`=:old_name,
        `new_shop_name`=:name,
        `old_mobile`=:old_number,
        `new_mobile`=:mobile_number,
        `old_licens_number`=:old_licens,
        `new_licens_number`=:license_number,
        `old_address`=:old_address,
        `new_address`=:address,
        `old_city`=:old_city,
        `new_city`=:shop_city,
        `old_pincode`=:old_pincode,
        `new_pincode`=:shop_pincode,
        `created_by`=:admin_token,
        `delete_status`='0',
        `date_and_time`='$currentDate'
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('old_name', $this->old_name);
        $stmt->bindParam('name', $this->shopName);
        $stmt->bindParam('old_number', $this->old_number);
        $stmt->bindParam('mobile_number', $this->contactNumber);
        $stmt->bindParam('old_licens', $this->licenseNumber);
        $stmt->bindParam('license_number', $this->licenseNumber);
        $stmt->bindParam('old_address', $this->old_address);
        $stmt->bindParam('address', $this->shopAddress);
        $stmt->bindParam('old_city', $this->old_city);
        $stmt->bindParam('shop_city', $this->shopCity);
        $stmt->bindParam('old_pincode', $this->old_pincode);
        $stmt->bindParam('shop_pincode', $this->shopPincode);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    function singleRetailer()
    {
        $query = "SELECT
        `shop`.`token`,
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
        INNER JOIN `shop__type` ON `shop__type`.`token` = `shop`.`shop_type_code`
        WHERE
        `shop`.`delete_status` = '1' AND `shop`.`token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->shop_token = (int)$row['token'];
        $obj->shop_code  = $row['retail_code'];
        $obj->shop_name  = $row['retailer_name'];
        $obj->shop_type  = $row['shop_type'];
        $obj->slot  = $row['slot'];
        $obj->shop_mobile_number = $row['mobile_number'];
        $obj->contact_person  = $row['contact_person'];
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

    //update pdf
    function retailerPdf()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT `shop`.`token`,
            `shop`.`retail_code`,
            `shop`.`name` AS `retailer_name`,
            `shop__type`.`name` AS `shop_type`,
            `shop`.`mobile_number`,
            `shop`.`contact_person`,
            `region`.`region_name`,
            `employees__state`.`state_name` AS `state`,
            `area`.`area_name`,
            `employees`.`name` AS `distributor`
            FROM `shop`
            INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
            INNER JOIN `employees__state` ON `employees__state`.`state_token` = `shop`.`state_id`
            INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token` = `shop`.token
            INNER JOIN `employees` ON `employees`.`token`=`shop_mapping`.`distributor_token` $stateQuery
            INNER JOIN `region` ON `region`.`token`=`employees`.`region_id`
            INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
            WHERE `shop`.`delete_status`='1'  GROUP BY `shop`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //shop type
    function insert_shoptypes()
    {
        $query = "SELECT * FROM `shop__type`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //show status shop
    function shopCheckToken()
    {
        $query = "SELECT `id`,`token` FROM `shop` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }
    function shopStatusUpdate()
    {
        $query = "UPDATE `shop` SET `shop_show_status`=?,`reason`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_show_status);
        $stmt->bindParam(2, $this->reason);
        $stmt->bindParam(3, $this->shop_token);
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

    //Inactivate Shop Log
    // function inactivate_shop_log(){
    //     $query = "UPDATE `shopedit_log` 
    //     SET `new_shop_name`=:name,
    //     `new_mobile`=:mobile_number,
    //     `new_licens_number`=:new_licens_number,
    //     `new_address`=:address,
    //     `new_city`=:new_city,
    //     `new_pincode`=:new_pincode,
    //     `delete_status`=:shop_mapping_status,
    //     `status`='3'
    //     WHERE `shop_token`=:token AND `status`='1'";
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->bindParam('name', $this->shop_name);
    //     $stmt->bindParam('mobile_number', $this->mobile_number);
    //     $stmt->bindParam('new_licens_number', $this->licens_number);
    //     $stmt->bindParam('address', $this->address);
    //     $stmt->bindParam('new_city', $this->city);
    //     $stmt->bindParam('new_pincode', $this->pincode);
    //     $stmt->bindParam('shop_mapping_status', $this->shop_mapping_status);
    //     $stmt->bindParam('token', $this->shop_token);
    //     $stmt->execute();
    //     return $stmt;
    // }

    function shopInactiveNewRetailer_log($currentDate)
    {
        $query = "INSERT INTO `shopedit_log` 
                SET `shop_token`=:token,
                `old_shop_name`=:name,
                `new_shop_name`='',
                `old_mobile`=:mobile_number,
                `new_mobile`='',
                `old_licens_number`=:old_licens_number,
                `new_licens_number`='',
                `old_address`=:address,
                `new_address`= '',
                `old_city`=:old_city,
                `new_city`='',
                `old_pincode`=:old_pincode,
                `new_pincode`='',
                `created_by`=:admin_token,
                `delete_status`=:shop_mapping_status,
                `date_and_time`='$currentDate'
                ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->shop_token);
        $stmt->bindParam('name', $this->shop_name);
        $stmt->bindParam('mobile_number', $this->mobile_number);
        $stmt->bindParam('old_licens_number', $this->licens_number);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('old_city', $this->city);
        $stmt->bindParam('old_pincode', $this->pincode);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->bindParam('shop_mapping_status', $this->shop_mapping_status);
        $stmt->execute();
        return $stmt;
    }

    //distributor add retailer
    function checkRetailerMobileNumber()
    {
        $query = "SELECT `id`,`token`,`retail_code` FROM `shop` WHERE `mobile_number`=? AND `mobile_number`!=''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->mobile_number);
        $stmt->execute();
        return $stmt;
    }
    function checkRetailerMobileNumber_read($stmt)
    {
        $shop_arr_data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $get_shop_token =  $row['token'];
            $get_retail_code = $row['retail_code'];
            array_push($shop_arr_data, $get_shop_token, $get_retail_code);
        }
        return $shop_arr_data;
    }

    function checkRetailerLicenseNumber()
    {
        $query = "SELECT `id` FROM `shop` WHERE `license_number`=? AND `license_number` !=''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->license_number);
        $stmt->execute();
        return $stmt;
    }
    function addNewRetailer($indiaDateTime, $state)
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
                `state_id`= '$state',
                `pincode`=:pincode,
                `coordinates`=:coordinates";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('retail_code', $this->retail_code);
        $stmt->bindParam('shop_type_code', $this->shop_type_code);
        //        $stmt->bindParam('slot_type', $this->slot_type);
        // $stmt->bindParam('distributor_token', $this->distributorToken);
        $stmt->bindParam('mobile_number', $this->mobile_number);
        $stmt->bindParam('contact_person', $this->contact_person);
        $stmt->bindParam('license_number', $this->license_number);
        $stmt->bindParam('license_image', $this->license_image);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('city', $this->city);
        // $stmt->bindParam('state_token', $this->state_token);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('coordinates', $this->coordinates);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //shop add log
    function shopaddNewRetailer_log($indiaDateTime)
    {
        $query = "INSERT INTO `shopedit_log` 
                SET `shop_token`=:token,
                `old_shop_name`=:name,
                `new_shop_name`='',
                `old_mobile`=:mobile_number,
                `new_mobile`='',
                `old_licens_number`=:license_number,
                `new_licens_number`='',
                `old_address`=:address,
                `new_address`= '',
                `old_city`=:shop_city,
                `new_city`='',
                `old_pincode`=:shop_pincode,
                `new_pincode`='',
                `created_by`=:admin_token,
                `delete_status`='0',
                `date_and_time`='$indiaDateTime'
                ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('mobile_number', $this->mobile_number);
        $stmt->bindParam('license_number', $this->license_number);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('shop_city', $this->city);
        $stmt->bindParam('shop_pincode', $this->pincode);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->execute();
        return $stmt;
    }

    //same shop add distributor
    //     function same_shop_addNewRetailer($gain_shop_token,$gain_retail_code,$indiaDateTime,$state){
    //         $this->name = htmlspecialchars(strip_tags($this->name));
    //         $query = "INSERT INTO `shop` 
    //         SET `token`= '$gain_shop_token',
    //         `name`=:name,
    //         `date_time`='$indiaDateTime',
    //         `unit_token`='',
    //         `retail_code`='$gain_retail_code',
    //         `shop_type_code`=:shop_type_code,
    //         `slot`='',
    //         `mobile_number`=:mobile_number,
    //         `contact_person`=:contact_person,
    //         `join_date`='$indiaDateTime',
    //         `license_number`=:license_number,
    //         `license_image`=:license_image,
    //         `delete_status`='1',
    //         `address`=:address,
    //         `city`=:city,
    //         `state_id`= '$state',
    //         `pincode`=:pincode,
    //         `coordinates`=:coordinates";
    //         $stmt = $this->conn->prepare( $query );
    //         // $stmt->bindParam('token', $this->token);
    //         $stmt->bindParam('name', $this->name);
    //         // $stmt->bindParam('retail_code', $this->retail_code);
    //         $stmt->bindParam('shop_type_code', $this->shop_type_code);
    // //        $stmt->bindParam('slot_type', $this->slot_type);
    //        // $stmt->bindParam('distributor_token', $this->distributorToken);
    //         $stmt->bindParam('mobile_number', $this->mobile_number);
    //         $stmt->bindParam('contact_person', $this->contact_person);
    //         $stmt->bindParam('license_number', $this->license_number);
    //         $stmt->bindParam('license_image', $this->license_image);
    //         $stmt->bindParam('address', $this->address);
    //         $stmt->bindParam('city', $this->city);
    //         // $stmt->bindParam('state_token', $this->state_token);
    //         $stmt->bindParam('pincode', $this->pincode);
    //         $stmt->bindParam('coordinates', $this->coordinates);
    //         if($stmt->execute()){
    //                 return true;
    //         }else{
    //                 return false;
    //         }
    //     }

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
        //   $stmt->bindParam('token', $this->token); 
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // add shop mapping
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
        $stmt1->bindParam('distributorToken', $this->distributorToken);
        $stmt1->execute();
        return $stmt1;
    }
    //same shop add mapping 
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
        $stmt1->bindParam('distributorToken', $this->distributorToken);
        $stmt1->execute();
        return $stmt1;
    }
    //shop_type
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
            $obj->shop_token = (int)$row['token'];
            $obj->shop_type  = $row['name'];
            array_push($array, $obj);
        }
        return $array;
    }
    //all distributor in region token
    function distributorlist()
    {
        $query = "SELECT `token`,`name` FROM `employees` WHERE `region_id`=? AND `deparment_token`='18028120' AND block_status='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->regionToken);
        $stmt->execute();
        return $stmt;
    }
    function distributorlistfetch($stmt)
    {
        $data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row["token"];
            $obj->name  = $row["name"];
            array_push($data, $obj);
        }
        return $data;
    }
    function rep_add_shops()
    {
        $query = "SELECT
    shop.retail_code,
    shop.token AS shop_token,
    shop.name,
    shop__type.name AS retailer_type,
    shop.mobile_number,
    shop.contact_person,
    shop.join_date,
    shop.license_number,
    shop_mapping.distributor_token,
    shop_mapping.status
FROM
    `shop`
INNER JOIN shop__type ON shop.shop_type_code = shop__type.token
INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token
WHERE
    shop_mapping.distributor_token = ? ORDER BY shop.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function rep_add_shops_read($stmt)
    {
        $shop_arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $shop_obj = new stdClass;
            $shop_obj->retail_code = $row['retail_code'];
            $shop_obj->shop_token = $row['shop_token'];
            $shop_obj->shop_name = $row['name'];
            $shop_obj->shop_type = $row['retailer_type'];
            $shop_obj->shop_mobile_number = $row['mobile_number'];
            $shop_obj->contact_person = $row['contact_person'];
            $shop_obj->join_date = $row['join_date'];
            $shop_obj->license_number = $row['license_number'];
            $shop_obj->shop_status = $row['status'];
            $shop_obj->distributor_token = $row['distributor_token'];
            array_push($shop_arr, $shop_obj);
        }
        return $shop_arr;
    }
    function  status_update()
    {
        $query = "UPDATE `shop_mapping` SET `status`=? WHERE `shop_token`=? AND `distributor_token`=? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_status);
        $stmt->bindParam(2, $this->shop_token);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function onboard_retailer_details()
    {
        $query = "SELECT
    shop_mapping.token AS shop_mapping_uniq_token,
    shop.token AS shop_token,
    shop.retail_code,
    shop.name AS retailer_name,
    shop__type.name AS shopType_name,
    shop.mobile_number,
    shop.contact_person,
    shop.license_number,
    shop.city
FROM
    `shop`
INNER JOIN shop__type ON shop.shop_type_code = shop__type.token
LEFT JOIN shop_mapping ON shop_mapping.shop_token = shop.token
INNER JOIN shop_product_division ON shop_product_division.shop_token = shop.token GROUP BY shop.token ORDER BY shop_product_division.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function onboard_retailer_details_list($func)
    {
        $table_arr = [];
        while ($row = $func->fetch(PDO::FETCH_ASSOC)) {
            $table_obj = new stdClass;
            $table_obj->shop_mapping_uniq_token = $row['shop_mapping_uniq_token'];
            $table_obj->shop_token = $row['shop_token'];
            $table_obj->retail_code = $row['retail_code'];
            $table_obj->retailer_name = $row['retailer_name'];
            $table_obj->shopType_name = $row['shopType_name'];
            $table_obj->mobile_number = $row['mobile_number'];
            $table_obj->contact_person = $row['contact_person'];
            $table_obj->license_number = $row['license_number'];
            $table_obj->city = $row['city'];
            array_push($table_arr, $table_obj);
        }
        return $table_arr;
    }
    function retailer_divi_details()
    {
        $query = "SELECT
            products__category.name AS division_name,
            shop_product_division.division_token
        FROM
            `shop_product_division`
        INNER JOIN products__category ON products__category.token = shop_product_division.division_token
        WHERE
            shop_product_division.`shop_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }
    function retailer_divi_details_list($stmt)
    {
        $divi_arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $divi_obj = new stdClass;
            $divi_obj->division_name = $row['division_name'];
            $divi_obj->division_token = $row['division_token'];
            array_push($divi_arr, $divi_obj);
        }
        return $divi_arr;
    }

    function retailer_divi_address()
    {
        $query = "SELECT `address`,`city`,`pincode` FROM `shop` WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }
    function retailer_divi_address_list($stmt1)
    {
        $address_arr = [];
        while ($rows = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $add_obj = new stdClass;
            $add_obj->address = $rows['address'];
            $add_obj->city = $rows['city'];
            $add_obj->pincode = $rows['pincode'];
            array_push($address_arr, $add_obj);
        }
        return $address_arr;
    }
    function request_updated($indiaDateTime)
    {
        $distributor_token = $this->distributor_token;
        $shop_token = $this->shop_token;
        foreach ($distributor_token as $distributortoken) {
            $random = rand(10000000, 99999999);
            $inserts[] = "('$random','$shop_token','$distributortoken','$indiaDateTime','1')";
        }
        $query = "INSERT INTO `shop_mapping`(`token`,`shop_token`, `distributor_token`, `date_time`, `status`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return true;
    }
    function mapping_outstanding($arr_token, $indiaDateTime)
    {
        foreach ($arr_token as $shop_uniq_token) {
            $inserts[] = "('$indiaDateTime','$shop_uniq_token','0','0','0','0')";
        }
        $query = "INSERT INTO `shop__outstanding`(`date_time`,`shop_token`,`bill_amount`,`paid_amt`,`total_outstanding`,`receiver_token`)VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return true;
    }

    function mapping_data_checking()
    {
        $distributor_token = $this->distributor_token;
        $shop_token = $this->shop_token;
        // foreach ($distributor_token as $distributortoken) {
        //     $inserts[] = "('$distributortoken')";
        // }
        $query = "SELECT
        employees.name AS distributor_name,
        shop_mapping.token,
        shop.name
    FROM
        `shop_mapping`
    INNER JOIN shop ON shop.token = shop_mapping.shop_token
    INNER JOIN employees ON employees.token = shop_mapping.distributor_token
    WHERE
        shop.token = $shop_token AND shop_mapping.distributor_token IN (" . implode(', ', $distributor_token) . ")";
        $stmt3 = $this->conn->prepare($query);
        $stmt3->execute();
        return $stmt3;
    }
    function mapping_data_checking_read($stmt3)
    {
        $distributor_name_arr = [];
        while ($rows = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            $dis_obj = new stdClass;
            $dis_obj->dis_name = $rows['distributor_name'];

            array_push($distributor_name_arr, $dis_obj);
        }
        return $distributor_name_arr;
    }

    function checkshop_distributor()
    {
        $query = "SELECT `shop`.`mobile_number`,`shop_mapping`.`distributor_token` FROM `shop` 
        INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
        WHERE `shop_mapping`.`distributor_token`=? AND `shop`.`mobile_number`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributorToken);
        $stmt->bindParam(2, $this->mobile_number);
        $stmt->execute();
        return $stmt;
    }

    function  remeove_shop()
    {
        $query = "UPDATE `shop_mapping` SET `status`= '2' WHERE distributor_token = ? AND shop_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->bindParam(2, $this->shop_token);
        $stmt->execute();
        return $stmt;
    }
}
