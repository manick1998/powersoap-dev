<?php
$obj=new stdClass();
include_once '../config/core.php';
$inputData = getInputs();
include_once '../config/database.php';
$database = new Database();
$db = $database->getConnection();
//if($inputData->dashboard_code == $verification_code){
    $distributor_token = $inputData->distributor_token;
    $state_id = mysqli_query($link,"SELECT `state_id` from `employees` WHERE `token`='$distributor_token'");
    $row22 = mysqli_fetch_assoc($state_id);
    $state = $row22['state_id'];
    include_once '../objects/order.php';
    $order = new Order($db);
    if($inputData->type == "update_box_count"){
        $order->boxCount = $inputData->boxCount;
        $order->product_token = $inputData->product_token;
        $order->admin_token = $inputData->admin_token;
        $order->distributorToken = $inputData->distributor_token;
        $order->category_token = $inputData->category_token;
        $order->price_per_unit = $inputData->price_per_unit;
        $order->piece_count = $inputData->piece_count;
        $order->order_token = $inputData->order_token;
        $order->order_array = $inputData->order_array;
        $data = $order->getDetail();
        $order->old_quantity = $data->quantity;
        $product_token = $inputData->product_token;
        $boxcount = $inputData->boxCount;
            if($order->updateDivisionOfferAmount($indiaDateTime,$state)){
                $order->insertFreeProduct($indiaDateTime);
                $stmtBillAmt = $order->updateBillAmts();
                $order->updateboxInsertLog($indiaDateTime);
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Updated Box Count!";
            }else{
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "Not Able to update!"; 
            }
    }else if($inputData->type == "update_discount_value"){
        $order->discount_value = $inputData->discount_value;
        $total_amount = $inputData->box_price*$inputData->distributor_quantity;
        $item_discount_amount = $total_amount*$inputData->discount_value/100;
        $item_total_amount = number_format($total_amount-$item_discount_amount, 2, '.', '');
        $product_token = $inputData->product_token;
        $order->total_amount = $item_total_amount;
        $stmt_gst = $db->prepare("SELECT `gst` FROM `products` WHERE `token`=?");
        $stmt_gst->execute([$product_token]);
        $gst_str = $stmt_gst->fetchColumn();
        $gst_rate = $gst_str !== false && $gst_str !== '' ? $gst_str : 0;
        $gst_multiplier = 1 + ($gst_rate / 100);
        $misc_price = number_format($item_total_amount / $gst_multiplier * $gst_rate / 100, 2, '.', '');
        $order->gst_amount = $misc_price;
        $order->product_token = $product_token;
        $order->order_token = $inputData->order_token;
            if($order->addDiscountDistributor()){
                if($order->updateBillAmts()){
                    $obj->status_code = 200;
                    $obj->header = "Success";
                    $obj->message = "Discount Added Successfully!";  
                }
            }else{
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "Not Able to add Discount!"; 
            }
    }else if($inputData->type == "deleteItem"){
        $order->product_token = $inputData->product_token;
        $order->order_token = $inputData->order_token;
        $order->admin_token = $inputData->admin_token;
        $order->distributorToken = $inputData->distributor_token;
        $data2 = $order->getDetails();
        $order->old_quantity = $data2->quantity;
        $order->discount_distributor = $data2->discount_distributor;
        $stmtsel = $order->selectOrderItemCount();
        $order->item_count = (int)$stmtsel-1;
            if($order->deleteDistributorOrderItem()){
                $order->deleteProductInsertLog($indiaDateTime);
                $array1 = $order->selectOrderData();
                $order->order_array = $array1;
                //$order->updateDivisionOfferAmount($indiaDateTime,$state);
                 $stmht = $order->updateOrderItemCount();
                $stmtBillAmt = $order->updateBillAmts();
                $obj->status_code = 200;
                $obj->header = "Success";
                $obj->message = "Deleted Successfully!";
                //$obj->message = "Discount Added Successfully!";
            }else{
                $obj->status_code = 400;
                $obj->header = "Oops";
                $obj->message = "Not Able to add Discount!"; 
            }
    }else if($inputData->type == "add_new_product"){
        $order->division_token = $inputData->division_token;
        $order->product_token = $inputData->product_token;
        $order->piece_count = $inputData->per_box_piece;
        $order->boxCount = $inputData->box_count;
        $order->distributorToken = $inputData->distributor_token;
        $order->order_token = $inputData->order_token;
        $order->admin_token = $inputData->admin_token;
        $stmtsel = $order->selectOrderItemCount();
        $order->item_count = (int)$stmtsel+1;      
          $numRow = $order->isProductAlreadyExistsForOrder();
            if($numRow->rowCount() > 0){
                  $order1 = $order->updateExistProductData();
            }else{
                $order->addItemInDistributorOrder($indiaDateTime);
                $stmht = $order->updateOrderItemCount();
            }
         $array1 = $order->selectOrderData();
         $order->order_array = $array1;
         $order->updateDivisionOfferAmount($indiaDateTime,$state);
         $st = $order->insertFreeProduct($indiaDateTime);
         $stmtBillAmt = $order->updateBillAmts();
         $order->addProductInsertLog($indiaDateTime);
         $obj->status_code = 200;
         $obj->header = "success";
         $obj->message = "Added New item!"; 
    }else if($inputData->type == "offer_percentage_value"){
        $order->offer_percentage = $inputData->offer_percentage;
        $order->product_token = $inputData->product_token;
        $order->distributorToken = $inputData->distributor_token;
        $order->box_price = $inputData->box_price;
        $order->distributor_quantity = $inputData->distributor_quantity;
        $order->order_token = $inputData->order_token;
        $productAmount = $inputData->distributor_quantity*$inputData->box_price;
        $offerAmount = $productAmount*$inputData->offer_percentage/100;
        $order->offer_value = $offerAmount;
        $billAmount = number_format($productAmount-$offerAmount, 2, '.', '');
        $product_token = $inputData->product_token;
        $stmt_gst = $db->prepare("SELECT `gst` FROM `products` WHERE `token`=?");
        $stmt_gst->execute([$product_token]);
        $gst_str = $stmt_gst->fetchColumn();
        $gst_rate = $gst_str !== false && $gst_str !== '' ? $gst_str : 0;
        $gst_multiplier = 1 + ($gst_rate / 100);
        $order->gstAmount = number_format($billAmount / $gst_multiplier * $gst_rate / 100, 2, '.', '');
        $order->billAmount = $billAmount;
        $order->admin_token = $inputData->admin_token;
        $data1 = $order->getDetails();
        $order->old_quantity = $data1->quantity;
        $order->discount_distributor = $data1->discount_distributor;
        if($order->updateOfferPercentage()){
            $stmtBillAmt = $order->updateBillAmts();
            $order->updatediscountInsertLog($indiaDateTime);
            $obj->status_code = 200;
            $obj->header = "success";
            $obj->message = "Update offer percentage!"; 
        }else{
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Not update offer percentage!"; 
        }
    }
    
    echo json_encode($obj);
//}
?>