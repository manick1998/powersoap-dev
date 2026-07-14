<?php
include "../config.php";
$json_input=getInputs();
$Year    = date("Y");
$year = isset($json_input->year) ? $json_input->year : "";
if($year==""){
    $year    = $Year; 
}
$array=[];
$categoryMonth = [];
$catMonthIndex = [];

$categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
MONTHNAME(`orders`.`date_time`) AS `Month`, 
CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
FROM `orders` WHERE `orders`.`date_time` LIKE '$year%' AND `order_type` IN ('Sales Order','Spot Order','Retailer order')
GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");

$idx = 0;
while($rowf =  mysqli_fetch_assoc($categoryQuery)){
    $monthlyYear = $rowf['Month'];
    array_push($categoryMonth, $monthlyYear);
    $catMonthIndex[$monthlyYear] = $idx++;
}

$pro_cat_array = [];
$query = mysqli_query($link,"SELECT * FROM `products__category` WHERE `delete_status` = '1'");
while($rows = mysqli_fetch_assoc($query)){
    $pro_cat_array[$rows['token']] = [
        "name" => $rows['name'],
        "CategorySales" => array_fill(0, count($categoryMonth), 0)
    ];
}

if(!empty($categoryMonth) && count($pro_cat_array) > 0){ 
    $categoryTokens = array_keys($pro_cat_array);
    $inClause = "'" . implode("','", $categoryTokens) . "'";
    
    $aggregateQuery = "
        SELECT 
            MONTHNAME(`orders`.`date_time`) AS `Monthly`,
            `products__category`.`token` AS `cat_token`,
            SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                     WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                     ELSE 0
                END) AS `total_quantity`
        FROM `orders__items`
        INNER JOIN `orders` ON `orders__items`.`order_token` = `orders`.`token`
        INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        INNER JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
        WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') 
          AND `orders`.`delivery` != 'Cancelled' 
          AND `orders`.`date_time` LIKE '$year%' 
          AND `products__category`.`token` IN ($inClause)
        GROUP BY `Monthly`, `cat_token`
    ";
    
    $runAggr = mysqli_query($link, $aggregateQuery);
    if ($runAggr) {
        while($rowAggr = mysqli_fetch_assoc($runAggr)) {
            $month = $rowAggr['Monthly'];
            $catToken = $rowAggr['cat_token'];
            $qty = $rowAggr['total_quantity'] ? $rowAggr['total_quantity'] : 0;
            
            if (isset($catMonthIndex[$month]) && isset($pro_cat_array[$catToken])) {
                $mIndex = $catMonthIndex[$month];
                $pro_cat_array[$catToken]['CategorySales'][$mIndex] = $qty;
            }
        }
    }
    
    foreach($pro_cat_array as $token => $val) {
        $obj = new stdClass();
        $obj->catName = $val['name'];
        $obj->CategorySales = array_values($val['CategorySales']); 
        array_push($array, $obj);
    }
}

$obj1 = new stdClass;
$obj1->status_code=200; 
$obj1->message='Product found';
$obj1->title='Success';
$obj1->category_array=$array;
$obj1->Category_month=$categoryMonth;


echo json_encode($obj1);

?>