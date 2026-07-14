<?php
class Employee
{

    public $conn;
    public $distributor_token;
    public $employeeToken;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function employeeEmaiIdCheck()
    {
        $query = "SELECT `id` FROM `employees` WHERE `email_id`=:emaiId AND `email_id` != ''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emaiId', $this->emaiId);
        $stmt->execute();
        return $stmt;
    }
    function employeeDepartmentToken()
    {
        $query = "SELECT `token`, `name` FROM `deparment` WHERE `name`=:department_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('department_name', $this->department_name);
        $stmt->execute();
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = (int)$row['token'];
        return $token;
    }
    function employeeUpdateEmailIdCheck()
    {
        $query = "SELECT * FROM `employees` WHERE `email_id` =:emaiId AND `email_id` != '' AND `token` not in (:token)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emaiId', $this->emaiId);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }
    function employeeMobileNumberCheck()
    {
        $query = "SELECT `id` FROM `employees` WHERE `mobile_number`=:mobileNumber AND `mobile_number` != '' AND deparment_token=18028120";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->execute();
        return $stmt;
    }
    function employeeUpdateMobileNumberCheck()
    {
        $query = "SELECT * FROM `employees` WHERE `mobile_number`=:mobileNumber AND `mobile_number` != '' AND `token` not in (:token)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    function employeeMobileNumber()
    {
        $query = "SELECT `mobile_number` FROM `employees` WHERE token=:distributor_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->execute();
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);
        $mobile = $row['mobile_number'];
        return $mobile;
    }

    function employeeMobileNumberSales()
    {
        $query = "SELECT id FROM `employees` WHERE `mobile_number`=:mobileNumber AND deparment_token=45916684 AND token!=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }

    function employeeDetailCheck()
    {
        $query = "SELECT `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`name`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`dob`,
        `employees`.`deparment_token`,
        `employees`.`gender`, 
        `employees`.`blood_group`, 
        `employees`.`address`, 
        `employees`.`pincode`, 
        `employees`.`street`, 
        `employees`.`city`,
        `employees`.`employee_image`,
        `employees`.`address_proof`,
        `employees`.`block_status`
        FROM `employees`
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        WHERE `delete_status`='1' AND `employees`.`admin_distributor_token`=?
        ORDER BY `employees`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDetails($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = (int)$row['token'];
            $obj->employee_code  = $row['employees_code'];
            $obj->employee_name  = $row['name'];
            $obj->employee_deparment_name = $row['deparment_name'];
            $obj->employee_mobile_number = $row['mobile_number'];
            $obj->employee_email_id  = $row['email_id'];
            //$obj->employee_join_date = date("d/m/Y",strtotime($row['join_date']));
            $obj->employee_join_date = date("m/d/Y", strtotime($row['join_date']));
            $obj->employee_dob       = date("m/d/Y", strtotime($row['dob']));
            //$obj->employee_dob       = date("d/m/Y",strtotime($row['dob']));
            $obj->deparment_token = $row['deparment_token'];
            $obj->gender = $row['gender'];
            $obj->blood_group = $row['blood_group'];
            $obj->address = $row['address'];
            $obj->pincode = $row['pincode'];
            $obj->street = $row['street'];
            $obj->city = $row['city'];
            $obj->blockStatus = $row['block_status'];
            $obj->employee_image = $row['employee_image'];
            $obj->address_proof = $row['address_proof'];
            $query = "SELECT `id`, `attachment_url` FROM `employees__attachments` WHERE `employee_token` = " . $row['token'] . "";
            $stmt1 = $this->conn->prepare($query);
            $stmt1->execute();
            $attachment_array = [];
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $obj1 = new stdClass;
                $obj1->attachment_id = (int)$row1['id'];
                $obj1->attachment = $row1['attachment_url'];
                array_push($attachment_array, $obj1);
            }
            $obj->attachment_image = $attachment_array;

            array_push($array, $obj);
        }
        return $array;
    }
    function employeeDetailCheckSingle()
    {
        $query = "SELECT `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`employee_image`,
        `employees`.`name`,
        `employees`.`gender`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`dob`,
        `employees`.`blood_group`,
        `employees`.`address`,
        `employees`.`pincode`,
        `employees`.`street`,
        `employees`.`city`,
        `employees`.`address_proof`,
        `employees`.`language`,
        `employees`.`block_status`
        FROM `employees`
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        WHERE `delete_status`='1'
        AND `employees`.`token`=? AND `employees`.`admin_distributor_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDetailsSingle($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = (int)$row['token'];
            $obj->block_status   = (int)$row['block_status'];
            $obj->employee_code  = $row['employees_code'];
            $obj->profile_image  = $row['employee_image'];
            $obj->employee_name  = $row['name'];
            $obj->employee_gender = ucwords(strtolower($row['gender']));
            $obj->employee_deparment_name = $row['deparment_name'];
            $obj->employee_mobile_number = $row['mobile_number'];
            $obj->employee_email_id  = $row['email_id'];
            //$obj->employee_join_date = date("d/m/Y",strtotime($row['join_date']));
            $obj->employee_join_date = date("m/d/Y", strtotime($row['join_date']));
            $obj->employee_dob       = date("m/d/Y", strtotime($row['dob']));
            //$obj->employee_dob       = date("d/m/Y",strtotime($row['dob']));
            $dateOfBirth = $row['dob'];
            $diff = date_diff(date_create($dateOfBirth), date_create($indiaDate));
            $obj->employee_age          = $diff->format('%y') . " age";
            $obj->employee_blood_group  = $row['blood_group'];
            $obj->employee_language     = $row['language'];
            $obj->employee_address_proof = $row['address_proof'];
            $obj->employee_address      = $row['address'] . ", " . $row['street'] . ", " . $row['city'] . " - " . $row['pincode'];

            $array_attachment = [];
            $query1 = "SELECT `id`,
            `attachment_url` 
            FROM `employees__attachments`
            WHERE `employee_token`=?";
            $stmt1  = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $row['token']);
            $stmt1->execute();
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $obj1 = new stdClass;
                $obj1->attachment_id = $row1['id'];
                $obj1->attachment    = $row1['attachment_url'];
                array_push($array_attachment, $obj1);
            }
            $obj->employee_attachment = $array_attachment;
            array_push($array, $obj);
        }
        return $array;
    }
    function addEmployee($indiaDateTime)
    {
        $query = "INSERT INTO `employees` 
        SET `token`=:token,
        `name`=:name,
        `date_time`='$indiaDateTime',
        `employees_code`=:code,
        `email_id`=:email,
        `password`='',
        `deparment_token`=:department,
        `admin_distributor_token`=:distributor_token,
        `gender`=:gender,
        `mobile_number`=:mobile,
        `join_date`=:joindate,
        `dob`=:dob,
        `blood_group`=:bloodgroup,
        `address`=:address,
        `street`=:street,
        `city`=:city,
        `pincode`=:pincode,
        `address_proof`=:addressproof,
        `state_id`='',
        `delete_status`='1',
        `employee_image`=:image";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('code', $this->code);
        $stmt->bindParam('email', $this->emaiId);
        // $password  = hash('sha512', "powersoapdist");
        // $stmt->bindParam('password', $password);
        $stmt->bindParam('department', $this->department);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('gender', $this->gender);
        $stmt->bindParam('mobile', $this->mobileNumber);
        $stmt->bindParam('joindate', $this->joinDate);
        $stmt->bindParam('dob', $this->dob);
        $stmt->bindParam('bloodgroup', $this->bloodGroup);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('street', $this->street);
        $stmt->bindParam('city', $this->city);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('addressproof', $this->proof1);
        $stmt->bindParam('image', $this->image);
        $stmt->execute();
        return $stmt;
    }
    function proofInsert($token, $proof)
    {
        $query = "INSERT INTO `employees__attachments` SET `employee_token`=?,
        `attachment_url`=?,
        `attachment_type`='ADDRESS'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $token);
        $stmt->bindParam(2, $proof);
        $stmt->execute();
        return true;
    }
    function tokenGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `employees` WHERE `token`=?";
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
    function employeeCheckToken()
    {
        $query = "SELECT `id` FROM `employees` WHERE `mobile_number`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->execute();
        return $stmt;
    }
    function employeeStatusUpdate()
    {
        $query = "UPDATE `employees` SET `block_status`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->statusValue);
        $stmt->bindParam(2, $this->employeeToken);
        $stmt->execute();
        return true;
    }
    
    function updateLanguage() {
        $query = "UPDATE `employees` SET `language`=? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->languageValue);
        $stmt->bindParam(2, $this->employeeToken);
        $stmt->execute();
        return true;
    }

    function updateEmployee($indiaDateTime)
    {
        $query = "UPDATE
        `employees`
        SET `name`=:name,
        `date_time`='$indiaDateTime',
        `email_id`=:email,
        `deparment_token`=:department,
        `admin_distributor_token`=:distributor_token,
        `gender`=:gender,
        `mobile_number`=:mobile,
        `join_date`=:joindate,
        `dob`=:dob,
        `blood_group`=:bloodgroup,
        `address`=:address,
        `street`=:street,
        `city`=:city,
        `pincode`=:pincode,
        `address_proof`=:addressproof,
        `state_id`='',
        `delete_status`='1',
        `employee_image`=:image WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('email', $this->emaiId);
        $stmt->bindParam('department', $this->department);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('gender', $this->gender);
        $stmt->bindParam('mobile', $this->mobileNumber);
        $stmt->bindParam('joindate', $this->joinDate);
        $stmt->bindParam('dob', $this->dob);
        $stmt->bindParam('bloodgroup', $this->bloodGroup);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('street', $this->street);
        $stmt->bindParam('city', $this->city);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('addressproof', $this->proof1);
        $stmt->bindParam('image', $this->image);
        $stmt->execute();
        return $stmt;
    }

    function proofUpdate($proof, $id)
    {
        $query = "UPDATE `employees__attachments` SET 
        `attachment_url`=?,
        `attachment_type`='ADDRESS'
        WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $proof);
        $stmt->bindParam(2, $id);
        $stmt->execute();
        return true;
    }

    function employeeDailyCount()
    {
        $query = "SELECT 
        `orders`.`date_time`
        FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`sales_man`.`admin_distributor_token`
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `sales_man`.`admin_distributor_token` =? AND `orders`.`delivery` != 'Cancelled' GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function employeeDaliyCheckFilter()
    {
        $dateQuery   = $this->dateQuery;
        $query = "SELECT 
        `orders`.`date_time`
        FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`sales_man`.`admin_distributor_token`
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `sales_man`.`admin_distributor_token` =? AND `orders`.`delivery` != 'Cancelled'
        $dateQuery 
        GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function employeeDaliyCheckSearch()
    {
        $searchQuery   = $this->searchQuery;
        $query = "SELECT 
        `orders`.`date_time`
        FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`sales_man`.`admin_distributor_token`
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        -- INNER JOIN `shop` ON `orders`.`shop_token` = `shop`.`token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `sales_man`.`admin_distributor_token` =? AND `orders`.`delivery` != 'Cancelled'
        $searchQuery 
        GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function serverEmployeeDailySummaryCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT 
        `orders`.`date_time`,
        `orders`.`token` AS `order_token`,
        `orders`.`product_list`,
        `orders`.`shop_list`,
        `sales_man`.`name` AS `employee_name`, 
        `sales_man`.`token` AS `employee_token`, 
        `deparment`.`name` AS `department_name`,
        count(DISTINCT `orders`.`shop_token`) AS `outlet_covered`, 
	    MAX(`orders`.`unit_shop_count`) AS `outletList`,
        `units`.`name` AS `location_name`,
        `units`.`token` AS `unit_token`
       	FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`sales_man`.`admin_distributor_token`
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        -- INNER JOIN `shop` ON `orders`.`shop_token` = `shop`.`token`
        INNER JOIN `shop_mapping` ON `shop_mapping`.`token` = `orders`.`shop_token`
        INNER JOIN `shop` ON `shop_mapping`.`shop_token` = `shop`.`token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE 1
        $searchQuery
        $dateQuery
        AND `sales_man`.`admin_distributor_token` =? AND `orders`.`delivery` != 'Cancelled' GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE),`units`.`token`
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDailySummary($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $productivity = $row['outlet_covered'] . '/' . $row['outletList'];
            // echo 'outlet_covered',$row['outlet_covered'];
            // echo 'outletList',$row['outletList'];
            // echo $productivity;
            $data[] = array(
                "slno" => $slno,
                "date_value" => date("d-m-Y", strtotime($row['date_time'])),
                "order_token" => $row['order_token'],
                "employee_token" => $row['employee_token'],
                "date_time" => '<a class="view_link" data-unit_token="' . $row['unit_token'] . '">' . date("d/m/Y", strtotime($row['date_time'])) . '</a>',
                "employee_name" => ucwords($row['employee_name']),
                "deparment_name" => ucwords($row['department_name']),
                "outlet" => $row['department_name'] == 'Sales' ? '<a style="color:#00B9F5" id="btn" data-toggle="modal" data-emp_token ="' . $row['employee_token'] . '" >' . $row['outlet_covered'] . '/' . $row['outletList'] . '</a>' : $row['outlet_covered'] . '/' . $row['outletList'],
                // "outlet"=>$row['outlet_covered'].'/'.$row['outletList'],
                "location_name" => ucwords($row['location_name']),
                "productivity" => round((float)$productivity * 5 / 2) . '/5'
            );
        }
        return $data;
    }

    function getLoadingSheetInvoice()
    {
        $query21 = "SELECT `token`, `product_list`, `shop_list` FROM `orders` WHERE `token` =?";
        $stmt21 = $this->conn->prepare($query21);
        $stmt21->bindParam(1, $this->order_token);
        $stmt21->execute();
        $row21 = $stmt21->fetch(PDO::FETCH_ASSOC);
        $obj = new stdClass;
        $obj->order_token   = $row21['token'];
        $obj->product_list    = $row21['product_list'];
        $obj->shop_list    = $row21['shop_list'];
        return $obj;
    }
    function employeeDateDetail()
    {
        $selectedDate = $this->selectedDate;
        $query = "SELECT 
        `orders`.`token`,
        `orders`.`product_list`,
        -- `shop`.`token` AS `shop_token`,
        `shop_mapping`.`token` AS `shop_token`,
        `shop`.`name` AS `shop_name`,
        `shop__type`.`name` AS `shop_type`,
        `orders`.`items`,
        SUM(`billing_amount`) AS `bill_amount`
        FROM `orders` 
        INNER JOIN shop_mapping ON shop_mapping.token =`orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = shop_mapping.shop_token
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        WHERE `orders`.`date_time` LIKE '$selectedDate%' 
        AND `orders`.`employee_token`=? AND shop_mapping.unit_token = ? AND `orders`.`delivery` != 'Cancelled' GROUP BY `orders`.`shop_token` ORDER BY `orders`.`date_time` desc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->bindParam(2, $this->unit_token);
        $stmt->execute();
        return $stmt;
    }
    function employeeDateOrdertoken()
    {
        $selectedDate = $this->selectedDate;
        $query1 = "SELECT 
        GROUP_CONCAT(`orders`.`token`) AS `order_token`
        FROM `orders`
        INNER JOIN shop_mapping ON shop_mapping.token =`orders`.`shop_token`
        INNER JOIN `shop` ON `shop`.`token` = shop_mapping.shop_token
        WHERE `orders`.`date_time` LIKE '$selectedDate%' AND `employee_token`=? AND shop_mapping.unit_token = ?";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->employeeToken);
        $stmt1->bindParam(2, $this->unit_token);
        $stmt1->execute();
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        $token = $row1['order_token'];
        return $token;
    }
    function readEmployeeDateDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->order_token   = $row['token'];
            $obj->product_list   = $row['product_list'];
            $obj->shop_token    = $row['shop_token'];
            $obj->shop_name     = $row['shop_name'];
            $obj->shop_type     = $row['shop_type'];
            $obj->items         = $row['items'];
            $obj->bill_amount         = $row['bill_amount'];
            array_push($array, $obj);
        }
        return $array;
    }
    function employeeDateItemDetail($orderconcat_token)
    {
        $arr = [];
        array_push($arr, $orderconcat_token);
        $selectedDate = $this->selectedDate;
        //  $commaSeparated = implode(', ',$orderconcat_token);
        //  echo $arr;
        $query = "SELECT
        `products`.`token`,
        `products`.`name` AS `item_name`,
        SUM(
            CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count` WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity` ELSE 0
        END
    ) AS `quantity`,
    `orders__items`.`units`,
    `orders__items`.`price_per_unit`
    FROM
        `orders__items`
    INNER JOIN `products` ON `products`.`token` = `orders__items`.`product_token`
    INNER JOIN `orders` ON `orders`.`token` = `orders__items`.`order_token`
    WHERE
        `orders__items`.`date_time` LIKE '$selectedDate%' AND `orders__items`.`order_token` IN (" . implode(',', $arr) . ") AND `orders`.`delivery` != 'Cancelled' AND `orders__items`.`delete_status` = 1
    GROUP BY
        `products`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDateItemDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token         = $row['token'];
            $obj->item_name     = $row['item_name'];
            $obj->quantity = $row['quantity'];
            $obj->units         = 'Nos';
            $obj->sales         = round($row['quantity'] * $row['price_per_unit'], 2);
            array_push($array, $obj);
        }
        return $array;
    }
    function employeeDateItemDetailShop()
    {
        $selectedDate = $this->selectedDate;
        $query = "SELECT 
        `products`.`token`,
        `products`.`name` AS `item_name`,
        `products`.`item_code` AS `item_code`,
        `orders__items`.`quantity`,
        `orders__items`.`price_per_unit`,
        `orders__items`.`misc_price`,
        `orders__items`.`units`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        WHERE `orders`.`date_time` LIKE '$selectedDate%'
        AND `orders`.`employee_token`=?
        AND `orders`.`shop_token`=?
        AND `orders`.`token`=?
        AND `orders__items`.`delete_status`=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->bindParam(2, $this->shopToken);
        $stmt->bindParam(3, $this->orderToken);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDateItemDetailShop($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token         = $row['token'];
            $obj->item_name     = $row['item_name'];
            $obj->item_code     = $row['item_code'];
            $obj->quantity      = $row['quantity'];
            $obj->price_per_unit = $row['price_per_unit'];
            $obj->misc_price    = $row['misc_price'];
            $obj->units         = $row['units'];
            array_push($array, $obj);
        }
        return $array;
    }
    function insertOTP($otp)
    {
        $query = "UPDATE `employees` SET `otp`='$otp' WHERE `email_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->emaiId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function verifyOtp()
    {
        $query1 = "SELECT `otp`,`token`,`email_id` FROM `employees` WHERE `otp`=? AND `email_id`=? ";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->otp);
        $stmt1->bindParam(2, $this->emaiId);
        $stmt1->execute();
        return $stmt1;
    }
    function updateEmployeePassword()
    {
        $query = "UPDATE `employees` SET `password`=? WHERE `email_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->password);
        $stmt->bindParam(2, $this->emaiId);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function orderLoadingSheet()
    {
        $selectedDate = $this->selectedDate;
        $query1 = "SELECT 
        `products`.`name` AS `item_name`,
        `products`.`retailer_price`,
        `products`.`piece_count`,
         SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END) AS `total_quantity`,
         SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END)/`products`.`piece_count` AS `total_boxs`,
        MOD(SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END),`products`.`piece_count`) AS `total_pieces`,
        SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END)*`products`.`retailer_price` AS `Prices`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        WHERE `orders`.`date_time` LIKE '$selectedDate%'
        AND `orders`.`employee_token`=? AND `orders`.`delivery` != 'Cancelled' AND `orders__items`.`delete_status`='1' GROUP BY `orders__items`.`product_token`";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->employee_token);
        $stmt1->execute();
        return $stmt1;
    }
    function orderLoadingSheetNew()
    {
        $selectedDate = $this->selectedDate;
        $shop_token = $this->shop_token;
        foreach ($shop_token as $token) {
            $token_value[] = $token;
        }
        $query1 = "SELECT 
        `products`.`name` AS `item_name`,
        `products`.`retailer_price`,
        `products`.`piece_count`,
         SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END) AS `total_quantity`,
         SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END)/`products`.`piece_count` AS `total_boxs`,
        MOD(SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END),`products`.`piece_count`) AS `total_pieces`,
        SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END)*`products`.`retailer_price` AS `Prices`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        WHERE `orders`.`date_time` LIKE '$selectedDate%'
        AND `orders`.`employee_token`=? AND `orders`.`delivery` != 'Cancelled' AND `orders__items`.`delete_status`='1' AND  `orders`.`shop_token` IN (" . implode(',', $token_value) . ") GROUP BY `orders__items`.`product_token`";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1, $this->employee_token);
        $stmt1->execute();
        return $stmt1;
    }
    function getEmployeeLocation()
    {
        $shopQuery = "SELECT 
        `shop`.`name` AS `shop_name`, 
        `employee__map_log`.`latitude`,
        `employee__map_log`.`longitude`,
        `employee__map_log`.`date_time`
        from `employee__map_log` 
        INNER JOIN `shop` ON `employee__map_log`.`shop_token`=`shop`.`token`
        WHERE `employee__map_log`.`employee_token`=? AND DATE(`employee__map_log`.`date_time`) = DATE(CURDATE()) ORDER BY `employee__map_log`.`date_time` ASC";
        $stmtpos = $this->conn->prepare($shopQuery);
        $stmtpos->bindParam(1, $this->employee_token);
        $stmtpos->execute();
        return $stmtpos;
    }
    function viewEmployeeLocation($stmtloc)
    {
        $location_log = [];
        while ($rowlog = $stmtloc->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->shop_name = $rowlog["shop_name"];
            $obj->employee_lat = $rowlog["latitude"];
            $obj->employee_lon = $rowlog["longitude"];
            $obj->date_time = date("h:i:s A", strtotime($rowlog["date_time"]));
            array_push($location_log, $obj);
        }
        return $location_log;
    }
    function getVisitedShopLog()
    {
        $shopQuery = "SELECT 
        `shop`.`name` AS `shop_name`, 
        concat(`employee__map_log`.`latitude`,' , ',`employee__map_log`.`longitude`) AS `position`, 
        `employee__map_log`.`date_time` 
        from `employee__map_log` 
        INNER JOIN `shop` ON `employee__map_log`.`shop_token`=`shop`.`token`
        WHERE `employee__map_log`.`employee_token`=? AND DATE(`employee__map_log`.`date_time`) = DATE(CURDATE()) ORDER BY `employee__map_log`.`date_time` ASC";
        $stmtpos = $this->conn->prepare($shopQuery);
        $stmtpos->bindParam(1, $this->employee_token);
        $stmtpos->execute();
        return $stmtpos;
    }
    function viewVisitedShopLog($stmtloc)
    {
        $log = [];
        while ($rowlog = $stmtloc->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->shop_name = $rowlog["shop_name"];
            $obj->position = $rowlog["position"];
            $obj->date_time = nl2br(date("d/m/Y \n h:i A", strtotime($rowlog['date_time'])));
            array_push($log, $obj);
        }
        return $log;
    }
    //forgot otp
    function sendOTP($mobile, $otp1)
    {
        $url = "https://apii.msg91.com/api/v5/otp?authkey=380803AF0dsqJz8g62f75785P1&country=91&mobile=$mobile&otp=$otp1&template_id=63b3f11fd6fc0572677a5f92";


        // Creating cURL to hit the url and get the response
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json"
            )
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $result = json_decode($response);
    }

    //payment details insert
    function addPaymentDetails($indiaDateTime)
    {
        $query = "INSERT INTO `employees_payment_details` 
    SET `token`=:token,
    `distributor_token`=:distributor_token,
    `bank_name`=:bank_name,
    `date_time`='$indiaDateTime',
    `account_number`=:account_number,
    `bank_code`=:bank_code,
    `holder_name`=:holder_name,
    `gpay`=:gpay,
    `paytm`=:paytm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('bank_name', $this->bank_name);
        $stmt->bindParam('account_number', $this->account_number);
        $stmt->bindParam('bank_code', $this->bank_code);
        $stmt->bindParam('holder_name', $this->holder_name);
        $stmt->bindParam('gpay', $this->gpay);
        $stmt->bindParam('paytm', $this->paytm);
        $stmt->execute();
        return $stmt;
    }
    function selectPaymentDetails()
    {
        $query = "SELECT
    bank_name,
    account_number,
    bank_code,
    holder_name,
    gpay,
    paytm
FROM
    `employees_payment_details` where `distributor_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function editPaymentDetails($indiaDateTime)
    {
        $query = "UPDATE
    `employees_payment_details` 
    SET `token`=:token,
    `distributor_token`=:distributor_token,
    `bank_name`=:bank_name,
    `date_time`='$indiaDateTime',
    `account_number`=:account_number,
    `bank_code`=:bank_code,
    `holder_name`=:holder_name,
    `gpay`=:gpay,
    `paytm`=:paytm";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('distributor_token', $this->distributor_token);
        $stmt->bindParam('bank_name', $this->bank_name);
        $stmt->bindParam('account_number', $this->account_number);
        $stmt->bindParam('bank_code', $this->bank_code);
        $stmt->bindParam('holder_name', $this->holder_name);
        $stmt->bindParam('gpay', $this->gpay);
        $stmt->bindParam('paytm', $this->paytm);
        $stmt->execute();
        return $stmt;
    }
    //profile
    function profileDetailCheckSingle()
    {
        $query = "SELECT `employees`.`token`,
    `employees`.`employees_code`,
    `employees`.`employee_image`,
    `employees`.`name`,
    `employees`.`gender`,
    `deparment`.`name` AS `deparment_name`,
    `employees`.`mobile_number`,
    `employees`.`email_id`,
    `employees`.`join_date`,
    `employees`.`dob`,
    `employees`.`blood_group`,
    `employees`.`address`,
    `employees`.`pincode`,
    `employees`.`street`,
    `employees`.`city`,
    `employees`.`address_proof`,
    `employees`.`language`,
    `employees`.`block_status`
    FROM `employees`
    INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
    WHERE `delete_status`='1'
    AND `employees`.`token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function readprofileDetailsSingle($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = (int)$row['token'];
            $obj->block_status   = (int)$row['block_status'];
            $obj->employee_code  = $row['employees_code'];
            $obj->profile_image  = $row['employee_image'];
            $obj->employee_name  = $row['name'];
            $obj->employee_gender = ucwords(strtolower($row['gender']));
            $obj->employee_deparment_name = $row['deparment_name'];
            $obj->employee_mobile_number = $row['mobile_number'];
            $obj->employee_email_id  = $row['email_id'];
            //$obj->employee_join_date = date("d/m/Y",strtotime($row['join_date']));
            $obj->employee_join_date = date("m/d/Y", strtotime($row['join_date']));
            $obj->employee_dob       = date("m/d/Y", strtotime($row['dob']));
            //$obj->employee_dob       = date("d/m/Y",strtotime($row['dob']));
            $dateOfBirth = $row['dob'];
            $diff = date_diff(date_create($dateOfBirth), date_create($GLOBALS['indiaDate']));
            $obj->employee_age          = $diff->format('%y') . " age";
            $obj->employee_blood_group  = $row['blood_group'];
            $obj->employee_language     = $row['language'];
            $obj->employee_address_proof = $row['address_proof'];
            $obj->employee_address      = $row['address'] . ", " . $row['street'] . ", " . $row['city'] . " - " . $row['pincode'];

            $array_attachment = [];
            $query1 = "SELECT `id`,
        `attachment_url` 
        FROM `employees__attachments`
        WHERE `employee_token`=?";
            $stmt1  = $this->conn->prepare($query1);
            $stmt1->bindParam(1, $row['token']);
            $stmt1->execute();
            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                $obj1 = new stdClass;
                $obj1->attachment_id = $row1['id'];
                $obj1->attachment    = $row1['attachment_url'];
                array_push($array_attachment, $obj1);
            }
            $obj->employee_attachment = $array_attachment;
            array_push($array, $obj);
        }
        return $array;
    }
    function visitequery()
    {
        $query = "SELECT * FROM `salesman_shop_visited` WHERE date = ?  AND employee_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->date);
        $stmt->bindParam(2, $this->emp_token);
        $stmt->execute();
        return $stmt;
    }
    function visitequeryread($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass();
            // $obj->token = $row["token"];
            //$obj->product_token = $row["product_token"];
            $obj1->shop_token = $row["shop_token"];
            $obj1->employee_token = $row["employee_token"];
            $obj1->status = $row["status"];
            array_push($array, $obj1);
        }
        return $array;
    }
}
