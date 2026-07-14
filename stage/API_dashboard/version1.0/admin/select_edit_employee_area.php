<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';

$database = new Database();
$db = $database->getConnection();

$emp = new Employee($db);

$data = json_decode(file_get_contents("php://input"));

$emp->region_token = $data->region_token;
$emp->employeeToken = $data->employeeToken;

$fun = $emp->select_edit_employee_area();

$num =$fun->rowCount();

//echo $num;

//$obj = new stdClass();

if ($num == 0) {
    // $obj->status_code = 400;
    // $obj->message ="data not found";
        echo "data not found";
}
else{
    $arr= [];
    while($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
        $obj = new stdClass();
        $obj->one_area = $rows['one_area'];
        $obj->employee_area = $rows['area_name'];
        //$obj->area_token = $rows[''];
        $obj->region_id = $rows['region_id'];
        array_push($arr,$obj);
    }
    $obj->status=true;
    $obj->message="success";
    $obj->code=200;
    $obj=$arr;
}
echo json_encode($obj);

?>