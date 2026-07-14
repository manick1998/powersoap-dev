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
DATE_FORMAT(`date_time`, '%M - %Y') AS `expense_month`,
SUM(amount) AS total,
GROUP_CONCAT(
    CONCAT(
        `token`,
        '&&&&',
        DATE(`date_time`),
        '&&&&',
        DATE_FORMAT(`date_time`, '%d %M'),
        '&&&&',
        `category_module`,
        '&&&&',
        `amount`,
        '&&&&',
        `image`
    ),
    '****'
) AS `expense_data`
FROM
`sales_rep__expense__details`
WHERE
`sales_rep__token` = '$sales_rep_token' AND(
    DATE(date_time) BETWEEN '$previous' AND '$current'
) AND `status` = '1' AND `amount` IS NOT NULL");
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
        $obj2->amount = $expense_data[4]==""?0:$expense_data[4];
        $obj2->image= $expense_data[5];
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