<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/adminLogin.php';
$admin = new Admin($db);
//$admin->admin_state_id = $inputData->admin_state_id;

$stmt = $admin->selectState();
$count = $stmt->rowCount();

if($count > 0){
    $arr = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        $obj1 = new StdClass();
        $obj1->state_token = $row["state_token"];
        $obj1->state_name = $row["state_name"];

        array_push($arr,$obj1);
    }
     $obj->status_code = 200;
     $obj->title = "success";
     $obj->message = "data listed";
     
     $obj = $arr;
}else{
    $obj->status_code = 400;
    $obj->title = "error";
    $obj->message = "data not found";

}
echo json_encode($obj);

?>