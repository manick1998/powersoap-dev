<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
//if($inputData->dashboard_code == $verification_code){
    include_once '../objects/inventory.php';
    $inventory = new Inventory($db);
    if($inputData->type=="all"){
        $stmt=$inventory->divisionCheckAll();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $inventory->readDivisionAll($stmt);
        }
     }else  if($inputData->type=="productall"){
            $stmt=$inventory->productCheckAll();
            $checkCount = $stmt->rowCount();
            if($checkCount==0){
                $obj->code=503;
                $obj->data=[];
            }else{
                $obj->code = 201;
                $obj->data = $inventory->readProductAll($stmt);
            }
     } else if($inputData->type == 'divisionToken'){
                if($inputData->divisionToken == 'all'){
                    $stmt = $inventory->productCheckAll();
                    $division = $inventory->readProductAll($stmt);
                }else{
                    $inventory->divisionToken = $inputData->divisionToken;
                    $stmt = $inventory->selectDivision();
                    $division = $inventory->fetchDivision($stmt);
                }
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->data = $division; 
    }else if($inputData->type=="single_division"){
        $inventory->divisionToken  = $inputData->division_token;
        $stmt=$inventory->singleDivisionCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==0){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $inventory->readDivisionAll($stmt);
        }
    }else if($inputData->type=="single_division_delete"){
        $inventory->divisionToken  = $inputData->division_token;
        $inventory->admin_token = $inputData->admin_token;
        $stmt1 = $inventory->divisionNameDel();
        $inventory->division = $stmt1;
        $stmt=$inventory->divisionAssignCheck();
        $checkCount = $stmt->rowCount();
        if($checkCount==1){
            $obj->code=503;
            $obj->data=[];
        }else{
            $obj->code = 201;
            $obj->data = $inventory->deleteDivision();
           $inventory->deleteDivisionLog($indiaDateTime);
        }
    }else if($inputData->type=="count_check"){
        $stmt=$inventory->divisionCheck();
        $obj->Count = $stmt->rowCount();
    }
    else  if($inputData->type=="products"){
        //$division_token = $inventory->division_token;
        $division_token = $inputData->division_token;
        $stmt1 = $inventory->division_products($division_token);
        if ($checkCount = $stmt1->rowCount()>0) {
            $stmt2 = $inventory->division_products_read($stmt1);
            $obj->code = 201;
            $obj->data = $stmt2;
        }
        else {
            $obj->code = 401;
            $obj->data = [];
        }
    }
    echo json_encode($obj);
?>