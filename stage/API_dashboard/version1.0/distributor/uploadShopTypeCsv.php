<?php
session_start();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/retailer_distributor.php';
$distributor_token = $_SESSION['distributor_token'];
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
                            $token = token_generate("shop__type","token");
                            $retailer->token = $token;
                            $retailer->name = addslashes($data[0]);
                            $insert = $retailer->addShopType($indiaDateTime);
                            //array_push($retailer_array,$retailer);
                        }
                    }
                }
                $row++;
            }
            fclose($handle);
            $obj->code    = 201;
            $obj->message = "success";
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