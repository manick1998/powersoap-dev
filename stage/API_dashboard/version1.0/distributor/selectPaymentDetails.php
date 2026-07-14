<?php
$obj1=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee_distributor.php';
$employee = new Employee($db);
$employee->distributor_token=$inputData->distributor_token;
$stmt = $employee->selectPaymentDetails();
if($stmt){
    $arr = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $obj = new StdClass();
        $obj->bank_name = $row["bank_name"];
        $obj->account_number = $row["account_number"];
        $obj->bank_code=$row["bank_code"];
        $obj->holder_name=$row["holder_name"];
        $obj->gpay=$row["gpay"];
        $obj->paytm=$row["paytm"];
        array_push($arr,$obj);
    }
     $obj1->code = 201;
     $obj1->title = "success";
     $obj1->message = "data listed";
     $obj1 = $arr;
}else{
    $obj1->code = 400;
    $obj1->title = "error";
    $obj1->message = "data not found";

}
echo json_encode($obj1);

?>