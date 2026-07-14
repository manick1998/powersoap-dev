<?php
include_once "../../config.php";
$obj_com = new stdClass();
$input_data = getInputs();
$distributor_token = $input_data->distributor_token;
if($input_data->type == "all_schedule"){
    $schdSql = mysqli_query($link, "SELECT `units`.`token`,
        `units`.`name`,
        COUNT(`units__shop_mapping`.`id`) AS `shop_count`,
        COALESCE(`employees`.`name`,'Distributor') AS `distributor`
        FROM `units`
        LEFT JOIN `units__shop_mapping` ON (
            `units__shop_mapping`.`unit_group_token`=`units`.`token`
            AND `units__shop_mapping`.`delete_status`='1'
        )
        LEFT JOIN `shop` ON `shop`.`token`=`units__shop_mapping`.`shop_token`
        LEFT JOIN `employees` ON `units`.`distributor_token`=`employees`.`token`
        where `units__shop_mapping`.`distributor_token` = '$distributor_token'
		GROUP BY `units`.`token`
        ORDER BY `units`.`id` DESC");
    if(mysqli_num_rows($schdSql) > 0){
        $array = [];
        while($row = mysqli_fetch_array($schdSql)){
            $obj = new stdClass;
            $obj->unit_token      = $row['token'];
            $obj->unit_name       = $row['name'];
            $obj->shop_count = $row['shop_count'];
            $obj->distributor_name = $row['distributor'];
            $day  = date('l',strtotime($indiaDate));
            $token= $row['token'];
            $query1 = mysqli_query($link,"SELECT `daily_schedule`.`id`, 
            COALESCE(`salesman`.`name`,'-') AS `salesman`, 
            COALESCE(`delivery`.`name`,'-') AS `delivery_man`
            FROM `daily_schedule` 
			LEFT JOIN `employees` AS `salesman` ON `daily_schedule`.`sales_emp_token` = `salesman`.`token`
            LEFT JOIN `employees` AS `delivery` ON `daily_schedule`.`delivery_emp_token` = `delivery`.`token`
            WHERE `unit_token`='$token' 
            AND `schedule_date`='$day'
            AND (`sales_emp_token`!=''
            OR `delivery_emp_token`!='')");
            if(mysqli_num_rows($query1) == 0){
                $obj->salesman_name = '-';
                $obj->deliveryman_name = '-';
                $obj->status = 'Not scheduled';
            }else{
                $row1 = mysqli_fetch_assoc($query1);
                $obj->salesman_name = $row1["salesman"];
                $obj->deliveryman_name = $row1["delivery_man"];
                $obj->status = 'Scheduled'; 
            }
            array_push($array, $obj);
            $obj_com->status_code = 200; 
            $obj_com->message = 'Schedule Details';
            $obj_com->title = 'Success';
            $obj_com->data = $array;  
        }
    }else{
        $obj_com->status_code = 400; 
        $obj_com->message = 'No Schedule Details';
        $obj_com->title = 'Oops';
    }
}else if($input_data->type == "schedule_list"){
    $unit_token = $input_data->unit_token;
    $distributor_token = $input_data->distributor_token;
        $array = [];
        $sales_array = [];
        $deli_array = [];
        $startDay  = "Sunday";
        for($i=1;$i<=7;$i++){
            $nextDay  = date('l', strtotime($startDay . " +$i day"));
            $obj1 = new stdClass();
            $obj1->sl_no   = $i;
            $obj1->day_val = $nextDay;
            $schdSql = mysqli_query($link,"SELECT `sales_emp_token`,`delivery_emp_token` FROM `daily_schedule` WHERE `unit_token`='$unit_token' AND `schedule_date`='$nextDay' AND `distributor_token`='$distributor_token'");
            if(mysqli_num_rows($schdSql)==0){
                $obj1->sales_employee_token   = "";
                $obj1->delivery_employee_token= "";
            }else{
                $schRow = mysqli_fetch_array($schdSql);
                $obj1->sales_employee_token   = $schRow["sales_emp_token"];
                $obj1->delivery_employee_token= $schRow["delivery_emp_token"];
            }
            array_push($array,$obj1);
        }
        $salesSql = mysqli_query($link,"SELECT `token`,`name` FROM `employees` WHERE `deparment_token`='45916684' AND `admin_distributor_token`='$distributor_token'");
        if(mysqli_num_rows($salesSql) == 0){
            $salesData=[];
        }else{
            while($salesRow = mysqli_fetch_array($salesSql)){
                $obj = new stdClass;
                $obj->token      = $salesRow['token'];
                $obj->name       = $salesRow['name'];
                array_push($sales_array, $obj);
            }
        }
        $deliSql = mysqli_query($link,"SELECT `token`,`name` FROM `employees` WHERE `deparment_token`='93402780' AND `admin_distributor_token`='$distributor_token'");
        if(mysqli_num_rows($deliSql) == 0){
            $deiveryData=[];
        }else{
            while($deliRow = mysqli_fetch_array($deliSql)){
                $obj = new stdClass;
                $obj->token      = $deliRow['token'];
                $obj->name       = $deliRow['name'];
                array_push($deli_array, $obj);
            }
        }
        $obj_com->status_code = 200; 
        $obj_com->message     = 'Single Unit Schedule Details';
        $obj_com->title       = 'Success';
        $obj_com->data        = $array;
        $obj_com->salesData   = $sales_array;
        $obj_com->deliveryData= $deli_array;
}else if($input_data->type == "save_schedule"){
    $checkarrayCount = 0;
    $salesmanExistArray = [];
    $DelivertExistArray = [];
    $unit_token = $input_data->unit_token;
    $array = $input_data->update_array;
    foreach($array as $value){
        $day = $value->day_val; 
        $saleEmployee = $value->sales_employee_token; 
        $deliveryEmployee = $value->delivery_employee_token;
        $checkSalesmanAssign = mysqli_query($link,"SELECT `daily_schedule`.`unit_token`, `daily_schedule`.`distributor_token`, `schedule_date`, `units`.`name` AS `unit_name`,`sales_emp_token`,`employees`.`name` AS `employee_name`
        FROM `daily_schedule` 
        INNER JOIN `units__shop_mapping` ON `daily_schedule`.`distributor_token`=`units__shop_mapping`.`distributor_token`
        INNER JOIN `units` ON `daily_schedule`.`unit_token` = `units`.`token` 
        INNER JOIN `employees` ON `daily_schedule`.`sales_emp_token`=`employees`.`token`
        where `daily_schedule`.`distributor_token`='$distributor_token' AND `daily_schedule`.`schedule_date`='$day' AND `sales_emp_token`='$saleEmployee' AND `daily_schedule`.`unit_token` !='$unit_token' GROUP BY `daily_schedule`.`unit_token`");
        
        $checkDeliveryAssign = mysqli_query($link,"SELECT `daily_schedule`.`unit_token`, `daily_schedule`.`distributor_token`, `schedule_date`, `units`.`name` AS `unit_name`, `delivery_emp_token`,`employees`.`name` AS `employee_name` 
        FROM `daily_schedule` 
        INNER JOIN `units__shop_mapping` ON `daily_schedule`.`distributor_token`=`units__shop_mapping`.`distributor_token`
        INNER JOIN `units` ON `daily_schedule`.`unit_token` = `units`.`token`
        INNER JOIN `employees` ON `daily_schedule`.`delivery_emp_token`=`employees`.`token`
        where `daily_schedule`.`distributor_token`='$distributor_token' AND `daily_schedule`.`schedule_date`='$day' AND `delivery_emp_token`='$deliveryEmployee' AND `daily_schedule`.`unit_token` !='$unit_token' GROUP BY `daily_schedule`.`unit_token`");
        $checkCountSales = mysqli_num_rows($checkSalesmanAssign);
        $checkCountDelivery = mysqli_num_rows($checkDeliveryAssign);
        if($checkCountSales == 0 && $checkCountDelivery == 0){
            $checkarrayCount++;
            $dailyScheduleCheck = mysqli_query($link,"SELECT `id` FROM `daily_schedule` WHERE `unit_token`='$unit_token' AND `schedule_date`='$day' AND `distributor_token`='$distributor_token'");
            if(mysqli_num_rows($dailyScheduleCheck) == 0){
                $insertDailySchedule = mysqli_query($link,"INSERT INTO 
                `daily_schedule` SET `unit_token`='$unit_token',
                `distributor_token`='$distributor_token',
                `sales_emp_token`='$saleEmployee',
                `delivery_emp_token`='$deliveryEmployee',
                `schedule_date`='$day',
                `date_time`='$indiaDateTime'");
            }else{
                $updateDailySchedule = mysqli_query($link,"UPDATE `daily_schedule` SET
                `sales_emp_token`='$saleEmployee',
                `delivery_emp_token`='$deliveryEmployee'
                WHERE `schedule_date`='$day' 
                AND `unit_token`='$unit_token' AND `distributor_token`='$distributor_token'");
            }
            if(count($array) == $checkarrayCount){
                $obj_com->status_code = 200; 
                $obj_com->message = 'Schedule Details';
                $obj_com->title = 'Success'; 
            }
        }else{
           if($checkCountSales != 0){
                while($salesRow = mysqli_fetch_array($checkSalesmanAssign)){
                    $assign_unit = $salesRow['employee_name']." already assigned in ".$salesRow['unit_name']." unit on ".$salesRow['schedule_date'];
                    array_push($salesmanExistArray, $assign_unit);
                }  
           }
           if($checkCountDelivery != 0){
                while ($delRow = mysqli_fetch_array($checkDeliveryAssign)) {
                    $assign_unit = $delRow['employee_name']." already assigned in ".$delRow['unit_name']." unit on ".$delRow['schedule_date'];
                    array_push($DelivertExistArray, $assign_unit);
                } 
           }
         $employee_data =  array_merge($salesmanExistArray,$DelivertExistArray);
         $employee_assign_data = implode(" ,",$employee_data); 
         $obj_com->status_code = 400; 
         $obj_com->message = 'Already Employee Assign Details';
         $obj_com->title = 'Oops'; 
         $obj_com->employee_data = $employee_assign_data;
        }
    }
}
echo json_encode($obj_com);
?>