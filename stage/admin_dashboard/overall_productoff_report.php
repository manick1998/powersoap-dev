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
        <title>Product list</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select2.min.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>

    </head>
    <style>
        .nav-pills .nav-link,
        .nav-pills .show>.nav-link {
            background-color: #fff;
            border: 1px solid #00b9f5;
            color: #00b9f5;
            transition: 1s;
            border-radius: 0;
        }

        .nav-pills .nav-link:hover,
        .nav-pills .show>.nav-link:hover {
            background-color: #00b9f5;
            color: #fff !important;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #00b9f5 !important;
        }

        .nav-item-center {
            margin-left: 100px;
        }

        .dataTables_filter label {
            top: 30px !important;
        }

        .dataTables_filter .box_form {
            height: 58px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: 1px solid #ccc !important;
            outline: 0;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #ccc !important;
        }

        a {
            cursor: pointer;
        }

        .header-details {
            display: flex;
            align-items: center;
        }

        .product_header_container .header-details h1 {
            padding: 20px 32px;
        }

        .a_button {
            color: #00b9f5 !important;
        }

        #item_code_color {
            color: red;
        }

        .modal-footer .deactive-btn {
            font: 16px var(--semibold-font);
            width: 140px;
            height: 40px;
            border: 1px solid #F44336;
            border-radius: 2px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .modal-footer .deactive-btn:hover {
            color: #F44336;
            background-color: transparent;
        }

        .chosen-container-single .chosen-single {
            position: relative;
            display: block;
            overflow: hidden;
            padding: 0px 5px;
            height: 23px;
            border: none;
            border-radius: 4px;
            background-color: transparent;
            box-shadow: none;
            color: #444;
            text-decoration: none;
            white-space: nowrap;
            line-height: 22px;
        }

        .header-section {
            width: 100%;
        }

        .inventory-top {
            width: 80%;
        }

        .view_link1 {
            font: 16px var(--semibold-font);
            color: #00B9F5 !important;
            margin-right: 20px;
            cursor: pointer;
            text-decoration: underline;
        }

        .view_link2 {
            font: 16px var(--semibold-font);
            color: #28ce7e !important;
            margin-right: 20px;
            cursor: pointer;
            text-decoration: underline;
        }

        .flex-set {
            display: flex;
        }

        .pdf-btn {
            background: #bc87f0 !important;
            padding: 8px 15px;
            border-radius: 4px;
            color: #fff !important;
            border: 1px solid #bc87f1 !important;
        }

        .cust-select-box {
            margin-left: 15px;
            width: 150px;
        }

        .ui-datepicker {
            z-index: 9999 !important;
        }

        .field_data {
            margin-right: 35px;
        }

        input#btndeactive {
            font: 16px var(--semibold-font);
            width: 130px;
            height: 40px;
            border: 1px solid #f54336;
            border-radius: 2px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .upload_file {
            cursor: pointer;
        }

        .module-option {
            width: 33.33%;
            padding: 0px 5px;
        }

        .module-option label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            position: relative;
        }

        .modal-input:checked~.cust-checkbox {
            background-color: #51c568;
            border-color: #51c568;
            animation-name: input-animate;
            animation-duration: 0.7s;
        }

        .modal-dialog-scrollable {
            height: calc(100% - 1rem);
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            flex: 1 1 auto;
        }

        .bodyheight {
            height: 400px;
        }

        /* image upload  */
        .custom-file {
            display: block;
            width: 180px;
            height: 40px;
            border: #00b9f5 1px solid;
            color: #00b9f5;
            border-radius: 4px;
            cursor: pointer;
        }

        .custom-file h5 {
            text-align: center;
            line-height: 35px;
            font-size: 18px;
        }

        .custom-file span {
            padding-top: 20px;
        }

        .img---uplod {
            display: flex;
            flex-direction: column;

        }

        /* width */
        .bodyheight::-webkit-scrollbar {
            width: 10px;
            display: block;
        }

        /* Track */
        .bodyheight::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .bodyheight::-webkit-scrollbar-thumb {
            background: #2196F3;
        }

        /* Handle on hover */
        .bodyheight::-webkit-scrollbar-thumb:hover {
            background: #00bcd4;
        }

        @media (min-width: 576px) {
            .modal-dialog-scrollable {
                height: calc(100% - 3.5rem);
            }
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

        .remove-btn {
            font: 16px var(--semibold-font);
            width: 160px;
            height: 40px;
            border: 1px solid #f54336;
            border-radius: 6px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        #removeGiftField {
            margin: 15px 0;
        }

        .remove-btn:hover {
            background-color: #fff;
            color: #f44336;
        }

        .modal-footer .createScheme-btn {
            font: 16px var(--semibold-font);
            width: 150px;
            height: 40px;
            border: 1px solid #00B9F5;
            border-radius: 2px;
            background-color: #00B9F5;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .modal-footer .createScheme-btn:hover {
            color: #00B9F5;
            background-color: transparent;
        }

        .product_list button {
            margin-left: 0px;
        }

        .main-contents .nav {
            width: 72%;
            /* gap: 20px; */
            margin-left: 30px;
        }

        .dt-buttons.btn-group {
            margin-left: 30px;
        }

        #product {
            display: none;
        }

        /* multi select */
        .select2-container {
            margin-right: 10px;
        }

        .select2-container--default .select2-selection--multiple {
            height: 58px;
            overflow-y: auto;
        }

        .select2-selection--multiple::-webkit-scrollbar {
            width: 3px;
            display: block;
        }

        .select2-selection--multiple::-webkit-scrollbar-track {
            background-color: rgb(255, 255, 255);
            -webkit-border-radius: 1px;
        }

        .select2-selection--multiple::-webkit-scrollbar-thumb:vertical {
            background-color: rgb(142, 142, 142);
            -webkit-border-radius: 0px;
            -webkit-width: 5;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-left: 5px;
        }

        .select2-selection--multiple::-webkit-scrollbar-thumb:vertical:hover {
            background: rgba(0, 245, 255, 0.65);
        }

        span {
            padding: 0;
        }

        .form-control {
            margin: 20px 0;
        }

        .dataTables_filter select.form-control {
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .singleSelect {
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 6px;
            margin: 0px 10px 0px 0;
            height: 58px;
        }

        .primary-btn {
            height: 58px !important;
        }
    </style>

    <body>
        <div class="se-pre-con"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar12"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle5">
                <div class="product_header_container">
                    <div class="header-details ">
                        <h1 class="header_main">Overall item sales report</h1>
                        <p class="table_count">Total - <span id="total_count">0</span></p>
                    </div>
                </div>
                <ul class="nav nav-pills mb-3 mt-3 ml-4" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Order Placed</a>
                    </li>
                    <!-- <li class="nav-item" role="presentation">
                        <a class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">No
                            Order</a>
                    </li> -->
                </ul>
                <!-- Nav tabs -->
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                        </div>
                        <div class="form-group">
                            <select class="singleSelect input-field" style="width: 270px" id="state_filter">
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="myselect input-field" multiple="multiple" style="width: 270px" id="division">
                            </select>
                        </div>
                        <!-- <div class="form-group">
                        <select class="myselect input-field" multiple="multiple" style="width: 300px" id="product">
                        </select>
                    </div> -->
                        <div class="form-group">
                            <button id="stateGoBtn" type="button" class="primary-btn">Go</button>
                        </div>
                    </form>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <table class="custom-table" id="table_data" style="display:none">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>State</th>
                                    <th>Division</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <!-- <th>Discount</th> -->
                                    <th>Total Sales Amount</th>
                                </tr>
                            </thead>
                            <tbody id="table_body"></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="6" style="text-align:right"></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <table class="custom-table" id="table_data2" style="display:none">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Division</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Total Sales Amount</th>
                                </tr>
                            </thead>
                            <tbody id="table_body1"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>

        <!-- jquery CDN -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>

        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var table1;
            var fromDate;
            var toDate;
            $(".se-pre-con").hide();
            //hide and show
            $("#differentcheckbox").click(function() {
                $(".product_division_box").show();
                $(".product_division_box").show();
            });
            $("#samecheckbox").click(function() {
                if ($(this).is(":checked")) {
                    $(".product_division_box").hide();
                    $(".product_division_box").hide();

                }
            });
            //     var placeholder = "select";
            //    $(".mySelect").select2({
            //         data: data,
            //         placeholder: placeholder,
            //         allowClear: false,
            //         minimumResultsForSearch: 5
            //     });
            //     var placeholder = "select";
            //     $(".myselect").select2({
            //         data: data,
            //         placeholder: placeholder,
            //         allowClear: false,
            //         minimumResultsForSearch: 5
            //     });
            //date picker
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#datePicker').attr('min', today);
            $('#fromDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd'
            });
            $('#toDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd'
            });
        </script>
        <script>
            $(document).ready(function() {
                //allstate
                let state = {
                    type: "allstate",

                };
                var json_data = JSON.stringify(state);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data: json_data,
                }).done(function(datas) {
                    let data = (datas.data || []).filter(function(stateItem) {
                        return !/karaikal/i.test(stateItem.state_name || '');
                    });
                    let html_text = '<option value="">Select State</option>';
                    for (let key in data) {
                        html_text +=
                            `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                    }
                    $('#state_filter').html(html_text);
                    // $('#state_filter').select2({
                    //             closeOnSelect: false,
                    //             placeholder: "Please select State"
                    //         });
                });

                let division = {
                    type: "all"
                };
                var json_data1 = JSON.stringify(division);
                //console.log(json_data1);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data1,
                }).done(function(datas) {
                    //console.log('data',datas);
                    var data = datas.data;
                    var html_text1 = '<option class="all" value="all">Select All Division</option>';
                    for (var key in data) {
                        html_text1 += '<option value="' + data[key].division_token + '">' + data[key]
                            .division_name + '</option>';
                    }
                    division = html_text1;
                    $("#division").html(html_text1);
                    $('#division').select2({
                        closeOnSelect: false,
                        placeholder: "Division"
                    });
                });
                //product         
                // let product = {
                //     type: "productall"
                // };
                // var json_data1 = JSON.stringify(product);
                // console.log(json_data1);
                // $.ajax({
                //     type: "POST",
                //     dataType: "json",
                //     url: api_path + "/admin/singleDivisionDetails.php",
                //     data: json_data1,
                // }).done(function(datas) {
                //     var data = datas.data;
                //     var html_text1 = '<option class="all" value="all">Select All Product</option>';
                //     for (var key in data) {
                //         html_text1 += '<option value="' + data[key].token + '">' + data[key]
                //             .name + '</option>';
                //     }
                //     $("#product").html(html_text1);
                //     $('#product').select2({
                //         closeOnSelect: false,
                //         placeholder: "Product"
                //     });
                // });

            });


            var table_main_data;




            $('body').on('click', '#stateGoBtn,#pills-home-tab', function() {
                $("#table_data").DataTable().clear().destroy();
                $('#table_data').css("display", "table");
                fromDate = $("#fromDate").val();
                toDate = $("#toDate").val();
                var state = $('#state_filter').val();
                var division_token = [];
                $('#division :selected').each(function() {
                    division_token.push($(this).val());
                });
                if (fromDate != "" && toDate != "" && state.length != 0 && division_token.length != 0) {
                    var data = {
                        type: "generel",
                        type1: 'three',
                        state: state,
                        division_token: division_token,
                        // product: product,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/overall_item_product_report.php",
                        data: json_data,
                    }).done(function(data) {
                        success2(data);
                    })
                } else {
                    swal({
                        text: "Please Select AllDropDown!",
                        type: "success"
                    }).then(function() {
                        location.reload();
                    });
                }

            });

            $(document).on('click', '#pills-profile-tab', function() {
                $("#table_data2").DataTable().clear().destroy();
                $('#table_data2').css("display", "table");
                fromDate = $("#fromDate").val();
                toDate = $("#toDate").val();
                var state = $('#state_filter').val();
                var division_token = [];
                $('#division :selected').each(function() {
                    division_token.push($(this).val());
                });
                if (fromDate != "" && toDate != "" && state.length != 0 && division_token.length != 0) {
                    var data = {
                        type: "generel",
                        type1: 'three',
                        state: state,
                        division_token: division_token,
                        // product: product,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/overall_item_product_report.php",
                        data: json_data,
                    }).done(function(data) {
                        success(data, product);
                    })
                } else {
                    swal({
                        text: "Please Select AllDropDown!",
                        type: "success"
                    }).then(function() {
                        location.reload();
                    });
                }

            });


            var table_main_data;

            function success2(data) {
                table_main_data = data.data;
                console.log(table_main_data);
                var html_text = "";
                var slno = 0;
                for (var key in table_main_data) {
                    slno++;
                    html_text += '<tr>';
                    html_text += '<td>' + slno + '</td>';
                    html_text += '<td>' + table_main_data[key].state_name + '</td>';
                    html_text += '<td>' + table_main_data[key].division_name + '</td>';
                    html_text += '<td>' + table_main_data[key].product_name + '</td>';
                    html_text += '<td>' + table_main_data[key].quantity + '</td>';
                    html_text += '<td>' + table_main_data[key].price_per_unit + '</td>';
                    // html_text += '<td>' + table_main_data[key].total_offer_amount.toLocaleString('en-IN') + '</td>';
                    html_text += '<td>' + table_main_data[key].total_sales_amount.toLocaleString('en-IN') + '</td>';
                    html_text += '</tr>';
                }
                $("#total_count").html(slno);
                $('#table_body').html(html_text);
                table1 = $("#table_data").DataTable({
                    dom: 'Bfrltip',
                    lengthChange: true,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    "footerCallback": function(row, data, start, end, display) {
                        var api = this.api(),
                            data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function(i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                i : 0;
                        };
                        if ((this.api().data().length) > 0) {
                            // Total over all pages
                            total = api
                                .column(6)
                                .data()
                                .reduce(function(a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0);

                            // Update footer
                            $(api.column(6).footer()).html('Total: ' + total);
                        } else {
                            $(api.column(6).footer()).hide();
                        }
                    },
                    buttons: [{
                        extend: 'pdfHtml5',
                        className: 'btn-primary buttonprint',
                        title: 'Overall item sales report:' + $('#fromDate').val() + 'to' + $('#toDate').val(),
                        orientation: 'landscape',
                        footer: true,
                        pageSize: 'LEGAL',
                    }, {
                        extend: 'csv',
                        className: 'btn-info buttonprint',
                        title: 'overall item sales report:' + $('#fromDate').val() + 'to' + $('#toDate').val(),
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }],
                    "columnDefs": [{
                        // "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });

            }

            var table_main_data;

            function success(data, product) {
                table_no_order_data = data.product;
                var dataTokens = table_main_data.map(item => item.product_token);
                var productTokens = table_no_order_data.map(item => item.product_token);
                var uniqueDataTokens = dataTokens.filter(token => !productTokens.includes(token));
                var uniqueProductTokens = productTokens.filter(token => !dataTokens.includes(token));
                var uniqueData = table_main_data.filter(item => uniqueDataTokens.includes(item.product_token));
                var uniqueProduct = table_no_order_data.filter(item => uniqueProductTokens.includes(item.product_token));
                var test = [];
                test = uniqueData.concat(uniqueProduct);
                var html_text1 = "";
                var slno1 = 0;


                for (var key in test) {
                    slno1++;
                    html_text1 += '<tr>';
                    html_text1 += '<td>' + slno1 + '</td>';
                    html_text1 += '<td>' + test[key].name + '</td>';
                    html_text1 += '<td>' + test[key].product_name + '</td>';
                    html_text1 += '<td>' + 0 + '</td>';
                    html_text1 += '<td>' + 0 + '</td>';
                    html_text1 += '</tr>';

                }

                $("#table_body1").html(html_text1);
                $("#total_count").html(slno1);

                table = $("#table_data2").DataTable({
                    dom: 'Bfrltip',
                    lengthChange: true,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    buttons: [{
                        extend: 'pdfHtml5',
                        className: 'btn-primary buttonprint',
                        title: 'No Order overallProduct_report:' + $('#fromDate').val() + 'to' + $('#toDate')
                            .val(),
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        footer: true
                    }, {
                        extend: 'csv',
                        className: 'btn-info buttonprint',
                        title: 'No order OverAllProduct_report:' + $('#fromDate').val() + 'to' + $('#toDate')
                            .val(),
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        footer: true
                    }],
                    "columnDefs": [{
                        //"targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
            }



            //division overall select
            $('#division').on("select2:select", function(e) {
                var data = e.params.data.text;
                if (data == 'Select All Division') {
                    $("#division > option").prop("selected", "selected");
                    $(".all").prop("selected", false);
                    $("#division").trigger("change");
                }
                //console.log($(this).val());
            });

            //product overall select
            // $('#product').on("select2:select", function(e) {
            //     var data = e.params.data.text;
            //     if (data == 'Select All Product') {
            //         $("#product > option").prop("selected", "selected");
            //         $(".all").prop("selected", false);
            //         $("#product").trigger("change");
            //     }
            //     console.log($(this).val());
            // });
        </script>

    </body>

    </html>
<?php
}
mysqli_close($link);
?>