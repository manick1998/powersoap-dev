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
    <link rel="stylesheet" href="css/daily-summary.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
<style>
    #item_list_table_wrapper .dataTable, #item_list_table_wrapper .dataTables_scrollHeadInner {
        width: 100% !important;
    }
    .dataTables_scrollHeadInner{
        width: 100% !important;
    }
    .table-checkbox{
        width: 16px;
        aspect-ratio: 1;
        vertical-align: top;
        cursor: pointer;
        margin-right: 12px;
    }
</style>
</head>
<body>
    <div class="se-pre-con" style="display: block;"></div>

     <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar33"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="daily_summary" >
            <div class="header_container">
                <div class="header-section">
                    <h1 class="header_main">Loading Sheet</h1>
                </div>
            </div>
            <div class="dataTables_filter">
                <form class="formdield">
                    <div class="form-group field_data"> 
                        <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()" type="text"  placeholder="From Date" readonly>
                    </div>
                    <div class="form-group field_data">
                        <input class="form-control box_form" name="date" id="toDate" onchange="date_filter()" type="text" placeholder="To Date" readonly>
                    </div>
                </form>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date Value</th>
                            <th>Order Token</th>
                            <th>Employee Token</th>
                            <th>Date</th>
                            <th>Employee Name</th>
                            <th>Area</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_id">
                    </tbody>
                </table>
            </div>
        </section>

        <section class="bg-white brad-4 full-height" id="daily_summary_view" style="display: none;">
            <div class="header_container">
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
            <div class="employee_header_container">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                <button class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Shop List</button>
                </li>
                <li class="nav-item" role="presentation">
                <button class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">SKU List</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    
                <div class="items_list sameway">
                    <div class="total_sales col-lg-2">
                        <p>Total Items </p>
                        <span class="total_item_id"></span>
                    </div>
                    <div class="total_sales col-lg-4" id="orderedShops">
                       
                    </div>
                </div>
                    <div class="table-box">
                        <table class="custom-table" id="shop_list_table">
                            <thead>
                                <tr>
                                <th><input type="checkbox" class="table-checkbox mr-2"> SI.No</th>
                                    <th>Shop Name</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Sales</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="shop_table_body">
                            </tbody>
                            <p id="GFG_DOWN"></p>
                        </table>
                    </div>
                </div>

            <!-- <div class="employee_header_container">
                <div class="items_list sameway">
                    <div class="total_sales col-lg-2">
                        <p>Total Items </p>
                        <span class="total_item_id">24</span>
                    </div>
                    <div class="total_sales col-lg-4" id="orderedShops">
                        <button class="btn_button" onclick="orderedShopList()" data-value="" id="shopListBtn">Generate Loading Sheet</button>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="shop_list_table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="table-checkbox mr-2"> SI.No</th>
                                <th>Shop Name</th>
                                <th>Type</th>
                                <th>Items</th>
                                <th>Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="shop_table_body">
                        </tbody>
                    </table>
                </div>
           </div> -->
        </section>

        <section class="bg-white brad-4 full-height" id="shoplist_details" style="display: none;" >
            <div class="header_container">
                <div class="header-details">
                    <div class="title_box">
                        <div class="header_box">
                        <h1 class="header_main"><span><img src="assets/back.png" class="back_btn" alt="" onclick="hide_shoplist()"></span><span id="shop_name_id"></span></h1>
                            <p class="table_count " id="order_token_num"  style="margin-left: 60px;"></p>
                        </div>
                    </div>
                </div> 
            </div>

            
            <div class="employee_header_container">
                <div class="items_list">
                    <div class="total_sales total_sales_dummy col-lg-4 col-md-6 col-sm-6">
                        <p>Date</p>
                        <span id="view_date_id"></span>
                    </div>
                    <div class="total_sales total_sales_dummy col-lg-4 col-md-6 col-sm-6">
                        <p>Total Items</p>
                        <span id="total_items_id">/span>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent" >
                    <div class="table-box">
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
            </div>
    </section>
    </main>
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
     var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
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
    
    function hide_shoplist(){
      $('#daily_summary_view').show(); 
      $('#shoplist_details').hide();  
      $('#daily_summary').hide();   
    }
    // function view_skulist(){
    //   $('#Skulist_view').show();  
    //   $('#daily_summary').hide();  
    //   $('#daily_summary_view').hide();  
    // }
    // function hide_skulist(){
    //   $('#daily_summary_view').show(); 
    //   $('#Skulist_view').hide();  
    //   $('#daily_summary').hide();   
    // }
