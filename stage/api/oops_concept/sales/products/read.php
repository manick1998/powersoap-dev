<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


ini_set('display_errors', 1);// show error reporting
 error_reporting(E_ALL);



// include "../../config.php";
include_once '../config/database.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$product = new Products($db);

// set ID property of record to read
$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of product to be edited
$product->read_product();

if($product->token!=null){
    // create array
    $product_arr = array(
        "token" =>  $product->token,
        "category_token" => $product->category_token,
        "piece_count" => $product->piece_count,
        "item_code" => $product->item_code,
        "name" => $product->name,
        "total_cost" => $product->total_cost,
        "gst" => $product->gst,
        "batch_number" => $product->batch_number,
        "net_weight" => $product->net_weight,
        "retailer_price" => $product->retailer_price,
        "pro_cat" => $product->pro_cat,
        "stock_in_hand" => $product->stock_in_hand
  
    );
 // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($product_arr);
}
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Product does not exist."));
}






?>