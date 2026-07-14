<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$order = new OrderList($db);
//$order_id = $input_data->order_id;
$order->order_id = $order_id;
$order->token = $order_id;
$order->shop_token = $stmt->shop_token;
$stmt = $order->salesOrderInvoice();
$html = "";
$html = '<!DOCTYPE html>
    <html lang="en">
    <style>
    td {
        vertical-align: center;
    }
    
    </style>
    <head>
        <meta charset="UTF-8">
    </head>
<body>
<div style="width: 1000px;margin: 0 auto;table-layout: fixed;">
    <table cellpadding="8" cellspacing="0" style="border-collapse: collapse;width: 100%;border:2px solid #000;text-align: left;background-color: #fff;font-size: 12px; font-family: sans-serif;vertical-align: center;">
        <tr>
            <td colspan="8" style="border: 1px solid #000;font-size: 12px;margin: 0;white-space: nowrap;"><b>' . $stmt->distributor_name . '</b><br/>
                <span>' . $stmt->distributor_address . '</span><br><span><b>GSTIN:</b>' . $stmt->distributor_license . '</span>
            </td>
            <td colspan="8" style="border: 1px solid #000;font-size: 12px;margin: 0;white-space: nowrap;"><span><b>Tax Invoice</b></span><br/>
                <span><b>Phone no :</b> ' . $stmt->shop_mobile_number . '<br/><b>Email :</b> ' . $stmt->email . '</span>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="border: 1px solid #000;font-size: 12px;margin: 0;white-space: nowrap;"><span><b>Buyer :</b>' . $stmt->shop_name . '</span><br/>
                <span>' . $stmt->shop_address . '<br/><b>BT :</b> ' . $stmt->unit_name . '<br/><b>GSTIN:</b> ' . $stmt->shop_license_number . ' <b style="text-align:right"> Phone no :</b>  ' . $stmt->shop_mobile_number . '</span>
            </td>
            <td colspan="8" style="border: 1px solid #000;text-align: left;font-size: 12px;vertical-align: text-top;"><span><b>No. :</b> ' . $order_id . ' <br/><b>Date :</b> ' . $indiaDateFormat . '<br/></span>
            </td>
        </tr>

        <tr>
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">SI</th>
            
            <th colspan="3" style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Goods Description</th>
            
            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">HSN </th>
            
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">MRP</th>
            
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Qty</th>

            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Rate <br/>(Bf.Tax)</th>
            
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Disc.</th>

            <th style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Tax</th>
            
            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;">Net Rate</th>
            
            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;margin: 0;color:#000;white-space: nowrap;">Net Amount</th>
            
        </tr>';
$stmt1 = $order->individualShopOrder();
$slno = 0;
$netRate = '';
$ob = new stdClass();
while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $totalAmtAfterDisc = 0;
    $sgst_amount = 0;
    $discounted = 0;
    $slno++;
    if ($row['units'] == "Box" && $row['is_free'] == '0') {
        if ($row["is_discount_enable"] == '1') {
            $itemtotalamount = $row['quantity'] * $row['piece_count'] * $row['price_per_unit'];
            $discounted = number_format($itemtotalamount * $row["discount_value"] / 100, 2, '.', '');
            $totalAmtAfterDisc = number_format($itemtotalamount - $discounted, 2, '.', '');
            $dicount_total_value += $discounted;
        } else {
            $totalAmtAfterDisc = number_format($row['quantity'] * $row['piece_count'] * $row['price_per_unit'], 2, '.', '');
        }
    } else if ($row['units'] == "Nos" && $row['is_free'] == '0') {
        if ($row["is_discount_enable"] == '1') {
            $itemtotalamount  = $row['quantity'] * $row['price_per_unit'];
            $discounted = numbwer_format($itemtotalamount * $row["discount_value"] / 100, 2, '.', '');
            $totalAmtAfterDisc = number_format($itemtotalamount - $discounted, 2, '.', '');
            $dicount_total_value += $discounted;
        } else {
            $totalAmtAfterDisc  = number_format($row['quantity'] * $row['price_per_unit'], 2, '.', '');
        }
    }
    $netRate = $totalAmtAfterDisc;
    $hsnCode = $row['hsn_code'];
    $totalNetRate =  number_format($netRate, 2, '.', '');
    $html .= '<tr style="vertical-align: center;">
                <td style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $slno . '</td>
                
                <td colspan="3" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $row['name'] . '</td>
                
                <td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $row['hsn_code'] . '</td>
                
                <td style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $row['mrp'] . '</td>
                
                <td style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $row['quantity'] . $row['units'] . '</td>';
    if ($row['is_free'] == '0') {
        $html .= '<td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . round($row['price_per_unit'] / 1.18) . '</td>

                    <td style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . indCurrencyFormatComma($discounted) . '</td>

                    <td style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">18%</td>


                    <td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">' . $row['price_per_unit'] . '</td>';
        if ($row['units'] == "Box") {
            $totalBox += $row['quantity'];
            $html .= '<td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;text-align: right;">' . indCurrencyFormatComma($totalAmtAfterDisc) . '</td>';
        } else {
            $totalPcs += $row['quantity'];
            $html .= '<td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;text-align: right;">' . indCurrencyFormatComma($totalAmtAfterDisc) . '</td>';
        }
    } else {
        $html .= '<td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>

                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">-</td>
                <td style="border: 1px solid #000;margin: 0;padding:0 15px;">Free</td>';
        if ($row['units'] == "Box") {
            $totalBox += $row['quantity'];
        } else {
            $totalPcs += $row['quantity'];
        }
    }
    $newTotalAmount += $totalAmtAfterDisc;
    $newSgstAmount +=  $sgst_amount;
    $html .= '</tr>';
    if (!property_exists($ob, $hsnCode)) {
        $ob->$hsnCode  = $totalNetRate;
    } else {
        $ob->$hsnCode = $ob->$hsnCode +  $totalNetRate;
    }
}

