<?php
include "config.php";
include "$api_path/config/core_distributor.php";
session_start();
if (!$_SESSION['distributor_token'] || $_SESSION["verification_code"] != $verification_code) {
    header("Location:login.php");
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Management</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <style>
            .dataTables_scroll {
                overflow: auto;
            }

            .dataTables_scrollHeadInner {
                width: 100% !important;
            }

            .nav-item button {
                white-space: nowrap;
            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>

        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar1"></div>
        <div class="se-pre-con"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main">Retailer Order</h1>
                        </div>
                        <p class="table_count">Total Order - <span id="total_order_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()" type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()" type="text" placeholder="To Date" readonly>
                        </div>
                    </form>
                </div>

                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Order Number</th>
                                <th>Date & Time</th>
                                <th>Shop Name</th>
                                <!-- <th>Order Taken By</th> -->
                                <th>Items</th>
                                <th>Paid Amount</th>
                                <th>Outstanding Amount</th>
                                <th>Delivery</th>
                                <th>Delivered on</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id">
                        </tbody>
                    </table>
                </div>
            </section>


            <section class="bg-white brad-4 full-height" id="toggle1" style="display: none;">
                <div class="header_container">
                    <div class="header-details">

                    </div>
                </div>
                <div class="nav-action-set">
                    <ul class="nav nav-pills mb-3 order-payment-tab" id="pills-tab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <a class="nav-link rightbot active" id="pills-home-tab" data-toggle="pill" href="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Order Details</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link leftbot" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Payments</a>
                        </li>
                    </ul>
                    <div class="nav-action-right-set">
                        <div class="nav-item" id="invoice_button">

                        </div>
                        <div class="order-right-content">
                            <span style="display:block;" class="total_amount_top"></span><span style="display:none;" class="discount_amount_down"></span>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-box ">
                            <table class="custom-table" id="item_list_table">
                                <thead id="item_table_header">
                                </thead>
                                <tbody id="item_table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="payments" class="table-box w3-border city">
                            <div class="table-box">
                                <table class="custom-table" id="item_payment_table">
                                    <thead>
                                        <tr>
                                            <th>SI.No</th>
                                            <th>Date & Time</th>
                                            <th>Mode</th>
                                            <th>Paid Amount</th>
                                            <th>Collected Person</th>
                                        </tr>
                                    </thead>
                                    <tbody id="individual_shop_paid_detail">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <!--Modal-->
            <div class="modal fade" id="formDiscount" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span>Add Offer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control discount_type_box">
                                    <p class="discount_type">Discount Type</p>
                                    <select class="input-field" id="discount_type">
                                        <option value="Rs">Rupees(Rs)</option>
                                        <option value="%">Percentage(%)</option>
                                    </select>
                                </div>
                                <div class="form-control discount_percentage_box">
                                    <p class="discount_type">Discount Percentage</p>
                                    <select class="input-field" id="discount_percentage">
                                        <!-- <option value="0">0%</option>
                                        <option value="0.5">0.5%</option>
                                        <option value="1">1%</option>
                                        <option value="1.5">1.5%</option>
                                        <option value="2">2%</option>
                                        <option value="2.5">2.5%</option>
                                        <option value="3">3%</option> -->
                                    </select>
                                </div>
                                <div class="form-control discount_amount_box">
                                    <p class="discount_amount">Discount Amount</p>
                                    <input class="input-field" id="discount_amount" placeholder="Enter Discount Amount" value="" onkeypress="return isNumber(event)">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" data-dismiss="modal" onclick="add_discount()">Add Discount</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableFreeDiscount" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span>Edit Free Column</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control free_type_box">
                                    <p class="free_type">Free Type</p>
                                    <select class="input-field" id="free_type">
                                        <option value="Box" selected>Box</option>
                                        <option value="Nos">Piece</option>
                                    </select>
                                </div>
                                <div class="form-control free_quantity_box">
                                    <p class="free_quantity">Free Quantity</p>
                                    <input class="input-field" id="free_quantity" placeholder="Enter Free Quantity" value="" onkeypress="return isNumber(event)">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" data-dismiss="modal" onclick="add_free_product()">Add Discount</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tableQuantityEdit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span>Edit Quantity</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control quantity_type_box">
                                    <p class="quantity_type">Quantity type</p>
                                    <!-- <input class="input-field" id="quantity_type" placeholder="Enter Quantity" value="" readonly> -->
                                    <select class="input-field" id="quantity_type">
                                        <option value="Box" selected>Box</option>
                                        <option value="Nos">Nos</option>
                                    </select>
                                </div>
                                <div class="form-control quantity_box">
                                    <p class="quantity">Quantity</p>
                                    <input class="input-field" id="quantity" placeholder="Enter Quantity" value="" onkeypress="return isNumber(event)">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" data-dismiss="modal" onclick="add_quantity()">Update Quantity</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- edit discount modal -->
            <div class="modal fade" id="editDiscountModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span>Edit Discount</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <!-- <div class="form-control quantity_type_box">
                            <p class="quantity_type">Quantity type</p>
                            <input class="input-field" id="quantity_type" placeholder="Enter Quantity" value="" readonly>
                          </div>
                          <div class="form-control quantity_box">
                            <p class="quantity">Quantity</p>
                            <input class="input-field" id="quantity" placeholder="Enter Quantity" value="" onkeypress="return isNumber(event)">
                        </div>  -->
                                <!-- <div class="form-control discountEdit">
                            <p class="quantity">Quantity</p>
                            <input class="input-field" id="edit_Discount_value" placeholder="Enter Discount" value="" onkeypress="return isNumber(event)">
                        </div> -->
                                <div class="form-control discountEdit">
                                    <p class="discount">Select Discount</p>
                                    <select class="input-field" id="edit_Discount_value">
                                        <!-- <option value="0">0%</option>
                                 <option value="1">1%</option>
                                 <option value="1.5">1.5%</option>
                                 <option value="2">2%</option> -->
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" data-dismiss="modal" onclick="Update_Discount()">Update Discount</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        </script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->

        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

        <!-- jquery CDN -->

        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->

        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var table,
                index_data = '',
                gl_order_token = '',
                gl_data = '';
            var distributor_token = "<?php echo $_SESSION["distributor_token"]; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var tcpf_file = "<?php echo $tcpf_file; ?>";

            function back_view_order() {
                location.reload();
                $('#toggle1').hide();
                $('#toggle').show();
            }
            $('.get_url_for_android').on('click', function() {
                let _get_url = $(this).attr('data-url');
                Android.showToast(`${_get_url}`);
            });
            /* Radion button box */
            $('.ratio-btn-selecter').on('click', function() {
                var quickcheck = $(this).attr('data-value');
                if (quickcheck == "image") {
                    $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
                    $('.popup-image-box').removeClass('hidden');
                    $('.popup-video-box').addClass('hidden');
                } else {
                    $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
                    $('.popup-image-box ').addClass('hidden');
                    $('.popup-video-box').removeClass('hidden');
                }
            });

            $(document).ready(function() {
                $('#retailer_order').addClass('active-sidemenu');
                $('#fromDate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    maxDate: 0 
                });
                $('#toDate').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    maxDate: 0 
                });
                data_fetch();
            });

            function data_fetch() {
                $(".se-pre-con").fadeIn();
                var from_date = $("#fromDate").val();
                var to_date = $("#toDate").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDate").val(from_date);
                }
                var to_date = $("#toDate").val();
                table = $('#table_data').DataTable({
                    scrollX: true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }],
                    order: [
                        [2, 'desc']
                    ],
                    'ajax': {
                        'url': api_path + "/distributor/server_retailer_order.php?from_date=" + from_date + "&&to_date=" + to_date + "&&v_id=" + verfication_code + "&&dist_id=" + distributor_token,
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                        }
                    },
                    'columns': [{
                            data: 'order_token'
                        },
                        {
                            data: 'order_number'
                        },
                        {
                            data: 'date_time'
                        },
                        {
                            data: 'shop_name'
                        },
                        // { data: 'sales_man' },
                        {
                            data: 'items'
                        },
                        {
                            data: 'paid_amount'
                        },
                        {
                            data: 'outstanding_amount'
                        },
                        {
                            data: 'delivery'
                        },
                        {
                            data: 'delivered_on'
                        }
                    ],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    }
                });
                table.column(0).visible(false);
                $('.dataTables_length').css("display", "none");
                $(".se-pre-con").fadeOut();
            }


            function date_filter() {
                var from_date = $("#fromDate").val();
                var to_date = $("#toDate").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDate").val(from_date);
                }
                var to_date = $("#toDate").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    table.clear();
                    table.destroy();
                    data_fetch();
                }
            }

            var order_table_check = false;
            var order_payment_table = false;
            var order_table;
            var order_paytable;
            var orderToken_storage;
            var sales_man_name;
            $('#table_data tbody').on('click', '.view_link', function() {
                var td_div = $(this).parent().parent();

                var table_data = table.row(td_div).data();
                var token = table_data.order_token;
                gl_order_token = table_data.order_token;
                orderToken_storage = table_data.order_token;
                sales_man_name = table_data.sales_man;
                particular_order_detail(token, sales_man_name);
                discount();
            });

            var item_data;
            var shop_data;
            var payment_data;

            function particular_order_detail(token, sales_man_name) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    order_token: token,
                    distributor_token: distributor_token,
                    type: "particular_order_detail"
                };
                var json_data = JSON.stringify(datas);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data
                }).done(function(data) {
                    shop_data = data.data;
                    console.log(shop_data);
                    var total_discounted_amount = 0;
                    for (var key in data.data_item) {
                        if (data.data_item[key].dicount_total_value > 0) {
                            total_discounted_amount += data.data_item[key].dicount_total_value;

                        }

                    }
                    // console.log('this',shop_data.invoice_name);
                    var afterDiscountAmount = parseFloat(shop_data.billing_amount - total_discounted_amount).toFixed(2);
                    var gstAmount = parseFloat(afterDiscountAmount * 18 / 100).toFixed(2);
                    var mrpAmount = parseFloat(afterDiscountAmount - gstAmount).toFixed(2);
                    var order_text1 = "";
                    order_text1 += '<div class="title_box">';
                    order_text1 += '<div class="header_box">';
                    order_text1 += '<h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span class="shop_name">' + shop_data.shop_name + '</span></h1>';
                    if (shop_data.delivery == "Pending") {
                        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn voliet status-widget">Pending</button>';
                    } else if (shop_data.delivery == "Cancelled") {
                        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn red status-widget">Cancelled</button>';
                    } else {
                        order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn greenbtn status-widget">Completed</button>';
                    }
                    order_text1 += '</div>';
                    if (shop_data.delivery == "Pending") {
                        order_text1 += '<div class="appr-rej-set"><a href="javascript:void(0)" class="blue_btn" onclick=deliveryOrder(' + shop_data.order_token + ')>Delivery Order</a>';
                        order_text1 += '<a href="javascript:void(0)" onclick=cancel_order(' + shop_data.order_token + ')>Cancel Order</a></div>';
                    }
                    order_text1 += '</div>';
                    order_text1 += '<p class="table_count">' + shop_data.order_token + '</p>';
                    order_text1 += '<div class="details-top-section">';

                    order_text1 += '<div class="details-top-div">';
                    order_text1 += '<p>Date & Time: <span class="label_value">' + shop_data.date_time + '</span></p>';
                    order_text1 += '<p>Amount: <span class="label_value">' + numberFormatComma(shop_data.mrp_amount) + '</span></p>';
                    order_text1 += '<p>Total Discount Amount : ₹ <span class="label_value" id="total_dis_amount"></span></p>';
                    order_text1 += '</div>';
                    order_text1 += '<div class="details-top-div">';
                    // order_text1 += '<p>Order Taken By: <span class="label_value">'+sales_man_name+'</span></p>';
                    order_text1 += '<p>GST(18%): <span class="label_value">Rs.' + numberFormatComma(shop_data.gst_amount) + '</span></p>';
                    order_text1 += '</div>';
                    order_text1 += '<div class="details-top-div">';
                    order_text1 += '<p>Items: <span class="label_value">' + shop_data.items + '</span></p>';
                    order_text1 += '<p>Paid: <span class="label_value">' + numberFormatComma(shop_data.paid_amount) + '</span></p>';
                    order_text1 += '</div>';
                    order_text1 += '<div class="details-top-div">';
                    if (shop_data.delivery == "Cancelled") {
                        order_text1 += '<p>Cancelled on: <span class="label_value">' + shop_data.delivered_on + '</span></p>';
                    } else {
                        if (shop_data.delivered_on == "") {
                            order_text1 += '<p>Delivered on: -</p>';
                        } else {
                            order_text1 += '<p>Delivered on: <span class="label_value">' + shop_data.delivered_on + '</span></p>';
                        }
                    }
                    if (shop_data.delivery != "Cancelled") {
                        order_text1 += '<p>Outstanding: <span style="color: tomato;">' + numberFormatComma(parseFloat(shop_data.total_outstanding).toFixed(0)) + '</span></p>';
                    }

                    order_text1 += '</div>';
                    order_text1 += '</div>';


                    $(".header-details").html(order_text1);
                    //console.log('S',shop_data.invoice_name);
                    if (shop_data.delivery != "Cancelled") {
                        $("#invoice_button").html('<a data-url="' + tcpf_file + shop_data.invoice_name + '" href="../invoice_pdf/' + shop_data.invoice_name + '" class="get_url_for_android" target="_blank"><button class="nav-link nav-item-center active" type="button"><span><img src="assets/invoice_icon.png" class="invoice"></span>Order Value</button></a>');

                        $('.get_url_for_android').on('click', function() {
                            let _get_url = $(this).attr('data-url');
                            Android.showToast(`${_get_url}`);
                        });
                        $("#invoice_button").css("display", "block");
                    } else {
                        $("#invoice_button").css("display", "none");
                    }
                    if (shop_data.bill_discount_amount != 0 || shop_data.bill_discount_percentage != 0) {
                        if (shop_data.bill_discount_percentage != 0) {
                            var discountPer = (parseFloat(shop_data.billing_amount * shop_data.bill_discount_percentage / 100).toFixed(2));
                            $(".order-right-content > .total_amount_top").html('Total Amount: <span class="label_value">Rs.' + numberFormatComma((shop_data.billing_amount - discountPer).toFixed(2)) + '</span>');
                            $("span.discount_amount_down").html('Discount(' + shop_data.bill_discount_percentage + '%): <span class="label_value">Rs:' + discountPer + '</span>');
                            $("span.discount_amount_down").css("display", "block");
                        } else if (shop_data.bill_discount_amount != 0) {
                            $(".order-right-content > .total_amount_top").html('Total Amount: <span class="label_value">Rs.' + numberFormatComma((shop_data.billing_amount - shop_data.bill_discount_amount).toFixed(2)) + '</span>');
                            $("span.discount_amount_down").html('Discount <span id="dis_amount"class="label_value">Rs:' + numberFormatComma((parseInt(shop_data.bill_discount_amount))) + '</span>');
                            $("span.discount_amount_down").css("display", "block");
                        }
                    } else {
                        $(".order-right-content > .total_amount_top").html('Total Amount: <span class="label_value">Rs.' + numberFormatComma(parseFloat(shop_data.billing_amount).toFixed(0)) + '</span>');
                        $("span.discount_amount_down").css("display", "none");
                    }

                    if (order_table_check) {
                        order_table.clear();
                        order_table.destroy();
                    }
                    var total_items = 0;
                    var total_sales = 0;
                    item_data = data.data_item;
                    // console.log(item_data);
                    var html_text = "";
                    var html_th = "";
                    var slno1 = 0;
                    html_th += '<tr>';
                    html_th += '<th>SI.No</th>';
                    html_th += '<th>Item Name</th>';
                    html_th += '<th>Item Code</th>';
                    html_th += '<th>Box Price</th>';
                    html_th += '<th>Per Unit Price</th>';
                    html_th += '<th>Quantity</th>';
                    //                html_th +='<th>Free Column</th>';
                    html_th += '<th id="amId">Amount</th>';
                    html_th += '<th id="disId">Discount</th>';
                    if (shop_data.delivery == "Pending") {
                        html_th += '<th>Action</th>';
                    }
                    html_th += '</tr>';
                    $("#item_table_header").html(html_th);
                    var total_dis_amount = 0;
                    gl_data = item_data;
                    for (var key in item_data) {

                        // var amountValue = item_data[key].amount;
                        slno1++;
                        if (item_data[key].is_free == 1) {
                            html_text += '<tr class="freeColumnColor">';
                        } else {
                            html_text += '<tr>';
                        }
                        html_text += '<td>' + slno1 + '</td>';
                        html_text += '<td>' + item_data[key].item_name + '</td>';
                        html_text += '<td>' + item_data[key].item_code + '</td>';
                        if (item_data[key].is_free != 1) {
                            html_text += '<td>' + numberFormatComma(item_data[key].box_price) + '</td>';
                            html_text += '<td>' + item_data[key].per_unit_price + '</td>';
                        } else {
                            html_text += '<td>-</td>';
                            html_text += '<td>-</td>';
                        }
                        if (shop_data.delivery == "Pending" && item_data[key].is_free != 1) {
                            html_text += '<td>' + item_data[key].quantity + '<a><img src="assets/edit.png" class="edit_input" onclick="item_quantity_edit(' + key + ')" data-toggle="modal" data-target="#tableQuantityEdit"  alt=""></a></td>';
                        } else {
                            html_text += '<td>' + item_data[key].quantity + '</td>';
                        }
                        //               if(shop_data.delivery == "Pending" && item_data[key].is_free != 1){
                        //                    html_text += '<td>'+item_data[key].free_product+'<a><img src="assets/edit.png" class="edit_input" onclick="item_freeproduct_edit('+key+')" data-toggle="modal" data-target="#tableFreeDiscount" alt=""></a></td>';
                        //               }else{
                        //                   html_text += '<td>'+item_data[key].free_product+'</td>';
                        //               }
                        if (shop_data.delivery == "Pending" && item_data[key].is_free != 1) {
                            html_text += '<td>' + numberFormatComma(item_data[key].amount) + '</td>';
                            html_text += '<td ><span style ="display:inline-block;color:#000;" id="discountEditvalue_' + key + '">' + numberFormatComma(item_data[key].discount) + '</span><a onclick="edit_discount(' + key + ')"><img src="assets/edit.png" class="edit_input" data-toggle="modal" data-target="#editDiscountModal"  alt=""></a></td>';
                            total_dis_amount += Number(item_data[key].discount);
                        } else if (shop_data.delivery == "Completed" && item_data[key].is_free != 1) {
                            html_text += '<td>' + numberFormatComma(item_data[key].amount) + '</td>';
                            html_text += '<td ><span style ="display:inline-block;color:#000;" id="discountEditvalue_' + key + '">' + numberFormatComma(item_data[key].discount) + '</span><a onclick="edit_discount(' + key + ')" hidden="hidden"><img src="assets/edit.png" class="edit_input" data-toggle="modal" data-target="#editDiscountModal"  alt=""></a></td>';
                            total_dis_amount += Number(item_data[key].discount);
                        } else if (shop_data.delivery == "Cancelled" && item_data[key].is_free != 1) {
                            html_text += '<td>' + numberFormatComma(item_data[key].amount) + '</td>';
                            html_text += '<td ><span style ="display:inline-block;color:#000;" id="discountEditvalue_' + key + '">' + numberFormatComma(item_data[key].discount) + '</span><a onclick="edit_discount(' + key + ')" hidden="hidden"><img src="assets/edit.png" class="edit_input" data-toggle="modal" data-target="#editDiscountModal"  alt=""></a></td>';
                            total_dis_amount += Number(item_data[key].discount);
                        } else {
                            html_text += '<td>Free</td>';
                            html_text += '<td>-</td>';
                        }
                        if (shop_data.delivery == "Pending") {
                            if (item_data[key].is_free != 1) {
                                html_text += '<td><a href="javascript:void(0)" style="color:red !important;" onclick="deleteItem(' + key + ')">Delete</a></td>';
                            } else {
                                html_text += '<td>-</td>';
                            }
                        }
                        html_text += '</tr>';
                    }
                    // console.log('jj',total_dis_amount);
                    $("#item_table_body").html(html_text);
                    $("#total_dis_amount").append(total_dis_amount);


                    order_table = $("#item_list_table").DataTable({
                        scrollX: true,
                        bLengthChange: false,
                        searching: false,
                        info: true,
                        autoWidth: true,
                        buttons: [],
                        language: {
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
                        },
                        "sScrollXInner": "100%"
                    });
                    order_table_check = true;

                    if (order_payment_table) {
                        order_paytable.clear();
                        order_paytable.destroy();
                    }
                    payment_data = data.data_payment;
                    var html_text1 = "";
                    var slno1 = 0;
                    for (var key in payment_data) {
                        console.log('payment_data', payment_data);
                        slno1++;
                        html_text1 += '<tr>';
                        html_text1 += '<td>' + slno1 + '</td>';
                        html_text1 += '<td>' + payment_data[key].date_time + '</td>';
                        html_text1 += '<td>' + payment_data[key].payment_mode + '</td>';
                        html_text1 += '<td>' + payment_data[key].amount + '</td>';
                        html_text1 += '<td>' + payment_data[key].emp_name + '</td>';
                        html_text1 += '</tr>';
                    }
                    $("#individual_shop_paid_detail").html(html_text1);
                    order_paytable = $("#item_payment_table").DataTable({
                        scrollX: true,
                        bLengthChange: false,
                        searching: false,
                        info: true,
                        buttons: [],
                        language: {
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
                        },
                        "sScrollXInner": "100%"
                    });
                    order_payment_table = true;
                    $(".se-pre-con").hide();
                    $('#toggle').hide();
                    $('#toggle1').show();


                });

            }

            //discount select
            function discount() {
                var data = {
                    dashboard_code: verfication_code,
                    type: "discount"
                };
                var json_data = JSON.stringify(data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data,
                }).done(function(data) {
                    var percentage = data.discount_data;
                    var html = '';
                    for (var key in percentage) {
                        var discount_value = (percentage[key].discount).replace('%', '');
                        html += `<option value="${discount_value}">${percentage[key].discount}</option>`;

                    }
                    $("#edit_Discount_value").append(html);
                });
            }

            // $(document).ready(function(){
            //     $('#item_table_body').each(function(){
            //         alert('hai',$(this).val());

            //     });


            // })

            // $(document).ready(function(){
            //     $('#table_data tbody').on( 'click', '.view_link', function () {
            //             alert($('#item_table_body').html());
            //     });
            // });

            // $(document).on("click","#table_data tbody",function(){
            //     // $('#table_data tbody').on( 'click', '.view_link', function () {
            //     // $('#item_table_body').each(function(){
            //         console.log($('#item_table_body').val());
            //             // var datas = $(this).closest('tr').find('ed:eq(1)').text();
            //             // console.log(datas);
            //     // });
            // //});
            // });

            //order delivery
            function deliveryOrder(order_token) {
                var order_token = order_token;
                swal({
                    title: "Are you sure?",
                    text: "You want to Deliver this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelivery) => {
                    if (willDelivery) {
                        var datas = {
                            'order_token': order_token,
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'shop_token': shop_data.shop_token,
                            'employee_token': shop_data.employee_token,
                            'date_value': shop_data.date_value,
                            'billing_amount': shop_data.billing_amount
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/orderDelivery.php",
                            data: json_data,
                        }).done(function(data) {
                            console.log(data);
                            if (data.status_code == 400) {
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                swal("Order Delivered successfully!", {
                                    icon: "success"
                                });
                                location.reload();
                            }
                        });

                    }
                })

            }

            //cancel order
            function cancel_order(order_token) {
                var order_items = [];
                var token = order_token;
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        for (var key in item_data) {
                            if (item_data[key].units == 'Box') {
                                var variousquantity = item_data[key].quantity;
                                var array = variousquantity.split(" ");
                                var quantity = array[0];
                                var data = {
                                    product_token: item_data[key].product_token,
                                    pieces_count: item_data[key].piece_count * quantity,
                                    sold_pieces: item_data[key].sold_pieces
                                }
                            } else {
                                var variousnosquantity = item_data[key].quantity;
                                var arraynos = variousnosquantity.split(" ");
                                var quantity1 = arraynos[0];
                                var data = {
                                    product_token: item_data[key].product_token,
                                    pieces_count: quantity1,
                                    sold_pieces: item_data[key].sold_pieces
                                }
                            }
                            order_items.push(data);
                        }
                        var datas = {
                            'order_items': order_items,
                            'order_token': token,
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'shop_token': shop_data.shop_token,
                            'employee_token': shop_data.employee_token,
                            'date_value': shop_data.date_value,
                            'billing_amount': shop_data.billing_amount
                        }
                        var json_data = JSON.stringify(datas);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/cancel_order.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Order cancelled successfully!", {
                                    icon: "success"
                                });
                                location.reload();
                                //particular_order_detail(orderToken_storage,sales_man_name);
                            }
                        });
                    }
                });
            }

            function add_discount() {
                var discount_type = $("#discount_type").val();
                var discount_amount = $("#discount_amount").val();
                var discount_percentage = $("#discount_percentage").val();
                let dis_amnt = parseInt(discount_amount);
                let bill_amnt = parseInt(shop_data.billing_amount);
                let bill_per = parseInt(discount_percentage);
                if (discount_amount > 0 || discount_percentage != '') {
                    if ((dis_amnt <= bill_amnt && discount_type == 'Rs') || (bill_per <= 100 && discount_type == '%')) {
                        $(".se-pre-con").show();
                        var datas = {
                            'discount_type': discount_type,
                            'discount_amount': discount_amount,
                            'discount_percentage': discount_percentage,
                            'distributor_token': distributor_token,
                            'order_token': shop_data.order_token,
                            'shop_token': shop_data.shop_token,
                            'bill_amount': shop_data.billing_amount,
                            'type': 'discount_bill_amount',
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/sales_order.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                var datas1 = {
                                    'order_token': shop_data.order_token,
                                    'distributor_token': distributor_token,
                                    'invoice_name': shop_data.invoice_name,
                                    'oustanding_amt': data.outstand_data
                                };
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                                    data: datas1,
                                }).done(function(data) {
                                    //$(".se-pre-con").hide();
                                    swal("Discounted from bill amount!", {
                                        icon: "success"
                                    });
                                    particular_order_detail(orderToken_storage, sales_man_name);
                                });
                            }
                        });
                    } else {
                        swal("Discount Amount Should be less than Actual Amount!");
                    }
                } else {
                    swal("Please Enter Discount Amount!");
                }

            }

            /* ============== Only Allow Numeric value in Phone Field code ============== */
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            var getProductToken;

            function item_freeproduct_edit(key) {
                getProductToken = item_data[key].product_token
                var datas = {
                    'product_token': item_data[key].product_token,
                    'order_token': shop_data.order_token,
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token,
                    'type': "item_productList"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data,
                }).done(function(data) {
                    var item_product_data = data.data;
                    if (item_product_data.free_product != '') {
                        let prod_val = item_product_data.free_product;
                        prod_val = prod_val.split(" ");
                        $("#free_type").val(prod_val[1]);
                        $("#free_quantity").val(prod_val[0]);
                    }
                });
            }

            function add_free_product() {
                $(".se-pre-con").show();
                var free_type = $("#free_type").val();
                var free_quantity = $("#free_quantity").val();
                var datas = {
                    'product_token': getProductToken,
                    'order_token': shop_data.order_token,
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token,
                    'free_type': free_type,
                    'free_quantity': free_quantity,
                    'shop_token': shop_data.shop_token,
                    'type': "AddFreeForproduct"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data,
                }).done(function(data) {

                    if (data.status_code == 400) {
                        $(".se-pre-con").hide();
                        swal("Something happened!");
                    } else if (data.status_code == 200) {
                        var datas1 = {
                            'order_token': shop_data.order_token,
                            'distributor_token': distributor_token,
                            'invoice_name': shop_data.invoice_name,
                            'oustanding_amt': data.outstand_data
                        };
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                            data: datas1,
                        }).done(function(data) {
                            $(".se-pre-con").hide();
                            swal("Free Added For Product!", {
                                icon: "success"
                            });
                            particular_order_detail(orderToken_storage, sales_man_name);
                        });
                    }
                });
            }

            var getProductQuaToken;
            var getProductQuantity;
            var getProductUnits;
            var getProductSoldPiece;
            var getPieces_count;
            var getper_unit_price;
            var prdQuantity;
            var reducedQunatinStock = '';
            var addQunatinStock = '';

            function item_quantity_edit(key) {
                getProductQuaToken = item_data[key].product_token;
                getProductQuantity = item_data[key].quantity;
                getProductUnits = item_data[key].units;
                getProductSoldPiece = item_data[key].sold_pieces;
                getPieces_count = item_data[key].piece_count;

                getper_unit_price = item_data[key].per_unit_price;
                prdQuantity = getProductQuantity.split(" ");

                var datas = {
                    'product_token': item_data[key].product_token,
                    'order_token': shop_data.order_token,
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token,
                    'type': "item_productList"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data,
                }).done(function(data) {
                    var item_productQuantity_data = data.data;
                    $("#quantity_type").val(item_productQuantity_data.units);
                    $("#quantity").val(item_productQuantity_data.quantity);
                });
            }

            function add_quantity() {
                var quantity = $("#quantity").val();
                var quantity_type = $("#quantity_type").val();
                let prd_qn = parseInt(prdQuantity[0]);
                let qty = parseInt(quantity);
                addQunatinStock=0;
                reducedQunatinStock=0;
                if (quantity > 0) {
                    if (quantity_type == 'Box') {
                        if (prd_qn > qty) {
                            var addQunat = prd_qn - qty;
                            addQunatinStock = addQunat;
                        } else {
                            reducedQunat = qty - prd_qn;
                            reducedQunatinStock = reducedQunat;
                        }
                    } else {
                        if (prd_qn > qty) {
                            var addQunat = prd_qn - qty;
                            addQunatinStock = addQunat;
                        } else if (prd_qn == qty) {
                            var addQuant = prd_qn - qty;
                            if (addQuant == 0) {
                                addQunatinStock = qty;
                            }
                        } else {
                            reducedQunat = qty - prd_qn;
                            reducedQunatinStock = reducedQunat;
                        }
                    }
                    var datas = {
                        'getPieces_count': getPieces_count,
                        'getper_unit_price': getper_unit_price,
                        'product_token': getProductQuaToken,
                        'units': quantity_type,
                        'getProductSoldPiece': getProductSoldPiece,
                        'order_token': shop_data.order_token,
                        'dashboard_code': verfication_code,
                        'distributor_token': distributor_token,
                        'quantity': quantity,
                        'addQunatinStock': addQunatinStock,
                        'reducedQunatinStock': reducedQunatinStock,
                        'shop_token': shop_data.shop_token,
                        'type': "addQuantityForproduct"
                    };
                    var json_data = JSON.stringify(datas);
                    console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/sales_order.php",
                        data: json_data,
                    }).done(function(data) {
                        ///$(".se-pre-con").show();
                        if (data.status_code == 400) {
                            $(".se-pre-con").hide();
                            swal("Something happened!");
                        } else if (data.status_code == 200) {
                            //$(".se-pre-con").show();
                            swal("Quantity Added For Product!", {
                                icon: "success"
                            });


                            var datas1 = {
                                'order_token': shop_data.order_token,
                                'distributor_token': distributor_token,
                                'invoice_name': shop_data.invoice_name,
                                'oustanding_amt': data.outstand_data
                            };
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                                data: datas1,
                            }).done(function(data) {
                                // $(".se-pre-con").hide();
                                swal("Updated product quantity successfully!", {
                                    icon: "success"
                                });
                                particular_order_detail(orderToken_storage, sales_man_name);
                                //location.reload();
                            });
                        }
                    });

                } else {
                    swal("Please Enter quantity!");
                }
            }
            //updateDiscount
            function edit_discount(key) {
                index_data = key;
                let value = item_data[index_data].discount_percentage;
                $(`#edit_Discount_value`).val(value);
            }

            //get table value
            function table_call() {
                let tValue = 0;
                for (x in gl_data) {
                    if (gl_data[x].is_free == "0") {
                        console.log(gl_data[x].amount);
                        tValue += parseFloat(gl_data[x].amount);
                    }
                }

                var table = document.getElementById('item_list_table');
                var index = document.getElementById('disId').cellIndex;
                var rows = table.rows;
                var a = 0;
                for (var i = 1; i < rows.length; i++) {
                    var objCells = rows.item(i).cells;
                    for (var j = index; j <= index; j++) {
                        var value = objCells.item(j);
                    }
                    let x = $(value).children('span').text();
                    if (x != "") {
                        console.log(x);
                        a += parseFloat(x);
                    }
                }
                var totalDisAmVaule = tValue - a;
                return totalDisAmVaule;
            }

            function Update_Discount() {
                var amountValue = item_data[index_data].amount;
                var selcted_product_token = item_data[index_data].product_token;
                let discountValue = $("#edit_Discount_value :selected").val();
                var findDiscount = ((amountValue / 100) * discountValue).toFixed(2);
                $("#discountEditvalue_" + index_data).text(findDiscount);
                let totFinalValue = table_call();
                // console.log(totFinalValue);
                var totalDisCountAmount = totFinalValue;
                // console.log(totalDisCountAmount);
                var roundValue = Math.round(totalDisCountAmount);
                $(".total_amount_top").html(`Total Amount: <span class="label_value">Rs.${roundValue}</span>`);
                //    $("#table_body_id td span").find("#outAmt").text(roundValue);
                var datas = {
                    'dashboard_code': verfication_code,
                    'selcted_product_token': selcted_product_token,
                    'discountValue': discountValue,
                    'order_token': shop_data.order_token,
                    'type': 'updateDiscountValue',
                    'totalDisCountAmount': totalDisCountAmount
                }
                var json_data = JSON.stringify(datas);
                //return;
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/sales_order.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 400) {
                        $(".se-pre-con").hide();
                        swal(data.message, {
                            icon: "success"
                        });
                    } else if (data.status_code == 200) {
                        var datas1 = {
                            'order_token': shop_data.order_token,
                            'distributor_token': distributor_token,
                            'invoice_name': shop_data.invoice_name,
                            'oustanding_amt': data.outstand_data
                        };
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                            data: datas1,
                        }).done(function(data) {
                            $(".se-pre-con").hide();
                            swal("Discount updated Successfully!", {
                                icon: "success"
                            });
                            particular_order_detail(orderToken_storage, sales_man_name);
                        });
                    }
                });
            }

            $(document).ready(function() {
                $(".discount_percentage_box").hide();
                $("#discount_type").change(function() {
                    var value = $(this).val();
                    if (value == '%') {
                        $(".discount_percentage_box").show();
                        $(".discount_amount_box").hide();
                    } else {
                        $(".discount_percentage_box").hide();
                        $(".discount_amount_box").show();
                    }
                });
            });

            function deleteItem(key) {
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this item?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $(".se-pre-con").show();
                        var checkQuantity = item_data[key].quantity;
                        checkQuantity = checkQuantity.split(" ");
                        var addQunatityinStock;
                        if (checkQuantity[1] == 'Box') {
                            addQunatityinStock = checkQuantity[0] * item_data[key].piece_count;
                        } else {
                            addQunatityinStock = checkQuantity[0];
                        }
                        var datas = {
                            'product_token': item_data[key].product_token,
                            'order_token': shop_data.order_token,
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'addQunatityinStock': addQunatityinStock,
                            'getProductSoldPiece': getProductSoldPiece,
                            'getPieces_count': getPieces_count,
                            'shop_token': shop_data.shop_token,
                            'type': "deleteItem"
                        };
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/sales_order.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                $(".se-pre-con").hide();
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                var datas1 = {
                                    'order_token': shop_data.order_token,
                                    'distributor_token': distributor_token,
                                    'invoice_name': shop_data.invoice_name,
                                    'oustanding_amt': data.outstand_data
                                };
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                                    data: datas1,
                                }).done(function(data) {
                                    $(".se-pre-con").hide();
                                    swal("Item Deleted Successfully!", {
                                        icon: "success"
                                    });
                                    particular_order_detail(orderToken_storage, sales_man_name);
                                });
                            }
                        });
                    }
                });
            }
        </script>
    </body>

    </html>
<?php
}
?>