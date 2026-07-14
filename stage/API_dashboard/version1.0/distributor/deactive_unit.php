<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$obj=new stdClass();
include_once '../config/core_distributor.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
    include_once '../objects/schedule_distributor.php';
    $schedule = new Schedule($db);
    // $schedule->edit_unit_name   = $inputData->edit_unit_name;
    $schedule->token   = $inputData->unit_token;
    $schedule->distributor_token = $inputData->distributor_token;
    // $shopTokens        = $inputData->shop_tokens;
    // $shopToken_uniq = $inputData->shop_token_uniq1;
    // $schedule->shopToken_uniq  = $shopToken_uniq;
    #=================== unit token change in shop_mapping
    $check = $schedule->check_shop_mapping();
    if ($check->rowCount() > 0) {
        $schedule -> remove_shop_unit_token();
        $check1 = $schedule->check_unit_grouping();
        if ($check1->rowCount() > 0) {
            $schedule -> update_unit_grouping();
            $obj->code=201;
            $obj->message="success";
        }
        
    }else{
        $obj->code=401;
        $obj->message="error";
   }

   
    echo json_encode($obj);

?>