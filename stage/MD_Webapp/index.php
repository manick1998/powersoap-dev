<?php
include "config.php";
if ($cookie_admin_name == "") {
    header("Location:login.php");
} else {
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Power Soap | Report Dashboard</title>
        <link rel="shortcut icon" href="img/favi.png" />

        <!-- bootstrap css  -->
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
        <link
            rel="stylesheet"
            href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"
        />
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/custom-table.css" />
        <link rel="stylesheet" href="css/header.css" />
        <link rel="stylesheet" href="css/report.css" />
        <link rel="stylesheet" href="css/mediaquery.css" />

        <style>
            .contain_width {
                width: 95%;
                margin: 0 auto;
            }
            .table-box::-webkit-scrollbar-thumb {
                background-color: #d30277 !important;
                border-radius: 10px;
            }
            .sidenav {
                background-color: #262d7a;
            }
            .sidenav a {
                color: var(--sidemenu-bg);
                white-space: nowrap;
            }
            .order-year,
            .top_sell_additional_box {
                /* padding-top: 27px; */
            }
            .ui-datepicker-calendar {
                display: none;
            }
                span#yearly {
        font-size: 35px;
    }
    span#monthly {
        font-size: 35px;
    }
            </style>
    </head>
    <body>
        <header id="main-dash-header" class="dash-header">
            <div class="head-logo">
                <span style="font-size: 30px; cursor: pointer; color: #fff" id="opentag" onclick="openNav()">&#9776; </span><a href="javascript:void(0)"><img class="logo" src="assets/logo.png" alt="logo" /></a>
            </div>
            <div class="back-drop hidden"></div>
            <div class="nav-menu">
                <ul class="nav-links">
                    <li>
                        <!-- <select class="form-control yearpass" id="select_box">
                            <option>Month/year</option>
                            <option value="a">Jan 2022</option>
                            <option value="b">Feb 2022</option>
                            <option value="c">Mar 2022</option>
                            <option value="d">Apr 2022</option>
                            <option value="e">May 2022</option>
                            <option value="f">Jun 2022</option>
                            <option value="g">Jul 2022</option>
                            <option value="h">Aug 2022</option>
                            <option value="i">Sep 2022</option>
                            <option value="j">Oct 2022</option>
                            <option value="k">Num 2022</option>
                            <option value="l">Dec 2022</option>
                        </select> -->
                        <!-- <div class="form-control yearHead">
                            <label for="datepicker">
                                <input
                                    class="datePickHead"
                                    type="text"
                                    id="datepicker"
                                    placeholder="Pick a Date"
                                    autocomplete="off"
                                />
                            </label>
                        </div> -->
                    </li>
                </ul>
            </div>
        </header>
        <div class="display_cls">
            <div id="mySidenav" class="sidenav">
                <a href="javascript:void(0)" class="closebtn" id="closetag" onclick="closeNav()">&times;</a>
                <a class="smoothscroll" href="#top_selling">Selling Product</a>
                <a class="smoothscroll" href="#top_distributor">Distributor</a>
                <a class="smoothscroll" href="#distributor_review">Distributor Reviewed</a>
                <a class="smoothscroll" href="#retailer_review">Retailers Reviewed</a>
                <a href="login.php">LogOut</a>
            </div>
            <!-- main-contents -->
            <main class="main-contents">
                <section class="full-height">
                    <div class="my-dashboard">
                        <div class="four-card-box">
                            <div class="order-card orderCard">
                                <p>Total Distributors Orders</p>
                                <div class="splitData">
                                    <div class="order-card-left">
                                        <img src="img/total_orders_icon.svg" alt="order-icon " class="dmImg" />
                                    </div>
                                    <div class="order-card-right">
                                        <h1>
                                            <span id="totalOrder" class="counter" data-duration="5000"></span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="employee-card orderCard">
                                <p>Total Distributors</p>
                                <div class="splitData">
                                    <div class="order-card-left">
                                        <img src="img/employees_icon.svg" alt="" class="dmImg" />
                                    </div>
                                    <div class="order-card-right">
                                        <h1>
                                            <span id="totalDistributor" class="counter" data-duration="5000">0</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="Total-Outstanding orderCard">
                                <p>Total Sales Agents</p>
                                <div class="splitData">
                                    <div class="order-card-left">
                                        <img src="img/total_outstanding_icon.svg" alt="order-icon " class="dmImg" />
                                    </div>
                                    <div class="order-card-right">
                                        <h1>
                                            <span id="totalSalesrep" class="counter" data-duration="5000">0</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            <div class="total-retailer orderCard">
                                <p>Total Retailers</p>
                                <div class="splitData">
                                    <div class="order-card-left">
                                        <img src="img/shop.svg" alt="order-icon " class="dmImg" />
                                    </div>
                                    <div class="order-card-right">
                                        <h1>
                                            <span id="totalRetailer" class="counter" data-duration="5000">0</span>
                                        </h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- sale-category -->
                    <!-- sale-bar-chart -->
                    <div class="top_sell_additional_box">
                        <div class="top_additonal_right_chart">
                            <div class="sale-title backColor">
                                <div class="sale-color">
                                    <p>Total Income</p>
                                    <h3><span>₹</span> <span id="yearly" class="counter" data-duration="5000"></span></h3>
                                </div>
                                <div class="divider"></div>
                                <div class="sale-color">
                                    <p>Monthly Avg Income</p>
                                    <h3><span>₹</span> <span id="monthly" class="counter" data-duration="5000"></span></h3>
                                </div>
                            </div>
                            <canvas id="lineGraph" style="width: 300px"></canvas>
                            <!-- lineGraph -->
                        </div>
                        <div class="top_additonal_left_chart mobileViewHide">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Sale by Category</h3>
                                </div>
                                <div class="sale-head-right">
                                    <!-- <select class="divisionBox" id="division">
                                    </select> -->
                                    <div class="form-control yearpass">
                                        <label for="datepicker1">
                                            <input class="datePickText" type="text" id="datepicker1" placeholder="year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center">
                                <canvas id="barChart" style="width: 300px; height: auto"></canvas>
                                <!-- barChart -->
                            </div>
                        </div>
                    </div>
                    <div class="order-year mobileViewHide">
                        <div class="sale-pie-chart">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Sales by Region</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="region_division">
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker10">
                                            <input class="datePickText" type="text" id="datepicker10" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <canvas id="myChart" width="500" height="350"></canvas>
                        </div>

                        <div class="top_additonal_left_set">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Top 10 Retailers</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="shop_state">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker11">
                                            <input class="datePickText"   type="text" id="datepicker11" placeholder="month/year"  autocomplete="off"/>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table" id="top_ten_shop">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Sale</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_shop_body">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4000</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="top_sell_additional_box" id="top_distributor">
                        <div class="top-sell-product" id="top_selling">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Top 10 Selling Product</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="selling_products_state">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    <select class="divisionBox" id="selling_products_region">
                                        <!-- <option>Select Region</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker12">
                                            <input class="datePickText" type="text" id="datepicker12" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Box</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_selling_product">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td></td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="top_additonal_right_set">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Top 10 Distributor</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="top_10_distributor">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker13">
                                            <input class="datePickText" type="text" id="datepicker13" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Sale</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_distributor">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="top_sell_additional_box" id="distributor_review">
                        <div class="top_additonal_left_set">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>10 Products To Be Reviewed</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="low_selling_product_state">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    <select class="divisionBox" id="low_selling_product_region">
                                        <!-- <option>Select Region</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker14">
                                            <input class="datePickText" type="text" id="datepicker14" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Box</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_products_review">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="top_additonal_right_set">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>10 Distributor To Be Reviewed</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="top_10_low_distributor">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker15">
                                            <input class="datePickText" type="text" id="datepicker15" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Sale</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_low_distributor">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="top_sell_additional_box" id="retailer_review">
                        <div class="top_additonal_right_set">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>10 Retailers To Be Reviewed</h3>
                                </div>
                                <div class="sale-head-right">
                                    <select class="divisionBox" id="low_state_id">
                                        <!-- <option>Select State</option>
                                        <option value="a">Division</option>
                                        <option value="b">Division</option>
                                        <option value="c">Division</option>
                                        <option value="d">Division</option> -->
                                    </select>
                                    </select>
                                    <div class="form-control yearpass">
                                        <label for="datepicker16">
                                            <input class="datePickText" type="text" id="datepicker16" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="table-box">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>SI.no</th>
                                            <th>Name</th>
                                            <th>Total Sale</th>
                                        </tr>
                                    </thead>
                                    <tbody id="top_ten_low_retailer">
                                        <!-- <tr>
                                            <td>1</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Active Power Freez soap 1kg</td>
                                            <td>4,863</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="sale-pie-chart">
                            <div class="sale-head">
                                <div class="sale-head-left">
                                    <h3>Top Sales By Area</h3>
                                </div>
                                <div class="sale-head-right">
                                    <div class="form-control yearpass">
                                        <label for="datepicker2">
                                            <input class="datePickText" type="text" id="datepicker2" placeholder="month/year" autocomplete="off" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div style="max-width:400px;margin:0 auto;padding:20px;text-align: center;">
                                <canvas id="piechart" height="100" width="100"></canvas>
                            </div>
                        </div>
                        <!--  -->
                    </div>
                </section>
            </main>
        </div>
        <!----------------js link chart--------------------->
        <script src="js/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.src.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js"></script>
        <script src="https://netdna.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
        <script>
            var api_path = "<?php echo $api_path; ?>";
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            console.log(gl_admin_name);
            function openNav() {
                $("#mySidenav").width(300);
            }
            function closeNav() {
                $("#mySidenav").width(0);
            }
            $(".display_cls").click(function () {
                closeNav();
            });
           
            $(".counter").each(function () {
                var $this = $(this),
                    countTo = $this.attr("data-countto");
                var countDuration = parseInt($this.attr("data-duration"));
                $({
                    counter: $this.text(),
                }).animate(
                    {
                        counter: countTo,
                    },
                    {
                        duration: countDuration,
                        easing: "linear",
                        step: function () {
                            $this.text(formatCounterValue(this.counter));
                        },
                        complete: function () {
                            $this.text(formatCounterValue(this.counter));
                        },
                    }
                );
            });

            function formatCounterValue(value) {
                if (value >= 1000000) {
                    return (value / 1000000).toFixed(1) + "M";
                } else {
                    return Math.floor(value)
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
            }

            $(function () {
                $("#datepicker").datepicker({
                    dateFormat: "mm-yy",
                    duration: "fast",
                    changeMonth: true,
                    changeYear: true,
                });
                $("#datepicker1").datepicker({
                    format: "yyyy",
                    viewMode: "years", 
                    minViewMode: "years"
                });
                $("#datepicker2").datepicker({
                    format: "yyyy-mm",
                    startView: "months", 
                    minViewMode: "months"
                });
                $("#datepicker10,#datepicker11").datepicker({
                    format: "yyyy-mm",
                    startView: "months",
                    minViewMode: "months",
                });
                $("#datepicker12,#datepicker13").datepicker({
                    format: "yyyy-mm",
                    startView: "months",
                    minViewMode: "months"
                });
                $("#datepicker14,#datepicker15").datepicker({
                    format: "yyyy-mm",
                    startView: "months",
                    minViewMode: "months"
                });
                $("#datepicker16").datepicker({
                    format: "yyyy-mm",
                    startView: "months",
                    minViewMode: "months"
                });
                $("#datepicker3").datepicker({
                    format: "mm-yyyy",
                    startView: "months", 
                    minViewMode: "months"
                 });
            });

            $(".smoothscroll").on("click", function (e) {
                e.preventDefault();
                var target = this.hash,
                    $target = $(target);
                $("html, body")
                    .stop()
                    .animate(
                        {
                            scrollTop: $target.offset().top,
                        },
                        800,
                        "swing",
                        function () {
                            window.location.hash = target;
                        }
                    );
            });
            $(document).ready(function () {
                var pTabItem = $(".prodNav .ptItem");
                $(pTabItem).click(function () {
                    // Tab nav active functionality
                    $(pTabItem).removeClass("active");
                    $(this).addClass("active");

                    // Tab container active functionality
                    var tabid = $(this).attr("id");
                    $(".prodMain").removeClass("active");
                    $("#" + tabid + "C").addClass("active");
                    return false;
                });
                $.ajax({
                          type: "POST",
                          dataType: "json",
                          url: api_path + "/divisionList.php",
                    }).done(function(data) {
                        // console.log(data);
                            var html='<option>Select Division</option>';
                            data.division_data.forEach(function(item,index){
                            html += `<option value="${item.token}">${item.name}</option>`
                        });

                            $('#division').html(html);   
                     });
                });

            /* Radion button box */
            $(".ratio-btn-selecter").on("click", function () {
                debugger;
                var quickcheck = $(this).attr("data-value");
                if (quickcheck == "image") {
                    $('input[name=radio_btn_option][value="image"]').attr(
                        "checked",
                        "checked"
                    );
                    $(".popup-image-box").removeClass("hidden");
                    $(".popup-video-box").addClass("hidden");
                } else {
                    $('input[name=radio_btn_option][value="video"]').attr(
                        "checked",
                        "checked"
                    );
                    $(".popup-image-box ").addClass("hidden");
                    $(".popup-video-box").removeClass("hidden");
                }
            });

   

            const colors = {
                purple: {
                    default: "rgba(27, 185, 120, 1)",
                    half: "rgba(27, 185, 120, 0.5)",
                    quarter: "rgba(27, 185, 120, 0.25)",
                    zero: "rgba(27, 185, 120, 0)",
                },
                indigo: {
                    default: "rgba(27, 185, 120, 1)",
                    quarter: "rgba(27, 185, 120, 0.25)",
                },
            };
//line graph
      

            // /chart js

            // setup
            // region chart

            
            $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_region_dotchart.php",
                    }).done(function(data) {
                            console.log('hai this',data);
                            var html1='<option>Select State</option>';
                            data.state_data.forEach(function(item,index){
                                html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                            });
                            $('#region_division').html(html1);
                                var chart_arr =[];
                               var labs =[];
                                var months =  ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'];
                                var letters = '0123456789ABCDEF';
                                var color = '#';
                                for (var i = 0; i < 6; i++) {
                                    color += letters[Math.floor(Math.random() * 16)];
                                    }
                                  var chart_datas = '';
                                  val = true;
                                  //console.log('chart',);
                                  labs.push(data.data[0].monthName);
                            data.data.forEach(function(item,index){
                                
                                var letters = '0123456789ABCDEF';
                                var color = '#';
                                for (var i = 0; i < 6; i++) {
                                    color += letters[Math.floor(Math.random() * 16)];
                                    }
                                         chart_datas ={ 
                                            label:item.region_name,
                                            backgroundColor: color,
                                            borderColor: color,
                                            data:[item.bill_amount],
                                        }
                                        
                                    
                                

                                chart_arr.push(chart_datas);
                            });

                            



                            console.log('chart_arr',chart_arr);
                           // var months =  ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November','December'];
                           var barValue = {
                            labels : labs,
                                //labels: ['Jan', 'Feb', 'Mar', 'Apl', 'May', 'Jun','jul','Agu','Sep','Oct','Nov','Dec'],
                                datasets: chart_arr
                            };
                            var ctx = document.getElementById("myChart").getContext('2d');
                            var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: barValue,
                            options: {
                                responsive: true,
                                maintainAspectRation: true,
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Bar Chart'
                                },

                                scales: {
                                        xAxes: [{
                                                display: true,
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: 'Month'
                                                }
                                            }],
                                        yAxes: [{
                                                display: true,
                                                ticks: {
                                                    beginAtZero: true,
                                                    // stepSize: 2,
                                                    steps: 1000000,
                                                    stepValue: 5,
                                                    max: 1000000
                                                    
                                                }
                                            }]
                                    },
                            }
                            });
                    });


            


