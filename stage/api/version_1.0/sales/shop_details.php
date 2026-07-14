<?php
include "../../config.php";
$json_input = getInputs();
// $employee_id = $json_input->employee_id;
$shop_id = $json_input->shop_id;

$shop_query = mysqli_query($link,"SELECT
                    shop.name AS shop_name,
                    shop__type.name AS shop_type,
                    shop.mobile_number,
                    shop__outstanding.bill_amount,
                    shop__outstanding.paid_amt,
                    shop__outstanding.total_outstanding
                FROM
                    `shop`
                INNER JOIN shop__type ON shop.shop_type_code = shop__type.token
                INNER JOIN shop__outstanding ON shop.token = shop__outstanding.shop_token
                WHERE
                    shop.token = $shop_id");
   
   $shop_obj = new stdClass;                 
$shop_row = mysqli_fetch_array($shop_query);

  $shop_obj->shop_name= $shop_row['shop_name'];
  $shop_obj->shop_type= $shop_row['shop_type'];
  $shop_obj->mobile_number= $shop_row['mobile_number'];
  $shop_obj->bill_amount= $shop_row['bill_amount'];
  $shop_obj->paid_amt= $shop_row['paid_amt'];
  $shop_obj->total_outstanding= $shop_row['total_outstanding'];
  
  
  
$obj= new stdClass; 
if($shop_id !='') {
$obj->status_code=200; 
    $obj->message='Shop found';
    $obj->title='Success';
    $obj->data=$shop_obj;
    
    
}
else {
    $obj->status_code=400; 
    $obj->message='Shop not found';
    $obj->title='Failure';
}

echo json_encode($obj);

?>