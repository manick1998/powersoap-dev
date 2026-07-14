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
        <title>Power soap</title>
        <link rel="shortcut icon" href="assets/favicon.ico">
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
            .nav-pills .nav-link,
            .nav-pills .show>.nav-link {
                background-color: #fff;
                border: #00b9f5 2px solid;
                color: #00b9f5;
                transition: 1s;
                border-radius: 4px;
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

            .rightbot {
                border-top-right-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
            }

            .leftbot {
                border-top-left-radius: 0 !important;
                border-bottom-left-radius: 0 !important;
            }

            .dataTables_scrollHeadInner {
                width: 100% !important;
            }

            .table-filter {
                text-align: right;
                margin-bottom: 12px;
                padding: 0 20px;
            }

            .table-filter-box {
                display: inline-block;
                position: relative;
            }

            .search-input {
                padding: 10px 10px 10px 36px;
                outline: none;
                border: 1px solid #cfcfcf;
                width: 200px;
                border-radius: 4px;
            }

            .search-label {
                position: absolute;
                left: 12px;
                top: 11px;
            }

            .ui-datepicker {
                z-index: 9999 !important;
            }

            .table_count {
                margin-left: 0;
            }

            .selectField {
                border: 1px solid var(--primary-color) !important;
                color: var(--primary-color) !important;
            }

            .nav-pills {
                margin-left: 0 !important;
            }

            .dataTables_filter label {
                top: -40px !important;
            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header"></header>
        <div class="se-pre-con"></div>
        <!-- sidebar -->
        <!-- <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar6"></div> -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar3"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="head">
                <div class="header_container">
                    <div>
                        <h1 class="header_main">Distributor Orders Count</h1>
                        <!-- <p class="table_count">Total - <span id="total_count"></span></p>
                        <p class="table_count1" style="display:none">Total - <span id="total_count1"></span></p> -->
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                        </div>
                        <div class="form-group">
                            <select id="selectState" class="selectField form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="selectRegion" class="selectField form-control">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button id="stateGoBtn" type="button" class="primary-btn">Go</button>
                        </div>
                    </form>

                    <ul class="nav nav-pills mb-3 mt-3 ml-4" id="pills-tab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" onclick="order_placedcheck()">Order
                                Placed</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false" onclick="no_ordercheck()">No
                                Order</a>
                        </li>
                    </ul>



                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-box">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>SlNo</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Order Count</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="table-box">
                                <div class="table-filter" style="display:none;">
                                    <div class="table-filter-box">
                                        <!-- <input type="search" class="search-input" id="custom_table_search" placeholder="search"> -->
                                        <!-- <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label> -->
                                        <!-- for="table-search" -->
                                    </div>
                                </div>
                                <table class="custom-table" id="table_data1">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Order Count</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id1"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </section>
        </main>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

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
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0');
            var yyyy = today.getFullYear();
            today = yyyy + '-' + mm + '-' + dd;
            $('#datePicker').attr('min', today);
            $('#fromDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
            $('#toDate').datepicker({
                autoclose: true,
                todayHighlight: true,
                dateFormat: 'yy-mm-dd',
                maxDate: 0
            });
        </script>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";

            function back_tofirst() {
                $('#first').show();
                $('#view_shoplist').hide();
                $('#head').hide();
            }

            function back_tosecond() {
                $('#second').show();
                $('#view_unitlist').hide();
                $('#head').hide();
            }

            function back_tohead() {
                $('#head').show();
                $('#first').hide();
                $('#second').hide();
            }

            function view_unitpage() {
                $("#view_unitlist").hide();
                $("#view_unit").show();
            }

            function back_tounitlist() {
                $("#view_unitlist").show();
                $("#view_unit").hide();
            }

            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";

            // var table;
            // var table1;

            function order_placed(type) {
                $('#table_data').DataTable().destroy();
                if (type == 'all') {
                    var datas = {
                        type: "order_placed"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';
                        });

                        $("#table_body_id").html(html_text);
                        // var rowCount = $('#table_body_id tr').length;
                        // $("#total_count").html(rowCount);
                        $("#table_data").DataTable({
                            //lengthChange:true,
                            dom: 'Bfrtip',
                            // lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'Distributor_order_count:',
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-primary buttonprint',
                                    title: 'Distributor_order_count:',
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

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
                        $(".se-pre-con").hide();
                    });

                } else if (type == 'selectState') {
                    $('#table_data').DataTable().destroy();
                    fromDate = $("#fromDate").val();
                    toDate = $("#toDate").val();
                    var state = $('#selectState :selected').val();
                    var data = {
                        type: "date_filter",
                        state: state,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';


                        });
                        $("#table_body_id").html(html_text);
                        // var rowCount = $('#table_body_id tr').length;
                        // $("#total_count").html(rowCount);
                        $("#table_data").DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-info buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

                                "visible": false,
                                "searchable": false
                            }],
                            //lengthChange:true,

                            // lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                            language: {
                                search: '<img src="assets/svg/Search_icon.svg">',
                                searchPlaceholder: "Search",
                                paginate: {
                                    next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                    previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                                }
                            }
                        });
                    });
                } else {
                    $('#table_data').DataTable().destroy();
                    fromDate = $("#fromDate").val();
                    toDate = $("#toDate").val();
                    var state = $('#selectState :selected').val();
                    var region = $('#selectRegion :selected').val();
                    var data = {
                        type: "date_filter",
                        state: state,
                        region: region,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';


                        });
                        $("#table_body_id").html(html_text);
                        // var rowCount = $('#table_body_id tr').length;
                        // $("#total_count").html(rowCount);
                        $("#table_data").DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-info buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

                                "visible": false,
                                "searchable": false
                            }],
                            //lengthChange:true,

                            // lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                            language: {
                                search: '<img src="assets/svg/Search_icon.svg">',
                                searchPlaceholder: "Search",
                                paginate: {
                                    next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                    previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                                }
                            }
                        });
                    });
                }
            }

            function no_order(type) {
                $('#table_data1').DataTable().destroy();
                if (type == 'all') {
                    var datas = {
                        type: "no_order"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';


                        });
                        $("#table_body_id1").html(html_text);
                        $("#table_data1").DataTable({

                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'No order Distributor:' + $('#fromDate').val() + 'to' + $(
                                        '#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-primary buttonprint',
                                    title: 'No order Distributor:' + $('#fromDate').val() + 'to' + $(
                                        '#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

                                "visible": false,
                                "searchable": false
                            }],
                            dom: 'Bfrtip',
                            language: {
                                search: '<img src="assets/svg/Search_icon.svg">',
                                searchPlaceholder: "Search",
                                paginate: {
                                    next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                    previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                                }
                            }
                        });
                    });
                } else if (type == 'stateSelect') {
                    $('#table_data1').DataTable().clear().destroy();
                    fromDate = $("#fromDate").val();
                    toDate = $("#toDate").val();
                    var state = $('#selectState :selected').val();
                    var data = {
                        type: "non_order",
                        state: state,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';


                        });

                        $("#table_body_id1").html(html_text);
                        // var rowCount = $('#table_body_id1 tr').length;
                        // $("#total_count").html(rowCount);
                        $("#table_data1").DataTable({

                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'No order Distributor:' + $('#fromDate').val() + 'to' + $(
                                        '#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-primary buttonprint',
                                    title: 'No order Distributor:' + $('#fromDate').val() + 'to' + $(
                                        '#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

                                "visible": false,
                                "searchable": false
                            }],
                            // lengthChange:true,
                            dom: 'Bfrtip',
                            // lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                            language: {
                                search: '<img src="assets/svg/Search_icon.svg">',
                                searchPlaceholder: "Search",
                                paginate: {
                                    next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                    previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                                }
                            }
                        });
                    });

                } else {
                    $('#table_data1').DataTable().destroy();
                    fromDate = $("#fromDate").val();
                    toDate = $("#toDate").val();
                    var state = $('#selectState :selected').val();
                    var region = $('#selectRegion :selected').val();
                    var data = {
                        type: "non_order",
                        state: state,
                        region: region,
                        fromDate: fromDate,
                        toDate: toDate
                    }
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributr_order_count.php",
                        data: json_data,
                    }).done(function(data) {
                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.mobile_number} </td>`
                            html_text += `<td> ${item.state_name} </td>`
                            html_text += `<td> ${item.region_name} </td>`
                            html_text += `<td> ${item.order_count} </td>`
                            '</tr>';


                        });
                        $("#table_body_id1").html(html_text);
                        $("#table_data1").DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-info buttonprint',
                                    title: 'Distributor_withorder:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5]
                                    },
                                    orientation: 'landscape',
                                    pageSize: 'LEGAL'
                                }
                            ],
                            "columnDefs": [{

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
                    });
                }

            }

            $(document).ready(function() {

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
                    let data = datas.data;
                    let html_text = '<option value="">Select State</option>';
                    for (let key in data) {
                        html_text +=
                            `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                    }
                    $('#selectState').html(html_text);
                });

                order_placed('all')

            });

            $(document).on('change', '#selectState', function() {
                let region = {
                    dashboard_code: verfication_code,
                    type: "region",
                    state_id: $("#selectState").val()
                };
                var json_data = JSON.stringify(region);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/filterReportDropDown.php",
                    data: json_data,
                }).done(function(datas) {
                    console.log("datas", datas);
                    let data = datas.data;
                    let html_text = '<option value="">Select Region</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].token}">${data[key].region_name}</option>`;
                    }
                    $('#selectRegion').html(html_text);
                });
            });

            var stateSelect = 0;

            //state change
            $(document).on('change', '#selectState', function() {
                stateSelect = 1;
                order_placed('selectState');
            });



            $(document).on('click', '#stateGoBtn', function() {
                stateSelect = 2;
                order_placed('filter');
            })

            function order_placedcheck() {
                if (stateSelect == 0) {
                    order_placed('all');
                } else if (stateSelect == 1) {
                    order_placed('stateSelect');
                } else {
                    order_placed('filter');
                }
            }

            function no_ordercheck() {
                if (stateSelect == 0) {
                    no_order('all');
                } else if (stateSelect == 1) {
                    no_order('stateSelect');
                } else {
                    no_order('filter');
                }
            }
        </script>
    </body>

    </html>
<?php
}
?>