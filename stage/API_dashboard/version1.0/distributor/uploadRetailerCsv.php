<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer_distributor.php';
$distributor_token = $_SESSION['distributor_token'];
$state_token = $_SESSION["state_id"];
$retailer = new Retailer($db);
$currentdate = $indiaDateTime;
$array = [];
$mobileNumber_array = [];
$row = 1;
$obj = new stdClass();

// Define the indexes for mandatory fields based on the expected CSV format
$mandatory_fields = [
    'Shop Name' => 0,
    'Mobile Number' => 2,
    'Shop Type' => 3,
    'Shop Address' => 5,
    'Shop City' => 6,
    'Shop Pincode' => 7
];

if (is_array($_FILES)) {
    if (is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
        $sourcePath = $_FILES['file_upload']['tmp_name'];
        if (($handle = fopen($sourcePath, "r")) !== FALSE) {
            $retailer_array = [];
            $retailer_outstanding_array = [];
            $retailer_map = [];
            $retailer_mapping = [];
            while (($data = fgetcsv($handle, 1000, ",", '"')) !== FALSE) {
                if ($row > 1) {
                    $missing_fields = [];
                    $data = array_map('trim', $data); // Trim all fields
                    foreach ($mandatory_fields as $field_name => $index) {
                        if (!isset($data[$index]) || empty($data[$index])) {
                            $missing_fields[] = $field_name;
                        }
                    }
                    if (!empty($missing_fields)) {
                        $obj->code = 503;
                        $obj->message = "The following mandatory fields are missing: " . implode(", ", $missing_fields);
                        echo json_encode($obj);
                        exit;
                    }

                    $token = token_generate("shop", "token");
                    $retailtoken = $token;
                    $token_map = token_generate("shop_mapping", "token");
                    $token_mapping = $token_map;
                    $mobile_number = addslashes($data[2]);
                    $retailer->mobile_number = $mobile_number;
                    $retailer->distributor_token = $distributor_token;
                    $license_number = addslashes($data[4]);
                    $retailer->license_number = $license_number;
                    $stmt = $retailer->checkRetailerMobileNumber();
                    $countmobile = $stmt->rowCount();
                    $data1 = $retailer->readcheckRetailer($stmt);
                    $map_token = $data1[0];

                    if ($countmobile == 0) {
                        $retailCode = token_generate("shop", "retail_code");
                        $retail_code = $retailCode;
                        $name = addslashes($data[0]);
                        $contact_person = addslashes($data[1]);
                        $retailer->shopTypeName = addslashes($data[3]);
                        $shop_type_code = $retailer->getShopTypeToken();
                        $address = addslashes($data[5]);
                        $city = addslashes($data[6]);
                        $pincode = addslashes($data[7]);
                        $coordinates = isset($data[8]) ? addslashes($data[8]) : '';
                        $license_image = '';
                        $slot_type = '0%';
                        $join_date = $indiaDateTime;
                        $created_by = '';
                        $unit_token = '';
                        $delete_status = '1';

                        mysqli_query($link, "INSERT INTO `shop`(`token`, `name`, `date_time`, `retail_code`, `shop_type_code`, `slot`, `mobile_number`, `contact_person`, `join_date`, `license_number`, `license_image`, `delete_status`, `address`, `city`, `state_id`, `pincode`, `coordinates`, `created_by`) VALUES('$retailtoken','$name','$date_time','$retail_code','$shop_type_code','$slot_type','$mobile_number','$contact_person','$join_date','$license_number','$license_image','$delete_status','$address','$city','$state_token','$pincode','$coordinates','$created_by')");
                        mysqli_query($link, "INSERT INTO `shop_mapping`(`token`,`shop_token`,`distributor_token`,`unit_token`,`date_time`,`status`) VALUES('$token_mapping','$retailtoken','$distributor_token','$unit_token','$indiaDateTime','1')");
                        mysqli_query($link, "INSERT INTO `shop__outstanding`(`date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES('$date_time','$token_mapping','0','0','0','0')");
                    } else {
                        $query = mysqli_query($link, "SELECT `token` FROM `shop_mapping` WHERE `distributor_token`=$distributor_token AND `shop_token`='$map_token'");
                        $count = mysqli_num_rows($query);
                        if ($count == 0) {
                            mysqli_query($link, "INSERT INTO `shop_mapping`(`token`,`shop_token`,`distributor_token`,`unit_token`,`date_time`,`status`) VALUES('$token_mapping','$map_token','$distributor_token','$unit_token','$indiaDateTime','1')");
                            mysqli_query($link, "INSERT INTO `shop__outstanding`(`date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES('$date_time','$token_mapping','0','0','0','0')");
                        } else {
                            array_push($mobileNumber_array, $retailer->mobile_number);
                        }
                    }
                    array_push($array, $retailer->token);
                }
                $row++;
            }
            fclose($handle);
            if (count($mobileNumber_array) == 0) {
                $obj->code = 201;
                $obj->message = "CSV Data Upload Successfully";
            } else if (count($mobileNumber_array) > 1) {
                $obj->code = 503;
                $obj->message = implode(", ", $mobileNumber_array) . " this Mobile Number already exists. We can't upload this Shop detail.";
            } else {
                $obj->code = 503;
                $obj->message = "error";
            }
        }
    }
} else {
    $obj->code = 503;
    $obj->message = "Error2";
}
echo json_encode($obj);
