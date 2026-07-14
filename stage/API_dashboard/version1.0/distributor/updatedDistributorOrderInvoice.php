<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$distributor_token = $input_data->distributor_token;
$order_id = $input_data->order_token;
$invoice_name = $input_data->invoice_name;

$delivery_query = mysqli_query($link, "SELECT `delivery` FROM `orders` WHERE `token` = '$order_id'");
$delivery_row = mysqli_fetch_assoc($delivery_query);
$delivery_status = isset($delivery_row['delivery']) ? $delivery_row['delivery'] : 'Pending';

$is_approved = ($delivery_status === 'Approved' || $delivery_status === 'Completed');

if ($is_approved) {
    $invoice_header_left = 'Invoice issued under Rule 1 of GST Tax Invoice Rules, 2017';
    $invoice_header_right = 'TAX INVOICE - Original for Receiver';
    $doc_number_label = 'Document Number';
} else {
    $invoice_header_left = 'Tax Estimate';
    $invoice_header_right = 'TAX ESTIMATE';
    $doc_number_label = 'Estimate Number';
}
$address_query = mysqli_query($link, "SELECT `name`, `address` AS `address_base`, `street`, `city`, `pincode`, `region_id`, `state_id`, `mobile_number`, `license_number` FROM `employees` WHERE `deparment_token`='18028120' AND `token` = '$distributor_token'");
$row21 = mysqli_fetch_assoc($address_query);
$dist_name = $row21["name"];
$dist_address = $row21["name"] . ", " . $row21["address_base"] . ", " . $row21["street"] . ", " . $row21["city"] . " - " . $row21["pincode"];
$dist_address_multiline = $row21["address_base"] . ",<br/>" . $row21["street"] . ",<br/>" . $row21["city"] . " - " . $row21["pincode"];
$dist_city = strtoupper($row21["city"]);
$dist_region = $row21["region_id"];
$query = mysqli_query($link, "SELECT region_name FROM `region` WHERE token='$dist_region'");
$row22 = mysqli_fetch_assoc($query);
$region = $row22["region_name"];
$dist_state = $row21["state_id"];
$query1 = mysqli_query($link, "SELECT  state_name FROM `employees__state` WHERE state_token='$dist_state'");
$row22 = mysqli_fetch_assoc($query1);
$state = $row22["state_name"];
$dist_mobile_number = $row21["mobile_number"];
$license_number = $row21["license_number"];
$total_tcs_amount = 0;
$date = new DateTime('2023-04-01');
$parts = explode('-', '2023-04-01');
$year1 = $parts[0];
$year = date('Y');
if ($year != $year1) {
    $date->modify('+1 years');
} else {
    $date = new DateTime('2023-04-01');
}
$value = $date->format('Y-m-d');

$date1 = new DateTime('2024-03-01');
$parts = explode('-', '2024-03-01');
$year1 = $parts[0];
$year = date('Y');
if ($year != $year1) {
    $date1 = new DateTime('2024-03-01');
} else {
    $date1->modify('+1 years');
}
$value1 = $date1->format('Y-m-d');

$query2 = mysqli_query($link, "SELECT SUM(billing_amount)AS `total` FROM `orders` WHERE date(date_time) BETWEEN '$value' AND '$value1' AND employee_token='$distributor_token' AND order_type='Distributor Order'");
$row23 = mysqli_fetch_assoc($query2);
$total_tcs = $row23["total"];

