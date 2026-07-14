<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
// $shop_id = $json_input->shop_id;

$employeeQuery = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` WHERE `token`='$employee_id'");
$employeeRow = mysqli_fetch_array($employeeQuery);

$distributorToken = $employeeRow['admin_distributor_token'];


// $sql1 = mysqli_query($link,"SELECT products.`category_token`, products.`token`,products.`piece_count`, products.`item_code`, products.`name`,  products.`total_cost`,products.`gst`, products.`batch_number`, products.`net_weight`,products__category.name as pro_cat FROM `stock__distributor`, `products`, `products__category` WHERE `stock__distributor`.`product_token` = `products`.`token` AND `products`.`category_token` = `products__category`.`token` AND `stock__distributor`.`employee_token` = '$distributorToken'");

$sql1 = mysqli_query($link,"SELECT
    products.`category_token`,
    products.`piece_count`,
    products.`token`,
    products.`item_code`,
    products.`name`,
    products.`total_cost`,
    products.`gst`,
    products.`batch_number`,
    products.`net_weight`,
    products__category.name AS pro_cat
FROM
    `products`
INNER JOIN products__category ON products__category.token = products.category_token
INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
WHERE
    employees__division_mapping.employee_token = $distributorToken AND employees__division_mapping.delete_status = '1'");

$prod_array = array();
while($query =   mysqli_fetch_array($sql1)){
    $prod_obj = new stdClass;
    $prod_obj->category_token = $query['category_token'];
    $prod_obj->category_name = $query['pro_cat'];
    $prod_obj->token = $query['token'];
    $prod_obj->name = $query['name'];
    $prod_obj->item_code = $query['item_code'];
    $prod_obj->product_per_price = $query['total_cost'];
    $prod_obj->product_gst = $query['gst'];
    $prod_obj->net_weight = $query['net_weight'];
    $prod_obj->piece_count = $query['piece_count'];
    
    
    
    array_push($prod_array,$prod_obj);
}

$obj = new stdClass;

if(sizeof($prod_array)){
    $obj->status_code=200; 
    $obj->message='Product found';
    $obj->title='Success';
    $obj->data=$prod_array;
    
} else {
    $obj->status_code=400; 
    $obj->message='Product not found';
    $obj->title='Success';
    
}
echo json_encode($obj);
?>