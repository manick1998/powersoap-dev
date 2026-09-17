<?php
//session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/employee.php';
//include_once '../config/core.php';
$database = new Database();
$db = $database->getConnection();
$emp = new Employee($db);
$input_data = json_decode(file_get_contents("php://input"));
$obj = new stdClass;
$emp->division = $input_data->division_token;
if ($input_data->type == "all" || $input_data->type == "generel") {
   if ($input_data->type1 == "three") {
      $filters = "AND LOWER(REPLACE(employees__state.state_name, ' ', '')) != 'karaikal' AND employees__state.state_token ='$input_data->state' AND products__category.token  IN(" . implode(',', $input_data->division_token) . ") AND date(orders__items.date_time) BETWEEN '$input_data->fromDate' AND '$input_data->toDate'";
   } else {
      $filters = "AND LOWER(REPLACE(employees__state.state_name, ' ', '')) != 'karaikal'";
   }
   $stmt = $emp->overall_item_product_report($filters);
   $stmt3 = $emp->partculoar_division_product1();
   $division_data = $emp->partculoar_division_product1_read($stmt3);
   $check = $stmt->rowCount();

   $arrays = [];
   if ($stmt) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $all_item_obj = new stdClass();
         $all_item_obj->state_token = $row["state_token"];
         $all_item_obj->state_name = $row["state_name"];
         $all_item_obj->division_name = $row["division_name"];
         $all_item_obj->division_token = $row["division_token"];
         $all_item_obj->product_name = $row["product_name"];
         $all_item_obj->product_token = $row["product_token"];
         $all_item_obj->quantity = $row["quantity"];
         $all_item_obj->price_per_unit = $row["price_per_unit"];
         $all_item_obj->total_sales_amount = round($row["total_sales_amount"]);
         array_push($arrays, $all_item_obj);
      }
      $obj->status_code = 200;
      $obj->header = "Success";
      $obj->message = "Data listed";
      $obj->data = $arrays;
      $obj->product  = $division_data;
   } else {
      $obj->status_code = 400;
      $obj->header = "Error";
      $obj->message = "Something Error";
      $obj->data = [];
   }
}

echo json_encode($obj);
