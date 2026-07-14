<?php
include "../config.php";
$json_input=getInputs();
$Year    = date("Y");
$year = $json_input->year;
if($year!=""){
    $year = $year;
}else{
    $year    = $Year; 
}
$array=[];
$categoryMonth = [];
$categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
MONTHNAME(`orders`.`date_time`) AS `Month`, 
CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
FROM `orders` WHERE `orders`.`date_time` LIKE '$year%' AND `order_type`='Distributor Order'
GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");
   while($rowf =  mysqli_fetch_assoc($categoryQuery)){
       $monthlyYear = $rowf['Month'];
       array_push($categoryMonth, $monthlyYear);
   }

 $query = mysqli_query($link,"SELECT * FROM `products__category` WHERE 	`delete_status` = '1'");
        $pro_cat_array = [];
        while($rows = mysqli_fetch_assoc($query)){
            extract($rows);
               $product_item=array(
                "token" => $token,
                "name" => $name
            );
            array_push($pro_cat_array, $product_item);
        }
    if(!empty($categoryMonth)){ 
        for($i=0; $i<count($pro_cat_array); $i++){
            $categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
            MONTHNAME(`orders`.`date_time`) AS `Month`, 
            CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
            FROM `orders` WHERE YEAR(`orders`.`date_time`) LIKE '$year%'
            GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");
            $proCat = $pro_cat_array[$i]['token'];
            $washingSoaps=[];
                while($rowa = mysqli_fetch_assoc($categoryQuery)){
                $obj = new stdClass();
                $YearMonth = $rowa['year_and_month'];
                if($YearMonth!=""){
                $catName = mysqli_query($link,"SELECT
                `products__category`.`name`, `products__category`.`id`
                 FROM `products__category`
                 WHERE `products__category`.`token` ='$proCat'");
                $row21 =mysqli_fetch_assoc($catName);    
                $obj->catName = $row21['name'];   
                $categoryMonQuery1 = mysqli_query($link,"SELECT
                MONTHNAME(`orders`.`date_time`) AS `Monthly`,
                COALESCE(`products__category`.`name`,'0') AS `category_name`,
                COALESCE(SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
                            WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
                            Else 0
                            END),'0') AS `total_quantity`
                 FROM `orders__items`
                INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
                INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
                INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
                INNER JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
                WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` LIKE '$YearMonth%' AND `products__category`.`token` ='$proCat'");
                    
                     while($row1 = mysqli_fetch_assoc($categoryMonQuery1)){
                            $total_quantity = $row1["total_quantity"];
                            array_push($washingSoaps, $total_quantity);
                    }
               $obj->CategorySales = $washingSoaps;
            } 
        }   
array_push($array,$obj);
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