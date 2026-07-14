<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$selected_date = $input_data->selectedorder_date;
$employee->selectedDate = date("Y-m-d", strtotime($selected_date));
$employee->employee_token = $input_data->employee_token; 
$employee->shop_token=$input_data->shop_token;    
$order_id = $input_data->order_token;     
$distributor_name = $input_data->distributor_name;     
$loadFileName = $input_data->loadFileName;     
$stmt = $employee->orderLoadingSheetNew();

    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
        </style>
    </head>
    <body>
    <table border="0" style="border-collapse: collapse;table-layout:fixed;width: 580px;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table style="border-collapse: collapse;table-layout:fixed;width: 100%;height:0;margin:0;padding:0;">
            <tr>
                <td style="display: block;text-align: center;margin:0;padding:0;">
                        <p style="width: 100%;font-size: 16px;line-height: 24px;margin:0;padding:0;"><span><b>'.$distributor_name.'</b></span><br/><span><b>LOADING SHEET</b></span><br/><b>BILL DATE </b>: <span>'.$selected_date.'</span></p>
                </td>
            </tr> 
            <tr>
                <td style="width:75%;font-size: 16px;line-height: 24px;margin:0;padding:0;"></td>
                <td style="width:40%;text-align:right;font-size: 16px;line-height: 24px;margin:0;padding:0;"><b>DATE </b>: <span>'.$indiaDateFormat.'</span><br/>
                </td>
            </tr> 
        </table>
        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 12px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:200px;text-align:center;"><b>Products</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>MRP</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>Box / pieces</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;" colspan="2"><b>QTY</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>Value</b></th>
            </tr>
            </thead>
                <tbody>';
                    $slno = 0;
                     while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                     $slno++;
    $html .='<tr>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$slno.'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">'.$row['item_name'].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$row['retailer_price'].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$row['piece_count'].'/Box</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.floor($row['total_boxs']).' Box</span></td>';
                if($row['piece_count']>$row['total_quantity']){
                    $html .='<td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.round((float)$row['total_quantity'],0).' Nos</span></td>';               
                }else{
                    $html .='<td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.round((float)$row['total_pieces'],0).' Nos</span></td>';
                }
                $html .='<td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.round((float)$row['Prices'],2).'</span></td>
            </tr>'; 
        }
                  
                        
$html .='</tbody>
        </table>
        </td>
        </tr>
        </table>
    </body>
    </html>';
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "loadingSheet_".$order_id.$stort_time.".pdf";
$update_order = "UPDATE `orders` SET `product_list`='$fileName' WHERE `token`='$order_id'";
  $obj = new stdClass();
if(mysqli_query($link, $update_order)){
    if($loadFileName != ""){
        $status = unlink($tcpf_file.$loadFileName);
        if($status){  
            $obj->FileStatus = "File deleted successfully";    
        }else{  
            $obj->FileStatus = "Sorry!";    
        } 
    }
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Product List Created Successfully";
    $obj->data = $fileName;
}else{
    $obj->status_code = 400;
    $obj->header = "Errror";
    $obj->message = "Product List Not Created"; 
}
      
echo json_encode($obj);  
?>
