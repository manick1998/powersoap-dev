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
$stmt = $order->salesOrderInvoiceNew();
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
    </head>
<body>
    <table style="width: 100%;table-layout:fixed;height: auto;border-collapse: collapse;border: 1px solid #000;text-align: left;font-family: sans-serif;margin: 20px auto;">
        <tr style="width:100%;">
            <td colspan="4" style="border: 1px solid #000;"><b style="font-size: 10px;line-height: 24px;margin: 0;white-space: nowrap;">'.$stmt->distributor_name.'</b><br/>
                <span style="font-size: 10px;line-height: 22px;width: 100%;margin: 0;padding:0;"><b>'.$stmt->distributor_address.'</b> <br/><b>Phone no: '.$stmt->distributor_mobile_number.'</b> <br/><b>GSTIN: '.$stmt->distributor_license.'</b></span>
            </td>
            <td colspan="6" style="border: 1px solid #000;"><span style="font-size: 10px;line-height: 24px;margin: 0;white-space: nowrap;"><b>'.$stmt->shop_name.'</b></span><br/>
                <span style="font-size: 10px;line-height: 22px;width: 100%;margin: 0;padding:0;"><b>'.$stmt->shop_address.'</b> <br/><b>Phone no: '.$stmt->shop_mobile_number.'</b> <br/><b>GSTIN: '.$stmt->shop_license_number.'</b></span>
            </td>
             <td colspan="3" style="border: 1px solid #000;text-align: left;"><span style="margin: 0;font-size: 10px;"><b>TAX ESTIMATE</b></span>
                 <p style="font-size: 10px;"><b>No.</b>: <b>'.$order_id.'</b><br/><b>Date</b>: <b>'.$indiaDateFormat.'</b><br/><b>Mode</b>: <b> CREDIT/CASH</b><br/><b>BT</b>: <b>'.$stmt->unit_name.'</b></p>
            </td>
        </tr>

        <tr style="width:100%;">
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:30px;"><b>SI</b></th>
            
             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:200px;"><b>Goods Description</b></th>
             
             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;"><b>HSN Code</b></th>
             
             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;"><b>MRP</b></th>
             
             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;"><b>Qty</b></th>

             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:45px;"><b>Rate</b></th>
             
             <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:55px;"><b>Disc.</b></th>

            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:60px;"><b>CGST</b></th>
            
            <th colspan="2" style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;width:60px;"><b>SGST</b></th>
            
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;"><b>NetRate</b></th>
            
            <th style="border: 1px solid #000;text-align: center;font-size: 10px;line-height: 24px;margin: 0;"><b>Amount</b></th>
            
        </tr>';
              $stmt1 = $order->individualShopOrderDetail();
              $slno = 0;
              while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
              $totalAmtAfterDisc = 0;
              $sgst_amount = 0;      
              $discounted = 0;      
              $slno++;
              $gst_rate = isset($row['gst']) && $row['gst'] !== '' ? $row['gst'] : 0;
              $gst_multiplier = 1 + ($gst_rate / 100);
               if($row['units']=="Box" && $row['is_free'] == '0'){
                    if($row["is_discount_enable"] == '1'){
                        $itemtotalamount = $row['quantity']*$row['piece_count']*$row['price_per_unit'];
                        $discounted = number_format($itemtotalamount*$row["discount_value"]/100,2,'.','');
                        $totalAmtAfterDisc = number_format($itemtotalamount-$discounted,2,'.','');
                        $dicount_total_value += $discounted;
                        $gst_amount = $totalAmtAfterDisc / $gst_multiplier * ($gst_rate / 100);
                        $sgst_amount =  number_format($gst_amount/2,2,'.','');
                    }else{
                        $totalAmtAfterDisc = number_format($row['quantity']*$row['piece_count']*$row['price_per_unit'],2,'.','');
                        $gst_amount = $totalAmtAfterDisc / $gst_multiplier * ($gst_rate / 100);
                        $sgst_amount =  number_format($gst_amount/2,2,'.','');
                    }
                }else if($row['units']=="Nos" && $row['is_free'] == '0'){
                    if($row["is_discount_enable"] == '1'){
                        $itemtotalamount  = $row['quantity']*$row['price_per_unit'];
                        $discounted = number_format($itemtotalamount*$row["discount_value"]/100,2,'.','');
                        $totalAmtAfterDisc = number_format($itemtotalamount-$discounted,2,'.','');
                        $gst_amount = $totalAmtAfterDisc / $gst_multiplier * ($gst_rate / 100);
                        $sgst_amount =  number_format($gst_amount/2,2,'.','');
                        $dicount_total_value += $discounted;
                    }else{
                        $totalAmtAfterDisc  = number_format($row['quantity']*$row['price_per_unit'],2,'.','');
                        $gst_amount = $totalAmtAfterDisc / $gst_multiplier * ($gst_rate / 100);
                        $sgst_amount =  number_format($gst_amount/2,2,'.','');
                    }
                } 
                $netRate = $totalAmtAfterDisc / $gst_multiplier;
                $totalNetRate =  number_format($netRate,2,'.','');
      $html .='<tr style="width:100%;">
      
            <td style="border-right: 1px solid #000;border-left: 1px solid #000;font-size: 8px;line-height: 22px;;margin: 0;padding:0 15px;width:30px;">'.$slno.'</td>
            
            <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:200px;">'.$row['name'].'</td>
            
            <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$row['item_code'].'</td>
            
            <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$row['mrp'].'</td>
            
            <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$row['quantity'].$row['units'].'</td>';
            
