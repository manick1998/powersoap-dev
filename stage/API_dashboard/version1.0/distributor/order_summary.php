<?php
// required headers
include_once '../config/core_distributor.php';
$input_data = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
$input_data = json_decode(file_get_contents("php://input"));
//$distributor_token = $input_data->distributor_token;
    $array = $input_data->order_array;
    $productsArray = [];
    foreach($array as $value){
        array_push($productsArray, $value->product_token);
    }
    $productQuery = implode(",",$productsArray);
    $result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
    `products__category`.`name` AS `division_name`,
    GROUP_CONCAT(	CONCAT(
        `products`.`name`,'&&&&',
        `products`.`token`,'&&&&',
        `products`.`mrp`,'&&&&',
        `products`.`total_cost`,'&&&&',
        `products`.`piece_count`,'&&&&',
        `products`.`item_code`,'&&&&',
        `products`.`batch_number`
    ),	'****') AS `product_details`
    FROM `products__category`
    INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
    WHERE `products`.`token` IN ( $productQuery )
    GROUP BY `products`.`token`");
    $details      = [];
    $total=[];
    while($row = mysqli_fetch_array($result)){
        $division_token  = $row['division_token'];
        $product_string  = rtrim($row["product_details"],'****');
        $product_details = explode("****,",$product_string);
        $total_amount = 0;
        foreach($product_details as $productData){
            $prod_data = explode("&&&&",$productData);
            foreach($array as $value){
                if($value->product_token==$prod_data[1]){
                    $quantity  = $value->quantity;
                }
            }
            $amount        = $quantity*$prod_data[3]*$prod_data[4];
            $box_price     =$prod_data[3]*$prod_data[4];
            //$final=$amount+$amount;
            $obj2 = new stdClass();
            $obj2->product_name      = $prod_data[0];
            $obj2->product_total_cost= $prod_data[3];
            $obj2->piece_count       = $prod_data[4];
            $obj2->box_price         =number_format($box_price, 2, '.', '');
            $obj2->quantity          = $quantity;
            $obj2->amount            = number_format($amount, 2, '.', '');
            array_push($details, $obj2);
            array_push($total,$obj2->amount );
        }
        //echo json_encode($total);
    }
$obj = new stdClass();
if($obj->status_code = "200"){
$obj->header = "Success";
$obj->final=number_format(array_sum($total), 2, '.', '');
$obj->data = $details;
}else{
    $obj->header="error";
    $obj->data="error";
}
echo json_encode($obj);  
?>