// -------------Bar Sales by Region End---------//

        $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/home_screen.php",
                }).done(function(data) {
            var boxData = data.dashboard_details;
            $("#totalOrder").text(boxData.order_taken_value);
            $("#totalDistributor").text(boxData.get_distributor);
            $("#totalSalesrep").text(boxData.get_salesDelivery);
            $("#totalRetailer").text(boxData.shop_count_value);
            $("#yearly").text(boxData.year_income);
            $("#monthly").text(boxData.month_income);
           const weight =boxData.month;
           const labels =boxData.Category_month;
           const ctx1 = document.getElementById("lineGraph").getContext("2d");
            ctx1.canvas.height = 190;
            const options ={
            type: "line",
               data :{
               labels : labels,
                datasets: [
                    {
                    label: 'overall income',
                            fill: true,
                            pointBackgroundColor: colors.purple.default,
                            borderColor: colors.purple.default,
                            data: weight,
                            lineTension: 0.1,
                            borderWidth: 2,
                            pointRadius: 3,
                },
            ],
                },
                options: {
                    layout: {
                        padding: 10,
                    },
                    responsive: true,
                    legend: {
                        display: true,
                    },

                    scales: {
                        xAxes: [
                            {
                                gridLines: {
                                    display: false,
                                },
                                ticks: {
                                    padding: 10,
                                    autoSkip: false,
                                    maxRotation: 15,
                                    minRotation: 15,
                                },
                            },
                        ],
                        yAxes: [
                            {
                                gridLineDashStyle: "longdash",
                                gridLines: {
                                    display: true,
                                    color: colors.indigo.quarter,
                                },
                                ticks: {
                                    display: true,
                                    beginAtZero: false,
                                    max:250000000,
                                    min: 10000000,
                                    padding: 10,
                                },
                            },
                        ],
                    },
                },
            }
           
                window.myLine = new Chart(ctx1, options);

        })
        });
        $(document).ready(function(){
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/bar_graph.php",
                }).done(function(data) {
        var barData = data.category_array;
        console.log(barData);
        var rancolor; 
        var cate_arr = [];
        var Category_types = barData;
        var DEFAULT_DATASET_SIZE = 7,
        addedCount = 0,
        color = Chart.helpers.color;
            for(let i in Category_types){
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
            var barValue = {
			labels: data.Category_month,
            datasets: cate_arr
        };
            var chart = data.Category_month;
            if(chart.length > 0){
            var index = 11;
            var ctx = document.getElementById('barChart');

            var existingBarChart = Chart.getChart("barChart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
            console.log("A1");
		    var	myNewChartB = new Chart(ctx, {
				type: 'bar',
				data: barValue,
				options: {
					responsive: true,
          maintainAspectRation: false,
					legend: {
						position: 'bottom',
					},
					title: {
						display: true,
						text: 'Group Product Sales Chart'
					}
				}
			});
            }else{
                var ctx = document.getElementById('barChart');
        var context = ctx.getContext('2d')

            var existingBarChart = Chart.getChart("barChart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
       var width = ctx.width;
      var height = ctx.height;
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.font = "16px normal 'Helvetica Nueue'";
      context.fillText('No data to display', width, height);
        } 
        })
    });
         //Bar Chart
         $("#datepicker1").on("change", function(){
            var year = $("#datepicker1").val();
            var datas = {
                year :year
            };
        var json_data = JSON.stringify(datas);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: json_data,
                    url: api_path + "/bar_graph.php",
                }).done(function(data) {
        var barData = data.category_array;
         var rancolor; 
        var cate_arr = [];
        var Category_types = barData;
        var DEFAULT_DATASET_SIZE = 7,
        addedCount = 0,
        color = Chart.helpers.color;
            for(let i in Category_types){
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
        var barValue = {
			labels: data.Category_month,
            datasets: cate_arr
        };
            var chart = data.Category_month;
            var index = 11;
            if(barValue.datasets.length>0){
                var ctx = document.getElementById('barChart');

                var existingBarChart = Chart.getChart("barChart");
                if (existingBarChart) {
                    existingBarChart.destroy();
                }
               console.log("A3");
            // var ctx = document.getElementById("barChart").getContext("2d");
		    var	myNewChartB = new Chart(ctx, {
				type: 'bar',
				data: barValue,
				options: {
					responsive: true,
                    maintainAspectRation: false,
					legend: {
						position: 'bottom',
					},
					title: {
						display: true,
						text: 'Group Product Sales Chart'
					}
				}
			});
            }else{
        var ctx = document.getElementById('barChart');
        var context = ctx.getContext('2d')

            var existingBarChart = Chart.getChart("barChart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
       var width = ctx.width;
       console.log(width);
      var height = ctx.height;
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.font = "16px normal 'Helvetica Nueue'";
      context.fillText('No data to display', width / 2, height / 2);
    }
});
    });

        $(document).ready(function(){
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/pie_graph.php"
        }).done(function(data){
            // console.log(data);
                  //Pie Chart
            var xValues = data.unit_names;
            var yValues = data.unit_sales;
            var barColors = data.random_color;
            if(xValues!="" && yValues!=" " ){
            var ctx = document.getElementById('piechart');

            var existingBarChart = Chart.getChart("piechart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    }]
                },
                options: {
                   legend: {
                      display: false
                    },
                    title: {
                    display: true,
                    text: "Top Sale by Area"
                    }
                }
            })
    }else{
     var ctx = document.getElementById('piechart');
        var context = ctx.getContext('2d')

            var existingBarChart = Chart.getChart("piechart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
       var width = ctx.width;
      var height = ctx.height;
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.font = "18px normal 'Helvetica Nueue'";
      context.fillText('No data to display', width / 2, height / 2);
        }
});
    });
    $(document).on('change','#datepicker2',function(){
        var year_and_month = $("#datepicker2").val();
            var datas = {
                "year_and_month" :year_and_month
            };
        var json_data = JSON.stringify(datas);
        console.log(json_data);
        $.ajax({
                type: "POST",
                dataType: "json",
                data : json_data,
                url: "php/pie_graph.php"
        }).done(function(data){
            // console.log(data);
                  //Pie Chart
            var xValues = data.unit_names;
            var yValues = data.unit_sales;
            var barColors = data.random_color;
            if(xValues!="" && yValues!=" " ){
            var ctx = document.getElementById('piechart');

            var existingBarChart = Chart.getChart("piechart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
            new Chart(ctx, {
                type: "doughnut",
                data: {
                    labels: xValues,
                    datasets: [{
                    backgroundColor: barColors,
                    data: yValues,
                    }]
                },
                options: {
                   legend: {
                      display: false
                    },
                    title: {
                    display: true,
                    text: "Top Sale by Area"
                    }
                }
            })
       
    }else{
        var ctx = document.getElementById('piechart');
        var context = ctx.getContext('2d')

            var existingBarChart = Chart.getChart("piechart");
            if (existingBarChart) {
                existingBarChart.destroy();
            }
       var width = ctx.width;
      var height = ctx.height;
      context.textAlign = 'center';
      context.textBaseline = 'middle';
      context.font = "16px normal 'Helvetica Nueue'";
      context.fillText('No data to display', width / 2, height / 2);
        }
})
    });

        // top_ten_shop_
        $(document).ready(function(){
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_shop.php",
                }).done(function(data) {
                        // console.log('hai',data);
                        var html='';
                        var html1='<option>Select State</option>';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const formattedAmount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.shop_name}</td>`
                            html += `<td>₹ ${formattedAmount}</td>`
                             '<tr>'
                        });

                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        $('#shop_state').html(html1);
                        $('#top_ten_shop_body').html(html);  
                });
                //TOP TEN SELLING PRODUCTS
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_productes.php",
                }).done(function(data) {
                        // console.log('hai',data);
                        var html='';
                        var html1='<option>Select State</option>';
                        var html2='<option>Select Region</option>';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const top_productSellingCost = item.top_productSellingCost.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.products_name}</td>`
                            html += `<td> ${top_productSellingCost}</td>`
                             '<tr>'
                        });
                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        

                         $("#selling_products_state").html(html1);
                        $('#top_ten_selling_product').html(html);  
                        $('#selling_products_region').hide();

        //======================= selling products Regions
                    $(document).on('change','#selling_products_state',function(){
                            var state_id = $(this).val();
                           
                            if (state_id == "Select State" || state_id == '0') {
                                $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: api_path + "/top_ten_productes.php",
                            }).done(function(data) {
                                    // console.log('hai',data);
                                    var html='';
                                    var count = 1;
                                    data.data.forEach(function(item,index){
                                        const top_productSellingCost1 = item.top_productSellingCost.toLocaleString('en-IN');
                                        html += `<tr>`
                                        html += `<td>${count++}</td>`
                                        html += `<td>${item.products_name}</td>`
                                        html += `<td>${top_productSellingCost1}</td>`
                                        '<tr>'
                                    });
                                    $('#top_ten_selling_product').html(html);  
                                    $('#selling_products_region').hide();
                                })
                            }else{
                              
                                var data = {
                                    type:"Topregion",
                                    state_id:state_id
                                }
                                let json_data = JSON.stringify(data);
                                // console.log('json_data',json_data);
                                $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: api_path + "/top_ten_productes.php",
                                        data:json_data,
                                    }).done(function(data) {
                                            //  console.log('region',data);
                                            var html2='<option>Select Region</option>';
                                        data.region_data.forEach(function(item,index){
                                            html2 += `<option value="${item.region_token}">${item.region_name}</option>`
                                        });

                                            $('#selling_products_region').html(html2);
                                            $('#selling_products_region').show();   
                                    });
                            }
                    });
                });
                // TOP TEN DISTRIBUTOR
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_distributor.php",
                }).done(function(data) {
                        // console.log('distributor',data);
                        var html='';
                        var html1='<option>Select State</option>';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const bill_amount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${bill_amount}</td>`
                             '<tr>'
                        });
                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        $('#top_10_distributor').html(html1);  
                        $('#top_ten_distributor').html(html);  
                       
                });
                //TOP TEN LOW PRODUCTS
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_products.php",
                }).done(function(data) {
                        //console.log('hai',data);
                        var html='';
                        var html1='<option>Select State</option>';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const top_productSellingCost_low = item.top_productSellingCost.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.products_name}</td>`
                            html += `<td>${top_productSellingCost_low}</td>`
                            html +='<tr>'
                        });
                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        $('#top_ten_products_review').html(html);  
                        $('#low_selling_product_state').html(html1);  
                        $('#low_selling_product_region').hide();  
                        
                });
                //======================= low selling products Regions
                $(document).on('change','#low_selling_product_state',function(){
                            var state_id = $(this).val();
                           
                            if (state_id == "Select State" || state_id == '0') {
                                $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: api_path + "/top_ten_low_products.php",
                            }).done(function(data) {
                                    // console.log('hai',data);
                                    var html='';
                                    var count = 1;
                                    data.data.forEach(function(item,index){
                                        const top_productSellingCost_low = item.top_productSellingCost.toLocaleString('en-IN');
                                        html += `<tr>`
                                        html += `<td>${count++}</td>`
                                        html += `<td>${item.products_name}</td>`
                                        html += `<td>${top_productSellingCost_low}</td>`
                                        '<tr>'
                                    });
                                    $('#top_ten_products_review').html(html);  
                                    $('#low_selling_product_region').hide();
                                })
                            }else{
                                var data = {
                                    type:"Topregion",
                                    state_id:state_id
                                }
                                let json_data = JSON.stringify(data);
                                // console.log('json_data',json_data);
                                $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: api_path + "/top_ten_low_products.php",
                                        data:json_data,
                                    }).done(function(data) {
                                            //  console.log('region',data);
                                            var html2='<option>Select Region</option>';
                                        data.region_data.forEach(function(item,index){
                                            html2 += `<option value="${item.region_token}">${item.region_name}</option>`
                                        });

                                            $('#low_selling_product_region').html(html2); 
                                            $('#low_selling_product_region').show();  
                                    });
                            }
                    });
                //TOP TEN LOW DISTRIBUTOR
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_distributor.php",
                }).done(function(data) {
                        // console.log('hai',data);
                        var html='';
                        var html1='<option>Select State</option>';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const dis_amount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${dis_amount}</td>`
                             '<tr>'
                        });
                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        $('#top_ten_low_distributor').html(html);  
                        $('#top_10_low_distributor').html(html1);  
                        
                });
                //TOP TEN LOW RETAILER
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_shop.php",
                }).done(function(data) {
                        //console.log('hai',data);
                        var html='';
                        var count = 1;
                        var html1='<option>Select State</option>';
                        data.data.forEach(function(item,index){
                            const bill_amount_low = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.shop_name}</td>`
                            html += `<td>₹ ${bill_amount_low}</td>`
                             '<tr>'
                        });
                        data.state_data.forEach(function(item,index){
                            html1 += `<option value="${item.state_token}">${item.state_name}</option>`
                        });
                        $('#low_state_id').html(html1);
                        $('#top_ten_low_retailer').html(html);  
                });
        });
