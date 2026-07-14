<?php
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer.php';
$retailer = new Retailer($db);
//$retailer_array = [];
$row = 1;
$obj=new stdClass();
if(is_array($_FILES)) {
    if(is_uploaded_file($_FILES['file_upload']['tmp_name'])) {
        $sourcePath = $_FILES['file_upload']['tmp_name'];
        if (($handle = fopen($sourcePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",",'"')) !== FALSE) {
                $num = count($data);
                for ($c=0; $c < $num; $c++) {
                    if($c==0){
                        if($row>1){
                            $token                    = $retailer->tokenGenerate();
                            $retailer->token          = $token;
                            $retailCode               = $retailer->codeGenerate();
                            $retailer->retailCode     = $retailCode;
                            $retailer->shopName       = addslashes($data[0]);
                            $retailer->contactPerson  = addslashes($data[1]);
                            $retailer->contactNumber  = addslashes($data[2]);
                            $retailer->shopTypeName   = addslashes($data[3]);
                            $retailer->shopType       = $retailer->getShopTypeToken();
                            $retailer->licenseNumber  = addslashes($data[4]);
                            $retailer->shopAddress    = addslashes($data[5]);
                            $retailer->shopCity       = addslashes($data[6]);
                            $retailer->shopPincode    = addslashes($data[7]);
                            $retailer->shopCoordinates= addslashes($data[8]);
                            $retailer->retailerImage  = '';
                            $insert = $retailer->addRetailer($indiaDateTime);
//                            array_push($retailer_array,$retailer);
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            $obj->code    = 201;
            $obj->message = "Success";//$retailer_array;//
        }
    }else{
        $obj->code    = 503;
        $obj->message = "Error2";
    }
}else{
    $obj->code    = 503;
    $obj->message = "Error";
}
echo json_encode($obj);
?>