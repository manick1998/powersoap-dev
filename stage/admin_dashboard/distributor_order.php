<?php
include "config.php";
include "$api_path/config/core.php";
if ($cookie_admin_name == "") {
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
    </head>
    <style>
        a {
            cursor: pointer;
        }

        .nav-item-center {
            margin-left: 0px;
        }

        .nav-blue {
            color: #fff;
            background-color: #00b9f5 !important;
        }

        .title_box a {
            color: red;
            text-decoration: underline;
        }

        table .tb-btn,
        #single_order_status .tb-btn {
            pointer-events: none;
        }

        .input_value {
            width: 70px;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background: transparent;
            margin-right: 10px;
        }

        .form-control p {
            margin: 0;
            color: #798893;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            text-align: left;
        }

        .input-field {
            border: none;
            color: #333;
            width: 100%;
            font-size: 16px;
            line-height: 20px;
            outline: none;
        }

        .strite {
            white-space: nowrap;
        }

        .form-control {
            margin: 10px 0;
        }

        .dataTables_filter select.form-control {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .appr-cancel-set {
            display: flex;
        }

        .appr-cancel-set a:not(:last-child) {
            padding-left: 30px;
        }

        .create-btn {
            width: auto !important;
            white-space: nowrap;
            padding: 0px 12px !important;
        }

        .freeColumnColor {
            background: #8fd6e3 !important;
        }

        .main-contents {
            width: 84%;
        }

        .brad-4 {
            overflow: hidden;
        }

        .main-contents {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            height: calc(100vh - 90px) !important;
            max-height: calc(100vh - 90px) !important;
            scrollbar-width: auto;
            -ms-overflow-style: auto;
        }

        .main-contents::-webkit-scrollbar {
            display: block !important;
            width: 8px !important;
        }

        .main-contents::-webkit-scrollbar-track {
            background: #f1f1f1 !important;
        }

        .main-contents::-webkit-scrollbar-thumb {
            background: #c1c1c1 !important;
            border-radius: 10px !important;
        }

        .main-contents::-webkit-scrollbar-thumb:hover {
            background: #9a9a9a !important;
        }

        .module-option {
            margin: 10px 0;
        }

        .module-option label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            position: relative;
        }

        .cust-checkbox {
            width: 18px;
            height: 18px;
            border: 1px solid #51c568;
            border-radius: 3px;
            display: inline-block;
            position: relative;
            transition: 0.4s;
        }

        .modal-input:checked~.cust-checkbox {
            background-color: #51c568;
            border-color: #51c568;
            animation-name: input-animate;
            animation-duration: 0.7s;
        }

        .modal-input:checked~.cust-checkbox::before {
            content: '';
            display: inline-block;
            width: 12px;
            height: 5px;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            transform: scale(1) rotate(-45deg);
            position: absolute;
            top: 4px;
            left: 2px;
            transition: 0.4s;
        }

        .table-box {
            display: block;
            /* overflow:hidden;
            overflow-x:none; */
        }

        @media screen and (max-width: 1861px) {

            .main-contents {
                width: 83%;
            }
        }

        @media screen and (max-width: 1600px) {
            .header-details {
                width: 95%;
            }

            /*   .table-box {
                overflow-x: scroll;
                display: -webkit-box;
                 white-space: nowrap; 
            }*/
            /* .table_control{
                display:inline;
            } */
            /*   .dataTables_info
            {
                position: sticky;
    left: 0;
            }*/
        }

        @media screen and (max-width: 1562px) {

            .main-contents {
                width: 80%;
            }
        }

        @media screen and (max-width: 1440px) {
            #item_list_table {
                overflow-y: scroll;
                display: block;
            }

            #item_list_table::-webkit-scrollbar {
                width: 5px;
            }

            #item_list_table thead tr th {
                white-space: nowrap;
            }
        }

        @media screen and (max-width: 1200px) {
            .main-contents {
                width: 95%;
            }

        }

        .dataTables_filter {
            height: 30px;
        }

        .dataTables_filter label {
            top: 40px !important;
        }

        div#table_data_length {
            padding-top: 0 !important;
        }

        .btn-group,
        .btn-group-vertical {
            padding-left: 20px !important;
            padding-top: 20px;
        }
    </style>

    <body>
        <div class="se-pre-con"></div>
        <header id="main-dash-header" class="dash-header">
        </header>

        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar1"></div>

        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main">Distributor Orders</h1>
                        </div>
                        <p class="table_count">Total Order - <span id="total_order_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()" type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()" type="text" placeholder="To Date" readonly>
                        </div>
                        <div class="form-group">
                            <select name="" id="selectState" class="form-control">
                                <option value="">filter</option>
                                <option value="">2adf</option>
                                <option value="">3adadfadsa</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button id="stateGoBtn" type="button" onclick="filterStateWise();" class="primary-btn">Go</button>
                        </div>
                    </form>
                </div>
                <div class="table-box">
                    <table class="custom-table table_control" id="table_data">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Order Number</th>
                                <th>Order Placed Date & Time</th>
                                <th>Distributor</th>
                                <th>Items</th>
                                <th>Delivery</th>
                                <th>Total Amount</th>
                                <th>Date & Time</th>
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
                        <div class="title_box">
                            <div class="header_box">
                                <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span id="single_shop_name"> </span></h1>
                                <span id="single_order_status"></span>
                            </div>
                            <div class="appr-cancel-set">
                                <input id="cancel_order_token" type="hidden">
                                <a href="javascript:void(0)" id="cancel_order_button" class="add_red" onclick="cancel_order()">Cancel Order</a>
                                <input id="distributor_token" type="hidden">
                                <input id="approve_order_token" type="hidden">
                                <a class="view_link" id="approve_button" onclick="approve()">Approve Order</a>
                                <a class="view_link" id="deliver_button" onclick="deliver()">Deliver Order</a>
                            </div>
                        </div>
                        <p class="table_count" id="single_order_token"></p>
                        <div class="details-top-section">
                            <div class="details-top-div">
                                <p id="single_order_amount"></p>
                                <p id="single_salesman_name"></p>
                            </div>
                            <div class="details-top-div">
                                <p id="single_paid_amount"></p>
                                <p id="single_items"></p>
                            </div>
                            <div class="details-top-div">
                                <p id="single_Tcs"></p>
                                <p id="single_order_date"></p>
                            </div>
                            <div class="details-top-div">
                                <p id="single_gst"></p>
                                <p id="single_delivered_on"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                    <li class="nav-item nav-item-center" id="after_approval_invoice_gen" style="display:none;">
                        <a id="invoice_pdf_id" href="" target="_blank">
                            <button class="nav-link active" type="button">
                                <span><img src="assets/invoice_icon.png" class="invoice"></span>Estimate
                            </button>
                        </a>
                    </li>


                    <button class="primary-btn" data-toggle="modal" id="add_product_button" data-target="#exampleModal">Add Products</button>

                    <p class="order-right-content"><a id="single_total_amount"></a></p>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-box">
                            <table class="custom-table contbox" id="item_list_table">
                                <thead id="item_table_header">

                                </thead>
                                <tbody id="item_table_body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- productModal -->
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Select Product</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="flex-set" id="schemeName">
                                <!-- <div class="module-option">
                                    <label for="product1" id="schemeName">
                                        <input type="checkbox" data-token="1" name="product1" id="product1" class="modal-input hidden">
                                        <span class="cust-checkbox"></span></label>
                                    </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal" onclick="cancelButton()">Cancel</button>
                        <button class="create-btn" id="schemeEdit">Selected</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add Product</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                    <div class="form-control offer_division_box">
                                        <p for="offer_division" class="input-field offer_division">Division</p>
                                        <select class="input-field" id="offer_division_data" onchange="divisionWiseProduct()">
                                        </select>
                                    </div>
                                    <div id="all_products_details">
                                        <div class="offer_product_data">
                                        </div>
                                        <div class="additional_product_data">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal" onclick="cancelButton()">Cancel</button>
                        <button class="create-btn" id="add_offer_button" onclick="orderNewProduct()">Order Product</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var gl_admin_token = "<?php echo $token; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>

        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!--        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>-->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            $('#fromDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd-mm-yy'
            });
            $('#toDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'dd-mm-yy'
            });
        </script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var current_path = window.location.pathname;
            var stage_index = current_path.indexOf("/stage/");
            var base_stage_url = current_path.substring(0, stage_index + 7);
            var tcpdf_url = base_stage_url + "TCPDF-main/examples/distributor_invoice_update.php";
            var table;
            // $(document).ready(function() {
            //     data_fetch();

            //     //get states
            //     $.ajax({
            //         type: "GET",
            //         dataType: "json",
            //         url: api_path + "/admin/state_list.php",
            //     }).done(function(datas) {
            //         let data = datas;
            //         let html_text = '<option value="">Select States</option>';
            //         for (let key in data) {
            //             html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
            //         }
            //         $('#selectState').html(html_text);
            //     })
            // });


            $(document).ready(function() {
                // Dates set pandra line-a thookiyachu, so default-a empty ah irukum (All data load aagum)
                $('#fromDate').val('');
                $('#toDate').val('');

                // Initial fetch
                data_fetch();

                //get states
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas) {
                    let data = datas;
                    let html_text = '<option value="">Select States</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                    }
                    $('#selectState').html(html_text);
                });
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
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }],
                    'ajax': {
                        'url': api_path + "/admin/serverDistivutorOrderList.php?from_date=" + from_date + "&&to_date=" + to_date + "&&v_id=" + verfication_code + "&&state_id=" + admin_state_id,
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                        }
                    },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    "order": [
                        [0, "DESC"]
                    ],
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
                            data: 'sales_man'
                        },
                        {
                            data: 'items'
                        },
                        {
                            data: 'delivery'
                        },
                        {
                            data: 'billing_amount'
                        },
                        {
                            data: 'delivered_on'
                        }
                    ],
                    dom: 'Bfrltip',
                    buttons: ['pdf',
                        'csv'
                    ],
                    // "info" : false,
                    // destroy: true,
                    // searching: true,
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    }
                });
                table.column(0).visible(false);
                //     setInterval( function () {
                //     table.ajax.reload();
                // }, 1000 );
                //$('.dataTables_length').css("display", "none");
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

            //filter stateWise
            function filterStateWise() {
                admin_state_id = $("#selectState :selected").val();
               // console.log(admin_state_id);
                table.clear();
                table.destroy();
                data_fetch();
            }

            var order_table_check = false;
            var order_table;
            var data_divisions;
            var item_data;
            var token;
            var order_data;
            $('#table_data tbody').on('click', '.view_link', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                console.log(`${td_div}, ${table_data}`);
                
                token = table_data.order_token;
                console.log(token);
                
                particular_order_detail(token)
            });

            function particular_order_detail(token, trigger_pdf = false) {
                $(".se-pre-con").show();
                $("#cancel_order_token").val(token);
                $("#approve_order_token").val(token);
                $("#offer_division_data").empty();
                var datas = {
                    dashboard_code: verfication_code,
                    order_token: token,
                    type: "particular_order_detail"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/distributorOrderDetails.php",
                    data: json_data
                }).done(function(data) {
                    order_data = data.data;
                    
                    if (trigger_pdf && order_data && order_data[0]) {
                        var datas_pdf = {
                            distributor_token: order_data[0].employee_token,
                            order_token: token,
                            invoice_name: order_data[0].invoice_name
                        };
                        var json_pdf = JSON.stringify(datas_pdf);
                        $.ajax({
                            async: true,
                            type: "POST",
                            dataType: "json",
                            url: tcpdf_url,
                            data: json_pdf
                        }).done(function(data_pdf) {
                            if (data_pdf.status_code == 200) {
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: api_path + "/admin/distributorOrderDetails.php",
                                    data: json_data
                                }).done(function(quiet_data) {
                                    order_data = quiet_data.data;
                                    if (order_data && order_data[0] && order_data[0].invoice_url != "") {
                                        $("#invoice_pdf_id").attr("href", order_data[0].invoice_url);
                                        $("#invoice_pdf_id").attr("disable", false);
                                        $("#invoice_pdf_id").css("display", "block");
                                    }
                                });
                            }
                        });
                    }
                    $("#distributor_token").val(order_data[0].employee_token);
                    if (order_data[0].delivery_value == "Pending") {
                        $("#approve_button,#cancel_order_button,#add_product_button").css("display", "block");
                        $("#approve_button,#cancel_order_button").prop('disabled', false);
                        $("#deliver_button").css("display", "none");
                        $("#deliver_button").prop('disabled', true);
                        //   $("#single_paid_amount").html("Paid: <span class='label_value'>Rs." +numberFormatComma(order_data[0].paid_amount)+ "</span>");
                    } else if (order_data[0].delivery_value == "Approved") {
                        $("#deliver_button").css("display", "block");
                        $("#deliver_button").prop('disabled', false);
                        $("#approve_button,#cancel_order_button,#add_product_button").css("display", "none");
                        $("#approve_button,#cancel_order_button").prop('disabled', true);
                        $("#single_paid_amount").html("Paid: <span class='label_value'>Rs." + numberFormatComma(order_data[0].billing_amount) + "</span>");
                    } else {
                        $("#single_paid_amount").html("Paid: <span class='label_value'>Rs." + numberFormatComma(order_data[0].billing_amount) + "</span>");
                        $("#approve_button,#deliver_button,#cancel_order_button,#add_product_button").css("display", "none");
                        $("#approve_button,#deliver_button,#cancel_order_button").prop('disabled', true);
                    }
                    if (order_data[0].delivery_value == "Approved" && order_data[0].invoice_url != "") {
                        $("#after_approval_invoice_gen").css("display", "block");
                    } else {
                        $("#after_approval_invoice_gen").css("display", "none");
                    }
                    if (order_data[0].invoice_url != "") {
                        $("#invoice_pdf_id").attr("disable", false);
                        $("#invoice_pdf_id").attr("href", order_data[0].invoice_url);
                        $("#invoice_pdf_id").css("display", "block");
                    } else {
                        $("#invoice_pdf_id").attr("href", "");
                        $("#invoice_pdf_id").attr("disable", true);
                        $("#invoice_pdf_id").css("display", "none");
                    }

                    $("#single_shop_name").html(order_data[0].shop_name);
                    $("#single_order_status").html(order_data[0].delivery);
                    $("#single_order_token").html(order_data[0].order_number);
                    $("#single_order_date").html("Date & Time: <span class='label_value'>" + order_data[0].date_time + "</span>");
                    $("#single_order_amount").html("Amount: <span class='label_value'>Rs." + numberFormatComma(order_data[0].mrp_amount) + "</span>");
                    $("#single_salesman_name").html("Distributor: <span class='label_value'>" + order_data[0].sales_man + "</span>");
                    $("#single_items").html("Items: <span class='label_value'>" + order_data[0].items + "</span>");
                    var tcs = order_data[0].tcs_amount;
                    $("#single_Tcs").html("Tcs: <span class='label_value'>" + tcs.toFixed(2) + "</span>");
                    $("#single_gst").html("GST: <span class='label_value'>" + numberFormatComma(order_data[0].gst_amount) + "</span>");
                    if (order_data[0].delivery_value == "Cancelled") {
                        $("#single_delivered_on").html("Cancelled on: <span class='label_value'>" + order_data[0].delivered_on + "</span>");
                    } else {
                        $("#single_delivered_on").html("Delivered on: <span class='label_value'>" + order_data[0].delivered_on + "</span>");
                    }
                    $("#single_total_amount").html("Total Amount : Rs." + numberFormatComma(order_data[0].billing_amount));
                    if (order_data[0].items != 0) {
                        $("#approve_button").css("display", "block");
                    } else {
                        $("#approve_button").css("display", "none");
                    }
                    if (order_data[0].delivery_value == "Pending") {
                        $("#cancel_order_button").css("display", "block");
                    } else {
                        $("#cancel_order_button").css("display", "none");
                    }
                    if (order_table_check) {
                        order_table.clear();
                        order_table.destroy();
                    }
                    var total_items = 0;
                    var total_sales = 0;
                    var table_header = '';
                    table_header += '<tr>';
                    table_header += '<th>SI.No</th>';
                    table_header += '<th>Item Name</th>';
                    table_header += '<th>Box</th>';
                    //                           table_header += '<th>Scheme Name</th>';
                    table_header += '<th>Box Price</th>';
                    table_header += '<th>Perunit price</th>';
                    table_header += '<th>Offer(%)</th>';
                    table_header += '<th>GST</th>';
                    //                            table_header += '<th>Discount(%)</th>';
                    table_header += '<th>Amount</th>';
                    table_header += '<th>Total</th>';
                    table_header += '<th>UOM(Type)</th>';
                    if (order_data[0].delivery_value == "Pending") {
                        table_header += '<th>Action</th>';
                    }
                    table_header += '</tr>';
                    $("#item_table_header").html(table_header);
                    item_data = data.data_item;
                    //console.log(order_data);
                    var html_text = "";
                    var slno1 = 0;
                    for (var key in item_data) {
                        slno1++;
                        if (item_data[key].is_free == 1) {
                            html_text += '<tr class="freeColumnColor">';
                        } else {
                            html_text += '<tr>';
                        }
                        html_text += '<td>' + slno1 + '</td>';
                        html_text += '<td>' + item_data[key].item_name + '</td>';

                        //console.log(order_data[0].delivery_value);
                        //console.log(item_data[key].distributor_quantity);

                        // if (item_data[key].distributor_quantity == 0) {
                        //     swal("Please Enter The Valid Input");
                        // }
                        if (order_data[0].delivery_value == "Pending" && item_data[key].is_free != 1) {

                            html_text += '<td><div class="form_input strite"><input class="input_value" name="input_box_count' + key + '" onchange="box_Count_changed(' + key + ')" type="text" value="' + item_data[key].distributor_quantity + '" readonly="" onkeypress="return isNumber(event)"><a><img src="assets/edit.png" class="edit_input" onclick="edit_box_count(' + key + ')" alt=""></a></div></td>';


                        } else {
                            html_text += '<td>' + item_data[key].distributor_quantity + '</td>';
                        }
                        if (item_data[key].is_free != 1) {
                            //html_text += '<td>' + item_data[key].scheme_name + '</td>';
                            html_text += '<td>' + numberFormatComma(item_data[key].box_price) + '</td>';
                            html_text += '<td>Rs.' + item_data[key].price_per_unit + '</td>';
                        } else {
                            // html_text += '<td>-</td>';
                            html_text += '<td>-</td>';
                            html_text += '<td>-</td>';
                        }
                        if (item_data[key].is_free != 1) {
                            if (order_data[0].delivery_value == "Pending") {
                                html_text += '<td><div class="form_input strite"><input class="input_value" name="input_offer_percent' + key + '" onchange="offerPercentageDistributor(' + key + ')" type="text" value="' + item_data[key].offer_percentage + '" maxlength="4" readonly="" onkeypress="return ispercent(event)"><a><img src="assets/edit.png" class="edit_input" onclick="edit_offer_percent(' + key + ')" alt=""></a></div></td>';
                            } else {
                                html_text += '<td>' + item_data[key].offer_percentage + '</td>';
                            }
                        } else {
                            html_text += '<td>-</td>';
                        }
                        if (item_data[key].is_free != 1) {
                            html_text += '<td>Rs.' + numberFormatComma(item_data[key].gst_rupee) + '</td>';
                        } else {
                            html_text += '<td>-</td>';
                        }
                        //                       if(item_data[key].is_free != 1){
                        //                            if(order_data[0].delivery_value == "Pending"){
                        //                                 html_text += '<td><div class="form_input"><input class="input_value" name="input_discount_percent' + key + '" onchange="discount_distributor(' + key + ')" type="text" value="' + item_data[key].discount_distributor + '" maxlength="4" readonly="" onkeypress="return ispercent(event)"><a><img src="assets/edit.png" class="edit_input" onclick="edit_discount_percent(' + key + ')" alt=""></a></div></td>';
                        //                            }else{
                        //                                 html_text += '<td>' + item_data[key].discount_distributor + '</td>';
                        //                            }
                        //                        }else{
                        //                            html_text += '<td>-</td>';
                        //                        }
                        if (item_data[key].is_free != 1) {
                            html_text += '<td>Rs.' + numberFormatComma(item_data[key].amount) + '</td>';
                            html_text += '<td>Rs.' + numberFormatComma(item_data[key].total) + '</td>';
                        } else {
                            html_text += '<td>Free</td>';
                            html_text += '<td>Free</td>';
                        }
                        html_text += '<td>' + item_data[key].units + '</td>';
                        if (order_data[0].delivery_value == "Pending") {
                            if (item_data[key].is_free != 1) {
                                html_text += '<td><a href="javascript:void(0)" style="color:red !important;" onclick="deleteItem(' + key + ')">Delete</a></td>';
                            } else {
                                html_text += '<td><a href="javascript:void(0)" data-toggle="modal" data-target="#productModal" ><img src="assets/edit.png" class="edit_input" alt="" onclick="editItem(' + token + ')"></a></div></td>';
                            }
                        }
                        html_text += '</tr>';
                    }
                    $("#item_table_body").html(html_text);

                    function productModal() {

                    }

                    var payment_data = data.data_payment;
                    order_table = $("#item_list_table").DataTable({
                        dom: 'Bfrtip',
                        buttons: [],
                        language: {
                            search: '<img src="assets/svg/Search_icon.svg">',
                            searchPlaceholder: "Search",
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
                        }
                    });
                    order_table_check = true;

                    $("#item_list_table_filter").css("display", "none");
                    $(".se-pre-con").hide();
                    $('#toggle').hide();
                    $('#toggle1').show();

                    data_divisions = data.data_division;
                    $html_new_text = '';
                    $html_new_text += '<option value="">Select Division</option>';
                    for (var keys in data_divisions) {
                        $html_new_text += '<option value="' + data_divisions[keys].division_token + '">' + data_divisions[keys].division_name + '</option>';
                    }
                    $("#offer_division_data").append($html_new_text);
                });
            }

            function back_view_order() {
                //location.reload(); 
                $('#toggle1').hide();
                $('#toggle').show();
            }

            function editItem(token) {
                var datas = {

                    'order_token': token,
                    'dashboard_code': verfication_code,
                    'type': "editItem"
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/distributorOrderDetails.php",
                    data: json_data,
                    success: function(response) {
                        $order_token = response.order_token;
                        let module_list = "";
                        response.orderData.forEach(function(item, index) {
                            //console.log(item.order_token);
                            module_list += `
                                                <div class="module-option">
                                                <label for="product1${index}">
                                                <input type="checkbox" id="product1${index}" data-target = "${$order_token}" name = "product1" value="${item.token}" class="modal-input hidden">
                                                <span class="cust-checkbox"></span>
                                                ${item.product_name}
                                                </label>
                                                </div>`
                        });
                        $("#schemeName").html(module_list);
                    }
                });
            }
            $("body").on("click", "#schemeEdit", function() {
                var order_token = $('input[name="product1"]:checked').data('target');
                var selectedProduct = [];
                $('input[name="product1"]:checked').each(function() {
                    selectedProduct.push($(this).val());
                });
                var datas = {
                    'dashboard_code': verfication_code,
                    'order_token': order_token,
                    'selectedProduct': selectedProduct,
                    'type': "schemeEdit"
                }
                var json_data = JSON.stringify(datas);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/distributorOrderDetails.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if (data.code == 400) {
                        swal("Something happened!");
                    } else if (data.code == 200) {
                        swal("Product changed successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();

                        });
                        particular_order_detail(order_token);
                    }
                });
            });

            function cancel_order() {
                var order_token = $("#cancel_order_token").val();
                var distributor_token = $("#distributor_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    $(".se-pre-con").show();
                    if (willDelete) {
                        var datas = {
                            'order_token': order_token,
                            'distributor_token': distributor_token,
                            'admin_token': gl_admin_token,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/cancelOrder.php",
                            data: json_data,
                        }).done(function(data) {
                            $(".se-pre-con").hide();
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Order cancelled successfully!", {
                                    icon: "success"
                                });
                                particular_order_detail(order_token);
                            }
                        });
                    }
                    $(".se-pre-con").hide();
                });
            }

            function approve() {
                var order_token = $("#approve_order_token").val();
                var distributor_token = $("#distributor_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to approve this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'order_token': order_token,
                            'distributor_token': distributor_token,
                            'type': 'approve',
                            'admin_token': gl_admin_token,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        // console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/distributorOrderDetails.php",
                            data: json_data,
                        }).done(function(data) {
                            //console.log(data);
                            if (data.code == 503) {
                                swal(data.message);
                            } else if (data.code == 201) {
                                var datas = {
                                    distributor_token: distributor_token,
                                    order_token: order_token,
                                    invoice_name: (order_data && order_data[0]) ? order_data[0].invoice_name : ""
                                };
                                var json_data = JSON.stringify(datas);
                                $.ajax({
                                    async: false,
                                    type: "POST",
                                    dataType: "json",
                                    url: tcpdf_url,
                                    data: json_data,
                                }).done(function(data) {
                                    if (data.status_code == "200") {
                                        swal("Order Approved successfully!", {
                                            icon: "success"
                                        });
                                        particular_order_detail(order_token);
                                    } else if (data.status_code == "400") {
                                        swal(data.message);
                                    }
                                });
                            }
                        });
                    }
                });
            }

            function deliver() {
                var order_token = $("#approve_order_token").val();
                var distributor_token = $("#distributor_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to deliver this order?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'order_token': order_token,
                            'distributor_token': distributor_token,
                            'type': 'deliver',
                            'admin_token': gl_admin_token,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/distributorOrderDetails.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal(data.message);
                            } else if (data.code == 201) {
                                swal("Order Delivered successfully!", {
                                    icon: "success"
                                });
                                particular_order_detail(order_token);
                            }
                        });
                    }
                });
            }

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }

            function ispercent(evt, value) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode != 46) {
                    return false;
                }
                return true;
            }
            //Remove readonly from box input field
            function edit_box_count(key) {
                var value = $('input[name=input_box_count' + key + ']').val();
                $('input[name=input_box_count' + key + ']').removeAttr('readonly').focus().val('').val(value);
            }
            //Remove readonly from discount input field
            function edit_discount_percent(key) {
                var value = $('input[name=input_discount_percent' + key + ']').val();
                $('input[name=input_discount_percent' + key + ']').removeAttr('readonly').focus().val('').val(value);
            }

            function edit_offer_percent(key) {
                var value = $('input[name=input_offer_percent' + key + ']').val();
                $('input[name=input_offer_percent' + key + ']').removeAttr('readonly').focus().val('').val(value);
            }
            //Changing the input value of box 
            function box_Count_changed(key) {
                // $(".se-pre-con").show();
                var distributor_token = $("#distributor_token").val();
                $('input[name=input_box_count' + key + ']').attr("readonly", true);
                var boxCount = $('input[name=input_box_count' + key + ']').val();
                var order_array = [];
                var product_token = item_data[key].product_token;
                var category_token = item_data[key].category_token;
                var price_per_unit = item_data[key].price_per_unit;
                var piece_count = item_data[key].piece_count;
                for (var key in item_data) {
                    if (item_data[key].distributor_quantity >= 0) {
                        var item_box_count = $('input[name=input_box_count' + key + ']').val();
                        if (item_box_count != undefined) {
                            var data = {
                                product_token: item_data[key].product_token,
                                quantity: item_box_count
                            };
                            order_array.push(data);
                        }
                    }
                }
                var datas = {
                    boxCount: boxCount,
                    product_token: product_token,
                    category_token: category_token,
                    price_per_unit: price_per_unit,
                    piece_count: piece_count,
                    dashboard_code: verfication_code,
                    order_token: token,
                    distributor_token: distributor_token,
                    admin_token: gl_admin_token,
                    type: "update_box_count",
                    order_array: order_array
                };
                var json_data = JSON.stringify(datas);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/updateDistributorOrder.php",
                    data: json_data,
                }).done(function(data) {
                    //console.log(data);
                    if (data.status_code == 200) {
                        $(".se-pre-con").hide();
                        swal("Quantity Updated Successfully!", {
                            icon: "success"
                        });
                        //console.log("Updated");
                        particular_order_detail(token, false);
                    } else {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "error");
                    }

                });
            }
            //Changing the input value of discount 
            function discount_distributor(key) {
                $(".se-pre-con").show();
                var discount_value = $('input[name=input_discount_percent' + key + ']').val();
                if (discount_value != '') {
                    $('input[name=input_discount_percent' + key + ']').attr("readonly", true);
                    var product_token = item_data[key].product_token;
                    var total_amount = item_data[key].total_amount;
                    var distributor_quantity = item_data[key].distributor_quantity;
                    var box_price = (parseFloat(item_data[key].price_per_unit) * parseFloat(item_data[key].piece_count)).toFixed(2);
                    var datas = {
                        discount_value: discount_value,
                        product_token: product_token,
                        box_price: box_price,
                        distributor_quantity: distributor_quantity,
                        dashboard_code: verfication_code,
                        order_token: token,
                        admin_token: gl_admin_token,
                        type: "update_discount_value"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateDistributorOrder.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == 200) {
                            $(".se-pre-con").hide();
                            swal("Discount Updated Successfully!", {
                                icon: "success"
                            });
                            particular_order_detail(token, false);
                        } else {
                            $(".se-pre-con").hide();
                            swal("Something happened!");
                        }

                    });
                }
            }

            function deleteItem(key) {
                var distributor_token = $("#distributor_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this item?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $(".se-pre-con").show();
                        var datas = {
                            'product_token': item_data[key].product_token,
                            'order_token': token,
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'admin_token': gl_admin_token,
                            'type': "deleteItem"
                        };
                        var json_data = JSON.stringify(datas);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/updateDistributorOrder.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                $(".se-pre-con").hide();
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                $(".se-pre-con").hide();
                                swal("Item Deleted Successfully!", {
                                    icon: "success"
                                });
                                particular_order_detail(token, false);
                            }
                        });
                    }
                });
            }

            function divisionWiseProduct() {
                var division_token = $("#offer_division_data").val();
                $(".offer_product_data").empty();
                $html_new_text1 = '';
                for (var keys in data_divisions) {
                    if (data_divisions[keys].division_token == division_token) {
                        var product_list = data_divisions[keys].product_list;
                        $html_new_text1 += '<div class="form-control">';
                        $html_new_text1 += '<p for="offer_division" class="input-field offer_division">Product</p>';
                        $html_new_text1 += '<select class="input-field" id="offer_product_data" onchange="productWiseBoxPiece()">';
                        $html_new_text1 += '<option value="">Select Product</option>';
                        for (var key1 in product_list) {
                            $html_new_text1 += '<option value="' + product_list[key1].product_token + '">' + product_list[key1].product_name + '</option>';
                        }
                        $html_new_text1 += '</select>';
                        $html_new_text1 += '</div>';
                        $(".offer_product_data").append($html_new_text1);
                    }
                }
            }

            function productWiseBoxPiece() {
                var product_token = $("#offer_product_data").val();
                var division_token = $("#offer_division_data").val();
                $(".additional_product_data").empty();
                for (var keys in data_divisions) {
                    if (data_divisions[keys].division_token == division_token) {
                        var product_list = data_divisions[keys].product_list;
                        for (var key1 in product_list) {
                            if (product_list[key1].product_token == product_token) {
                                var html_data = '';
                                html_data += '<div class="form-control product_box_piece_box">';
                                html_data += '<p for="offer_name" class="input-field product_box_piece">Product Item Code</p>';
                                html_data += '<input type="text" class="input-field" value="' + product_list[key1].product_item_code + '" id="product_item_code" readonly>';
                                html_data += '</div>';
                                html_data += '<div class="form-control product_box_piece_box">';
                                html_data += '<p for="offer_percentage" class="input-field product_box_piece">Product Box Pieces</p>';
                                html_data += '<input type="text" id="product_box_piece" class="input-field" value="' + product_list[key1].product_piece_count + '" readonly>';
                                html_data += '</div>';
                                html_data += '<div class="form-control product_box_count">';
                                html_data += '<p for="offer_percentage" class="input-field product_box_piece">No. of Box</p>';

                                html_data += '<input type="text" id="product_box_counts" class="input-field" value="" onkeypress="return isNumber(event)" placeholder="Enter the Box Count">';
                                html_data += '</div>';
                            }
                        }
                        $(".additional_product_data").append(html_data);
                    }
                }
            }

            function orderNewProduct() {
                $(".se-pre-con").show();
                var product_token = $("#offer_product_data").val();
                var division_token = $("#offer_division_data").val();
                var per_box_piece = $("#product_box_piece").val();
                var box_count = $("#product_box_counts").val();
                var distributor_token = $("#distributor_token").val();
                if (product_token != "" && division_token != "" && box_count != "") {
                    var datas = {
                        product_token: product_token,
                        per_box_piece: per_box_piece,
                        box_count: box_count,
                        division_token: division_token,
                        dashboard_code: verfication_code,
                        distributor_token: distributor_token,
                        order_token: token,
                        admin_token: gl_admin_token,
                        type: "add_new_product"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateDistributorOrder.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == 200) {
                            $("#exampleModal").modal('hide');
                            $(".additional_product_data").empty();
                            $(".offer_product_data").empty();
                            $("#offer_division_data").val("");
                            $(".se-pre-con").hide();
                            swal("Added new product Successfully!", {
                                icon: "success"
                            });
                            particular_order_detail(token, false);
                        } else {
                            $(".se-pre-con").hide();
                            swal("Something happened!");
                        }
                    });
                } else {
                    swal("Please Select the All field");
                    $(".se-pre-con").hide();
                }
            }

            function cancelButton() {
                $(".additional_product_data").empty();
                $(".offer_product_data").empty();
                $("#offer_division_data").val("");
            }

            function offerPercentageDistributor(key) {
                $(".se-pre-con").show();
                var offer_percentage = $('input[name=input_offer_percent' + key + ']').val();
                var distributor_token = $("#distributor_token").val();
                if (offer_percentage != '') {
                    $('input[name=input_offer_percent' + key + ']').attr("readonly", true);
                    var product_token = item_data[key].product_token;
                    var distributor_quantity = item_data[key].distributor_quantity;
                    var box_price = (parseFloat(item_data[key].price_per_unit) * parseFloat(item_data[key].piece_count)).toFixed(2);
                    var datas = {
                        offer_percentage: offer_percentage,
                        product_token: product_token,
                        box_price: box_price,
                        distributor_quantity: distributor_quantity,
                        dashboard_code: verfication_code,
                        distributor_token: distributor_token,
                        order_token: token,
                        admin_token: gl_admin_token,
                        type: "offer_percentage_value"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateDistributorOrder.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == 200) {
                            $(".se-pre-con").hide();
                            swal("Offer Updated Successfully!", {
                                icon: "success"
                            });
                            particular_order_detail(token, false);
                        } else {
                            $(".se-pre-con").hide();
                            swal("Something happened!");
                        }

                    });
                }
            }
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>