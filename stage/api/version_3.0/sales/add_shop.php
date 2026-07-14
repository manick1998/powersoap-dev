<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
$units_id = $json_input->units_id;
$token  = genToken('token','shop');
$retailcode = genToken('retail_code','shop');

date_default_timezone_set("Asia/Kolkata");   //India time (GMT+5:30)
$order_date = date('Y-m-d h:i:s');
$dateonly = $indiaDate;
$dayname =  date('l', strtotime($order_date));

$sql = "SELECT * FROM `daily_schedule` WHERE sales_emp_token ='$employee_id' AND schedule_date = '$dayname'";
$amount = $link->query($sql);
$data= $amount->num_rows;

if ($data == 0) {
    $obj1 = new stdClass;
    $obj1->status_code=200; 
    $obj1->message='Sorry U Can\'t Add shop'; 
    $obj1->title='Success';
    echo json_encode($obj1);
}
else {
    
$shop_name = $json_input->shop_name;
$contact_name = $json_input->contact_name;
$contact_number = $json_input->contact_number;
$shop_type = $json_input->shop_type;
$licence_number = $json_input->licence_number;
$upload_url = $json_input->upload_url;
$address = $json_input->address;
$city = $json_input->city;
$pincode = $json_input->pincode;
$coordinates = $json_input->coordinates;
$date = $currnetDateTime;
$get_distributor_id = mysqli_query($link,"SELECT `admin_distributor_token` FROM `employees` where `token` = '$employee_id'");
$row_id = mysqli_fetch_array($get_distributor_id);
$distributor_id = $row_id['admin_distributor_token'];

//get state
$get_State_id = mysqli_query($link,"SELECT `state_id` FROM `employees` where `token` = '$distributor_id'");
$row = mysqli_fetch_array($get_State_id);
$state_id = $row['state_id'];
$obj1 = new stdClass;
//if($employee_id){ 
$mobile_numberCheck = mysqli_query($link,"SELECT COUNT(mobile_number) as count,token FROM `shop` 
INNER JOIN `shop_mapping` ON `shop_mapping`.`shop_token`=`shop`.`token`
WHERE `shop_mapping`.`distributor_token`='$distributor_id' AND `shop`.`mobile_number`='$contact_number'"); 
$row1 =mysqli_fetch_array($mobile_numberCheck);
$count = $row1["count"];
    if($count==0){
        $insert_shop = mysqli_query($link,"INSERT INTO `shop`( `token`, `name`, `date_time`, `unit_token`,  `retail_code`, `shop_type_code`, `slot`, `mobile_number`,`contact_person`, `join_date`, `license_number`,license_image,  `delete_status`, `address`, `city`, `state_id`, `pincode`, `coordinates`,`created_by`) VALUES ('$token','$shop_name','$date','$units_id' , '$retailcode','$shop_type','0%','$contact_number','$contact_name','$date','$licence_number','$upload_url', '1','$address','$city','$state_id','$pincode','$coordinates','$employee_id')");

        $insert_shop_mapping = mysqli_query($link,"INSERT INTO `shop_mapping`(`shop_token`, `distributor_token`, `date_time`, `status`) VALUES ('$token','$distributor_id','$currnetDateTime','1')");

            if($insert_shop){
                $units_mapping = mysqli_query($link,"INSERT INTO `units__shop_mapping`( `unit_group_token`, `distributor_token`, `shop_token`, `delete_status`) VALUES ('$units_id','$distributor_id','$token','1')");
                $shop_outstanding_amt = mysqli_query($link,"INSERT INTO `shop__outstanding`( `date_time`, `shop_token`, `bill_amount`, `paid_amt`, `total_outstanding`, `receiver_token`) VALUES ('$date','$token','0','0','0','0')");
            }
        $obj1->status_code=200; 
        $obj1->message='Product Added Successfully';
        $obj1->title='Success';
    }else{
        $obj1->status_code=400; 
        $obj1->message='Mobile No Already Exist!';
        $obj1->title='failed'; 
    }
echo json_encode($obj1);
}
?>