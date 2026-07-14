<?php
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
$currentdate=$indiaDateTime;
$array = [];
$mobileNumber_array = [];
//$licenseNumber_array = [];
$row = 1;
$obj=new stdClass();
if(is_array($_FILES)) {
    if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
        $sourcePath = $_FILES['file_upload']['tmp_name'];
        if (($handle = fopen($sourcePath, "r")) !== FALSE) {
            $retailer_array = [];
            $retailer_outstanding_array = [];
            $retailer_map=[];
            while (($data = fgetcsv($handle, 1000, ",",'"')) !== FALSE) {
                $num = count($data);
                for ($c=0; $c < $num; $c++) {
                   if($c==0){
                        if($row>1){
                            $token   = token_generate("shop","token");
                            $retailtoken  = $token;
                            $distributor_token = $distributor_token;
                            $mobile_number  = addslashes($data[2]);
                            $retailer->mobile_number = $mobile_number;
                            $license_number  = addslashes($data[4]);
                            $retailer->license_number = $license_number;
                            $stmt=$retailer->checkRetailerMobileNumber();
                            $countmobile = $stmt->rowCount();  
                            // $stmt1=$retailer->checkRetailerLicenseNumber();
                            // $countLicense = $stmt1->rowCount();
                            if($countmobile == 0){
                                $retailCode    = token_generate("shop","retail_code");
                                $retail_code     = $retailCode;
                                $name       = addslashes($data[0]);
                                $contact_person  = addslashes($data[1]);
                                $retailer->shopTypeName   = addslashes($data[3]);
                                $shop_type_code  = $retailer->getShopTypeToken();
                                $address    = addslashes($data[5]);
                                $city       = addslashes($data[6]);
                                $pincode    = addslashes($data[7]);
                                $coordinates= addslashes($data[8]);
                                $license_image  = '';
                                $slot_type  = '0%';
                                $date_time  = $indiaDateTime;
                                $join_date  = $indiaDateTime;
                                $created_by  = '';
                                $unit_token  = '';
                                $delete_status  = '1';
                                $retailer_array[] = "('$retailtoken','$name','$date_time','$unit_token','$retail_code','$shop_type_code','$slot_type','$mobile_number','$contact_person','$join_date','$license_number','$license_image','$delete_status','$address','$city','$state_token','$pincode','$coordinates','$created_by')";
                                $retailer_outstanding_array[] = "('$date_time','$retailtoken','0','0','0','0')";
                                $retailer_map[]= "('$retailtoken','$distributor_token','$indiaDateTime','1')";
                            }else if($countmobile != 0){
                                    array_push($mobileNumber_array, $retailer->mobile_number);
                            }
                            else{
                                $retailCode    = token_generate("shop","retail_code");
                                $retail_code     = $retailCode;
                                $name       = addslashes($data[0]);
                                $contact_person  = addslashes($data[1]);
                                $retailer->shopTypeName   = addslashes($data[3]);
                                $shop_type_code  = $retailer->getShopTypeToken();
                                $address    = addslashes($data[5]);
                                $city       = addslashes($data[6]);
                                $pincode    = addslashes($data[7]);
                                $coordinates= addslashes($data[8]);
                                $license_image  = '';
                                $slot_type  = '0%';
                                $date_time  = $indiaDateTime;
                                $join_date  = $indiaDateTime;
                                $created_by  = '';
                                $unit_token  = '';
                                $delete_status  = '1';
                                $retailer_array[] = "('$retailtoken','$name','$date_time','$unit_token','$retail_code','$shop_type_code','$slot_type','$mobile_number','$contact_person','$join_date','$license_number','$license_image','$delete_status','$address','$city','$state_token','$pincode','$coordinates','$created_by')";
                                $retailer_outstanding_array[] = "('$date_time','$retailtoken','0','0','0','0')";
                                $retailer_map[]= "('$retailtoken','$distributor_token','$indiaDateTime','1')";
                                array_push($mobileNumber_array, $retailer->mobile_number);
                            }
                        
                            array_push($array, $retailer->token);
                        }
                    }
               }
                $row++;
            }
            fclose($handle);
            $stmt=$retailer->checkRetailerMobileNumber();
            $countmobile = $stmt->rowCount();  
             if($mobileNumber_array){
                $mobile = implode(",",$mobileNumber_array);
                $query = mysqli_query($link,"SELECT `token` FROM `shop` WHERE `mobile_number` IN ($mobile)");
                while($row = mysqli_fetch_array($query)){
                 $token = $row['token'];
                 $queryMap=mysqli_query($link,"INSERT INTO `shop_mapping`( `shop_token`, `distributor_token`, `date_time`, `status`) VALUES ('$token','$distributor_token','$indiaDateTime','1')");
                }
                if($countmobile==0){
                    $queryShop = mysqli_query($link,'INSERT INTO `shop`(`token`, `name`, `date_time`, `unit_token`, `retail_code`, `shop_type_code`, `slot`, `mobile_number`, `contact_person`, `join_date`, `license_number`, `license_image`, `delete_status`, `address`, `city`, `state_id`, `pincode`, `coordinates`, `created_by`) VALUES'.implode(", ", $retailer_array));
                   $queryMap=mysqli_query($link,'INSERT INTO `shop_mapping`(`shop_token`,`distributor_token`,`date_time`,`status`)VALUES'.implode(", ", $retailer_map));
   
            }
        }else{
            $queryShop = mysqli_query($link,'INSERT INTO `shop`(`token`, `name`, `date_time`, `unit_token`, `retail_code`, `shop_type_code`, `slot`, `mobile_number`, `contact_person`, `join_date`, `license_number`, `license_image`, `delete_status`, `address`, `city`, `state_id`, `pincode`, `coordinates`, `created_by`) VALUES'.implode(", ", $retailer_array));
                   $queryMap=mysqli_query($link,'INSERT INTO `shop_mapping`(`shop_token`,`distributor_token`,`date_time`,`status`)VALUES'.implode(", ", $retailer_map));
   
        }
            $queryShopOutstanding = mysqli_query($link,'INSERT INTO `shop__outstanding`(`date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES'.implode(", ", $retailer_outstanding_array));
                if($distributor_token || $mobileNumber_array){
                    $obj->code     = 201;
                    $obj->message = "CSV Data Upload Successfully";
                 }else{
                     $obj->code    = 503;
                     $obj->message ="error";
                }
            }
        }
    }else{
        $obj->code    = 503;
        $obj->message = "Error2";
    }
echo json_encode($obj);
?>