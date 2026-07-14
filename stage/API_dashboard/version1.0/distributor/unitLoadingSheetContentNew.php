<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$order = new OrderList($db);
$selected_date = $input_data->selectedorder_date;
$order->date_value = date("Y-m-d", strtotime($selected_date));
$order->location_name = $input_data->location_name;
$loadFileNameShop = $input_data->loadFileNameShop;
$order_token = $input_data->order_token;
$shop_name =$input_data->shop_name;
$stmt1 = $order->unitShopListNew();
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
                        <p style="width: 100%;font-size: 16px;line-height: 24px;margin:0;padding:0;"><span><b>SHOP LIST - '.$input_data->location_name.'</b></span></p>
                </td>
            </tr> 
            <tr>
                <td style="width:75%;font-size: 16px;line-height: 24px;margin:0;padding:0;"></td>
                <td style="width:40%;text-align:right;font-size: 16px;line-height: 24px;margin:0;padding:0;"><b>DATE </b>: '.$input_data->selectedorder_date.'<span></span><br/>
                </td>
            </tr> 
        </table>
        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 12px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>Retailer Code</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>Date</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:200px;text-align:center;"><b>Retailer Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:70px;text-align:center;"><b>Discount</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:70px;text-align:center;"><b>Paid Amount</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:100px;text-align:center;"><b>Bill Amount</b></th>
            </tr>
            </thead>
                <tbody>';
            $slno = 0;
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $slno++;
            $dateValues = date("d/m/Y",strtotime($row["order_date"]));
            $discountAmt = ($row["bill_discount_amount"]+$row["percentage_value"]);
       $html.= '<tr>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$slno.'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">'.$row["order_number"].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$dateValues.'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$row["shop_name"].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$discountAmt.'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$row["paid_amount"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$row["billing_amount"].'</span></td>               
            </tr>';
        }
     $html.= '</tbody>
        </table>
        </td>
        </tr>
        </table>
    </body>
    </html>';
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "shopList_".$order_token.$stort_time.".pdf";
$update_order = "UPDATE `orders` SET `shop_list`='$fileName' WHERE `token`='$order_token'";
  $obj = new stdClass();
if(mysqli_query($link, $update_order)){
    if($loadFileNameShop != ""){
        $status = unlink($tcpf_file.$loadFileNameShop);
        if($status){  
            $obj->FileStatus = "File deleted successfully";    
        }else{  
            $obj->FileStatus = "Sorry!";    
        } 
    }
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Shop List Created Successfully";
    $obj->data = $fileName;
}else{
    $obj->status_code = 400;
    $obj->header = "Errror";
    $obj->message = "Shop List Not Created"; 
}
      
echo json_encode($obj);  
?>