</script>
<script>
    var verfication_code = "<?php echo $verification_code; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    var distributor_name = "<?php echo $_SESSION['distributor_name'] ?>";
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
            order: [[0, 'desc']],
            'ajax': {
                'url':api_path+"/distributor/server_daily_summary.php?from_date="+from_date+"&&to_date="+to_date+"&&v_id="+verfication_code+"&&dist_id="+distributor_token
            },
            'columns': [
                { data: 'slno' },
                { data: 'date_value' },
                { data: 'order_token' },
                { data: 'employee_token' },
                { data: 'date_time' },
                { data: 'employee_name' },
                { data: 'location_name' },
                { data: 'deparment_name' }
              
            ],
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
            }
        });
        table.columns([0,1,2,3]).visible(false);
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

    var date_time;
    var date_value;    
    var employee_token; 
    var order_token;
    var outlet;
    var department_name;
    var location_name;
    $('#table_data tbody').on( 'click', '.view_link', function () {
        var td_div = $(this).parent().parent();
        var table_data = table.row( td_div ).data();
        date_time = table_data.date_time;
        date_value = table_data.date_value;
        order_token = table_data.order_token;
        employee_token = table_data.employee_token;
        outlet = table_data.outlet;
        department_name = table_data.deparment_name;
        location_name = table_data.location_name;
        particular_date_emp_detail();
    });
    var summary_date;
    var shop_table_check = false;
    var shop_data;
    var item_data
    var shop_table;
    var shop_table_item;
    function particular_date_emp_detail(){
        $(".se-pre-con").show();
        summary_date = date_time.substr(22,10);
        $("#single_view_date").html(summary_date);
        $("#single_outletscovered").html("Outlets Covered - "+outlet);
        $('#daily_summary').hide();
        $('#daily_summary_view').show();
        var datas = {
            dashboard_code: verfication_code,
            distributor_token:distributor_token,
            selected_date: date_value,
            employee_token: employee_token,
            order_token: order_token,
            type: "particular_date_detail"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/employeeDailySummary.php",
            data: json_data
        }).done(function(data) {
            if(shop_table_check){
                shop_table.clear();
                shop_table.destroy();
                shop_table_item.clear();
                shop_table_item.destroy();
            }
            var total_items = 0;
            shop_data = data.data;
            //console.log(shop_data);
            var html_text = "";
            var slno = 0;
            for (var key in shop_data) {
                slno++;
                html_text += '<tr>';
                    html_text += '<td><input class="table-checkbox" type="checkbox" name="check" value="'+shop_data[key].shop_name+'">'+slno+'</td>';
                    html_text += '<td>'+shop_data[key].shop_name+'</td>';
                    html_text += '<td>'+shop_data[key].shop_type+'</td>';
                    html_text += '<td>'+shop_data[key].items+'</td>';
                    html_text += '<td>'+shop_data[key].bill_amount+'</td>';
                    html_text += '<td><a class="view_link" onclick="view_shoplist('+key+')">View Detail</a></td>';
                    html_text += '</tr>';
            }
            $("#shop_table_body").html(html_text);
            invoice_file_load = data.invoice_file;
            var productBtn = "";
            var shopBtn = "";
            if(department_name == "Sales"){
                 shopBtn +=' <button class="btn_button" onclick="orderedShopList()" data-value="'+invoice_file_load.shop_list+'" id="shopListBtn">Generate Shop List</button>';
                productBtn +='<button class="btn_button" onclick="orderedProductLoading()" data-value="'+invoice_file_load.product_list+'" id="productLListBtn">Generate Loading Sheet</button>'; 
            }
            $("#orderedShops").html(shopBtn);
            $("#orderedProducts").html(productBtn);
            
            item_data = data.data_item;
            var html_text = "";
            var slno1 = 0;
            for (var key in item_data) {
                slno1++;
                html_text += '<tr>';
                    html_text += '<td>'+slno1+'</td>';
                    html_text += '<td>'+item_data[key].item_name+'</td>';
                    html_text += '<td>'+item_data[key].quantity+'</td>';
                    html_text += '<td>'+item_data[key].units+'</td>';
                    html_text += '<td>'+item_data[key].sales+'</td>';
                html_text += '</tr>';
            }
            total_items = slno1;
            $("#item_table_body").html(html_text);
         
            $(".total_item_id").html(total_items);
            shop_table = $("#shop_list_table").DataTable({
                scrollX: true,
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
            shop_table.columns.adjust().draw(); 
            shop_table_item = $("#item_list_table").DataTable({
                scrollX: true,
//                "initComplete": function (settings, json) {  
//                    $("#item_list_table").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
//                },
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
            shop_table_item.columns.adjust().draw(); 
           shop_table_check = true;
            $(".se-pre-con").hide();
        });  
    }
    
    
    var shop_item_table;
    var shop_item_table_check=false;
    function view_shoplist(key){
        if(shop_item_table_check){
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
            url : api_path+"/distributor/employeeDailySummary.php",
            data: json_data
        }).done(function(data) {
            var shop_item_data = data.data;
            var html_text = "";
            var slno1 = 0;
            for (var key in shop_item_data) {
                slno1++;
                html_text += '<tr>';
                    html_text += '<td>'+slno1+'</td>';
                    html_text += '<td>'+shop_item_data[key].item_name+'</td>';
                    html_text += '<td>'+shop_item_data[key].item_code+'</td>';
                    html_text += '<td>'+shop_item_data[key].quantity+'</td>';
                    html_text += '<td>'+shop_item_data[key].units+'</td>';
                html_text += '</tr>';
            }
            $("#shop_item_table_body").html(html_text);
            $("#total_items_id").html(slno1);
            $('#shoplist_details').show();  
            $('#daily_summary').hide();  
            $('#daily_summary_view').hide(); 
            shop_item_table = $("#shop_item_table").DataTable({
                scrollX: true,
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
            $("#shop_item_table_filter").css("display","none");
            shop_item_table_check = true;
        })
    }
    
    function orderedProductLoading(){
        swal({
            title: "Are you sure?",
            text: "You want to generate loading sheet?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
           $('#productLListBtn').prop('disabled', true);
           var loadFileName = $("#productLListBtn").attr("data-value");
           var datas = {
                dashboard_code: verfication_code,
                distributor_token:distributor_token,
                selectedorder_date: date_value,
                employee_token: employee_token,
                distributor_name: distributor_name,
                order_token: order_token,
                loadFileName: loadFileName
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "../TCPDF-main/examples/orderLoadingSheet.php",
                data: json_data
            }).done(function(data) {
                swal("Loading Sheet Created successfully!", {icon: "success"}).then((value) => {
                             window.open('../invoice_pdf/'+data.data, '_blank');
                        });
                particular_date_emp_detail();
            });
        }
        });
    }
    
    function orderedShopList(){
        var selected=[];
         $("input:checkbox[name=check]:checked").each(function() {
            selected.push($(this).val());
  });
         swal({
            title: "Are you sure?",
            text: "You want to generate shop list?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
           $('#shopListBtn').prop('disabled', true);
           var loadFileNameShop = $("#shopListBtn").attr("data-value");
           var shop_name=selected;
           var datas = {
                dashboard_code: verfication_code,
                distributor_token:distributor_token,
                selectedorder_date: date_value,
                location_name: location_name,
                loadFileNameShop: loadFileNameShop,
                selected:shop_name,
                order_token: order_token
            };
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : "../TCPDF-main/examples/unitLoadingSheet.php",
                data: json_data
            }).done(function(data){
                console.log(data);
                swal("Shop List Created successfully!", {icon: "success"}).then((value) => {
                             window.open('../invoice_pdf/'+data.data, '_blank');
                        });
                particular_date_emp_detail();
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