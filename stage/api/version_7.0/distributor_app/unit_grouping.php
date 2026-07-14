<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once "../../config.php";
$obj_com = new stdClass();
$input_data = getInputs();
$distributor_token = $input_data->distributor_token;
if($input_data->type == "all_unit"){
    $schdSql = mysqli_query($link, "SELECT `units`.`token`,
        `units`.`name`,
        COUNT(`units__shop_mapping`.`id`) AS `shop_count`,
        COALESCE(GROUP_CONCAT(`shop`.`name` ORDER BY `shop`.`id`),'') AS `shop_name`,
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
            $obj->shop_name  = $row['shop_name'];
            array_push($array, $obj); 
        }
        $obj_com->status_code = 200; 
        $obj_com->message = 'Unit Details';
        $obj_com->title = 'Success';
        $obj_com->data = $array; 
    }else{
        $obj_com->status_code = 400; 
        $obj_com->message = 'No Units Details';
        $obj_com->title = 'Oops';
    }
}else if($input_data->type == "shopList_without_unitMap"){
    $unitSql = mysqli_query($link, "SELECT `token`,`name` FROM `shop` WHERE `distributor_token`='$distributor_token' AND `unit_token`=''");
    if(mysqli_num_rows($unitSql) > 0){
        $shop_array = [];
        while($shop_row = mysqli_fetch_array($unitSql)){
            $obj_shop = new stdClass();
            $obj_shop->shop_token = $shop_row["token"];
            $obj_shop->shop_name = $shop_row["name"];
            array_push($shop_array, $obj_shop); 
        }
        $obj_com->status_code = 200; 
        $obj_com->message = 'shop List';
        $obj_com->title = 'Success';
        $obj_com->data = $shop_array;  
    }else{
        $obj_com->status_code = 400; 
        $obj_com->message = 'No Shop List';
        $obj_com->title = 'Oops';
    }
}else if($input_data->type == 'create_new_unit'){
    if($input_data->unit_name != '' && count($input_data->shop_tokens) > 0){
        $token      = genToken("token","units");
        $unitName   = $input_data->unit_name;
        $query = mysqli_query($link,"INSERT INTO `units` SET 
            `date_time`='$indiaDateTime',
            `token`='$token',
            `name`='$unitName',
            `distributor_token`='$distributor_token'");
        $shopTokens = $input_data->shop_tokens;
        $array = [];
        foreach($shopTokens as $shopToken){
            $query = mysqli_query($link,"SELECT `id` FROM `shop` WHERE `token`='$shopToken' AND `distributor_token`='$distributor_token' AND `unit_token`=''");
            if(mysqli_num_rows($query) == 1){
                $query = mysqli_query($link,"INSERT INTO `units__shop_mapping` SET `unit_group_token`='$token',
                `distributor_token`='$distributor_token',`shop_token`='$shopToken'");
                $query1 = mysqli_query($link,"UPDATE `shop` SET `unit_token`='$token' WHERE `token`='$shopToken' AND `distributor_token`='$distributor_token'");
                array_push($array,$shopToken);
            }
        }
       $obj_com->status_code = 200; 
       $obj_com->message = 'Unit created successfully';
       $obj_com->title = 'Success';
       $obj_com->data = $array; 
    }else{
       $obj_com->status_code = 400; 
       $obj_com->message = 'unit not created';
       $obj_com->title = 'Oops';
    }
}else if($input_data->type == 'shopList_withAndWithout_unitMap'){
    $unit_token   = $input_data->unit_token;
    $unitAddedSql = mysqli_query($link, "SELECT `shop`.`token`,`shop`.`name`,`shop`.`unit_token` 
    FROM `shop` WHERE `shop`.`distributor_token`='$distributor_token' AND  `shop`.`unit_token` IN($unit_token,'') ORDER BY `shop`.`unit_token` DESC");
        $shop_array = [];
        while($shop_row = mysqli_fetch_array($unitAddedSql)){
            $obj_shop = new stdClass();
            $obj_shop->shop_token = $shop_row["token"];
            $obj_shop->shop_name = $shop_row["name"];
            if($shop_row["unit_token"] != ''){
               $obj_shop->selected = true; 
            }else{
               $obj_shop->selected = false;  
            } 
            array_push($shop_array, $obj_shop); 
        }
        $obj_com->status_code = 200; 
        $obj_com->message = 'shop List';
        $obj_com->title = 'Success';
        $obj_com->data = $shop_array;  
}else if($input_data->type == 'update_unitList'){
        $unit_token   = $input_data->unit_token;
        $distributor_token = $input_data->distributor_token;
        $shopTokens        = $input_data->shop_tokens;
            $selectShop = mysqli_query($link,"SELECT `shop`.`token`,
            `shop`.`name`,`shop`.`address`
            FROM `units__shop_mapping`
            INNER JOIN `shop` ON `shop`.`token`=`units__shop_mapping`.`shop_token`
            WHERE  `units__shop_mapping`.`unit_group_token`='$unit_token'
            AND `units__shop_mapping`.delete_status='1' AND `units__shop_mapping`.`distributor_token` ='$distributor_token'");
            $array = [];
            while ($row = mysqli_fetch_array($selectShop)){
                array_push($array, $row['token']);
            }
        $existData = $array;
        foreach($existData as $existToken){
            if(!in_array($existToken, $shopTokens)){
                $removeShopFromUnit = mysqli_query($link,"UPDATE `units__shop_mapping` 
                SET `delete_status`='2' 
                WHERE `unit_group_token`='$unit_token' 
                AND `shop_token`='$existToken'");
                $removeShopFromUnit1 = mysqli_query($link,"UPDATE `shop` SET `unit_token`='' WHERE `token`='$existToken'");
            }
        }
        foreach($shopTokens as $shopToken){
            if(!in_array($shopToken, $existData)){
               $query = mysqli_query($link,"SELECT `id` FROM `shop` WHERE `token`='$shopToken' AND `distributor_token`='$distributor_token' AND `unit_token`=''");
                if(mysqli_num_rows($query) == 1){
                    $query = mysqli_query($link,"INSERT INTO `units__shop_mapping` SET `unit_group_token`='$unit_token',
                    `distributor_token`='$distributor_token',`shop_token`='$shopToken'");
                    $query1 = mysqli_query($link,"UPDATE `shop` SET `unit_token`='$unit_token' WHERE `token`='$shopToken' AND `distributor_token`='$distributor_token'");
                }
            }
        }
       $obj_com->status_code = 200; 
       $obj_com->message = 'Unit List Updated successfully';
       $obj_com->title = 'Success';
}

echo json_encode($obj_com);
?>