<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$inventory = new Inventory($db);
$stmt1 = $inventory->productListPdf();
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
                          <p style="width: 100%;font-size: 16px;line-height: 24px;margin:0;padding:0;"><br/><span><b>PRODUCT LIST</b></span><br/></p>
                </td>
            </tr> 
            <tr>
                <td style="width:75%;font-size: 16px;line-height: 24px;margin:0;padding:0;"></td>
                <td style="width:40%;text-align:right;font-size: 16px;line-height: 24px;margin:0;padding:0;"><b>DATE </b>: '.$indiaDateFormat.'<span></span><br/>
                </td>
            </tr> 
        </table>
        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 12px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:80px;text-align:center;"><b>Item Code</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:280px;text-align:center;"><b>Item Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:150px;text-align:center;"><b>Division</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>Net Price</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>MRP</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:50px;text-align:center;"><b>Box Pieces</b></th>
            </tr>
            </thead>
                <tbody>';
            $slno = 0;
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $slno++;
       $html.= '<tr>
                <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$slno.'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;">'.$row["item_code"].'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;">'.$row["name"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;text-align:center;">'.$row["type"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;text-align:center;">'.$row["total_cost"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;text-align:center;">'.$row["mrp"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;"><span style="display: block;text-align:center;">'.$row["piece_count"].'</span></td>                
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
$fileName   = "productList_".$stort_time.".pdf";
//$update_order = "SELECT `products` from `product_list`='$fileName'";
  $obj = new stdClass();
if($fileName){
    // if($loadFileNameProduct!= ""){
    //     $status = unlink("/home/mastrnig/public_html/Pugazh/development/invoice_pdf/".$loadFileNameProduct);
    //     if($status){  
    //         $obj->FileStatus = "File deleted successfully";    
    //     }else{  
    //         $obj->FileStatus = "Sorry!";    
    //     } 
    // }
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
