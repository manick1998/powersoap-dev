<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
if($inputData->dashboard_code == $verification_code){
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
   if($inputData->type=="single_scheme"){
        $inventory->product_token  = $inputData->product_token;
        $inventory->free_token  = $inputData->free_token;
        $inventory->token  = $inputData->token;
        $stmt=$inventory->singleSchemeCheck($indiaDate);
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $inventory->readsingleSchemeCheck($stmt);
        }
    }else if($inputData->type=="update_scheme"){
        $inventory->token  = $inputData->token;
        $inventory->product_token  = $inputData->product_token;
        $inventory->free_token  = $inputData->free_token;
        $inventory->scheme_name  = $inputData->scheme_name;
        $inventory->buy_product_box  = $inputData->buy_product_box;
        $inventory->get_product_box  = $inputData->get_product_box;
        $inventory->fromStatDateScheme  = $inputData->fromStatDateScheme;
        $inventory->toEndDateScheme  = $inputData->toEndDateScheme;
        $stmt=$inventory->updateScheme($indiaDate);
        if($stmt){
            $obj->code = 201;
            $obj->message = 'Updated Successfully';
        }else{
            $obj->code=503;
            $obj->message='Error';
        }
      }else if($inputData->type=="single_scheme_delete"){
        $inventory->product_token  = $inputData->product_token;
        $inventory->token  = $inputData->token;
        $token = $inputData->token;
        $inventory->free_token  = $inputData->free_token;
        $stmt=$inventory->schemeCheck($token);
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $inventory->deleteScheme($indiaDate);
        }
    }
    echo json_encode($obj);
}
?>