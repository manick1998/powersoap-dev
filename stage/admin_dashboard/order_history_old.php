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
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<style>
    a{
        cursor: pointer;
    }
</style>
<body>
    <div class="se-pre-con" style="display: block;"></div>
    <header id="main-dash-header" class="dash-header">      
    </header>

    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar4"></div>
    
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle">
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main">Sales Order</h1>
                    </div>
                    <p class="table_count">Total Order - <span id="total_order_count"></span></p>
                </div>
            </div>
            <div class="dataTables_filter">
               <form class="formdield">
                    <div class="form-group"> 
                        <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()" type="text"  placeholder="From Date" readonly>
                      </div>
                      <div class="form-group">
                        <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()"  type="text" placeholder="To Date"  readonly>
                      </div>
                  </form>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Order ID</th>
                            <th>Date & Time</th>
                            <th>Shop Name</th>
                            <th>Salesman</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Delivery</th>
                            <th>Delivered on</th>
                            <th>Outstanding</th>
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

                    <!--<div class="header-section sep_word">
                        <h1 class="header_main">
                          <span class="twoinspace">
                                <img src="assets/back.png" onclick="back_view_order()" alt="">
                            </span>   
                        </h1>
                    </div>-->

                    <div class="title_box">
                        <div class="header_box">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span id="single_shop_name"> </span></h1>
                            <span id="single_order_status"></span>
                        </div>
                        <input id="cancel_order_token" type="hidden">
                        <a id="cancel_order_button" class="add_red" onclick="cancel_order()">Cancel Order</a>
                    </div>
                    
                    <p class="table_count" id="single_order_token"></p>
                    <div class="details-top-section">
                        <div class="details-top-div">
                            <p id="single_order_date"></p>
                            <p id="single_order_amount"></p>
                        </div>
                        <div class="details-top-div">
                            <p id="single_salesman_name"></p>
                            <p id="single_paid_amount"></p>
                        </div>
                        <div class="details-top-div">
                            <p id="single_items"></p>
                            <p id="single_outstanding"></p>
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
                <li class="nav-item " role="presentation">
                <button class="nav-link rightbot active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Order Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link leftbot" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Payments</button>
                </li>
                <li class="nav-item nav-item-center" >
                    <button class="nav-link active" type="button"><span><img src="assets/invoice_icon.png" class="invoice"></span>Invoice</button>
                </li>
                <p class="order-right-content"><a id="single_total_amount">Total Amount: Rs.6,285</a></p>
            </ul>
            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="custom-table" id="item_list_table">
                        <thead>
                            <tr>
                                <th>SI.No</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Perunit price</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody id="item_table_body"></tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div id="payments" class="table-box w3-border city" >
                        <table class="custom-table" id="order_payment_table">
                            <thead>
                                <tr>
                                    <th>SI.No</th>
                                    <th>Date & Time</th>
                                    <th>Mode</th>
                                    <th>Paid Amount</th>
                                </tr>
                            </thead>
                            <tbody id="order_payment_table_body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>



    </main>    
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> 
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
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
        var table;    
        var table_main_data;    
        $(document).ready(function () {
            var datas = {
                dashboard_code: verfication_code,
                type: "all"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/orderDetails.php",
                data: json_data,
                success: success,
            });
        });    
        function success(data) {
            table_main_data = data.data;
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                    html_text += '<td>'+slno+'</td>';
                    html_text += '<td><a class="view_link" onclick="particular_order_detail('+key+')">'+table_main_data[key].order_token+'</a></td>';
                    html_text += '<td>'+table_main_data[key].date_time+'</td>';
                    html_text += '<td>'+table_main_data[key].shop_name+'</td>';
                    html_text += '<td>'+table_main_data[key].sales_man+'</td>';
                    html_text += '<td>'+table_main_data[key].items+'</td>';
                    html_text += '<td>Rs.'+numberWithCommas(table_main_data[key].billing_amount)+'</td>';
                    html_text += '<td>'+table_main_data[key].delivery+'</td>';
                    html_text += '<td>'+table_main_data[key].delivered_on+'</td>';
                    if(table_main_data[key].outstanding==0){
                        html_text += '<td class="add_red">Rs.'+table_main_data[key].outstanding+'</td>';
                    }else{
                        html_text += '<td><span style="color: tomato;">Rs.'+numberWithCommas(table_main_data[key].outstanding)+'</span></td>';
                    }
                    
                html_text += '</tr>';
            }
            $("#table_body_id").html(html_text);
            key++;
            $("#total_order_count").html(numberWithCommas(key));
            table = $("#table_data").DataTable({
                dom: 'Bfrtip',
                buttons: [],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                    }
                }
            });
            $(".se-pre-con").hide();
        }
        function date_filter(){
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            if(from_date!="" && to_date!="" && from_date!=undefined && to_date!=undefined){
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    from_date: from_date,
                    to_date: to_date,
                    type: "date_range"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url : api_path+"/admin/orderDetails.php",
                    data: json_data,
                    success: successClear,
                });
            }
        }
        function successClear(data){
            table.clear();
            table.destroy();
            success(data);
        }
        var order_table_check = false;
        var order_table;    
        function particular_order_detail(key){
            $("#cancel_order_token").val(table_main_data[key].order_token);
            if(table_main_data[key].delivery_value=="Pending"){
                $("#cancel_order_button").css("display", "block");
            }else{
                $("#cancel_order_button").css("display", "none");
            }
            var datas = {
                dashboard_code: verfication_code,
                order_token: table_main_data[key].order_token,
                type: "particular_order_detail"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/orderDetails.php",
                data: json_data
            }).done(function(data) {
                var order_data = data.data;
                $("#single_shop_name").html(order_data[0].shop_name);
                $("#single_order_status").html(order_data[0].delivery);
                $("#single_order_token").html(order_data[0].order_token);
                $("#single_order_date").html("Date & Time: "+order_data[0].date_time);
                $("#single_order_amount").html("Amount: Rs."+numberWithCommas(order_data[0].billing_amount));
                $("#single_salesman_name").html("Salesman: "+order_data[0].sales_man);
                $("#single_paid_amount").html("Paid: Rs."+numberWithCommas(order_data[0].paid_amount));
                $("#single_items").html("Items: "+order_data[0].items);
                if(order_data[0].outstanding==0){
                    $("#single_outstanding").html("Outstanding: -");
                }else{
                    $("#single_outstanding").html('Outstanding: <span style="color: tomato;">Rs.'+numberWithCommas(order_data[0].outstanding)+'</span>');
                }
                $("#single_gst").html("GST(5%):"+numberWithCommas(order_data[0].gst_amount));
                $("#single_delivered_on").html("Delivered on: "+order_data[0].delivered_on);
                $("#single_total_amount").html("Total Amount: Rs."+numberWithCommas(order_data[0].billing_amount));
                console.log(data);
                
                
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
                        html_text += '<td>Rs.'+item_data[key].price_per_unit+'</td>';
                        html_text += '<td>'+item_data[key].units+'</td>';
                    html_text += '</tr>';
                }
                $("#item_table_body").html(html_text);
                var payment_data= data.data_payment;
                var html_text = "";
                var slno = 0;
                for (var key in payment_data) {
                    slno++;
                    html_text += '<tr>';
                        html_text += '<td>'+slno+'</td>';
                        html_text += '<td>'+payment_data[key].date_time+'</td>';
                        html_text += '<td>'+payment_data[key].mode+'</td>';
                        html_text += '<td>'+numberWithCommas(payment_data[key].paid_amout)+'</td>';
                    html_text += '</tr>';
                }
                $("#order_payment_table_body").html(html_text);
                order_table = $("#order_payment_table,#item_list_table").DataTable({
                    dom: 'Bfrtip',
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
                $("#item_list_table_filter,#order_payment_table_filter").css("display","none");
                $('#toggle').hide();
                $('#toggle1').show();
            });
        }
        function back_view_order(){
            $('#toggle1').hide();
            $('#toggle').show();
        }
        function cancel_order(){
            var token = $("#cancel_order_token").val();
            swal({
                title: "Are you sure?",
                text: "You want to cancel this order?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var datas ={
                        'order_token':token,
                        'dashboard_code':verfication_code
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url : api_path+"/admin/cancelOrder.php",
                        data: json_data,
                    }).done(function(data) {
                        if(data.code==503){
                            swal("Something happened!");
                        }else if(data.code==201){
                            swal("Order cancelled successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                            });
                        }
                    });
                }
            });
        }
    </script>
</body>
</html>
<?php
}
mysqli_close($link);
?>