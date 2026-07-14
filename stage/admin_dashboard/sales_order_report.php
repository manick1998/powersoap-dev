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
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/salesreport.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head> 
<style>
    a{
        cursor: pointer;
    }
    .greenline{
        border-left: 5px solid #5aafd8 !important;
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
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff;
        background-color: #00b9f5 !important;
    }
    .pdf-btn {
        background: #bc87f0 !important;
        padding: 6px 15px;
        border-radius: 4px;
    }
    .product_list button {
        margin: 0 10px;
    }
    .nav-item button {
        width: auto;
        height: 50px;
    }
    .nav-blue {
        color: #fff;
        background-color: #00b9f5 !important;
    }
    .dt-buttons.btn-group {
        margin-left: 1.4rem;
    }
    .form-group > .form-control {
        width:100%;
    }
    .dataTables_filter form {
    gap: 1rem;
    }
    .view_link {
        color:#060707 !important;
        cursor: unset;
    }
    .dataTables_filter label {
        top: 60px !important;
    }
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
                        <h1 class="header_main">Sales Order Report</h1>
                    </div>
                    <p class="table_count" style="display: none;">Total Order Report - <span id="total_order_count"></span></p>
                </div>
            </div>
            <div class="dataTables_filter">
               <form class="formdield">
                    <div class="form-group">
                        <select id="orderType" class="form-control">
                            <option value="">Order type</option>
                            <option value="Distributor Order">Distributor Order</option>
                            <option value="Sales Order">Sales Order</option>
                            <option value="Spot Order">Spot Order</option>
                            <option value="Retailer Order">Retailer order</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: none;"> 
                        <input class="form-control box_form" name="date" id="fromDate" type="text"  placeholder="From Date" readonly>
                    </div>
                    <div class="form-group" style="display: none;">
                        <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date"  readonly>
                    </div>
                    <div class="form-group" style="display: none;">
                         <select id="orderStatus" class="form-control">
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                         <select id="selectState" class="form-control">
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                         <select id="selectRegion" class="form-control">
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                         <select id="distributor" class="form-control">
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                         <select id="orderBy" class="form-control">
                            <option value=""> Order by</option>
                            <option value="Salesrep">Sales rep</option>
                            <option value="Salesman">Salesman</option>
                            <option value="Distributor">Distributor</option>
                            <option value="Retailer">Retailer</option>
                            <option value="Overall">Overall</option>
                        </select>
                    </div>
                    <div class="form-group" style="display: none;">
                        <button type="button"  class="primary-btn" >Go</button>
                    </div>
                </form>
            </div>
            <!-- Nav tabs -->
<!--
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button  class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                </li>
            </ul>
