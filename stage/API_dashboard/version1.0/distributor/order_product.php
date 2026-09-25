<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$freeproduct_array = [];
$orderproduct_array = [];
$indiaDate = date("Y-m-d");
$distributor_token = $input_data->distributor_token;

$state_id_res = mysqli_query($link, "SELECT state_id from employees WHERE token='$distributor_token'");
$row22 = mysqli_fetch_assoc($state_id_res);
$state = $row22 ? $row22['state_id'] : '';
// print_r($link);
// exit;
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
    return 'ORD-D' . $random;
}

$order_id = token_generate("orders", "token");
$order_number = token_generate_order("orders", "order_number");

$address_query = mysqli_query($link, "SELECT CONCAT(`name`,', ', `address`,', ', `street`,', ', `city`,', ', `pincode`) AS `address`, `mobile_number`, `license_number` FROM `employees` WHERE `deparment_token`='18028120' AND `token` = '$distributor_token'");
$row21 = mysqli_fetch_assoc($address_query);
$dist_address = $row21 ? $row21["address"] : '';
$dist_mobile_number = $row21 ? $row21["mobile_number"] : '';
$license_number = $row21 ? $row21["license_number"] : '';

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
<table border="0" style="table-layout:fixed;width: 580px;height:auto;margin: 0 auto;font-family: sans-serif;">
<tr>
    <td>
    <table style="table-layout:fixed;width: 100%;height:0;margin:0;padding:0;">
        <tr cellpadding="0" cellspacing="0" style="margin:0;padding:0;">
            <td style="display: block;width: 50%;text-align: left;margin:0;padding:0;">
            <table style="width: 100%;">
            <tr>
                <td><img src="https://powersoaps.online/stage/admin_dashboard/assets/logo.png" alt="logo" style="width: 150px;object-fit: contain;"></td>
            </tr>
            <tr>
                <td style="display: block;width: 100%;text-align: left;min-width: 200px;font-size: 10px;line-height: 22px;margin:0;padding:0;"><span style="font-size: 12px;">Abirami Soap Works</span><br/>R.S.No 94/1, Embalam main Road, Sembiapalayam Village, Korkadu Post, Puthucherry-627000 <span style="display: block;">Ph : 984231765</span> </td>
            </tr>
            </table>
            </td>
            <td style="display: block;width: 50%;text-align: right;">
            <br/><br/><br/>
            <table style="width: 100%;">
            <tr>
                <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="width: 100px;display: inline-block;">Estimate No </b>: <span>' . $order_id . '</span><br/><b style="width: 100px;display: inline-block;" >Estimate Date </b>: <span>' . $indiaDateFormat . '</span></td>
            </tr>
            </table>
            </td>
        </tr>
        <tr cellpadding="0" cellspacing="0" style="margin:0;padding:0;">
            <td style="display: block;width: 50%;text-align: left;">
            <table style="width: 100%;">
            <tr>
                <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">BILL TO</b><br/>' . $dist_address . '<span style="display: block;"><br>Ph :' . $dist_mobile_number . '</span><br/><b style="width: 100px;">GST IN </b>: <span>' . $license_number . '</span></td>
            </tr>
            </table>
            </td>
            <td style="display: block;width: 50%;text-align: right;">
            <table style="width: 100%;">
            <tr>
                <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">SHIP TO</b><br/>' . $dist_address . '</td>
            </tr>
            </table>
            </td>
        </tr>  
    </table>

    <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 10px;line-height: 22px;font-family: sans-serif;">
        <thead style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
        <tr>
            <th style="border: 1px solid #ccc;padding: 8px 10px;width:40px;text-align:center;"><b>S.No</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;width:200px;text-align:center;"><b>Item Name</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>HSN Code</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>Qty / UOM</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Basic Rate</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>Discount</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>GST Amount</b></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Amt</b></th>
        </tr>
    </thead>
    <tbody>';

$array = $input_data->order_array;

$productsArray = [];
foreach ($array as $value) {
    // echo $value->product_token.'-';
    if (!empty($value->product_token)) {
        // array_push($productsArray, "'" . mysqli_real_escape_string($link, $value->product_token) . "'");
        array_push($productsArray,$value->product_token);
    }
}

if (empty($productsArray)) {
    echo json_encode(["status_code" => 400, "message" => "No products selected"]);
    // exit();
}

$productQuery = implode(",", $productsArray);
$finalArray = [];