//=================== TOP 10 SHOP STATE

        $(document).on('change','#shop_state',function(){
            var state_id = $(this).val();
            if (state_id == "Select State" || state_id == "0") {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_shop.php",
                }).done(function(data) {
                        // console.log('hai',data);
                        var html='';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const shop_amount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.shop_name}</td>`
                            html += `<td>₹ ${shop_amount}</td>`
                             '<tr>'
                        });
                        $('#top_ten_shop_body').html(html); 
                });
                
            }else{
                var data = {
                    type:"TopRetailer",
                    state_id:state_id
                }
                let json_data = JSON.stringify(data);
                
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_shop.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data.data);
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                                var html='';
                                var count = 1;
                                data.data.forEach(function(item,index){
                                const shop_amount1 = item.bill_amount.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.shop_name}</td>`
                                html += `<td>₹ ${shop_amount1}</td>`
                                '</tr>'
                                });
                                
                            }
                            $('#top_ten_shop_body').html(html); 
                            
                    });
            }
        });

        //state and year select top 10 shop
        $(document).on('change','#datepicker11',function(){
            var year_and_month = $(this).val();
            var state_id=$('#shop_state').val();
            if (state_id !='' && year_and_month!='') {
                var data = {
                    type:"TopRetailer",
                    state_id:state_id,
                    year_and_month:year_and_month
                }
                let json_data = JSON.stringify(data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_shop.php",
                        data:json_data,
                    }).done(function(data) {
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                                var html='';
                                var count = 1;
                                data.data.forEach(function(item,index){
                                const shop_amount1 = item.bill_amount.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.shop_name}</td>`
                                html += `<td>₹ ${shop_amount1}</td>`
                                '</tr>'
                                });
                                
                            }
                            $('#top_ten_shop_body').html(html); 
                            
                    });
                
                
            }else{
                swal("Please select state");
                            
            }
        });


        //=============== TOP 10 LOW STATE SHOPS
        $(document).on('change','#low_state_id',function(){
            var state_id = $(this).val();
            if (state_id == "Select State" || state_id == "0") {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_shop.php",
                }).done(function(data) {
                        console.log('hai',data);
                        var html='';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const low_shop_amount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.shop_name}</td>`
                            html += `<td>₹ ${low_shop_amount}</td>`
                             '<tr>'
                        });
                        $('#top_ten_low_retailer').html(html);   
                });
                
            }else{
                var data = {
                    type:"TopRetailer",
                    state_id:state_id
                }
                let json_data = JSON.stringify(data);
                console.log('json_data',json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_shop.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                                const low_shop_amount1 = item.bill_amount.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.shop_name}</td>`
                                html += `<td>₹ ${low_shop_amount1}</td>`
                                '<tr>'
                            });
                        }
                            $('#top_ten_low_retailer').html(html);   
                    });
            }
        });

       //top 10 low year and month wise
       $(document).on('change','#datepicker16',function(){
            var year_and_month=$(this).val();
            var state_id =$('#low_state_id').val();
            var data = {
                    type:"TopRetailer",
                    state_id:state_id,
                    year_and_month:year_and_month
                }
                let json_data = JSON.stringify(data);
                if(state_id!='' && year_and_month!=''){
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_shop.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                                const low_shop_amount1 = item.bill_amount.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.shop_name}</td>`
                                html += `<td>₹ ${low_shop_amount1}</td>`
                                '<tr>'
                            });
                        }
                            $('#top_ten_low_retailer').html(html);   
                    }); 
            }else{
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_shop.php",
                }).done(function(data) {
                        console.log('hai',data);
                        var html='';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const low_shop_amount = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.shop_name}</td>`
                            html += `<td>₹ ${low_shop_amount}</td>`
                             '<tr>'
                        });
                        $('#top_ten_low_retailer').html(html);   
                });
            }
        });
        //=================== top selling region products
           
            $(document).on('change','#selling_products_region',function(){
                var region_id = $(this).val();
                var state_id = $("#selling_products_state").val();
                
                    var data = {
                        type:"TopRetailer",
                        state_id:state_id,
                        region_id:region_id
                    }
                    let json_data = JSON.stringify(data);
                    console.log('json_data',json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_productes.php",
                        data:json_data,
                    }).done(function(data){
                            // console.log('hai',data);
                            var html='';
                            var html1='<option>Select State</option>';
                            var html2='<option>Select Region</option>';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                                const region_amount = item.top_productSellingCost.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.products_name}</td>`
                                html += `<td>${region_amount}</td>`
                                '</tr>'
                                });
                            }
                            $('#top_ten_selling_product').html(html);  
                        });
                
            });

            //top ten year filter wise
            $(document).on('change','#datepicker12',function(){
                var year_and_month = $(this).val();
                var region_id = $("#selling_products_region").val();
                var state_id = $("#selling_products_state").val();
                
                    var data = {
                        type:"TopRetailer",
                        state_id:state_id,
                        region_id:region_id,
                        year_and_month:year_and_month
                    }
                    let json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_productes.php",
                        data:json_data,
                    }).done(function(data){
                            // console.log('hai',data);
                            var html='';
                            var html1='<option>Select State</option>';
                            var html2='<option>Select Region</option>';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                                const region_amount = item.top_productSellingCost.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.products_name}</td>`
                                html += `<td>${region_amount}</td>`
                                '</tr>'
                                });
                            }
                            $('#top_ten_selling_product').html(html);  
                        });
                
            });

                 //=================== top selling low region products

            $(document).on('change','#low_selling_product_region',function(){
                var region_id = $(this).val();
                var state_id = $("#low_selling_product_state").val();
                
                    var data = {
                        type:"TopRetailer",
                        state_id:state_id,
                        region_id:region_id
                    }
                    let json_data = JSON.stringify(data);
                    console.log('json_data',json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_products.php",
                        data:json_data,
                    }).done(function(data){
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                                const region_amount_low = item.top_productSellingCost.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.products_name}</td>`
                                html += `<td> ${region_amount_low}</td>`
                                '</tr>'
                            });
                        }
                            $('#top_ten_products_review').html(html);  
                        });
                
            });

            //top selling low year and month wise
            $(document).on('change', '#datepicker14', function() {
                var region_id = $('#low_selling_product_region').val();
                var state_id = $("#low_selling_product_state").val();
                var year_and_month = $(this).val();

                var data = {
                    type: "TopRetailer",
                    state_id: state_id,
                    region_id: region_id,
                    year_and_month:year_and_month
                }
                let json_data = JSON.stringify(data);
                console.log('json_data', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_products.php",
                    data: json_data,
                }).done(function(data) {
                    var html = '';
                    var count = 1;
                    if (data.data.length === 0) {
                        html += `<tr>`

                        html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`

                        '</tr>'
                    } else {
                        data.data.forEach(function(item, index) {
                            const region_amount_low = item.top_productSellingCost.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.products_name}</td>`
                            html += `<td> ${region_amount_low}</td>`
                            '</tr>'
                        });
                    }
                    $('#top_ten_products_review').html(html);
                });

            });
            //================= top_10_distributor

            $(document).on('change','#top_10_distributor',function(){
            var state_id = $(this).val();
            if (state_id == "Select State" || state_id == "0") {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_distributor.php",
                }).done(function(data) {
                        //console.log('top_10_distributor', data.data);
                        var html='';
                        var count = 1;
                       
                                data.data.forEach(function(item,index){
                                const distributor_amounts = item.bill_amount.toLocaleString('en-IN');
                                html += `<tr>`
                                html += `<td>${count++}</td>`
                                html += `<td>${item.distributor_name}</td>`
                                html += `<td>₹ ${distributor_amounts}</td>`
                                '</tr>'
                                });
                            
                        $('#top_ten_distributor').html(html);    
                });
                
            }else{
                var data = {
                    type:"TopRetailer",
                    state_id:state_id
                }
                let json_data = JSON.stringify(data);
                console.log('json_data',json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                             const distributor_amounts1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts1}</td>`
                             '<tr>'
                            });
                        }
                        $('#top_ten_distributor').html(html);  
                    });
            }
        });

        //top10 distributor year and month wise
         $(document).on('change','#datepicker13',function(){
            var year_and_month = $(this).val();
            var state_id=$('#top_10_distributor').val();
            if (state_id !='' && year_and_month!='') {
                var data = {
                    type:"TopRetailer",
                    state_id:state_id,
                    year_and_month:year_and_month
                }
                let json_data = JSON.stringify(data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                             const distributor_amounts1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts1}</td>`
                             '<tr>'
                            });
                        }
                        $('#top_ten_distributor').html(html);  
                    });
                
                
            }else{
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                             const distributor_amounts1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts1}</td>`
                             '<tr>'
                            });
                        }
                        $('#top_ten_distributor').html(html);  
                    });
                            
            }
        });


         //================= top_10_low_distributor

         $(document).on('change','#top_10_low_distributor',function(){
            var state_id = $(this).val();
            if (state_id == "Select State" || state_id == "0") {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/top_ten_low_distributor.php",
                }).done(function(data) {
                        console.log('hai',data);
                        var html='';
                        var count = 1;
                        data.data.forEach(function(item,index){
                            const distributor_amounts_low = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts_low}</td>`
                             '<tr>'
                        });
                        $('#top_ten_low_distributor').html(html);    
                });
                
            }else{
                var data = {
                    type:"TopRetailer",
                    state_id:state_id
                }
                let json_data = JSON.stringify(data);
                console.log('json_data',json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            console.log('hai',data);
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                            const distributor_amounts_low1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts_low1}</td>`
                             '<tr>'
                        });
                    }
                        $('#top_ten_low_distributor').html(html);  
                    });
            }
        });

       //top 10 low distributor year and month wise
        $(document).on('change','#datepicker15',function(){
            var year_and_month = $(this).val();
            var state_id=$('#top_10_low_distributor').val();
            if (state_id !='' && year_and_month!='') {
                var data = {
                    type:"TopRetailer",
                    state_id:state_id,
                    year_and_month:year_and_month
                }
                let json_data = JSON.stringify(data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                            const distributor_amounts_low1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts_low1}</td>`
                             '<tr>'
                        });
                    }
                        $('#top_ten_low_distributor').html(html);  
                    });
                
            }else{
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_low_distributor.php",
                        data:json_data,
                    }).done(function(data) {
                            var html='';
                            var count = 1;
                            if (data.data.length === 0) {
                                html += `<tr>`
                                
                                html += `<td colspan="3"><span style="text-align:center">Data not found</span></td>`
                                
                                '</tr>'
                            }else{
                            data.data.forEach(function(item,index){
                            const distributor_amounts_low1 = item.bill_amount.toLocaleString('en-IN');
                            html += `<tr>`
                            html += `<td>${count++}</td>`
                            html += `<td>${item.distributor_name}</td>`
                            html += `<td>₹ ${distributor_amounts_low1}</td>`
                             '<tr>'
                        });
                    }
                        $('#top_ten_low_distributor').html(html);  
                    });
                            
            }
        });




        //sales by region chart

        $(document).on('change','#datepicker10',function(){
            var state_id = $('#region_division').val();
            var year_and_month = $("#datepicker10").val();
            var datas = {
                type:'TopRetailer',
                state_id : state_id,
                year_and_month:year_and_month
                
            };
        var json_data = JSON.stringify(datas);
            console.log('json_data',json_data);
            $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/top_ten_region_dotchart.php",
                        data:json_data,
                    }).done(function(chartdata) {
                        console.log('chartdata',chartdata);
                        if(chartdata.data.length > 0){
                        var chart_datas1 = '';
                        var chart_arr1 = [];
                        var labs1=[];
                        labs1.push(chartdata.data[0].monthName);
                        chartdata.data.forEach(function(item,index){
                            var letters = '0123456789ABCDEF';
                        var color = '#';
                        for (var i = 0; i < 6; i++) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }
                            
                            chart_datas1 ={ 
                                label:item.region_name,
                                backgroundColor: color,
                                borderColor: color,
                                data:[item.bill_amount],
                            }
                            chart_arr1.push(chart_datas1);
                        });

                        var barValue = {
                            labels : labs1,
                            datasets: chart_arr1
                            };
                            const ctx = document.getElementById('myChart');
                            // Get the existing chart instance and destroy it
                            const existingBarChart = Chart.getChart("myChart");
                            if (existingBarChart) {
                                existingBarChart.destroy();
                            }
                            var myChart = new Chart(ctx, {
                            type: 'bar',
                            data: barValue,
                            options: {
                                responsive: true,
                                maintainAspectRation: true,
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Bar Chart'
                                },

                                scales: {
                                        xAxes: [{
                                                display: true,
                                                scaleLabel: {
                                                    display: true,
                                                    labelString: 'Month'
                                                }
                                            }],
                                        yAxes: [{
                                                display: true,
                                                ticks: {
                                                    beginAtZero: true,
                                                    // stepSize: 2,
                                                    steps: 1000000,
                                                    stepValue: 5,
                                                    max: 1000000
                                                    
                                                }
                                            }]
                                    },
                            }
                            });
                        }else{
                            var ctx = document.getElementById('myChart');
                            var context = ctx.getContext('2d')

                                var existingBarChart = Chart.getChart("myChart");
                                if (existingBarChart) {
                                    existingBarChart.destroy();
                                }
                        var width = ctx.width;
                        console.log(width);
                        var height = ctx.height;
                        context.textAlign = 'center';
                        context.textBaseline = 'middle';
                        context.font = "16px normal 'Helvetica Nueue'";
                        context.fillText('No data to display', width / 2, height / 2);
                        }
                    });
        });
        
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
mysqli_close($link);