-->
            <!-- <div class="table-box"> -->
            <table class="custom-table" id="table_data" style="display: none;">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order Number</th>
                        <th>Date & Time</th>
                        <th>Distributor</th>
                        <th>Items</th>
                        <th>Delivery</th>
                        <th class="sum">Order Amount</th>
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
                        </tr>
                    </tfoot>
                <tbody id="table_body_id">
                </tbody>
            </table>
            <table class="custom-table" id="sales_table_data" style="display: none;">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order Number</th>
                        <th>Distributor Name</th>
                        <th>Date & Time</th>
                        <th>Shop Name</th>
                        <th>Order Taken By</th>
                        <th>Items</th>
                        <th>Delivery</th>
                        <th class="sum">Order Amount</th>
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
                        </tr>
                    </tfoot>
                <tbody id="table_body_id_2">
                </tbody>
            </table>
            <table class="custom-table" id="retailer_table_data" style="display: none;">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Order Number</th>
                        <th>Date & Time</th>
                        <th>Shop Name</th>
                        <th>Distributor Name</th>
                        <th>Items</th>
                        <th>Delivery</th>
                        <th class="sum">Order Amount</th>
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
                        </tr>
                    </tfoot>
                <tbody id="table_body_id_3">
                </tbody>
            </table>
        </section>
    </main>    
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>

     <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
     <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>  
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        var region_change="";
        var dist_change="";
        $('#fromDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd'
        });
        $('#toDate').datepicker({
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'yy-mm-dd'
        });
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table; 
        $(document).ready(function () {
            $('#orderType').on('change',function(){
                 $("#orderStatus").html(`<option value="">Order status</option>
                            <option value="Approved">Approved</option>
                            <option value="Pending">Pending</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Completed">Completed</option>
                            <option value="Overall">Overall</option>`);
                if($('#orderType').val() == 'Distributor Order'){
                    $("#fromDate,#toDate,#orderStatus,#selectState").parent('div').css("display","block");
                    $("#selectRegion,#distributor,#orderBy,.primary-btn").parent("div").css("display","none");
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion,#distributor,#orderBy").val("");
                }else if($('#orderType').val() == 'Sales Order'){
                    $(".primary-btn").parent("div").css("display","none");
                    $("#fromDate,#toDate,#orderStatus,#selectState").parent("div").css("display","block"); 
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion,#distributor,#orderBy").val("");
                }else if($('#orderType').val() == 'Spot Order'){
                    $("#orderStatus").html(`<option value="">Order status</option><option value="Completed">Completed</option>`);
                    $("#orderBy").html(`<option value="" selected>Deliveryman</option>`);
                    $(".primary-btn").parent("div").css("display","none");
                    $("#fromDate,#toDate,#orderStatus,#selectState").parent("div").css("display","block"); 
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion,#distributor,#orderBy").val("");  
                }else if($('#orderType').val() == 'Retailer Order'){
                    $("#orderStatus").html(`<option value="">Order status</option><option value="Pending">Pending</option> <option value="Cancelled">Cancelled</option><option value="Completed">Completed</option>`);
                    $(".primary-btn").parent("div").css("display","none");
                    $("#fromDate,#toDate,#orderStatus,#selectState").parent("div").css("display","block"); 
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion").val("");
                }else{
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion,#distributor,#orderBy,.primary-btn").parent("div").css("display","none"); 
                    $("#fromDate,#toDate,#orderStatus,#selectState,#selectRegion,#distributor,#orderBy").val("");
                }
            });
            $(".se-pre-con").hide();
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

        //region
        $('#selectState').on('change',function(){
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
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option value="">Select Region</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].token}">${data[key].region_name}</option>`;
                }
                $('#selectRegion').html(html_text);
                if($('#orderType').val() == 'Sales Order' || $('#orderType').val() == 'Spot Order'|| $('#orderType').val() == 'Retailer Order' ){
                 $("#selectRegion").parent("div").css("display","block");
                }else{
                    $("#selectRegion,#distributor,#orderBy").parent("div").css("display","none");
                    $(".primary-btn").parent("div").css("display","block");
                }
            });
       });
        //distributor
       $('#selectRegion').on('change',function(){
          let dist = {
               dashboard_code: verfication_code,
               type: "distributor",
               region_id: $("#selectRegion").val()
            };
            var json_data = JSON.stringify(dist);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/filterReportDropDown.php",
                data:json_data,
            }).done(function(datas){
                if(datas.code == 201 && ($('#orderType').val() != 'Retailer Order')){
                    let data = datas.data;
                    let html_text = '<option value="">Select distributors</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].token}">${data[key].dist_name}</option>`;
                    }
                    $('#distributor').html(html_text);
                    $("#distributor,#orderBy,.primary-btn").parent("div").css("display","block");
                }else if($('#orderType').val() == 'Retailer Order'){
                    $(".primary-btn").parent("div").css("display","block");
                }else{
                   swal("Distributor not found");
                   $('#distributor').html(''); 
                   $("#distributor,#orderBy,.primary-btn").parent("div").css("display","none");
                }
            });
       });
    //    $('#distributor').on('change',function(){
    //       $("#orderBy,.primary-btn").parent("div").css("display","block"); 
    //    });    
       $(".primary-btn").click(function(){
           if($('#orderType').val() == 'Sales Order' || $('#orderType').val() == 'Spot Order'){
                 $("#table_data_wrapper").css("display","none");
                 $("#sales_table_data").css("display","table");
                 sales_data_fetch();
            }else if($('#orderType').val() == 'Distributor Order'){     
                 $("#sales_table_data_wrapper").css("display","none");
                 $("#table_data").css("display","table");
                 distributor_data_fetch();
            }else if($('#orderType').val() == 'Retailer Order'){     
                 $("#sales_table_data_wrapper").css("display","none");
                 $("#retailer_table_data").css("display","table");
                 retailer_data_fetch();
            }
       });
       function distributor_data_fetch(){
            $(".se-pre-con").fadeIn();
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            var orderType   = $("#orderType").val();
            var orderStatus   = $("#orderStatus").val();
            var state   = $("#selectState").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            if(from_date != '' && to_date != '' && orderType != '' && orderStatus != '' && state !=''){
                table = $('#table_data').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                    ],
                    'ajax': {
                        'url':api_path+"/admin/serverSalesOrderReport.php",
                        'data': function (d) {
                            d.from_date = from_date;
                            d.to_date = to_date;
                            d.v_id = verfication_code;
                            d.orderType = orderType;
                            d.status = orderStatus;
                            d.state = state;
                        }, 
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                            }
                        },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                    "order": [[0, "DESC" ]],
                    'columns': [
                        { data: 'order_token' },
                        { data: 'order_number' },
                        { data: 'date_time' },
                        { data: 'sales_man' },
                        { data: 'items' },
                        { data: 'delivery' },
                        { data: 'billing_amount' }
                    ],
                    dom: 'Bfrltip',
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
                    },
                    destroy: true,
                    searching: true,
               "drawCallback": function (settings, json) {
                   if((this.api().data().length) > 0){
                 this.api().columns('.sum').every(function () {
                    var column = this;

                    var sum = column
                    .data()
                    .reduce(function (a, b) { 
                        a = parseInt(a, 10);
                        if(isNaN(a)){ a = 0; }
                        
                        b = parseInt(b, 10);
                        if(isNaN(b)){ b = 0; }
                        
                        return a + b;
                    });
                    $(column.footer()).html('Total: ' + sum);
                });
            }else{
                // this.api().clear('.sum');
                table.column('.sum').visible(false);
            }
            },
                    buttons: [{
                                extend: 'pdfHtml5',
                                footer:true,
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                footer:true,
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             }],
                });
                table.column(0).visible(false);
                $(".table_count").css("display","block");
            }else{
                swal('Please select all dropdown value');
                $(".table_count").css("display","none");
            }
            $(".se-pre-con").fadeOut();
        }
        
        function sales_data_fetch(){
            $(".se-pre-con").fadeIn();
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            var orderType   = $("#orderType").val();
            var orderStatus   = $("#orderStatus").val();
            var state   = $("#selectState").val();
            var region = $("#selectRegion").val();
            var distributor = $("#distributor").val();
            var orderBy = $("#orderBy").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            if(from_date != '' && to_date != '' && orderType != '' && orderStatus != '' && state != '' && region != ''){
                table = $('#sales_table_data').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                    ],
                    'ajax': {
                        'url':api_path+"/admin/serverSalesOrderReport.php",
                        'data': function (d) {
                            d.from_date = from_date;
                            d.to_date = to_date;
                            d.v_id = verfication_code;
                            d.orderType = orderType;
                            d.status = orderStatus;
                            d.state = state;
                            d.region = region;
                            d.distributor = distributor;
                            d.orderBy = orderBy;
                        }, 
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                            }
                        },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                    "order": [[0, "DESC" ]],
                    'columns': [
                        { data: 'order_token' },
                        { data: 'order_number' },
                        { data: 'distributor_name' },
                        { data: 'date_time' },
                        { data: 'shop_name' },
                        { data: 'sales_man' },
                        { data: 'items' },
                        { data: 'delivery' },
                        { data: 'billing_amount' }
                    ],
                    dom: 'Bfrltip',
                    // language: {
                    //     search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
                    // },
                    
                    destroy: true,
                    searching: true,
                    "drawCallback": function (settings, json) {
                   if((this.api().data().length) > 0){
                 this.api().columns('.sum').every(function () {
                    var column = this;

                    var sum = column
                    .data()
                    .reduce(function (a, b) { 
                        a = parseInt(a, 10);
                        if(isNaN(a)){ a = 0; }
                        
                        b = parseInt(b, 10);
                        if(isNaN(b)){ b = 0; }
                        
                        return a + b;
                    });
                    $(column.footer()).html('Total: ' + sum);
                });
            }else{
                // this.api().clear('.sum');
                table.column('.sum').visible(false);
            }
            },
                    buttons: [{
                                extend: 'pdfHtml5',
                                footer:true,
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7,8]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                footer:true,
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7,8]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             }],
                    language: {
                search: '<img src="assets/svg/Search_icon.svg">',
                searchPlaceholder: "Search",
                paginate: {
                    next: '<img src="assets/svg/Right_arrow_icon.svg">',
                    previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
                table.column(0).visible(false);
                $(".table_count").css("display","block");
            }else{
                swal('Please select all dropdown value');
                $(".table_count").css("display","none");
            }
            $(".se-pre-con").fadeOut();
        }
        function retailer_data_fetch(){
            $(".se-pre-con").fadeIn();
            var from_date = $("#fromDate").val();
            var to_date   = $("#toDate").val();
            var orderType   = $("#orderType").val();
            var orderStatus   = $("#orderStatus").val();
            var state   = $("#selectState").val();
            var region = $("#selectRegion").val();
            if(from_date>to_date && to_date!="" && to_date!=undefined){
                $("#toDate").val(from_date);
            }
            var to_date   = $("#toDate").val();
            if(from_date != '' && to_date != '' && orderType != '' && orderStatus != '' && state != '' && region != ''){
                table = $('#retailer_table_data').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [
                        { "bSortable": false, "aTargets": [ 0 ] }
                    ],
                    'ajax': {
                        'url':api_path+"/admin/serverSalesOrderReport.php",
                        'data': function (d) {
                            d.from_date = from_date;
                            d.to_date = to_date;
                            d.v_id = verfication_code;
                            d.orderType = orderType;
                            d.status = orderStatus;
                            d.state = state;
                            d.region = region;
                        }, 
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                            }
                        },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                    "order": [[0, "DESC" ]],
                    'columns': [
                        { data: 'order_token' },
                        { data: 'order_number' },
                        { data: 'date_time' },
                        { data: 'shop_name' },
                        { data: 'sales_man' },
                        { data: 'items' },
                        { data: 'delivery' },
                        { data: 'billing_amount' }
                    ],
                    dom: 'Bfrltip',
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
                    },
                    destroy: true,
                    searching: true,
                    "drawCallback": function (settings, json) {
                   if((this.api().data().length) > 0){
                 this.api().columns('.sum').every(function () {
                    var column = this;

                    var sum = column
                    .data()
                    .reduce(function (a, b) { 
                        a = parseInt(a, 10);
                        if(isNaN(a)){ a = 0; }
                        
                        b = parseInt(b, 10);
                        if(isNaN(b)){ b = 0; }
                        
                        return a + b;
                    });
                    $(column.footer()).html('Total: ' + sum);
                });
            }else{
                // this.api().clear('.sum');
                table.column('.sum').visible(false);
            }
            },
                    buttons: [{
                                extend: 'pdfHtml5',
                                footer:true,
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                footer:true,
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [1,2,3,4,5,6,7]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             }],
                });
                table.column(0).visible(false);
                $(".table_count").css("display","block");
            }else{
                swal('Please select all dropdown value');
                $(".table_count").css("display","none");
            }
            $(".se-pre-con").fadeOut();
        }
</script>
</body>
</html> 
<?php
}
mysqli_close($link);
?>