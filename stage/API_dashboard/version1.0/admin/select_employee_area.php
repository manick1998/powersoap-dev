
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
$obj = new stdClass();
$emp->region_token = $data->region_token;

$stmt = $emp->select_employee_area();
if ($data->type = "area") {
   if ($stmt->rowCount()>0) {
      $data1=$emp->select_employee_area_read($stmt);
      $obj->code=200;
      $obj->message="success";
      $obj->area_data = $data1;
   }else {
      $obj->code=400;
      $obj->message="Data node found";
      $obj->area_data =[];
   }
   
}


//echo $num;

//$obj = new stdClass();

// if ($num == 0) {
//     // $obj->status_code = 400;
//     // $obj->message ="data not found";
//     $obj->message="data not found";
//     $obj->code = 400;
// }
// else{
//     $arr= [];
//     while($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
       
//         $obj->area_name = $rows['area_name'];
//         $obj->area_token = $rows['area_token'];
//         array_push($arr,$obj);
//     }
//     $obj->status=true;
//     $obj->message="success";
//     $obj->code=200;
//     $obj=$arr;
// }
echo json_encode($obj);

?>