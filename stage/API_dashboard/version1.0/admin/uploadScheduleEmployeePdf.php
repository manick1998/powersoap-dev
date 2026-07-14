<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
$database = new Database();
$db = $database->getConnection();
$employee = new Employee($db);
$stateId = $_GET["state_id"];
if($stateId != '0'){
    $stateQuery = " AND `employees`.`state_id` IN ('".$stateId."')";
}else{
    $stateQuery = " ";
}
$employee->stateQuery  = $stateQuery;
$stmt1 = $employee->allScheduleListPdf();
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
                          <p style="width: 100%;font-size: 16px;line-height: 24px;margin:0;padding:0;"><br/><span><b>Schedule List</b></span><br/></p>
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
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:55px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:180px;text-align:center;"><b>Sales Rep Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:120px;text-align:center;"><b>Scheduled Date</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:120px;text-align:center;"><b>State</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:120px;text-align:center;"><b>Region</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:120px;text-align:center;"><b>Attendance</b></th>
            </tr>
            </thead>
                <tbody>';
            $slno = 0;
        while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
            $slno++;
       $html.= '<tr>
                <td style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;">'.$slno.'</td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;"><span style="display: block;">'.$row["salesRepName"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;"><span style="display: block;">'.$row["schedule_date"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;"><span style="display: block;">'.$row["state_name"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;"><span style="display: block;">'.$row["region_name"].'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;text-align:center;"><span style="display: block;color:'.($row["is_absent"] > 0 ? "red" : "green").';">'.($row["is_absent"] > 0 ? "Absent" : "Present").'</span></td>
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
$fileName   = "ScheduleList_".$stort_time.".pdf";
//$update_order = "SELECT `employees` from `employee_list`='$fileName'";
  $obj = new stdClass();
if($fileName){
    // if($loadFileNameEmployee!= ""){
    //     $status = unlink("/home/mastrnig/public_html/Pugazh/development/invoice_pdf/".$loadFileNameEmployee);
    //     if($status){  
    //         $obj->FileStatus = "File deleted successfully";    
    //     }else{  
    //         $obj->FileStatus = "Sorry!";    
    //     } 
    // }
    $obj->status_code = 200;
    $obj->header = "Success";
    $obj->message = "Schedule List Created Successfully";
    $obj->data = $fileName;
}else{
    $obj->status_code = 400;
    $obj->header = "Errror";
    $obj->message = "Schedule List Not Created"; 
}
      
echo json_encode($obj);  
?>
