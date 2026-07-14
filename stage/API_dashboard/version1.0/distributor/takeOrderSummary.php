<?php
// required headers
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$inputData = json_decode(file_get_contents("php://input"));
include_once '../config/core_distributor.php';
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$distributor_token = $inputData->distributor_token;
    $array = $inputData->order_array;
    $productsArray = [];
    $details=[];
    $total=[];
    foreach($array as $value){
        array_push($productsArray, $value->product_token);
    }
    $productQuery = implode(",",$productsArray);
    $query = mysqli_query($link, "SELECT 
    `products__category`.`name` AS `division_name`,
    GROUP_CONCAT(	CONCAT(
        `products`.`name`,'&&&&',
        `products`.`token`,'&&&&',
        `products`.`retailer_price`,'&&&&',
        `products`.`piece_count`,'&&&&',
        `products`.`item_code`,'&&&&'
    ),	'****') AS `product_details`
    FROM `products__category`
    INNER JOIN `products` ON `products__category`.`token`=`products`.`category_token`
    WHERE `products`.`token` IN ($productQuery)
    GROUP BY `products`.`token`");
   while($row = mysqli_fetch_array($query)){
        $product_string  = rtrim($row["product_details"],'****');
        $product_details = explode("****,",$product_string);
        foreach($product_details as $productData){
            $prod_data = explode("&&&&",$productData);
            foreach($array as $value){
                if($value->product_token==$prod_data[1]){
                    $quantity  = $value->quantity;
                }
            }
            foreach($array as $value){
                if($value->product_token==$prod_data[1]){
                    $name  = $value->name;
                }
            }
            foreach($array as $value){
                if($value->product_token==$prod_data[1]){
                    $units  = $value->toggle;
                }
        }
        if($units=="Box"){
        $amount             =($quantity*$prod_data[2]*$prod_data[3]);
        $box_price     =($quantity*$prod_data[2]*$prod_data[3]);
        }else{
        $amount             =($quantity*$prod_data[2]);
        $box_price        = ($quantity*$prod_data[2]);
        }
        $obj = new stdClass();
            $obj->product_name      = $name;
            $obj->product_token  =$prod_data[1];
            $obj->product_total_cost= $prod_data[2];
            $obj->piece_count       = $prod_data[3];
            $obj->box_price         =number_format($box_price, 2, '.', '');
            if($units=="Box"){
            $obj->quantity          = $quantity."Box";
            }else{
                $obj->quantity          = $quantity."Nos";
            }
            $obj->amount            = number_format($amount, 2, '.', '');
            array_push($details,$obj);
            array_push($total,$obj->amount);
        }
    }
$obj2 = new stdClass();
if($distributor_token){
$obj2->status_code="200";
$obj2->header = "Success";
$obj2->final=number_format(array_sum($total), 2, '.', '');
$obj2->data =$details;
}else{
    $obj2->header="error";
    $obj2->data="error";
}
echo json_encode($obj2);  
?>
