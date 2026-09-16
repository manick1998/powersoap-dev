<?php
    include "config.php";
    include "$api_path/config/core.php";
    if($cookie_admin_name ==""){
        header("Location:login.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Soaps</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/employee.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <style>
    a {
        cursor: pointer;
    }

    .form-control {
        margin: 0 !important;
    }

    .view_link {
        color: #00B9F5 !important;
        text-decoration: underline !important;
    }

    .class1 {
        display: inline-block;
        margin-right: 55px;

    }

    .class2 {
        display: inline-block;

    }

    .class3,
    .table_count {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .nav-pills {
        padding-left: 0 !important;
    }

    .dataTables_wrapper .dataTables_length {
        padding-top: 0 !important;
    }

    .dataTables_filter label {
        top: -10px !important;
    }

    .header-section {
        padding: 0 10px;
    }

    .table.dataTable thead>tr>th.sorting_asc {
        white-space: nowrap;
    }
    .custom-table {
        display: table;
    }
    table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting {
    white-space: nowrap;
    }
 
    .header_container {
    width: 100%;
    margin: auto;
    padding: 0;
    }
    .header-section {
        padding: 20px 20px 0;
    }
    .tab-content {
        width: 100%;
    }
    .items_list {
    padding: 10px 20px 0px;
    }
    div.dataTables_wrapper div.dataTables_info {
        padding-bottom: 20px;
    }
    </style>
</head>

<body>
    <div class="se-pre-con" style="display: none;"></div>
    <header id="main-dash-header" class="dash-header">
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar33"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="daily_summary">
            <div class="header-section">
                <h1 class="header_main">Daily Summary</h1>
                <form class="formdield">
                    <div class="form-group field_data">
                        <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()"
                            type="text" placeholder="From Date" readonly>
                    </div>
                    <div class="form-group field_data">
                        <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()"
                            type="text" placeholder="To Date" readonly>
                    </div>
                </form>
                <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <a class="nav-link rightbot unitBTN active" id="pills-home-tab1" data-toggle="pill"
                            href="#pills-home1" role="tab" aria-controls="pills-home1" aria-selected="true">Unit
                            Summery</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link leftbot customunitBtn" id="pills-profile-tab1" data-toggle="pill"
                            href="#pills-profile1" role="tab" aria-controls="pills-profile1"
                            aria-selected="false">Customised Unit Summery</a>
                    </li>
                </ul>
            </div>
            <div class="header_container">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home1" role="tabpanel"
                        aria-labelledby="pills-home-tab1">
                        <table class="custom-table" id="table_data">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Date Value</th>
                                    <th>Employee Token </th>
                                    <th>Date</th>
                                    <th>Distributor Name</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Outlets Covered</th>
                                    <th>Area</th>
                                    <th>Productivity</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody id="table_body_id">
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade show" id="pills-profile1" role="tabpanel"
                        aria-labelledby="pills-profile-tab1">
                        <table class="custom-table" id="custom_table_data">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <!-- <th>Date Value</th>
                                    <th>Employee Token </th> -->
                                    <th>Date</th>
                                    <th>Distributor Name</th>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Outlets Covered</th>
                                    <th>Area</th>
                                    <th>Productivity</th>
                                    <th>Total Amount</th>
                                </tr>
                            </thead>
                            <tbody id="custom_table_body_id">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <!-- visted shop  pop -->
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Outlets Covered</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="forms">
                            <div class="class3">
                                <div class="class1">
                                    <h1 class="header_main">Visited</h1>
                                    <p class="table_count">
                                        <span id="visited_count"></span>
                                    </p>
                                </div>
                                <div class="class2">
                                    <h1 class="header_main">Orderd</h1>
                                    <p class="table_count">
                                        <span id="order_count"></span>
                                    </p>
                                </div>
                            </div>
                            <!-- <div class="form-control division_name_box">
                            <p class="division_name">Division Name</p>
                            <input class="input-field" id="division_name" placeholder="Enter Division Name">
                        </div> -->
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                    <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                    <button type="button" class="btn model-btn" id="add_division_button" onclick="add_division()">Add Division</button>
                </div> -->
                </div>
            </div>
        </div>

        <section class="bg-white brad-4 full-height" id="daily_summary_view" style="display: none;">
            <div class="employee_header_container">
                <div class="header-details">
                    <img src="assets/back.png" class="back_btn" alt="" onclick="hidemodal2()">
                    <div class="title_box">
                        <div class="header_box">
                            <div class="header_box_contnent">
                                <h1 class="header_main" id="single_view_date"></h1>
                                <p class="table_count mrg_count" id="single_outletscovered"></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Nav tabs -->
            <div class="employee_header_container">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <!-- <button class="nav-link rightbot active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">Shop List</button> -->
                        <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill"
                            href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Shop List</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <!-- <button class="nav-link leftbot" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="true">SKU List</button> -->
                        <a class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-toggle="pill"
                            href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">SKU
                            List</a>
                    </li>
                </ul>
                <div class="items_list">
                    <div class="total_sales col-lg-4">
                        <p>Total Items</p>
                        <span id="total_item_id"></span>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane active fade show" id="pills-home" role="tabpanel"
                        aria-labelledby="pills-home-tab">
                        <table class="custom-table" id="shop_list_table">
                            <thead>
                                <tr>
                                    <th>SI.No</th>
                                    <th>Shop Name</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="shop_table_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="payments" class="table-box w3-border city" style="padding:0 20px;">
                            <table class="custom-table" id="item_list_table">
                                <thead>
                                    <tr>
                                        <th>SI.No</th>
                                        <th>Item Name</th>
                                        <th>Qty</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody id="item_table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white brad-4 full-height" id="shoplist_details" style="display: none;">
            <div class="header_container">
                <div class="header-details">
                    <div class="title_box">
                        <div class="header_box">
                            <h1 class="header_main"><span><img src="assets/back.png" class="back_btn" alt=""
                                        onclick="hide_shoplist()"></span><span id="shop_name_id"></span></h1>
                            <p class="table_count " id="order_token_num" style="margin-left: 60px;"></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Nav tabs -->
            <div class="employee_header_container">
                <div class="items_list">
                    <div class="total_sales  col-lg-4">
                        <p>Date</p>
                        <span id="view_date_id"></span>
                    </div>
                    <div class="total_sales col-lg-4">
                        <p>Total Items</p>
                        <span id="total_items_id"></span>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <table class="custom-table" id="shop_item_table">
                        <thead>
                            <tr>
                                <th>SI.No</th>
                                <th>Item Name</th>
                                <th>Item Code</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                            </tr>
                        </thead>
                        <tbody id="shop_item_table_body">
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var admin_state_id = "<?php echo $cookie_admin_state; ?>";
    </script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->
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

    function hide_shoplist() {
        $('#daily_summary_view').show();
        $('#shoplist_details').hide();
        $('#daily_summary').hide();
    }

    function view_skulist() {
        $('#Skulist_view').show();
        $('#daily_summary').hide();
        $('#daily_summary_view').hide();
    }

    function hide_skulist() {
        $('#daily_summary_view').show();
        $('#Skulist_view').hide();
        $('#daily_summary').hide();
    }
    </script>
    <script>
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table;
    var table1;
    var table_main_data;
    $(document).ready(function() {
        $(".se-pre-con").hide();
        date_filter();

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
            pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
            order: [
                [0, 'desc']
            ],
            'ajax': {
                'url': api_path + "/admin/serverDailySummary.php?from_date=" + from_date + "&&to_date=" +
                    to_date + "&&v_id=" + verfication_code + "&&state_id=" + admin_state_id
            },
            'columns': [{
                    data: 'slno'
                },
                {
                    data: 'date_value'
                },
                {
                    data: 'employee_token'
                },
                {
                    data: 'date_time'
                },
                {
                    data: 'distributor_name'
                },
                {
                    data: 'employee_name'
                },
                {
                    data: 'deparment_name'
                },
                {
                    data: 'outlet'
                },
                {
                    data: 'location_name'
                },
                {
                    data: 'productivity'
                },
                {
                    data: 'billing'
                }
            ],

            language: {
                search: '<img src="assets/svg/Search_icon.svg">',
                searchPlaceholder: "Search"
            }
        });
        table.columns([0, 1, 2]).visible(false);
        //$('.dataTables_length').css("display", "none");
        $(".se-pre-con").fadeOut();
    }

    function custom_data_fetch() {
        // $("#custom_table_data").show();
        var from_date = $("#fromDate").val();
        var to_date = $("#toDate").val();
        var data = {
            type: "custom_unit_summery",
            from_date: from_date,
            to_date: to_date,
        }
        var json_data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/custom_admin_summery.php",
            data: json_data
        }).done(function(data) {
            console.log(data);
            var html = '';
            var count = 1;
            data.data1.forEach(function(item, index) {
                html += `<tr>`
                html += `<td>${count++}</td>`
                html += `<td>${item.date_time}</td>`
                html += `<td>${item.distributor_name}</td>`
                html += `<td>${item.employee_name}</td>`
                html += `<td>${item.deparment_name}</td>`
                html += `<td>${item.outlet}</td>`
                html += `<td>${item.location_name}</td>`
                html += `<td>${item.productivity}</td>`
                html += `<td>${item.billing}</td>`
                '</tr>';
            });
            $("#custom_table_body_id").html(html);
            table1 = $("#custom_table_data").DataTable({
                dom: 'Bfrltip',
                pageLength: <?php echo $page_length; ?>,
                lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
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
        }).fail(function() {
            $(".se-pre-con").hide();
        });
    }


    function date_filter() {
        var from_date = $("#fromDate").val();
        var to_date = $("#toDate").val();
        if (from_date > to_date && to_date != "" && to_date != undefined) {
            $("#toDate").val(from_date);
        }
        var to_date = $("#toDate").val();
        if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
            if ($.fn.DataTable.isDataTable('#table_data')) {
                table.clear();
                table.destroy();
            }
            data_fetch();
            if ($.fn.DataTable.isDataTable('#custom_table_data')) {
                table1.clear();
                table1.destroy();
            }
            custom_data_fetch();
        }
    }

    $(document).on("click", "#btn", function() {
        var emp_token = $(this).attr('data-emp_token');
        var originalDateString = $(this).closest('tr').find('td:eq(0)').text();
        const parts = originalDateString.split('/');
        const day = parts[0];
        const month = parts[1];
        const year = parts[2];
        const date = `${year}-${month}-${day}`;
        var data = {
            type: "visted",
            emp_token: emp_token,
            date: date
        }
        var json_data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/employeeDailySummary.php",
            data: json_data
        }).done(function(data) {
            console.log(data);
            var arr = [];
            var arr1 = [];
            data.data.forEach(function(item, index) {
                if (item.status == '0') {
                    arr.push(item.shop_token);
                } else {
                    arr1.push(item.shop_token);
                }
            });
            $('#visited_count').html(arr.length);
            $('#order_count').html(arr1.length);
        });

        $("#form").modal('show');
    });

    var date_time;
    var date_value;
    var employee_token;
    var order_token;
    $('#table_data tbody').on('click', '.view_link', function() {
        var td_div = $(this).parent().parent();
        var table_data = table.row(td_div).data();
        date_time = table_data.date_time;
        date_value = table_data.date_value;
        employee_token = table_data.employee_token;
        var outlet = table_data.outlet;
        var department_name = table_data.deparment_name;
        particular_date_emp_detail(outlet);
    });
    //======custom
    $('#custom_table_data tbody').on('click', '.view_link', function() {
        date_time = $(this).text();
        date_value = $(this).attr('data-date_value');
        employee_token = $(this).attr('data-employee_token');
        var outlet = $(this).attr('data-outlet');
        particular_date_emp_detail(outlet);
    });

    var shop_table_check = false;
    var shop_data;
    var item_data
    var shop_table;
    var summary_date;

    function particular_date_emp_detail(outlet) {
        $(".se-pre-con").show();
        summary_date = date_time.substr(22, 10);
        $("#single_view_date").html(summary_date);
        $("#single_outletscovered").html("Outlets Covered - " + outlet);
        $('#daily_summary').hide();
        $('#daily_summary_view').show();
        var datas = {
            dashboard_code: verfication_code,
            selected_date: date_value,
            employee_token: employee_token,
            type: "particular_date_detail"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/employeeDailySummary.php",
            data: json_data
        }).done(function(data) {
            console.log('sku', data);
            if (shop_table_check) {
                shop_table.clear();
                shop_table.destroy();
            }

            shop_data = data.data;
            var html_text = "";
            var slno = 0;
            for (var key in shop_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>' + slno + '</td>';
                html_text += '<td>' + shop_data[key].shop_name + '</td>';
                html_text += '<td>' + shop_data[key].shop_type + '</td>';
                html_text += '<td>' + shop_data[key].items + '</td>';
                html_text += '<td>' + shop_data[key].billing_amount + '</td>';
                html_text += '<td><a class="view_link" onclick="view_shoplist(' + key +
                    ')">View Detail</a></td>';
                html_text += '</tr>';
            }
            $("#shop_table_body").html(html_text);
            item_data = data.data_item;
            var html_text = "";
            var slno1 = 0;
            for (var key in item_data) {
                slno1++;
                html_text += '<tr>';
                html_text += '<td>' + slno1 + '</td>';
                html_text += '<td>' + item_data[key].item_name + '</td>';
                html_text += '<td>' + item_data[key].quantity + '</td>';
                html_text += '<td>' + item_data[key].units + '</td>';
                html_text += '</tr>';
            }
            $("#item_table_body").html(html_text);

            $("#total_item_id").html(slno1);
            shop_table = $("#shop_list_table,#item_list_table").DataTable({
                dom: 'Bfrltip',
                pageLength: <?php echo $page_length; ?>,
                lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
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
            shop_table_check = true;
            $(".se-pre-con").hide();
        });
    }
    var shop_item_table;
    var shop_item_table_check = false;

    function view_shoplist(key) {
        if (shop_item_table_check) {
            shop_item_table.destroy();
            shop_item_table.clear();
        }
        $("#view_date_id").html(summary_date);
        $("#shop_name_id").html(shop_data[key].shop_name);
        $("#order_token_num").html(shop_data[key].order_token);
        var datas = {
            dashboard_code: verfication_code,
            selected_date: date_value,
            employee_token: employee_token,
            shop_token: shop_data[key].shop_token,
            order_token: shop_data[key].order_token,
            type: "particular_date_detail_shop"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/employeeDailySummary.php",
            data: json_data
        }).done(function(data) {
            $(".se-pre-con").show();
            var shop_item_data = data.data;
            var html_text = "";
            var slno1 = 0;
            for (var key in shop_item_data) {
                slno1++;
                html_text += '<tr>';
                html_text += '<td>' + slno1 + '</td>';
                html_text += '<td>' + shop_item_data[key].item_name + '</td>';
                html_text += '<td>' + shop_item_data[key].item_code + '</td>';
                html_text += '<td>' + shop_item_data[key].quantity + '</td>';
                html_text += '<td>' + shop_item_data[key].units + '</td>';
                html_text += '</tr>';
            }
            $("#shop_item_table_body").html(html_text);
            $("#total_items_id").html(slno1);
            shop_item_table = $("#shop_item_table").DataTable({
                dom: 'Bfrltip',
                pageLength: <?php echo $page_length; ?>,
                lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
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
            $("#shop_item_table_filter").css("display", "none");
            shop_item_table_check = true;
            $('#daily_summary').hide();
            $('#daily_summary_view').hide();
            $(".se-pre-con").hide();
            $('#shoplist_details').show();
        });
    }
    </script>
</body>

</html>
<?php
}
mysqli_close($link);
?>