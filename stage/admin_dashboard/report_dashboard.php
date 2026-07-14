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
        <title>Power Soap | Report Dashboard</title>
        <link rel="shortcut icon" href="assets/favicon.ico">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <!--    <link rel="stylesheet" href="css/banner.css<?php echo $js_cache_string; ?>">-->
        <link rel="stylesheet" href="css/report_dashboard.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    </head>
    <style>
        .field_data {
            margin-right: 0.5rem;
        }

        .table-box {
            max-height: 550px;
            overflow: auto;
        }

        .custom-table thead {
            position: sticky;
            top: -2px;
        }

        .custom-table thead tr th {
            white-space: nowrap;
        }


        .table-box::-webkit-scrollbar {
            display: block;
            background-color: #000;
            height: 2px;
            border-radius: 10px;
            width: 8px;

        }

        .table-box::-webkit-scrollbar-thumb {
            background-color: #232a77;
            border-radius: 10px;


        }

        .table-box::-webkit-scrollbar-track {
            background-color: #cacaca;
            border-radius: 10px;
        }

        .datePickText {
            opacity: 1;
            color: rgba(0, 0, 0, 1);
            font-family: var(--regular-font);
            font-size: 18px;
            font-weight: 400;
            font-style: normal;
            letter-spacing: -0.78px;
            text-align: left;
            border: none;
            width: 100px;
            height: 30px;
        }

        .yearpass {
            width: 150px;
            background: #fff;
            color: #262d7a;
            border-radius: 2px;
            border: 1px solid #ebebeb;
            background-color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            outline: none;
            float: right;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 1rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 0.25rem;
        }

        .local-loader {
            width: 100%;
            min-height: 100px;
            background: url(assets/load.gif) center no-repeat;
            background-size: 50px;
        }

        .se-pre-con {
            display: none !important;
        }
    </style>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <div class="se-pre-con"></div>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar12"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="full-height">
                <div class="global-filter-container container-fluid mt-3 mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <!-- <label for="global_date_range" class="font-weight-bold" style="color: #232a77;">Select Period:</label> -->
                            <select id="global_date_range" class="form-control" style="border: 1px solid #232a77; font-weight: 600;margin-top: 10px;">
                                <option value="all">All</option>
                                <option value="last_90">Last 90 days</option>
                                <option value="last_30">Last 30 days</option>
                                <option value="last_7">Last 7 days</option>
                                <option value="this_month" selected>This month</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div id="custom_date_inputs" class="col-md-6" style="display:none;">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="font-weight-bold" style="color: #232a77;">From:</label>
                                    <input type="text" id="global_from_date" class="form-control date_picker" placeholder="YYYY-MM-DD" readonly>
                                </div>
                                <div class="col-md-5">
                                    <label class="font-weight-bold" style="color: #232a77;">To:</label>
                                    <input type="text" id="global_to_date" class="form-control date_picker" placeholder="YYYY-MM-DD" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-dashboard">
                    <div class="four-card-box">
                        <div class="order-card">
                            <div class="order-card-left">
                                <img src="assets/icons/total_ordeers_icon.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p>Total Order</p>
                                <h1 id="order_count"><img src="assets/load.gif" style="height:30px"></h1>
                            </div>
                        </div>
                        <div class="employee-card">
                            <div class="order-card-left">
                                <img src="assets/icons/employees_icon.svg" alt="">
                            </div>
                            <div class="order-card-right">
                                <p>Distributor Employees</p>
                                <h1 id="employees_count"><img src="assets/load.gif" style="height:30px"></h1>
                            </div>
                        </div>
                        <div class="Total-Outstanding">
                            <div class="order-card-left">
                                <img src="assets/icons/total_outstanding_icon.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p>Total Distributors</p>
                                <h1 id="outstanding_count"><img src="assets/load.gif" style="height:30px"></h1>
                            </div>

                        </div>
                        <div class="total-retailer">
                            <div class="order-card-left">
                                <img src="assets/icons/shop.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p>Total Retailer</p>
                                <h1 id="retailer_count"><img src="assets/load.gif" style="height:30px"></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-year">
                    <div class="sale-pie-chart">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3> Top Sales by Unit</h3>
                            </div>
                        </div>
                        <div id="pie_loader" class="local-loader"></div>
                        <canvas id="piechart" style="height:100px;width:100px; display:none;"></canvas>
                    </div>
                    <div class="top-sell-product">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3> Top Sales by Distributor</h3>
                            </div>
                            <div class="sale-head-right">
                                <!-- Date filters removed here, moved to global filter -->
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Sl no</th>
                                        <th>Distributor Name</th>
                                        <th>Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="distributor_body">
                                    <tr><td colspan="3"><div class="local-loader"></div></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="sale-category">
                    <div class="sale-bar-chart">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3>Sale by Category</h3>
                            </div>
                        </div>
                        <div id="bar_loader" class="local-loader"></div>
                        <canvas id="barChart" style="width:100%; display:none;"></canvas>
                    </div>
                </div>
                <div class="top_sell_additional_box">
                    <div class="top_additonal_right_set">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3> Top Selling Product</h3>
                            </div>
                            <div class="sale-head-right">
                                <!-- Date filters removed here, moved to global filter -->
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Sl no</th>
                                        <th>Name</th>
                                        <th>Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="top_prodt_body">
                                    <tr><td colspan="3"><div class="local-loader"></div></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="top_additonal_left_set">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3>Product to be Reviewed</h3>
                            </div>
                            <div class="sale-head-right">
                                <!-- Date filters removed here, moved to global filter -->
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th>Sl no</th>
                                        <th>Name</th>
                                        <th>Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="bottom_prodt_body">
                                    <tr><td colspan="3"><div class="local-loader"></div></td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        </script>
        <!----------------js link chart--------------------->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> -->
        <script src="js/jquery-3.6.0.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://code.highcharts.com/highcharts.src.js"></script> -->
        <script src="js/highcharts.src.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script> -->
        <script src="js/Chart.min.js<?php echo $js_cache_string; ?>"></script>

        <!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> -->
        <script src="js/Chart.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script> -->
        <script src="js/Chart.bundle.js<?php echo $js_cache_string; ?>"></script>

        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
