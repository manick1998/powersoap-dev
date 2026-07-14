<?php
include "../../config.php";
$json_input = getInputs();
$distributor_token = $json_input->distributor_token;
$shop_id = $json_input->shop_id;
$obj = new stdClass;
if($distributor_token !="" && $shop_id != ""){
    $token = mysqli_query($link,"SELECT `token` FROM orders
    WHERE `shop_token` = '$shop_id' AND `distributor_token` = '$distributor_token'
    ORDER BY id DESC LIMIT 1");
    if(mysqli_num_rows($token)>0){
        $get_token = mysqli_fetch_array($token);
        $sale_order_token = $get_token['token'];
        $array = array();
        $order_details = mysqli_query($link,"SELECT
                                            orders__items.product_token,
                                            products.name as product_name,
                                            orders__items.quantity,
                                            orders__items.units,
                                            orders__items.piece_count,
                                            -- ( orders__items.quantity * orders__items.price_per_unit ) AS amount
                                            ( orders__items.price_per_unit ) AS amount
                                            FROM `orders`
                                            INNER JOIN orders__items ON orders__items.order_token = orders.token and orders__items.is_free = 0 and orders__items.delete_status=1
                                            INNER JOIN products ON products.token = orders__items.product_token
                                            WHERE orders.token = $sale_order_token");


                                            while($order_row = mysqli_fetch_array($order_details)) {
                                                $order_obj = new stdClass;
                                                $order_obj->product_token = $order_row['product_token'];
                                                $order_obj->product_name = $order_row['product_name'];
                                                $order_obj->quantity = $order_row['quantity'];
                                                $order_obj->units = $order_row['units'];
                                                $order_obj->amount = $order_row['amount'];
                                                $order_obj->piece_count = $order_row['piece_count'];
                                                array_push($array,$order_obj);
                                            }                      

            $order_total = mysqli_query($link,"SELECT
                                               sum( orders__items.quantity * orders__items.price_per_unit ) AS total_amount,
                                               orders.token as order_token,
                                               SUM(orders__items.quantity) as quantity
                                               FROM `orders`
                                               INNER JOIN orders__items ON orders__items.order_token = orders.token
                                               INNER JOIN products ON products.token = orders__items.product_token
                                               WHERE orders.token = $sale_order_token");

                                               $order_mount = mysqli_fetch_array($order_total);
                                               $amt_obj = new stdClass;
                                               $amt_obj->order_token = $order_mount['order_token'];
                                               $amt_obj->total_amount = $order_mount['total_amount'];
                                               $amt_obj->quantity = $order_mount['quantity'];

            $order_val = new stdClass;
            $order_val->order_details = $array;
            $order_val->order_val = $amt_obj;              
            $check_data = mysqli_num_rows($order_details);                
            if($check_data > 0){
                $obj->status_code=200; 
                $obj->message='Product found';
                $obj->title='Success';
                $obj->data = $order_val;

                } 
    }else {
            $obj->status_code=400; 
            $obj->message='Product not found';
            $obj->title='Error';

        }
}else{
    $obj->status_code=400; 
    $obj->message='All field are mandatory';
    $obj->title='Error';
}
echo json_encode($obj);
?>