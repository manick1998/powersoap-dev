<?php
include "../../config.php";
$json_input = getInputs();
$current = $indiaDate;
$sales_rep_token = $json_input->sales_rep_token;
$data = array();
$overallRegion = mysqli_query($link,"SELECT
`region_token`,
`region_name`
FROM
`schedule_sales_rep`
INNER JOIN `region` ON `schedule_sales_rep`.`region_token` = `region`.`token`
WHERE
`schedule_sales_rep`.`sales_rep_token` = '$sales_rep_token' AND `schedule_sales_rep`.`schedule_date` = '$current'");
   $regionList = mysqli_fetch_array($overallRegion);
    $obj = new stdClass;
    $obj->token = $regionList['region_token'];
    $obj->region_name = $regionList['region_name'];
  
$regiontoken = $obj->token;
$area = array();
$overallArea=mysqli_query($link,"SELECT
`area_token`,
`area_name`
FROM
`area` where `region_token`='$regiontoken'");
while($areaList = mysqli_fetch_array($overallArea)){
    $obj2 = new stdClass;
     $obj2->area_token = $areaList['area_token'];
     $obj2->area_name = $areaList['area_name'];
     array_push($area,$obj2);
}
$distributor =array();
$overalldistributor=mysqli_query($link,"SELECT
`area_token`,
`token` ,
`name`
FROM
`employees`
WHERE
`deparment_token` = 18028120 AND `region_id`='$regiontoken' AND `block_status`='1'");
while($distributorList = mysqli_fetch_array($overalldistributor)) {
    $obj3 = new stdClass;
     $obj3->area_token = $distributorList['area_token'];
     $obj3->token = $distributorList['token'];
     $obj3->name = $distributorList['name'];
     array_push($distributor,$obj3);
}
$obj1=new stdclass;
$obj1->region = $obj;
$obj1->area = $area;
$obj1->distributor=$distributor;
array_push($data,$obj1);
$obj_final = new stdClass;
if($data){
    $obj_final->status_code=200; 
    $obj_final->message='overalldata';
    $obj_final->title='Success';
    $obj_final->data = $data;
    
} else {
    $obj_final->status_code=400; 
    $obj_final->message='error';
    $obj_final->title='failure';
    
}



    echo json_encode($obj_final);

?>