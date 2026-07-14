<?php

include "../../config.php";
$json_input = getInputs();
$employee_id = mysqli_real_escape_string($link, $json_input->employee_id);
$shopId = isset($json_input->shopId) ? (int)$json_input->shopId : 0;
// Note: searchKey is included for consistency with home_screen.php if needed later
$search_key = isset($json_input->searchKey) ? mysqli_real_escape_string($link, $json_input->searchKey) : '';

$home_data = array();
date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d H:i:s');
$dateonly = $indiaDate;
$dayname = date('l', strtotime($order_date));

$date_start = "$dateonly 00:00:00";
$date_end = "$dateonly 23:59:59";

$shopQuery = ($shopId == 0) ? '' : " AND shop.id < $shopId";
if ($search_key != '') {
    $shopQuery .= " AND shop.name LIKE '%$search_key%'";
}

// Get distributor token
$get_distributor_id = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$distributor_id = $row_id['admin_distributor_token'];

// Main query for pending orders grouped by shop
$shop_list_sql = "SELECT 
        shop.id, shop.name, shop.token, shop.address, shop.city, shop.pincode,
        shop__type.name as type_name,
        orders.delivery,
        shop_mapping.token as mapping_token,
        COALESCE(SUM(orders.billing_amount), 0) AS bill_amt_val,
        COALESCE(SUM(orders.paid_amount), 0) AS paid_amt_val,
        COALESCE(SUM(orders.items), 0) AS items_val
    FROM `orders`
    INNER JOIN shop_mapping ON shop_mapping.token = orders.shop_token
    INNER JOIN shop ON shop_mapping.shop_token = shop.token
    INNER JOIN shop__outstanding ON shop__outstanding.shop_token = orders.shop_token
    INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
    WHERE (orders.employee_token = '$employee_id' OR orders.distributor_token = '$distributor_id') 
        AND orders.delivery = 'Pending' 
        AND (orders.date_time < '$date_start' OR orders.date_time > '$date_end')
        AND orders.order_type != 'Distributor Order'
        $shopQuery
    GROUP BY shop.token 
    ORDER BY shop.id DESC LIMIT 10";

$shop_res = mysqli_query($link, $shop_list_sql);
$shop_array = array();
$shop_temp_list = array();
$mapping_tokens = array();

while ($row = mysqli_fetch_array($shop_res)) {
    $shop_temp_list[] = $row;
    $mapping_tokens[] = "'" . $row['mapping_token'] . "'";
}

// --- Optimized: Fetch overall totals only for the 10 shops found ---
$overall_orders_data = array();
if (!empty($mapping_tokens)) {
    $tokens_str = implode(',', $mapping_tokens);
    $orders_sql = "SELECT shop_token, 
                   SUM(billing_amount) as total_billing, 
                   SUM(paid_amount) as total_paid, 
                   SUM(bill_discount_amount) as total_discount,
                   SUM(CASE WHEN bill_discount_percentage != 0 THEN (billing_amount * bill_discount_percentage / 100) ELSE 0 END) as total_perc_discount,
                   SUM(items) as total_items
            FROM orders 
            WHERE shop_token IN ($tokens_str) AND delivery != 'Cancelled' 
            GROUP BY shop_token";
    $orders_res = mysqli_query($link, $orders_sql);
    while ($o_row = mysqli_fetch_array($orders_res)) {
        $overall_orders_data[$o_row['shop_token']] = $o_row;
    }
}

$total_shop = count($shop_temp_list);
foreach ($shop_temp_list as $row) {
    $m_token = $row['mapping_token'];
    $o_data = $overall_orders_data[$m_token] ?? array();

    $total_discount = round(($o_data['total_discount'] ?? 0) + ($o_data['total_perc_discount'] ?? 0));
    $billing_amt = $o_data['total_billing'] ?? 0;
    $paid_amt = $o_data['total_paid'] ?? 0;
    $balance = round($billing_amt - ($total_discount + $paid_amt));

    $obj_shop = new stdClass;
    $obj_shop->shopId = (int)$row['id'];
    $obj_shop->shop_id = $row['token'];
    $obj_shop->shop_name = $row['name'];
    $obj_shop->shop_total = round($billing_amt - $total_discount);
    $obj_shop->paid_amt = round($row['paid_amt_val']);
    $obj_shop->balance_amt = $balance;
    $obj_shop->delivery = $row['delivery'];
    $obj_shop->target_amount = round($billing_amt - $total_discount);
    $obj_shop->achived_amount = round($paid_amt);
    $obj_shop->balance_amount = $balance;
    $obj_shop->category_name = $row['type_name'];
    $obj_shop->items = $o_data['total_items'] ?? 0;
    $obj_shop->address = $row['address'];
    $obj_shop->city = $row['city'];
    $obj_shop->pincode = $row['pincode'];
    $obj_shop->shop_distance = rand(1, 10);
    
    array_push($shop_array, $obj_shop);
}

$home_screen = new stdClass;
$home_screen->total_shop = $total_shop;
$home_screen->shop_details = $shop_array;

$obj = new stdClass;
if ($employee_id && (count($shop_array) > 0 || $shopId != 0)) {
    $obj->status_code = 200;
    $obj->message = 'Product found';
    $obj->title = 'Success';
    $obj->data = $home_screen;
} else {
    $obj->status_code = 400;
    $obj->message = 'Product not found';
    $obj->title = 'Success';
}

echo json_encode($obj);
?>