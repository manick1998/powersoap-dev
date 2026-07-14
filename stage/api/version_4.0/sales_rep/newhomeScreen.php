<?php

include "../../config.php";
$json_input=getInputs();
$currentDate = $indiaDate;
$sales_rep_employee_token = $json_input->sales_rep_employee_token;

$data= array();

$sql = mysqli_query($link,"SELECT `rep_schedule_token` FROM `schedule_sales_rep` WHERE `sales_rep_token`='$sales_rep_employee_token' AND `schedule_date` = '$currentDate' AND `status`='1'");
$rep_schedule=mysqli_fetch_array($sql);
$schedule_token = $rep_schedule['rep_schedule_token'];


$sql1 = mysqli_query($link,"SELECT 
GROUP_CONCAT(DISTINCT concat( `employees`.`token`, '&&&&',`employees`.`name`,'&&&&'),'****')as distributor,
GROUP_CONCAT(DISTINCT `area`.`area_name`)as area,
`region`.`region_name`
FROM
`employees`
INNER JOIN `schedule_sales_rep` ON `schedule_sales_rep`.`distributor_token` = `employees`.`token`
INNER JOIN `area` ON `area`.`area_token` = `schedule_sales_rep`.`area_token`
INNER JOIN `shop` ON `shop`.`state_id`=`employees`.`state_id` AND shop.shop_type_code != 0
INNER JOIN `region` ON `region`.`token` = `employees`.`region_id`
INNER JOIN `shop_mapping` ON `shop_mapping`.`distributor_token` = `employees`.`token` 
WHERE
`schedule_sales_rep`.`sales_rep_token` = '$sales_rep_employee_token' AND `employees`.`deparment_token` = '18028120' AND `schedule_sales_rep`.`schedule_date` = '$currentDate' AND `schedule_sales_rep`.`status` = '1' AND shop_mapping.status = '1'");


		while($row1 = mysqli_fetch_array($sql1)){
			$distributor_obj = new stdClass;
            $distributor_obj->region_name = $row1['region_name']==null?"":$row['region_name'];
            $home_string  = rtrim($row1["distributor"],'****');
            $home_details = explode("****,",$home_string);
            $distributor = array();
           foreach($home_details as $home){
            $home_data = explode("&&&&",$home);
               $obj1=new stdclass();
               $obj1->distributor_token = $home_data[0];
               $obj1->distributor_name = $home_data[1]==null?"":$home_data[1]; 
                array_push($distributor,$obj1);
           }
			 $distributor_obj->distributor= $distributor;
		     $areas = $row1["area"];
             $areadata= explode(",", $areas);
             $area = implode(', ', $areadata);
             $distributor_obj->area = $area;
			 array_push($data,$distributor_obj);
		}

$obj = new stdClass;
		if($rep_schedule!="") {
        $obj->status_code=200; 
        $obj->message='data successfully';
        $obj->title='Success';
        $obj->data=$data;
    }
    else {
        $obj->status_code=200; 
        $obj->message='Today schedule not available';
        $obj->title='success';
        $obj->data=[];
    }


echo json_encode($obj);

?>