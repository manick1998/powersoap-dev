<?php

$obj = new StdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);

$token = $inputData->token;
$admin->token = $token;

$stmt = $admin->listmodule();
$count = $stmt->rowCount();

if($token !=""){
    if($count > 0){
        $arr=[];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $obj1 = new StdClass();
            $obj1->module_name = $row["module_name"];
            $obj1->image = $row["image"];
            $obj1->file_name = $row["file_name"];
            array_push($arr,$obj1);
        }
        
        $obj->status_code = 200;
        $obj->title = "success";
        $obj->message = "data listed";
        $obj = $arr;
    }else{
        $obj->status_code = 400;
        $obj->title = "Error";
        $obj->message = "data not found";
    }
}else{
    $obj->status_code = 400;
    $obj->title = "Eroor";
    $obj->message = "All fields are mandatroy";
}
echo json_encode($obj);
$db = null;


?>