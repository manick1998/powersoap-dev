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

$input = json_decode(file_get_contents('php://input'));
$emp->areas_token = $input->areas_token;
// $datas = $input->areas_token;
// foreach ($datas as $key) {
//          //echo $key;
// }

$fun = $emp->area_distributors();
$num = $fun->rowCount();
//echo "count", $num;

if ($num == 0) {
        // $obj->status_code = 400;
        // $obj->message ="data not found";
            echo "data not found";
    }
    else{
        $arr= [];
        while($rows = $fun->fetch(PDO::FETCH_ASSOC)) {
            $obj = new stdClass();
            $obj->name = $rows['name'];
                // echo "name",$obj->name = $rows['name'];
            $obj->token = $rows['token'];
                // echo  "token", $obj->token = $rows['token'];
            array_push($arr,$obj);
        }
        $obj->status=true;
        $obj->message="success";
        $obj->code=200;
        $obj=$arr;
    }
    //echo $obj;
 echo json_encode($obj);


?>