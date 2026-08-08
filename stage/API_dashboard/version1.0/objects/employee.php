<?php
class Employee
{
    public $mobileNumber;
    public $employeeToken;
    public $licenseNumber;
    public $token;
    public $name;
    public $code;
    public $emaiId;
    public $department;
    public $gender;
    public $joinDate;
    public $dob;
    public $bloodGroup;
    public $address;
    public $city;
    public $street;
    public $pincode;
    public $image;
    public $proof1;
    public $proof2;
    public $proof3;
    public $proof4;
    public $proof5;
    public $area_token;
    public $state_token;
    public $region_token;
    public $resignation_date;
    public $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    function base64_url_encode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function employeeEmailCheck()
    {
        $this->emaiId = htmlspecialchars(strip_tags($this->emaiId));
        $query = "SELECT `id` FROM `employees` WHERE `email_id`=:email_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('email_id', $this->emaiId);
        $stmt->execute();
        return $stmt;
    }
    function employeeEmailAlreadyExist()
    {
        $this->emaiId = htmlspecialchars(strip_tags($this->emaiId));
        $query = "SELECT `id` FROM `employees` WHERE `email_id`=:email_id AND `token` not in (:token)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('email_id', $this->emaiId);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }
    function employeeMobileNumberCheck()
    {
        $query = "SELECT `id` FROM `employees` WHERE `mobile_number`=:mobileNumber AND `mobile_number` != ''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->execute();
        return $stmt;
    }

    //GST number check
    function licenseNumberCheck()
    {
        $query = "SELECT license_number FROM employees WHERE license_number=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->licenseNumber);
        $stmt->execute();
        return $stmt;
    }
    //area_token check
    // function area_token_validation(){
    //     $query="SELECT `id` FROM `employees` WHERE `area_token`=:area_token AND `area_token` != ''";
    //     $stmt=$conn->this->prepare($query);
    //     $stmt->bindParam(1,$this->area_token);
    //     $stmt->execute();
    //     return $stmt;
    // }

    //update GST number
    function employeeUpdateLicenseNumberCheck()
    {
        $query = "SELECT * FROM `employees` WHERE `license_number`=:licenseNumber AND `license_number` != '' AND `token` not in (:token)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('licenseNumber', $this->licenseNumber);
        $stmt->bindParam('token', $this->token);
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
    function employeeDetailCheckCount()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT `employees`.`id`
        FROM `employees`
        WHERE `delete_status`='1' AND `employees`.`area_token`!=''
        AND `employees`.`deparment_token`='18028120' $stateQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function employeeDetailCheck()
    {
        $this->mobileNumber = htmlspecialchars(strip_tags($this->mobileNumber));
        $query = "SELECT `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`name`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`license_number`,
        `employees`.`join_date`,
        `employees`.`dob`
        FROM `employees`
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        WHERE `delete_status`='1'
        AND `deparment`.`name`='Distributor'
        ORDER BY `employees`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //upload pdf 
    function employeeDetailCheckPdf()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT
        `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`name`,
        `employees`.`mobile_number`,
        `employees__state`.`state_name`,
        `region`.`region_name`,
        `employees`.`email_id`,
        `area`.`area_name`
        FROM
        `employees`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
        INNER JOIN `region` ON `region`.`token` = `employees`.`region_id` 
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
        WHERE `delete_status`='1'
        AND `deparment`.`name`='Distributor' $stateQuery
        ORDER BY `employees`.`id` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    function readEmployeeDetails($stmt)
    {
        $array = [];
        $employeeToken = htmlspecialchars(strip_tags($this->token));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = (int)$row['token'];
            $obj->employee_code  = $row['employees_code'];
            $obj->employee_name  = $row['name'];
            $obj->employee_deparment_name = $row['deparment_name'];
            $obj->employee_mobile_number = $row['mobile_number'];
            $obj->employee_license_number = $row['license_number'];
            $obj->employee_email_id  = $row['email_id'];
            $obj->employee_join_date = date("d/m/Y", strtotime($row['join_date']));
            $obj->employee_dob       = date("d/m/Y", strtotime($row['dob']));
            array_push($array, $obj);
        }
        return $array;
    }
    // function serverEmployeeCheckfilter()
    // {
    //     $searchQuery = $this->searchQuery;
    //     $stateQuery = $this->stateQuery;
    //     $query = "SELECT `employees`.`id`
    //     FROM `employees`
    //     INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    //     INNER JOIN `region` ON `region`.`token` = `employees`.`region_id` 
    //     INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
    //     WHERE `delete_status`='1' AND `employees`.`deparment_token`='18028120' $stateQuery
    //     $searchQuery";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    //     return $stmt;
    // }

    function serverEmployeeCheckfilter()
    {
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT `employees`.`id`
        FROM `employees`
        LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
        LEFT JOIN `region` ON `region`.`token` = `employees`.`region_id` 
        LEFT JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
        WHERE `employees`.`delete_status`='1' AND `employees`.`deparment_token`='18028120' $stateQuery
        $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function order_count($filters)
    {
        $query = "SELECT
        `employees`.`token`,
        `employees`.`name`,
        COUNT(`orders`.`id`) AS `orders_count`,
        `employees`.`mobile_number`,
        `employees__state`.`state_name`,
        `region`.`region_name`
    FROM
        `employees`
    INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    INNER JOIN `orders` ON `orders`.`employee_token` = `employees`.`token`
    INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
    INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
    WHERE
        `employees`.`delete_status` = '1' AND `employees`.`deparment_token` = '18028120' AND 
        `orders`.`order_type` = 'Distributor Order' AND `orders`.`delivery`='Completed' $filters
    GROUP BY
        `employees`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function order_count_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->distributor_token = $row["token"];
            $obj1->distributor_name = $row["name"];
            $obj1->mobile_number = $row["mobile_number"];
            $obj1->state_name = $row["state_name"];
            $obj1->region_name = $row["region_name"];
            $obj1->order_count = $row["orders_count"];
            array_push($arr, $obj1);
        }
        return $arr;
    }

    function no_order($arr_token, $filters)
    {
        $not_in_clause = "";
        if (!empty($arr_token)) {
            $not_in_clause = "AND `employees`.`token` NOT IN ('" . implode("','", $arr_token) . "')";
        }
        
        $query = "SELECT
        `employees`.`token`,
        `employees`.`name`,
        0 AS orders_count,
        `employees`.`mobile_number`,
        `employees__state`.`state_name`,
        `region`.`region_name`
    FROM
        `employees`
    INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
    INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
    WHERE
        `employees`.`delete_status` = '1' AND `employees`.`deparment_token` = '18028120'
        $not_in_clause $filters
    GROUP BY
        `employees`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function no_order_read($stmt1)
    {
        $arr = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->distributor_token1 = $row["token"];
            $obj1->distributor_name = $row["name"];
            $obj1->mobile_number = $row["mobile_number"];
            $obj1->state_name = $row["state_name"];
            $obj1->region_name = $row["region_name"];
            $obj1->order_count = $row["orders_count"];
            array_push($arr, $obj1);
        }
        return $arr;
    }

    // function serverEmployeeCheck()
    // {
    //     $rowStart    = $this->rowStart;
    //     $rowperpage  = $this->rowperpage;
    //     $searchQuery = $this->searchQuery;
    //     $stateQuery  = $this->stateQuery;
    //     $columnName  = $this->columnName;
    //     $columnSortOrder = $this->columnSortOrder;

    //     $query = "SELECT
    //         `employees`.`token`,
    //         `employees`.`employees_code`,
    //         `employees`.`name`,
    //         `employees`.`mobile_number`,
    //         `employees__state`.`state_name`,
    //         `region`.`region_name`,
    //         `area`.`area_name`,
    //         `employees`.`email_id`,
    //         `employees`.`join_date`,
    //         `employees`.`block_status`,
    //         `employees`.`delete_status`,
    //         `employees`.`send_otp`,
    //         `employees`.`address`,
    //         `employees`.`city`,
    //         `employees`.`pincode`,
    //         `employees`.`license_number`,
    //         (
    //             SELECT GROUP_CONCAT(`products__category`.`name` SEPARATOR ', ')
    //             FROM `employees__division_mapping`
    //             INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
    //             WHERE `employees__division_mapping`.`employee_token` = `employees`.`token`
    //             AND `employees__division_mapping`.`delete_status` = '1'
    //         ) AS division_Name
    //     FROM
    //         `employees`
    //         INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    //         INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
    //         INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
    //     WHERE
    //         `employees`.`delete_status` = '1'
    //         AND `employees`.`deparment_token` = '18028120'
    //         $stateQuery
    //         $searchQuery
    //     ORDER BY $columnName $columnSortOrder
    //     LIMIT $rowStart, $rowperpage";

    //     $stmt = $this->conn->prepare($query);
    //     $stmt->execute();
    //     return $stmt;
    // }

   
   
    function serverEmployeeCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery  = $this->stateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;

        $query = "SELECT
            `employees`.`token`,
            `employees`.`employees_code`,
            `employees`.`name`,
            `employees`.`mobile_number`,
            COALESCE(`employees__state`.`state_name`, '') AS state_name,
            COALESCE(`region`.`region_name`, '') AS region_name,
            COALESCE(`area`.`area_name`, '') AS area_name,
            `employees`.`email_id`,
            `employees`.`join_date`,
            `employees`.`block_status`,
            `employees`.`delete_status`,
            `employees`.`send_otp`,
            `employees`.`address`,
            `employees`.`city`,
            `employees`.`pincode`,
            `employees`.`license_number`,
            (
                SELECT GROUP_CONCAT(`products__category`.`name` SEPARATOR ', ')
                FROM `employees__division_mapping`
                INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
                WHERE `employees__division_mapping`.`employee_token` = `employees`.`token`
                AND `employees__division_mapping`.`delete_status` = '1'
            ) AS division_Name
        FROM
            `employees`
            LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
            LEFT JOIN `region` ON `region`.`token` = `employees`.`region_id`
            LEFT JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
        WHERE
            `employees`.`delete_status` = '1'
            AND `employees`.`deparment_token` = '18028120'
            $stateQuery
            $searchQuery
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart, $rowperpage";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
   
   
   
    function serverReadEmployee($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            if ($row['send_otp'] == "1") {
                $sendBtn = '<button type="button" data-clk_btn"" class="sendcrds">Send</button>';
            } else {
                $sendBtn = '<button type="button" data-clk_btn"" class="sendcrds">Resend</button>';
            }
            $fullAddress = $row['address'] . ', ' . $row['city'] . ' - ' . $row['pincode'];
            if($row['block_status'] == "1"){
                $status = "Active";
            }else{
                $status = "Deactive";
            }
            $data[] = array(
                "slno" => $slno,
                "employee_token" => $row['token'],
                "employee_code" => '<a href="javascript:void(0)" class="view_link employee_code_view" >' . $row['employees_code'] . '</a>',
                "employee_name" => $row['name'],
                "employee_mobile_number" => $row['mobile_number'],
                "employee_email_id" => $row['email_id'],
                "employee_join_date" => date("m/d/Y", strtotime($row['join_date'])),
                "state_name" => $row['state_name'],
                "region" => $row['region_name'],
                "employee_area" => $row['area_name'],
                "delete_status" => $row['delete_status'],
                "full_address" => $fullAddress,
                "status"=> $status,
                "division"=> $row['division_Name'],
                "block_status" => $row['block_status'],
                "action" => '<a><img src="assets/edit.png" class="edit_input employee_code_edit" alt=""></a>',
                "deactivate" => '<button type="button" class="table_deactivate_btn" data-token="' . $row['token'] . '" data-status="' . $row['block_status'] . '" data-name="' . $row['name'] . '" data-mobile="' . $row['mobile_number'] . '" data-email="' . $row['email_id'] . '" data-license="' . $row['license_number'] . '" style="padding:3px 8px;font-size:12px;border-radius:4px;cursor:pointer;border:1px solid ' . ($row['block_status'] == '1' ? '#e53e3e' : '#38a169') . ';background:' . ($row['block_status'] == '1' ? '#e53e3e' : '#38a169') . ';color:#fff;">' . ($row['block_status'] == '1' ? 'Deactivate' : 'Activate') . '</button>',
                "send_password" => $sendBtn
            );
        }
        return $data;
    }
    function serverEmployeeCheck_app()
    {
        $query = "SELECT
        `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`name`,
        `employees`.`mobile_number`,
        `employees__state`.`state_name`,
        `region`.`region_name`,
        `area`.`area_name`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`block_status`,
        `sales_rep_add_distributor`.`status_code` AS delete_status,
        sales_rep_add_distributor.rep_token
    FROM
        `employees`
    INNER JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
    INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
    INNER JOIN sales_rep_add_distributor ON sales_rep_add_distributor.distributor_token = employees.token
    WHERE `employees`.`deparment_token` = '18028120' ORDER BY sales_rep_add_distributor.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function serverReadEmployee_app($func)
    {
        $data = array();
        // $slno = $this->rowStart;
        while ($row = $func->fetch(PDO::FETCH_ASSOC)) {
            $status = ($row['delete_status'] == '0') ? 'Pending' : (($row['delete_status'] == 1) ? 'Approved' : 'Rejected');
            $data[] = array(
                // "slno"=>$slno,
                "employee_token" => $row['token'],
                "employee_code" => $row['employees_code'],
                "employee_name" => $row['name'],
                "employee_mobile_number" => $row['mobile_number'],
                "employee_email_id" => $row['email_id'],
                "employee_join_date" => date("m/d/Y", strtotime($row['join_date'])),
                "state_name" => $row['state_name'],
                "region" => $row['region_name'],
                "employee_area" => $row['area_name'],
                "delete_status" => $row['delete_status'],
                "status" => $status,
                "block_status" => $row['block_status'],
                "rep_token" => $row['rep_token'],
                // "action"=> '<a><img src="assets/edit.png" class="edit_input employee_code_edit" alt=""></a>', 
            );
        }
        return $data;
    }
    // rep add distributor edit show data
    function employeeDetailCheckSingle_rep()
    {
        $query = "SELECT
        `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`employee_image`,
        `employees`.`name`,
        `employees`.`gender`,
        `employees`.`region_id`,
        `employees`.`license_number`,
        `employees`.`deparment_token`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`dob`,
        `employees`.`blood_group`,
        `employees`.`address`,
        `employees`.`area_token`,
        `area`.`area_name`,
        `employees`.`pincode`,
        `employees`.`street`,
        `employees`.`city`,
        `employees`.`address_proof`,
        `employees`.`block_status`,
        `region`.`region_name`,
        GROUP_CONCAT(`products__category`.`name`, '****') AS `division_name`,
        `employees__state`.`state_token`,
        `employees__state`.`state_name`
        
    FROM
        `employees`
    INNER JOIN `deparment` ON `deparment`.`token` = `employees`.`deparment_token`
    INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token` = `employees`.`token`
    INNER JOIN `products__category` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
    INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
    INNER JOIN `area` ON `area`.`area_token` = `employees`.`area_token`
    LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
    LEFT JOIN `sales_rep_add_distributor` ON `sales_rep_add_distributor`.`distributor_token` = `employees`.`token`
    WHERE
        `employees__division_mapping`.`delete_status` = '1' AND `sales_rep_add_distributor`.`distributor_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->execute();
        return $stmt;
    }

    function employeeDetailCheckSingle()
    {
        $query = "SELECT `employees`.`token`,
        `employees`.`employees_code`,
        `employees`.`employee_image`,
        `employees`.`name`,
        `employees`.`gender`,
        `employees`.`region_id`,
        `employees`.`license_number`,
        `employees`.`deparment_token`,
        `deparment`.`name` AS `deparment_name`,
        `employees`.`mobile_number`,
        `employees`.`email_id`,
        `employees`.`join_date`,
        `employees`.`dob`,
        `employees`.`blood_group`,
        `employees`.`address`,
        `employees`.`area_token`,
        `area`.`area_name`,
         `employees`.`pincode`,
        `employees`.`street`,
        `employees`.`city`,
        `employees`.`address_proof`,
        `employees`.`block_status`,
        `region`.`region_name`,
        GROUP_CONCAT(`products__category`.`name`, '****') AS `division_name`,
        `employees__state`.`state_token`,
        `employees__state`.`state_name`,
        `employees__division_mapping`.`division_token`
        FROM `employees`
        INNER JOIN `deparment` ON `deparment`.`token`=`employees`.`deparment_token`
        INNER JOIN `employees__division_mapping` ON `employees__division_mapping`.`employee_token`=`employees`.`token`
        INNER JOIN `products__category` ON `products__category`.`token`=`employees__division_mapping`.`division_token`
        INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
        INNER JOIN `area` ON `area`.`area_token`=`employees`.`area_token`
        LEFT JOIN `employees__state` ON `employees__state`.`state_token` = `employees`.`state_id`
        WHERE `employees`.`delete_status`='1' AND `employees__division_mapping`.`delete_status`='1'
        AND `employees`.`token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDetailsSingle($stmt)
    {
        $indiaDate = $this->indiaDate;
        $array = [];
        $employeeToken = htmlspecialchars(strip_tags($this->token));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token  = (int)$row['token'];
            $obj->block_status    = (int)$row['block_status'];
            $obj->employee_code   = $row['employees_code'];
            $obj->profile_image   = $row['employee_image'];
            $obj->employee_name   = $row['name'];
            $obj->employee_address = $row['address'];
            $obj->employee_area = $row['area_token'];
            $obj->employee_area_name = $row['area_name'];
            $obj->employee_pincode = $row['pincode'];
            $obj->employee_street = $row['street'];
            $obj->employee_city   = $row['city'];
            $obj->employee_gender = ucwords(strtolower($row['gender']));
            $obj->employee_gender_val    = strtolower($row['gender']);
            $obj->region_id    = $row['region_id'];
            $obj->state_token    = $row['state_token'];
            $obj->state_name    = $row['state_name'];
            $obj->employee_deparment_name = $row['deparment_name'];
            $obj->employee_mobile_number = $row['mobile_number'];
            $obj->employee_email_id      = $row['email_id'];
            //$obj->employee_join_date     = date("d/m/Y",strtotime($row['join_date']));
            $obj->employee_join_date     = date("m/d/Y", strtotime($row['join_date']));
            $obj->employee_dob           = date("m/d/Y", strtotime($row['dob']));
            //$obj->employee_dob           = date("d/m/Y",strtotime($row['dob']));
            $dateOfBirth = $row['dob'];
            $diff = date_diff(date_create($dateOfBirth), date_create($indiaDate));
            $obj->employee_age            = $diff->format('%y') . " age";
            $obj->employee_blood_group    = $row['blood_group'];
            $obj->employee_address_proof  = $row['address_proof'];
            $obj->employee_license_number = $row['license_number'];
            $obj->employee_deparment_token = $row['deparment_token'];
            $obj->division_token = $row['division_token'];
            $obj->employee_region_name = $row['region_name'];
            $obj->employee_address_full      = $row['address'] . ", " . $row['city'] . " - " . $row['pincode'];
            $array_division = [];
            $division_string  = rtrim($row["division_name"], '****');
            $array_division = explode("****,", $division_string);
            $obj->division_name = $array_division;

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

            $array_division = [];
            $query2 = "SELECT `id`,
            `division_token`
            FROM `employees__division_mapping`
            WHERE `employee_token`=?
            AND delete_status='1'";
            $stmt2  = $this->conn->prepare($query2);
            $stmt2->bindParam(1, $row['token']);
            $stmt2->execute();
            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                array_push($array_division, $row2['division_token']);
            }
            $obj->employee_attachment = $array_attachment;
            $obj->employee_division  = $array_division;
            array_push($array, $obj);
        }
        return $array;
    }
    function addEmployee($indiaDateTime)
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $query = "INSERT INTO `employees` 
        SET `token`=:token,
        `name`=:name,
        `date_time`='$indiaDateTime',
        `employees_code`=:code,
        `email_id`=:email,
        `password`=:password,
        `support_password`='6a8eabb9447e2fd817035c282e2275d4fa21f91409dd4726eb071d35e645418192feb3b5f0c60ff836345481bcf3739e3c728e91bd97aa191f92c148be4becae',
        `deparment_token`=:department,
        `admin_distributor_token`='',
        `region_id`=:employee_region,
        `gender`='',
        `mobile_number`=:mobile,
        `join_date`=:joindate,
        `dob`='',
        `blood_group`='',
        `address`=:address,
        `street`='',
        `area_token`=:area,
        `city`=:city,
        `pincode`=:pincode,
        `address_proof`=:addressproof,
        `state_id`=:employee_state,
        `delete_status`='1',
        `employee_image`=:image,
        `license_number`=:license_number";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('code', $this->code);
        $stmt->bindParam('email', $this->emaiId);
        $stmt->bindParam('password', $this->password);
        $stmt->bindParam('department', $this->department);
        $stmt->bindParam('employee_region', $this->employee_region);
        $stmt->bindParam('mobile', $this->mobileNumber);
        $stmt->bindParam('joindate', $this->joinDate);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('area', $this->area);
        $stmt->bindParam('city', $this->city);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('addressproof', $this->proof1);
        $stmt->bindParam('employee_state', $this->employee_state);
        $stmt->bindParam('image', $this->image);
        $stmt->bindParam('license_number', $this->licenseNumber);
        $stmt->execute();
        return $stmt;
    }
    function addEmployee_log($indiaDateTime)
    {
        $query = "INSERT INTO `distributor_log1` SET
            `distributor_token`=?,
            `old_name`=?,
            `old_mobile`=?,
            `old_license`=?,
            `old_email`=?,
            `created_by`=?,
            `block_status`='1',
            `date_and_time`= '$indiaDateTime',
            `status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->name);
        $stmt->bindParam(3, $this->mobileNumber);
        $stmt->bindParam(4, $this->licenseNumber);
        $stmt->bindParam(5, $this->emaiId);
        $stmt->bindParam(6, $this->admin_token);
        $stmt->execute();
        return $stmt;
    }
    function editEmployee_log($indiaDateTime, $divisionArray, $olddivisionArray)
    {
        // $token=$this->token;
        // $name = $this->name;
        // $old_name = $this->old_name;
        // $mobile =  $this->mobileNumber;
        // $old_mobilenumber = $this->old_mobilenumber;
        // $license_number =  $this->licenseNumber;
        // $old_licens = $this->old_licens;
        // $email =  $this->emaiId;
        // $old_email = $this->old_email;
        // $admin_token = $this->admin_token;  
        // // foreach ($divisionArray as $division_token) {
        // //     foreach ($olddivisionArray as  $old_division_token) {
        // //         $arr[]="('$token','$old_name','$name','$old_mobilenumber','$mobile','$old_licens','$license_number','$old_email','$email','$old_division_token','$division_token','$admin_token','1','2','$indiaDateTime')";
        // //     }

        // // }
        $query = "INSERT INTO `distributor_log1` SET
            `distributor_token`=?,
            `old_name`=?,
            `new_name`=?,
            `old_mobile`=?,
            `new_mobile`=?,
            `old_license`=?,
            `new_license`=?,
            `old_email`=?,
            `new_email`=?,
            `created_by`=?,
            `block_status`='1',
            `date_and_time`='$indiaDateTime',
            `status`='2'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->old_name);
        $stmt->bindParam(3, $this->name);
        $stmt->bindParam(4, $this->old_mobilenumber);
        $stmt->bindParam(5, $this->mobileNumber);
        $stmt->bindParam(6, $this->old_licens);
        $stmt->bindParam(7, $this->licenseNumber);
        $stmt->bindParam(8, $this->old_email);
        $stmt->bindParam(9, $this->emaiId);
        $stmt->bindParam(10, $this->admin_token);
        $stmt->execute();
        return $stmt;
    }
    //area insert
    function area_insert($indiaDateTime)
    {
        $query = "INSERT INTO `area`  SET `state_token`=:employee_state,`region_token`=:employee_region,`area_token`=:area_token,`area_name`=:area,`datetime`='$indiaDateTime'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('employee_state', $this->employee_state);
        $stmt->bindParam('employee_region', $this->employee_region);
        $stmt->bindParam('area_token', $this->area_token);
        $stmt->bindParam('area', $this->area);
        $stmt->execute();
        return true;
    }

    function updateEmployee($indiaDateTime)
    {
        $this->name = htmlspecialchars(strip_tags($this->name));
        $query = "UPDATE `employees` 
        SET `name`=:name,
        `email_id`=:email,
        `deparment_token`=:department,
        `region_id`=:employee_region,
        `gender`='',
        `mobile_number`=:mobile,
        `join_date`=:joindate,
        `dob`='',
        `blood_group`='',
        `address`=:address,
        `area_token`=:area,
        `street`=:street,
        `city`=:city,
        `pincode`=:pincode,
        `address_proof`=:addressproof,
        `state_id`=:employee_state,
        `employee_image`=:image,
        `license_number`=:license_number
        WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('name', $this->name);
        $stmt->bindParam('email', $this->emaiId);
        $stmt->bindParam('department', $this->department);
        $stmt->bindParam('employee_region', $this->employee_region);
        $stmt->bindParam('mobile', $this->mobileNumber);
        $stmt->bindParam('joindate', $this->joinDate);
        $stmt->bindParam('address', $this->address);
        $stmt->bindParam('area', $this->area);
        $stmt->bindParam('street', $this->street);
        $stmt->bindParam('city', $this->city);
        $stmt->bindParam('pincode', $this->pincode);
        $stmt->bindParam('addressproof', $this->proof1);
        $stmt->bindParam('image', $this->image);
        $stmt->bindParam('license_number', $this->licenseNumber);
        $stmt->bindParam('employee_state', $this->employee_state);
        $stmt->execute();
        return $stmt;
    }
    function send_otp()
    {
        $query = "UPDATE `employees` 
        SET `send_otp`='2'
        WHERE `token`=:token 
        AND `email_id`=:email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('email', $this->email);
        $stmt->execute();
        return $stmt;
    }
    function insertDistributorPassword()
    {
        $query = "UPDATE `employees` 
        SET `password`=:password
        WHERE `token`=:token 
        AND `email_id`=:email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('email', $this->email);
        $stmt->bindParam('password', $this->password);
        $stmt->execute();
        return $stmt;
    }
    function deleteAllDivision()
    {
        $query = "UPDATE `employees__division_mapping` 
        SET `delete_status`='2'
        WHERE `employee_token`=:employee_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('employee_token', $this->token);
        $stmt->execute();
    }
    function divisionInsert($divisionToken, $indiaDateTime)
    {
        $query = "INSERT INTO `employees__division_mapping` 
        SET `employee_token`=:employee_token,
        `division_token`=:division_token,
        `delete_status`=1,
        `datetime`='$indiaDateTime'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('employee_token', $this->token);
        $stmt->bindParam('division_token', $divisionToken);
        $stmt->execute();
        return true;
    }
    function insertDistributorStock($divisionToken)
    {
        $distributor_token = $this->token;
        $prodQuery = "SELECT `category_token`, `token` AS `product_token` FROM `products` WHERE `category_token`='$divisionToken'";
        $prodStmt = $this->conn->prepare($prodQuery);
        $prodStmt->execute();
        $distributor_stock = [];
        while ($distrow = $prodStmt->fetch(PDO::FETCH_ASSOC)) {
            $distributor_stock[] = "(" . $distrow["product_token"] . "," . $distrow["category_token"] . ",'$distributor_token','0','0','0','0','Added','0')";
        }
        $stockInsert = "INSERT INTO `stock__distributor`(`product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs`, `aog`, `status`,`is_active`) VALUES " . implode(", ", $distributor_stock);
        $intStmt = $this->conn->prepare($stockInsert);
        if ($intStmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function divisionUpdate($divisionToken)
    {
        $query = "UPDATE `employees__division_mapping` 
        SET `delete_status`='1'
        WHERE `employee_token`=:employee_token
        AND `division_token`=:division_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('employee_token', $this->token);
        $stmt->bindParam('division_token', $divisionToken);
        $stmt->execute();
    }
    function employeeDivisionCheck($division)
    {
        $query = "SELECT `id` 
        FROM `employees__division_mapping` 
        WHERE `employee_token`=:employee_token 
        AND `division_token`=:division_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('employee_token', $this->token);
        $stmt->bindParam('division_token', $division);
        $stmt->execute();
        return $stmt;
    }
    //===update distributor log
    // function update_distributor_log($division,$indiaDateTime){
    //     $query = "UPDATE `distributor_log`
    //     SET `new_name`= ?,`new_mobile`=?,`new_license`=?,`new_email`=?,`new_division`='$division',`status`= '1',`update_date_time`='$indiaDateTime'
    //     WHERE `distributor_token`= ?
    //     AND `status`= '0'";
    //    $stmt = $this->conn->prepare( $query );
    //    $stmt->bindParam(1, $this->name);
    //    $stmt->bindParam(2, $this->mobileNumber);
    //    $stmt->bindParam(3, $this->licenseNumber);
    //    $stmt->bindParam(4, $this->emaiId);
    //    $stmt->bindParam(5, $this->token);
    //    $stmt->execute();
    //    return $stmt;
    // }
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
    function employeeStatusUpdate_log($indiaDateTime, $division_token)
    {
        $query = "UPDATE `distributor_log` SET `block_status`=?,`status`=?,`inactive_date_time`='$indiaDateTime',`active_data_time`='$indiaDateTime' WHERE `distributor_token`=? AND `status`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->statusValue);
        $stmt->bindParam(2, $this->statusValue);
        $stmt->bindParam(3, $this->employeeToken);
        $stmt->execute();
        return true;
    }

    function addEmployee_log_status($indiaDateTime, $division_areay)
    {
        $query = "INSERT INTO `distributor_log1` SET
                `distributor_token`=?,
                `old_name`=?,
                `old_mobile`=?,
                `old_license`=?,
                `old_email`=?,
                `created_by`=?,
                `block_status`=?,
                `date_and_time`= '$indiaDateTime',
                `status`='3'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->bindParam(2, $this->employee_name);
        $stmt->bindParam(3, $this->mobile_numbr);
        $stmt->bindParam(4, $this->employee_licens);
        $stmt->bindParam(5, $this->employee_gmail);
        $stmt->bindParam(6, $this->admin_token);
        $stmt->bindParam(7, $this->statusValue);
        $stmt->execute();
        return $stmt;
    }

    function employeeDailyCount()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT 
        `orders`.`date_time`
        FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE `orders`.`delivery` != 'Cancelled'
        GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function employeeDaliyCheckFilter()
    {
        $dateQuery   = $this->dateQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT 
         `orders`.`date_time`
         FROM `orders` 
         INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
         INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
         INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
         INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
         INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
         INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
         WHERE 1
         $dateQuery AND `orders`.`delivery` != 'Cancelled'
         GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function employeeDaliyCheckSearch()
    {
        $searchQuery   = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT 
        `orders`.`date_time`
        FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE 1 
        $searchQuery AND `orders`.`delivery` != 'Cancelled'
        GROUP BY `orders`.`employee_token`,CAST(`orders`.`date_time` AS DATE)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function serverEmployeeDailySummaryCheck()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $stateQuery = $this->stateQuery;
        $searchQuery = $this->searchQuery;
        $dateQuery   = $this->dateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT 
        `orders`.`date_time`, 
        `orders`.`billing_amount`,
        `sales_man`.`name` AS `employee_name`, 
        `sales_man`.`token` AS `employee_token`, 
        `deparment`.`name` AS `department_name`,
        `distributor`.`name` AS `distributor_name`,
        COUNT(DISTINCT `orders`.`shop_token`) AS `outlet_covered`,
        `orders`.`unit_shop_count` AS `outletList`,
        `units`.`name` AS `location_name`,
        `units`.`token` AS `unit_token`
       	FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token` $stateQuery
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        WHERE 1
        $searchQuery
        $dateQuery AND `orders`.`delivery` != 'Cancelled'
        GROUP BY `orders`.`employee_token`, CAST(`orders`.`date_time` AS DATE)
        ORDER BY $columnName $columnSortOrder
        LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
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
            $data[] = array(
                "slno" => $slno,
                "date_value" => date("Y-m-d", strtotime($row['date_time'])),
                "billing" => $row['billing_amount'],
                "employee_token" => $row['employee_token'],
                "date_time" => '<a class="view_link" >' . date("d/m/Y", strtotime($row['date_time'])) . '</a>',
                "distributor_name" => $row['distributor_name'],
                "employee_name" => ucwords($row['employee_name']),
                "deparment_name" => ucwords($row['department_name']),
                "outlet" => $row['department_name'] == 'Sales' ? '<a style="color:#00B9F5" id="btn" data-toggle="modal" data-emp_token ="' . $row['employee_token'] . '" >' . $row['outlet_covered'] . '/' . $row['outletList'] . '</a>' : $row['outlet_covered'] . '/' . $row['outletList'],
                "location_name" => ucwords($row['location_name']),
                "productivity" => round((float)$productivity * 5, 2) . '/5'
            );
        }
        return $data;
    }
    //===== custom beat daily summery
    function customEmployeeDailySummaryCheck($dateQuery)
    {
        //  $dateQuery   = $this->dateQuery;
        $query = "SELECT 
        `orders`.`date_time`, 
        `orders`.`billing_amount`,
        `sales_man`.`name` AS `employee_name`, 
        `sales_man`.`token` AS `employee_token`, 
        `deparment`.`name` AS `department_name`,
        `distributor`.`name` AS `distributor_name`,
        COUNT(DISTINCT `orders`.`shop_token`) AS `outlet_covered`,
        `orders`.`unit_shop_count` AS `outletList`,
        `units`.`name` AS `location_name`,
        `units`.`token` AS `unit_token`,
        unit_customise.customunit_name,
        unit_customise.token AS customunit_token
       	FROM `orders` 
        INNER JOIN `employees` AS `sales_man` ON `sales_man`.`token`=`orders`.`employee_token`
        INNER JOIN `employees` AS `distributor` ON `distributor`.`token`=`orders`.`distributor_token`
        INNER JOIN `deparment` ON `sales_man`.`deparment_token` = `deparment`.`token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `units` ON `shop_mapping`.`unit_token` = `units`.`token`
        INNER JOIN unit_customise_mapping ON unit_customise_mapping.unit_token = units.token
        INNER JOIN  unit_customise ON unit_customise.token = unit_customise_mapping.custom_unit_token
        WHERE 1
        AND `orders`.`delivery` != 'Cancelled' $dateQuery
        GROUP BY `orders`.`employee_token`, CAST(`orders`.`date_time` AS DATE),unit_customise.token
        ORDER BY unit_customise_mapping.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function customreadEmployeeDailySummary($stmt)
    {
        $data = array();
        $slno = $this->rowStart;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $slno++;
            $productivity = $row['outlet_covered'] . '/' . $row['outletList'];
            $data[] = array(
                "slno" => $slno,
                "date_value" => date("Y-m-d", strtotime($row['date_time'])),
                "billing" => $row['billing_amount'],
                "employee_token" => $row['employee_token'],
                "date_time" => '<a class="view_link" data-employee_token="' . $row['employee_token'] . '" data-date_value="' . date("Y-m-d", strtotime($row['date_time'])) . '" data-outlet="' . $row['outlet_covered'] . '/' . $row['outletList'] . '">' . date("d/m/Y", strtotime($row['date_time'])) . '</a>',
                "distributor_name" => $row['distributor_name'],
                "employee_name" => ucwords($row['employee_name']),
                "deparment_name" => ucwords($row['department_name']),
                "outlet" => $row['department_name'] == 'Sales' ? '<a style="color:#00B9F5" id="btn" data-toggle="modal" data-emp_token ="' . $row['employee_token'] . '" >' . $row['outlet_covered'] . '/' . $row['outletList'] . '</a>' : $row['outlet_covered'] . '/' . $row['outletList'],
                "location_name" => ucwords($row['customunit_name']),
                "productivity" => round((float)$productivity * 5, 2) . '/5'
            );
        }
        return $data;
    }

    function employeeDateDetail()
    {
        $selectedDate = $this->selectedDate;
        $query = "SELECT 
        `orders`.`token`,
        -- `shop`.`token` AS `shop_token`,
        `shop_mapping`.`token`  AS `shop_token`,
        `shop`.`name` AS `shop_name`,
        `shop__type`.`name` AS `shop_type`,
        `employees`.`name` AS `employee_name`,
        `orders`.`items`,
        `orders`.`billing_amount`
        FROM `orders`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token` = `shop_mapping`.`shop_token`
        INNER JOIN `shop__type` ON `shop__type`.`token`=`shop`.`shop_type_code`
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        WHERE `orders`.`date_time` LIKE '$selectedDate%' AND `orders`.`delivery` != 'Cancelled' AND `orders`.`employee_token`=? ORDER BY `orders`.`date_time` desc";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDateDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->order_token   = $row['token'];
            $obj->shop_token    = $row['shop_token'];
            $obj->shop_name     = $row['shop_name'];
            $obj->shop_type     = $row['shop_type'];
            $obj->employee_name = $row['employee_name'];
            $obj->items         = $row['items'];
            $obj->billing_amount = $row['billing_amount'];
            array_push($array, $obj);
        }
        return $array;
    }

    function employeeDateItemDetail()
    {
        $selectedDate = $this->selectedDate;
        $query = "SELECT 
        `products`.`name` AS `item_name`,
         SUM(CASE
        	WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        	WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        	Else 0
        	END) AS `quantity`,
        `orders__items`.`price_per_unit`,
        `orders__items`.`misc_price`,
        `orders__items`.`units`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        WHERE `orders`.`date_time` LIKE '$selectedDate%' AND `orders`.`delivery` != 'Cancelled' AND `orders`.`employee_token`=? GROUP BY `orders__items`.`product_token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->execute();
        return $stmt;
    }
    function readEmployeeDateItemDetail($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->item_name     = $row['item_name'];
            $obj->quantity      = $row['quantity'];
            $obj->price_per_unit = $row['price_per_unit'];
            $obj->misc_price    = $row['misc_price'];
            $obj->units         = 'Nos';
            array_push($array, $obj);
        }
        return $array;
    }
    function employeeDateItemDetailShop()
    {
        $selectedDate = $this->selectedDate;
        $query = "SELECT 
        `products`.`name` AS `item_name`,
        `products`.`item_code` AS `item_code`,
        `orders__items`.`quantity`,
        `orders__items`.`price_per_unit`,
        `orders__items`.`misc_price`,
        `orders__items`.`units`
        FROM `orders`
        INNER JOIN `orders__items` ON `orders__items`.`order_token`=`orders`.`token`
        INNER JOIN `products` ON `products`.`token`=`orders__items`.`product_token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
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
    function getAllRegion()
    {
        $stateQuery = $this->stateQuery;
        $queryregion = "SELECT `region`.`token`, `region`.`region_name`, `employees__state`.`state_name`, `employees__state`.`state_token`  FROM `region`
        INNER JOIN `employees__state` ON `region`.`state_id` = `employees__state`.`state_token` WHERE `region`.`status`='1' $stateQuery";
        $stmtregion = $this->conn->prepare($queryregion);
        $stmtregion->execute();
        $array_region = [];
        while ($row1 = $stmtregion->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->region_token = $row1['token'];
            $obj->region_name = $row1['region_name'];
            $obj->state_name = $row1['state_name'];
            $obj->state_token = $row1['state_token'];
            array_push($array_region, $obj);
        }
        return $array_region;
    }
    function getAllStates()
    {
        $state_token = $this->state_token;
        $querystate = "SELECT `state_token`, `state_name` FROM `employees__state` WHERE 1 $state_token";
        $stmtstate = $this->conn->prepare($querystate);
        $stmtstate->execute();
        $array_state = [];
        while ($row1 = $stmtstate->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->state_token = $row1['state_token'];
            $obj->state_name = $row1['state_name'];
            array_push($array_state, $obj);
        }
        return $array_state;
    }
    function getRegions()
    {
        $query = "SELECT `token`, `region_name` FROM `region` WHERE `status`='1'";
        $stmtregion = $this->conn->prepare($query);
        $stmtregion->execute();
        $array_region = [];
        while ($row1 = $stmtregion->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row1['token'];
            $obj->region_name = $row1['region_name'];
            array_push($array_region, $obj);
        }
        return $array_region;
    }
    
    function deleteRegion()
    {
        $query = "UPDATE `region` SET `status`='2' WHERE `token`=:token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':token', $this->region_token);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function addRegion($indiaDateTime)
    {
        $query1 = "INSERT INTO `region` SET
       `date_time`='$indiaDateTime',
       `token`=:token,
       `region_name`=:region_name,
       `state_id`=:state_token";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam('token', $this->token);
        $stmt1->bindParam('region_name', $this->region_name);
        $stmt1->bindParam('state_token', $this->state_token);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function updateRegionName($indiaDateTime)
    {
        $query2 = "UPDATE `region` SET `date_time`='$indiaDateTime', `region_name`=?, `state_id`=? WHERE `token`=?";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->bindParam(1, $this->region_name);
        $stmt2->bindParam(2, $this->state_token);
        $stmt2->bindParam(3, $this->region_token);
        if ($stmt2->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function salesRepCount()
    {
        $salesRepquery = "SELECT `id` FROM `employees` WHERE `deparment_token`=72602780";
        $stmtrep = $this->conn->prepare($salesRepquery);
        $stmtrep->execute();
        return $stmtrep;
    }
    function serverSalesRepCheck()
    {
        $stateQuery = $this->stateQuery;
        $query = "SELECT
        `employees`.`token`,
        `employees`.`name`,
        `employees__state`.`state_name`,
        `region`.`region_name`,
        `employees`.`state_id` AS state_token,
        `employees`.`email_id`,
        `employees`.`mobile_number`,
        `employees`.`date_time`,
        `employees`.`deparment_token`,
        `employees`.`block_status`,
        `employees`.`resignation_date`
        FROM
        `employees`
        INNER JOIN `region` ON `employees`.`region_id`=`region`.`token`
        LEFT JOIN `employees__state` ON `employees`.`state_id`=`employees__state`.`state_token`
        WHERE `deparment_token` IN (72602780,98765433,98765434) $stateQuery
        ORDER BY
        CASE
            WHEN LOWER(REPLACE(`employees__state`.`state_name`, ' ', '')) IN ('tamilnadu', 'tamilnad') THEN 1
            WHEN LOWER(REPLACE(`employees__state`.`state_name`, ' ', '')) = 'karaikal' THEN 2
            WHEN LOWER(REPLACE(`employees__state`.`state_name`, ' ', '')) IN ('puducherry', 'pondicherry') THEN 3
            ELSE 4
        END ASC,
        `employees__state`.`state_name` ASC,
        `region`.`region_name` ASC,
        `employees`.`name` ASC,
        `employees`.`date_time` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readSalesRepCheck($stmt)
    {
        $array_salesrep = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = $row1['token'];
            $obj->employee_name = $row1['name'];
            $obj->state_name = $row1['state_name'];
            $obj->region_name = $row1['region_name'];
            $obj->state_token = $row1['state_token'];
            $obj->email_id = $row1['email_id'];
            $obj->mobile_number = $row1['mobile_number'];
            $obj->deparment_token = $row1['deparment_token'];
            $obj->block_status = $row1['block_status'];
            $obj->resignation_date = $row1['resignation_date'] ? date("d/m/Y", strtotime($row1['resignation_date'])) : '';
            $obj->date_time = nl2br(date("d/m/Y \n h:i A", strtotime($row1['date_time'])));
            array_push($array_salesrep, $obj);
        }
        return $array_salesrep;
    }
    function insertNewSalesRep($indiaDateTime)
    {
        $insertSales = "INSERT INTO `employees` SET
        `token`=:token,
        `name`=:sales_rep_name,
        `date_time`='$indiaDateTime',
        `employees_code`=:employee_code,
        `email_id`=:sales_rep_mailid,
        `password`='',
        -- `deparment_token`='72602780',
        `deparment_token`=:rolls_token,
        `admin_distributor_token`='',
        `region_id`=:region_token,
        `gender`='',
        `mobile_number`=:mobileNumber,
        `join_date`='',
        `dob`='',
        `blood_group`='',
        `address`='',
        `pincode`='',
        `street`='',
        `city`='',
        `address_proof`='',
        `license_number`='',
        `state_id`=:state_token,
        `delete_status`='1',
        `block_status`='1',
        `employee_image`=:employee_image,
        `otp`=''";
        $stmtSales = $this->conn->prepare($insertSales);
        $stmtSales->bindParam('token', $this->token);
        $stmtSales->bindParam('sales_rep_name', $this->sales_rep_name);
        $stmtSales->bindParam('mobileNumber', $this->mobileNumber);
        $stmtSales->bindParam('employee_code', $this->employee_code);
        $stmtSales->bindParam('sales_rep_mailid', $this->sales_rep_mailid);
        $stmtSales->bindParam('region_token', $this->region_token);
        $stmtSales->bindParam('state_token', $this->state_token);
        $stmtSales->bindParam('rolls_token', $this->rolls_token);
        $stmtSales->bindParam('employee_image', $this->salesrep_image);
        if ($stmtSales->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //log salesRep
    function insertSalesRepLog($indiaDateTime)
    {
        $insert = "INSERT INTO `sales_repLog` SET
        `sales_rep__token`=:token,
        `old_mobile`=:mobileNumber,
        `new_mobile`=:mobileNumber,
        `old_name`=:sales_rep_name,
        `new_name`=:sales_rep_name,
        `created_by`=:admin_token,
        `date_time`='$indiaDateTime',
        `delete_status`='1'";
        $stmt = $this->conn->prepare($insert);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('sales_rep_name', $this->sales_rep_name);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function insertRegionWiseDistributor($indiaDateTime)
    {
        $regionquery = "INSERT INTO `region__sales_rep` SET
        `date_time`='$indiaDateTime',
        `region_token`=:employee_region,
        `distributor_token`=:token";
        $stmtregion = $this->conn->prepare($regionquery);
        $stmtregion->bindParam('employee_region', $this->employee_region);
        $stmtregion->bindParam('token', $this->token);
        if ($stmtregion->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function isDistributorExistInRegion()
    {
        $queryreg = "SELECT `region_token`, `distributor_token`, `is_active`
        FROM `region__sales_rep`
        WHERE `distributor_token`=? AND `region_token`!=? AND `is_active`='1'";
        $stmtreg = $this->conn->prepare($queryreg);
        $stmtreg->bindParam(1, $this->token);
        $stmtreg->bindParam(2, $this->employee_region);
        $stmtreg->execute();
        return $stmtreg;
    }
    function updateRegionWiseDistributor($indiaDateTime)
    {
        $regionquery1 = "UPDATE `region__sales_rep` SET
        `is_active`='0',
        `last_modified`='$indiaDateTime'
        WHERE `distributor_token`=:token";
        $stmtregion1 = $this->conn->prepare($regionquery1);
        $stmtregion1->bindParam('token', $this->token);
        if ($stmtregion1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function selectSingleSalesRep()
    {
        $queryselect = "SELECT `token`, `name`, `email_id`, `region_id`, `mobile_number`, `state_id`,`employee_image`,`resignation_date` FROM `employees` WHERE `token`=?";
        $stmtselect = $this->conn->prepare($queryselect);
        $stmtselect->bindParam(1, $this->employee_token);
        $stmtselect->execute();
        return $stmtselect;
    }
    function readSingleSalesRep($stmt)
    {
        $array_salesrep1 = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->employee_token = $row1['token'];
            $obj->employee_name = $row1['name'];
            $obj->region_token = $row1['region_id'];
            $obj->email_id = $row1['email_id'];
            $obj->mobile_number = $row1['mobile_number'];
            $obj->state_token = $row1['state_id'];
            $obj->employee_image = $row1['employee_image'];
            $obj->resignation_date = $row1['resignation_date'];
            array_push($array_salesrep1, $obj);
        }
        return $array_salesrep1;
    }
    //update salesLog
    function fetchDetails()
    {
        $query = "SELECT `name`,`mobile_number` FROM `employees` WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    function readfetchDetails($stmt)
    {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->old_name = $row['name'];
            $obj->old_mobile = $row['mobile_number'];
            return $obj;
        }
    }
    function updateSalesRepLog($indiaDateTime)
    {
        $insert = "INSERT INTO `sales_repLog` SET
        `sales_rep__token`=:token,
        `old_mobile`=:old_mobile,
        `new_mobile`=:mobileNumber,
        `old_name`=:old_name,
        `new_name`=:sales_rep_name,
        `created_by`=:admin_token,
        `date_time`='$indiaDateTime',
        `delete_status`='1'";
        $stmt = $this->conn->prepare($insert);
        $stmt->bindParam('token', $this->token);
        $stmt->bindParam('old_name', $this->old_name);
        $stmt->bindParam('sales_rep_name', $this->sales_rep_name);
        $stmt->bindParam('old_mobile', $this->old_mobile);
        $stmt->bindParam('mobileNumber', $this->mobileNumber);
        $stmt->bindParam('admin_token', $this->admin_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // function updateSalesRep()
    // {
    //     $updateSales = "UPDATE `employees` SET 
    //     `name`=:sales_rep_name, 
    //     `email_id`=:sales_rep_mailid, 
    //     `region_id`=:region_token, 
    //     `mobile_number`=:mobileNumber,
    //     `state_id`=:state_token,
    //     `employee_image`=:employee_image,
    //     `deparment_token`=:rolls_token,
    //     `resignation_date`=:resignation_date
    //     WHERE `token`=:token";
    //     $stmtupt = $this->conn->prepare($updateSales);
    //     $stmtupt->bindParam('token', $this->token);
    //     $stmtupt->bindParam('sales_rep_name', $this->sales_rep_name);
    //     $stmtupt->bindParam('region_token', $this->region_token);
    //     $stmtupt->bindParam('sales_rep_mailid', $this->sales_rep_mailid);
    //     $stmtupt->bindParam('mobileNumber', $this->mobileNumber);
    //     $stmtupt->bindParam('state_token', $this->state_token);
    //     $stmtupt->bindParam('resignation_date', $this->resignation_date);
    //     $stmtupt->bindParam('employee_image', $this->employee_image);
    //     $stmtupt->bindParam('rolls_token', $this->rolls_token);
    //     if ($stmtupt->execute()) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

        function updateSalesRep()
    {
        // Resignation date empty-a irundha MySQL-ukku NULL-a anuppurom
        if (empty($this->resignation_date)) {
            $this->resignation_date = null;
        }

        $updateSales = "UPDATE `employees` SET 
        `name`=:sales_rep_name, 
        `email_id`=:sales_rep_mailid, 
        `region_id`=:region_token, 
        `mobile_number`=:mobileNumber,
        `state_id`=:state_token,
        `employee_image`=:employee_image,
        `deparment_token`=:rolls_token,
        `resignation_date`=:resignation_date
        WHERE `token`=:token";

        $stmtupt = $this->conn->prepare($updateSales);
        $stmtupt->bindParam('token', $this->token);
        $stmtupt->bindParam('sales_rep_name', $this->sales_rep_name);
        $stmtupt->bindParam('region_token', $this->region_token);
        $stmtupt->bindParam('sales_rep_mailid', $this->sales_rep_mailid);
        $stmtupt->bindParam('mobileNumber', $this->mobileNumber);
        $stmtupt->bindParam('state_token', $this->state_token);
        $stmtupt->bindParam('resignation_date', $this->resignation_date);
        $stmtupt->bindParam('employee_image', $this->employee_image);
        $stmtupt->bindParam('rolls_token', $this->rolls_token);

        if ($stmtupt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    function getSalesRepVisitedLocation($date)
    {
        $shopQuery = "SELECT * FROM `live_location` WHERE rep_token = ? AND DATE_FORMAT(date_time,'%d-%m-%Y') = '$date'";
        $stmtpos = $this->conn->prepare($shopQuery);
        $stmtpos->bindParam(1, $this->employee_token);
        $stmtpos->execute();
        return $stmtpos;
    }
    function viewSalesRepVisitedLocation($stmtloc)
    {
        $location_log = [];
        while ($rowlog = $stmtloc->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            // $obj->shop_name = $rowlog["shop_name"];
            $obj->employee_lat = $rowlog["latitud"];
            $obj->employee_lon = $rowlog["langitud"];
            $obj->employee_date_time = date("h:i A", strtotime($rowlog['date_time']));
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

    //select state
    function selectState()
    {
        $query = "SELECT
        *
    FROM
        `employees__state`
    WHERE
        state_name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_name);
        $stmt->execute();
        return $stmt;
    }
    function insertState($indiaDateTime)
    {
        $query = "INSERT INTO `employees__state` SET
        `date_time`='$indiaDateTime',
        `state_token`=:state_token,
        `state_name`=:state_name";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam('state_token', $this->state_token);
        $stmt1->bindParam('state_name', $this->state_name);
        $stmt1->execute();
        return $stmt1;
    }
    //region validation 
    function regionExists()
    {
        $regSql = "SELECT `region_name` FROM `region` WHERE `region_name`=? AND `state_id`=? AND `status`='1'";
        if (isset($this->region_token) && !empty($this->region_token)) {
            $regSql .= " AND `token`!=?";
        }
        $regstmt = $this->conn->prepare($regSql);
        $regstmt->bindParam(1, $this->region_name);
        $regstmt->bindParam(2, $this->state_token);
        if (isset($this->region_token) && !empty($this->region_token)) {
            $regstmt->bindParam(3, $this->region_token);
        }
        $regstmt->execute();
        return $regstmt;
    }
    //leave_management
    function updateLeave($indiaDateTime)
    {
        $indiaDate = date("Y-m-d");
        $leave_status = $this->leave_status;
       
        if ($leave_status == "Rejected") {
            $query = "UPDATE `sales_rep__leave` SET `date_time`='$indiaDateTime',`leave_status`='$leave_status',`status`='2' WHERE `token`=? AND`sales_rep_token`=? ";
        } else {
            $query = "UPDATE `sales_rep__leave` SET `date_time`='$indiaDateTime',`leave_status`='$leave_status',`status`='1' WHERE `token`=? AND`sales_rep_token`=? ";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->sales_rep_token);
         
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //leave log
    function leaveLog($indiaDateTime)
    {
        $leave_status = $this->leave_status;
        if ($leave_status == "Rejected") {
            $query = "INSERT INTO `leave_log` SET
            `sales_rep__token`=:sales_rep_token,
            `status_updatedby`=:admin_token,
            `date_time`='$indiaDateTime',
            `status`='2'";
        } else {
            $query = "INSERT INTO `leave_log` SET
                `sales_rep__token`=:sales_rep_token,
                `status_updatedby`=:admin_token,
                `date_time`='$indiaDateTime',
                `status`='1'";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->bindParam('sales_rep_token', $this->sales_rep_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function leaveFilter()
    {
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $query = "SELECT
        employees.name,
        sales_rep__leave.token,
        sales_rep__leave.sales_rep_token,
        sales_rep__leave.start_date,
        sales_rep__leave.end_date,
        sales_rep__leave.reason,
        sales_rep__leave.leave_status
    FROM
        employees
    JOIN sales_rep__leave ON employees.token = sales_rep__leave.sales_rep_token  WHERE `employees`.`delete_status` = '1' AND `employees`.`deparment_token` IN('72602780','98765434','98765433') 
    $stateQuery $searchQuery";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function leaveManagement()
    {
        $rowStart    = $this->rowStart;
        $rowperpage  = $this->rowperpage;
        $searchQuery = $this->searchQuery;
        $stateQuery = $this->stateQuery;
        $columnName  = $this->columnName;
        $columnSortOrder = $this->columnSortOrder;
        $query = "SELECT
        employees.name,
        sales_rep__leave.token,
        sales_rep__leave.sales_rep_token,
        sales_rep__leave.start_date,
        sales_rep__leave.end_date,
        sales_rep__leave.leave_shift,
        sales_rep__leave.reason,
        sales_rep__leave.leave_status
        
    FROM
        employees
    JOIN sales_rep__leave ON employees.token = sales_rep__leave.sales_rep_token  WHERE `employees`.`delete_status` = '1' AND `employees`.`deparment_token` IN('72602780','98765434','98765433') 
    $stateQuery $searchQuery
    ORDER BY $columnName $columnSortOrder
    LIMIT $rowStart,$rowperpage";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readLeaveMangement($stmt)
{
    $data = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($row['leave_status'] == "Pending") {
            $status  = '<button type="button" class="status-btn primary-btn" id="statusbtn" data-toggle="modal" data-target="#status-view" data-token="' . $row['sales_rep_token'] . '" data-token1="' . $row['token'] . '">' . $row['leave_status'] . '</button>';
        } else if ($row['leave_status'] == "Approved") {
            $status  = '<button class="tb-btn greenbtn" data-token1="' . $row['token'] . '">' . $row['leave_status'] . '</button>';
        } else {
            $status  = '<button class="tb-btn red" data-token1="' . $row['token'] . '">' . $row['leave_status'] . '</button>';
        }
        $delete = '<button class="tb-btn red delete_leave"  data-token1="' . $row['token'] . '">Delete</button>';
        
        $data[] = array(
            "salesname" => $row["name"],
            "sales_rep_token" => $row["sales_rep_token"],
            "start_date" => $row['start_date'],
            "end_date" => $row['end_date'],
            "leave_shift" => $row['leave_shift'] ?? '-', // Fixed: Changed ; to ,
            "reason" => $row["reason"],
            "action" => $status,
            "delete" => $delete
        );
    }
    return $data;
}
    //count leave
    function countLeave()
    {
        $query = "SELECT sales_rep_token FROM `sales_rep__leave`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //leave token
    function leaveTokenGenerate()
    {
        $random = rand(10000000, 99999999);
        $val = true;
        do {
            $query = "SELECT `id` FROM `sales_rep__leave` WHERE `token`=?";
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
    //leaveapply
    function insertLeave($indiaDateTime)
    {
        $query = "INSERT INTO `sales_rep__leave` SET
            `token`=:token,
            `sales_rep_token`=:sales_rep_token,
            `date_time`='$indiaDateTime',
            `start_date`=:start_date,
            `end_date`=:end_date,
            `reason`=:reason";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam('token', $this->token);
        $stmt1->bindParam('sales_rep_token', $this->sales_rep_token);
        $stmt1->bindParam('start_date', $this->start_date);
        $stmt1->bindParam('end_date', $this->end_date);
        $stmt1->bindParam('reason', $this->reason);
        if ($stmt1->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //insertleavelog
    function insertleaveLog($indiaDateTime)
    {
        $query = "INSERT INTO `leave_log` SET
            `sales_rep__token`=:sales_rep_token,
            `status_updatedby`=:admin_token,
            `date_time`='$indiaDateTime',
            `status`='0'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('admin_token', $this->admin_token);
        $stmt->bindParam('sales_rep_token', $this->sales_rep_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //checkleave
    function checkleave($indiaDate)
    {
        $query = "SELECT `id` FROM `sales_rep__leave` WHERE date(`date_time`) ='$indiaDate' AND `sales_rep_token` = ?";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->bindParam(1, $this->sales_rep_token);
        $stmt1->execute();
        return $stmt1;
    }
    //selecte all states
    function selectAllState()
    {
        $query = "SELECT `state_token`,`state_name` FROM `employees__state` ORDER BY `state_name` ASC";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->execute();
        return $stmt1;
    }
    function fetchState($stmt1)
    {
        $state = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->state_token = $row["state_token"];
            $obj->state_name = $row["state_name"];
            array_push($state, $obj);
        }
        return $state;
    }
    function fetchState_data($stmt)
    {
        $state = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->state_token = $row["state_token"];
            $obj1->state_name = $row["state_name"];
            array_push($state, $obj1);
        }
        return $state;
    }
    //select all region
    // function selectAllRegion()
    // {
    //     $query = "SELECT `token` AS `region_token`,`region_name` FROM `region`";
    //     $stmt1 = $this->conn->prepare($query);
    //     $stmt1->execute();
    //     return $stmt1;
    // }


    function selectAllRegion()
    {
        $query = "SELECT `token` AS `region_token`,`region_name` FROM `region` WHERE `status` = '1'";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->execute();
        return $stmt1;
    }




    function fetchAllRegion($stmt1)
    {
        $region = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->region_token = $row["region_token"];
            $obj->region_name = $row["region_name"];
            array_push($region, $obj);
        }
        return $region;
    }

    //select all areas
    function selectAllAreas()
    {
        $query = "SELECT `area_token`,`area_name` FROM `area`";
        $stmt1 = $this->conn->prepare($query);
        $stmt1->execute();
        return $stmt1;
    }
    function fetchAllAreas($stmt1)
    {
        $area = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->area_token = $row["area_token"];
            $obj->area_name = $row["area_name"];
            array_push($area, $obj);
        }
        return $area;
    }

    //select all distributor
    function area_distributors()
    {
        $query = "SELECT `token`,`name` FROM `employees` WHERE `deparment_token`='18028120'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchAll($stmt1)
    {
        $dist = [];
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row["token"];
            $obj->name = $row["name"];
            array_push($dist, $obj);
        }
        return $dist;
    }

    //select region
    // function selectRegion()
    // {
    //     $query = "SELECT `token`,`region_name` FROM `region` WHERE `state_id` = ?";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(1, $this->stateToken);
    //     $stmt->execute();
    //     return $stmt;
    // }



    function selectRegion()
    {
        $query = "SELECT `token`,`region_name` FROM `region` WHERE `state_id` = ? AND `status` = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->stateToken);
        $stmt->execute();
        return $stmt;
    }




    function fetchRegion($stmt)
    {
        $region = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->region_token = $row["token"];
            $obj->region_name = $row["region_name"];
            array_push($region, $obj);
        }
        return $region;
    }
    //select area 
    function selectArea()
    {
        $query = "SELECT `area_token`,`area_name` FROM `area` WHERE `region_token` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->regionToken);
        //$stmt->bindParam(1, $this->check_distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function fetchArea($stmt)
    {
        $area = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->area_token = $row["area_token"];
            $obj->area_name = $row["area_name"];
            array_push($area, $obj);
        }
        return $area;
    }

    //select distributor
    function selectAreaDist()
    {
        $query = "SELECT `token`,`name` FROM `employees` WHERE `region_id`=? AND deparment_token = '18028120' AND `block_status` = '1' AND `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->regionToken);
        $stmt->execute();
        return $stmt;
    }
    function fetchAreaDist($stmt)
    {
        $dist = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row["token"];
            $obj->name = $row["name"];
            array_push($dist, $obj);
        }
        return $dist;
    }
    //select distributor
    function selectDistMap()
    {
        $disToken = $this->disToken;
        $query = "SELECT
            `products__category`.`name`,
            `employees`.`name` AS `distributor`
        FROM
            `products__category`
        INNER JOIN `employees__division_mapping` ON `products__category`.`token` = `employees__division_mapping`.`division_token`
        INNER JOIN `employees` ON `employees`.`token` = `employees__division_mapping`.`employee_token`
        WHERE `products__category`.`delete_status` ='1' AND
            `employees__division_mapping`.`employee_token` IN(" . implode(',', $disToken) . ")";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1, $this->disToken);
        $stmt->execute();
        return $stmt;
    }
    function fetchDistMap($stmt)
    {
        $distMap = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->distname = $row["distributor"];
            $obj->name = $row["name"];
            array_push($distMap, $obj);
        }
        return $distMap;
    }

    //check schedule
    function checkSchedule()
    {
        $query = "SELECT * FROM `sales_rep_schedule_mapping` WHERE `sales_rep_token` = ? AND date(`date_time`) = ? AND `status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->sales_rep_name);
        $stmt->bindParam(2, $this->schedule_date);
        $stmt->execute();
        return $stmt;
    }
    //salesRepschedule insert
    function sales_Rep_schedule($schedule_token, $indiaDateTime)
    {
        $query = "INSERT INTO `sales_rep_schedule_mapping` SET
                    `rep_schedule_token` = $schedule_token,
                    `sales_rep_token` = :sales_rep_name,
                    `state_token` = :stateToken,
                    `date_time` = '$indiaDateTime',
                    `status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('sales_rep_name', $this->sales_rep_name);
        $stmt->bindParam('stateToken', $this->stateToken);
        $stmt->execute();
        return $stmt;
    }
    //salesRepschedule insert
    function salesRepschedule($indiaDateTime)
    {
        $schedule_token = $this->schedule_token;
        $sales_rep_token = $this->sales_rep_name;
        $date = $this->schedule_date;
        $areaToken = $this->areaToken;
        $stateToken = $this->stateToken;
        $regionToken = $this->regionToken;
        $areaDisToken = $this->areaDisToken;

        foreach ($areaToken as $area_token) {
            foreach ($areaDisToken as $area_distoken) {
                $inserts[] = "('$schedule_token','$sales_rep_token','$date','$stateToken','$regionToken','$area_token','$area_distoken','$indiaDateTime','1')";
            }
        }
        $query = "INSERT INTO `schedule_sales_rep`(`rep_schedule_token`,`sales_rep_token`, `schedule_date`, `state_token`, `region_token`, `area_token`,`distributor_token`,`date_time`,`status`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //logschedule
    function salesRepscheduleLog($indiaDateTime)
    {
        $schedule_token = $this->schedule_token;
        $sales_rep_token = $this->sales_rep_name;
        $areaToken = $this->areaToken;
        $area = implode(',', $areaToken);
        $stateToken = $this->stateToken;
        $regionToken = $this->regionToken;
        $areaDisToken = $this->areaDisToken;
        $areaDis = implode(',', $areaDisToken);
        $admin_token = $this->admin_token;
        $query = "INSERT INTO `schedule_log`
            SET
                `rep_schedule_token`='$schedule_token',
                `sales_rep_token`='$sales_rep_token',
                `old_state_token`='$stateToken',
                `new_state_token`='',
                `old_region_token`= '$regionToken',
                `new_region_token`= '',
                `old_area_token`= '$area',
                `new_area_token`='',
                `old_distributor_token` = '$areaDis',
                `new_distributor_token` = '',
                `created_by`='$admin_token',
                `date_time`='$indiaDateTime',
                `status`='1'";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //select scheduled sales rep `schedule_sales_rep`.`schedule_date`,
    function todayallScheduledSaleRep()
    {
        $stateQuery = $this->stateQuery;
        $indiaDateTime_new = date("Y-m-d");
        $query = "SELECT
            `schedule_sales_rep`.`rep_schedule_token` AS `schedule_token`,
            `employees`.`token` AS `saleRepToken`,
            `employees`.`name` AS `salesRepName`,
            DATE_FORMAT(
                `schedule_sales_rep`.`schedule_date`,
                '%d-%m-%Y'
            ) AS `schedule_date`,
            `employees__state`.`state_name`,
            `region`.`region_name`,
            `schedule_sales_rep`.`region_token`,
            -- `schedule_sales_rep`.`ta`,
            `schedule_sales_rep`.`region_token` AS region_token,
            (SELECT COUNT(1) FROM `sales_rep__leave` 
             WHERE `sales_rep_token` = `employees`.`token` 
             AND `leave_status` = 'Approved' 
             AND `schedule_sales_rep`.`schedule_date` BETWEEN `start_date` AND `end_date`) AS `is_absent`
        FROM
            `employees`
        INNER JOIN `schedule_sales_rep` ON `employees`.`token` = `schedule_sales_rep`.`sales_rep_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        WHERE
            `schedule_sales_rep`.`status` = 1 $stateQuery AND `schedule_sales_rep`.`schedule_date` = '$indiaDateTime_new'
        GROUP BY
            `schedule_sales_rep`.`sales_rep_token` ,
            `schedule_sales_rep`.`schedule_date`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchtodayAllScheduledSaleRep($stmt)
    {
        $arrayAllScheduledSaleRep = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->schedule_token = $row1['schedule_token'];
            $obj->saleRepToken = $row1['saleRepToken'];
            $obj->salesRepName = $row1['salesRepName'];
            $obj->schedule_date = $row1['schedule_date'];
            $obj->state_name = $row1['state_name'];
            // $obj->travel = $row1["ta"];
            $obj->region_name = $row1['region_name'];
            $obj->region_token = $row1['region_token'];
            $obj->is_absent = $row1['is_absent'];
            // $obj->date_time = nl2br(date("d/m/Y \n h:i A",strtotime($row1['date_time'])));
            array_push($arrayAllScheduledSaleRep, $obj);
        }
        return $arrayAllScheduledSaleRep;
    }

    function allScheduledSaleRep()
    {
        $stateQuery = $this->stateQuery;
        $dateQuery   = $this->dateQuery;
        $indiaDateTime_new = date("Y-m-d");
        $query = "SELECT
            
            `employees`.`token` AS `saleRepToken`,
            `employees`.`name` AS `salesRepName`,
            DATE_FORMAT(`schedule_sales_rep`.`schedule_date`,'%d-%m-%Y') AS `schedule_date`,
            `employees__state`.`state_name`,
            `region`.`region_name`,
            -- `schedule_sales_rep`.`ta`,
            (SELECT COUNT(1) FROM `sales_rep__leave` 
             WHERE `sales_rep_token` = `employees`.`token` 
             AND `leave_status` = 'Approved' 
             AND `schedule_sales_rep`.`schedule_date` BETWEEN `start_date` AND `end_date`) AS `is_absent`
        FROM
            `employees`
        INNER JOIN `schedule_sales_rep` ON `employees`.`token` = `schedule_sales_rep`.`sales_rep_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        LEFT JOIN `orders` ON `orders`.`sales_rep_token` = schedule_sales_rep.sales_rep_token
        WHERE 
            `schedule_sales_rep`.`status` = 1 $dateQuery  $stateQuery  AND  NOT `schedule_sales_rep`.`schedule_date` = '$indiaDateTime_new'
        GROUP BY
        schedule_sales_rep.id
            ORDER BY schedule_sales_rep.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function fetchAllScheduledSaleRep($stmt)
    {
        $arrayAllScheduledSaleRep = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->saleRepToken = $row1['saleRepToken'];
            $obj->salesRepName = $row1['salesRepName'];
            $obj->schedule_date = $row1['schedule_date'];
            $obj->state_name = $row1['state_name'];
            $obj->region_name = $row1['region_name'];
            $obj->is_absent = $row1['is_absent'];
            // $obj->travel = $row1["ta"];

            // $obj->order_total_amt = $row1['order_billig_amt'];
            // $obj->date_time = nl2br(date("d/m/Y \n h:i A",strtotime($row1['date_time'])));
            array_push($arrayAllScheduledSaleRep, $obj);
        }
        return $arrayAllScheduledSaleRep;
    }

    function allScheduledPdf()
    {
        $stateQuery = $this->stateQuery;
        $betweenQuery = $this->betweenQuery;
        $indiaDateTime_new = date("Y-m-d");
        $query = "SELECT
            `sales_repname`.`name` AS `employee_name`,
            DATE_FORMAT(
                `schedule_sales_rep`.`schedule_date`,
                '%d-%m-%Y'
            ) AS `schedule_date`,
            `employees__state`.`state_name`,
            `region`.`region_name`,
            `area`.`area_name`,
            `distributor`.`name` AS `distributor_name`,
            (SELECT COUNT(1) FROM `sales_rep__leave` 
             WHERE `sales_rep_token` = `sales_repname`.`token` 
             AND `leave_status` = 'Approved' 
             AND `schedule_sales_rep`.`schedule_date` BETWEEN `start_date` AND `end_date`) AS `is_absent`
        FROM
            `schedule_sales_rep`
        INNER JOIN `employees` AS `sales_repname`
        ON
            `sales_repname`.`token` = `schedule_sales_rep`.`sales_rep_token`
        INNER JOIN `employees` AS `distributor`
        ON
            `distributor`.`token` = `schedule_sales_rep`.`distributor_token`
        INNER JOIN `employees__state` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        WHERE
            `schedule_sales_rep`.`status` = 1 $stateQuery $betweenQuery AND NOT `schedule_sales_rep`.`schedule_date` = '2023-09-12'
        GROUP BY
            `schedule_sales_rep`.`sales_rep_token`,
            `schedule_sales_rep`.`schedule_date`
        ORDER BY
            schedule_sales_rep.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //salerep particular area
    function salesRepArea()
    {
        $query = "SELECT
                    `employees__state`.`state_name`,
                    `employees__state`.`state_token`,
                    `region`.`token` AS `region_token`,
                    `region`.`region_name`,
                    `schedule_sales_rep`.`rep_schedule_token`,
                    -- `schedule_sales_rep`.`ta`,
                    GROUP_CONCAT(DISTINCT
                        CONCAT( 
                            `area`.`area_token`,
                            '&&&',
                            `area`.`area_name`
                        ),
                        '***'
                    ) AS `areas`,
                    GROUP_CONCAT( DISTINCT
                        CONCAT(
                            CASE
                                WHEN `employees`.`token` IS NULL THEN `schedule_sales_rep`.`distributor_token`
                                ELSE `employees`.`token`
                            END,
                            '&&&',
                            CASE
                                WHEN `employees`.`token` IS NULL THEN `schedule_sales_rep`.`distributor_token`
                                ELSE `employees`.`name`
                            END
                        ),
                        '***'
                    ) AS `areadist`
                FROM
                    `employees__state`
                INNER JOIN `schedule_sales_rep` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
                INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
                INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
                LEFT JOIN `employees` ON `employees`.`token` = `schedule_sales_rep`.`distributor_token`
                WHERE
                    `schedule_sales_rep`.`sales_rep_token` = ? AND `schedule_sales_rep`.`status` = '1' AND `schedule_sales_rep`.`schedule_date` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesReoToken);
        $stmt->bindParam(2, $this->schedule_date);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new StdClass();
            $obj1->rep_schedule_token  = $row["rep_schedule_token"];
            // $obj1->travel  = $row["ta"];
            $obj1->state_name  = $row["state_name"];
            $obj1->state_token = $row["state_token"];
            $obj1->region_token = $row["region_token"];
            $obj1->region_name = $row["region_name"];
            $details = rtrim($row["areas"], '***');
            $area_detail = explode('***,', $details);
            $modules = [];
            foreach ($area_detail as $area_data) {
                $obj2 = new stdClass();
                $ar_data = explode('&&&', $area_data);
                $obj2->area_id = $ar_data[0];
                $obj2->area_name = $ar_data[1];
                array_push($modules, $obj2);
            }
            $obj1->modules_data = $modules;

            $detail = rtrim($row["areadist"], '***');
            $area_dist = explode('***,', $detail);
            $modvalue = [];
            foreach ($area_dist as $area_distrib) {
                $obj2 = new stdClass();
                $ar_dist = explode('&&&', $area_distrib);
                $obj2->token = $ar_dist[0];
                $obj2->name = $ar_dist[1];
                array_push($modvalue, $obj2);
            }
            $obj1->modules = $modvalue;
        }
        return $obj1;
    }
    //updatesales rep schedule
    function updateSalesRepStatus()
    {
        $query = "UPDATE `schedule_sales_rep` SET `status`= '2' WHERE `sales_rep_token` = ? AND `rep_schedule_token`= ? AND `schedule_date` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesRepToken);
        $stmt->bindParam(2, $this->rep_schedule_token);
        $stmt->bindParam(3, $this->schedule_date);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    function updateSalesRepSchedule($indiaDateTime)
    {
        $rep_schedule_token = $this->rep_schedule_token;
        $salesRepToken = $this->salesRepToken;
        $date = $this->schedule_date;
        $areaToken = $this->areaToken;
        $areaDisToken = $this->areaDisToken;
        $stateToken = $this->stateToken;
        $regionToken = $this->regionToken;
        //'$travelAllowance',
        foreach ($areaToken as $area_token) {
            foreach ($areaDisToken as $area_distoken) {
                $inserts[] = "('$rep_schedule_token','$salesRepToken','$date','$stateToken','$regionToken','$area_token','$area_distoken','$indiaDateTime','1')";
            }
        }
        $query = "INSERT INTO `schedule_sales_rep`(`rep_schedule_token`,`sales_rep_token`, `schedule_date`, `state_token`, `region_token`, `area_token`,`distributor_token`,`date_time`,`status`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    //log select
    function fetchscheduleDetails()
    {
        $query = "SELECT state_token,region_token,GROUP_CONCAT(DISTINCT area_token)AS area,GROUP_CONCAT(DISTINCT distributor_token)AS distributor FROM `schedule_sales_rep` WHERE `rep_schedule_token`=? AND `status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_schedule_token);
        $stmt->execute();
        return $stmt;
    }

    function readfetchscheduleDetails($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdclass();
            $obj->state_token = $row['state_token'];
            $obj->region_token = $row['region_token'];
            $obj->area = $row['area'];
            $obj->distributor = $row['distributor'];
            array_push($array, $obj);
        }
        return $array;
    }

    //logupdatedSchedule
    function updateSalesRepScheduleLog($indiaDateTime)
    {
        $rep_schedule_token = $this->rep_schedule_token;
        $salesRepToken = $this->salesRepToken;
        $state_token = $this->state_token;
        $region_token = $this->region_token;
        $areas_token = $this->areas_token;
        $distributor_token = $this->distributor_token;
        $areaToken = $this->areaToken;
        $areaDisToken = $this->areaDisToken;
        $stateToken = $this->stateToken;
        $regionToken = $this->regionToken;
        $admin_token = $this->admin_token;
        $area = implode(',', $areaToken);
        $areaDis = implode(',', $areaDisToken);
        $query = "INSERT INTO `schedule_log`
            SET
                `rep_schedule_token`='$rep_schedule_token',
                `sales_rep_token`='$salesRepToken',
                `old_state_token`='$state_token',
                `new_state_token`='$stateToken',
                `old_region_token`= '$region_token',
                `new_region_token`= '$regionToken',
                `old_area_token`= '$areas_token',
                `new_area_token`='$area',
                `old_distributor_token` = '$distributor_token',
                `new_distributor_token` = '$areaDis',
                `created_by`='$admin_token',
                `date_time`='$indiaDateTime',
                `status`='1'";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //logscheduledata
    // function scheduleDetails(){
    //     $query ="SELECT `sales_rep_token`,`state_token`,`region_token`,`area_token`,`distributor_token` FROM `schedule_sales_rep` WHERE `rep_schedule_token` ='30931906'"
    // }

    //send Login Creditals
    function sendOTP($distributor_mobile, $distributor_name, $distributor_email, $pwd)
    {
        // $link_new = mysqli_connect('localhost','powersoap_dev','=Kb9PetRpam2','powersoap_dev');
        // $indiaDateTime_new = date("Y-m-d H:i:s");
        // Collecting the variables to be sent in send otp server call
        // $url = "https://apii.msg91.com/api/v5/flow?authkey=380803AF0dsqJz8g62f75785P1&country=91&mobile=$distributor_mobile&name=$distributor_name&email=$distributor_email&password=$pwd&template_id=1707166556636634604";


        // Creating cURL to hit the url and get the response
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://apii.msg91.com/api/v5/flow/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"6347d2f8694f4e16e040bf92\",\n  \"recipients\": [\n    {\n      \"name\":\"$distributor_name\",   \n      \"mobiles\": \"91$distributor_mobile\",\n      \"email\": \"$distributor_email\",\n      \"password\": \"$pwd\"\n    }\n  ]\n}",
            CURLOPT_HTTPHEADER => [
                "authkey: 380803AF0dsqJz8g62f75785P1",
                "content-type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
    }
    //area view
    function countArea()
    {
        $query = "SELECT area_token FROM `area`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function areaOverAll()
    {
        $query = "SELECT
    area.area_token,
    area.area_name,
    region.region_name
FROM
    `area`
JOIN region ON area.region_token = region.token
WHERE
    area.state_token = ?  AND area.region_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->bindParam(2, $this->region_token);
        $stmt->execute();
        return $stmt;
    }
    // function fetchOverAllArea($stmt){
    //     $data = array();
    //     $slno = $this->rowStart;
    //         while($row= $stmt->fetch(PDO::FETCH_ASSOC)){
    //             $slno++;
    //             $data[]=array(
    //             "area_token"=>$row["area_token"],
    //             "slno"=>$slno,
    //              "area_name"=>$row["area_name"]
    //             );
    //         }
    //     return $data;
    // }
    function updateAreaData()
    {
        $query = "UPDATE `area` SET `area_name`=:area  WHERE `area_token`=:area_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('area', $this->area_name);
        // $stmt->bindParam('state_token',$this->state_token);
        // $stmt->bindParam('region_token',$this->region_token);
        $stmt->bindParam('area_token', $this->area_token);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // delete area functionaity manick code starrt 
    function deleteAreaData()
    {
        $query = "DELETE FROM `area` WHERE `area_token`=:area_token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('area_token', $this->area_token);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    // delete area functionaity manick code end 

    function select_employee_area()
    {
        $query = "SELECT area.area_name,area.area_token FROM `area` INNER join region ON region.token=area.region_token WHERE region.token= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->region_token);
        $stmt->execute();
        return $stmt;
    }
    function select_employee_area_read($stmt)
    {
        $arr_data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $area_obj = new stdClass;
            $area_obj->area_name = $row['area_name'];
            $area_obj->area_token = $row['area_token'];
            array_push($arr_data, $area_obj);
        }
        return $arr_data;
    }

    function validateArea()
    {
        $query = "SELECT * FROM `area` WHERE area_name = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->area);
        $stmt->execute();
        return $stmt;
    }

    function areaview_Insert($indiaDateTime)
    {
        $query = "INSERT INTO `area`  SET `state_token`=:state_token,`region_token`=:region_token,`area_token`=:area_token,`area_name`=:area,`datetime`='$indiaDateTime'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('state_token', $this->state_token);
        $stmt->bindParam('region_token', $this->region_token);
        $stmt->bindParam('area_token', $this->area_token);
        $stmt->bindParam('area', $this->area);
        $stmt->execute();
        return true;
    }

    function select_edit_employee_area()
    {
        $query = "SELECT
    employees.area_token AS one_area,
    area.area_name AS area_name,
    area.area_token,
    region.token AS region_id
FROM
    area
INNER JOIN region ON region.token = area.region_token
INNER JOIN employees ON employees.region_id = area.region_token
WHERE
    employees.token = ? AND region.token=?";
        $stmt = $this->conn->prepare($query);
        //$stmt->bindParam(1,$this->region_token);
        $stmt->bindParam(1, $this->employeeToken);
        $stmt->bindParam(2, $this->region_token);
        $stmt->execute();
        return $stmt;
    }

    //check leave for apply schedule
    function scheduleCheck()
    {
        $indiaDate     = date("Y-m-d");
        $query = "SELECT `id` FROM `schedule_sales_rep` WHERE `sales_rep_token`=? AND `schedule_date`='$indiaDate' AND `status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->sales_rep_token);
        $stmt->execute();
        return $stmt;
    }

    //schedule_check for leave apply
    function leaveCheck()
    {
        $indiaDate     = date("Y-m-d");
        $query = "SELECT `id` FROM `sales_rep__leave` WHERE `sales_rep_token`=? AND `start_date`='$indiaDate' AND `end_date`='$indiaDate' AND `leave_status`='Approved'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->sales_rep_token);
        $stmt->execute();
        return $stmt;
    }



    //schedule pdf
    function allScheduleListPdf()
    {
        $stateQuery = $this->stateQuery;
        $indiaDateTime_new = date("Y-m-d");
        $query = "SELECT
    `employees`.`name` AS `salesRepName`,
    DATE_FORMAT(
        `schedule_sales_rep`.`schedule_date`,
        '%d-%m-%Y'
    ) AS `schedule_date`,
    `employees__state`.`state_name`,
    `region`.`region_name`,
    `schedule_sales_rep`.`ta`,
    (SELECT COUNT(1) FROM `sales_rep__leave` 
     WHERE `sales_rep_token` = `employees`.`token` 
     AND `leave_status` = 'Approved' 
     AND `schedule_sales_rep`.`schedule_date` BETWEEN `start_date` AND `end_date`) AS `is_absent`
FROM
    `employees`
INNER JOIN `schedule_sales_rep` ON `employees`.`token` = `schedule_sales_rep`.`sales_rep_token`
INNER JOIN `employees__state` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
WHERE
    `schedule_sales_rep`.`status` = 1 $stateQuery AND `schedule_sales_rep`.`schedule_date` = '$indiaDateTime_new'
GROUP BY
     `schedule_sales_rep`.`rep_schedule_token`,
    `schedule_sales_rep`.`schedule_date`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function admin_view_stock()
    {
        // $rowStart    = $this->rowStart;
        // $rowperpage  = $this->rowperpage;
        // $searchQuery = $this->searchQuery;
        // $columnName  = $this->columnName;
        // $columnSortOrder = $this->columnSortOrder;

        //     $query="SELECT
        //     stock__distributor.product_token,
        //     products.name AS item_name,
        //     products__category.name AS division,
        //     `stock__distributor`.`stock_in_hand`,
        //     `products`.`piece_count`
        // FROM
        //     `products`
        // INNER JOIN stock__distributor ON stock__distributor.product_token = products.token
        // INNER JOIN products__category ON products__category.token = products.category_token
        // WHERE
        //     stock__distributor.employee_token = ? AND products.delete_status = 1";


        $query = "SELECT `products`.`token` AS `product_token`,
`products`.`item_code`,
`products`.`name` AS `product_name`,
`products`.`piece_count`,
`products__category`.`name` AS `product_category`,
`products__category`.`token` AS `product_category_token`,
`products`.`total_cost`,
`products`.`retailer_price`,
`orders__items`.`units`,
COALESCE(`stock__distributor`.`mfs`,0)as mfs,
`stock__distributor`.`aog`,
`stock__distributor`.`stock_in_hand`,
`stock__distributor`.`sold_pieces`,
`stock__distributor`.`monthly_avg`
FROM  `products` 
LEFT JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
INNER JOIN `orders__items` ON `orders__items`.`product_token`=`products`.`token`
LEFT JOIN `employees__division_mapping` ON `employees__division_mapping`.`division_token`=`products__category`.`token`
LEFT JOIN `stock__distributor` ON (`stock__distributor`.`employee_token`=`employees__division_mapping`.`employee_token` AND `stock__distributor`.`product_token`= `products`.`token`)
WHERE `employees__division_mapping`.`employee_token` = ? AND `employees__division_mapping`.`delete_status`=1 AND `products`.`delete_status` = 1 GROUP BY `products`.`token`";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    // function adminViewList($stmt){
    //     $data = array();
    //     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //      $data[]=array(
    //         "employee_token"=>$row["employee_token"],
    //         "item_name"=>$row["item_name"],
    //         "name" => $row["name"],
    //         "piece_count" => $row["piece_count"]
    //      );
    //     }
    //     return $data;
    // }

    function get_employee_area()
    {
        $query = "SELECT area_name,area_token FROM `area` WHERE area_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->area_token);
        $stmt->execute();
        return $stmt;
    }
    function emailValidation()
    {
        $query = "SELECT `id` FROM `employees` WHERE `email_id`=? AND `email_id` != ''";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->emaiId);
        $stmt->execute();
        return $stmt;
    }
    function employeeUpdateEmailCheck()
    {
        $query = "SELECT id FROM `employees` WHERE `email_id`=:emaiId AND `email_id` != '' AND `token` not in (:token)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emaiId', $this->emaiId);
        $stmt->bindParam('token', $this->token);
        $stmt->execute();
        return $stmt;
    }
    function state_and_region()
    {
        $query = "SELECT
    region.token AS region_token,
    region.region_name,
    region.state_id
FROM
    `employees__state`
LEFT JOIN region ON employees__state.state_token = region.state_id
WHERE
    employees__state.state_token = ? AND employees__state.state_token IS NOT NULL AND region.status = '1'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->execute();
        return $stmt;
    }
    function state_and_region_read($stmt)
    {
        $arr_data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $region_obj = new stdClass;
            $region_obj->region_name = $row['region_name'] == " " ? "-" : $row['region_name'];
            $region_obj->region_token = $row['region_token'] == " " ? "-" : $row['region_token'];
            array_push($arr_data, $region_obj);
        }
        return $arr_data;
    }

    //    function area_distributor($key){
    //     // foreach ($datas as $key) {
    //     //     echo 'this',$key;
    //     // }
    //     //echo "hai",(int)$key;
    //     // $int = (int)$num;
    //     $query = "SELECT * FROM `employees` WHERE area_token = $key";
    //     $stmt = $this->conn->prepare($query);
    //    // $stmt->bindParam('areas_token',$this->areas_token);
    //     $stmt->execute();
    //     return $stmt;

    //    } 

    //    function area_distributors(){
    //     $query = "SELECT * FROM `employees` WHERE area_token = ?";
    //     $stmt=$this->conn->prepare($query);
    //     $stmt->bindParam(1,$this->areas_token);
    //     $stmt->execute();
    //     return $stmt;
    //    }
    function live_tracking_state($date)
    {
        $query = "SELECT
            COUNT(orders.token) AS count_order,
            COALESCE(SUM(orders.billing_amount), 0) AS total_order_value
        FROM
            `employees`
        LEFT JOIN orders ON orders.sales_rep_token = employees.token
            AND date(orders.date_time) = '$date'
        WHERE
            employees.deparment_token = '72602780'
            AND (
                employees.resignation_date IS NULL
                OR TRIM(employees.resignation_date) = ''
                OR employees.resignation_date LIKE '0000-00-00%'
            )";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function live_tracking_state_read($func)
    {
        $overallstate_value = [];

        while ($rows = $func->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->orders_count = isset($rows['count_order']) ? $rows['count_order'] : "0";
            $obj1->total_order_value = isset($rows['total_order_value']) ? $rows['total_order_value'] : "0";
            array_push($overallstate_value, $obj1);
        };
        return $overallstate_value;
    }
    function live_tracking_state_read_array($results)
    {
        $overallstate_value = [];
        foreach ($results as $rows) {
            $obj1 = new stdClass;
            $obj1->orders_count = isset($rows['count_order']) ? $rows['count_order'] : "0";
            $obj1->total_order_value = isset($rows['total_order_value']) ? $rows['total_order_value'] : "0";
            array_push($overallstate_value, $obj1);
        }
        return $overallstate_value;
    }
    function particular_state_order_details($date)
    {
        $query = "SELECT
                -- DATE(orders.date_time) AS dates,
                COUNT(orders.token) AS count_order,
                SUM(orders.billing_amount) AS total_order_value
            FROM
                `schedule_sales_rep`
            LEFT JOIN orders ON orders.sales_rep_token = schedule_sales_rep.sales_rep_token
            WHERE
                DATE(orders.date_time) = '$date' AND schedule_sales_rep.state_token = ? AND DATE(schedule_sales_rep.date_time) = '$date' AND schedule_sales_rep.status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->execute();
        return $stmt;
    }
    function particular_state_order_read($result)
    {
        $state_order_details = [];
        while ($rows = $result->fetch(PDO::FETCH_ASSOC)) {
            $state_order_details_obj = new stdClass;
            // $state_order_details_obj->dates = $rows['dates'];
            $state_order_details_obj->count_order = $rows['count_order'];
            $state_order_details_obj->total_order_value = $rows['total_order_value'];
            array_push($state_order_details, $state_order_details_obj);
        }
        return $state_order_details;
    }
    function  state_data($date)
    {
        $query = "SELECT
            employees.state_id,
            employees__state.state_name 
        FROM
            `schedule_sales_rep`
        INNER JOIN employees__state ON schedule_sales_rep.state_token = employees__state.state_token
        INNER JOIN employees ON employees.state_id = schedule_sales_rep.state_token
        WHERE
            employees.deparment_token = '72602780' AND schedule_sales_rep.schedule_date = '$date'
        GROUP BY
            schedule_sales_rep.state_token";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function  state_data_read($state)
    {
        $state_array = [];
        while ($rows = $state->fetch(PDO::FETCH_ASSOC)) {
            $state_obj = new stdClass;
            $state_obj->state_token = $rows['state_id'];
            $state_obj->state_name = $rows['state_name'];
            array_push($state_array, $state_obj);
        }
        return $state_array;
    }
    function state_data_read_array($results)
    {
        $state_value = [];
        foreach ($results as $rows) {
            $obj1 = new stdClass;
            $obj1->state_token = $rows['state_id'];
            $obj1->state_name = $rows['state_name'];
            array_push($state_value, $obj1);
        }
        return $state_value;
    }

    function individual_state_amount($date)
    {
        $query = "SELECT
        SUM(orders.billing_amount)AS state_total_amount
    FROM
        sales_rep_schedule_mapping
    LEFT JOIN orders ON orders.sales_rep_token = sales_rep_schedule_mapping.sales_rep_token
    WHERE
        sales_rep_schedule_mapping.state_token = ? AND DATE(orders.date_time) = '$date' AND DATE(
            sales_rep_schedule_mapping.date_time
        ) = '$date'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->execute();
        return $stmt;
    }

    function  sidebar_statedata()
    {
        $query = "SELECT * FROM `employees__state` ORDER BY state_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function sidebar_statedata_read($sidebar_statedata)
    {
        $all_state_arr = [];
        while ($rows = $sidebar_statedata->fetch(PDO::FETCH_ASSOC)) {
            $all_state_obj = new stdClass;
            $all_state_obj->token = $rows['state_token'];
            $all_state_obj->state_name = $rows['state_name'];
            array_push($all_state_arr, $all_state_obj);
        }
        return $all_state_arr;
    }
    function individual_state_rep()
    {
        $query = "SELECT * FROM `employees` WHERE deparment_token = '72602780' AND state_id = ? AND block_status = '1' AND (
                resignation_date IS NULL
                OR TRIM(resignation_date) = ''
                OR resignation_date LIKE '0000-00-00%'
            )";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->execute();
        return $stmt;
    }
    function individual_state_rep_read($func)
    {
        $arr = [];
        while ($row = $func->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass;
            $obj1->rep_token = $row['token'];
            $obj1->rep_name = $row['name'];
            array_push($arr, $obj1);
        }
        return $arr;
    }
    function  rep_sales_details($date)
    {
        $query = "SELECT
            employees.token,
            employees.mobile_number,
            COUNT(orders.shop_token) AS shop_count,
            SUM(orders.billing_amount) AS total_amount
        FROM
            `employees`
        LEFT JOIN orders ON employees.token = orders.sales_rep_token
        WHERE
            employees.deparment_token = '72602780' AND employees.block_status = '1' 
            AND orders.sales_rep_token = ? AND DATE(orders.date_time) = '$date'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function rep_sales_details_read($func)
    {
        $arr = [];
        while ($rows = $func->fetch(PDO::FETCH_ASSOC)) {
            $details_obj = new stdClass;
            $details_obj->employe_token = $rows["token"];
            $details_obj->mobile_number = $rows["mobile_number"] == "" ? "-" : $rows["mobile_number"];
            $details_obj->shop_count = $rows["shop_count"] == "" ? "-" : $rows["shop_count"];
            $details_obj->total_amount = $rows["total_amount"] == "" ? "-" : $rows["total_amount"];
            array_push($arr, $details_obj);
        }
        return $arr;
    }
    function total_number_shop($date)
    {
        $query = "SELECT
			COUNT(DISTINCT shop.token)AS total_shop_count,
            schedule_sales_rep.rep_schedule_token,
            shop.name
        FROM
            `shop` 
        LEFT JOIN shop_mapping ON shop_mapping.shop_token = shop.token
        INNER JOIN schedule_sales_rep ON schedule_sales_rep.distributor_token = shop_mapping.distributor_token
        WHERE
            DATE(schedule_sales_rep.date_time) = '$date' AND schedule_sales_rep.sales_rep_token = ? AND schedule_sales_rep.status = '1'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function total_number_shop_read($total_shop)
    {
        $total_shop_arr = [];
        while ($rows = $total_shop->fetch(PDO::FETCH_ASSOC)) {
            $total_shop_obj = new stdClass;
            $total_shop_obj->rep_schedule_token = $rows['rep_schedule_token'] == "" ? "-" : $rows['rep_schedule_token'];
            $total_shop_obj->total_shop_count = $rows['total_shop_count'] == "" ? "-" : $rows['total_shop_count'];
            array_push($total_shop_arr, $total_shop_obj);
        }
        return $total_shop_arr;
    }
    function  take_order_no_order($date)
    {
        $query = "SELECT
            type,
            COUNT(type) AS order_and_close
        FROM
            `live_location`
        WHERE
            DATE(date_time) = '$date' AND rep_token = ? AND type = '3'
        GROUP BY type";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function take_order_no_order_read($total_take_order_no_order)
    {
        $no_order = [];
        while ($rows = $total_take_order_no_order->fetch(PDO::FETCH_ASSOC)) {
            $no_order_obj = new stdClass;
            $no_order_obj->type = $rows['type'] == "" ? "-" : $rows['type'];
            $no_order_obj->type_count = $rows['order_and_close'] == "" ? "-" : $rows['order_and_close'];
            array_push($no_order, $no_order_obj);
        }
        return $no_order;
    }
    function total_taken_shop_order($date)
    {
        $query = "SELECT
            COUNT(DISTINCT shop_token) AS total_shop_order
        FROM
            `orders`
        WHERE
            DATE(date_time) = '$date' AND sales_rep_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function total_taken_shop_order_read($total_shop_order_taken)
    {
        $taken_order = [];
        while ($rows = $total_shop_order_taken->fetch(PDO::FETCH_ASSOC)) {
            $taken_order_obj = new stdClass;
            $taken_order_obj->total_shop_order = $rows['total_shop_order'] == "" ? "-" : $rows['total_shop_order'];
            array_push($taken_order, $taken_order_obj);
        }
        return $taken_order;
    }

    function allocted_distributor($date)
    {
        $query = "SELECT GROUP_CONCAT(DISTINCT
            employees.name)AS name
        FROM
            `schedule_sales_rep`
        INNER JOIN employees ON employees.token = schedule_sales_rep.distributor_token
        WHERE
            schedule_sales_rep.sales_rep_token = ? AND DATE(schedule_sales_rep.date_time) = '$date' AND schedule_sales_rep.status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function allocted_distributor_read($distributor)
    {
        $dis_arr = [];
        while ($rows = $distributor->fetch(PDO::FETCH_ASSOC)) {
            $dis_obj = new stdClass;
            $dis_obj->distributor_name = $rows['name'] == "" ? "-" : $rows['name'];
            array_push($dis_arr, $dis_obj);
        }
        return $dis_arr;
    }
    function allocted_distributor_area($date)
    {
        $query = "SELECT GROUP_CONCAT(DISTINCT
            area.area_name) AS area_name
           
        FROM
            `schedule_sales_rep`
        INNER JOIN area ON area.area_token = schedule_sales_rep.area_token
       
        WHERE
            schedule_sales_rep.sales_rep_token = ? AND DATE(schedule_sales_rep.date_time) = '$date' AND schedule_sales_rep.status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function allocted_distributor_area_read($distributor1)
    {
        $dis_arr1 = [];
        while ($rows1 = $distributor1->fetch(PDO::FETCH_ASSOC)) {
            $dis_obj1 = new stdClass;
            $dis_obj1->area_name = $rows1['area_name'] == "" ? "-" : $rows1['area_name'];
            // $dis_obj1->region_name = $rows1['region_name'];
            array_push($dis_arr1, $dis_obj1);
        }
        return $dis_arr1;
    }
    function allocted_distributor_state($date)
    {
        $query = "SELECT  GROUP_CONCAT(DISTINCT
            region.region_name)AS region_name
        FROM
            `schedule_sales_rep`
            INNER JOIN region ON region.token = schedule_sales_rep.region_token
        WHERE
            schedule_sales_rep.sales_rep_token = ? AND DATE(schedule_sales_rep.date_time) = '$date' AND schedule_sales_rep.status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function allocted_distributor_state_read($distributor2)
    {
        $dis_arr2 = [];
        while ($rows2 = $distributor2->fetch(PDO::FETCH_ASSOC)) {
            $dis_obj2 = new stdClass;
            $dis_obj2->region_name = $rows2['region_name'] == "" ? "-" : $rows2['region_name'];
            array_push($dis_arr2, $dis_obj2);
        }
        return $dis_arr2;
    }
    function all_latlag($date, $beforemin)
    {
        $startDate = date('Y-m-d 00:00:00', strtotime($date));
        $endDate = $date;
        $query = "SELECT
            latest_live_location.rep_schedule_token,
            latest_live_location.rep_token,
            employees.employee_image AS image,
            employees.name AS rep_name,
            area.area_name AS schedule_area_name,
            latest_live_location.area_location,
            latest_live_location.area_name AS live_area_name,
            latest_live_location.latitud,
            latest_live_location.langitud,
            latest_live_location.date_time AS last_time
        FROM (
            SELECT ll1.*
            FROM `live_location` ll1
            INNER JOIN (
                SELECT rep_token, MAX(id) AS latest_id
                FROM (
                    SELECT id, rep_token
                    FROM `live_location`
                    ORDER BY id DESC
                    LIMIT 50000
                ) recent_live_location
                GROUP BY rep_token
            ) latest_row
                ON latest_row.latest_id = ll1.id
        ) latest_live_location
        INNER JOIN employees ON employees.token = latest_live_location.rep_token
        LEFT JOIN schedule_sales_rep ON schedule_sales_rep.rep_schedule_token = latest_live_location.rep_schedule_token
        LEFT JOIN area ON area.area_token = schedule_sales_rep.area_token
        WHERE
            employees.deparment_token IN ('72602780','18028120')
            AND employees.block_status = '1'
            AND employees.delete_status = '1'
            AND (
                employees.resignation_date IS NULL
                OR TRIM(employees.resignation_date) = ''
                OR employees.resignation_date LIKE '0000-00-00%'
            )
            AND latest_live_location.date_time >= ?
            AND latest_live_location.date_time <= ?
        ORDER BY
            last_time DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $startDate);
        $stmt->bindParam(2, $endDate);
        $stmt->execute();
        return $stmt;
    }
    function  all_latlag_read($func)
    {
        $arr = [];
        while ($rows = $func->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->schedule_token = $rows['rep_schedule_token'];
            $obj->rep_token = $rows['rep_token'];
            $obj->rep_image = $rows['image'];
            $obj->rep_name = $rows['rep_name'];
            
            // Priority selection:
            // 1st priority: area_location (mapped to input area_name)
            // 2nd priority: live_area_name (mapped to input area)
            // 3rd priority: schedule_area_name (fallback)
            if (isset($rows['area_location']) && trim($rows['area_location']) !== "") {
                $obj->area_name = $rows['area_location'];
            } else if (isset($rows['live_area_name']) && trim($rows['live_area_name']) !== "") {
                $obj->area_name = $rows['live_area_name'];
            } else {
                $obj->area_name = isset($rows['schedule_area_name']) ? $rows['schedule_area_name'] : "";
            }
            
            $obj->lat = $rows['latitud'];
            $obj->lang = $rows['langitud'];
            $timestamp = strtotime($rows['last_time']);
            $new_date_format = date('Y-m-d H:i', $timestamp);
            $obj->date_time = $new_date_format;

            array_push($arr, $obj);
        }
        return $arr;
    }
    //particulor_rep_latlang
    function particulor_rep_latlang()
    {
        $query = "SELECT * FROM `live_location` WHERE rep_schedule_token = ? AND rep_token = ? ORDER BY `date_time` ASC, `id` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_schedule_token);
        $stmt->bindParam(2, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    //read_particulor_rep_latlang
    function read_particulor_rep_latlang($stmt)
    {
        $rep_latlang = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep_latlang_obj = new stdClass;
            $rep_latlang_obj->rep_lat = $rows['latitud'];
            $rep_latlang_obj->rep_lang = $rows['langitud'];
            $rep_latlang_obj->rep_schedule_token = $rows['rep_schedule_token'];
            $rep_latlang_obj->rep_token = $rows['rep_token'];
            $rep_latlang_obj->type = $rows['type'];
            array_push($rep_latlang, $rep_latlang_obj);
        }
        return $rep_latlang;
    }

    function latest_sales_rep_latlang()
    {
        $query = "SELECT
            `latitud`,
            `langitud`,
            `date_time`
        FROM `live_location`
        WHERE `rep_token` = ?
        ORDER BY `id` DESC
        LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }

    function latest_sales_rep_latlang_read($stmt)
    {
        $arr = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->lat = $rows['latitud'];
            $obj->lang = $rows['langitud'];
            $obj->date_time = $rows['date_time'];
            array_push($arr, $obj);
        }
        return $arr;
    }
    //shop latlang
    function  shops_latlang($date1)
    {
        $query = "SELECT DISTINCT
            shop.name AS shop_names,
            shop.coordinates AS lats
        FROM
            `employees`
        INNER JOIN shop_mapping ON shop_mapping.distributor_token = employees.token
        INNER JOIN shop ON shop.token = shop_mapping.shop_token
        INNER JOIN schedule_sales_rep ON schedule_sales_rep.distributor_token = employees.token
        WHERE
            schedule_sales_rep.sales_rep_token = ? AND DATE(schedule_sales_rep.date_time) = '$date1' 
            AND shop.delete_status = '1' AND shop.shop_show_status = 'Active' 
            AND employees.delete_status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    //read_shops_latlang
    function read_shops_latlang($stmt1)
    {
        $shop_lat_arr = [];
        while ($rows = $stmt1->fetch(PDO::FETCH_ASSOC)) {
            $shop_lat_obj = new stdClass;
            $shop_lat_obj->shop_name = $rows['shop_names'];
            $shop_lat_obj->lats = $rows['lats'];
            array_push($shop_lat_arr, $shop_lat_obj);
        }
        return $shop_lat_arr;
    }
    //particular sales rep lat lang
    function particulare_state_salesrep_latlang($date, $beforemin)
    {
        $startDate = date('Y-m-d 00:00:00', strtotime($date));
        $endDate = $date;
        $query = "SELECT
            latest_live_location.rep_schedule_token,
            latest_live_location.rep_token,
            employees.employee_image AS image,
            employees.name AS rep_name,
            area.area_name,
            latest_live_location.latitud,
            latest_live_location.langitud,
            latest_live_location.date_time AS last_time
        FROM (
            SELECT ll1.*
            FROM `live_location` ll1
            INNER JOIN (
                SELECT rep_token, MAX(id) AS latest_id
                FROM (
                    SELECT id, rep_token
                    FROM `live_location`
                    ORDER BY id DESC
                    LIMIT 50000
                ) recent_live_location
                GROUP BY rep_token
            ) latest_row
                ON latest_row.latest_id = ll1.id
        ) latest_live_location
        INNER JOIN employees ON employees.token = latest_live_location.rep_token
        LEFT JOIN schedule_sales_rep ON schedule_sales_rep.rep_schedule_token = latest_live_location.rep_schedule_token
        LEFT JOIN area ON area.area_token = schedule_sales_rep.area_token
        WHERE
            schedule_sales_rep.state_token = ?
            AND employees.deparment_token = '72602780'
            AND employees.block_status = '1'
            AND employees.delete_status = '1'
            AND (
                employees.resignation_date IS NULL
                OR TRIM(employees.resignation_date) = ''
                OR employees.resignation_date LIKE '0000-00-00%'
            )
            AND latest_live_location.date_time >= ?
            AND latest_live_location.date_time <= ?
        ORDER BY
            last_time DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $endDate);
        $stmt->execute();
        return $stmt;
    }
    function particulare_state_salesrep_latlang_read($state_stmt)
    {
        $state_rep_latlang = [];
        while ($rows_state = $state_stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj_state = new stdClass;
            $obj_state->rep_image = $rows_state['image'];
            $obj_state->rep_name = $rows_state['rep_name'];
            $obj_state->area_name = $rows_state['area_name'];
            $obj_state->rep_lat = $rows_state['latitud'];
            $obj_state->rep_lang = $rows_state['langitud'];
            $obj_state->rep_token = $rows_state['rep_token'];
            $obj_state->rep_schedule_token = $rows_state['rep_schedule_token'];
            $obj_state->date_time = $rows_state['last_time'];
            array_push($state_rep_latlang, $obj_state);
        }
        return $state_rep_latlang;
    }
    //expense details sales_rep
    function expensedetailCount()
    {
        $query = "SELECT
            id
        FROM
            `sales_rep__expense__details`
        WHERE
            sales_rep__token != ''";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function expensemangement()
    {
        $stateQuery = $this->stateQuery;
        $salesQuery = $this->salesQuery;
        $dateQuery = $this->dateQuery;
        $query = "SELECT `employees`.`token`,
            employees.name,
            DATE(
                sales_rep__expense__details.date_time
            )AS date_time,
            SUM(
                sales_rep__expense__details.amount
            ) AS total,
            GROUP_CONCAT(
                allowance.allowane_type
            ) AS category,
            GROUP_CONCAT(
                sales_rep__expense__details.amount
            ) AS amount
        FROM
            `sales_rep__expense__details`
        INNER JOIN employees ON sales_rep__expense__details.sales_rep__token = employees.token
        INNER JOIN allowance ON sales_rep__expense__details.category_token = allowance.token
        WHERE
            sales_rep__expense__details.status = '1' AND `employees`.`delete_status`='1' $salesQuery $stateQuery  $dateQuery 
        GROUP BY
        date_time,sales_rep__expense__details.sales_rep__token
        ORDER BY
            DATE(
                sales_rep__expense__details.date_time
            )
        DESC
            ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function readexpenseMangement($stmt)
    {
        $array = [];
        while ($row1 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass;
            $obj->token = $row1['token'];
            $obj->name = $row1['name'];
            $obj->date_time = $row1['date_time'];
            $obj->total = $row1['total'];
            $obj->module = $row1['category'];
            $obj->amount = $row1['amount'];
            array_push($array, $obj);
        }
        return $array;
    }


    //expense pdf
    function expenseListPdf()
    {
        $stateQuery = $this->stateQuery;
        $salesQuery = $this->salesQuery;
        $betweenQuery = $this->betweenQuery;
        $query = "SELECT 
            employees.name,
            DATE(
                sales_rep__expense__details.date_time
            )AS date_time,
            SUM(
                sales_rep__expense__details.amount
            ) AS total,
            GROUP_CONCAT(
                allowance.allowane_type
            ) AS category,
            GROUP_CONCAT(
                sales_rep__expense__details.amount
            ) AS amount
        FROM
            `sales_rep__expense__details`
        INNER JOIN employees ON sales_rep__expense__details.sales_rep__token = employees.token
        INNER JOIN allowance ON sales_rep__expense__details.category_token = allowance.token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        WHERE
            sales_rep__expense__details.status = '1' AND `employees`.`delete_status`='1' $salesQuery $stateQuery $betweenQuery
        GROUP BY
            DATE(
                sales_rep__expense__details.date_time
            ),sales_rep__expense__details.sales_rep__token
        ORDER BY
            DATE(
                sales_rep__expense__details.date_time
            )
        DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //livetracking count of leave reps
    function livetrackingcountLeave($date)
    {
        $query = "SELECT COUNT(sales_rep_token)AS leave_count FROM `sales_rep__leave` WHERE date(date_time) ='$date'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function livetrackingcountLeave_read($leave_count)
    {
        $leave_arr = [];
        while ($rows = $leave_count->fetch(PDO::FETCH_ASSOC)) {
            $leave_obj = new stdClass;
            $leave_obj->total_count_leave = $rows['leave_count'] == "" ? "-" : $rows['leave_count'];
            array_push($leave_arr, $leave_obj);
        }
        return $leave_arr;
    }
    function data_latlang($date)
    {
        $query = "SELECT * FROM live_location WHERE latitud = ? AND langitud = ? AND date(date_time)='$date'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->lat);
        $stmt->bindParam(2, $this->lang);
        $stmt->execute();
        return $stmt;
    }
    function read_date_latlang($stmt_lat_lang)
    {
        $date_arr = [];
        while ($rows = $stmt_lat_lang->fetch(PDO::FETCH_ASSOC)) {
            $date_obj = new stdClass;
            $date_obj->date_time = $rows['date_time'];
            array_push($date_arr, $date_obj);
        }
        return $date_arr;
    }

    function particulor_rep_name()
    {
        $query = "SELECT * FROM `employees` WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->rep_token);
        $stmt->execute();
        return $stmt;
    }
    function read_particulor_name($stmt)
    {
        $name_date_arr = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $name_date_obj = new stdClass;
            $name_date_obj->rep_name = $rows['name'];
            array_push($name_date_arr, $name_date_obj);
        }
        return $name_date_arr;
    }

    function admin_add_issue($currentDate, $random_token, $admin_departmenttoken)
    {
        $query = "INSERT INTO `support_table` SET `status_token`= '$random_token',`emp_token` =:emp_token,`name`=:emp_name,`mobile_number`=:mobile_number,`deparment_token`= '$admin_departmenttoken',`description`=:description_text,`attachment`=:attachment_img,`status_code`='0',`date_time`='$currentDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emp_token', $this->admin_token);
        $stmt->bindParam('emp_name', $this->admin_name);
        $stmt->bindParam('mobile_number', $this->admin_mobilenumber);
        //$stmt->bindParam('admin_departmenttoken',$this->admin_departmenttoken);
        $stmt->bindParam('description_text', $this->text);
        $stmt->bindParam('attachment_img', $this->admin_image);
        $stmt->execute();
        return $stmt;
    }

    function admin_add_issue_log($random_token, $admin_name, $admin_departmenttoken, $currentDate)
    {
        $query = "INSERT INTO `support_log` SET `status_token`= '$random_token',`emp_token` =:emp_token,`employee_name`='$admin_name',`deparment_token`= '$admin_departmenttoken',`description`=:description,`status_code`= '0',`created_by`='12345679',`date_time`='$currentDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emp_token', $this->admin_token);
        $stmt->bindParam('description', $this->text);
        $stmt->execute();
        return $stmt;
    }

    function  issue_table()
    {
        $query = "SELECT
            support_table.status_token,
            support_table.emp_token,
            support_table.name AS emp_name,
            support_table.mobile_number,
            deparment.name AS department_name,
            support_table.deparment_token,
            support_table.description,
            support_table.attachment,
            support_table.status_code
        FROM
            `support_table`
        INNER JOIN deparment ON deparment.token = support_table.deparment_token order by support_table.id desc";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function issue_table_read($stmt)
    {
        $read_data = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $read_data_obj = new stdClass;
            $read_data_obj->status_token = $row['status_token'];
            $read_data_obj->emp_token = $row['emp_token'];
            $read_data_obj->emp_name = $row['emp_name'];
            $read_data_obj->mobile_number = $row['mobile_number'];
            $read_data_obj->department_name = $row['department_name'];
            $read_data_obj->deparment_token = $row['deparment_token'];
            $read_data_obj->description = $row['description'];
            $read_data_obj->attachment = $row['attachment'];
            $read_data_obj->status_code = $row['status_code'];
            array_push($read_data, $read_data_obj);
        }
        return $read_data;
    }
    function status_update()
    {
        $query = "UPDATE `support_table` SET status_code = ? WHERE status_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status_code);
        $stmt->bindParam(2, $this->status_token);
        $stmt->execute();
        return $stmt;
    }
    function support_log($currentDate)
    {
        $query = "INSERT INTO `support_log` SET `status_token`= :status_token,`emp_token` =:emp_token,`employee_name`=:employee_name,`deparment_token`=:depo_token,`description`=:description,`status_code`=:status_code,`created_by`='12345679',`date_time`='$currentDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('status_token', $this->status_token);
        $stmt->bindParam('emp_token', $this->emp_token);
        $stmt->bindParam('employee_name', $this->emp_name);
        $stmt->bindParam('depo_token', $this->depo_token);
        $stmt->bindParam('description', $this->description);
        $stmt->bindParam('status_code', $this->status_code);
        $stmt->execute();
        return $stmt;
    }

    function distributor_add_issue($currentDate, $random_token, $deparment_token)
    {
        $query = "INSERT INTO `support_table` SET `status_token`= '$random_token',`emp_token` =:emp_token,`name`=:emp_name,`mobile_number`=:mobile_number,`deparment_token`= '$deparment_token',`description`=:description_text,`attachment`=:attachment_img,`status_code`='0',`date_time`='$currentDate'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('emp_token', $this->Distributor_token);
        $stmt->bindParam('emp_name', $this->Distributor_name);
        $stmt->bindParam('mobile_number', $this->distributor_mobilenumber);
        $stmt->bindParam('description_text', $this->text);
        $stmt->bindParam('attachment_img', $this->distributor_image);
        $stmt->execute();
        return $stmt;
    }

    //sales rep req
    function sales_rep_req($date)
    {
        $query = "SELECT
            schedule_salesRep_request.schedule_token,
            schedule_salesRep_request.sales_rep_token,
            schedule_salesRep_request.distributor_token,
            employees.name AS emp_name,
            schedule_sales_rep.schedule_date AS schedule_date,
            employees__state.state_name AS state_name,
            region.region_name AS region_name,
            schedule_salesRep_request.status
        FROM
            `schedule_salesRep_request`
        INNER JOIN employees ON employees.token = schedule_salesRep_request.sales_rep_token
        INNER JOIN schedule_sales_rep ON schedule_sales_rep.rep_schedule_token = schedule_salesRep_request.schedule_token
        INNER JOIN employees__state ON employees__state.state_token = schedule_sales_rep.state_token
        INNER JOIN region ON schedule_sales_rep.region_token = region.token
        WHERE date(schedule_sales_rep.schedule_date)='$date'
        GROUP BY schedule_salesRep_request.distributor_token ORDER BY schedule_sales_rep.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function sales_rep_req_list($stmt)
    {
        $rep_rq = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep_rq_obj = new stdClass;
            $rep_rq_obj->schedule_token = $rows['schedule_token'];
            $rep_rq_obj->sales_rep_token = $rows['sales_rep_token'];
            $rep_rq_obj->distributor_token = $rows['distributor_token'];
            $rep_rq_obj->emp_name = $rows['emp_name'];
            $rep_rq_obj->schedule_date = $rows['schedule_date'];
            $rep_rq_obj->state_name = $rows['state_name'];
            $rep_rq_obj->region_name = $rows['region_name'];
            $rep_rq_obj->status = $rows['status'];
            array_push($rep_rq, $rep_rq_obj);
        }
        return $rep_rq;
    }
    function schedul_status_update()
    {
        $query = "UPDATE `schedule_salesRep_request` SET `status` = ? WHERE schedule_token = ? AND sales_rep_token= ? AND distributor_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status_change_value);
        $stmt->bindParam(2, $this->schedule_token);
        $stmt->bindParam(3, $this->sales_rep_token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function schedule_sales_rep_status_update()
    {
        $query = "UPDATE `schedule_sales_rep` SET `status` = ? WHERE rep_schedule_token = ? AND sales_rep_token = ? AND distributor_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status_change_value);
        $stmt->bindParam(2, $this->schedule_token);
        $stmt->bindParam(3, $this->sales_rep_token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function schedul_status_update_zero()
    {
        $query = "UPDATE `schedule_salesRep_request` SET `status` = ? WHERE schedule_token = ? AND sales_rep_token= ? AND distributor_token = ?";
        $stmt = $this->conn->prepare($query);


        $stmt->bindParam(1, $this->status_change_value);
        $stmt->bindParam(2, $this->schedule_token);
        $stmt->bindParam(3, $this->sales_rep_token);
        $stmt->bindParam(4, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function schedule_sales_rep_status_update_zero()
    {
        $query = "UPDATE `schedule_sales_rep` SET `status` = '2' WHERE rep_schedule_token = ? AND sales_rep_token = ? AND distributor_token = ?";
        $stmt = $this->conn->prepare($query);
        // $stmt->bindParam(1,$this->status_change_value);
        $stmt->bindParam(1, $this->schedule_token);
        $stmt->bindParam(2, $this->sales_rep_token);
        $stmt->bindParam(3, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    function sales_rep_req_details($timestamp)
    {
        $query = "SELECT
            employees.name AS dis_name,
            schedule_sales_rep.ta AS travel,
            employees__state.state_name AS state_name,
            region.region_name AS region_name,
            area.area_name
        FROM
            `employees__state`
        INNER JOIN `schedule_sales_rep` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `employees` ON `employees`.`token` = `schedule_sales_rep`.`distributor_token`
        WHERE
            `schedule_sales_rep`.`sales_rep_token` = ? AND `schedule_sales_rep`.`status` = '2' AND  DATE(
                `schedule_sales_rep`.`schedule_date` 
            ) = '$timestamp' AND employees.token = ? GROUP BY employees.token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesReoToken);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function sales_rep_req_details_list($stmt)
    {
        $rep_rq_details = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep_rq_detail_obj = new stdClass;
            $rep_rq_detail_obj->dis_name = $rows['dis_name'];
            $rep_rq_detail_obj->travel = $rows['travel'];
            $rep_rq_detail_obj->state_name = $rows['state_name'];
            $rep_rq_detail_obj->region_name = $rows['region_name'];
            $rep_rq_detail_obj->area_name = $rows['area_name'];
            array_push($rep_rq_details, $rep_rq_detail_obj);
        }
        return $rep_rq_details;
    }

    function sales_rep_req_details_status_check($timestamp)
    {
        $query = "SELECT
            employees.name AS dis_name,
            schedule_sales_rep.ta AS travel,
            employees__state.state_name AS state_name,
            region.region_name AS region_name,
            area.area_name
        FROM
            `employees__state`
        INNER JOIN `schedule_sales_rep` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `employees` ON `employees`.`token` = `schedule_sales_rep`.`distributor_token`
        WHERE
            `schedule_sales_rep`.`sales_rep_token` = ? AND `schedule_sales_rep`.`status` = '1' AND  DATE(
                `schedule_sales_rep`.`schedule_date` 
            ) = '$timestamp' AND employees.token = ? GROUP BY employees.token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesReoToken);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function sales_rep_req_details_status_check_list($stmt)
    {
        $rep_rq_details_check = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep_rq_detail_check_obj = new stdClass;
            $rep_rq_detail_check_obj->dis_name = $rows['dis_name'];
            $rep_rq_detail_check_obj->travel = $rows['travel'];
            $rep_rq_detail_check_obj->state_name = $rows['state_name'];
            $rep_rq_detail_check_obj->region_name = $rows['region_name'];
            $rep_rq_detail_check_obj->area_name = $rows['area_name'];
            array_push($rep_rq_details_check, $rep_rq_detail_check_obj);
        }
        return $rep_rq_details_check;
    }

    function sales_rep_req_details_status_check2($timestamp)
    {
        $query = "SELECT
            employees.name AS dis_name,
            schedule_sales_rep.ta AS travel,
            employees__state.state_name AS state_name,
            region.region_name AS region_name,
            area.area_name
        FROM
            `employees__state`
        INNER JOIN `schedule_sales_rep` ON `employees__state`.`state_token` = `schedule_sales_rep`.`state_token`
        INNER JOIN `region` ON `region`.`token` = `schedule_sales_rep`.`region_token`
        INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
        INNER JOIN `employees` ON `employees`.`token` = `schedule_sales_rep`.`distributor_token`
        WHERE
            `schedule_sales_rep`.`sales_rep_token` = ? AND `schedule_sales_rep`.`status` = '2' AND  DATE(
                `schedule_sales_rep`.`schedule_date` 
            ) = '$timestamp' AND employees.token = ? GROUP BY employees.token";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->salesReoToken);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function sales_rep_req_details_status_check_list2($stmt)
    {
        $rep_rq_details_check2 = [];
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rep_rq_detail_check_obj_2 = new stdClass;
            $rep_rq_detail_check_obj_2->dis_name = $rows['dis_name'];
            $rep_rq_detail_check_obj_2->travel = $rows['travel'];
            $rep_rq_detail_check_obj_2->state_name = $rows['state_name'];
            $rep_rq_detail_check_obj_2->region_name = $rows['region_name'];
            $rep_rq_detail_check_obj_2->area_name = $rows['area_name'];
            array_push($rep_rq_details_check2, $rep_rq_detail_check_obj_2);
        }
        return $rep_rq_details_check2;
    }

    function status_update_rq()
    {
        $query = "UPDATE `employees` SET delete_status = ?  WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status_token);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function status_update_rq_mapping()
    {
        $query = "UPDATE `sales_rep_add_distributor` SET status_code = ? WHERE distributor_token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->status_token);
        $stmt->bindParam(2, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }

    //====rolls
    function rollFunction()
    {
        $query = "SELECT `token`,`name` FROM `deparment` WHERE  token IN ('72602780','98765433','98765434')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function rollslist($stmt)
    {
        $rollsArr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rollsobj = new stdClass;
            $rollsobj->rolls_token = $row['token'];
            $rollsobj->rolls_name = $row['name'];
            array_push($rollsArr, $rollsobj);
        }
        return $rollsArr;
    }
    function addroleamount($random)
    {
        $query =  "INSERT INTO `sales_rep__allowance` SET `token` = '$random',`state_id` =:state_id,`dep_token` =:roles_token,`amount_outside_roaming`=:alamount1";
        $stmt =  $this->conn->prepare($query);
        $stmt->bindParam('state_id', $this->state_token);
        $stmt->bindParam('roles_token', $this->roles_token);
        $stmt->bindParam('alamount1', $this->alamount1);
        $stmt->execute();
        return $stmt;
    }
    function addroleamount2($random)
    {
        $query = "INSERT INTO `sales_rep__allowance` SET token ='$random',`state_id` =:state_id,`dep_token` =:roles_token,`amount_outside_roaming`=:alamount1,`amount_inside_roaming`=:alamount2";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('state_id', $this->state_token);
        $stmt->bindParam('roles_token', $this->roles_token);
        $stmt->bindParam('alamount1', $this->alamount1);
        $stmt->bindParam('alamount2', $this->alamount2);
        $stmt->execute();
        return $stmt;
    }
    function role_table_data()
    {
        $query = "SELECT
                employees__state.state_token,
                employees__state.state_name,
                deparment.name AS dep_name,
                deparment.token AS dep_token,
                sales_rep__allowance.token AS sales_allowance_token,
                CONCAT(
                    sales_rep__allowance.amount_outside_roaming,
                    ',',
                    sales_rep__allowance.amount_inside_roaming
                ) AS amt
            FROM
                `sales_rep__allowance`
            LEFT JOIN employees__state ON employees__state.state_token = sales_rep__allowance.state_id
            LEFT JOIN deparment ON deparment.token = sales_rep__allowance.dep_token";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function role_table_data_list($stmt)
    {
        $rollsAMTArr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $rollsamtobj = new stdClass;
            $rollsamtobj->state_token = $row['state_token'];
            $rollsamtobj->state_name = $row['state_name'];
            $rollsamtobj->dep_name = $row['dep_name'];
            $rollsamtobj->dep_token = $row['dep_token'];
            $rollsamtobj->sales_allowance_token = $row['sales_allowance_token'];
            $rollsamtobj->al_amount = $row['amt'];
            array_push($rollsAMTArr, $rollsamtobj);
        }
        return $rollsAMTArr;
    }

    function updateroleamount1()
    {
        $query = "UPDATE `sales_rep__allowance` SET `state_id`= ?,`dep_token`= ?,`amount_outside_roaming`= ? WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->bindParam(2, $this->roles_token);
        $stmt->bindParam(3, $this->alamount1);
        $stmt->bindParam(4, $this->rep_al_token);
        $stmt->execute();
        return $stmt;
    }
    function updateroleamount2()
    {
        $query = "UPDATE `sales_rep__allowance` SET `state_id`= ?,`dep_token`= ?,`amount_outside_roaming`= ? ,`amount_inside_roaming`= ?  WHERE `token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->state_token);
        $stmt->bindParam(2, $this->roles_token);
        $stmt->bindParam(3, $this->alamount1);
        $stmt->bindParam(4, $this->alamount2);
        $stmt->bindParam(5, $this->rep_al_token);
        $stmt->execute();
        return $stmt;
    }
    function check_schedule()
    {
        $query = "SELECT * FROM `schedule_sales_rep` WHERE rep_schedule_token = ? ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->schedule_token);
        $stmt->execute();
        return $stmt;
    }

    //log schedule
    function allDetails()
    {
        $indiaDate     = date("Y-m-d");
        $query = "SELECT * FROM `schedule_sales_rep` WHERE rep_schedule_token=? AND schedule_date='$indiaDate' GROUP BY `area_token`,`distributor_token`";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->schedule_token);
        $stmt->execute();
        return $stmt;
    }
    function readallDetails($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->sales_rep_token = $row['sales_rep_token'];
            $arr_obj->state_token = $row['state_token'];
            $arr_obj->region_token = $row['region_token'];
            $arr_obj->area_token = $row['area_token'];
            $arr_obj->distributor_token = $row['distributor_token'];
            array_push($array, $arr_obj);
        }
        return $array;
    }

    function scheduleDeleteLog($indiaDateTime)
    {
        $schedule_token = $this->schedule_token;
        $sales_rep_token = $this->sales_rep_token;
        $area_token = $this->area_token;
        $distributor_token = $this->distributor_token;
        $state_token = $this->state_token;
        $region_token = $this->region_token;
        $admin_token = $this->admin_token;
        $inserts[] = "('$schedule_token','$sales_rep_token','$state_token','$state_token','$region_token','$region_token','$area_token','$area_token','$distributor_token','$distributor_token','$admin_token','$indiaDateTime','2')";
        $query = "INSERT INTO `schedule_log`(`rep_schedule_token`,`sales_rep_token`,`old_state_token`,`new_state_token`, `old_region_token`,`new_region_token`, `old_area_token`,`new_area_token`,`old_distributor_token`,`new_distributor_token`,`created_by`,`date_time`,`status`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function disable_schedule()
    {
        $query = "UPDATE `schedule_sales_rep` SET `status` = '2'  WHERE `rep_schedule_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->schedule_token);
        $stmt->execute();
        return $stmt;
    }
    function disable_schedule_mappig()
    {
        $query = "UPDATE `sales_rep_schedule_mapping` SET `status` = '2'  WHERE `rep_schedule_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->schedule_token);
        $stmt->execute();
        return $stmt;
    }
    function  support_log_data()
    {
        $query = "SELECT
            -- employees.name AS employees_name,
            support_log.employee_name,
            depo.name AS deparment_name,
            support_log.description,
            support_log.status_code,
            admin_login.name AS created_by_person,
            support_log.date_time
        FROM
            `support_log`
        
        -- LEFT JOIN employees ON employees.token = support_log.emp_token
        LEFT JOIN admin_login ON `support_log`.`created_by` = admin_login.token
        LEFT JOIN deparment AS depo
        ON
            depo.token = support_log.deparment_token ORDER BY support_log.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function support_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->employees_name = $row['employee_name'];
            $arr_obj->deparment_name = $row['deparment_name'];
            $arr_obj->description = $row['description'];
            $arr_obj->status_code = $row['status_code'];
            $arr_obj->created_by_person = $row['created_by_person'];
            $arr_obj->date_time = $row['date_time'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }

    //=======shop_type_log

    function  shop_type_log_data()
    {
        $query = "SELECT
            shop_typeLog.old_name,
            shop_typeLog.new_name,
            shop_typeLog.date_time,
            admin_login.name AS user_name
        FROM
            `shop_typeLog`
        LEFT JOIN admin_login ON admin_login.token = shop_typeLog.created_by ORDER BY shop_typeLog.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function shop_type_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->old_name = $row['old_name'];
            $arr_obj->new_name = $row['new_name'];
            $arr_obj->date_time = $row['date_time'];
            $arr_obj->user_name = $row['user_name'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }
    //=======shop_create_log
    function  shop_create_log_data()
    {
        $query = "SELECT
            shopedit_log.old_shop_name,
            shopedit_log.new_shop_name,
            shopedit_log.old_mobile,
            shopedit_log.new_mobile,
            shopedit_log.old_licens_number,
            shopedit_log.new_licens_number,
            shopedit_log.old_address,
            shopedit_log.new_address,
            shopedit_log.old_city,
            shopedit_log.new_city,
            shopedit_log.old_pincode,
            shopedit_log.new_pincode,
            admin_login.name AS admin_name
        FROM
            `shopedit_log`
        LEFT JOIN admin_login ON admin_login.token = shopedit_log.created_by ORDER BY shopedit_log.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function shop_create_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->old_shop_name = $row['old_shop_name'];
            $arr_obj->new_shop_name = $row['new_shop_name'];
            $arr_obj->old_mobile = $row['old_mobile'];
            $arr_obj->new_mobile = $row['new_mobile'];
            $arr_obj->old_licens_number = $row['old_licens_number'];
            $arr_obj->new_licens_number = $row['new_licens_number'];
            $arr_obj->old_address = $row['old_address'];
            $arr_obj->new_address = $row['new_address'];
            $arr_obj->old_city = $row['old_city'];
            $arr_obj->new_city = $row['new_city'];
            $arr_obj->old_pincode = $row['old_pincode'];
            $arr_obj->new_pincode = $row['new_pincode'];
            $arr_obj->admin_name = $row['admin_name'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }
    //=======admin_stock_log
    function  admin_stock_log_data()
    {
        $query = "SELECT
			products.name AS product_name,
           `adminStockLog`.`before_stock`,
            adminStockLog.updated_stock,
            admin_login.name AS admin_name,
            adminStockLog.add_date_time,
            adminStockLog.update_date_time
        FROM
            `adminStockLog`
         LEFT JOIN products ON products.token = adminStockLog.product_token
        LEFT JOIN admin_login ON admin_login.token = adminStockLog.created_by ORDER BY adminStockLog.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function admin_stock_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->product_name = $row['product_name'];
            $arr_obj->before_stock = $row['before_stock'];
            $arr_obj->updated_stock = $row['updated_stock'];
            $arr_obj->admin_name = $row['admin_name'];
            $arr_obj->add_date_time = $row['add_date_time'];
            $arr_obj->update_date_time = $row['update_date_time'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }
    //=======distributot__log
    function  Distributor_log_data()
    {
        $query = "SELECT
            distributor_log1.distributor_token,
            distributor_log1.old_name,
            distributor_log1.new_name,
            distributor_log1.old_mobile,
            distributor_log1.new_mobile,
            distributor_log1.old_license,
            distributor_log1.new_license,
            distributor_log1.old_email,
            distributor_log1.new_email,
            admin_login.name AS admin_name,
            distributor_log1.block_status,
            distributor_log1.date_and_time,
            distributor_log1.status AS status_code
        FROM
            `distributor_log1`
        LEFT JOIN admin_login ON admin_login.token = distributor_log1.created_by ORDER BY distributor_log1.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function Distributor_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->distributor_token = $row['distributor_token'];
            $arr_obj->old_name = $row['old_name'];
            $arr_obj->new_name = $row['new_name'];
            $arr_obj->old_mobile = $row['old_mobile'];
            $arr_obj->new_mobile = $row['new_mobile'];
            $arr_obj->old_license = $row['old_license'];
            $arr_obj->new_license = $row['new_license'];
            $arr_obj->old_email = $row['old_email'];
            $arr_obj->new_email = $row['new_email'];
            $arr_obj->block_status = $row['block_status'];
            $arr_obj->date_and_time = $row['date_and_time'];
            $arr_obj->admin_name = $row['admin_name'];
            $arr_obj->status_code = $row['status_code'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }
    function Distributor_division_log_data()
    {
        $query = "SELECT
            products__category.name AS division_name
        FROM
            `employees__division_mapping`
        LEFT JOIN products__category ON products__category.token = employees__division_mapping.division_token
        WHERE
            employees__division_mapping.employee_token =? ORDER BY employees__division_mapping.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function Distributor_division_log_data_read($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->division_name = $row['division_name'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }

    function Distributor_division_log_data1()
    {
        $query = " SELECT
            products__category.name AS division_name
        FROM
            `employees__division_mapping`
        LEFT JOIN products__category ON products__category.token = employees__division_mapping.division_token
        WHERE
            employees__division_mapping.employee_token =? AND employees__division_mapping.delete_status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        return $stmt;
    }
    function Distributor_division_log_data_read1($stmt)
    {
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_obj = new stdClass;
            $arr_obj->division_name = $row['division_name'];
            array_push($arr, $arr_obj);
        }
        return $arr;
    }

    function all_schem_report($date_fillter)
    {
        $query = "SELECT
            byitem.token AS products_token,
            `byitem`.`name` AS `buy_product`,
            products__scheme.`scheme_name`,
            `products__scheme`.`image`,
            products__scheme.`limit_box`,
            products__scheme.`free_box`,
            `Freeitem`.`name` AS `free_product`,
            COALESCE(SUM(freeboxs.quantity),
            0) AS total_free_box,
            COALESCE(SUM(sold_boxs.quantity),
            0) AS total_buy_box
        FROM
            `orders` AS orders1
        INNER JOIN orders__items AS sold_boxs
        ON
            sold_boxs.order_token = orders1.token
        INNER JOIN orders__items AS freeboxs
        ON
            freeboxs.order_token = sold_boxs.order_token
        INNER JOIN products AS byitem
        ON
            byitem.token = sold_boxs.product_token
        INNER JOIN products AS Freeitem
        ON
            Freeitem.token = sold_boxs.product_token
        INNER JOIN products__scheme  ON products__scheme.token = freeboxs.scheme_token
        WHERE
            sold_boxs.is_free = '0' AND products__scheme.is_scheme = '1' AND freeboxs.is_free = '1' AND orders1.delivery = 'Completed' $date_fillter
        GROUP BY
            products__scheme.token,freeboxs.scheme_token
        ORDER BY
            orders1.id
        DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function all_schem_report_read($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $schem_obj = new stdClass();
            // $obj->token = $row["token"];
            //$obj->product_token = $row["product_token"];
            $schem_obj->product_name = $row["buy_product"];
            $schem_obj->scheme_name = $row["scheme_name"];
            $schem_obj->limit_box = $row["limit_box"];
            $schem_obj->free_product_box = $row["free_box"];
            $schem_obj->buy_box = $row["total_buy_box"];
            $schem_obj->free_box = $row["total_free_box"];
            $schem_obj->image = $row["image"];
            $schem_obj->free_product = $row["free_product"];
            array_push($array, $schem_obj);
        }
        return $array;
    }

    function overall_item_product_report($filters)
    {
        $query = "SELECT
        employees__state.state_token,
        employees__state.state_name,
        products__category.token AS division_token,
        products__category.name AS division_name,
        products.token AS product_token,
        products.name AS product_name,
        sum(orders__items.quantity)  AS quantity,
        orders__items.price_per_unit,
        COALESCE(
            orders__items.price_per_unit * orders__items.piece_count * orders__items.quantity,
            '0'
        ) AS total_sales_amount
    FROM
        `products`
    INNER JOIN products__category ON products__category.token = products.category_token
    INNER JOIN orders__items ON orders__items.product_token = products.token
    INNER JOIN orders ON orders.token = orders__items.order_token
    INNER JOIN employees ON employees.token = orders.employee_token
    INNER JOIN employees__state ON employees__state.state_token = employees.state_id
    WHERE
        orders.order_type = 'Distributor Order' AND orders.delivery = 'Completed' AND products.delete_status = '1'  $filters
    GROUP BY
        products.token ORDER BY orders.id DESC";
        $stmt = $this->conn->prepare($query);
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
    function sales_order_count($filters)
    {
        $query = "SELECT
            employees.token,
            employees.name AS distributor_name,
            employees__state.state_name AS state_name,
            region.region_name AS region_name,
            COALESCE(COUNT(orders.shop_token),0) AS order_taken_shop_count,
            COALESCE(SUM(orders.billing_amount),0) AS total_amount
        FROM
            employees
        INNER JOIN orders ON employees.token = orders.distributor_token
        INNER JOIN employees__state ON employees__state.state_token = employees.state_id
        INNER JOIN region ON region.token = employees.region_id
        WHERE
            orders.order_type = 'Sales Order' AND orders.delivery != 'Cancelled' $filters GROUP BY employees.token";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    function sales_order_count_read($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass();
            $obj1->token = $row['token'];
            $obj1->distributor_name = $row['distributor_name'];
            $obj1->state_name = $row['state_name'];
            $obj1->region_name = $row['region_name'];
            $obj1->order_taken_shop_count = $row['order_taken_shop_count'];
            $obj1->total_amount = $row['total_amount'];
            array_push($array, $obj1);
        }
        return $array;
    }

    //sales order no order
    function no_orderSales($arr_token)
    {
        $query = "SELECT
        employees.token,
        employees.name AS distributor_name,
        employees__state.state_name AS state_name,
        region.region_name AS region_name,
       COALESCE(CASE WHEN `orders`.`employee_token` = `employees`.`token` THEN COUNT(`orders`.`id`)ELSE 0 END) AS order_taken_shop_count
    FROM
        employees
    INNER JOIN orders ON employees.token != orders.distributor_token
    INNER JOIN employees__state ON employees__state.state_token = employees.state_id
    INNER JOIN region ON region.token = employees.region_id
    WHERE
        orders.order_type = 'Sales Order' AND orders.delivery != 'Cancelled' 
        AND employees.token NOT IN(" . implode(',', $arr_token) . ") GROUP BY
        `employees`.`token`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    function no_order_readSales($stmt)
    {
        $array = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $obj1 = new stdClass();
            $obj1->token = $row['token'];
            $obj1->distributor_name = $row['distributor_name'];
            $obj1->state_name = $row['state_name'];
            $obj1->region_name = $row['region_name'];
            $obj1->order_taken_shop_count = $row['order_taken_shop_count'];
            array_push($array, $obj1);
        }
        return $array;
    }

    function partculoar_division_product1()
    {
        $division = $this->division;
        $query1 = "SELECT
        products.category_token AS division_token,
        products__category.name AS name,
        products.token AS product_token,
        products.name AS product_name
    FROM
        `products`
    INNER JOIN products__category ON products__category.token = products.category_token
    WHERE
        products.category_token IN (" . implode(',', $division) . ") AND products__category.delete_status = '1'";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        return $stmt1;
    }
    function partculoar_division_product1_read($stmt3)
    {
        $array = [];
        while ($row = $stmt3->fetch(PDO::FETCH_ASSOC)) {
            $obj_product = new stdClass();
            $obj_product->division_token = $row["division_token"];
            $obj_product->name = $row["name"];
            $obj_product->product_token = $row["product_token"];
            $obj_product->product_name = $row["product_name"];
            array_push($array, $obj_product);
        }
        return $array;
    }

    function stationarySalesRepAlerts($currentDateTime, $minutes = 30)
    {
        $lookbackMinutes = $minutes + 10;
        $query = "SELECT
            ll.rep_token,
            MAX(e.name) AS rep_name,
            MAX(es.state_name) AS state_name,
            MAX(ll.rep_schedule_token) AS rep_schedule_token,
            MIN(ll.date_time) AS start_time,
            MAX(ll.date_time) AS end_time,
            ROUND(AVG(ll.latitud), 5) AS latitud,
            ROUND(AVG(ll.langitud), 5) AS langitud
        FROM `live_location` ll
        INNER JOIN `employees` e
            ON e.token = ll.rep_token
            AND e.deparment_token = '72602780'
            AND e.block_status = '1'
            AND e.delete_status = '1'
        INNER JOIN `schedule_sales_rep` ssr
            ON ssr.sales_rep_token = ll.rep_token
            AND ssr.status = '1'
            AND DATE(ssr.date_time) = DATE(?)
        LEFT JOIN `employees__state` es
            ON es.state_token = ssr.state_token
        WHERE ll.date_time BETWEEN DATE_SUB(?, INTERVAL $lookbackMinutes MINUTE) AND ?
        GROUP BY ll.rep_token
        HAVING COUNT(*) >= 2
            AND MAX(ll.date_time) > DATE_SUB(?, INTERVAL $minutes MINUTE)
            AND MIN(ll.date_time) <= DATE_SUB(?, INTERVAL $minutes MINUTE)
            AND (MAX(ll.latitud) - MIN(ll.latitud)) <= 0.0005
            AND (MAX(ll.langitud) - MIN(ll.langitud)) <= 0.0005";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $currentDateTime);
        $stmt->bindParam(2, $currentDateTime);
        $stmt->bindParam(3, $currentDateTime);
        $stmt->bindParam(4, $currentDateTime);
        $stmt->bindParam(5, $currentDateTime);
        $stmt->execute();
        return $stmt;
    }

    function offlineSalesRepAlerts($currentDateTime, $staleBefore)
    {
        $query = "SELECT
            ssr.sales_rep_token AS rep_token,
            MAX(e.name) AS rep_name,
            MAX(es.state_name) AS state_name,
            MAX(ssr.rep_schedule_token) AS rep_schedule_token,
            MAX(ll.last_time) AS last_time
        FROM `schedule_sales_rep` ssr
        INNER JOIN `employees` e
            ON e.token = ssr.sales_rep_token
            AND e.deparment_token = '72602780'
            AND e.block_status = '1'
            AND e.delete_status = '1'
        LEFT JOIN `employees__state` es
            ON es.state_token = ssr.state_token
        LEFT JOIN (
            SELECT rep_token, MAX(date_time) AS last_time
            FROM `live_location`
            WHERE date_time >= DATE(?) AND date_time <= ?
            GROUP BY rep_token
        ) ll
            ON ll.rep_token = ssr.sales_rep_token
        WHERE ssr.status = '1'
            AND DATE(ssr.date_time) = DATE(?)
        GROUP BY ssr.sales_rep_token
        HAVING (last_time IS NULL AND MIN(ssr.date_time) <= ?)
            OR last_time <= ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $currentDateTime);
        $stmt->bindParam(2, $currentDateTime);
        $stmt->bindParam(3, $currentDateTime);
        $stmt->bindParam(4, $staleBefore);
        $stmt->bindParam(5, $staleBefore);
        $stmt->execute();
        return $stmt;
    }
}
