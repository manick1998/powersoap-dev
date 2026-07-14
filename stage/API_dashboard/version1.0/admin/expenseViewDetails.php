<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
$database = new Database();
$db = $database->getConnection();
$obj = new stdClass;
$array = [];
$token = $input_data->token;
$date = $input_data->date;
$result = mysqli_query($link,"SELECT
employees.name,
GROUP_CONCAT(
    allowance.allowane_type
) AS category,
GROUP_CONCAT(
    sales_rep__expense__details.amount
) AS amount,
GROUP_CONCAT(sales_rep__expense__details.image)as image
FROM
`sales_rep__expense__details`
INNER JOIN employees ON sales_rep__expense__details.sales_rep__token = employees.token
INNER JOIN allowance ON sales_rep__expense__details.category_token = allowance.token
WHERE
sales_rep__expense__details.status = '1' AND sales_rep__expense__details.sales_rep__token = '$token'  AND date(sales_rep__expense__details.date_time) = '$date'
");
while($row = mysqli_fetch_array($result)){
    $obj1 = new stdclass;
    $obj1->name=$row["name"];
    $obj1->category_module = $row["category"];
    $obj1->amount = $row["amount"];
    $images = explode(",",$row["image"]);
    $obj1->image = $images;
}
if($obj1){
$obj = new stdClass();
$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "List Successfully";
$obj->data=$obj1;
}else{
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Error"; 
}

echo json_encode($obj);  


?>