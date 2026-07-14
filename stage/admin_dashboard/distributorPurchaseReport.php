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
                        <h1 class="header_main">Distributor Purchase Report</h1>
                        <p class="table_count">Total - <span id="total_count"></span></p>
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
                            <select id="selectDivision" class="selectField form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="selectProduct" class="selectField form-control">
                            </select>
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
                            <button id="stateGoBtn" type="button" class="primary-btn" onclick="reportOverall()">Go</button>
                        </div>
                    </form>



                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-box">
                                <table class="custom-table" id="table_data" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>SlNo</th>
                                            <th>Distributor Name</th>
                                            <th>Product Name</th>
                                            <th>Division Name</th>
                                            <th>Region Name</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align:right"></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="table-box">
                                <table class="custom-table" id="table_data1">
                                    <thead>
                                        <tr>
                                            <th>SlNo</th>
                                            <th>Distributor Name</th>
                                            <th>Product Name</th>
                                            <th>Division Name</th>
                                            <th>State Name</th>
                                            <th>Quantity</th>
                                            <th>Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id1"></tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5" style="text-align:right"></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
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


            function reportOverall() {
                // $("#selectState").hide();
                $(".se-pre-con").hide();
                $('#table_data1').css("display", "none");
                $('#table_data1').DataTable().destroy();
                $('#table_data').css("display", "table");
                $('#table_data').DataTable().destroy();
                var fromDate = $("#fromDate").val();
                var toDate = $("#toDate").val();
                var division = $("#selectDivision").val();
                var product = $("#selectProduct").val();
                var state = $('#selectState :selected').val();
                var region = $('#selectRegion :selected').val();
                var data = {
                    type: "date_filter",
                    state: state,
                    region: region,
                    fromDate: fromDate,
                    toDate: toDate,
                    division: division,
                    product: product
                };
                var json_data = JSON.stringify(data);
                if (fromDate != '' && toDate != '' && state != '' && division != '') {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributorPurchaseReport.php",
                        data: json_data,
                    }).done(function(data) {

                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.product_name} </td>`
                            html_text += `<td> ${item.division_name} </td>`
                            html_text += `<td> ${item.region} </td>`
                            html_text += `<td> ${item.total_quantity} </td>`
                            html_text += `<td> ${item.total_amount} </td>`
                            '</tr>';
                        });
                        $("#table_body_id").html(html_text);
                        $("#total_count").html(count - 1);
                        $("#table_data").DataTable({
                            dom: 'Bfrtip',
                            pageLength: <?php echo $page_length; ?>,
                            lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                            "footerCallback": function(row, data, start, end, display) {
                                var api = this.api();

                                // Function to convert strings to integers
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };

                                if (api.data().length > 0) {
                                    // Calculate total for column 5
                                    var total1 = api
                                        .column(5)
                                        .data()
                                        .reduce(function(a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0);


                                    // Update footer for column 5
                                    $(api.column(5).footer()).html('Total: ' + total1);
                                } else {
                                    // If no data available, hide footers
                                    $(api.column(5).footer()).hide();
                                }
                            },
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'DistributorPurchaseRegionReport:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6]
                                    },
                                    orientation: 'landscape',
                                    footer: true,
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-info buttonprint',
                                    title: 'DistributorPurchaseRegionReport:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6]
                                    },
                                    orientation: 'landscape',
                                    footer: true,
                                    pageSize: 'LEGAL'
                                }
                            ],
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
                    swal("Please Select all DropDown");
                }
            }

            $(document).on('change', '#selectState', function() {
                $(".se-pre-con").hide();
                $('#table_data').DataTable().destroy();
                $('#table_data1').DataTable().destroy();
                $('#table_data1').css("display", "block");
                $('#table_data').css("display", "none");
                var fromDate = $("#fromDate").val();
                var toDate = $("#toDate").val();
                var division = $("#selectDivision").val();
                var product = $("#selectProduct").val();
                var state = $('#selectState :selected').val();
                var data = {
                    type: "state_filter",
                    state: state,
                    fromDate: fromDate,
                    toDate: toDate,
                    division: division,
                    product: product
                };
                var json_data = JSON.stringify(data);
                if (fromDate != '' && toDate != '' && state != '' && division != '') {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/distributorPurchaseReport.php",
                        data: json_data,
                    }).done(function(data) {

                        var html_text = "";
                        var count = 1;
                        data.data.forEach(function(item, index) {
                            html_text += `<tr>`
                            html_text += `<td> ${count++} </td>`
                            html_text += `<td> ${item.distributor_name} </td>`
                            html_text += `<td> ${item.product_name} </td>`
                            html_text += `<td> ${item.division_name} </td>`
                            html_text += `<td> ${item.state} </td>`
                            html_text += `<td> ${item.total_quantity} </td>`
                            html_text += `<td> ${item.total_amount} </td>`
                            '</tr>';
                        });
                        $("#table_body_id1").html(html_text);
                        $("#total_count").html(count - 1);
                        $("#table_data1").DataTable({
                            dom: 'Bfrtip',
                            pageLength: <?php echo $page_length; ?>,
                            lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                            "footerCallback": function(row, data, start, end, display) {
                                var api = this.api();

                                // Function to convert strings to integers
                                var intVal = function(i) {
                                    return typeof i === 'string' ?
                                        i.replace(/[\$,]/g, '') * 1 :
                                        typeof i === 'number' ?
                                        i : 0;
                                };

                                if (api.data().length > 0) {
                                    // Calculate total for column 5
                                    var total1 = api
                                        .column(5)
                                        .data()
                                        .reduce(function(a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0);


                                    // Update footer for column 5
                                    $(api.column(5).footer()).html('Total: ' + total1);

                                } else {
                                    // If no data available, hide footers
                                    $(api.column(5).footer()).hide();
                                }
                            },
                            buttons: [{
                                    extend: 'pdfHtml5',
                                    className: 'btn-primary buttonprint',
                                    title: 'DistributorPurchaseStateReport:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6]
                                    },
                                    orientation: 'landscape',
                                    footer: true,
                                    pageSize: 'LEGAL'
                                },
                                {
                                    extend: 'csv',
                                    className: 'btn-info buttonprint',
                                    title: 'DistributorPurchaseStateReport:' + $('#fromDate').val() + 'to' +
                                        $('#toDate').val(),
                                    exportOptions: {
                                        columns: [0, 1, 2, 3, 4, 5, 6]
                                    },
                                    orientation: 'landscape',
                                    footer: true,
                                    pageSize: 'LEGAL'
                                }
                            ],
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
                    swal("Please Select all DropDown");
                }
            });



            $(document).ready(function() {
                $(".se-pre-con").hide();
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
                    let html_text = '<option value="all">All States</option>';
                    for (let key in data) {
                        html_text +=
                            `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                    }
                    $('#selectState').html(html_text);
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
                    var html_text1 = '<option class="all" value="all">All Divisions</option>';
                    for (var key in data) {
                        html_text1 += '<option value="' + data[key].division_token + '">' + data[key]
                            .division_name + '</option>';
                    }
                    division = html_text1;
                    $("#selectDivision").html(html_text1);
                });

            });

            //division and product
            $(document).on('change', '#selectDivision', function() {
                let divisionToken = $(this).val();
                let divisionobj = {
                    dashboard_code: verfication_code,
                    divisionToken: divisionToken,
                    type: 'divisionToken'
                }
                var json_data = JSON.stringify(divisionobj);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    let data = datas.data;
                    // console.log(datas);
                    let html_text = '<option value="all">All Products</option>';

                    data.forEach(function(item, index) {
                        html_text += `<option value="${item.token}">${item.name}</option>`;
                    });
                    $("#selectProduct").html(html_text);
                });
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
                    let data = datas.data;
                    let html_text = '<option value="all">All Regions</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].token}">${data[key].region_name}</option>`;
                    }
                    $('#selectRegion').html(html_text);
                });
            });
        </script>
    </body>

    </html>
<?php
}
?>