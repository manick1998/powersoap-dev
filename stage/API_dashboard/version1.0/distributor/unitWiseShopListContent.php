<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$retailer = new Retailer($db);
$unitToken = $input_data->unitToken;
$retailer->unit_token = $input_data->unitToken;
$retailer->distributor_token = $input_data->distributor_token;
$unitName = $input_data->unitName;
$stmt = $retailer->unitWiseRetailerList();
$sqlunit = "SELECT `unitWise_shopList` AS `unitWiseShopList` FROM `units` WHERE `token`='$unitToken'";
$getUnit1 = mysqli_query($link, $sqlunit);
$rowUnit = mysqli_fetch_assoc($getUnit1);
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>
        </style>
    </head>
    <body>
    <table border="0" style="border-collapse: collapse;table-layout:fixed;width: 630px;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table style="border-collapse: collapse;table-layout:fixed;width: 100%;height:0;margin:0;padding:0;">
            <tr>
                <td style="display: block;text-align: center;margin:0;padding:0;">
                        <p style="width: 100%;font-size: 14px;line-height: 24px;margin:0;padding:0;"><span><b>SHOP LIST'.$unitName.'</b></span></p>
                </td>
            </tr> 
            <tr>
                <td style="width:75%;font-size: 14px;line-height: 24px;margin:0;padding:0;"></td>
                <td style="width:40%;text-align:right;font-size: 14px;line-height: 24px;margin:0;padding:0;"><b>DATE: '.$indiaDateFormat.'</b> <span></span><br/>
                </td>
            </tr> 
        </table>
        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 10px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
            <th style="border: 1px solid #ccc;padding: 8px 10px;width:30px;text-align:center;"><b>Sno</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:64px;text-align:center;"><b>Retailer Code</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:85px;text-align:center;"><b>Retailer Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:75px;text-align:center;"><b>Type</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:80px;text-align:center;"><b>Unit Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:74px;text-align:center;"><b>Mobile Number</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:80px;text-align:center;"><b>Contact Person</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>Joining date</b></th>
                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>GST Number</b></th>
                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>Paid Amount</b></th>
                 <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>O/S Amount</b></th>
            </tr>
            </thead>
            <tbody>';
            $slno = 0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $slno++;
                $jnDAte = date("d/m/Y",strtotime($row['join_date']));
        $html .= '<tr>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$slno.'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['retail_code'].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['retailer_name'].'</td>         
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['shop_type'].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['unit_name'].'</td>'; 
        $html .= '<td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['mobile_number'].'</td>         
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['contact_person'].'</td>         
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$jnDAte.'</td>                 
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.$row['license_number'].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.round($row['paid_amount']).'</td>                 
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:45px;">'.round($row['outstanding_amount']).'</td>';
        $html .= '</tr>';
              }
    $html .= '</tbody>
        </table>
        </td>
        </tr>
        </table>
    </body>
    </html>';
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "unitWiseShopList_".$unitToken.$stort_time.".pdf";
$update_order = "UPDATE `units` SET `unitWise_shopList`='$fileName' WHERE `token`='$unitToken'";
  $obj = new stdClass();
if(mysqli_query($link, $update_order)){
    if($rowUnit["unitWiseShopList"] != ""){
        $status = file_exists($tcpf_file.$rowUnit["unitWiseShopList"]) ? unlink($tcpf_file.$rowUnit["unitWiseShopList"]) : true;
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
