<?php
include "../../config.php";
$json_input = getInputs();
$current =$indiaDate;
$previous =date('Y-m-d', strtotime("-1 days"));
$sales_rep_token = $json_input->sales_rep_token;
$obj = new stdclass;
$total=0;
$sql = mysqli_query($link,"SET SESSION group_concat_max_len = 1000000");
$sql1 = mysqli_query($link,"SELECT DISTINCT
DATE_FORMAT(
    `sales_rep__expense__details`.`date_time`,
    '%M - %Y'
) AS `expense_month`,
SUM(
    `sales_rep__expense__details`.amount
) AS total,
GROUP_CONCAT(
    CONCAT(
        `sales_rep__expense__details`.`token`,
        '&&&&',
        DATE(
            `sales_rep__expense__details`.`date_time`
        ),
        '&&&&',
        DATE_FORMAT(
            `sales_rep__expense__details`.`date_time`,
            '%d %M'
        ),
        '&&&&',
        `allowance`.`allowane_type`,
        '&&&&',
        `allowance`.`token`,
        '&&&&',
        `sales_rep__expense__details`.`amount`,
        '&&&&',
        `sales_rep__expense__details`.`image`
    ),
    '****'
) AS `expense_data`
FROM
`sales_rep__expense__details`
INNER JOIN `allowance` ON `sales_rep__expense__details`.`category_token` = `allowance`.`token`
WHERE
`sales_rep__expense__details`.`sales_rep__token` = '$sales_rep_token' AND(
    DATE(
        `sales_rep__expense__details`.`date_time`
    ) BETWEEN '$previous' AND '$current'
) AND `sales_rep__expense__details`.`status` = '1' AND `sales_rep__expense__details`.`amount` IS NOT NULL");
$expens_data = [];
while($row = mysqli_fetch_array($sql1)){
    $obj1 = new stdclass;
    $obj1->month = $row["expense_month"]==""?"":$row["expense_month"];
    $expense_string  = rtrim($row["expense_data"],'****');
    $expense_details = explode("****,",$expense_string);
    $details      = [];
    $image=[];
    
    foreach($expense_details as $expenseData){
        $expense_data = explode("&&&&",$expenseData);
        $obj2 = new stdClass();
        $obj2->token   = $expense_data[0];
        $obj2->current_date   = $expense_data[1]==$current?"true":"false";
        $obj2->date_time   = $expense_data[2]==""?"":$expense_data[2];
        $obj2->category_module     = $expense_data[3]==""?"":$expense_data[3];
        $obj2->category_token    = $expense_data[4]==""?"":$expense_data[4];
        $obj2->amount = $expense_data[5]==""?0:$expense_data[5];
        $obj2->image= $expense_data[6];
        $image = explode(",",$obj2->image);
        $obj2->image = $image;
        array_push($details, $obj2);
    }
    $obj1->list = $details;
    if($obj1->month == ""){
        //nothing do..
    }else{
        array_push($expens_data,$obj1);
    }
    
    $obj3=new stdclass;
    $total_data = $row["total"];
    $total += $total_data;
    $obj3->total = $total;
}

$obj3->dataList = $expens_data;
    if(mysqli_num_rows($sql1) > 0){
        $obj->status_code=200; 
        $obj->message='Expense List';
        $obj->title='Success';
        $obj->data = $obj3;//$obj3==''?[]:$obj3;
    }
    else {
        $obj->status_code=400; 
        $obj->message='error';
        $obj->title='error';
        $obj->data = [];
    }


echo json_encode($obj);  
?>