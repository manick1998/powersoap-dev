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
$freeproduct_array = [];
$distributor_token = $input_data->distributor_token;
$token = $input_data->token;

//get shop mapping uniq token 
$get_shop_uniq_token = mysqli_query($link, "SELECT *  FROM `shop_mapping` WHERE `shop_token` = '$token' AND distributor_token = '$distributor_token'");
$shop_uniq_token  = mysqli_fetch_array($get_shop_uniq_token);
$shop_uniq_token1 = $shop_uniq_token['token'];
// echo $shop_uniq_token1;

$order_array = $input_data->order_array;
$get_distributor_token = mysqli_query($link, "SELECT deparment_token FROM `employees` WHERE `token`= '$distributor_token'");
$distribut_row  = mysqli_fetch_array($get_distributor_token);
$deparment_token = $distribut_row['deparment_token'];
$currnetDateTime =  date("Y-m-d H:i:s");
$order_type = "Sales Order";
$order_id  = token_generate('orders', 'token');
//echo $order_id;
function token_generate_order($table_name, $column_name)
{
    $random = rand(10000000, 99999999);
    $val = true;
    do {
        $result = mysqli_query($GLOBALS['link'], "SELECT `$column_name` FROM `$table_name` WHERE `$column_name`='$random'");
        $count = mysqli_num_rows($result);
        if ($count == 0) {
            $val = false;
        } else {
            $random = rand(10000000, 99999999);
        }
    } while ($val);
    return 'ORD-R' . $random;
}
$order_number = token_generate_order("orders", "order_number");
$productsArray = [];
foreach ($order_array as $value) {
    array_push($productsArray, $value->product_token);
}
$productQuery = implode(",", $productsArray);
//echo $productQuery;
$result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
`products__category`.`name` AS `division_name`,
GROUP_CONCAT(	CONCAT(
    `products`.`name`,'&&&&',
    `products`.`token`,'&&&&',
    `products`.`mrp`,'&&&&',
    `products`.`retailer_price`,'&&&&',
    `products`.`piece_count`,'&&&&',
    `products`.`item_code`,'&&&&',
    `products`.`free_box`,'&&&&',
    `products`.`is_scheme`,'&&&&',
    `products`.`batch_number`,'&&&&',
    `products`.`gst`
),	'****') AS `product_details`
FROM `products__category`
INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
WHERE `products`.`token` IN ( $productQuery )
GROUP BY `products`.`token`");
$gst_total_amount = 0;
$basicRate_total = 0;
$total_final_amount = 0;
$total = 0;
$slno = 0;
while ($row = mysqli_fetch_array($result)) {
    $division_token  = $row['division_token'];
    $product_string  = rtrim($row["product_details"], '****');
    $product_details = explode("****,", $product_string);
    //echo json_encode($product_details);
    $details      = [];
    $total_amount = 0;
    foreach ($product_details as $productData) {
        $prod_data = explode("&&&&", $productData);
        foreach ($order_array as $value) {
            if ($value->product_token == $prod_data[1]) {
                $quantity  = $value->quantity;
            }
        }
        foreach ($order_array as $value) {
            if ($value->product_token == $prod_data[1]) {
                $discount_percent  = $value->discount;
            }
        }
        foreach ($order_array as $value) {
            if ($value->product_token == $prod_data[1]) {
                $units  = $value->toggle;
            }
        }

        $finalArray   = [];
        if ($units == "Box") {
            //$totalamount        = $quantity*$prod_data[3]*$prod_data[4]*0.06;
            $amount             = ($quantity * $prod_data[3] * $prod_data[4]);
        } else {
            //$totalmar  =$quantity*$prod_data[3]*0.06;
            $amount             = ($quantity * $prod_data[3]);
        }
        //$total_amount += $amount;
        $obj2 = new stdClass();
        $obj2->product_name      = $prod_data[0];
        $obj2->product_token     = $prod_data[1];
        $obj2->product_mrp       = $prod_data[2];
        $obj2->product_total_cost = $prod_data[3];
        $obj2->piece_count       = $prod_data[4];
        $obj2->item_code         = $prod_data[5];
        $obj2->free_box           = $prod_data[6];
        $obj2->scheme             = $prod_data[7];
        $obj2->batch_number      = $prod_data[8];
        $obj2->gst               = $prod_data[9];
        $obj2->quantity          = $quantity;
        $obj2->discount_percent  = $discount_percent;
        $obj2->discount_amount   = 0;
        $obj2->amount            = number_format($amount, 2, '.', '');
        $obj2->final_amount      = number_format($amount, 2, '.', '');
        $obj2->units             = $units;
        array_push($details, $obj2);
    }
    //echo json_encode($details);

    $order_insert = mysqli_query($link, "INSERT INTO `orders`(`token`, `order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`,`distributor_token`, `delivery`) VALUES ('$order_id','$order_number','$currnetDateTime','$order_type','$shop_uniq_token1','$distributor_token','$distributor_token','Pending')");
    if ($order_insert) {
        $emp_daily_summary = mysqli_query($link, "INSERT INTO `employees__daily_summary`( `date_time`, `department_token`, `employees_token`, `location_token`, `order_value`, `collection`, `productivity`, `outlets_covered`) VALUES ('$currnetDateTime','$deparment_token','$distributor_token','0','0','0','0','0')");
    }
    foreach ($details as $value) {
        $product_discount_amount = number_format($value->amount * $discount_percent / 100, 2, '.', '');
        $product_final_amount    = number_format($value->amount - $product_discount_amount, 2, '.', '');
        $value->discount_amount  = number_format($product_discount_amount, 2, '.', '');
        $value->final_amount     = number_format($product_final_amount, 2, '.', '');
        $discount_enable         = $value->discount_percent > 0 ? 1 : 0;
        $total += $product_final_amount;


        $gst_multiplier = 1 + ($value->gst / 100);
        $gst_amount = number_format($product_final_amount / $gst_multiplier * $value->gst / 100, 2, '.', '');
        $gst_total_amount += number_format($gst_amount, 2, '.', '');
        $basicRate_total += number_format($product_final_amount / $gst_multiplier, 2, '.', '');
        $basicRate = number_format($product_final_amount / $gst_multiplier, 2, '.', '');
        $slno++;
        $free_box_val = 0;
        $orderproduct_array[] = "('$order_id','$value->product_token','$value->product_total_cost','$value->piece_count','$gst_amount','$value->quantity','0','0','0','$value->final_amount ','$value->units','0','$discount_enable','$value->discount_percent','0','0','$value->gst','$currnetDateTime')";
        $is_offer_product = mysqli_query($link, "SELECT `product_token`, `scheme_name`, `limit_box`, `free_box`, `start_date`, `end_date`, `is_scheme` FROM `products__scheme` WHERE `product_token`='$value->product_token' AND `is_scheme`='1' ORDER BY `limit_box` DESC LIMIT 0,1");
        if (mysqli_num_rows($is_offer_product) > 0) {
            $row1 = mysqli_fetch_array($is_offer_product);
            if ($row1["limit_box"] <= $value->quantity) {
                $free_box_val = (int)($value->quantity / $row1["limit_box"]);
                if ($free_box_val >= 1) {
                    $free_box_val1 = $value->quantity / $row1["limit_box"];
                    $freeProduct_count = $free_box_val1 * $row1["free_box"];
                    $freeProduct = (int)$freeProduct_count;
                    $orderproduct_array[] = "('$order_id','$value->product_token','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','$units','1','0','0','0','0','$value->gst','$currnetDateTime')";
                }
            }
        }
        if ($discount_percent != 0) {
            $discount_total = $product_discount_amount;
            $discount_percentTotal = $discount_percent;
            $update_discount = mysqli_query($link, "UPDATE `orders` SET `bill_discount_amount`='$discount_total',`bill_discount_percentage`='$discount_percentTotal' WHERE `token`='$order_id'");
        }
        $items = $slno;
    }
}
$select_dist_stock = mysqli_query($link, "SELECT `stock_in_hand`,`sold_pieces` FROM `stock__distributor` WHERE `product_token`='$value->product_token' AND`employee_token`= '$distributor_token'");
$selectrow_dist = mysqli_fetch_array($select_dist_stock);
$old_stock_count = $selectrow_dist['stock_in_hand'];
$sold_old_pices = $selectrow_dist['sold_pieces'];
// $newcount_stock = $old_stock_count - $order_qty;
if ($units == 'Box') {
    $disrtributor_product_count = $quantity;
    $newcount_stock = $old_stock_count - $disrtributor_product_count;
    $stockUpdate = mysqli_query($link, "UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$value->product_token' AND `employee_token`='$distributor_token'");
} else {
    $disrtributor_product_count = $quantity;
    $new_sold_pieces = $sold_old_pices + $disrtributor_product_count;
    $new_box =  $old_stock_count - floor($new_sold_pieces / $value->piece_count);
    $balanace_pieces = $new_sold_pieces % $value->piece_count;
    $stockUpdate = mysqli_query($link, "UPDATE `stock__distributor` SET `stock_in_hand` = '$new_box', `sold_pieces`='$balanace_pieces' WHERE `product_token`='$value->product_token' AND `employee_token`='$distributor_token'");
}
$order_free_product = mysqli_query($link, "INSERT INTO `orders__items`(`order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `return_qty`, `offer_token`, `offer_percentage`, `offer_amount`, `units`, `is_free`, `is_discount_enable`,`discount_value`, `product_dis_price`, `product_price`, `gst_percent`, `date_time`) VALUES" . implode(", ", $orderproduct_array));
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "invoice_" . $order_id . $stort_time . ".pdf";
$update_order = mysqli_query($link, "UPDATE `orders` SET `items`='$items',`billing_amount`='$total',`outstanding_amount`='$total',`gst`='$gst_total_amount',`invoice_name`='$fileName' WHERE `token`='$order_id'");
$outstanding_value = mysqli_query($link, "SELECT `shop`.`name`, 
`orders`.`shop_token`, 
SUM(`orders`.`billing_amount`) AS `billing_amount`, 
SUM(`orders`.`paid_amount`) AS `paid_amount`
FROM `orders` 
INNER JOIN `shop` ON `orders`.`shop_token` = `shop`.`token`
WHERE `orders`.`delivery`!='Cancelled' AND `orders`.`token`= '$order_id'");
while ($row = mysqli_fetch_array($outstanding_value)) {
    $billing_amount = $row['billing_amount'];
    $paid_amount = $row['paid_amount'];
    $outstanding = $row['billing_amount'] - $row['paid_amount'];
}

if ($order_free_product && $update_order) {
    $obj = new stdClass();
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Order Created Successfully";
    $obj->item = $items;
    $obj->total = $total;
    $obj->order_id = $order_id;
    $obj->invoice_name = $fileName;
    $obj->outstanding_amount = $outstanding;
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Error";
}

echo json_encode($obj);
