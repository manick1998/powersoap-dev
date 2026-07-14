<?php
include "../../config.php";
$json_input = getInputs();
$product_array = $json_input->data;
$shop_distributor_token = $json_input->employee_id;
 



foreach( $product_array as $key => $data) {
     $product_token = $data->token;
     $stock_in_hand = $data->added_count;
     $update =mysqli_query($link,"UPDATE
     `stock__distributor`
 SET
     `stock_in_hand` = '$stock_in_hand',`sold_pieces`='0'
 WHERE
     `product_token` = '$product_token' AND `employee_token` = '$shop_distributor_token' AND `is_active`='0'");
}
      



$obj = new stdClass;
if($update){
    $obj->status_code=200; 
    $obj->message='Product Stock Updated';
    $obj->title='Success';
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}

echo json_encode($obj);


?>