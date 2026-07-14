<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
include_once '../objects/employee.php';
$admin = new Employee($db);
$admin->sales_rep_token=$inputData->sales_rep_token;
$stmt = $admin->todayTotalExpense();
$row  = $stmt->fetch(PDO::FETCH_ASSOC);
$amount = (int)$row["amount"];
$obj->amount = $amount;
echo json_encode($obj);
$db = null;


?>