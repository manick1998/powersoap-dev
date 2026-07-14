<?php
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/inventory.php';
$inventory = new Inventory($db);
$array = [];
$arrayExists = [];
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
//                            $inventory->productCode=addslashes($data[0]);
//                            $stmt=$inventory->addProductCheck();
//                            $checkCount = $stmt->rowCount();
                            $inventory->productTypeName    = addslashes($data[8]);
                            $inventory->productType        = $inventory->getProductTypeToken();
                            if($inventory->productType != '0' && $inventory->productType != ''){
                                $inventory->productCode=addslashes($data[0]);
                                $inventory->productTotalCost   = addslashes($data[6]);
                                $retailer_price = $inventory->productTotalCost*6/100;
                                $inventory->retailerPrice  = number_format($retailer_price+$inventory->productTotalCost, 2, '.', '');
                                $token                    = $inventory->tokenGenerate();
                                $inventory->token         = $token;
                                $inventory->productName   = addslashes($data[1]);
                                $inventory->productWeight = addslashes($data[2]);
                                $inventory->productMrp    = addslashes($data[3]);
                                $inventory->productGst    = isset($data[10]) ? addslashes($data[10]) : "";
                                $inventory->productBatchNumber = addslashes($data[4]);
                                $inventory->productLocation    = addslashes($data[5]);
                                $inventory->productDescription = addslashes($data[7]);
                                $inventory->productImage       = "";
                                $inventory->productPieceCount  = addslashes($data[9]);
                                $inventory->productAdditionalOffer  = isset($data[11]) ? addslashes($data[11]) : "";
                                $inventory->name_short = isset($data[12]) ? addslashes($data[12]) : "";
                                $inventory->hsn_code = isset($data[13]) ? addslashes($data[13]) : "";
                                $insert = $inventory->addProduct($indiaDateTime);
                                $dist_stock = $inventory->addDistributorStockInHand();
                            }else{
                                array_push($arrayExists,$inventory->productTypeName);
                            }  
                            array_push($array,$inventory->productCode);
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            if(count($array)==count($arrayExists)){
                $obj->code    = 503;
                if(count($arrayExists)==1){
                    $obj->message = implode(",",$arrayExists)." this Product Division are not matching. We can't upload this product";
                }else{
                    $obj->message = implode(",",$arrayExists)." these Product Divisions are not matching. We can't upload these products";
                }
            }else{
                $obj->code     = 201;
                if(count($arrayExists)==0){
                    $obj->message = "Csv data uploaded successfully!";
                }else{
                    if(count($arrayExists)==1){
                        $obj->message = implode(",",$arrayExists)." this Product Division are not matching. We can't upload this product. Except this one other products uploaded successfully!";
                    }else{
                        $obj->message = implode(",",$arrayExists)." these Product Divisions are not matching. We can't upload these products. Except these other products uploaded successfully!";
                    }
                }
            }
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