if ($state == 'Pondicherry') {
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            .bold { font-weight: bold; }
        </style>
    </head>
    <body>
    
    <table border="0" style="table-layout:fixed;width: 100%;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; font-family: sans-serif; font-size: 8px; line-height: 10px; margin-bottom: 5px;">
            <tr>
                <td style="width: 50%; text-align: left;">' . $invoice_header_left . '</td>
                <td style="width: 50%; text-align: right; font-weight: bold;">' . $invoice_header_right . '</td>
            </tr>
        </table>
        
        <table cellpadding="4" cellspacing="0" style="table-layout:fixed;border-collapse: collapse;width: 100%;text-align: left;font-size: 8px;line-height: 12px;font-family: sans-serif;border: 1px solid #000;margin-bottom: 10px;">
            <tr>
                <td style="border: 1px solid #000; width: 73%; vertical-align: middle;">
                    <table style="width:100%; border:none;">
                        <tr>
                            <td style="border:none; width: 18%;"><img src="' . $baseUrlPath . 'admin_dashboard/assets/logo.png" style="width: 45px; object-fit: contain;"></td>
                            <td style="border:none; width: 82%; font-size: 8px; line-height: 10px;">
                                <b style="font-size: 10px; font-weight: bold; text-transform: uppercase;">Abirami Soap Works LLP</b><br/>
                                RS NO 93/2 1A 1B, EMBALAM MAIN ROAD, SEMBIAPALAYAM VILLAGE, KORKADU POST, PUDUCHERRY - 605110.<br/>
                                <b>GSTIN</b>: 34AAIFA1436C1Z3
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="border: 1px solid #000; width: 13.5%; text-align: center; vertical-align: top;">
                    <span style="color: #666; font-size: 7px;">' . $doc_number_label . '</span><br/><br/>
                    <b style="font-size: 9px;">' . $order_id . '</b>
                </td>
                <td style="border: 1px solid #000; width: 13.5%; text-align: center; vertical-align: top;">
                    <span style="color: #666; font-size: 7px;">Invoice Date</span><br/><br/>
                    <b style="font-size: 9px;">' . $indiaDateFormat . '</b>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; width: 73%; vertical-align: top; padding: 6px;">
                    <b>Billing Address:</b><br/>
                    <b style="font-size: 9px;">' . $dist_name . '</b><br/>
                    ' . $dist_address_multiline . '
                </td>
                <td colspan="2" style="border: 1px solid #000; width: 27%; vertical-align: top; line-height: 14px; font-size: 8px; padding: 6px;">
                    <b>Mobile Number</b> : ' . $dist_mobile_number . '<br/><br/>
                    <b>GSTIN/UIN</b> : <b>' . $license_number . '</b>
                </td>
            </tr>
        </table>

        <table cellpadding="3" style="table-layout:fixed;border-collapse: collapse;border: 1px solid #000;width: 100%;text-align: left;font-size: 8px;line-height: 16px;font-family: sans-serif;">
            <thead style="background: #f5f5f5;border: 1px solid #000;">
            <tr>
                <th style="border: 1px solid #000;padding: 4px;width:4%;text-align:center;"><b>Sno</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:22%;text-align:center;"><b>Product Description</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>MRP</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>HSN / SAC</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:5%;text-align:center;"><b>UoM</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>Kgs</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Box/Bags</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Unit Price</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Before Discount</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>Discount</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>GST</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Total</b></th>
            </tr>
        </thead>
    <tbody>';
    $query = mysqli_query($link, "SELECT
    `orders__items`.`order_token`,
    `products`.`name` AS `product_name`,
    `products`.`item_code` AS `item_codes`,
    `products`.`mrp`,
    `products`.`hsn_code`,
    `products`.`net_weight`,
    `products`.`gst`,
    `orders__items`.`price_per_unit`,
    `orders__items`.`piece_count`,
    `orders__items`.`misc_price` as misc_price,
    `orders__items`.`quantity`,
    `orders__items`.`offer_percentage`,
    `orders__items`.`offer_amount`,
    `orders__items`.`discount_distributor`,
    `orders__items`.`units`,
    `orders__items`.`is_free`,
    `orders__items`.`is_discount_enable`,
    `orders__items`.`discount_value`
    FROM
    `orders__items`
    INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
    where `orders__items`.`order_token`='$order_id' AND `orders__items`.`delete_status`='1' ORDER BY `products`.`name`, `orders__items`.`is_free` ASC");
    $slno = 0;
    $totalTaxableValue = 0;
    $totalDiscountAmt = 0;
    $totalBeforeDisc = 0;
    $totalBags = 0;
    $totalKgs = 0;
    $gst_total_amount = 0;
    $total_final_amount = 0;

    while ($row = mysqli_fetch_array($query)) {
        $slno++;
        $gst_rate = isset($row['gst']) && $row['gst'] !== '' ? floatval($row['gst']) : 18;
        $gst_multiplier = 1 + ($gst_rate / 100);
        
        $qty = floatval($row['quantity']);
        $unit = $row['units'];
        $mrp = floatval($row['mrp']);
        
        if ($unit == "Box" && $row['is_free'] == '0') {
            $unitPriceIncl = intval($row['piece_count']) * floatval($row['price_per_unit']);
            $unitPriceTaxable = $unitPriceIncl / $gst_multiplier;
            $grossTaxable = $qty * $unitPriceTaxable;
            $bags = $qty;
        } else if ($unit == "Nos" && $row['is_free'] == '0') {
            $unitPriceIncl = floatval($row['price_per_unit']);
            $unitPriceTaxable = $unitPriceIncl / $gst_multiplier;
            $grossTaxable = $qty * $unitPriceTaxable;
            $bags = number_format($qty / (intval($row['piece_count']) > 0 ? intval($row['piece_count']) : 1), 2, '.', '');
        } else {
            $unitPriceIncl = 0;
            $unitPriceTaxable = 0;
            $grossTaxable = 0;
            $bags = 0;
        }

        // Calculate weight in Kgs
        $total_pieces = ($unit == "Box") ? ($qty * intval($row['piece_count'])) : $qty;
        $net_weight = isset($row['net_weight']) ? floatval($row['net_weight']) : 0;
        $row_kgs = ($total_pieces * $net_weight) / 1000;

        // Apply discount after removing GST
        $discount_pct = 0;
        if ($row["is_discount_enable"] == '1') {
            $discount_pct += floatval($row["discount_value"]);
        }
        if (isset($row["offer_percentage"]) && floatval($row["offer_percentage"]) > 0) {
            $discount_pct += floatval($row["offer_percentage"]);
        }
        $discValueRowTaxable = $grossTaxable * ($discount_pct / 100);
        
        $taxableValue = $grossTaxable - $discValueRowTaxable;
        $row_gst_amt = $taxableValue * ($gst_rate / 100);
        $netTotalRow = $taxableValue + $row_gst_amt;
        
        $beforeDiscCol = $grossTaxable;
        $discountCol = $discValueRowTaxable;
        $gstCol = $row_gst_amt;
        $totalCol = $netTotalRow;

        $totalBeforeDisc += $beforeDiscCol;
        $totalDiscountAmt += $discountCol;
        $gst_total_amount += $gstCol;
        $total_final_amount += $totalCol;

        $totalTaxableValue += $taxableValue;
        $totalBags += $bags;
        $totalKgs += $row_kgs;

        $html .= '<tr>
                    <td style="border: 1px solid #000;text-align:center;width:4%;">' . $slno . '</td>
                    <td style="border: 1px solid #000;text-align:left;padding-left:5px;width:22%;">' . $row["product_name"] . '</td>
                    <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($mrp, 2, '.', '') . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:8%;">' . $row["hsn_code"] . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:5%;">' . $unit . '</td>
                    <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($row_kgs, 2, '.', '') . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:8%;">' . number_format($bags, 2, '.', '') . '</td>';
        if ($row["is_free"] != '1') {
            $html .= '<td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($unitPriceTaxable, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($beforeDiscCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($discountCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($gstCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($totalCol, 2, '.', '') . '</td>';
        } else {
            $html .= '<td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:7%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">Free</td>';
        }
        $html .= '</tr>';
    }
    $basicRate_total = $totalTaxableValue;
    
    // Calculate GST amounts (divided equally for CGST and SGST in Pondicherry branch)
    $gst_total_amount = $total_final_amount - $totalTaxableValue;
    $cgst_amt = $gst_total_amount / 2;
    $sgst_amt = $gst_total_amount / 2;
    
    // TCS calculation
    $total_tcs_amount = 0;
    if ($total_tcs > 5000000) {
        $total_tcs_amount = ($total_final_amount) / 1000;
    }
    
    $invoice_total_unrounded = $total_final_amount + $total_tcs_amount;
    $invoice_total_rounded = round($invoice_total_unrounded);
    $rounded_off = number_format($invoice_total_rounded - $invoice_total_unrounded, 2, '.', '');
    
    $gstWords = numbertoword(round($gst_total_amount));
    $tcsWords = $total_tcs_amount > 0 ? numbertoword(round($total_tcs_amount)) : "";
    $amountWords = numbertoword(round($invoice_total_rounded));
    
    $html .= '<tr>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000; padding: 4px; width: 4%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 22%;" class="bold">Total Amount [INR]</td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 7%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 8%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px; width: 5%;"></td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:7%;" class="bold">' . number_format($totalKgs, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:center;width:8%;" class="bold">' . number_format($totalBags, 2, '.', '') . '</td>
                <td style="border: 1px solid #000;padding: 4px;width:8%;"></td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($totalBeforeDisc, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:7%;" class="bold">' . number_format($totalDiscountAmt, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($gst_total_amount, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($total_final_amount, 2, '.', '') . ' &nbsp;</td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>GST Payable:</b> CGST (9%): Rs ' . number_format($cgst_amt, 2, '.', '') . ', SGST (9%): Rs ' . number_format($sgst_amt, 2, '.', '') . ' | <b>GST Payable in Words:</b> (INR) ' . $gstWords . ' Only
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; padding: 4px;">
                    TCS Tax
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; padding: 4px;">
                    ' . number_format($total_tcs_amount, 2, '.', '') . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>TCS Payable in Words:</b> (INR) ' . ($total_tcs_amount > 0 ? $tcsWords . ' Only' : '') . '
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; padding: 4px;">
                    Rounded Off
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; padding: 4px;">
                    ' . $rounded_off . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>Amount in Words:</b> (INR) ' . $amountWords . ' Only
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; background-color: #f5f5f5; padding: 4px;">
                    Invoice Total
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f5f5f5; padding: 4px;">
                    ' . indCurrencyFormatComma($invoice_total_rounded) . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="12" style="border: 1px solid #000; padding: 4px;">
                    <b>Terms and Conditions:</b> Interest shall be levied @18% P.A if payment is not made within the credit period
                </td>
            </tr>
            <tr>
                <td colspan="8" style="border-left: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; vertical-align: bottom;">
                </td>
                <td colspan="4" style="border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; text-align: right; vertical-align: top; line-height: 12px;">
                    <span style="font-weight: bold;">For ABIRAMI SOAP WORKS LLP</span><br/><br/><br/><br/>
                    <span style="font-weight: bold; text-decoration: overline;">Authorized Signatory</span>
                </td>
            </tr>
    </tbody>
        </table>
        
        <table cellpadding="4" cellspacing="0" style="width: 100%; table-layout: fixed; border-top: 1px solid #000; font-family: sans-serif; font-size: 7px; line-height: 10px; margin-top: 15px;">
            <tr>
                <td style="width: 35%; text-align: left;">
                    Ph No: 0413-2266111 Email Id: puducherry@powersoaps.com
                </td>
                <td style="width: 30%; text-align: center; font-weight: bold;">
                    PROMOTIONAL ARTICLES PRICES ARE INCLUDED IN ABOVE RATE
                </td>
                <td style="width: 35%; text-align: right;">
                    LLP Identification No. : <b>AAG-9662</b> "It is registered with limited liability"
                </td>
            </tr>
            <tr>
                <td style="text-align: right;">
                    Page 1 of 1
                </td>
                <td colspan="2" style="text-align: left;">
                    E & O.E.
                </td>
            </tr>
        </table>
        
        </td>
        </tr>
        </table>
    </body>
    </html>';
    // }else if($region == 'karaikal' && $state == 'Pondicherry') {
    //     $html = "";
    //     $html = '<!DOCTYPE html>
    //     <html lang="en">
    //     <head>
    //         <meta charset="UTF-8">
    //         <style>

    //         </style>
    //     </head>
    //     <body>

    //     <table border="0" style="table-layout:fixed;width: 580px;height:auto;margin: 0 auto;font-family: sans-serif;">
    //     <tr>
    //         <td>
    //         <table cellpadding="0" cellspacing="0" style="table-layout:fixed;border-collapse: collapse;width: 100%;text-align: left;font-size: 10px;line-height: 18px;font-family: sans-serif;">
    //             <tr style="">
    //                 <td style="display: block;width: 50%;text-align: left;margin:0;padding:0;">
    //                 <table style="width: 100%;">
    //                 <tr>
    //                     <td><img src="'.$baseUrlPath.'admin_dashboard/assets/logo.png" alt="logo" style="width: 150px;object-fit: contain;"></td>
    //                 </tr>
    //                  <tr>
    //                     <td style="display: block;width: 100%;text-align: left;min-width: 200px;font-size: 10px;line-height: 16px;margin:0;padding:0;"><span style="font-size: 12px;font-weight:700;">Praveen Chem Industry</span><br/>No 76/12,Keelavanjur Nagore,<br/> Karaikal-609602 <br/><b style="width: 100px;">GSTIN </b>: <span>34AAEFP7684H1ZW</span> </td>
    //                 </tr>
    //                 </table>
    //                 </td>
    //                 <td style="display: block;width: 380px;text-align: right;float:right;margin:0;padding:0;">
    //                 <br/><br/><br/>
    //                 <table style="width: 100%;">
    //                 <tr>
    //                     <td style="font-size: 10px;line-height: 5px;width: 100%;margin:0;padding:0;"></td>
    //                  </tr>
    //                 <tr>
    //                     <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="width: 100px;font-size: 12px;display: inline-block;">Estimate No </b>: <span>'.$order_id.'</span><br/><b style="width: 100px;font-size: 12px;display: inline-block;" >Date </b>: <span>'.$indiaDateFormat.'</span></td>
    //                  </tr>
    //                 </table>
    //                </td>
    //             </tr>
    //             <tr cellpadding="0"
    //        cellspacing="0" style="margin:0;padding:0;">
    //                 <td style="display: block;width: 50%;text-align: left;">
    //                 <table style="width: 100%;">
    //                 <tr>
    //                     <td style="font-size: 10px;line-height: 16px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">BILL TO</b><br/>'.$dist_address.'<span style="display: block;"><br>Ph :'.$dist_mobile_number.'</span><br/><b style="width: 100px;">GSTIN </b>: <span>'.$license_number.'</span></td>
    //                 </tr>
    //                 </table>
    //                </td>
    //             </tr>  
    //         </table>

    //         <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 10px;line-height: 18px;font-family: sans-serif;">
    //             <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
    //             <tr>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:40px;text-align:center;"><b>S.No</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:170px;text-align:center;"><b>Item Name</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Price</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:40px;text-align:center;"><b>Qty<br/>Box/Bags</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Basic Rate</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:30px;text-align:center;"><b>Offer</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>SGST Amt 9%</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>CGST Amt 9%</b></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Amt</b></th>
    //             </tr>
    //         </thead>
    //     <tbody>';  
    //     $query = mysqli_query($link,"SELECT
    //     `orders__items`.`order_token`,
    //     `products`.`name` AS `product_name`,
    //     `products`.`item_code` AS `item_codes`,
    //     `orders__items`.`price_per_unit`,
    //     `orders__items`.`piece_count`,
    //     `orders__items`.`misc_price` as misc_price,
    //     `orders__items`.`quantity`,
    //     `orders__items`.`offer_percentage`,
    //     `orders__items`.`offer_amount`,
    //     `orders__items`.`discount_distributor`,
    //     `orders__items`.`units`,
    //     `orders__items`.`is_free`
    //     FROM
    //     `orders__items`
    //     INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
    //     where `orders__items`.`order_token`='$order_id' AND `orders__items`.`delete_status`='1' ORDER BY `products`.`name`, `orders__items`.`is_free` ASC");
    //      $slno=0;
    //     while($row = mysqli_fetch_array($query)){
    //             $slno++;
    //             $sgstAmt = number_format($row["offer_amount"]/1.18*0.18/2, 2, '.', '');
    //             $basic_total=number_format($row["offer_amount"]/1.18, 2, '.', '');
    //             $html .= '<tr>
    //                     <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$slno.'</td>
    //                     <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">'.$row["product_name"].'</td>';
    //                     if($row["is_free"] != '1'){
    //             $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$row["price_per_unit"].'</td>';           
    //                     }else{
    //             $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>';            
    //                     }
    //             $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$row["quantity"].' Box</td>';
    //                     if($row["is_free"] != '1'){
    //            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($basic_total).'</span></td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$row["offer_percentage"].'%</td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($sgstAmt).'</span></td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($sgstAmt).'</span></td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($row["offer_amount"]).'</span></td>';               
    //                     }else{
    //            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
    //                      <td style="border: 1px solid #ccc;padding: 8px 10px;">Free</td>';               
    //                     }
    //            $html .= '</tr>';

    //         $basicRate_total += $basic_total;
    //         $gst_total_amount += $sgstAmt;
    //         $total_final_amount += $row["offer_amount"];
    //      }
    //      if($total_tcs > 5000000){
    //         $total_tcs_amount =  ($total_final_amount)/1000;
    //         $total_final_amount = $total_final_amount+$total_tcs_amount;
    //     }
    //     $numbertoWord = numbertoword(round($total_final_amount));
    //     $html .= '<tr>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;"></th>
    //                 <th style="border: 1px solid #ccc;padding: 8px 10px;">Sub Total</th>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($basicRate_total).'</span></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($gst_total_amount).'</span></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($gst_total_amount).'</span></td>
    //                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.indCurrencyFormatComma($total_final_amount).'</span></td>
    //             </tr>
    //     </tbody>
    //         </table>
    //         <table style="width: 100%;font-size: 12px;line-height: 20px;text-align: right;">
    //             <tr>
    //                 <th style="text-align: left;width:50%;" colspan="4">Basic Rate after discount before tax</th>
    //                 <th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>'.indCurrencyFormatComma($basicRate_total).'</span></span></th>
    //             </tr>
    //             <tr>
    // <th style="text-align: left;width:50%;" colspan="4"><b>TCS Total</b></th>
    // <th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>'.indCurrencyFormatComma(round($total_tcs_amount)).'</span></span></th>
    // </tr>
    //     <tr>
    //     <th style="text-align: left;width:50%;" colspan="4"><b>Grand Total</b></th>
    //     <th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>'.indCurrencyFormatComma(round($total_final_amount)).'</span></span></th>
    // </tr>
    // </table>
    // <table style="width: 100%;font-size: 12px;line-height: 44px;text-align: right;">
    //             <tr>
    //                 <td  colspan="8" style="text-align: left;width:100%;"><b>Amount In Words</b> : <span>'.$numbertoWord.'</span></td>
    //             </tr>
    //             <tr>
    //                 <th style="text-align: left;padding-top: 30px;" >Signature</th>
    //             </tr>
    //         </table>

    //         </td>
    //         </tr>
    //         </table>
    //     </body>
    //     </html>';

} else if ($state == 'KARAIKAL') {
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>

        </style>
    </head>
    <body>
    
    <table border="0" style="table-layout:fixed;width: 580px;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table style="table-layout:fixed;width: 100%;height:0;margin:0;padding:0;">
            <tr cellpadding="0"
       cellspacing="0" style="margin:0;padding:0;">
                <td style="display: block;width: 50%;text-align: left;margin:0;padding:0;">
                <table style="width: 100%;">
                <tr>
                    <td><img src="' . $baseUrlPath . 'admin_dashboard/assets/logo.png" alt="logo" style="width: 150px;object-fit: contain;"></td>
                </tr>
                 <tr>
                 <td style="display: block;width: 100%;text-align: left;min-width: 200px;font-size: 10px;line-height: 16px;margin:0;padding:0;"><span style="font-size: 12px;font-weight:700;">Praveen Chem Industry</span><br/>No 76/12,Keelavanjur Nagore,<br/> Karaikal-609602 <br/><b style="width: 100px;">GSTIN </b>: <span>34AAEFP7684H1ZW</span> </td>                </tr>
                </table>
                </td>
                <td style="display: block;width: 50%;text-align: right;">
                <br/><br/><br/>
                <table style="width: 100%;line-height:1px;">
                <tr>
                <td style="font-size: 10px;line-height: 19px;width: 100%;margin:0;padding:0;"><b style="width: 100px;font-size: 12px;display: inline-block;">Estimate No </b>: <span>' . $order_id . '</span><br/><b style="width: 100px;font-size: 12px;display: inline-block;" >Date </b>: <span>' . $indiaDateFormat . '</span></td>
                 </tr>
                </table>
               </td>
            </tr>
            <tr cellpadding="0"
       cellspacing="0" style="margin:0;padding:0;">
                <td style="display: block;width: 50%;text-align: left;">
                <table style="width: 100%;">
                <tr>
                    <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">BILL TO</b><br/>' . $dist_address . '<span style="display: block;"><br>Ph :' . $dist_mobile_number . '</span><br/><b style="width: 100px;">GSTIN </b>: <span>' . $license_number . '</span></td>
                </tr>
                </table>
               </td>
            </tr>  
        </table>

        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 10px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:30px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:160px;text-align:center;"><b>Item Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Price</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>Qty<br/>Box/Bags</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Basic Rate</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:40px;text-align:center;"><b>Offer</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>GST 18%</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Amt</b></th>
            </tr>
        </thead>
    <tbody>';
    $query = mysqli_query($link, "SELECT
    `orders__items`.`order_token`,
    `products`.`name` AS `product_name`,
    `products`.`item_code` AS `item_codes`,
    `orders__items`.`price_per_unit`,
    `orders__items`.`piece_count`,
    `orders__items`.`misc_price`,
    `orders__items`.`quantity`,
    `orders__items`.`offer_percentage`,
    `orders__items`.`offer_amount`,
    `orders__items`.`discount_distributor`,
    `orders__items`.`units`,
    `orders__items`.`is_free`
    FROM
    `orders__items`
    INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
    where `orders__items`.`order_token`='$order_id' AND `orders__items`.`delete_status`='1'ORDER BY `products`.`name`, `orders__items`.`is_free` ASC");
    $slno = 0;
    while ($row = mysqli_fetch_array($query)) {
        $slno++;
        $offer_amount_incl = floatval($row["offer_amount"]);
        $basic_total_val = $offer_amount_incl / 1.18;
        $gstAmt_val = $basic_total_val * 0.18;
        $net_total_val = $basic_total_val + $gstAmt_val;

        $gstAmt = number_format($gstAmt_val, 2, '.', '');
        $basic_total = number_format($basic_total_val, 2, '.', '');
        $row["offer_amount"] = number_format($net_total_val, 2, '.', '');

        $html .= '<tr>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">' . $slno . '</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">' . $row["product_name"] . '</td>';
        if ($row["is_free"] != '1') {
            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">' . $row["price_per_unit"] . '</td>';
        } else {
            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>';
        }
        $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">' . $row["quantity"] . ' Box</td>';
        if ($row["is_free"] != '1') {
            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($basic_total) . '</span></td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">' . $row["offer_percentage"] . '%</td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($gstAmt) . '</span></td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($row["offer_amount"]) . '</span></td>';
        } else {
            $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">-</td>
                                 <td style="border: 1px solid #ccc;padding: 8px 10px;">Free</td>';
        }
        $html .= '</tr>';

        $basicRate_total += $basic_total;
        $gst_total_amount += $gstAmt;
        $total_final_amount += $row["offer_amount"];
    }
    if ($total_tcs > 5000000) {
        $total_tcs_amount =  ($total_final_amount) / 1000;
        $total_final_amount = $total_final_amount + $total_tcs_amount;
    }
    $numbertoWord = numbertoword(round($total_final_amount));
    $html .= '<tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;"></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;">Sub Total</th>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($basicRate_total) . '</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($gst_total_amount) . '</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>' . indCurrencyFormatComma($total_final_amount) . '</span></td>
            </tr>
    </tbody>
        </table>
        <table style="width: 100%;font-size: 12px;line-height: 28px;text-align: right;">
            <tr>
                <th style="text-align: left;width:50%;" colspan="4">Basic Rate after discount before tax</th>
                <th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>' . indCurrencyFormatComma($basicRate_total) . '</span></span></th>
            </tr>
            <tr>
<th style="text-align: left;width:50%;" colspan="4"><b>TCS Total</b></th>
<th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>' . indCurrencyFormatComma(round($total_tcs_amount)) . '</span></span></th>
</tr>
    <tr>
    <th style="text-align: left;width:50%;" colspan="4"><b>Grand Total</b></th>
    <th style="display: block;" colspan="8"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>' . indCurrencyFormatComma(round($total_final_amount)) . '</span></span></th>
</tr>
</table>
<table style="width: 100%;font-size: 12px;line-height: 44px;text-align: right;">
            <tr>
                <td  colspan="8" style="text-align: left;width:100%;"><b>Amount In Words</b> : <span>' . $numbertoWord . '</span></td>
            </tr>
            <tr>
                <th style="text-align: left;padding-top: 30px;" >Signature</th>
            </tr>
        </table>
         
        </td>
        </tr>
        </table>
    </body>
    </html>';
} else {
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
            .bold { font-weight: bold; }
        </style>
    </head>
    <body>
    
    <table border="0" style="table-layout:fixed;width: 100%;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table cellpadding="0" cellspacing="0" style="width: 100%; border: none; font-family: sans-serif; font-size: 8px; line-height: 10px; margin-bottom: 5px;">
            <tr>
                <td style="width: 50%; text-align: left;">' . $invoice_header_left . '</td>
                <td style="width: 50%; text-align: right; font-weight: bold;">' . $invoice_header_right . '</td>
            </tr>
        </table>
        
        <table cellpadding="4" cellspacing="0" style="table-layout:fixed;border-collapse: collapse;width: 100%;text-align: left;font-size: 8px;line-height: 12px;font-family: sans-serif;border: 1px solid #000;margin-bottom: 10px;">
            <tr>
                <td style="border: 1px solid #000; width: 73%; vertical-align: middle;">
                    <table style="width:100%; border:none;">
                        <tr>
                            <td style="border:none; width: 18%;"><img src="' . $baseUrlPath . 'admin_dashboard/assets/logo.png" style="width: 45px; object-fit: contain;"></td>
                            <td style="border:none; width: 82%; font-size: 8px; line-height: 10px;">
                                <b style="font-size: 10px; font-weight: bold; text-transform: uppercase;">Abirami Soap Works LLP</b><br/>
                                RS NO 93/2 1A 1B, EMBALAM MAIN ROAD, SEMBIAPALAYAM VILLAGE, KORKADU POST, PUDUCHERRY - 605110.<br/>
                                <b>GSTIN</b>: 34AAIFA1436C1Z3
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="border: 1px solid #000; width: 13.5%; text-align: center; vertical-align: top;">
                    <span style="color: #666; font-size: 7px;">' . $doc_number_label . '</span><br/><br/>
                    <b style="font-size: 9px;">' . $order_id . '</b>
                </td>
                <td style="border: 1px solid #000; width: 13.5%; text-align: center; vertical-align: top;">
                    <span style="color: #666; font-size: 7px;">Invoice Date</span><br/><br/>
                    <b style="font-size: 9px;">' . $indiaDateFormat . '</b>
                </td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; width: 73%; vertical-align: top; padding: 6px;">
                    <b>Billing Address:</b><br/>
                    <b style="font-size: 9px;">' . $dist_name . '</b><br/>
                    ' . $dist_address_multiline . '
                </td>
                <td colspan="2" style="border: 1px solid #000; width: 27%; vertical-align: top; line-height: 14px; font-size: 8px; padding: 6px;">
                    <b>Mobile Number</b> : ' . $dist_mobile_number . '<br/><br/>
                    <b>GSTIN/UIN</b> : <b>' . $license_number . '</b>
                </td>
            </tr>
        </table>

        <table cellpadding="3" style="table-layout:fixed;border-collapse: collapse;border: 1px solid #000;width: 100%;text-align: left;font-size: 8px;line-height: 16px;font-family: sans-serif;">
            <thead style="background: #f5f5f5;border: 1px solid #000;">
            <tr>
                <th style="border: 1px solid #000;padding: 4px;width:4%;text-align:center;"><b>Sno</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:22%;text-align:center;"><b>Product Description</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>MRP</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>HSN / SAC</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:5%;text-align:center;"><b>UoM</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>Kgs</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Box/Bags</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Unit Price</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Before Discount</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:7%;text-align:center;"><b>Discount</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>GST</b></th>
                <th style="border: 1px solid #000;padding: 4px;width:8%;text-align:center;"><b>Total</b></th>
            </tr>
        </thead>
    <tbody>';
    $query = mysqli_query($link, "SELECT
    `orders__items`.`order_token`,
    `products`.`name` AS `product_name`,
    `products`.`item_code` AS `item_codes`,
    `products`.`mrp`,
    `products`.`hsn_code`,
    `products`.`net_weight`,
    `products`.`gst`,
    `orders__items`.`price_per_unit`,
    `orders__items`.`piece_count`,
    `orders__items`.`misc_price`,
    `orders__items`.`quantity`,
    `orders__items`.`offer_percentage`,
    `orders__items`.`offer_amount`,
    `orders__items`.`discount_distributor`,
    `orders__items`.`units`,
    `orders__items`.`is_free`,
    `orders__items`.`is_discount_enable`,
    `orders__items`.`discount_value`
    FROM
    `orders__items`
    INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
    where `orders__items`.`order_token`='$order_id' AND `orders__items`.`delete_status`='1' ORDER BY `products`.`name`, `orders__items`.`is_free` ASC");
    $slno = 0;
    $totalTaxableValue = 0;
    $totalDiscountAmt = 0;
    $totalBeforeDisc = 0;
    $totalBags = 0;
    $totalKgs = 0;
    $gst_total_amount = 0;
    $total_final_amount = 0;

    while ($row = mysqli_fetch_array($query)) {
        $slno++;
        $gst_rate = isset($row['gst']) && $row['gst'] !== '' ? floatval($row['gst']) : 18;
        $gst_multiplier = 1 + ($gst_rate / 100);
        
        $qty = floatval($row['quantity']);
        $unit = $row['units'];
        $mrp = floatval($row['mrp']);
        
        if ($unit == "Box" && $row['is_free'] == '0') {
            $unitPriceIncl = intval($row['piece_count']) * floatval($row['price_per_unit']);
            $unitPriceTaxable = $unitPriceIncl / $gst_multiplier;
            $grossTaxable = $qty * $unitPriceTaxable;
            $bags = $qty;
        } else if ($unit == "Nos" && $row['is_free'] == '0') {
            $unitPriceIncl = floatval($row['price_per_unit']);
            $unitPriceTaxable = $unitPriceIncl / $gst_multiplier;
            $grossTaxable = $qty * $unitPriceTaxable;
            $bags = number_format($qty / (intval($row['piece_count']) > 0 ? intval($row['piece_count']) : 1), 2, '.', '');
        } else {
            $unitPriceIncl = 0;
            $unitPriceTaxable = 0;
            $grossTaxable = 0;
            $bags = 0;
        }

        // Calculate weight in Kgs
        $total_pieces = ($unit == "Box") ? ($qty * intval($row['piece_count'])) : $qty;
        $net_weight = isset($row['net_weight']) ? floatval($row['net_weight']) : 0;
        $row_kgs = ($total_pieces * $net_weight) / 1000;

        // Apply discount after removing GST
        $discount_pct = 0;
        if ($row["is_discount_enable"] == '1') {
            $discount_pct += floatval($row["discount_value"]);
        }
        if (isset($row["offer_percentage"]) && floatval($row["offer_percentage"]) > 0) {
            $discount_pct += floatval($row["offer_percentage"]);
        }
        $discValueRowTaxable = $grossTaxable * ($discount_pct / 100);
        
        $taxableValue = $grossTaxable - $discValueRowTaxable;
        $row_gst_amt = $taxableValue * ($gst_rate / 100);
        $netTotalRow = $taxableValue + $row_gst_amt;
        
        $beforeDiscCol = $grossTaxable;
        $discountCol = $discValueRowTaxable;
        $gstCol = $row_gst_amt;
        $totalCol = $netTotalRow;

        $totalBeforeDisc += $beforeDiscCol;
        $totalDiscountAmt += $discountCol;
        $gst_total_amount += $gstCol;
        $total_final_amount += $totalCol;

        $totalTaxableValue += $taxableValue;
        $totalBags += $bags;
        $totalKgs += $row_kgs;

        $html .= '<tr>
                    <td style="border: 1px solid #000;text-align:center;width:4%;">' . $slno . '</td>
                    <td style="border: 1px solid #000;text-align:left;padding-left:5px;width:22%;">' . $row["product_name"] . '</td>
                    <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($mrp, 2, '.', '') . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:8%;">' . $row["hsn_code"] . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:5%;">' . $unit . '</td>
                    <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($row_kgs, 2, '.', '') . '</td>
                    <td style="border: 1px solid #000;text-align:center;width:8%;">' . number_format($bags, 2, '.', '') . '</td>';
        if ($row["is_free"] != '1') {
            $html .= '<td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($unitPriceTaxable, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($beforeDiscCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:7%;">' . number_format($discountCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($gstCol, 2, '.', '') . '</td>
                      <td style="border: 1px solid #000;text-align:right;padding-right:5px;width:8%;">' . number_format($totalCol, 2, '.', '') . '</td>';
        } else {
            $html .= '<td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:7%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">-</td>
                      <td style="border: 1px solid #000;text-align:center;width:8%;">Free</td>';
        }
        $html .= '</tr>';
    }
    $basicRate_total = $totalTaxableValue;
    
    // Calculate GST amount (combined IGST in else branch)
    $gst_total_amount = $total_final_amount - $totalTaxableValue;
    
    // TCS calculation
    $total_tcs_amount = 0;
    if ($total_tcs > 5000000) {
        $total_tcs_amount = ($total_final_amount) / 1000;
    }
    
    $invoice_total_unrounded = $total_final_amount + $total_tcs_amount;
    $invoice_total_rounded = round($invoice_total_unrounded);
    $rounded_off = number_format($invoice_total_rounded - $invoice_total_unrounded, 2, '.', '');
    
    $gstWords = numbertoword(round($gst_total_amount));
    $tcsWords = $total_tcs_amount > 0 ? numbertoword(round($total_tcs_amount)) : "";
    $amountWords = numbertoword(round($invoice_total_rounded));
    
    $html .= '<tr>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000; padding: 4px; width: 4%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 22%;" class="bold">Total Amount [INR]</td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 7%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; width: 8%;"></td>
                <td style="border-top: 1px solid #000; border-bottom: 1px solid #000; border-right: 1px solid #000; padding: 4px; width: 5%;"></td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:7%;" class="bold">' . number_format($totalKgs, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:center;width:8%;" class="bold">' . number_format($totalBags, 2, '.', '') . '</td>
                <td style="border: 1px solid #000;padding: 4px;width:8%;"></td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($totalBeforeDisc, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:7%;" class="bold">' . number_format($totalDiscountAmt, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($gst_total_amount, 2, '.', '') . ' &nbsp;</td>
                <td style="border: 1px solid #000;padding: 4px;text-align:right;width:8%;" class="bold">' . number_format($total_final_amount, 2, '.', '') . ' &nbsp;</td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>GST Payable:</b> IGST (18%): Rs ' . number_format($gst_total_amount, 2, '.', '') . ' | <b>GST Payable in Words:</b> (INR) ' . $gstWords . ' Only
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; padding: 4px;">
                    TCS Tax
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; padding: 4px;">
                    ' . number_format($total_tcs_amount, 2, '.', '') . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>TCS Payable in Words:</b> (INR) ' . ($total_tcs_amount > 0 ? $tcsWords . ' Only' : '') . '
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; padding: 4px;">
                    Rounded Off
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; padding: 4px;">
                    ' . $rounded_off . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="9" style="border: 1px solid #000; vertical-align: top; padding: 4px;">
                    <b>Amount in Words:</b> (INR) ' . $amountWords . ' Only
                </td>
                <td colspan="2" style="border: 1px solid #000; font-weight: bold; text-align: left; background-color: #f5f5f5; padding: 4px;">
                    Invoice Total
                </td>
                <td style="border: 1px solid #000; text-align: right; font-weight: bold; background-color: #f5f5f5; padding: 4px;">
                    ' . indCurrencyFormatComma($invoice_total_rounded) . ' &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="12" style="border: 1px solid #000; padding: 4px;">
                    <b>Terms and Conditions:</b> Interest shall be levied @18% P.A if payment is not made within the credit period
                </td>
            </tr>
            <tr>
                <td colspan="8" style="border-left: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; vertical-align: bottom;">
                </td>
                <td colspan="4" style="border-right: 1px solid #000; border-bottom: 1px solid #000; padding: 4px; text-align: right; vertical-align: top; line-height: 12px;">
                    <span style="font-weight: bold;">For ABIRAMI SOAP WORKS LLP</span><br/><br/><br/><br/>
                    <span style="font-weight: bold; text-decoration: overline;">Authorized Signatory</span>
                </td>
            </tr>
    </tbody>
        </table>
        
        <table cellpadding="4" cellspacing="0" style="width: 100%; table-layout: fixed; border-top: 1px solid #000; font-family: sans-serif; font-size: 7px; line-height: 10px; margin-top: 15px;">
            <tr>
                <td style="width: 35%; text-align: left;">
                    Ph No: 0413-2266111 Email Id: puducherry@powersoaps.com
                </td>
                <td style="width: 30%; text-align: center; font-weight: bold;">
                    PROMOTIONAL ARTICLES PRICES ARE INCLUDED IN ABOVE RATE
                </td>
                <td style="width: 35%; text-align: right;">
                    LLP Identification No. : <b>AAG-9662</b> "It is registered with limited liability"
                </td>
            </tr>
            <tr>
                <td style="width: 50%; text-align: right;">
                    Page 1 of 1
                </td>
                <td style="width: 50%; text-align: left;">
                    E & O.E.
                </td>
            </tr>
        </table>
        
        </td>
        </tr>
        </table>
    </body>
    </html>';
}
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "invoice_" . $order_id . $stort_time . ".pdf";

$update_order = "UPDATE `orders` SET `invoice_name`='$fileName' WHERE `token`='$order_id'";
$obj = new stdClass();
if (mysqli_query($link, $update_order)) {
    $status = unlink($tcpf_file . $invoice_name);
    if ($status) {
        $obj->FileStatus = "File deleted successfully";
    } else {
        $obj->FileStatus = "Sorry!";
    }

    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Order Invoice Created Successfully";
} else {
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Order not Created";
}

echo json_encode($obj);
