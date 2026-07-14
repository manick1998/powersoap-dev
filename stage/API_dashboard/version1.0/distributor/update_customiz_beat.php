<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/schedule_distributor.php';
include_once '../config/core_distributor.php';

$database = new Database();
$db = $database->getConnection();
$schedule = new Schedule($db);
$input_data = json_decode(file_get_contents("php://input"));
$schedule->token = $input_data->token;
$schedule->distributor_token = $input_data->distributor_token;
$beat_tokens = $input_data->beat_tokens;
$schedule->beat_tokens = $beat_tokens;
//echo $beat_tokens;
$stmt1       = $schedule->update_select_unit();
$checkCount = $stmt1->rowCount();
//echo $checkCount;
$obj=new stdClass();
if ($checkCount == 0){
   //echo "no data";
}
else{   
    
   $check = $schedule->update_customiz_beat();
   if (!$check) {
    //echo "somethig wrong";
   }
   else{
    $change_date = $schedule->update_customiz_beat_date($indiaDateTime);
      if(!$change_date){
            //echo "date_and_time_not_updated";
      }
      else{
       $update=$schedule->unit_customise_mapping();
       if(!$update){
            //echo "updated not successfully";
       }
       else{
         //echo "updated successfully";
       }
         //echo "date_and_updated";
      }
   //  echo "done";
   }
        //echo $checkCount;
        //echo  "success";
}
$obj->code=201;
$obj->message="updated successfully";
echo json_encode($obj);


?>