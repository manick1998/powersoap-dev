<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include "../config.php";
$json_data = getInputs();
$obj_final = new stdClass;
$YearMonth = $json_data->year_and_month;
if($YearMonth!=""){
    $YearMonth ="AND `orders`.`date_time` LIKE '$YearMonth%'";
}else{
    $YearMonth =""; 
}
$unitQuery = mysqli_query($link,"SELECT 
        `units`.`name` AS `unit_name`,
        `units`.`token` AS `unit_token`,
        SUM(`orders`.`billing_amount`) AS `unit_sales`
       	FROM `orders` 
        INNER JOIN `employees` ON `employees`.`token`=`orders`.`employee_token`
        INNER JOIN `shop_mapping` ON `orders`.`shop_token` = `shop_mapping`.`token`
        INNER JOIN `shop` ON `shop`.`token`=`shop_mapping`.`shop_token`
        INNER JOIN `units` ON `shop`.`unit_token` = `units`.`token`
        WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' $YearMonth
        GROUP BY `units`.`name`");

        $unitArray = [];
        while($row = mysqli_fetch_assoc($unitQuery)){
           $obj = new stdClass();
           $obj->unit_name = $row["unit_name"];
           $obj->unit_token = $row["unit_token"];
           $rand = str_pad(dechex(rand(0x000000, 0xFFFFFF)), 6, 0, STR_PAD_LEFT);
           $obj->random_color = '#'.$rand;
           $obj->unit_sales = round($row["unit_sales"],2);
            array_push($unitArray, $obj);
        }

        // $outer_array=[];
        // $year = date("Y");
        // $query = mysqli_query($link,"SELECT * FROM `products__category` WHERE 	`delete_status` = '1'");
        // $pro_cat_array = [];
        // while($rows = mysqli_fetch_assoc($query)){
        //     extract($rows);
        //        $product_item=array(
        //         "token" => $token,
        //         "name" => $name
        //     );
        //     array_push($pro_cat_array, $product_item);
        // }
     
        // for($i=0; $i<count($pro_cat_array); $i++){
        //     $categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
        //     MONTHNAME(`orders`.`date_time`) AS `Month`, 
        //     CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
        //     FROM `orders` WHERE `orders`.`date_time` LIKE '$year%'
        //     GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");
        //     $proCat = $pro_cat_array[$i]['token'];
        //     $washingSoaps=[];
        //         while($rowa = mysqli_fetch_assoc($categoryQuery)){
        //         $obj1 = new stdClass();
        //         $YearMonth = $rowa['year_and_month'];
        //         $catName = mysqli_query($link,"SELECT
        //         `products__category`.`name`, `products__category`.`id`
        //          FROM `products__category`
        //          WHERE `products__category`.`token` ='$proCat'");
        //         $row21 =mysqli_fetch_assoc($catName);    
        //         $obj1->catName = $row21['name'];   
        //         $categoryMonQuery1 = mysqli_query($link,"SELECT
        //         MONTHNAME(`orders`.`date_time`) AS `Monthly`,
        //         COALESCE(`products__category`.`name`,'0') AS `category_name`,
        //         COALESCE(SUM(CASE WHEN `orders__items`.`units` = 'Box' THEN `orders__items`.`quantity` * `products`.`piece_count`
        //                     WHEN `orders__items`.`units` = 'Nos' THEN `orders__items`.`quantity`
        //                     Else 0
        //                     END),'0') AS `total_quantity`
        //          FROM `orders__items`
        //         INNER JOIN `orders` ON `orders__items`.`order_token`=`orders`.`token`
        //         INNER JOIN `employees` on `orders`.`employee_token` = `employees`.`token`
        //         INNER JOIN `products` ON `orders__items`.`product_token` = `products`.`token`
        //         INNER JOIN `products__category` ON `products`.`category_token` = `products__category`.`token`
        //         WHERE `orders`.`order_type` IN('Sales Order', 'Spot Order') AND `orders`.`delivery` != 'Cancelled' AND `orders`.`date_time` LIKE '$YearMonth%' AND `products__category`.`token` ='$proCat'");
                    
        //              while($row1 = mysqli_fetch_assoc($categoryMonQuery1)){
        //                     $total_quantity = $row1["total_quantity"];
        //                     array_push($washingSoaps, $total_quantity);
        //             }
        //        $obj1->CategorySales = $washingSoaps;
        //     }    
        // array_push($outer_array, $obj1);
        // }
        
        // $categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
        //     MONTHNAME(`orders`.`date_time`) AS `Month`, 
        //     CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
        //     FROM `orders` WHERE `orders`.`date_time` LIKE '$year%'
        //     GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");
      
        // $categoryMonth = [];
        // while($rowf =  mysqli_fetch_assoc($categoryQuery)){
        //     $monthlyYear = $rowf['MonthlyYear'];
        //     array_push($categoryMonth, $monthlyYear);
        // }
       
        $obj_final->status_code=200; 
        $obj_final->message='shop found';
        $obj_final->title='Success';
        $obj_final->unit_names = array_column($unitArray, 'unit_name');
        $obj_final->unit_sales = array_column($unitArray, 'unit_sales');
        $obj_final->random_color = array_column($unitArray, 'random_color');
        //$obj_final->Category_array = $outer_array;
        //$obj_final->Category_month = $categoryMonth;

echo json_encode($obj_final);

?>