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
        <title>Power Soap | Report Dashboard</title>
        <link rel="shortcut icon" href="assets/favicon.ico">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <!--    <link rel="stylesheet" href="css/banner.css<?php echo $js_cache_string; ?>">-->
        <link rel="stylesheet" href="css/report_dashboard.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <!----------------js link chart--------------------->
        <style>
            
        </style>
    </head>

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
                <div class="my-dashboard">
                    <div class="four-card-box">
                        <div class="order-card">
                            <div class="order-card-left">
                                <img src="assets/icons/total_ordeers_icon.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p data-i18n="total_order">Total Order</p>
                                <h1 id="order_count"></h1>
                            </div>
                        </div>
                        <div class="employee-card">
                            <div class="order-card-left">
                                <img src="assets/icons/employees_icon.svg" alt="">
                            </div>
                            <div class="order-card-right">
                                <p data-i18n="employees">Employees</p>
                                <h1 id="employees_count"></h1>
                            </div>
                        </div>
                        <div class="Total-Outstanding">
                            <div class="order-card-left">
                                <img src="assets/icons/total_outstanding_icon.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p data-i18n="total_outstanding">Total Outstanding</p>
                                <h1 id="outstanding_count"></h1>
                            </div>
                        </div>
                        <div class="total-retailer">
                            <div class="order-card-left">
                                <img src="assets/icons/shop.svg" alt="order-icon ">
                            </div>
                            <div class="order-card-right">
                                <p data-i18n="total_retailer">Total Retailer</p>
                                <h1 id="retailer_count"></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-year">
                    <div class="sale-pie-chart">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3 data-i18n="top_sale_by_unit"> Top Sale by Unit</h3>
                            </div>
                        </div>
                        <canvas id="piechart" style="height:300px;width: 600px;"></canvas>
                    </div>
                    <div class="top-sell-product">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3 data-i18n="top_selling_shop"> Top Selling Shop</h3>
                            </div>
                            <div class="sale-head-right">
                                <form class="formdield">
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="fromDateFromSale" type="text" onchange="date_Filter_Shop()" placeholder="From Date" readonly data-i18n-placeholder="from_date">
                                    </div>
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="toDateFromSale" type="text" onchange="date_Filter_Shop()" placeholder="To Date" readonly data-i18n-placeholder="to_date">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th data-i18n="sl_no">Sl no</th>
                                        <th data-i18n="shop_name">Shop Name</th>
                                        <th data-i18n="total_sale">Total Sale</th>

                                    </tr>
                                </thead>
                                <tbody id="shop_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="sale-category">
                    <div class="sale-bar-chart">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3 data-i18n="sale_by_category">Sale by Category</h3>
                            </div>
                        </div>
                        <canvas id="barChart" style="width:100%;"></canvas>
                    </div>
                </div>
                <div class="top_sell_additional_box">
                    <div class="top_additonal_right_set">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3 data-i18n="top_selling_product"> Top Selling Product</h3>
                            </div>
                            <div class="sale-head-right">
                                <form class="formdield">
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="fromDateTopSell" onchange="date_filter_Top_Sell()" type="text" placeholder="From Date" readonly data-i18n-placeholder="from_date">
                                    </div>
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="toDateTopSell" onchange="date_filter_Top_Sell()" type="text" placeholder="To Date" readonly data-i18n-placeholder="to_date">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th data-i18n="sl_no">Sl no</th>
                                        <th data-i18n="product_name">Product Name</th>
                                        <th data-i18n="total_sale">Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="top_prodt_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="top_additonal_left_set">
                        <div class="sale-head">
                            <div class="sale-head-left">
                                <h3 data-i18n="products_to_be_reviewed">Products to be Reviewed</h3>
                            </div>
                            <div class="sale-head-right">
                                <form class="formdield">
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="fromDateBotSell" onchange="date_filter_Bot_Sell()" type="text" placeholder="From Date" readonly data-i18n-placeholder="from_date">
                                    </div>
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="toDateBotSell" onchange="date_filter_Bot_Sell()" type="text" placeholder="To Date" readonly data-i18n-placeholder="to_date">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="custom-table">
                                <thead>
                                    <tr>
                                        <th data-i18n="sl_no">Sl no</th>
                                        <th data-i18n="product_name">Product Name</th>
                                        <th data-i18n="total_sale">Total Sale</th>
                                    </tr>
                                </thead>
                                <tbody id="bottom_prodt_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        </script>
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
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            $(document).ready(function() {
                $('#fromDateFromSale').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });
                $('#toDateFromSale').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });

                $('#fromDateTopSell').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });
                $('#toDateTopSell').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });


                $('#fromDateBotSell').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });
                $('#toDateBotSell').datepicker({
                    autoclose: true,
                    todayHighlight: true,
                });

            });

            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";

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

            $(document).ready(function(){
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "all"
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path+"/distributor/report.php",
                data : json_data,
                }).done(function(data){
                    console.log(data);
                    var boxData = data.box_Data;
                    $("#order_count").text(boxData.order_count);
                    $("#employees_count").text(boxData.employees_count);
                    $("#outstanding_count").text(boxData.Outstanding_amt);
                    $("#retailer_count").text(boxData.shop_count);
                    //Pie Chart
                    var xValues = data.unit_names;
                    var yValues = data.unit_sales;
                    var barColors = data.random_color;
                    new Chart("piechart", {
                        type: "doughnut",
                        height: 380,
                        Width: 50,
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues,
                            }]
                        },
                        options: {
                            title: {
                                text: getGlobalTranslation("top_sale_by_unit")
                            }
                        }
                    });

                    var shopData = data.shop_Data;
                    //console.log(shopData);
                    var shno = 0;
                    var shop_html = '';
                    if (shopData.length > 0) {
                        for (var key in shopData) {
                            shno++;
                            shop_html += '<tr>';
                            shop_html += '<td>' + shno + '</td>';
                            shop_html += '<td>' + shopData[key].shop_name + '</td>';
                            shop_html += '<td>' + shopData[key].billing_amt + '</td>';
                            shop_html += '</tr>';
                        }
                    } else {
                        shop_html += '<tr>';
                        shop_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                        shop_html += '</tr>';
                    }
                    $("#shop_body").html(shop_html);

                    var topProdtData = data.top_product_Data;
                    //console.log(topProdtData);
                    var prtno = 0;
                    var top_html = '';
                    if (topProdtData.length > 0) {
                        for (var key in topProdtData) {
                            prtno++;
                            top_html += '<tr>';
                            top_html += '<td>' + prtno + '</td>';
                            top_html += '<td>' + topProdtData[key].top_product_name + '</td>';
                            top_html += '<td>' + topProdtData[key].top_productSellingCost + '</td>';
                            top_html += '</tr>';
                        }
                    } else {
                        top_html += '<tr>';
                        top_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                        top_html += '</tr>';
                    }
                    $("#top_prodt_body").html(top_html);

                    var bottomProdtData = data.bottom_product_Data;
                    var prbno = 0;
                    var bottom_html = '';
                    if (bottomProdtData.length > 0) {
                        for (var key in bottomProdtData) {
                            prbno++;
                            bottom_html += '<tr>';
                            bottom_html += '<td>' + prbno + '</td>';
                            bottom_html += '<td>' + bottomProdtData[key].bottom_product_name + '</td>';
                            bottom_html += '<td>' + bottomProdtData[key].bottom_productSellingCost + '</td>';
                            bottom_html += '</tr>';
                        }
                    } else {
                        bottom_html += '<tr>';
                        bottom_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                        bottom_html += '</tr>';
                    }
                    $("#bottom_prodt_body").html(bottom_html);

                    //Bar Chart
                    var rancolor;
                    var Category_types = data.Category_array;
                   // console.log(Category_types);
                    var cate_arr = [];
                    var DEFAULT_DATASET_SIZE = 7,
                        addedCount = 0,
                        color = Chart.helpers.color;

                    for (let i in Category_types) {
                        rancolor = getRandomColor();
                        let xyz = {
                            label: Category_types[i].catName,
                            backgroundColor: rancolor,
                            borderColor: "#000000",
                            borderWidth: 1,
                            data: Category_types[i].CategorySales
                        };

                        cate_arr.push(xyz);
                    }

                    var barData = {
                        labels: data.Category_month,
                        datasets: cate_arr

                    };
                    var chartLength = data.Category_month;
                    if (chartLength.length > 0) {

                        var index = 11;
                        var ctx = document.getElementById("barChart").getContext("2d");
                        var myNewChartB = new Chart(ctx, {
                            type: 'bar',
                            data: barData,
                            options: {
                                responsive: true,
                                maintainAspectRation: true,
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    text: getGlobalTranslation("sale_by_category")
                                }
                            }
                        });
                    }
                    $(".se-pre-con").hide();
                });
            });

            function date_Filter_Shop() {
                var from_date = $("#fromDateFromSale").val();
                var to_date = $("#toDateFromSale").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDateFromSale").val(from_date);
                }
                var to_date = $("#toDateFromSale").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    $(".se-pre-con").fadeIn();
                    var datas = {
                        dashboard_code: verfication_code,
                        distributor_token: distributor_token,
                        from_date: from_date,
                        to_date: to_date,
                        type: "date_range_shop"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/report.php",
                        data: json_data
                    }).done(function(data) {
                        $('#shop_body').empty();
                        var shopData = data.shop_Data;
                        var shno = 0;
                        var shop_html = '';
                        if (data.code == 201) {
                            for (var key in shopData) {
                                shno++;
                                shop_html += '<tr>';
                                shop_html += '<td>' + shno + '</td>';
                                shop_html += '<td>' + shopData[key].shop_name + '</td>';
                                shop_html += '<td>' + shopData[key].billing_amt + '</td>';
                                shop_html += '</tr>';
                            }
                        } else {
                            shop_html += '<tr>';
                            shop_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                            shop_html += '</tr>';
                        }
                        $(".se-pre-con").fadeOut();
                        $("#shop_body").html(shop_html);
                    });
                }
            }

            function date_filter_Top_Sell() {
                var from_date = $("#fromDateTopSell").val();
                var to_date = $("#toDateTopSell").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDateTopSell").val(from_date);
                }
                var to_date = $("#toDateTopSell").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    $(".se-pre-con").fadeIn();
                    var datas = {
                        dashboard_code: verfication_code,
                        distributor_token: distributor_token,
                        from_date: from_date,
                        to_date: to_date,
                        type: "date_range_top_sell"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/report.php",
                        data: json_data
                    }).done(function(data) {
                        $('#top_prodt_body').empty();
                        var topProdtData = data.top_product_Data;
                        var prtno = 0;
                        var top_html = '';
                        if (data.code == 201) {
                            for (var key in topProdtData) {
                                prtno++;
                                top_html += '<tr>';
                                top_html += '<td>' + prtno + '</td>';
                                top_html += '<td>' + topProdtData[key].top_product_name + '</td>';
                                top_html += '<td>' + topProdtData[key].top_productSellingCost + '</td>';
                                top_html += '</tr>';
                            }
                        } else {
                            top_html += '<tr>';
                            top_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                            top_html += '</tr>';
                        }
                        $(".se-pre-con").fadeOut();
                        $("#top_prodt_body").html(top_html);
                    });
                }
            }

            function date_filter_Bot_Sell() {
                var from_date = $("#fromDateBotSell").val();
                var to_date = $("#toDateBotSell").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDateBotSell").val(from_date);
                }
                var to_date = $("#toDateBotSell").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    $(".se-pre-con").fadeIn();
                    var datas = {
                        dashboard_code: verfication_code,
                        distributor_token: distributor_token,
                        from_date: from_date,
                        to_date: to_date,
                        type: "date_range_bot_sell"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/report.php",
                        data: json_data
                    }).done(function(data) {
                        $('#bottom_prodt_body').empty();
                        var bottomProdtData = data.bottom_product_Data;
                        var prbno = 0;
                        var bottom_html = '';
                        if (data.code == 201) {
                            for (var key in bottomProdtData) {
                                prbno++;
                                bottom_html += '<tr>';
                                bottom_html += '<td>' + prbno + '</td>';
                                bottom_html += '<td>' + bottomProdtData[key].bottom_product_name + '</td>';
                                bottom_html += '<td>' + bottomProdtData[key].bottom_productSellingCost + '</td>';
                                bottom_html += '</tr>';
                            }
                        } else {
                            bottom_html += '<tr>';
                            bottom_html += '<td colspan="3" style="text-align: center;" data-i18n="no_records_found">' + getGlobalTranslation("no_records_found") + '</td>';
                            bottom_html += '</tr>';
                        }
                        $(".se-pre-con").fadeOut();
                        $("#bottom_prodt_body").html(bottom_html);
                    });
                }
            }

            function getRandomColor() {
                var letters = '0123456789ABCDEF';
                var color = '#';
                for (var i = 0; i < 6; i++) {
                    color += letters[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        </script>
    </body>

    </html>
<?php
}
?>