<script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";

            function getDates(type) {
                let fromDate = "";
                let toDate = new Date().toISOString().split('T')[0];
                let d = new Date();
                
                switch(type) {
                    case 'all':
                        fromDate = "";
                        toDate = "";
                        break;
                    case 'last_7':
                        d.setDate(d.getDate() - 7);
                        fromDate = d.toISOString().split('T')[0];
                        break;
                    case 'last_30':
                        d.setDate(d.getDate() - 30);
                        fromDate = d.toISOString().split('T')[0];
                        break;
                    case 'last_90':
                        d.setDate(d.getDate() - 90);
                        fromDate = d.toISOString().split('T')[0];
                        break;
                    case 'this_month':
                        fromDate = new Date(d.getFullYear(), d.getMonth(), 1).toISOString().split('T')[0];
                        break;
                    case 'custom':
                        fromDate = $("#global_from_date").val();
                        toDate = $("#global_to_date").val();
                        break;
                }
                return { from: fromDate, to: toDate };
            }

            function loadDashboard() {
                var filterType = $("#global_date_range").val();
                var dates = getDates(filterType);
                
                if (filterType == 'custom' && (!dates.from || !dates.to)) {
                    return;
                }

                var requestData = { 
                    dashboard_code: verfication_code, 
                    from_date: dates.from, 
                    to_date: dates.to 
                };

                $("#order_count, #employees_count, #outstanding_count, #retailer_count").html('<img src="assets/load.gif" style="height:30px">');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/reportAndAnalytics.php",
                    data: JSON.stringify($.extend({}, requestData, { type: "box_data" })),
                }).done(function(data) {
                    var boxData = data.box_Data;
                    $("#order_count").text(boxData.order_count);
                    $("#employees_count").text(boxData.employees_count);
                    $("#outstanding_count").text(boxData.Outstanding_amt);
                    $("#retailer_count").text(boxData.shop_count);
                });

                $("#pie_loader").show();
                $("#piechart").hide();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/reportAndAnalytics.php",
                    data: JSON.stringify($.extend({}, requestData, { type: "pie_chart" })),
                }).done(function(data) {
                    $("#pie_loader").hide();
                    if (data.unit_names && data.unit_names.length > 0) {
                        $("#piechart").show();
                        var ctx = document.getElementById("piechart");
                        if (window.myPieChart) { window.myPieChart.destroy(); }
                        
                        window.myPieChart = new Chart(ctx, {
                            type: "doughnut",
                            data: {
                                labels: data.unit_names,
                                datasets: [{
                                    backgroundColor: data.random_color,
                                    data: data.unit_sales,
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: { display: false },
                                title: { display: true, text: "Top Sale by Unit" }
                            }
                        });
                    }
                });

                $("#distributor_body").html('<tr><td colspan="3"><div class="local-loader"></div></td></tr>');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/reportAndAnalytics.php",
                    data: JSON.stringify($.extend({}, requestData, { type: "top_distributor" })),
                }).done(function(data) {
                    var distData = data.dist_Data;
                    var shno = 0;
                    var dist_html = '';
                    if (distData && distData.length > 0) {
                        for (var key in distData) {
                            shno++;
                            dist_html += '<tr><td>' + shno + '</td><td>' + distData[key].distributor_name + '</td><td>' + distData[key].distributor_sales + '</td></tr>';
                        }
                    } else {
                        dist_html += '<tr><td colspan="3" style="text-align: center;">No Records Found</td></tr>';
                    }
                    $("#distributor_body").html(dist_html);
                });

                $("#top_prodt_body").html('<tr><td colspan="3"><div class="local-loader"></div></td></tr>');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/reportAndAnalytics.php",
                    data: JSON.stringify($.extend({}, requestData, { type: "top_selling" })),
                }).done(function(data) {
                    var topProdtData = data.top_product_Data;
                    var prtno = 0;
                    var top_html = '';
                    if (topProdtData && topProdtData.length > 0) {
                        for (var key in topProdtData) {
                            prtno++;
                            top_html += '<tr><td>' + prtno + '</td><td>' + topProdtData[key].top_product_name + '</td><td>' + topProdtData[key].top_productSellingCost + '</td></tr>';
                        }
                    } else {
                        top_html += '<tr><td colspan="3" style="text-align: center;">No Records Found</td></tr>';
                    }
                    $("#top_prodt_body").html(top_html);
                });

                $("#bottom_prodt_body").html('<tr><td colspan="3"><div class="local-loader"></div></td></tr>');
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/reportAndAnalytics.php",
                    data: JSON.stringify($.extend({}, requestData, { type: "bot_selling" })),
                }).done(function(data) {
                    var bottomProdtData = data.bottom_product_Data;
                    var prbno = 0;
                    var bottom_html = '';
                    if (bottomProdtData && bottomProdtData.length > 0) {
                        for (var key in bottomProdtData) {
                            prbno++;
                            bottom_html += '<tr><td>' + prbno + '</td><td>' + bottomProdtData[key].bottom_product_name + '</td><td>' + bottomProdtData[key].bottom_productSellingCost + '</td></tr>';
                        }
                    } else {
                        bottom_html += '<tr><td colspan="3" style="text-align: center;">No Records Found</td></tr>';
                    }
                    $("#bottom_prodt_body").html(bottom_html);
                });
            }

            function loadBarChart(year) {
                $("#barChart").hide();
                $("#bar_loader").show();
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: JSON.stringify({ year: year }),
                    url: api_path + "/admin/bar_graph.php",
                }).done(function(data) {
                    $("#bar_loader").hide();
                    var barData = data.category_array;
                    if (!barData || barData.length === 0) {
                        $("#barChart").show();
                        let ctx = document.getElementById('barChart').getContext('2d');
                        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                        ctx.textAlign = 'center';
                        ctx.fillText('No data to display', ctx.canvas.width / 2, ctx.canvas.height / 2);
                        return;
                    }

                    var cate_arr = [];
                    for (let i in barData) {
                        cate_arr.push({
                            label: barData[i].catName,
                            backgroundColor: getRandomColor(),
                            borderColor: "#000000",
                            borderWidth: 1,
                            data: barData[i].CategorySales
                        });
                    }

                    $("#barChart").show();
                    var ctx = document.getElementById("barChart");
                    if (window.myBarChart) { window.myBarChart.destroy(); }

                    window.myBarChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: data.Category_month,
                            datasets: cate_arr
                        },
                        options: {
                            responsive: true,
                            legend: { position: 'bottom' },
                            title: { display: true, text: 'Group Product Sales Chart' }
                        }
                    });
                });
            }

            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }

            $(document).ready(function() {
                // Initialize Datepickers
                $('.date_picker').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                    endDate: "today",
                    format: "yyyy-mm-dd"
                }).on('changeDate', function() {
                    loadDashboard();
                });


                // Global Filter Change
                $("#global_date_range").on('change', function() {
                    if ($(this).val() == 'custom') {
                        $("#custom_date_inputs").show();
                    } else {
                        $("#custom_date_inputs").hide();
                        loadDashboard();
                    }
                });

                // Initial Load
                loadDashboard();
                loadBarChart(new Date().getFullYear());

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
            });
        </script>
    </body>
    </html>
<?php } ?>