//            <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$row['free_product'].'</td>';
            if($row['is_free'] == '0'){
                $html .='<td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:45px;">'.$row['price_per_unit'].'</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:55px;">'.indCurrencyFormatComma($discounted).'</td>

                
                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:40px;">'.indCurrencyFormatComma($sgst_amount).'</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:20px;">'.($gst_rate / 2).'%</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:40px;">'.indCurrencyFormatComma($sgst_amount).'</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:20px;">'.($gst_rate / 2).'%</td>


                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($totalNetRate).'</td>';      
                if($row['units']=="Box"){
                    $totalBox += $row['quantity'];
                    $html .='<td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($totalAmtAfterDisc).'</td>';
                }else{
                    $totalPcs += $row['quantity'];
                    $html .='<td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($totalAmtAfterDisc).'</td>';
                }
            }else{
                $html .='<td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:45px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:55px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:40px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:20px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:40px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;width:20px;">-</td>

                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">-</td>
                <td style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">Free</td>';
                 if($row['units']=="Box"){
                   $totalBox += $row['quantity']; 
                 }else{
                   $totalPcs += $row['quantity'];
                 }
            }
            $newTotalAmount += $totalAmtAfterDisc; 
            $newSgstAmount +=  $sgst_amount;    
       $html .='</tr>'; 
        }
             $discountPercent = $stmt->billing_amount*$stmt->bill_discount_percentage/100;
             $disc =  number_format($discountPercent/1.18,2,'.','');
 $html .='<tr>
            <td colspan="4" style="border-top: 1px solid #000;border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">DISCOUNT</td>';
//            if($stmt->bill_discount_percentage == 0){
//            $html .='<td colspan="6" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>';
//            }else{
//              $html .='<td colspan="6" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$stmt->bill_discount_percentage.'</td>';  
//            }
//            if($stmt->bill_discount_amount != 0){
//             $html .='<td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$stmt->bill_discount_amount.'</td>';   
//            }else if($stmt->bill_discount_percentage != 0){
//            $html .='<td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$disc.'</td>';  
//            }
    $html .='<td colspan="6" style="border-top: 1px solid #000;border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>
            <td colspan="6" style="border-top: 1px solid #000;border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($dicount_total_value).'</td>
        </tr>
        <tr>
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>TOTAL AMOUNT</b></td>
            
            <td colspan="6"  style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="4"  style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>'.indCurrencyFormatComma($newTotalAmount).'</b></td>
        </tr>
        <tr>
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">CGST</td>
             <td colspan="6" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($newSgstAmount).'</td>
        </tr>
        <tr>
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">SGST</td>
             <td colspan="6" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma($newSgstAmount).'</td>
        </tr>

        <tr>
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">ROUNDED-OFF</td>
             <td colspan="6" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"></td>
            
            <td colspan="4" style="border-right: 1px solid #000; border-left: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.indCurrencyFormatComma(round($newTotalAmount)).'</td>
        </tr>
         <tr>
            <td colspan="4" style="border: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>TOTAL</b></td>
            
            <td colspan="3" style="border: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>'.$totalBox.' BOX</b></td>
            
            <td colspan="3" style="border: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>'.$totalPcs.' PCS</b></td>';
            if($stmt->bill_discount_amount == 0 && $stmt->bill_discount_percentage == 0){
                 $roundTotal = round($newTotalAmount); 
                 $html .='<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>Rs: <span>'.$roundTotal.'</span></b></td>';
                 $numbertoWord = numbertoword(round($roundTotal)); 
            }else if($stmt->bill_discount_amount != 0){
                 $totalDiscountAmount = $stmt->billing_amount-$stmt->bill_discount_amount;
                 $roundtotalDiscountAmount = round($totalDiscountAmount);  
                 $html .='<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>Rs: <span>'.$roundtotalDiscountAmount.'</span></b></td>';
                 $numbertoWord = numbertoword(round($roundtotalDiscountAmount)); 
            }else if($stmt->bill_discount_percentage != 0){
                 $totalDiscountpercent = $stmt->billing_amount-$disc;
                 $roundTotalDiscountpercent = round($totalDiscountpercent);  
                 $html .='<td colspan="3" style="border: 1px solid #000;text-align: right;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;"><b>Rs: <span>'.$roundTotalDiscountpercent.'</span></b></td>';
                 $numbertoWord = numbertoword(round($roundTotalDiscountpercent));    
            }
$html .='</tr>
          <tr>
            <td colspan="7" style="border-right: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0 15px;">'.$numbertoWord.'</td>
            <td colspan="3"></td>
        </tr>
         <tr>
            <td colspan="3" style="font-size: 8px;line-height: 22px;margin: 0;padding:0;">Due : <span>'.$indiaDateFormat.'</span></td> 
            
            <td colspan="4" style="text-align: right;border-right: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0;">Party Signature</td>
            
            <td colspan="7" style="text-align: center;font-size: 8px;line-height: 22px;margin: 0;padding:0"><br/>Signature</td>
        </tr>
         <tr>
          <td colspan="13" style="width:100%;border: 1px solid #000;font-size: 8px;line-height: 22px;margin: 0;padding:0">Total pending collection amount is <span>'.indCurrencyFormatComma(round($oustanding_shop_amt)).'</span>.</td>   
         </tr>
    </table>
</body>
    </html>';
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "invoice_".$order_id.$stort_time.".pdf";
$update_order = "UPDATE `orders` SET `invoice_name`='$fileName' WHERE `token`='$order_id'";
   $obj = new stdClass();
if (mysqli_query($link, $update_order)) {
    $status = unlink($tcpf_file.$invoice_name);
    if($status){  
        $obj->FileStatus = "File deleted successfully";    
    }else{  
        $obj->FileStatus = "Sorry!";    
    }
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Order Invoice Created Successfully";
}else{
    $obj->status_code = 400;
    $obj->header = "Error";
    $obj->message = "Order not Created";
}
echo json_encode($obj);  
?>
