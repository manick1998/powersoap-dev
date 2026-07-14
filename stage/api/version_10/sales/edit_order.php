<?php
include "../../config.php";
$json_input = getInputs();
$order_id = $json_input->ordertoken;
$obj = new stdClass;
$indiaDate     = date("Y-m-d");

$query = mysqli_query($link, "SELECT date(`date_time`)AS `date` FROM `orders` WHERE `token`='$order_id'");
$row = mysqli_fetch_array($query);
$date = $row['date'];



if ($date == $indiaDate) {

  if ($order_id) {
    $array = array();
    $order_details = mysqli_query($link, "SELECT
  orders__items.product_token,
  products.name as product_name,
  orders__items.quantity,
  orders__items.units,
  orders__items.offer_amount,
  orders__items.piece_count,
  orders__items.is_discount_enable,
  (CASE WHEN orders__items.is_discount_enable=1 then orders__items.discount_value ELSE 0 END) as discount_value,
  ( orders__items.price_per_unit ) AS amount
FROM
  `orders`
INNER JOIN orders__items ON orders__items.order_token = orders.token and orders__items.is_free = 0 and orders__items.delete_status=1
INNER JOIN products ON products.token = orders__items.product_token
WHERE
  orders.token = '$order_id'");


    while ($order_row = mysqli_fetch_array($order_details)) {
      $order_obj = new stdClass;
      $order_obj->product_token = $order_row['product_token'];
      $order_obj->product_name = $order_row['product_name'];
      $order_obj->quantity = $order_row['quantity'];
      $order_obj->unit_type = $order_row['units'];
      $order_obj->amount = $order_row['amount'];
      $order_obj->piece_count = $order_row['piece_count'];
      $order_obj->discount_enable = $order_row['is_discount_enable'] == '1' ? 'true' : 'false';
      $order_obj->discount = $order_row['discount_value'];
      $order_obj->totalamount = $order_row['offer_amount'];
      array_push($array, $order_obj);
    }

    $order_total = mysqli_query($link, "SELECT
                                orders.billing_amount AS total_amount,
                            orders.token as order_token,
                            SUM(orders__items.quantity) as quantity
                        FROM
                            `orders`
                        INNER JOIN orders__items ON orders__items.order_token = orders.token
                        INNER JOIN products ON products.token = orders__items.product_token
                        WHERE
                            orders.token = $order_id");

    $order_mount = mysqli_fetch_array($order_total);
    $amt_obj = new stdClass;
    $amt_obj->order_token = $order_mount['order_token'];
    $amt_obj->total_amount = $order_mount['total_amount'];
    $amt_obj->quantity = $order_mount['quantity'];





    $order_val = new stdClass;
    $order_val->order_details = $array;
    $order_val->order_val = $amt_obj;





    $check_data = mysqli_num_rows($order_details);

    if ($check_data > 0) {
      $obj->status_code = 200;
      $obj->message = 'Product found';
      $obj->title = 'Success';
      $obj->data = $order_val;
    }
  } else {
    $obj->status_code = 400;
    $obj->message = 'Product not found';
    $obj->title = 'Success';
  }
} else {
  $obj->status_code = 400;
  $obj->message = 'Within one day';
  $obj->title = 'Success';
}
echo json_encode($obj);
