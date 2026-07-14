<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include '../db_connection/db_conn.php';
include '../retailer_object/retailer_login.php';
$database = new Database();
$db = $database->getConnection();
$retailer =new retailer($db);
$input = json_decode(file_get_contents("php://input"));
$distributor_token = $input->distributorToken;
$retailer->distributor_token = $distributor_token;



$productList =$retailer->productList();
$prod_array = [];
while($row = $productList->fetch(PDO::FETCH_ASSOC)) {
    $prod_obj = new stdClass;
    $prod_obj->category_token = $row['category_token'];
    $prod_obj->category_name = utf8_encode($row['pro_cat']);
    $prod_obj->token = $row['token'];
    $prod_obj->name = utf8_encode($row['name']);
    $prod_obj->image = $row['image'];
    $prod_obj->item_code = $row['item_code'];
    $prod_obj->product_per_price = $row['retailer_price'];
    $prod_obj->product_gst = $row['gst'];
    $prod_obj->net_weight = $row['net_weight'];
     $prod_obj->piece_count = $row['piece_count'];
     $prod_obj->stock_in_hand = $row['stock_in_hand'];
     $prod_obj->additional_offer = $row['additional_offer'];
     $prod_obj->limit_box = (int)$row['limit_box'];
     $prod_obj->free_box = (int)$row['free_box'];
     if($row['is_scheme']==1){
        $is_scheme = true;

     }else{
        $is_scheme = false;

     }

     $prod_obj->is_scheme = $is_scheme;

    
    
    
    
    array_push($prod_array,$prod_obj);
}

$obj = new stdClass;

if(sizeof($prod_array)){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->ProductDetail=$prod_array;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
?>