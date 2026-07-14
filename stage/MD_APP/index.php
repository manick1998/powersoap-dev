<?php
	include "config.php";
    include "$api_path/config/core.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Power Soap | Report Dashboard</title>
    <link rel="shortcut icon" href="img/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/style.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/report.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
<style>
    .contain_width{
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
    .order-year, .top_sell_additional_box{
    padding-top: 85px;
    }
</style>
</head>
<body >
    <header id="main-dash-header" class="dash-header">  
        <div class="head-logo">
             <span style="font-size:30px;cursor:pointer" id="opentag" onclick="openNav()">&#9776; </span><a href="javascript:void(0)"><img class="logo" src="img/logo.png" alt="logo"></a>
        </div> 
        <div class="back-drop hidden"></div>
    </header>
    <div class="display_cls">
    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" id="closetag" onclick="closeNav()">&times;</a>
      <a class="smoothscroll" href="#top_sale_unit">Sale By Unit</a>
      <a class="smoothscroll" href="#top_selling">Selling Product</a>
      <a class="smoothscroll" href="#top_sale_unit">Distributor</a>
      <a class="smoothscroll" href="#retailer_review">Retailers Reviewed</a>
    </div>
    <!-- main-contents -->
    <main class="main-contents">
    <div class="contain_width">
    <section class="full-height">
        
        <div class="my-dashboard">
            <div class="four-card-box">
                <div class="order-card">
                    <div class="order-card-left">
                        <img src="img/total_ordeers_icon.svg" alt="order-icon ">
                    </div>
                    <div class="order-card-right">
                        <p>Total Orders</p>
                        <h1 id="order_count"></h1>
                    </div>
                </div>
                <div class="employee-card">
                    <div class="order-card-left">
                        <img src="img/employees_icon.svg" alt="">
                    </div>
                    <div class="order-card-right">
                        <p>Total Distributors</p>
                        <h1 id="employees_count"></h1>
                    </div>
                </div>
                <div class="Total-Outstanding">
                    <div class="order-card-left">
                        <img src="img/total_outstanding_icon.svg" alt="order-icon ">
                    </div>
                    <div class="order-card-right">
                        <p>Total Field Sales Agents</p>
                        <h1 id="outstanding_count"></h1>
                    </div>
                </div>
                <div class="total-retailer">
                    <div class="order-card-left">
                        <img src="img/shop.svg" alt="order-icon ">
                    </div>
                    <div class="order-card-right">
                        <p>Total Retailers</p>
                        <h1 id="retailer_count"></h1>
                    </div>
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
                <canvas id="barChart" style="width:100%;"></canvas> 
             </div>
        </div>  
        <div class="order-year" id="top_sale_unit">
            <div class="sale-pie-chart" >
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3> Top Sales By Unit</h3>
                    </div>
                </div>
                <canvas id="piechart" style="height:300px;width: 600px;"></canvas>
            </div>
             <div class="top_additonal_right_set">
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3> Top 10 Distributor</h3>
                    </div>
                    <div class="sale-head-right">
                        <form class="formdield">
                           <div class="form-group field_data"> 
                                <input class="form-control box_form" name="date" id="fromDateTopDist" onchange="date_Filter_Distribut()" type="text"  placeholder="From Date" readonly>
                           </div>
                          <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDateTopDist" onchange="date_Filter_Distribut()" type="text" placeholder="To Date"  readonly>
                          </div>
                        </form>
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
                   
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
        <div class="top_sell_additional_box" id="top_selling">
            <div class="top-sell-product" >
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3> Top 10 Selling Product</h3>
                    </div>
                    <div class="sale-head-right">
                        <form class="formdield">
                           <div class="form-group field_data"> 
                                <input class="form-control box_form" name="date" id="fromDateTopSell" onchange="date_filter_Top_Sell()" type="text"  placeholder="From Date" readonly>
                           </div>
                          <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDateTopSell" onchange="date_filter_Top_Sell()" type="text" placeholder="To Date"  readonly>
                          </div>
                        </form>
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
                        
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="top_additonal_left_set">
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3>Products To Be Reviewed</h3>
                    </div>
                     <div class="sale-head-right">
                        <form class="formdield">
                           <div class="form-group field_data"> 
                                <input class="form-control box_form" name="date" id="fromDateBotSell" onchange="date_filter_Bot_Sell()" type="text"  placeholder="From Date" readonly>
                           </div>
                          <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDateBotSell" onchange="date_filter_Bot_Sell()" type="text" placeholder="To Date"  readonly>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>sl no</th>
                                <th>Name</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody id="bottom_prodt_body">
                        
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
        <div class="top_sell_additional_box" id="retailer_review">
          <div class="top_additonal_right_set">
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3>Top 10 Retailers</h3>
                    </div>
                     <div class="sale-head-right">
                        <form class="formdield">
                           <div class="form-group field_data"> 
                                <input class="form-control box_form" name="date" id="fromDateTopRetailer" onchange="date_filter_top_retailer()" type="text"  placeholder="From Date" readonly>
                           </div>
                          <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDateTopRetailer" onchange="date_filter_top_retailer()" type="text" placeholder="To Date"  readonly>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody id="retailer_body">
                              
                        </tbody>
                    </table>
                </div>
             </div>
          <div class="top_additonal_left_set">
                <div class="sale-head">
                    <div class="sale-head-left">
                        <h3>Retailers To Be Reviewed</h3>
                    </div>
                    <div class="sale-head-right">
                        <form class="formdield">
                           <div class="form-group field_data"> 
                                <input class="form-control box_form" name="date" id="fromDateBotRetailer" onchange="date_filter_bottom_retailer()" type="text"  placeholder="From Date" readonly>
                           </div>
                          <div class="form-group field_data">
                            <input class="form-control box_form" name="date" id="toDateBotRetailer" onchange="date_filter_bottom_retailer()" type="text" placeholder="To Date"  readonly>
                          </div>
                        </form>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Rank</th>
                                <th>Name</th>
                                <th>Total Sale</th>
                            </tr>
                        </thead>
                        <tbody id="retailerReview_body">
                           
                        </tbody>
                    </table>
                </div>
             </div>
        </div>
    </section>
    </div>
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
    <script>
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";     
$(document).ready(function(){
    $('#fromDateTopDist').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    $('#toDateTopDist').datepicker({
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
    
    $('#fromDateTopRetailer').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    $('#toDateTopRetailer').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    
    $('#fromDateBotRetailer').datepicker({
        autoclose: true,
        todayHighlight: true,
    });
    $('#toDateBotRetailer').datepicker({
        autoclose: true,
        todayHighlight: true,
    });

});   
            
    function openNav() {
        $("#mySidenav").width( 300 );
    }
    function closeNav() {
        $("#mySidenav").width( 0 );
    }
    $(".display_cls").click(function(){
        closeNav();
    });
        
    $('.smoothscroll').on('click',function(e) {
        e.preventDefault();
        var target = this.hash,
        $target = $(target);
        $('html, body').animate({
            'scrollTop': $target.offset().top
        }, 800, 'swing', function () {
            window.location.hash = target;
        });
    });

//    /*scale pie chart*/
//    var xValues = ["Mylapore", "Tambaram", "Guindy"];
//    var yValues = [60, 30, 10];
//    var barColors = ["#facd18","#44d62c","#d70b64"];
//    new Chart("piechart", {
//        type: "doughnut",
//        data: {
//            labels: xValues,
//            datasets: [{
//            backgroundColor: barColors,
//            data: yValues,
//            }]
//        },
//        options: {
//            title: {
//            display: true,
//            text: "Top Sale by Unit"
//            }
//        }
//    });
//
//    //bar chart
//    var DEFAULT_DATASET_SIZE = 7,
//        addedCount = 0,
//        color = Chart.helpers.color;
//
//    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
//
//    var chartColors = {
//        red: "#51bdff",
//        orange: "#ffb851",
//        yellow: 'rgb(255, 205, 86)',
//        green: 'rgb(75, 192, 192)',
//        blue: "#a151ff",
//        purple: 'rgb(153, 102, 255)',
//        grey: 'rgb(231,233,237)'
//    };
//
//    function randomScalingFactor() {
//        return Math.round(Math.random() * 100);
//    }
//
//    var barData = {
//        labels: ["January", "February", "March", "April", "May", "June", "July"],
//        datasets: [{
//            label: 'Soap',
//            backgroundColor: color(chartColors.red).alpha(0.5).rgbString(),
//            borderColor: chartColors.red,
//            borderWidth: 1,
//            data: [
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor()
//            ]
//        }, {
//            label: 'Liquid',
//            backgroundColor: color(chartColors.blue).alpha(0.5).rgbString(),
//            borderColor: chartColors.blue,
//            borderWidth: 1,
//            data: [
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor()
//            ]
//        },{
//            label: 'Conditioner',
//            backgroundColor: color(chartColors.orange).alpha(0.5).rgbString(),
//            borderColor: chartColors.red,
//            borderWidth: 1,
//            data: [
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor(),
//                randomScalingFactor()
//            ]
//        }
//    ]};
//    var index = 11;
//    var ctx = document.getElementById("barChart").getContext("2d");
//    var	myNewChartB = new Chart(ctx, {
//            type: 'bar',
//            data: barData,
//            options: {
//                responsive: true,
//      maintainAspectRation: true,
//                legend: {
//                    position: 'bottom',
//                },
//                title: {
//                    display: true,
//                    text: 'Bar Chart'
//                }
//            }
//        });
        
    
        
        
    $(document).ready(function(){
        $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/homepageTotal.php",
        }).done(function(data){
            var boxData = data.dashboard_details;
            $("#order_count").text(boxData.order_taken_value);
            $("#employees_count").text(boxData.get_distributor);
            $("#outstanding_count").text(boxData.get_salesDelivery);
            $("#retailer_count").text(boxData.shop_count_value);
        });
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/pie_graph.php"
        }).done(function(data){
            console.log(data);
                  //Pie Chart
            var xValues = data.unit_names;
            var yValues = data.unit_sales;
            var barColors = data.random_color;
            new Chart("piechart", {
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
                    text: "Top Sale by Unit"
                    }
                }
            });
                             
        //Bar Chart
        var rancolor; 
        var cate_arr = [];
        var Category_types = data.Category_array;
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
            
        var barData = {
			labels: data.Category_month,
            datasets: cate_arr
        };
            var chartLength = data.Category_month;
            if(chartLength.length > 0){
            var index = 11;
            var ctx = document.getElementById("barChart").getContext("2d");
		    var	myNewChartB = new Chart(ctx, {
				type: 'bar',
				data: barData,
				options: {
					responsive: true,
          maintainAspectRation: true,
					legend: {
						position: 'bottom',
					},
					title: {
						display: true,
						text: 'Bar Chart'
					}
				}
			});
        }  
    });
         
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/top_distributor.php"
        }).done(function(data){
            var distData = data.data;
            var shno = 0;
            var dist_html = '';
            if(distData.length > 0){
               for(var key in distData){
                   shno++;
                    dist_html += '<tr>';
                        dist_html += '<td>'+shno+'</td>';
                        dist_html += '<td>'+distData[key].distributor_name+'</td>';
                        dist_html += '<td>'+distData[key].distributor_amt+'</td>';      
                    dist_html += '</tr>';
               }
            }else{
                dist_html += '<tr>';
                        dist_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                dist_html += '</tr>';
            }
            $("#distributor_body").html(dist_html);
        });
           
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/top_selling_product.php"
        }).done(function(data){ 
            var topProdtData = data.data;
            var prtno = 0;
            var top_html = '';
            if(topProdtData.length > 0){
               for(var key in topProdtData){
                   prtno++;
                    top_html += '<tr>';
                        top_html += '<td>'+prtno+'</td>';
                        top_html += '<td>'+topProdtData[key].product_name+'</td>';
                        top_html += '<td>'+topProdtData[key].product_amt+'</td>';      
                    top_html += '</tr>';
               }
            }else{
                top_html += '<tr>';
                        top_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                top_html += '</tr>';
            }
            $("#top_prodt_body").html(top_html);
        });
         
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/least_selling_product.php"
        }).done(function(data){ 
            var bottomProdtData = data.data;
            var prbno = 0;
            var bottom_html = '';
            if(bottomProdtData.length > 0){
               for(var key in bottomProdtData){
                   prbno++;
                    bottom_html += '<tr>';
                        bottom_html += '<td>'+prbno+'</td>';
                        bottom_html += '<td>'+bottomProdtData[key].product_name+'</td>';
                        bottom_html += '<td>'+bottomProdtData[key].product_amt+'</td>';      
                    bottom_html += '</tr>';
               }
            }else{
                 bottom_html += '<tr>';
                        bottom_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                bottom_html += '</tr>';
            }
            $("#bottom_prodt_body").html(bottom_html);
        });
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/top_retailers.php"
        }).done(function(data){
            console.log(data);
            var shopData = data.data;
            var shno = 0;
            var shop_html = '';
            if(shopData.length > 0){
               for(var key in shopData){
                   shno++;
                    shop_html += '<tr>';
                        shop_html += '<td>'+shno+'</td>';
                        shop_html += '<td>'+shopData[key].shop_name+'</td>';
                        shop_html += '<td>'+shopData[key].bill_amount+'</td>';      
                    shop_html += '</tr>';
               }
            }else{
                 shop_html += '<tr>';
                        shop_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                shop_html += '</tr>';
            }
            $("#retailer_body").html(shop_html);
        });
        
        $.ajax({
                type: "POST",
                dataType: "json",
                url: "php/least_retailer.php"
        }).done(function(data){
            console.log(data);
            var shopReview = data.data;
            var reno = 0;
            var review_html = '';
            if(shopReview.length > 0){
               for(var key in shopReview){
                   reno++;
                    review_html += '<tr>';
                        review_html += '<td>'+reno+'</td>';
                        review_html += '<td>'+shopReview[key].shop_name+'</td>';
                        review_html += '<td>'+shopReview[key].bill_amount+'</td>';      
                    review_html += '</tr>';
               }
            }else{
                 review_html += '<tr>';
                        review_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                review_html += '</tr>';
            }
            $("#retailerReview_body").html(review_html);
        });
    });    


    function date_Filter_Distribut(){
        var from_date = $("#fromDateTopDist").val();
        var to_date   = $("#toDateTopDist").val();
        if(from_date>to_date && to_date!="" && to_date!=undefined){
            $("#toDateTopDist").val(from_date);
        }
        var to_date   = $("#toDateTopDist").val();
        if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
            var datas = {
                from_date: from_date,
                to_date: to_date,
                type: 'TopDistributor'
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "php/top_distributor.php",
                data: json_data
            }).done(function(data){
            $('#distributor_body').empty();
            var distData = data.data;
            var shno = 0;
            var dist_html = '';
            if(distData.length > 0){
               for(var key in distData){
                   shno++;
                    dist_html += '<tr>';
                        dist_html += '<td>'+shno+'</td>';
                        dist_html += '<td>'+distData[key].distributor_name+'</td>';
                        dist_html += '<td>'+distData[key].distributor_amt+'</td>';      
                    dist_html += '</tr>';
               }
            }else{
                dist_html += '<tr>';
                        dist_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                dist_html += '</tr>';
            }
            $("#distributor_body").html(dist_html);
            });
        }
    }
        
    function date_filter_Top_Sell(){
        var from_date = $("#fromDateTopSell").val();
        var to_date   = $("#toDateTopSell").val();
        if(from_date>to_date && to_date!="" && to_date!=undefined){
            $("#toDateTopSell").val(from_date);
        }
        var to_date   = $("#toDateTopSell").val();
        if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
            var datas = {
                from_date: from_date,
                to_date: to_date,
                type: 'TopSellingProduct'
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "php/top_selling_product.php",
                data: json_data
            }).done(function(data){
                $('#top_prodt_body').empty();
                var topProdtData = data.data;
                var prtno = 0;
                var top_html = '';
                if(topProdtData.length > 0){
                   for(var key in topProdtData){
                       prtno++;
                        top_html += '<tr>';
                            top_html += '<td>'+prtno+'</td>';
                            top_html += '<td>'+topProdtData[key].product_name+'</td>';
                            top_html += '<td>'+topProdtData[key].product_amt+'</td>';      
                        top_html += '</tr>';
                   }
                }else{
                    top_html += '<tr>';
                            top_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                    top_html += '</tr>';
                }
                $("#top_prodt_body").html(top_html);
            });
        }
    }
            
    function date_filter_Bot_Sell(){
        var from_date = $("#fromDateBotSell").val();
        var to_date   = $("#toDateBotSell").val();
        if(from_date>to_date && to_date!="" && to_date!=undefined){
            $("#toDateBotSell").val(from_date);
        }
        var to_date   = $("#toDateBotSell").val();
        if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
            var datas = {
                from_date: from_date,
                to_date: to_date,
                type: 'BottomSellingProduct' 
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "php/least_selling_product.php",
                data: json_data
            }).done(function(data){
                $('#bottom_prodt_body').empty();
                var bottomProdtData = data.data;
                var prbno = 0;
                var bottom_html = '';
                if(bottomProdtData.length > 0){
                   for(var key in bottomProdtData){
                       prbno++;
                        bottom_html += '<tr>';
                            bottom_html += '<td>'+prbno+'</td>';
                            bottom_html += '<td>'+bottomProdtData[key].product_name+'</td>';
                            bottom_html += '<td>'+bottomProdtData[key].product_amt+'</td>';      
                        bottom_html += '</tr>';
                   }
                }else{
                     bottom_html += '<tr>';
                            bottom_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                    bottom_html += '</tr>';
                }
                $("#bottom_prodt_body").html(bottom_html); 
            });
        }
    } 
        
    function date_filter_top_retailer(){
        var from_date = $("#fromDateTopRetailer").val();
        var to_date   = $("#toDateTopRetailer").val();
        if(from_date>to_date && to_date!="" && to_date!=undefined){
            $("#toDateTopRetailer").val(from_date);
        }
        var to_date   = $("#toDateTopRetailer").val();
        if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
            var datas = {
                from_date: from_date,
                to_date: to_date,
                type: 'TopRetailer' 
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "php/top_retailers.php",
                data: json_data
            }).done(function(data){
                $('#retailer_body').empty();
                var shopData = data.data;
                var shno = 0;
                var shop_html = '';
                if(shopData.length > 0){
                   for(var key in shopData){
                       shno++;
                        shop_html += '<tr>';
                            shop_html += '<td>'+shno+'</td>';
                            shop_html += '<td>'+shopData[key].shop_name+'</td>';
                            shop_html += '<td>'+shopData[key].bill_amount+'</td>';      
                        shop_html += '</tr>';
                   }
                }else{
                     shop_html += '<tr>';
                            shop_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                    shop_html += '</tr>';
                }
                $("#retailer_body").html(shop_html);
            });
        }
    } 
        
    function date_filter_bottom_retailer(){
        var from_date = $("#fromDateBotRetailer").val();
        var to_date   = $("#toDateBotRetailer").val();
        if(from_date>to_date && to_date!="" && to_date!=undefined){
            $("#toDateBotRetailer").val(from_date);
        }
        var to_date   = $("#toDateBotRetailer").val();
        if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
            var datas = {
                from_date: from_date,
                to_date: to_date,
                type: 'BottomRetailer' 
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "php/least_retailer.php",
                data: json_data
            }).done(function(data){
                $('#retailerReview_body').empty();
                var shopReview = data.data;
                var reno = 0;
                var review_html = '';
                if(shopReview.length > 0){
                   for(var key in shopReview){
                       reno++;
                        review_html += '<tr>';
                            review_html += '<td>'+reno+'</td>';
                            review_html += '<td>'+shopReview[key].shop_name+'</td>';
                            review_html += '<td>'+shopReview[key].bill_amount+'</td>';      
                        review_html += '</tr>';
                   }
                }else{
                     review_html += '<tr>';
                            review_html += '<td colspan="3" style="text-align: center;">No Records Found</td>'; 
                    review_html += '</tr>';
                }
                $("#retailerReview_body").html(review_html); 
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
    <script>
    // Activate Bootstrap scrollspy on the main nav element
//    const mainNav = document.body.querySelector('#main-dash-header');
//    if (mainNav) {
//        new bootstrap.ScrollSpy(document.body, {
//            target: '#main-dash-header',
//            offset: 80,
//        });
//    };
    
    </script>
</body>
</html>