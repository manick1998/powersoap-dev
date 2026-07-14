<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);

$input = json_decode(file_get_contents("php://input"));

$schedule->distributor_token = $input->distributor_token;

$fun_call = $schedule->customize_unit_list();

$count = $fun_call->rowCount();
// echo $count;
if ($count == 0) {
    echo "data not found";
}
else{
    $arr = [];
    $data =[];
    while($row = $fun_call->fetch(PDO::FETCH_ASSOC)){
        $obj1 = new stdClass();
        $obj = new stdClass();
        $obj->beat_name = $row['name'];
        $obj->beat_token = $row['token'];

        array_push($arr,$obj);
        
    }
    $obj->code = 201;
    // $obj->newdata = array_push($data,$arr);
    // array_push($data,$arr);
    // $obj1->obj=$arr;
    $obj=$arr;
    // $obj=$obj1;
}
echo json_encode($obj);

?>