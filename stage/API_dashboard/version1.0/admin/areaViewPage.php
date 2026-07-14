<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$admin = new Employee($db);
$admin->region_token=$inputData->region_token;
$admin->state_token=$inputData->state_token;
$stmt = $admin->areaOverAll();
if($stmt){
    $arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $obj1 = new StdClass();
        $obj1->area_token = $row["area_token"];
        $obj1->area_name = $row["area_name"];
        $obj1->region_name=$row["region_name"];
        array_push($arr,$obj1);
    }
     $obj->code = 201;
     $obj->title = "success";
     $obj->message = "data listed";
     $obj = $arr;
}else{
    $obj->code = 400;
    $obj->title = "error";
    $obj->message = "data not found";

}
echo json_encode($obj);
$db = null;


?>