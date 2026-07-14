<?php

include "../../../config.php";
$json_input = getInputs();
$employee_id = mysqli_real_escape_string($link, $json_input->employee_id);
$shopId = isset($json_input->shopId) ? (int)$json_input->shopId : 0;
$search_key = isset($json_input->searchKey) ? mysqli_real_escape_string($link, $json_input->searchKey) : '';

$home_data = array();
date_default_timezone_set("Asia/Kolkata");
$order_date = date('Y-m-d H:i:s');
$dateonly = $indiaDate;
$dayname = date('l', strtotime($order_date));

// Shop cursor pagination
$shopQuery = ($shopId == 0) ? '' : " AND shop.id < $shopId";
// Search filter
if ($search_key != '') {
    $shopQuery .= " AND shop.name LIKE '%$search_key%'";
}

// Get distributor token
$get_distributor_id = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$distributor_id = $row_id['admin_distributor_token'];

// Check schedules
$check_regular = mysqli_query($link, "SELECT COUNT(1) as count FROM `daily_schedule` WHERE sales_emp_token = '$employee_id' AND schedule_date = '$dayname'");
$row_regular = mysqli_fetch_array($check_regular);
$has_regular = $row_regular['count'] > 0;

$check_custom = mysqli_query($link, "SELECT COUNT(1) as count FROM custom_daily_schedule WHERE sales_emp_token = '$employee_id' AND schedule_date = '$dayname'");
$row_custom = mysqli_fetch_array($check_custom);
$has_custom = $row_custom['count'] > 0;

// Determine which logic to use
$is_custom_mode = ($has_custom && !$has_regular);