// $result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
//     `products__category`.`name` AS `division_name`,
//     GROUP_CONCAT( CONCAT(
//         `products`.`name`,'&&&&',
//         `products`.`token`,'&&&&',
//         `products`.`mrp`,'&&&&',
//         `products`.`total_cost`,'&&&&',
//         `products`.`piece_count`,'&&&&',
//         `products`.`item_code`,'&&&&',
//         `products`.`batch_number`,'&&&&',
//         `products`.`gst`
//     ), '****') AS `product_details`
//     FROM `products__category`
//     INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
//     WHERE `products`.`token` IN ($productQuery)
//      GROUP BY `products__category`.`token`");

$result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
    `products__category`.`name` AS `division_name`,
    GROUP_CONCAT( CONCAT(
        `products`.`name`,'&&&&',
        `products`.`token`,'&&&&',
        `products`.`mrp`,'&&&&',
        `products`.`total_cost`,'&&&&',
        `products`.`piece_count`,'&&&&',
        `products`.`item_code`,'&&&&',
        `products`.`batch_number`,'&&&&',
        `products`.`gst`
    ), '****') AS `product_details`
    FROM `products__category`
    INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
    WHERE `products`.`token` IN ($productQuery)
     GROUP BY `products__category`.`token`");
$gst_total_amount = 0;
$basicRate_total = 0;
$total_final_amount = 0;
$slno = 0;
$item_count_total = 0;
$total_amount_check = 0;
$order_insert = mysqli_query($link, "INSERT INTO `orders`(`token`, `order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`, `delivery`) VALUES ('$order_id','$order_number','$indiaDateTime','Distributor Order','0','$distributor_token','Pending')");
// $div_arr = [];
while ($row = mysqli_fetch_array($result)) {
    $division_token = $row['division_token'];
    // array_push($div_arr,$division_token);
    // echo $division_token.'-';
    $product_string = rtrim($row["product_details"], '****');
    // echo '$product_string - '.$product_string;
    $product_details = explode("****,", $product_string);
    // echo '$product_details - '.$product_details;
   $details = [];
    $total_amount = 0;

    foreach ($product_details as $productData) {
        $prod_data = explode("&&&&", $productData);
        
        $pToken = $prod_data[1];
        // echo 'prod_data - '.$prod_data;
        $quantity1 = 0;

        foreach ($array as $value) {
            if ($value->product_token == $pToken) {
                $quantity1 = (float)$value->quantity;
                //  echo($quantity1.'-');
                break;
            }
        }
        if ($quantity1 <= 0) continue;
        $cost = (float)$prod_data[3];
        $pieces = (float)$prod_data[4];
        $amount = $quantity1 * $cost * $pieces;
        //  echo($amount.'-');
        $total_amount += $amount;
        // $total_amount_check += $amount;
        // echo 'Total Amount: ' . $total_amount . '<br>';
        // echo 'Total Amount Check: ' . $total_amount_check . '<br>';
        // echo $prod_data[1].'-';
        $obj2 = new stdClass();
        $obj2->product_name = $prod_data[0];
        $obj2->product_token = $prod_data[1];
        $obj2->product_mrp = $prod_data[2];
        $obj2->product_total_cost = $cost;
        $obj2->piece_count = $pieces;
        $obj2->item_code = $prod_data[5];   
        $obj2->batch_number = $prod_data[6];
        $obj2->quantity = $quantity1;
        $obj2->discount_percent = 0;
        $obj2->discount_amount = 0;
        $obj2->amount = number_format($amount, 2, '.', '');
        $obj2->final_amount = number_format($amount, 2, '.', '');
        $obj2->gst_rate = isset($prod_data[7]) && $prod_data[7] !== '' ? (float)$prod_data[7] : 18;
        array_push($details, $obj2);
    }

// ============================= new code 
// $result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
//     `products__category`.`name` AS `division_name`,
//     GROUP_CONCAT( CONCAT(
//         `products`.`name`,'&&&&',
//         `products`.`token`,'&&&&',
//         `products`.`mrp`,'&&&&',
//         `products`.`total_cost`,'&&&&',
//         `products`.`piece_count`,'&&&&',
//         `products`.`item_code`,'&&&&',
//         `products`.`batch_number`,'&&&&',
//         IFNULL(`products`.`gst`, '18')
//     ) SEPARATOR '****') AS `product_details`
//     FROM `products__category`
//     INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
//     WHERE `products`.`token` IN ($productQuery)
//     GROUP BY `products__category`.`token`");

// $gst_total_amount = 0;
// $basicRate_total = 0;
// $total_final_amount = 0;
// $slno = 0;
// $item_count_total = 0;
// $total_amount_check = 0;

// $output_data = []; 

// while ($row = mysqli_fetch_array($result)) {
//    $division_token =$row['division_token'];
//    echo $division_token.'-';
//    $product_string =$row["product_details"];
    
//     // Split cleanly by '****' since commas are handled by MySQL's SEPARATOR custom modifier
//    $product_details = explode("****", $product_string);
//    $details = [];
//    $total_amount = 0;

//     foreach ($product_details as $productData) {
//         if (empty($productData)) continue; 

//        $prod_data = explode("&&&&", $productData);
//        print_r($prod_data);
        
//         // Ensure data is fully formed before index extraction
//         if (count($prod_data) < 8) continue; 

//         $pToken =$prod_data[1];$quantity1 = 0;

//         // FIXED: Added missing '$' signs to array variables
//         foreach ($array as $value) {
//             if ($value->product_token ==$pToken) {
//                 $quantity1 = (float)$value->quantity;
//                 break;
//             }
//         }
        
//         if ($quantity1 <= 0) continue;

//         $cost = (float)$prod_data[3];
//         $pieces = (float)$prod_data[4];
//         $amount = $quantity1 * $cost * $pieces;
        
//        $total_amount +=$amount;
//        $total_amount_check +=$amount; 
//         // echo $prod_data[1].'-';
//         $obj2 = new stdClass();
//         $obj2->product_name       =$prod_data[0];
//         $obj2->product_token      =$prod_data[1];
//         $obj2->product_mrp        =$prod_data[2];
//         $obj2->product_total_cost =$cost;
//         $obj2->piece_count        =$pieces;
//         $obj2->item_code          =$prod_data[5];   
//         $obj2->batch_number       =$prod_data[6];
//         $obj2->quantity = $quantity1;
//         $obj2->discount_percent   = 0;
//         $obj2->discount_amount    = 0;
//         $obj2->amount             = number_format($amount, 2, '.', '');
//         $obj2->final_amount        = number_format($amount, 2, '.', '');
//         $obj2->gst_rate           = ($prod_data[7] !== '') ? (float) $prod_data[7] : 18;
//         array_push($details, $obj2);
//     }



        // echo 'Total Amount Check: ' . $total_amount_check . '<br>';
    $resultOffer = mysqli_query($link, "SELECT `admin_offers`.`token`,
        `admin_offers`.`offer_percentage`,
        `admin_offers`.`offer_name`
        FROM `admin_offers` 
        WHERE `division_token`='$division_token'
        AND `minimum_purchase_amount`<='$total_amount'
        AND `status`='1' AND `state_id`='$state'
        ORDER BY `minimum_purchase_amount` DESC
        LIMIT 0,1");

    if (mysqli_num_rows($resultOffer) > 0) {
        $rowOffer = mysqli_fetch_array($resultOffer);
        $offer_percentage = (float)$rowOffer['offer_percentage'];
        $offer_token = $rowOffer['token'];
        $offer_name = $rowOffer['offer_name'];
    } else {
        $offer_percentage = 0;
        $offer_token = '0';
        $offer_name = '';
    }

    $div_discount_amount = $total_amount * $offer_percentage / 100;
    $final_amount = $total_amount - $div_discount_amount;
    $units = 'Box';

    foreach ($details as $value) {
        // echo $value->product_token.'-';
        $item_count_total++;
        $product_discount_amount = $value->amount * $offer_percentage / 100;
        $product_final_amount = number_format($value->amount - $product_discount_amount, 2, '.', '');
        $value->discount_percent = $offer_percentage;
        $value->discount_amount = number_format($product_discount_amount, 2, '.', '');
        $value->final_amount = number_format($product_final_amount, 2, '.', '');

        $item_gst_rate = $value->gst_rate;
        $gst_multiplier = 1 + ($item_gst_rate / 100);
        if ($gst_multiplier <= 0) { $gst_multiplier = 1; }

        $gst_amount = number_format(($product_final_amount / $gst_multiplier) * ($item_gst_rate / 100), 2, '.', '');
        $gst_total_amount += (float)$gst_amount;
        $basicRate = number_format($product_final_amount / $gst_multiplier, 2, '.', '');
        $basicRate_total += (float)$basicRate;

        $slno++;
        $html .= '<tr>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">' . $slno . '</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">' . $value->product_name . '</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">' . $value->item_code . '</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">' . $value->quantity . ' box</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . $basicRate . '</span></td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">' . $value->discount_percent . '%</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . $gst_amount . '</span></td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . $product_final_amount . '</span></td>
                    </tr>';

        // Clean 19-Column matching Insert
        $orderproduct_array[] = "('$order_id','$value->product_token','$value->product_total_cost','$value->piece_count','$gst_amount','$value->quantity','0','$offer_token','$value->discount_percent','$product_discount_amount','$product_final_amount','$units','0','0','0','0','0','$item_gst_rate','$indiaDateTime')";
        $is_offer_product = mysqli_query($link, "SELECT `token`, `product_token`, `limit_box`, `free_box`, `free_product` FROM `products__scheme` WHERE `product_token`='$value->product_token' AND `is_scheme`='1' AND `limit_box` > 0 ORDER BY `limit_box` DESC");

        if (mysqli_num_rows($is_offer_product) > 0) {
            while ($schRow = mysqli_fetch_assoc($is_offer_product)) {
                $limit = (int)$schRow['limit_box'];
                $freeBox = (int)$schRow['free_box'];

                if ($limit > 0 && $value->quantity >= $limit) {
                    $multiplier = intdiv((int)$value->quantity, $limit);
                    $freeProduct = $multiplier * $freeBox;
                    $scheme_token_val = $schRow['token'];
                    $free_target_token = (!empty($schRow['free_product']) && $schRow['free_product'] != '0') ? $schRow['free_product'] : $value->product_token;

                    // Get piece count and cost for free product
                    $free_prod_q = mysqli_query($link, "SELECT `piece_count`, `total_cost`, `gst` FROM `products` WHERE `token`='$free_target_token' LIMIT 1");
                    $freeProdRow = mysqli_fetch_assoc($free_prod_q);
                    $f_piece_count = $freeProdRow ? $freeProdRow['piece_count'] : $value->piece_count;
                    $f_total_cost = $freeProdRow ? $freeProdRow['total_cost'] : $value->product_total_cost;
                    $f_gst = $freeProdRow ? (float)$freeProdRow['gst'] : 18;

                    // Exactly 19 Columns
                    $orderproduct_array[] = "('$order_id','$free_target_token','$f_total_cost','$f_piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token_val','0','0','0','$f_gst','$indiaDateTime')";
                    break;
                }
            }
        }

        // Distributor stock check
        $query_stk = mysqli_query($link, "SELECT `product_token`, `employee_token` FROM `stock__distributor` WHERE `product_token`= '$value->product_token' AND `employee_token`='$distributor_token'");
        if (mysqli_num_rows($query_stk) == 0) {
            mysqli_query($link, "INSERT INTO `stock__distributor`(`product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs`, `aog`, `status`) VALUES ('$value->product_token','$division_token','$distributor_token','0','0','0','0','Added')");
        }
    }

    $total_final_amount += (float)$final_amount;
}
// print_r($details);
// Bulk Insert Items into orders__items
// exit();
if (!empty($orderproduct_array)) {
    $insert_sql = "INSERT INTO `orders__items`(`order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `return_qty`, `offer_token`, `offer_percentage`,`offer_value`, `offer_amount`, `units`, `is_free`,`scheme_token`, `is_discount_enable`, `product_dis_price`, `product_price`, `gst_percent`, `date_time`) VALUES " . implode(", ", $orderproduct_array);
    $order_free_product = mysqli_query($link, $insert_sql);
}

$numbertoWord = numbertoword($total_final_amount);
$html .= '<tr>
            <th style="border: 1px solid #ccc;padding: 8px 10px;"></th>
            <th style="border: 1px solid #ccc;padding: 8px 10px;">Sub Total</th>
            <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . number_format($basicRate_total, 2, '.', '') . '</span></td>
            <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
            <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . number_format($gst_total_amount, 2, '.', '') . '</span></td>
            <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . number_format($total_final_amount, 2, '.', '') . '</span></td>
        </tr>
    </tbody>
    </table>
    <table style="width: 100%;font-size: 12px;line-height: 44px;text-align: right;">
        <tr>
            <th style="text-align: left;width:50%;" colspan="4">Estimate Total</th>
            <th style="display: block;" colspan="7"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>' . number_format($total_final_amount, 2, '.', '') . '</span></span></th>
        </tr>
        <tr>
            <td colspan="8" style="text-align: left;width:100%;"><b>Amount In Words</b> : <span>' . $numbertoWord . '</span></td>
        </tr>
        <tr>
            <th style="text-align: left;padding-top: 30px;">Signature</th>
        </tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>';

$stort_time = strtotime($indiaDateTime);
$fileName = "invoice_" . $order_id . $stort_time . ".pdf";
$update_order = mysqli_query($link, "UPDATE `orders` SET `items`='$item_count_total',`billing_amount`='$total_final_amount',`gst`='$gst_total_amount',`invoice_name`='$fileName' WHERE `token`='$order_id'");

$obj = new stdClass();
$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "Order Created Successfully";

echo json_encode($obj);
?>