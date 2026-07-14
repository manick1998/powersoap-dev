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
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/stock_orders.css?v=123<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <style>
            .dataTables_filter form {
                z-index: 9999;
            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <div class="se-pre-con"></div>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar2"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="stocks">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main" data-i18n="order_history">Order History</h1>
                        </div>
                        <p class="table_count"><span data-i18n="total_orders">Total Orders</span> - <span id="project_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group field_data">
                            <input class="box_form" name="date" id="datepicker" onchange="date_filter()" type="text" placeholder="From Date" data-i18n-placeholder="from_date" readonly>
                        </div>
                        <div class="form-group field_data">
                            <input class="box_form" name="date" id="datepicker1" onchange="date_filter()" type="text" placeholder="To Date" data-i18n-placeholder="to_date" readonly>
                        </div>
                    </form>
                </div>
                <div class="table-box stock">
                    <table class="custom-table" id="dataTables_filter">
                        <thead>
                            <tr>
                                <th data-i18n="sl_no">Id</th>
                                <th data-i18n="order_id">Order ID</th>
                                <th data-i18n="date_time">Date & Time</th>
                                <th data-i18n="items">Items</th>
                                <th data-i18n="amount">Amount</th>
                                <th data-i18n="delivery">Delivery</th>
                                <th data-i18n="delivery_on">Delivery on</th>
                            </tr>
                        </thead>
                        <tbody id="table_data_stock">

                        </tbody>
                    </table>
                </div>
            </section>
            <section class="bg-white brad-4 full-height" id="order_id" style="display: none;">
                <div class="header_container">
                    <div class="header-details">

                    </div>
                </div>
                <ul class="stock-order-tab" id="pills-tab" role="tablist">
                    <li class="nav-item nav-item-center mrg_zero" id="invoice_button">

                    </li>
                    <!-- <li>
                        <p class="order-right-content"></p>
                    </li> -->
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-box">
                            <table class="custom-table" id="dataTables_filter1">
                                <thead>
                                    <tr>
                                        <th data-i18n="sl_no">SI.No</th>
                                        <th data-i18n="item_name">Item Name</th>
                                        <th data-i18n="offer_percentage">Offer(%)</th>
                                        <th data-i18n="item_code">Item Code</th>
                                        <th data-i18n="box">Box</th>
                                        <th data-i18n="box_price">Box Price</th>
                                        <th data-i18n="amount">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="purchase_items">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
            $(document).ready(function() {
                $('#datepicker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    dateFormat: 'dd-mm-yy',
                    maxDate: 0
                });
                $('#datepicker1').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    dateFormat: 'dd-mm-yy',
                    maxDate: 0
                });
            });
            $('.get_url_for_android').on('click', function() {
                let _get_url = $(this).attr('data-url');
                console.log(`${_get_url}`);
                Android.showToast(`${_get_url}`);
            });
            var table;

            function dataTableIn() {
                table = $("#dataTables_filter").DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    "order": [
                        [0, "desc"]
                    ],
                    "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }],
                    buttons: [],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: getGlobalTranslation("search"),
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
            }
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
            })

            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
            $(document).ready(function() {
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "all_stock_order"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stock_order.php",
                    data: json_data,
                    success: success,
                });
            });
            var table_main_data;

            function success(data) {
                var table_main_data = data.data;
                var html_text1 = "";
                var slno = 0;
                for (var key in table_main_data) {
                    slno++;
                    html_text1 += '<tr>';
                    html_text1 += '<td>' + slno + '</td>';
                    html_text1 += '<td><a class="view_link" href="#" onclick="view_order(' + table_main_data[key].order_id + ')">' + table_main_data[key].order_number + '</a></td>';
                    html_text1 += '<td>' + table_main_data[key].order_date_time + '</td>';
                    html_text1 += '<td>' + table_main_data[key].items + '</td>';
                    html_text1 += '<td>' + numberFormatComma(table_main_data[key].amount) + '</td>';
                    if (table_main_data[key].order_status == "Pending") {
                        html_text1 += '<td><button class="tb-btn voliet">' + getGlobalTranslation("pending") + '</button></td>';
                    } else if (table_main_data[key].order_status == "Cancelled") {
                        html_text1 += '<td><button class="tb-btn red">' + getGlobalTranslation("cancelled") + '</button></td>';
                    } else if (table_main_data[key].order_status == "Approved") {
                        html_text1 += '<td><button class="tb-btn bluebtn">' + getGlobalTranslation("approved") + '</button></td>';
                    } else {
                        html_text1 += '<td><button class="tb-btn greenbtn">' + getGlobalTranslation("completed") + '</button></td>';
                    }

                    if (table_main_data[key].order_status == "Pending" || table_main_data[key].order_status == "Cancelled") {
                        html_text1 += '<td>-</td>';
                    } else if (table_main_data[key].order_status == "Approved") {
                        html_text1 += '<td>' + table_main_data[key].approved_on + '</td>';
                    } else {
                        html_text1 += '<td>' + table_main_data[key].delivered_on + '</td>';
                    }
                    html_text1 += '</tr>';
                }
                $("#table_data_stock").html(html_text1);
                key++;
                $("#project_count").html(key);
                dataTableIn();
                $(".se-pre-con").hide();
            }

            function view_order(order_id) {
                $('#stocks').hide();
                $(".se-pre-con").show();
                var order_id = order_id;
                var datas = {
                    "order_token": order_id,
                    dashboard_code: verfication_code
                };
                var json = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stock_detail.php",
                    data: json,
                    success: stock_detail,
                    error: function(request, error) {
                        alert(" Can't do because131: " + error);
                    }
                });
                var datas1 = {
                    "order_token": order_id,
                    dashboard_code: verfication_code
                };
                var json1 = JSON.stringify(datas1);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stock_order_detail.php",
                    data: json1,
                    success: stock_order_detail,
                    error: function(request, error) {
                        alert(" Can't do because132: " + error);
                    }
                });
            }

            function stock_detail(data) {
                var stock_detail = data.data;
                console.log(stock_detail);
                var order_text1 = "";
                order_text1 += '<div class="title_box">';
                order_text1 += '<div class="header_box">';
                order_text1 += '<h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span class="shop_name">' + stock_detail.order_number + '</span></h1>';
                if (stock_detail.order_status == "Pending") {
                    order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn voliet status-widget">' + getGlobalTranslation("pending") + '</button>';
                } else if (stock_detail.order_status == "Cancelled") {
                    order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn red status-widget">' + getGlobalTranslation("cancelled") + '</button>';
                } else if (stock_detail.order_status == "Approved") {
                    order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn bluebtn status-widget">' + getGlobalTranslation("approved") + '</button>';
                } else {
                    order_text1 += '<button style="margin-left: 20px; margin-top: 0px;" class="tb-btn greenbtn status-widget">' + getGlobalTranslation("completed") + '</button>';
                }
                order_text1 += '</div>';
                if (stock_detail.order_status == "Pending") {
                    order_text1 += '<a href="javascript:void(0)" onclick=cancel_order(' + stock_detail.order_id + ')>' + getGlobalTranslation("cancel_order") + '</a>';
                }
                order_text1 += '</div>';
                order_text1 += '<div class="details-top-section">';
                order_text1 += '<div class="details-top-div">';
                order_text1 += '<p>' + getGlobalTranslation("date_time") + ': <span class="label_value">' + stock_detail.order_date_time + '</span></p>';
                order_text1 += '<p>' + getGlobalTranslation("amount") + ': <span class="label_value">' + numberFormatComma(stock_detail.amount) + '</span></p>';
                order_text1 += '</div>';
                order_text1 += '<div class="details-top-div">';
                order_text1 += '<p>' + getGlobalTranslation("items") + ': <span class="label_value">' + stock_detail.items + '</span></p>';
                order_text1 += '<p>' + getGlobalTranslation("total_gst") + ': <span class="label_value">Rs. ' + numberFormatComma(stock_detail.gst) + '</span></p>';
                order_text1 += '</div>';
                order_text1 += '<div class="details-top-div ">';
                order_text1 += '<p class="order-right-content2"></p>';
                order_text1 += '<p class="order-right-content1"></p>';
                order_text1 += '</div>';
                order_text1 += '</div>';
                $(".header-details").html(order_text1);
                $(".order-right-content2").html(getGlobalTranslation("total_amount") + ": <span class='label_value'>Rs. " + numberFormatComma(stock_detail.billing_amount) + "</span>");
                $(".order-right-content1").html(getGlobalTranslation("total_tcs") + ": <span class='label_value'>Rs. " + numberFormatComma((stock_detail.billing_amount) * 0.001) + "</span>");
                if (stock_detail.order_status != "Pending" && stock_detail.order_status != "Cancelled") {
                    $("#invoice_button").css("display", "block");
                    $("#invoice_button").html('<a data-url="' + stock_detail.invoice_url + '" href="' + stock_detail.invoice_url + '" class="get_url_for_android" target="_blank"><button class="nav-link active" type="button"><span><img src="assets/invoice_icon.png" class="invoice"></span>Estimate</button></a>');
                    $('.get_url_for_android').on('click', function() {
                        let _get_url = $(this).attr('data-url');
                        console.log(`${_get_url}`);
                        Android.showToast(`${_get_url}`);
                    });
                } else {
                    $("#invoice_button").css("display", "none");
                }
            }

            function back_view_order() {
                $('#stocks').show();
                $('#order_id').hide();
            }
            var stockOrderTable;
            var order_table_check = false;

            function stock_order_detail(data) {
                var material_data = data.data;
                var order_detail = "";
                var srno = 0;
                if (order_table_check) {
                    stockOrderTable.clear();
                    stockOrderTable.destroy();
                }
                for (var key in material_data) {
                    srno++;
                    if (material_data[key].is_free == 0) {
                        order_detail += '<tr>';
                    } else {
                        order_detail += '<tr class="freeColumnColor">';
                    }
                    order_detail += '<td>' + srno + '</td>';
                    order_detail += '<td>' + material_data[key].product_name + '</td>';
                    if (material_data[key].is_free == 0) {
                        order_detail += '<td>' + material_data[key].offer_percentage + '%</td>';
                    } else {
                        order_detail += '<td>-</td>';
                    }
                    order_detail += '<td>' + material_data[key].item_code + '</td>';
                    order_detail += '<td>' + material_data[key].quantity + '</td>';
                    if (material_data[key].is_free == 0) {
                        order_detail += '<td>' + numberFormatComma(material_data[key].box_price) + '</td>';
                    } else {
                        order_detail += '<td>-</td>';
                    }
                    if (material_data[key].is_free == 0) {
                        order_detail += '<td>' + numberFormatComma(material_data[key].amount) + '</td>';
                    } else {
                        order_detail += '<td>' + getGlobalTranslation("free") + '</td>';
                    }
                    order_detail += '</tr>';
                    $("#purchase_items").html(order_detail);
                }
                $(".se-pre-con").hide();
                $('#order_id').show();
                stockOrderTable = $("#dataTables_filter1").DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    bFilter: false,
                    buttons: [],
                    language: {
                        //                        search: '<img src="assets/svg/Search_icon.svg">',
                        //                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
                order_table_check = true;
            }

            function date_filter() {
                var from_date = $("#datepicker").val();
                var to_date = $("#datepicker1").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#datepicker1").val(from_date);
                }
                var to_date = $("#datepicker1").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    $(".se-pre-con").show();
                    var datas = {
                        dashboard_code: verfication_code,
                        from_date: from_date,
                        to_date: to_date,
                        type: "date_range",
                        distributor_token: distributor_token
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/stock_order.php",
                        data: json_data,
                        success: successClear,
                    });
                }
            }

            function cancel_order(order_token) {
                var token = order_token;
                swal({
                    title: getGlobalTranslation("are_you_sure"),
                    text: getGlobalTranslation("cancel_order_confirm_text"),
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'order_token': token,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/cancel_order.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 201) {
                                swal(getGlobalTranslation("order_cancelled_successfully"), {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }

            function successClear(data) {
                table.clear();
                table.destroy();
                success(data);
            }
        </script>
    </body>

    </html>
<?php
}
?>