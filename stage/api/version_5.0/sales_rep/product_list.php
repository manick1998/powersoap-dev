<?php
include "../../config.php";
$json_input = getInputs();
$employee_id = $json_input->employee_id;
// $shop_id = $json_input->shop_id; 

$employeeQuery = mysqli_query($link, "SELECT `admin_distributor_token` FROM `employees` WHERE `token`='$employee_id'");
$employeeRow = mysqli_fetch_array($employeeQuery);

 $distributorToken = $employeeRow['admin_distributor_token'];


// $sql1 = mysqli_query($link,"SELECT products.`category_token`, products.`piece_count`, products.`token`, products.`item_code`, products.`name`,  products.`total_cost`,products.`gst`, products.`batch_number`, products.`net_weight`,products__category.name as pro_cat FROM `stock__distributor`, `products`, `products__category` WHERE `stock__distributor`.`product_token` = `products`.`token` AND `products`.`category_token` = `products__category`.`token` AND `stock__distributor`.`employee_token` = '$distributorToken'");

// $sql1 = mysqli_query($link,"SELECT
//     products.`category_token`,
//     products.`piece_count`,
//     products.`token`,
//     products.`item_code`,
//     products.`name`,
//     products.`total_cost`,
//     products.`gst`,
//     products.`batch_number`,
//     products.`net_weight`,
//     products.mrp,
//     products__category.name AS pro_cat
// FROM 
//     `products`
// INNER JOIN products__category ON products__category.token = products.category_token
// INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
// WHERE
//     employees__division_mapping.employee_token = $distributorToken AND employees__division_mapping.delete_status = '1'");
$sql1 = mysqli_query($link,"SELECT 
                    products.`token`,
                    products.`category_token`,
                    products.`piece_count`,
                    products.`item_code`,
                    products.`name`,
                    products.`image`,
                    products.`total_cost`,
                    products.`gst`,
                    products.`batch_number`,
                    products.`net_weight`,
                    COALESCE(products__scheme.scheme_name,0) AS additional_offer,
                    COALESCE(products__scheme.`limit_box`,0) as limit_box,
                    COALESCE(products__scheme.`free_box`,0)as free_box,
                    COALESCE(products__scheme.`is_scheme`,0)as is_scheme,
                    products.retailer_price,
                    products__category.name AS pro_cat,
                    COALESCE(stock__distributor.stock_in_hand,0) AS stock_in_hand
                FROM
                    `products`
                INNER JOIN products__category ON products__category.token = products.category_token
                left JOIN products__scheme ON products__scheme.product_token=products.token AND products__scheme.is_scheme='1'
                INNER JOIN employees__division_mapping ON employees__division_mapping.division_token = products.category_token
                LEFT JOIN stock__distributor ON (stock__distributor.product_token = products.token AND stock__distributor.employee_token = employees__division_mapping.employee_token)
                WHERE
                    employees__division_mapping.employee_token = '$employee_id' AND employees__division_mapping.delete_status = '1' and ((`products`.`delete_status`='2' AND `stock__distributor`.`stock_in_hand` > '0') ||  `products`.`delete_status`='1') GROUP BY products.token");

$prod_array = array();
while($query =   mysqli_fetch_array($sql1)){
    $prod_obj = new stdClass;
    $prod_obj->category_token = $query['category_token'];
    $prod_obj->category_name = utf8_encode($query['pro_cat']);
    $prod_obj->token = $query['token'];
    $prod_obj->image = $query['image'];
    $prod_obj->name = utf8_encode($query['name']);
    $prod_obj->item_code = $query['item_code'];
    // $prod_obj->product_per_price = $query['total_cost'];
    $prod_obj->product_per_price = $query['retailer_price'];
    $prod_obj->product_gst = $query['gst'];
    $prod_obj->net_weight = $query['net_weight'];
     $prod_obj->piece_count = $query['piece_count'];
     $prod_obj->stock_in_hand = $query['stock_in_hand'];
     $prod_obj->additional_offer = $query['additional_offer'];
     $prod_obj->limit_box = (int)$query['limit_box'];
     $prod_obj->free_box = (int)$query['free_box'];
     if($query['is_scheme']==1){
        $is_scheme = true;

     }else{
        $is_scheme = false;

     }

     $prod_obj->is_scheme = $is_scheme;

    
    
    
    
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