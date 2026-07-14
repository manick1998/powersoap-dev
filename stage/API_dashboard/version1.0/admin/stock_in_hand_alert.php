<?php 
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/inventory.php';

// Read raw POST data
$data = json_decode(file_get_contents("php://input"));

$database = new Database();
$db = $database->getConnection();
$inv = new Inventory($db);

$obj = new stdClass();
$obj->status_code = 404; // Default status if type doesn't match
$obj->header = "Error";
$obj->message = "Invalid Request Type";
$obj->data1 = [];

date_default_timezone_set('Asia/Kolkata');
$beforemin = date('Y-m-d H:i', strtotime('-30 minutes'));
$date = date('Y-m-d H:i', strtotime('now'));

// Check if $data and type exist before evaluating to prevent warnings
if (isset($data->type) && $data->type == "stock_in_hand_alert") {
    
    $stockData = $inv->stockalert(); 
    
    if ($stockData) {
        $obj->status_code = 200;
        $obj->header = "success";
        $obj->message = "success"; 
        
        // Loop through rows and add them directly to the data1 array
        while ($row = $stockData->fetch(PDO::FETCH_ASSOC)) {
            $item = new stdClass();
            $item->stock_in_hand = $row['stock_in_hand'];
            $item->stock_name = $row['name'];
            $obj->data1[] = $item; 
        }
    } else {
        $obj->status_code = 400;
        $obj->header = "Error";
        $obj->message = "Stock In Hand Not found"; 
        $obj->data1 = [];
    }
}

// Always echo valid JSON at the very end
echo json_encode($obj);
?>