<?php
include "../config.php";
$json_input = getInputs();
$year    = date("Y");
$month    = date("m");


$detail = new stdClass;
// order_taken
$order_item = mysqli_query($link,"SELECT COUNT(`id`) as order_taken FROM `orders` WHERE `order_type` in ('Distributor Order') AND `delivery` = 'Completed' ANd YEAR(date_time)='$year'");
$get_order_taken = mysqli_fetch_array($order_item);
 $detail->order_taken_value = $get_order_taken['order_taken'];

 // distributor_data
 $distributor_data = mysqli_query($link,"SELECT 1 FROM `employees` WHERE `deparment_token`=18028120 AND `block_status`=1");
  $detail->get_distributor = mysqli_num_rows($distributor_data);

  // salesRep
  $salesDelivery = mysqli_query($link,"SELECT 1 FROM `employees` WHERE `deparment_token`in (72602780,98765433,98765434)");
   $detail->get_salesDelivery = mysqli_num_rows($salesDelivery);

   // shop data
   $shop = mysqli_query($link,"SELECT COUNT(`id`) as shop_value FROM `shop` WHERE `delete_status`='1' AND `shop_show_status`='Active'");
   $get_shop = mysqli_fetch_array($shop);
    $detail->shop_count_value = $get_shop['shop_value'];
//income

//yearly
    $year_item = mysqli_query($link,"SELECT COALESCE(SUM(`billing_amount`),0)AS `year` FROM `orders` WHERE YEAR(date_time)='$year' AND `delivery`='Completed' AND `order_type`='Distributor Order'");
    $get_year = mysqli_fetch_array($year_item);
    $detail->year_income = indCurrencyFormatComma(round($get_year['year']));
    
     //monthly
     $month_data = mysqli_query($link,"SELECT COALESCE(SUM(`billing_amount`),0)AS `month` FROM `orders` WHERE `delivery`='Completed' AND `order_type`='Distributor Order' AND YEAR(date_time) LIKE '$year%'");
    
     $get_order_taken = mysqli_fetch_array($month_data);
     
     $detail->month_income = indCurrencyFormatComma(round($get_order_taken['month']/$month));
       
          //monthly
          $monthValue = mysqli_query($link,"SELECT SUM(billing_amount) AS total,MONTHNAME(`orders`.`date_time`) AS `Month` FROM orders WHERE `delivery`='Completed' AND YEAR(date_time) LIKE '$year%' AND `order_type`='Distributor Order' GROUP BY MONTH(date_time)");
          $month = [];
          while($row = mysqli_fetch_assoc($monthValue)){
              $monthly = round($row['total']);
              array_push($month,$monthly);
          }
          $detail->month=$month;
        
     

     //category month
     $categoryQuery = mysqli_query($link,"SELECT DATE_FORMAT(`orders`.`date_time`, '%Y-%m') AS `year_and_month`, 
            MONTHNAME(`orders`.`date_time`) AS `Month`, 
            CONCAT(MONTHNAME(`orders`.`date_time`),'-', YEAR(`orders`.`date_time`)) AS `MonthlyYear` 
            FROM `orders` WHERE `orders`.`date_time` LIKE '$year%' AND `order_type`='Distributor Order'
            GROUP BY MONTH(`orders`.`date_time`), YEAR(`orders`.`date_time`)");
      
        $categoryMonth = [];
        while($rowf =  mysqli_fetch_assoc($categoryQuery)){
            $monthlyYear = $rowf['Month'];
            array_push($categoryMonth, $monthlyYear);
        }
        $detail->Category_month= $categoryMonth;
   
$homescreen = new stdClass;
$homescreen->dashboard_details = $detail;
$obj1 = new stdClass;
if($detail){
    $obj1->status_code=200; 
    $obj1->message='Product found';
    $obj1->title='Success';
    $obj1->data=$homescreen;

}else{
    $obj1->status_code=400; 
    $obj1->message='Error';
    $obj1->title='Error';
}



echo json_encode($homescreen);

?>