$html .= '<tr>
            <td style="padding: 10px;border-top: 1px solid #000;border-right: 1px solid #000;border-left: 1px solid #000;"></td>
            <td colspan="4" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">SUB TOTAL</td>
            
            <td colspan="9" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;text-align: right;"><span style="padding-top: 5px;border-top:2px solid #000;"><b>' . indCurrencyFormatComma($newTotalAmount) . '</b></span></td>
        </tr>';
$html .= '<tr>
            <td style="padding: 12px;border-right: 1px solid #000;border-left: 1px solid #000;"> </td>
            <td colspan="4" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;">ROUNDED-OFF</td>
            <td colspan="9" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="2" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;text-align: right;">' . indCurrencyFormatComma(round($newTotalAmount)) . '</td>
        </tr>';
$html .= '<tr>
            <th style="padding: 12px;text-align: center;border-right: 1px solid #000;border-left: 1px solid #000;"></th>
            <th colspan="2" style="padding: 12px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">HSN</th>
            <th style="padding: 12px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">GST</th>
            <th colspan="2" style="padding: 12px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">TXBL.AMT</th>
            <th colspan="3" style="padding: 12px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">CGST</th>
            <th colspan="3" style="padding: 12px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">SGST</th>
            <th colspan="4" style="padding: 12px;text-align: center;border:1px solid #000;"></th>
        </tr>';
foreach ($ob as $key => $obj) {
    $html .= '<tr>
            <td style="padding: 10px;border-right: 1px solid #000;border-left: 1px solid #000;"></td>
            <td colspan="2" style="padding: 10px 0;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
            ' . $key . '
            </td>
            <td style="padding: 10px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
                18%
            </td>
            <td colspan="2" style="padding: 10px 0;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
                ' . indCurrencyFormatComma(number_format($obj / 1.18, 2, '.', '')) . '
            </td>
            <td style="padding: 10px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
                9%
            </td>
            <td colspan="2" style="padding: 10px 0;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
            ' . number_format(($obj - ($obj / 1.18)) / 2, 2, '.', '') . '
            </td>
            <td style="padding: 10px;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
                9%
            </td>
            <td colspan="2" style="padding: 10px 0;text-align: center;border:1px solid #000;font-size: 8px;color:#333;">
            ' . number_format(($obj - ($obj / 1.18)) / 2, 2, '.', '') .  '
            </td>
            <td colspan="4" style="padding: 10px;border:1px solid #000;"></td>
        </tr>';
    $hsnTotal += $obj / 1.18;
    $gstTotal += number_format(($obj - ($obj / 1.18)) / 2, 2, '.', '');
}
$html .= '<tr>
            <td style="font-size: 8px;padding: 10px;border-top:2px solid #000;border-left:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"></td>
            <td colspan="3" style="font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;">TOTAL:</td>
            <td colspan="2" style="text-align: center;font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;">' . number_format(round($hsnTotal), 2, '.', '') . '</td>
            <td style="font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;"></td>
            <td colspan="2" style="text-align: center;font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;">' . $gstTotal . '</td>
            <td style="font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;"></td>
            <td colspan="2" style="text-align: center;font-size: 8px;padding: 10px;border-top:1px solid #000;border-bottom:1px solid #000;">' . $gstTotal . '</td>
            <td colspan="6" style="font-size: 8px;padding: 10px;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;"></td>
        </tr>';


$html .= '<tr>
            <td style="padding: 10px;border: 1px solid #000;"> </td>
            <td colspan="7" style="border: 1px solid #000;font-size: 8px;margin: 0;padding:0 15px;"></td>
            <td colspan="2" style="border: 1px solid #000;font-size: 10px;margin: 0;padding:0 15px;line-height: 22px;"><b>TOTAL :</b></td>';
if ($dicount_total_value == 0) {
    $roundTotal = round($newTotalAmount);
    $html .= '<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;margin: 0;padding:0 10px;"></td>';
    $html .= '<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>Rs: <span>' . $roundTotal . '</span></b></td>';
    $numbertoWord = numbertoword(round($roundTotal));
} else {
    $html .= '<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;margin: 0;padding:0 15px;"><b>Rs: <span>' . $dicount_total_value . '</span></b></td>';
    $html .= '<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>Rs: <span>' . round($newTotalAmount) . '</span></b></td>';
    $numbertoWord = numbertoword(round($roundtotalDiscountAmount));
}
$html .= '</tr>
        <tr>
            <td colspan="8" style="border-left: 1px solid #000;border-right: 1px solid #000;font-size: 8px;">' . $numbertoWord . '</td>
            <td colspan="8" style="border-right: 1px solid #000;"></td>
        </tr>
        <tr>
            <td colspan="8" style="font-size: 8px;line-height: 22px;margin: 0;padding:0;border-left: 1px solid #000;border-bottom: 1px solid #000;border-right: 1px solid #000;">Due : <span>' . $indiaDateFormat . '</span></td> 
            <td colspan="8" style="text-align: center;font-size: 8px;line-height: 22px;margin: 0;padding:0;border-right: 1px solid #000;border-bottom: 1px solid #000;"><br/><b>Signature</b></td>
        </tr>
    </table>
</div>
</body>
</html>';
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
