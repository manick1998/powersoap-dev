<?php
include "../../config.php";
$json_input = getInputs();
$sales_rep_token = $json_input->sales_rep_token;
$obj = new stdclass;
$sql1 = mysqli_query($link,"SELECT 
DISTINCT DATE_FORMAT(`start_date`,'%M - %Y') as `leave_month`,
group_concat(CONCAT(DATE_FORMAT(`start_date`,'%d %M'),'&&&&',DATE_FORMAT(`end_date`,'%d %M'),'&&&&',`reason`),'****') as `leave_dates`
FROM `sales_rep__leave` 
WHERE `sales_rep_token` = '$sales_rep_token'
GROUP BY DATE_FORMAT(`start_date`, '%M - %Y')");
$leave_data = [];
while($row = mysqli_fetch_array($sql1)){
    $obj1 = new stdclass;
    $obj1->month = $row["leave_month"];
    $leave_string  = rtrim($row["leave_dates"],'****');
    $leave_details = explode("****,",$leave_string);
    $details      = [];
    foreach($leave_details as $leaveData){
        $lea_data = explode("&&&&",$leaveData);
        $obj2 = new stdClass();
        $obj2->start_data   = $lea_data[0];
        $obj2->end_data     = $lea_data[1];
        $obj2->reason_detail= $lea_data[2];
        array_push($details, $obj2);
    }
    $obj1->list = $details;
    array_push($leave_data,$obj1);
}
$obj = new stdclass;
		if($leave_data) {
        $obj->status_code=200; 
        $obj->message='data successfully';
        $obj->title='Success';
        $obj->leave_data = $leave_data;
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
    }


echo json_encode($obj);  
?>