if ($is_custom_mode || $has_regular) {
    // --- SUMMARY DATA ---
    $date_start = "$dateonly 00:00:00";
    $date_end = "$dateonly 23:59:59";

    if ($is_custom_mode) {
        $summary_sql = "SELECT
            SUM(so.bill_amount) AS order_value1,
            COALESCE(SUM(today_orders.billing_amount), 0) AS order_value,
            SUM(so.paid_amt) AS total_collection,
            SUM(so.total_outstanding) AS outstanding,
            COUNT(DISTINCT shop.token) AS shop_count_value,
            ucm.unit_token,
            SUM(CASE WHEN today_orders.bill_discount_percentage != 0 THEN (today_orders.billing_amount * today_orders.bill_discount_percentage / 100) ELSE 0 END) AS percentage_value,
            COALESCE(SUM(today_orders.bill_discount_amount), 0) AS discount
        FROM custom_daily_schedule cds
        INNER JOIN unit_customise_mapping ucm ON cds.custom_unit_token = ucm.custom_unit_token
        INNER JOIN units__shop_mapping usm ON ucm.unit_token = usm.unit_group_token
        INNER JOIN shop__outstanding so ON so.shop_token = usm.shop_token
        INNER JOIN shop_mapping sm ON sm.unit_token = ucm.unit_token
        INNER JOIN shop ON shop.token = sm.shop_token
        LEFT JOIN orders AS today_orders ON today_orders.shop_token = sm.token 
            AND today_orders.date_time BETWEEN '$date_start' AND '$date_end'
            AND today_orders.delivery != 'Cancelled' 
            AND today_orders.employee_token = '$employee_id'
        WHERE cds.sales_emp_token = '$employee_id' 
            AND usm.delete_status = '1' 
            AND shop.delete_status = '1' 
            AND ucm.delete_status = '1' 
            AND cds.schedule_date = '$dayname'";
    } else {
        $summary_sql = "SELECT
            SUM(so.bill_amount) as order_value1,
            SUM(today_orders.billing_amount) as order_value,
            SUM(so.paid_amt) as total_collection,
            SUM(so.total_outstanding) as outstanding,
            COUNT(DISTINCT shop.token) as shop_count_value,
            ds.unit_token,
            SUM(CASE WHEN today_orders.bill_discount_percentage !=0 THEN (today_orders.billing_amount * today_orders.bill_discount_percentage / 100) ELSE 0 END) as percentage_value,
            SUM(today_orders.bill_discount_amount) as discount
        FROM `daily_schedule` ds
        INNER JOIN units__shop_mapping usm ON usm.unit_group_token = ds.unit_token
        INNER JOIN shop__outstanding so ON so.shop_token = usm.shop_token
        INNER JOIN shop_mapping sm ON sm.token = usm.shop_token
        LEFT JOIN orders AS today_orders ON sm.token = today_orders.shop_token 
            AND today_orders.date_time BETWEEN '$date_start' AND '$date_end'
            AND today_orders.delivery != 'Cancelled' 
            AND today_orders.employee_token = '$employee_id'
        INNER JOIN shop ON shop.token = sm.shop_token
        WHERE ds.sales_emp_token = '$employee_id' 
            AND usm.delete_status = 1 
            AND ds.schedule_date = '$dayname'";
    }

    $summary_res = mysqli_query($link, $summary_sql);
    $summary_row = mysqli_fetch_array($summary_res);

    // Productivity and Additional metrics (Combined where possible)
    $sales_log_data = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(1) as count FROM `sales__log` WHERE `date_time` BETWEEN '$date_start' AND '$date_end' AND `sales_token` = '$employee_id'"));
    $visited_data = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(1) as count FROM `salesman_shop_visited` WHERE `employee_token` = '$employee_id' AND `status` = '0' AND `date` = '$indiaDate'"));
    $collection_data = mysqli_fetch_array(mysqli_query($link, "SELECT SUM(`amount`) as today_amount FROM `shop__order_transaction` WHERE `employee_id` = '$employee_id' AND `date_time` BETWEEN '$date_start' AND '$date_end'"));
    
    $overall_data = mysqli_fetch_array(mysqli_query($link, "SELECT
            SUM(billing_amount) AS overallamt,
            SUM(CASE WHEN bill_discount_percentage != 0 THEN (billing_amount * bill_discount_percentage / 100) ELSE 0 END) as percentage_value,
            SUM(bill_discount_amount) as discount_amt
        FROM `orders`
        WHERE `employee_token` = '$employee_id' AND date_time BETWEEN '$date_start' AND '$date_end' AND `order_type` = 'Sales Order' AND delivery != 'Cancelled'"));

    $sales_log_count = $sales_log_data['count'];
    $visited_count = $visited_data['count'];
    $today_coll_amt = $collection_data['today_amount'] ?? 0;
    $overall_item_amt = round(($overall_data['overallamt'] ?? 0) - (($overall_data['percentage_value'] ?? 0) + ($overall_data['discount_amt'] ?? 0)));

    $total_covered = $sales_log_count + $visited_count;
    $shop_total_scheduled = (int)($summary_row['shop_count_value'] ?? 0);

    $obj_summary = new stdClass;
    $obj_summary->cover_today_value = $total_covered;
    $obj_summary->cover_today_outoff = $shop_total_scheduled;
    $obj_summary->today_order = intval(($summary_row['order_value'] ?? 0) - (($summary_row['percentage_value'] ?? 0) + ($summary_row['discount'] ?? 0)));
    $obj_summary->today_cover = 0;
    $obj_summary->achived_productivity = $total_covered;
    $obj_summary->overall_productivity = $shop_total_scheduled;
    $obj_summary->today_collection_amount = round($today_coll_amt);
    $obj_summary->overall_item_amount_value = round($overall_item_amt);
    $obj_summary->productivity = ($shop_total_scheduled > 0) ? round(($total_covered / $shop_total_scheduled) * 5) : 0;
    $obj_summary->unit_token = $summary_row['unit_token'] ?? '';

    // --- SHOP LIST DATA ---
    if ($is_custom_mode) {
        $shop_list_sql = "SELECT 
                shop.id, shop.token AS shop_token, shop.name, shop__type.name as type_name,
                shop.address, shop.city, shop.pincode, units.name AS units_name,
                COALESCE(today_orders.delivery, 'NoOrder') AS delivery,
                shop_mapping.token as mapping_token
            FROM shop
            INNER JOIN shop_mapping ON shop_mapping.shop_token = shop.token AND shop_mapping.distributor_token = '$distributor_id'
            INNER JOIN unit_customise_mapping ON shop_mapping.unit_token = unit_customise_mapping.unit_token
            INNER JOIN units ON unit_customise_mapping.unit_token = units.token 
            INNER JOIN custom_daily_schedule ON unit_customise_mapping.custom_unit_token = custom_daily_schedule.custom_unit_token 
            INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
            LEFT JOIN orders AS today_orders ON today_orders.shop_token = shop_mapping.token 
                AND today_orders.date_time BETWEEN '$date_start' AND '$date_end'
                AND today_orders.delivery != 'Cancelled' 
                AND today_orders.employee_token = '$employee_id'
            WHERE custom_daily_schedule.sales_emp_token = '$employee_id' 
                AND custom_daily_schedule.schedule_date = '$dayname' 
                AND shop.delete_status = '1' 
                AND unit_customise_mapping.delete_status = '1'
                $shopQuery
            GROUP BY shop.token
            ORDER BY shop.id DESC LIMIT 10";
    } else {
        $shop_list_sql = "SELECT 
                shop.id, shop.token AS shop_token, shop.name, shop__type.name as type_name,
                shop.address, shop.city, shop.pincode, units.name AS units_name,
                COALESCE(today_orders.delivery, 'NoOrder') AS delivery,
                shop_mapping.token as mapping_token
            FROM `daily_schedule`
            INNER JOIN units__shop_mapping ON units__shop_mapping.unit_group_token = daily_schedule.unit_token
            INNER JOIN shop_mapping ON shop_mapping.token = units__shop_mapping.shop_token
            INNER JOIN shop ON shop_mapping.shop_token = shop.token
            INNER JOIN shop__type ON shop__type.token = shop.shop_type_code
            INNER JOIN units ON units.token = daily_schedule.unit_token
            LEFT JOIN orders AS today_orders ON today_orders.shop_token = units__shop_mapping.shop_token 
                AND today_orders.date_time BETWEEN '$date_start' AND '$date_end'
                AND today_orders.delivery != 'Cancelled' 
                AND today_orders.employee_token = '$employee_id'
            WHERE daily_schedule.sales_emp_token = '$employee_id' 
                AND units__shop_mapping.delete_status = 1 
                AND daily_schedule.schedule_date = '$dayname'
                $shopQuery
            GROUP BY shop.token 
            ORDER BY shop.id DESC LIMIT 10";
    }

    $shop_res = mysqli_query($link, $shop_list_sql);
    $shop_details = array();
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

    foreach ($shop_temp_list as $row) {
        $m_token = $row['mapping_token'];
        $o_data = $overall_orders_data[$m_token] ?? array();

        $delivery_status = ($row['delivery'] == 'Pending' || $row['delivery'] == 'Completed') ? 'Completed' : 'NoOrder';
        
        $total_discount = round(($o_data['total_discount'] ?? 0) + ($o_data['total_perc_discount'] ?? 0));
        $billing_amt = $o_data['total_billing'] ?? 0;
        $paid_amt = $o_data['total_paid'] ?? 0;
        $balance = round($billing_amt - ($total_discount + $paid_amt));

        $obj_shop = new stdClass;
        $obj_shop->shopId = (int)$row['id'];
        $obj_shop->shop_id = $row['shop_token'];
        $obj_shop->shop_name = $row['name'];
        $obj_shop->shop_total = round($billing_amt - $total_discount);
        $obj_shop->paid_amt = round($paid_amt);
        $obj_shop->balance_amt = $balance;
        $obj_shop->target_amount = round($billing_amt - $total_discount);
        $obj_shop->achived_amount = round($paid_amt);
        $obj_shop->balance_amount = $balance;
        $obj_shop->category_name = $row['type_name'];
        $obj_shop->delivery = $delivery_status;
        $obj_shop->items = $row['total_items'] ?? 0;
        $obj_shop->address = $row['address'];
        $obj_shop->city = $row['city'];
        $obj_shop->pincode = $row['pincode'];
        $obj_shop->shop_distance = rand(1, 10);
        $obj_shop->units_name = $row['units_name'];
        
        $shop_details[] = $obj_shop;
    }

    $home_screen = new stdClass;
    $home_screen->summary_details = $obj_summary;
    $home_screen->shop_details = $shop_details;

    $response = new stdClass;
    $response->status_code = 200;
    $response->message = 'Product found';
    $response->title = 'Success';
    $response->data = $home_screen;

    echo json_encode($response);
} else {
    $response = new stdClass;
    $response->status_code = 400;
    $response->message = 'Product not found';
    $response->title = 'Success';
    echo json_encode($response);
}
