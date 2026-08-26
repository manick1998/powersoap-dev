<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 $freeproduct_array = [];
 $indiaDate     = date("Y-m-d");
    $distributor_token = $input_data->distributor_token;
    $state_id=mysqli_query($link,"SELECT state_id from employees WHERE token='$distributor_token'");
    $row22=mysqli_fetch_assoc($state_id);
    $state=$row22['state_id'];
      function token_generate_order($table_name,$column_name){
        $random = rand(10000000,99999999);
        $val=true;
        do{
            $result = mysqli_query($GLOBALS['link'], "SELECT `$column_name` FROM `$table_name` WHERE `$column_name`='$random'");
            $count = mysqli_num_rows($result);
            if($count==0){
                $val = false;
            }else{
                $random = rand(10000000,99999999);
            }
        }while($val);
        return 'ORD-D'.$random;
    }
    $order_id = token_generate("orders","token");
    $order_number = token_generate_order("orders","order_number");
    $address_query = mysqli_query($link,"SELECT CONCAT(`name`,', ', `address`,', ', `street`,', ', `city`,', ', `pincode`) AS `address`, `mobile_number`, `license_number` FROM `employees` WHERE `deparment_token`='18028120' AND `token` = '$distributor_token'");
    $row21 = mysqli_fetch_assoc($address_query);
    $dist_address = $row21["address"];
    $dist_mobile_number = $row21["mobile_number"];
    $license_number = $row21["license_number"];
    $html = "";
    $html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <style>

        </style>
    </head>
    <body>
    
    <table border="0" style="table-layout:fixed;width: 580px;height:auto;margin: 0 auto;font-family: sans-serif;">
    <tr>
        <td>
        <table style="table-layout:fixed;width: 100%;height:0;margin:0;padding:0;">
            <tr cellpadding="0"
       cellspacing="0" style="margin:0;padding:0;">
                <td style="display: block;width: 50%;text-align: left;margin:0;padding:0;">
                <table style="width: 100%;">
                <tr>
                    <td><img src="https://powersoaps.online/stage/admin_dashboard/assets/logo.png" alt="logo" style="width: 150px;object-fit: contain;"></td>
                </tr>
                 <tr>
                    <td style="display: block;width: 100%;text-align: left;min-width: 200px;font-size: 10px;line-height: 22px;margin:0;padding:0;"><span style="font-size: 12px;">Abirami Soap Works</span><br/>R.S.No 94/1, Embalam main Road, Sembiapalayam Village, Korkadu Post, Puthucherry-627000 <span style="display: block;">Ph : 984231765</span> </td>
                </tr>
                </table>
                </td>
                <td style="display: block;width: 50%;text-align: right;">
                <br/><br/><br/>
                <table style="width: 100%;">
                <tr>
                    <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="width: 100px;display: inline-block;">Estimate No </b>: <span>'.$order_id.'</span><br/><b style="width: 100px;display: inline-block;" >Estimate Date </b>: <span>'.$indiaDateFormat.'</span></td>
                 </tr>
                </table>
               </td>
            </tr>
            <tr cellpadding="0"
       cellspacing="0" style="margin:0;padding:0;">
                <td style="display: block;width: 50%;text-align: left;">
                <table style="width: 100%;">
                <tr>
                    <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">BILL TO</b><br/>'.$dist_address.'<span style="display: block;"><br>Ph :'.$dist_mobile_number.'</span><br/><b style="width: 100px;">GST IN </b>: <span>'.$license_number.'</span></td>
                </tr>
                </table>
               </td>
                <td style="display: block;width: 50%;text-align: right;">
                <table style="width: 100%;">
                <tr>
                        <td style="font-size: 10px;line-height: 22px;width: 100%;margin:0;padding:0;"><b style="font-size: 14px;">SHIP TO</b><br/>'.$dist_address.'</td>
                </tr>
                </table>
                </td>
            </tr>  
        </table>

        <table style="table-layout:fixed;border-collapse: collapse;border: 1px solid #ccc;width: 100%;text-align: left;font-size: 10px;line-height: 22px;font-family: sans-serif;">
            <thead  style="background: darkgrey;border: 1px solid #ccc;line-height: 50px;">
            <tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:40px;text-align:center;"><b>S.No</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:200px;text-align:center;"><b>Item Name</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>HSN Code</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>Qty / UOM</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Basic Rate</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;width:60px;text-align:center;"><b>Discount</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>GST Amount</b></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;text-align:center;"><b>Net Amt</b></th>
            </tr>
        </thead>
    <tbody>';
    $array = $input_data->order_array;
    $quantity=0;
    $productsArray = [];
    foreach($array as $value){
        array_push($productsArray, $value->product_token);
    }
    $productQuery = implode(",",$productsArray);
    $finalArray   = [];
    $result = mysqli_query($link, "SELECT `products__category`.`token` AS `division_token`,
    `products__category`.`name` AS `division_name`,
    GROUP_CONCAT(	CONCAT(
        `products`.`name`,'&&&&',
        `products`.`token`,'&&&&',
        `products`.`mrp`,'&&&&',
        `products`.`total_cost`,'&&&&',
        `products`.`piece_count`,'&&&&',
        `products`.`item_code`,'&&&&',
        `products`.`batch_number`,'&&&&',
        `products`.`gst`
    ),	'****') AS `product_details`
    FROM `products__category`
    INNER JOIN `products` ON `products`.`category_token`=`products__category`.`token`
    WHERE `products`.`token` IN ( $productQuery )
    GROUP BY `products__category`.`token`");
    $gst_total_amount =0;
    $basicRate_total =0;
    $total_final_amount =0; 
    $slno = 0;
    $order_insert = mysqli_query($link,"INSERT INTO `orders`(`token`, `order_number`, `date_time`, `order_type`, `shop_token`, `employee_token`, `delivery`) VALUES ('$order_id','$order_number','$indiaDateTime','Distributor Order','0','$distributor_token','Pending')");
    while($row = mysqli_fetch_array($result)){
        $division_token  = $row['division_token'];
        $product_string  = rtrim($row["product_details"],'****');
        $product_details = explode("****,",$product_string);
        $details      = [];
        $total_amount = 0;
        foreach($product_details as $productData){
            $prod_data = explode("&&&&",$productData);
            $gst_rate = isset($prod_data[7]) && $prod_data[7] !== '' ? $prod_data[7] : 0;
            foreach($array as $value){
                if($value->product_token==$prod_data[1]){
                    $quantity1  = $value->quantity;
                }
            }
            $amount        = $quantity1*$prod_data[3]*$prod_data[4];
            $total_amount += $amount;
            $obj2 = new stdClass();
            $obj2->product_name      = $prod_data[0];
            $obj2->product_token     = $prod_data[1];
            $obj2->product_mrp       = $prod_data[2];
            $obj2->product_total_cost= $prod_data[3];
            $obj2->piece_count       = $prod_data[4];
            $obj2->item_code         = $prod_data[5];
            $obj2->batch_number      = $prod_data[6];
            $obj2->quantity          = $quantity1;
            $obj2->discount_percent  = 0;
            $obj2->discount_amount   = 0;
            $obj2->amount            = number_format($amount, 2, '.', '');
            $obj2->final_amount      = number_format($amount, 2, '.', '');
            $obj2->gst_rate          = isset($prod_data[7]) && $prod_data[7] !== '' ? $prod_data[7] : 0;
            array_push($details, $obj2);
        }
        $resultOffer = mysqli_query($link, "SELECT `admin_offers`.`token`,
        `admin_offers`.`offer_percentage`,
        `admin_offers`.`offer_name`,
        `admin_offers`.`division_token`
        FROM `admin_offers` 
        WHERE `division_token`='$division_token'
        AND `minimum_purchase_amount`<='$total_amount'
        AND `status`='1' AND `state_id`='$state'
        ORDER BY `minimum_purchase_amount` DESC
        LIMIT 0,1");
        if(mysqli_num_rows($resultOffer)>0){
            $rowOffer = mysqli_fetch_array($resultOffer);
            // echo 'check1 - '.$rowOffer['division_token'];
            $offer_percentage= $rowOffer['offer_percentage'];
            $offer_token     = $rowOffer['token'];
            $offer_name      = $rowOffer['offer_name'];
        }else{
            //  echo 'check2 - ';
            $offer_percentage= 0;
            $offer_token     = '';
            $offer_name      = '';
        }
        $div_discount_amount   = $total_amount*$offer_percentage/100;
        $final_amount          = $total_amount-$div_discount_amount;
        $units = 'Box';
        foreach($details as $value){
            $product_discount_amount = $value->amount*$offer_percentage/100;
            $product_final_amount    = number_format($value->amount-$product_discount_amount, 2, '.', '');
            $value->discount_percent = $offer_percentage;
            $value->discount_amount  = number_format($product_discount_amount, 2, '.', '');
            $value->final_amount     = number_format($product_final_amount, 2, '.', '');
            
            $item_gst_rate = $value->gst_rate;
            $gst_multiplier = 1 + ($item_gst_rate / 100);
            $gst_amount = number_format($product_final_amount / $gst_multiplier * $item_gst_rate / 100, 2, '.','');
            $gst_total_amount += number_format($gst_amount, 2, '.', '');
            $basicRate_total += number_format($product_final_amount / $gst_multiplier, 2, '.', '');
            $basicRate = number_format($product_final_amount / $gst_multiplier, 2, '.','');
            $slno++;
            $html .= '<tr>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$slno.'</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;height:40px;">'.$value->product_name.'</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$value->item_code.'</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$value->quantity.' box</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$basicRate.'</span></td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">'.$value->discount_percent.'%</td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$gst_amount.'</span></td>
                    <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$product_final_amount.'</span></td>
                    </tr>';
            $orderproduct_array[] = "('$order_id','$value->product_token','$value->product_total_cost','$value->piece_count','$gst_amount','$value->quantity','0','$offer_token','$value->discount_percent','$product_discount_amount','$product_final_amount','$units','0','0','0','0','0','$item_gst_rate','$indiaDateTime')";

            
           $array1 =[];
           $freeproduct1=0;
           $freeproduct2=0;
           $free1=0;
           $free2=0;
           $limit1=0;
           $limit2=0;
           $quantity = 0;
           $token_count=0;
            $is_offer_product = mysqli_query($link,"SELECT `id`,`token`, `product_token`, `scheme_name`, `limit_box`, `free_box`, `start_date`, `end_date`, `is_scheme`,`free_product` FROM `products__scheme` WHERE `product_token`='$value->product_token' AND `is_scheme`='1'");
            $count1 = mysqli_num_rows($is_offer_product);
            $division=$division_token;
            if($count1 > 0){
            while($row1=mysqli_fetch_array($is_offer_product)){
                $obj = new stdClass();
                $obj->scheme_token = $row1["token"];
                $obj -> product_token = $row1["product_token"];
                $obj->free_box = $row1["free_box"];
                $obj->free_product = $row1["free_product"]==0?0:$row1["free_product"];
                $obj->limit_box = $row1["limit_box"];
                array_push($array1,$obj);
            }
             //print_r($array1);
             $scheme_token= (array_column($array1, 'scheme_token'));
             $counts =count($scheme_token);
             if($counts ==1){
              $scheme_token1 = $scheme_token[0];
             }else{
                $scheme_token1 = $scheme_token[0];
                $scheme_token2=$scheme_token[1];
             }
         $free_product = (array_column($array1, 'free_product'));
         $count =count($free_product);
         if($count ==1){
          $freeproduct1 = $free_product[0];
         }else{
            $freeproduct1 = $free_product[0];
            $freeproduct2=$free_product[1];
         }
          $data=(array_column($array1, 'limit_box'));
          $count1 =count($data);
          if($count1 ==1){
            $limit1 = $data[0];
          }else{
            $limit1 = $data[0];
            $limit2 = $data[1];
          }
           $free =(array_column($array1, 'free_box'));
          $count2=count($free);
          if($count2==1){
           $free1=$free[0];
          }else{
            $free1=$free[0];
           $free2=$free[1];
          }
          if($division_token ==70049216){
            foreach($array as $data)
            {
            $quantity +=$data->quantity;
          }
        }
         
           //limit=20
                 if($value->quantity === $limit1 && $limit2==0 && $freeproduct1!=0 && $division!=70049216){
                               $free_box_val1 =(int)($value->quantity/$limit1);
                               $freeProduct_count =$free_box_val1 *$free1;
                                $freeProduct = $freeProduct_count;
                                $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$indiaDateTime')";
                            }
                            //limit=40
                            elseif($value->quantity == $limit2 && $freeproduct2!=0 && $division!=70049216){
                                 $free_box_val1 = (int)($value->quantity/$limit2);
                                 $freeProduct_count = $free_box_val1*$free2;
                                  $freeProduct =(int) $freeProduct_count;
                                  $orderproduct_array[] = "('$order_id','$freeproduct2','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token2','0','0','0','$indiaDateTime')";
                                }
                                //limit>20
                                elseif($value->quantity > $limit1 && $freeproduct1!=0 && $freeproduct2==0 && $division!=70049216){
                                $free_box_val2 = intdiv($value->quantity,$limit1);
                                $free_box_val3 = fmod($value->quantity,$limit1);
                                if($free_box_val3 ==0){
                                $freeProduct_count1 = $free_box_val2*$free1;
                                $freeProduct = $freeProduct_count1;
                                $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$indiaDateTime')";
                            }elseif($free_box_val3 > 0 && $limit2==0){
                                $free_box_val2 = intdiv($value->quantity,$limit1);
                                $freeProduct_count1 = $free_box_val2*$free1;
                                $freeProduct = $freeProduct_count1;
                                $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$indiaDateTime')";
                            }
                            //limit2,limit1>value
                            else{
                                if($free_box_val3 > 0){
                                    $free_box_val6 = intdiv($free_box_val3,$limit2);
                                    $freeProduct = $free_box_val2*$free1 + $free_box_val6 * $free2;
                                    $orderproduct_array[] = "('$order_id','$freeproduct2','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token2','0','0','0','$indiaDateTime')";

                                }
                            }
                        }
                        //limit2>40
                        elseif($value->quantity > $limit2 && $limit2!=0 && $freeproduct1!=0 && $freeproduct2==0 && $division!=70049216){
                                $free_box_val4 = intdiv($value->quantity,$limit2);
                                $free_box_val5 = fmod($value->quantity,$limit2);
                                if($free_box_val4 > 0 || $free_box_val5 ==0){
                                $freeProduct_count1 = $free_box_val4*$free2;
                                $freeProduct = $freeProduct_count1;
                                $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$indiaDateTime')";
                            }
                }
                //freeproduct value 1
                elseif($limit1==$value->quantity && $freeproduct1!=0 && $division!=70049216){
                    $free_box_val1 =(int)($value->quantity/$limit1);
                               $freeProduct_count =$free_box_val1 *$free1;
                                $freeProduct = $freeProduct_count;
                                $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$indiaDateTime')";
                }elseif($limit2==$value->quantity && $freeproduct2!=0 && $division!=70049216){
                    $free_box_val1 =(int)($value->quantity/$limit2);
                               $freeProduct_count =$free_box_val1 *$free2;
                                $freeProduct = $freeProduct_count;
                                $orderproduct_array[] = "('$order_id','$freeproduct2','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1',''$scheme_token2,'0','0','0','$indiaDateTime')";
                }
                //free product limit > 0
                elseif($freeproduct1!=0 && $value->quantity > $limit1 && $division!=70049216){
                    $free_box_val2 = intdiv($value->quantity,$limit1);
                    $free_box_val3 = fmod($value->quantity,$limit1);
                    if($free_box_val3 ==0){
                    $freeProduct_count1 = $free_box_val2*$free1;
                    $freeProduct = $freeProduct_count1;
                    $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1',''$scheme_token1,'0','0','0','$gst_rate','$indiaDateTime')";
                }else{
                    if($free_box_val3 > 0){
                        $free_box_val6 = intdiv($free_box_val3,$limit2);
                        $freeProduct = $free_box_val2*$free1 + $free_box_val6 * $free2;
                        $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$gst_rate','$indiaDateTime')";

                    }
                }
            }
            //freproduct 2
            elseif($freeproduct2!=0 && $value->quantity > $limit2 && $division!=70049216){
                $free_box_val4 = intdiv($value->quantity,$limit2);
                $free_box_val5 = fmod($value->quantity,$limit2);
                if($free_box_val4 > 0 || $free_box_val5 ==0){
                $freeProduct_count1 = $free_box_val4*$free2;
                $freeProduct = $freeProduct_count1;
                $orderproduct_array[] = "('$order_id','$freeproduct2','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token2','0','0','0','$gst_rate','$indiaDateTime')";
            }
        }elseif($division == 70049216 && $freeproduct1!=0){
             if($value->quantity==$limit1 && $value->quantity!=5){
                $free_box_val1 =floor($value->quantity/$limit1);
                               $freeProduct_count =$free_box_val1 *$free1;
                                $freeProduct = $freeProduct_count;
            $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1','$scheme_token1','0','0','0','$gst_rate','$indiaDateTime')";
            }
        elseif($value->quantity > $limit1 && $value->quantity!=5){
            $free_box_val1 =floor($value->quantity/$limit1);
            $freeProduct_count =($free_box_val1+$free_box_val1) *$free1;
            $freeProduct = $freeProduct_count;
            $orderproduct_array[] = "('$order_id','$freeproduct1','$value->product_total_cost','$value->piece_count','0','$freeProduct','0','0','0','0','0','$units','1',''$scheme_token1,'0','0','0','$gst_rate','$indiaDateTime')";
             }
            }
            $query = mysqli_query($link,"SELECT `product_token`, `employee_token` FROM `stock__distributor` WHERE `product_token`= '$value->product_token' AND `employee_token`='$distributor_token'");
            if(mysqli_num_rows($query) == 0){
                $stock_distributor_Added_Product = mysqli_query($link,"INSERT INTO `stock__distributor`(`product_token`, `pro_cat_token`, `employee_token`, `stock_in_hand`, `monthly_avg`, `mfs`, `aog`, `status`) VALUES ('$value->product_token','$division_token','$distributor_token','0','0','0','0','Added')");
            } 
        }
    }
        $items = $slno;
        $obj = new stdClass(); 
        $obj->division_token   = $division_token;
        $obj->division_name    = $row['division_name'];
        $obj->discount_percent = $offer_percentage;
        $obj->discount_amount  = number_format($div_discount_amount, 2, '.', '');
        $obj->division_amount  = number_format($total_amount, 2, '.', '');
        $obj->final_amount     = number_format($final_amount, 2, '.', '');
        $obj->product_details  = $details;
        $total_final_amount += number_format($obj->final_amount, 2, '.', '');
        array_push($finalArray, $obj);

    }
    // exit();
    $order_free_product = mysqli_query($link,"INSERT INTO `orders__items`(`order_token`, `product_token`, `price_per_unit`, `piece_count`, `misc_price`, `quantity`, `return_qty`, `offer_token`, `offer_percentage`,`offer_value`, `offer_amount`, `units`, `is_free`,`scheme_token`, `is_discount_enable`, `product_dis_price`, `product_price`, `gst_percent`, `date_time`) VALUES".implode(", ", $orderproduct_array));


    $numbertoWord = numbertoword($total_final_amount);
    $html .= '<tr>
                <th style="border: 1px solid #ccc;padding: 8px 10px;"></th>
                <th style="border: 1px solid #ccc;padding: 8px 10px;">Sub Total</th>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$basicRate_total.'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;"></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$gst_total_amount.'</span></td>
                <td style="border: 1px solid #ccc;padding: 8px 10px;">Rs <span>'.$total_final_amount.'</span></td>
            </tr>
    </tbody>
        </table>
        <table style="width: 100%;font-size: 12px;line-height: 44px;text-align: right;">
            <tr>
                <th style="text-align: left;width:50%;" colspan="4">Estimate Total</th>
                <th style="display: block;" colspan="7"><span style="border-top: 1px solid #727272;border-bottom: 1px solid #727272;padding: 10px 0;">Rs <span>'.$total_final_amount.'</span></span></th>
            </tr>
            <tr>
                <td  colspan="8" style="text-align: left;width:100%;"><b>Amount In Words</b> : <span>'.$numbertoWord.'</span></td>
            </tr>
            <tr>
                <th style="text-align: left;padding-top: 30px;" >Signature</th>
            </tr>
        </table>
        
        </td>
        </tr>
        </table>
    </body>
    </html>';
$stort_time = strtotime(date("Y-m-d H:i:s"));
$stort_time = strtotime($indiaDateTime);
$fileName   = "invoice_".$order_id.$stort_time.".pdf";
$update_order = mysqli_query($link,"UPDATE `orders` SET `items`='$items',`billing_amount`='$total_final_amount',`gst`='$gst_total_amount',`invoice_name`='$fileName' WHERE `token`='$order_id'");
      
$obj = new stdClass();
$obj->status_code = 200;
$obj->header = "Success";
$obj->message = "Order Created Successfully";
 
echo json_encode($obj);  
?>
