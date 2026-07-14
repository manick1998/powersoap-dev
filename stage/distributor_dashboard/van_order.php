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
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<style>
    /* a{
        cursor: pointer;
    }
    .field_data{
        padding-right: 10px;
    } 
    .dataTables_filter form {
            position: absolute;
        }
        .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
              position: static;
        }          */
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
                        <h1 class="header_main">Van Order</h1>
                    </div>
                    <p class="table_count">Total Order - <span id="total_order_count"></span></p>
                </div>
            </div>
            <div class="dataTables_filter">
               <form class="formdield">
                    <div class="form-group field_data"> 
                        <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()" type="text"  placeholder="From Date" readonly>
                      </div>
                      <div class="form-group field_data">
                        <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()"  type="text" placeholder="To Date"  readonly>
                      </div>
                  </form>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Order Number</th>
                            <th>Date & Time</th>
                            <th>Shop Name</th>
                            <th>Salesman</th>
                            <th>Items</th>
                            <th>Paid Amount</th>
                            <th>Outstanding Amount</th>
                            <th>Delivery</th>
                            <th>Delivered on</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_id">
                    </tbody>
                </table>
            </div>
        </section>
        <section class="bg-white brad-4 full-height" id="toggle1" style="display: none;" >
            <div class="header_container">
                <div class="header-details">
                    <div class="title_box">
                        <div class="header_box">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span class="shop_name" id="single_shop_name"> </span></h1>
                            <span id="single_order_status"></span>
                        </div>
                    </div>
                    <p class="table_count" id="single_order_token"></p>
                    <div class="details-top-section">
                        <div class="details-top-div">
                            <p id="single_order_date"></p>
                        </div>
                        <div class="details-top-div">
                            <p id="single_salesman_name"></p>
                        </div>
                        <div class="details-top-div">
                            <p id="single_items"></p>
                        </div>
                        <div class="details-top-div">
                            <p id="single_delivered_on"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-box">
                        <table class="custom-table" id="item_list_table">
                            <thead>
                                <tr>
                                    <th>SI.No</th>
                                    <th>Item Name</th>
                                    <th>Qty In Pieces</th>
                                    <th>UOM</th>
                                </tr>
                            </thead>
                            <tbody id="item_table_body"></tbody>
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
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>


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
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script> 
    <script>var notiCount = "<?php echo $notiCount; ?>";</script>
    <script>
        $('#fromDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            maxDate: 0 
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            maxDate: 0 
        });
    </script>
    <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var distributor_token = "<?php echo $_SESSION["distributor_token"]; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table; 
        $(document).ready(function () {
             data_fetch();
        });
        function data_fetch(){
            $(".se-pre-con").fadeIn();
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            
            table = $('#table_data').DataTable({
                scrollX: true,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0 ] }
                ],
                'ajax': {
                'url':api_path+"/distributor/server_van_order_list.php?from_date="+from_date+"&to_date="+to_date+"&v_id="+verfication_code+"&dist_id="+distributor_token,
                'dataSrc': function(data) {
                        $("#total_order_count").html(data.iTotalDisplayRecords);
                        return data.aaData;
                    }
                },
                "order": [[2, 'desc']],
                'columns': [
                    { data: 'order_token' },
                    { data: 'order_number' },
                    { data: 'date_time' },
                    { data: 'shop_name' },
                    { data: 'sales_man' },
                    { data: 'items' },
                    { data: 'paid_amount' },
                    { data: 'outstanding_amount' },
                    { data: 'delivery' },
                    { data: 'delivered_on' }
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
                }
            });
            table.column(0).visible(false);
            $('.dataTables_length').css("display","none");
            $(".se-pre-con").fadeOut();
        }
        function date_filter(){
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
                table.clear();
                table.destroy();
                data_fetch();
            }
        }
        var order_table_check = false;
        var order_table;
        $('#table_data tbody').on( 'click', '.view_link', function () {
            var td_div = $(this).parent().parent();
            var table_data = table.row( td_div ).data();
            var token = table_data.order_token;
            particular_order_detail(token)
        });
        function particular_order_detail(token){
            $(".se-pre-con").show();
            var datas = {
                dashboard_code: verfication_code,
                distributor_token:distributor_token,
                order_token: token,
                type: "particular_order_detail"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/distributor/van_order_detail.php",
                data: json_data
            }).done(function(data) {
                var order_data = data.data;
                $("#single_shop_name").html(order_data[0].shop_name);
                $("#single_order_status").html(order_data[0].delivery);
                $("#single_order_token").html(order_data[0].order_number);
                $("#single_order_date").html("Date & Time: <span class='label_value'>"+order_data[0].date_time+"</span>");
                $("#single_salesman_name").html("Salesman: <span class='label_value'>"+order_data[0].sales_man+"</span>");
                $("#single_items").html("Items: <span class='label_value'>"+order_data[0].items+"</span>");
                $("#single_delivered_on").html("Delivered on: <span class='label_value'>"+order_data[0].delivered_on+"</span>");
                if(order_table_check){
                    order_table.clear();
                    order_table.destroy();
                }
                var total_items = 0;
                var total_sales = 0;
                var item_data = data.data_item;
                var html_text = "";
                var slno1 = 0;
                for (var key in item_data) {
                    slno1++;
                    html_text += '<tr>';
                        html_text += '<td>'+slno1+'</td>';
                        html_text += '<td>'+item_data[key].item_name+'</td>';
                        html_text += '<td>'+item_data[key].quantity+'</td>';
                        html_text += '<td>'+item_data[key].units+'</td>';
                    html_text += '</tr>';
                }
                $("#item_table_body").html(html_text);
                var payment_data= data.data_payment;

                $('#toggle').hide();
                $('#toggle1').show();
                order_table = $("#item_list_table").DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    bFilter: false,
                    buttons: [],
                    language: {
                      search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                     paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                    }
                    }
                });
                order_table_check = true;
                // $("#item_list_table_filter").css("display","none");
                $(".se-pre-con").hide();
            });
        }
        function back_view_order(){
            $('#toggle1').hide();
            $('#toggle').show();
        }
    </script>
</body>
</html>
<?php
}
mysqli_close($link);
?>