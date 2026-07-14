<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
// $shop_id = $json_input->shop_id; 

$employeeQuery = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` WHERE `token`='$employee_id'");
$employeeRow = mysqli_fetch_array($employeeQuery);

 $distributorToken = $employeeRow['admin_distributor_token'];

$sql1 = mysqli_query($link,"SELECT 
                    products.`token`,
                    products.`category_token`,
                    products.`piece_count`,
                    products.`item_code`,
                    products.`name`,
                    products.`image`,
                    products.retailer_price,
                    products__category.name AS pro_cat
                FROM
                    `products`
                INNER JOIN products__category ON products__category.token = products.category_token
                INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
                WHERE
                    employees__division_mapping.employee_token = $employee_id AND employees__division_mapping.delete_status = '1' AND `products`.`delete_status`='1' GROUP BY products.token");

$prod_array = array();
while($query =   mysqli_fetch_array($sql1)){
    $prod_obj = new stdClass;
    $prod_obj->category_token = $query['category_token'];
    $prod_obj->category_name = utf8_encode($query['pro_cat']);
    $prod_obj->token = $query['token'];
    $prod_obj->image = $query['image'];
    $prod_obj->name = utf8_encode($query['name']);
    $prod_obj->item_code = $query['item_code'];
    $prod_obj->product_per_price = $query['retailer_price'];
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