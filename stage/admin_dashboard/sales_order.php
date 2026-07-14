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
    <title>Order Management</title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<style>
    a{
        cursor: pointer;
    }
    .buleline{
        border-left: 5px solid #2196F3 !important;
    }
    .dataTables_filter select.form-control{
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
    }
    div.dataTables_wrapper div.dataTables_filter {
        text-align: right;
    }
    .dataTables_filter label {
        position: relative;
        top: 0;
    }
</style>
<body>
    <div class="se-pre-con"></div>
    <header id="main-dash-header" class="dash-header">      
    </header>

    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar1"></div>
    
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
                    <div class="form-group">
                        <select name="" id="selectState" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="" id="selectCity" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="" id="selectdist" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                         <select id="orderBy" class="form-control">
                            <option value=""> Order by</option>
                            <option value="Salesrep">Sales rep</option>
                            <option value="Salesman">Salesman</option>
                            <option value="Distributor">Distributor</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <button  type="button" onclick="gobutton();" class="primary-btn" >Go</button>
                    </div>
                  </form>
            </div>
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Order Number</th>
                            <th>Distributor Name</th>
                            <th>Date & Time</th>
                            <th>Shop Name</th>
                            <th>Order Taken By</th>
                            <th>Items</th>
                            <th class="sum">Total Amount</th>
                            <th>Delivery</th>
                            <th>Delivered on</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody id="table_body_id">
                    </tbody>
                </table>
        </section>
        <section class="bg-white brad-4 full-height" id="toggle1" style="display: none;" >
            <div class="header_container">
                <div class="header-details">
                    <div class="title_box">
                        <div class="header_box">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span><span id="single_shop_name"> </span></h1>
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
            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="custom-table" id="item_list_table">
                        <thead>
                            <tr>
                                <th>SI.No</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>UOM</th>
                                <th>Product Nature</th>
                            </tr>
                        </thead>
                        <tbody id="item_table_body"></tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>    
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        var region_change="";
        var dist_change="";
        var order_by ="Salesman";
    </script>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
     <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>  
    
    <script>
        $('#fromDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            maxDate: 0,
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd-mm-yy',
            maxDate: 0,
        });
    </script>
    <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table; 
        
        $(document).ready(function () {
            data_fetch();
        });
        
        //get states
        $.ajax({
            type: "GET",
            dataType: "json",
            url: api_path + "/admin/state_list.php",
        }).done(function(datas){
            let data = datas;
            let html_text = '<option value="">Select State</option>';
            for (let key in data) {
                html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
            }
            $('#selectState').html(html_text);
        });

        //all region
        let region = { type: "allregion" };
        var json_data = JSON.stringify(region);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/scheduleSalesRep.php",
            data:json_data,
        }).done(function(datas){
            let data = datas.data;
            let html_text = '<option value="">Select Region</option>';
            for (let key in data) {
                html_text += `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
            }
            $('#selectCity').html(html_text);
        });

        //all distributor
        let dist = { type: "alldistributor" };
        var json_data = JSON.stringify(dist);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/scheduleSalesRep.php",
            data:json_data,
        }).done(function(datas){
            let data = datas.data;
            let html_text = '<option value="">Select distributors</option>';
            for (let key in data) {
                html_text += `<option value="${data[key].token}">${data[key].name}</option>`;
            }
            $('#selectdist').html(html_text);
        });

        //state change region affect
        $('#selectState').on('change',function(){
            let stateToken = $(this).find(':selected').val();
            let obj = { stateToken:stateToken, type:'stateToken' }
            var json_data = JSON.stringify(obj);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option value="">Select Region</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
                }
                $('#selectCity').html(html_text);
            });
        });
        
        //region change affect area
        $("#selectCity").on('change',function(){
            let regionToken = $(this).find(':selected').val();
            let regobj = { dashboard_code: verfication_code, regionToken:regionToken, type:'regionToken' }
            var json_data = JSON.stringify(regobj);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/retailerDetails.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option value="">Select Distributor</option>';
                data.forEach(function(item,index){
                    html_text += `<option id='areas_name' value="${item.token}">${item.name}</option>`;
                });
                $('#selectdist').html(html_text);
            });
        });


        // data fetch area function code starts   
        function data_fetch(){
            $(".se-pre-con").fadeIn();
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            
            if(from_date > to_date && to_date != "" && to_date != undefined){
                $("#toDate").val(from_date);
            }
            var to_date = $("#toDate").val();
            $(".se-pre-con").hide();
            
            var current_url = api_path + "/admin/serverSalesOrderList.php?from_date=" + from_date + "&to_date=" + to_date + "&v_id=" + verfication_code + "&state_id=" + admin_state_id + "&region_token=" + region_change + "&dist_token=" + dist_change + "&order_by=" + order_by;

            if ($.fn.DataTable.isDataTable('#table_data')) {
                // Table already exists, just reload data and reset pagination to page 1
                table.ajax.url(current_url).load(null, true);
            } else {
                // Initialize table first time
                table = $('#table_data').DataTable({
                    // stateSave: true,
                    stateSave: false,
                    "destroy": true,
                    "pageLength": 10,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                    ],
                    'ajax': {
                        'url': current_url,
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                        }
                    },
                    lengthChange: true,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    "order": [[0, "DESC" ]],
                    'columns': [
                        { data: 'order_token' },
                        { data: 'order_number' },
                        { data: 'distributor_name' },
                        { data: 'date_time' },
                        { data: 'shop_name' },
                        { data: 'sales_man' },
                        { data: 'items' },
                        { data: 'billing_amount' },
                        { data: 'delivery' },
                        { data: 'delivered_on' }
                    ],
                    dom: 'Bfrltip',
                    "drawCallback": function (settings, json) {
                        if((this.api().data().length) > 0){
                             this.api().columns('.sum').every(function () {
                                var column = this;
                                var sum = column.data().reduce(function (a, b) { 
                                    a = parseInt(a, 10); if(isNaN(a)){ a = 0; }
                                    b = parseInt(b, 10); if(isNaN(b)){ b = 0; }
                                    return a + b;
                                });
                                $(column.footer()).html('Total: ' + sum);
                            });
                        } else {
                            this.api().column('.sum').visible(false);
                        }
                    },
                    // buttons: [{
                    //     extend: 'pdfHtml5',
                    //     title: 'Sales_order:' + $('#fromDate').val() + 'to' + $('#toDate').val(), 
                    //     className: 'btn-primary buttonprint',
                    //     orientation: 'landscape',
                    //     pageSize: 'LEGAL',
                    //     footer: true,
                    //     filename: 'Sales_order' + $('#fromDate').val() + 'to' + $('#toDate').val() 
                    // }, {
                    //     extend: 'csv',
                    //     title: 'Sales_order:' + $('#fromDate').val() + 'to' + $('#toDate').val(), 
                    //     className: 'btn-info buttonprint',
                    //     orientation: 'landscape',
                    //     pageSize: 'LEGAL',
                    //     footer: true,
                    //     filename: 'Sales_order:' + $('#fromDate').val() + 'to' + $('#toDate').val() 
                    // }],
                    buttons: [{
                        extend: 'pdfHtml5',
                        title: function() {
                            var fromDate = $('#fromDate').val() ? $('#fromDate').val() : 'All';
                            var toDate = $('#toDate').val() ? $('#toDate').val() : 'All';
                            return 'Sales_order_' + fromDate + '_to_' + toDate;
                        }, 
                        className: 'btn-primary buttonprint',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        footer: true,
                        filename: function() {
                            var fromDate = $('#fromDate').val() ? $('#fromDate').val() : 'All';
                            var toDate = $('#toDate').val() ? $('#toDate').val() : 'All';
                            return 'Sales_order_' + fromDate + '_to_' + toDate;
                        },
                        action: function(e, dt, node, config) {
                            var self = this;
                            var oldLength = dt.page.len(); 
                            
                            dt.page.len(100000).draw();
                            
                            // Data fetch aagi mudichathum trigger aagum
                            dt.one('draw', function() {
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, node, config); // PDF download aagum
                                dt.page.len(oldLength).draw(); // Thirumbavum table-ah 10 rows view-ku mathiduvom
                            });
                        }
                    }, {
                        extend: 'csv',
                        title: function() {
                            var fromDate = $('#fromDate').val() ? $('#fromDate').val() : 'All';
                            var toDate = $('#toDate').val() ? $('#toDate').val() : 'All';
                            return 'Sales_order_' + fromDate + '_to_' + toDate;
                        }, 
                        className: 'btn-info buttonprint',
                        orientation: 'landscape',
                        pageSize: 'LEGAL',
                        footer: true,
                        filename: function() {
                            var fromDate = $('#fromDate').val() ? $('#fromDate').val() : 'All';
                            var toDate = $('#toDate').val() ? $('#toDate').val() : 'All';
                            return 'Sales_order_' + fromDate + '_to_' + toDate;
                        },
                        action: function(e, dt, node, config) {
                            var self = this;
                            var oldLength = dt.page.len(); 
                            
                            dt.page.len(100000).draw();
                            
                            dt.one('draw', function() {
                                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, node, config); 
                                dt.page.len(oldLength).draw();
                            });
                        }
                    }],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
                    }
                });
                table.column(0).visible(false);
            }
        }
        // datat function area code end 

        //filter change
        function gobutton(){
            admin_state_id = $("#selectState :selected").val();
            region_change = $("#selectCity :selected").val();
            dist_change = $("#selectdist :selected").val();
            order_by = $("#orderBy :selected").val();
            
            // Just call data_fetch to reload table smoothly
            data_fetch();
        }

        function date_filter(){
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            if(from_date > to_date && to_date != "" && to_date != undefined){
                $("#toDate").val(from_date);
            }
            var to_date = $("#toDate").val();
            if(from_date != "" && to_date != "" && from_date != undefined && to_date != undefined){
                 // Just call data_fetch to reload table smoothly
                data_fetch();
            }
        }
        
        var order_table_check = false;
        var order_table;
        $('#table_data tbody').on( 'click', '.view_link', function () {
            var td_div = $(this).parent().parent();
            var table_data = table.row( td_div ).data();
            var token = table_data.order_token;
            var sales_man = table_data.sales_man;
            particular_order_detail(token,sales_man)
        });
        
        function particular_order_detail(token,sales_man){
            $(".se-pre-con").show();
            var datas = {
                dashboard_code: verfication_code,
                order_token: token,
                type: "particular_order_detail"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/salesOrderDetails.php",
                data: json_data
            }).done(function(data) {
                var order_data = data.data;
                $("#single_shop_name").html(order_data[0].shop_name); 
                $("#single_order_status").html(order_data[0].delivery);
                $("#single_order_token").html(order_data[0].order_number);
                $("#single_order_date").html("Date & Time: <span class='label_value'>"+order_data[0].date_time+"</span>");
                $("#single_salesman_name").html("Order Taken By: <span class='label_value'>"+sales_man+"</span>");
                $("#single_items").html("Items: <span class='label_value'>"+order_data[0].items+"</span>");
                if(order_data[0].delivery_value == "Cancelled"){
                    $("#single_delivered_on").html("Cancelled on: <span class='label_value'>"+order_data[0].delivered_on+"</span>");
                }else{
                    $("#single_delivered_on").html("Delivered on: <span class='label_value'>"+order_data[0].delivered_on+"</span>");
                }
                
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
                        if(item_data[key].is_free == '0'){
                            html_text += '<td>Pay Product</td>';
                        }else{
                            html_text += '<td>Free Product</td>';
                        }
                    html_text += '</tr>';
                }
                $("#item_table_body").html(html_text);
                
                order_table = $("#item_list_table").DataTable({
                    lengthChange:true,
                    dom: 'lrtip',
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
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
                $("#item_list_table_filter").css("display","none");
                 $(".se-pre-con").hide();
                $('#toggle').hide();
                $('#toggle1').show();
            });
        }
        
        // #function back view ordercode starts
        function back_view_order(){
            $('#toggle1').hide();
            $('#toggle').show();
        }
        // function back view code end 
    </script>
</body>
</html> 
<?php
}
mysqli_close($link);
?>