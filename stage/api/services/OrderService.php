<?php

class OrderService
{
    public static function processOrder($link, $product_array, $context)
    {
        $token  = genToken('token', 'orders');
        $order_number = "ORD-R" . $token;

        $shop_mapping_token = $context['shop_mapping_token'] ?? '';
        $employee_token = $context['employee_token'] ?? '';
        $distributor_token = $context['distributor_token'] ?? '';
        $bill_amount = $context['bill_amount'] ?? 0;
        $unit_shop_count = $context['unit_shop_count'] ?? 0;
        $order_type = $context['order_type'] ?? '';
        $currnetDateTime = $context['currnetDateTime'] ?? date("Y-m-d H:i:s");
        $indiaDate = $context['indiaDate'] ?? date("Y-m-d");
        $app_context = $context['app_context'] ?? '';
        $shop_token = $context['shop_token'] ?? '';
        $baseUrlPath = $context['baseUrlPath'] ?? '';

        $deparment_token = $context['deparment_token'] ?? '';
        $unit_token = $context['unit_token'] ?? '';

        // Product Items Count (Safe check for boolean/string/int)
        $product_item_val = 0;
        foreach ($product_array as $key => $data) {
            $is_free_val = isset($data->is_free) ? $data->is_free : false;
            if ($is_free_val === false || $is_free_val === '0' || $is_free_val === 0 || $is_free_val === 'false') {
                $product_item_val += 1;
            }
        }
        $final_product_item_count = $product_item_val;

        // Insert Order
        if ($app_context === 'delivery_boy') {
            $order_insert = mysqli_query($link, "INSERT INTO `orders`( `token`,`order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`,`distributor_token`, `items`, `billing_amount`,`outstanding_amount`,`delivery`,`delivery_emp_token`, `approved_on`, `delivered_on`,`unit_shop_count`) 
            VALUES ('$token','$order_number','$currnetDateTime','$order_type','$shop_mapping_token','$employee_token','$distributor_token','$final_product_item_count','$bill_amount','0','Completed','$employee_token','$currnetDateTime','$currnetDateTime','$unit_shop_count')");
        } else if ($app_context === 'sales_rep') {
            $sales_rep_token = $context['sales_rep_token'] ?? '';
            $order_insert = mysqli_query($link, "INSERT INTO `orders`( `token`,`order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`,`distributor_token`, `items`, `billing_amount`,`outstanding_amount`,`delivery`,`unit_shop_count`, `is_slaes_rep_admin`, `sales_rep_token`) 
            VALUES ('$token','$order_number','$currnetDateTime','$order_type','$shop_mapping_token','$distributor_token','$distributor_token','$final_product_item_count','$bill_amount','0','pending','$unit_shop_count', '1', '$sales_rep_token')");
        } else {
            $order_insert = mysqli_query($link, "INSERT INTO `orders`( `token`,`order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`,`distributor_token`, `items`, `billing_amount`,`outstanding_amount`,`delivery`,`unit_shop_count`) 
            VALUES ('$token','$order_number','$currnetDateTime','$order_type','$shop_mapping_token','$employee_token','$distributor_token','$final_product_item_count','$bill_amount','0','pending','$unit_shop_count')");
        }

        if ($order_insert) {
            // Context-specific pre-order logging
            if ($app_context === 'sales' || $app_context === 'sales_rep') {
                mysqli_query($link, "INSERT INTO `employees__daily_summary`( `date_time`, `department_token`, `employees_token`, `location_token`, `order_value`, `collection`, `productivity`, `outlets_covered`) VALUES ('$currnetDateTime','$deparment_token','$employee_token','$unit_token','0','0','0','0')");

                $check_status = mysqli_query($link, "SELECT * FROM `sales__log` WHERE `distributor_token`='$distributor_token' AND `sales_token`='$employee_token' AND  `shop_token` ='$shop_mapping_token' and `date_time` LIKE '$indiaDate%'");
                if (mysqli_num_rows($check_status) > 0) {
                    mysqli_query($link, "UPDATE `sales__log` SET `status`='Completed'  WHERE `distributor_token` = '$distributor_token' AND `sales_token` = '$employee_token' AND `shop_token`='$shop_mapping_token' AND `date_time` LIKE '$indiaDate%'");
                } else {
                    mysqli_query($link, "INSERT INTO `sales__log`(`date_time`, `distributor_token`, `sales_token`, `shop_token`, `status`) VALUES ('$currnetDateTime','$distributor_token','$employee_token','$shop_mapping_token','Completed')");
                }
            } else if ($app_context === 'distributor') {
                mysqli_query($link, "INSERT INTO `employees__daily_summary`( `date_time`, `department_token`, `employees_token`, `location_token`, `order_value`, `collection`, `productivity`, `outlets_covered`) VALUES ('$currnetDateTime','$deparment_token','$distributor_token','$unit_token','0','0','0','0')");

                $check_status = mysqli_query($link, "SELECT * FROM `sales__log` WHERE `distributor_token`='$distributor_token' AND `shop_token` ='$shop_mapping_token' and `date_time` LIKE '$indiaDate%'");
                if (mysqli_num_rows($check_status) > 0) {
                    mysqli_query($link, "UPDATE `sales__log` SET `status`='Completed'  WHERE `distributor_token` = '$distributor_token' AND `shop_token`='$shop_mapping_token' AND `date_time` LIKE '$indiaDate%'");
                } else {
                    mysqli_query($link, "INSERT INTO `sales__log`(`date_time`, `distributor_token`, `shop_token`, `status`) VALUES ('$currnetDateTime','$distributor_token','$shop_mapping_token','Completed')");
                }
            } else if ($app_context === 'delivery_boy') {
                mysqli_query($link, "INSERT INTO `employees__daily_summary`( `date_time`, `department_token`, `employees_token`, `location_token`, `order_value`, `collection`, `productivity`, `outlets_covered`) VALUES ('$currnetDateTime','$deparment_token','$employee_token','$unit_token','0','0','0','0')");
            }
        }

        $bill_amount = 0;
        $gst_total_amount = 0;

        foreach ($product_array as $key => $data) {
            $category_token = $data->category_token ?? '';
            $product_token = $data->token ?? '';
            $product_name = $data->name ?? '';
            $item_code = $data->item_code ?? '';
            
            // Support both app variants
            $order_qty = isset($data->added_count) ? (float)$data->added_count : (isset($data->order_count) ? (float)$data->order_count : 0);
            $units = isset($data->added_type) ? $data->added_type : (isset($data->order_type) ? $data->order_type : 'Box');
            
            $product_per_price = isset($data->product_per_price) ? (float)$data->product_per_price : 0;
            $product_per_gst = isset($data->product_gst) ? (float)$data->product_gst : 0;
            $piece_count = (isset($data->piece_count) && (float)$data->piece_count > 0) ? (float)$data->piece_count : 1;
            
            $is_discount_enable = isset($data->discount_enable) ? $data->discount_enable : false;
            $is_free = isset($data->is_free) ? $data->is_free : false;
            $is_scheme = isset($data->is_scheme) ? $data->is_scheme : false;
            $limit_box = (isset($data->limit_box) && (float)$data->limit_box > 0) ? (float)$data->limit_box : 0;
            $free_box = isset($data->free_box) ? (float)$data->free_box : 0;
            $percentage = (property_exists($data, 'percentage')) ? $data->percentage : 0;

            // Safe Boolean / String check
            $check_not_free = ($is_free === false || $is_free === '0' || $is_free === 0 || $is_free === 'false');

            if ($check_not_free) {
                if ($units == 'Box') {
                    $disrtributor_product_count = $order_qty * $piece_count;
                    $order_qty1 = $order_qty * $piece_count;
                    $product_amount_value = $order_qty * $piece_count * $product_per_price;
                } else {
                    $disrtributor_product_count = $order_qty;
                    $order_qty1 = $order_qty;
                    $product_amount_value = $order_qty * $product_per_price;
                }

                if ($is_discount_enable && ($is_discount_enable === true || $is_discount_enable === '1' || $is_discount_enable === 1)) {
                    $discount_val = 1;
                    $percentage_number = (float) filter_var($percentage, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $percentage_cal = $percentage_number / 100;
                    $product_value = ($order_qty1 * $product_per_price) - ($order_qty1 * $product_per_price * $percentage_cal);
                } else {
                    $discount_val = 0;
                    $percentage_number = 0;
                    $product_value = ($order_qty1 * $product_per_price);
                }

                $bill_amount += $product_value;

                $gst_multiplier = 1 + ($product_per_gst / 100);
                if ($gst_multiplier <= 0) { $gst_multiplier = 1; }
                $gst_amount = number_format($product_value / $gst_multiplier * $product_per_gst / 100, 2, '.', '');
                $gst_total_amount += number_format($gst_amount, 2, '.', '');

                // Added delete_status='1' explicitly
                mysqli_query($link, "INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`,`offer_amount`, `units`,`is_discount_enable` ,`discount_value`, `gst_percent`, `delete_status`, `date_time`) VALUES 
                ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$order_qty','$product_amount_value','$units','$discount_val','$percentage_number','$product_per_gst','1','$currnetDateTime')");

                mysqli_query($link, "INSERT INTO `shop__stock_list`( `products_token`, `shop_token`, `qty`, `sales`) VALUES ('$product_token','$shop_mapping_token','$order_qty','$bill_amount')");

                $select_dist_stock = mysqli_query($link, "SELECT `stock_in_hand`,`sold_pieces` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$distributor_token'");
                $selectrow_dist = mysqli_fetch_array($select_dist_stock);
                
                $old_stock_count = $selectrow_dist['stock_in_hand'] ?? 0;
                $sold_old_pices = $selectrow_dist['sold_pieces'] ?? 0;

                if ($units == 'Box') {
                    $newcount_stock = $old_stock_count - $order_qty;
                    mysqli_query($link, "UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock' WHERE `product_token`='$product_token' AND `employee_token`='$distributor_token'");
                } else {
                    $new_sold_pieces = $sold_old_pices + $order_qty;
                    $new_box =  $old_stock_count - floor($new_sold_pieces / $piece_count);
                    $balanace_pieces = $new_sold_pieces % $piece_count;
                    mysqli_query($link, "UPDATE `stock__distributor` SET `stock_in_hand` = '$new_box', `sold_pieces`='$balanace_pieces' WHERE `product_token`='$product_token' AND `employee_token`='$distributor_token'");
                }

                // Scheme calculations with zero-division safeguard
                if ($is_scheme && $limit_box > 0 && $free_box > 0) {
                    if ($units == 'Box') {
                        $free_box_val = ($order_qty / $limit_box) * $free_box;
                        if ($free_box_val >= 1) {
                            $product_box_count = (int)($free_box_val);
                            $units_offer = 'Box';
                            $product_dist_count_free = $product_box_count * $piece_count;
                        } else {
                            $product_box_count = (int)($free_box_val * $piece_count);
                            $units_offer = 'Nos';
                            $product_dist_count_free = $product_box_count;
                        }
                        if ($product_box_count > 0) {
                            mysqli_query($link, "INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`,`is_free`,`is_discount_enable`, `gst_percent`, `delete_status`, `date_time`) VALUES 
                            ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$product_box_count','$units_offer','1','0','$product_per_gst','1','$currnetDateTime')");
                        }
                    } else {
                        $qtyToBox = $order_qty / $piece_count;
                        $free_box_val = ($qtyToBox / $limit_box) * $free_box;
                        if ($free_box_val >= 1) {
                            $product_box_count = (int)($free_box_val);
                            $units_offer = 'Box';
                            $product_dist_count_free = $product_box_count * $piece_count;
                        } else {
                            $product_box_count = (int)($free_box_val * $piece_count);
                            $units_offer = 'Nos';
                            $product_dist_count_free = $product_box_count;
                        }
                        if ($product_box_count > 0) {
                            mysqli_query($link, "INSERT INTO `orders__items`( `order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `units`,`is_free`,`is_discount_enable`, `gst_percent`, `delete_status`, `date_time`) VALUES 
                            ('$token','$product_token','$product_per_price','$piece_count','$product_per_gst','$product_box_count','$units_offer','1','0','$product_per_gst','1','$currnetDateTime')");
                        }
                    }

                    // Deduct scheme items from stock
                    if(isset($product_dist_count_free) && $product_dist_count_free > 0) {
                        $select_dist_stock2 = mysqli_query($link, "SELECT `stock_in_hand` FROM `stock__distributor` WHERE `product_token`='$product_token' AND`employee_token`= '$distributor_token'");
                        $selectrow_dist2 = mysqli_fetch_array($select_dist_stock2);
                        $old_stock_count2 = $selectrow_dist2['stock_in_hand'] ?? 0;
                        $newcount_stock2 = $old_stock_count2 - $product_dist_count_free;
                        mysqli_query($link, "UPDATE `stock__distributor` SET `stock_in_hand`='$newcount_stock2' WHERE `product_token`='$product_token' AND `employee_token`='$distributor_token'");
                    }
                }
            }
        }

        $bill_amount_final = round($bill_amount);
        mysqli_query($link, "UPDATE `orders` SET `billing_amount`= '$bill_amount_final', `outstanding_amount`='$bill_amount_final', `gst`='$gst_total_amount' WHERE `token`='$token'");

        // Shop Outstanding Mapping
        $outstanding_shop_token = ($app_context === 'distributor') ? $shop_token : $shop_mapping_token;
        
        $check_shop = mysqli_query($link, "SELECT `shop_token` FROM `shop__outstanding` WHERE `shop_token` = '$outstanding_shop_token'");
        if (mysqli_num_rows($check_shop) > 0) {
            $addamount = mysqli_query($link, "SELECT `bill_amount`, `paid_amt`, `total_outstanding` FROM `shop__outstanding` WHERE `shop_token` = '$outstanding_shop_token'");
            $row1 = mysqli_fetch_array($addamount);
            $new_billAmount = $row1['bill_amount'] + $bill_amount;
            $new_total_outstanding  = $row1['total_outstanding'] + $bill_amount;
            mysqli_query($link, "UPDATE `shop__outstanding` SET `bill_amount`='$new_billAmount',`total_outstanding`= '$new_total_outstanding' WHERE `shop_token` = '$outstanding_shop_token'");
        } else {
            mysqli_query($link, "INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`) VALUES ('$currnetDateTime','$outstanding_shop_token','$bill_amount',0,'$bill_amount')");
        }

        // Generate PDF
        if ($order_insert && !empty($baseUrlPath)) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $baseUrlPath . 'TCPDF-main/examples/salesOrderInvoice.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('order_token' => $token),
            ));
            curl_exec($curl);
            curl_close($curl);
        }

        $obj = new stdClass;
        if ($order_insert) {
            $obj->status_code = 200;
            $obj->message = 'Product inserted';
            $obj->title = 'Success';
        } else {
            $obj->status_code = 400;
            $obj->message = 'Product not found';
            $obj->title = 'Success';
        }

        return $obj;
    }
}