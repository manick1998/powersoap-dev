
<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
include_once '../config/database.php';
include_once '../objects/orders.php';
include_once '../config/core_distributor.php';
$input_data = json_decode(file_get_contents("php://input"));
if ($input_data->dashboard_code == $verification_code) {
    $distributor_token = $input_data->distributor_token;
    $type = $input_data->type;
    $database = new Database();
    $db = $database->getConnection();
    $orderList = new OrderList($db);
    $obj = new stdClass;
    $orderList->distributor_token = $distributor_token;
    if ($type == "count") {
        $orderList->orderType = "Sales Order";
        $stmt = $orderList->orderCheckCount();
        $obj = $stmt->rowCount();
    } else if ($type == "particular_order_detail") {
        $orderList->token = $input_data->order_token;
        $updateBillAmt = $orderList->updateBillAmts();
        $updateOutstandingAmt = $orderList->updateOutstandingAmts();
        $stmt = $orderList->individualShopDetail();
        $stmt1 = $orderList->individualShopOrderDetail();
        $stmt2 = $orderList->individualShopPaymentDetail();
        $num = $stmt->rowCount();
        if ($num) {
            $data = $orderList->viewIndividualShopDetail($stmt);
            $orderList->shop_token = $data->shop_token;
            $data1 = $orderList->viewIndividualShopOrderDetail($stmt1);
            $key_value = count($data1) - 1;
            $orderList->dis_val = $data1[$key_value]->dicount_total_value;
            $outstand = $orderList->getTotalBillAndPaidAmt();
            $data2 = $orderList->viewIndividualShopPaymentDetail($stmt2);
            $updateBillAmShopWise = $orderList->updateBillAmtsShopWise();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->message = "Individual Order List";
            $obj->data = $data;
            $obj->data_item = $data1;
            $obj->data_payment = $data2;
        } else {
            $obj->status_code = 400;
            $obj->header = "Oops";
            $obj->message = "No Individual Order List Found";
        }
    } else if ($type == "discount_bill_amount") {
        $discount_type = $input_data->discount_type;
        if ((int)$input_data->discount_amount != 0 || (float)$input_data->discount_percentage != 0) {
            if ($discount_type == 'Rs') {
                $orderList->discount_percentage = 0;
                $orderList->bill_discount_amount = $input_data->discount_amount;
            } else if ($discount_type == '%') {
                $orderList->discount_percentage = $input_data->discount_percentage;
                $orderList->bill_discount_amount = 0;
            }
        } else {
            $orderList->bill_discount_amount = 0;
            $orderList->discount_percentage = 0;
        }
        $orderList->token = $input_data->order_token;
        $orderList->shop_token = $input_data->shop_token;
        if ($orderList->discountBillAmount()) {
            $stht = $orderList->updateBillAmts();
            $shop_outstanding = $orderList->singleShopOutstanding();
            $obj->status_code = 200;
            $obj->outstand_data = $shop_outstanding;
            $obj->header = "Success";
            $obj->message = "Discount from Bill Amount";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Error Occuring While Discount the Bill Amount";
        }
    } else if ($type == "item_productList") {
        $orderList->product_token = $input_data->product_token;
        $orderList->token = $input_data->order_token;
        $stmt12 = $orderList->selectSingleProduct();
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->message = "Selected free column value";
        $obj->data = $stmt12;
    } else if ($type == "AddFreeForproduct") {
        $orderList->product_token = $input_data->product_token;
        $orderList->token = $input_data->order_token;
        $orderList->shop_token = $input_data->shop_token;
        $free_quantity = $input_data->free_quantity;
        $free_type = $input_data->free_type;
        $orderList->free_quantitys = $free_quantity . ' ' . $free_type;
        if ($orderList->addFreeForproduct()) {
            $stht = $orderList->updateBillAmts();
            $shop_outstanding = $orderList->singleShopOutstanding();
            $obj->status_code = 200;
            $obj->outstand_data = $shop_outstanding;
            $obj->header = "Success";
            $obj->message = "Added free for product";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Error Occuring While free for product the Bill Amount";
        }
    } else if ($type == "addQuantityForproduct") {
        $orderList->piece_count = $input_data->getPieces_count;
        $orderList->sold_pieces = $input_data->getProductSoldPiece;
        $orderList->price_per_unit = $input_data->getper_unit_price;
        $orderList->product_token = $input_data->product_token;
        $orderList->units = $input_data->units;
        $orderList->token = $input_data->order_token;
        $orderList->quantitys = $input_data->quantity;
        $orderList->shop_token = $input_data->shop_token;
        if ($input_data->units == 'Box') {
            if ($input_data->addQunatinStock != '' && $input_data->addQunatinStock != 0) {
                $stock_in_hand = $orderList->selectStockOrderDistributor($distributor_token, $orderList->product_token);
                $newStockInHand = $stock_in_hand + $input_data->addQunatinStock;
                $balanace_pieces = $input_data->getProductSoldPiece;
                $stmt = $orderList->returnStockOnCancel($orderList->product_token, $newStockInHand, $balanace_pieces, $distributor_token);
            } else if ($input_data->reducedQunatinStock != '' && $input_data->reducedQunatinStock != 0) {
                $stock_in_hand = $orderList->selectStockOrderDistributor($distributor_token, $orderList->product_token);
                $newStockInHand = $stock_in_hand - $input_data->reducedQunatinStock;
                $balanace_pieces = $input_data->getProductSoldPiece;
                $stmt = $orderList->returnStockOnCancel($orderList->product_token, $newStockInHand, $balanace_pieces, $distributor_token);
            }
        } else {
            if ($input_data->addQunatinStock != '' && $input_data->addQunatinStock != 0) {
                $stock = $input_data->addQunatinStock;
                $stock_in_hand = $orderList->selectStockOrderDistributor($distributor_token, $orderList->product_token);
                $sold_pieces = $orderList->selectStockOrderDistributorsold($distributor_token, $orderList->product_token);
                if ($stock != '' && $stock < $orderList->piece_count) {
                    $balanace = abs($sold_pieces - $stock);
                    $balanace_piece = $balanace != ($orderList->piece_count) ? $balanace : 0;
                } else {
                    $balanace_piece = $stock;
                }

                if ($balanace_piece == 0) {
                    $balanace_pieces = $balanace_piece;
                    $newStockInHand = $balanace_piece == 0 ? $stock_in_hand : $balanace_piece;
                } else if ($balanace_piece < $input_data->getPieces_count) {
                    $balanace_pieces = $balanace_piece;
                    $newStockInHand = $balanace_piece > 0 ? $stock_in_hand : $balanace_piece;
                }
                if ($balanace_piece >= $input_data->getPieces_count) {
                    $quotient = intdiv($balanace_piece, $input_data->getPieces_count);
                    $remainder = fmod($balanace_piece, $input_data->getPieces_count);
                    if ($remainder == 0) {
                        if ($stock_in_hand > 0 && $sold_pieces == 0) {
                            $newStockInHand = $stock_in_hand + $quotient;
                            $balanace_pieces = $remainder == 0 ? 0 : $remainder;
                        } else {
                            $newStockInHand = $stock_in_hand - $quotient;
                            $balanace_pieces = $remainder == 0 ? 0 : $remainder;
                        }
                    } else {
                        $balanace_pieces = $remainder;
                        $newStockInHand = $balanace_piece + $input_data->getPieces_count != 0 ? $stock_in_hand + $quotient : $stock_in_hand;
                    }
                }
                $stmt = $orderList->returnStockOnCancel($orderList->product_token, $newStockInHand, $balanace_pieces, $distributor_token);
            } else if ($input_data->reducedQunatinStock != '' && $input_data->reducedQunatinStock != 0) {
                $stock = $input_data->reducedQunatinStock;
                $stock_in_hand = $orderList->selectStockOrderDistributor($distributor_token, $orderList->product_token);
                $sold_pieces = $orderList->selectStockOrderDistributorsold($distributor_token, $orderList->product_token);
                $newStockInHand = $stock_in_hand;
                $balanace_piece = $input_data->getProductSoldPiece + $stock;
                if ($balanace_piece < $input_data->getPieces_count) {
                    $balanace_pieces = $balanace_piece;
                }
                if ($balanace_piece >= $input_data->getPieces_count) {
                    $quotient = intdiv($balanace_piece, $input_data->getPieces_count);
                    $remainder = fmod($balanace_piece, $input_data->getPieces_count);
                    if ($remainder == 0) {
                        if ($stock_in_hand > 0 && $sold_pieces == 0) {
                            $newStockInHand = $stock_in_hand + $quotient;
                            $balanace_pieces = $remainder == 0 ? 0 : $remainder;
                        }
                        // else if($stock_in_hand > 0 )
                        // $newStockInHand = $stock_in_hand + $quotient;
                        // $balanace_pieces = $remainder == 0 ? 0 : $remainder;
                        // }
                        else {
                            $newStockInHand = $stock_in_hand - $quotient;
                            $balanace_pieces = $remainder == 0 ? 0 : $remainder;
                        }
                    } else {
                        $balanace_pieces = $remainder;
                        $newStockInHand = $balanace_piece - $input_data->getPieces_count != 0 ? $stock_in_hand + $quotient : $stock_in_hand;
                    }
                }
                $stmt = $orderList->returnStockOnCancel($orderList->product_token, $newStockInHand, $balanace_pieces, $distributor_token);
            }
        }
        if ($orderList->addQuantityForproduct()) {
            $quantityCount = $orderList->selectFreeQunatityCount();
            $total_stockInHand = $newStockInHand + $quantityCount;
            $orderList->insertFreeProduct($indiaDateTime, $total_stockInHand, $distributor_token);
            $stht = $orderList->updateBillAmts();
            $shop_outstanding = $orderList->singleShopOutstanding();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->outstand_data = $shop_outstanding;
            $obj->message = "Added quantity for product";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Error Occuring While adding product quantity";
        }
    } else if ($type == "deleteItem") {
        $orderList->product_token = $input_data->product_token;
        $orderList->token = $input_data->order_token;
        $orderList->piece_count = $input_data->getPieces_count;
        $orderList->sold_pieces = $input_data->getProductSoldPiece;
        $orderList->shop_token = $input_data->shop_token;
        $orderList->addQunatityinStock = $input_data->addQunatityinStock;
        $stock_in_hand = $orderList->selectStockOrderDistributor($distributor_token, $orderList->product_token);
        $quantity = $orderList->selectFreeQunatityCount();
        $newStockInHand = $stock_in_hand + $input_data->addQunatityinStock + $quantity;
        if ($input_data->getProductSoldPiece >= $input_data->getPieces_count) {
            $balanace_pieces = $input_data->getProductSoldPiece - $input_data->getPieces_count;
        } else {
            $balanace_pieces = $stock_in_hand;
        }
        $stmt = $orderList->returnStockOnCancel($orderList->product_token, $newStockInHand, $balanace_pieces, $distributor_token);
        if ($orderList->updateOrderItem()) {
            $stht = $orderList->updateBillAmts();
            $shop_outstanding = $orderList->singleShopOutstanding();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->outstand_data = $shop_outstanding;
            $obj->message = "Deleted Item from sales order";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Not Able to Delete the Item from sales order";
        }
    } else if ($type == "updateDiscountValue") {
        $orderList->selcted_product_token = $input_data->selcted_product_token;
        $orderList->discountValue = $input_data->discountValue;
        $orderList->order_token = $input_data->order_token;
        $orderList->totalDisCountAmount = $input_data->totalDisCountAmount;
        if ($input_data->discountValue == "0") {
            $stmt3 = $orderList->updateDisableDiscount();
            $stmt1 = $orderList->updateTotalAmountvalue();
        } else {
            $stmt = $orderList->updateDiscuntvalue();
            $stmt = $orderList->updateDiscountStatus();
            $stmt1 = $orderList->updateTotalAmountvalue();
        }

        if ($stmt1) {
            $shop_outstanding = $orderList->singleShopOutstanding();
            $obj->status_code = 200;
            $obj->header = "Success";
            $obj->outstand_data = $shop_outstanding;
            $obj->message = "Discount Update Successfully";
        } else {
            $obj->status_code = 400;
            $obj->header = "Error";
            $obj->message = "Some thing will append plz conduct developer";
        }
    } else if ($type == "discount") {
        $stmt14 = $orderList->discount();
        $discount = $orderList->readDiscount($stmt14);
        $obj->status_code = 200;
        $obj->header = "Success";
        $obj->discount_data = $discount;
    }

    echo json_encode($obj);
}
