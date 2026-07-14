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
    <title>Product list</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select2.min.css<?php echo $js_cache_string; ?>">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>

</head>
<style>
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #ccc !important;
                outline: 0;
}
.select2-container--default .select2-selection--multiple{
    border: 1px solid #ccc !important;
}
a {
    cursor: pointer;
}

.header-details {
    display: flex;
    align-items: center;
}

.product_header_container .header-details h1 {
    padding: 20px 32px;
}

.a_button {
    color: #00b9f5 !important;
}
#item_code_color{
    color:red;
}
.modal-footer .deactive-btn {
    font: 16px var(--semibold-font);
    width: 140px;
    height: 40px;
    border: 1px solid #F44336;
    border-radius: 2px;
    background-color: #f44336;
    color: #fff;
    outline: none;
    text-transform: uppercase;
    -webkit-transition: .3s;
    transition: .3s;
}
.modal-footer .deactive-btn:hover {
    color: #F44336;
    background-color: transparent;
}
.chosen-container-single .chosen-single {
    position: relative;
    display: block;
    overflow: hidden;
    padding: 0px 5px;
    height: 23px;
    border: none;
    border-radius: 4px;
    background-color: transparent;
    box-shadow: none;
    color: #444;
    text-decoration: none;
    white-space: nowrap;
    line-height: 22px;
}

.header-section {
    width: 100%;
}

.inventory-top {
    width: 80%;
}

.view_link1 {
    font: 16px var(--semibold-font);
    color: #00B9F5 !important;
    margin-right: 20px;
    cursor: pointer;
    text-decoration: underline;
}

.view_link2 {
    font: 16px var(--semibold-font);
    color: #28ce7e !important;
    margin-right: 20px;
    cursor: pointer;
    text-decoration: underline;
}

.flex-set {
    display: flex;
}
.pdf-btn {
    background: #bc87f0 !important;
    padding: 8px 15px;
    border-radius: 4px;
    color: #fff !important;
    border: 1px solid #bc87f1 !important;
}
.cust-select-box {
    margin-left: 15px;
    width: 150px;
}

.ui-datepicker {
    z-index: 9999 !important;
}

.field_data {
    margin-right: 35px;
}
input#btndeactive {
    font: 16px var(--semibold-font);
    width: 130px;
    height: 40px;
    border: 1px solid #f54336;
    border-radius: 2px;
    background-color: #f44336;
    color: #fff;
    outline: none;
    text-transform: uppercase;
    -webkit-transition: .3s;
    transition: .3s;
}
.upload_file {
    cursor: pointer;
}
.module-option {
    width: 33.33%;
    padding: 0px 5px;
}
.module-option label {
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    position: relative;
}
.modal-input:checked ~ .cust-checkbox {
    background-color: #51c568;
    border-color: #51c568;
    animation-name: input-animate;
    animation-duration: 0.7s;
}
    .modal-dialog-scrollable {
    height: calc(100% - 1rem);
    }
    .modal-dialog-scrollable .modal-body {
    overflow-y: auto;
    flex: 1 1 auto;
    }
    .bodyheight{
    height: 400px;
    }
    /* image upload  */
    .custom-file {
        display: block;
        width: 180px;
        height: 40px;
        border: #00b9f5 1px solid;
        color: #00b9f5;
        border-radius: 4px;
        cursor: pointer;
    }
    .custom-file h5 {
        text-align: center;
        line-height: 35px;
        font-size: 18px;
    }
    .custom-file span {
        padding-top: 20px;
    }
    .img---uplod {
        display:flex;
        flex-direction: column;

    }
    /* width */
    .bodyheight::-webkit-scrollbar {
    width: 10px;
    display: block;
    }

    /* Track */
    .bodyheight::-webkit-scrollbar-track {
    background: #f1f1f1;
    }

    /* Handle */
    .bodyheight::-webkit-scrollbar-thumb {
    background: #2196F3;
    }
    /* Handle on hover */
    .bodyheight::-webkit-scrollbar-thumb:hover {
    background: #00bcd4;
    }

    @media (min-width: 576px){
    .modal-dialog-scrollable {
        height: calc(100% - 3.5rem);
    }
    }

    .cust-checkbox {
        width: 18px;
        height: 18px;
        border: 1px solid #51c568;
        border-radius: 3px;
        display: inline-block;
        position: relative;
        transition: 0.4s;
    }
    .modal-input:checked ~ .cust-checkbox::before {
        content: '';
        display: inline-block;
        width: 12px;
        height: 5px;
        border-bottom: 2px solid #fff;
        border-left: 2px solid #fff;
        transform: scale(1) rotate(-45deg);
        position: absolute;
        top: 4px;
        left: 2px;
        transition: 0.4s;
    }
    .remove-btn {
        font: 16px var(--semibold-font);
        width: 160px;
        height: 40px;
        border: 1px solid #f54336;
        border-radius: 6px;
        background-color: #f44336;
        color: #fff;
        outline: none;
        text-transform: uppercase;
        -webkit-transition: .3s;
        transition: .3s;
    }
    #removeGiftField{
        margin: 15px 0;
    }
    .remove-btn:hover {
        background-color: #fff;
        color: #f44336;
    }
    .modal-footer .createScheme-btn{
        font:16px var(--semibold-font);
        width: 150px;
        height: 40px;
        border: 1px solid #00B9F5;
        border-radius: 2px;
        background-color: #00B9F5;
        color: #fff;
        outline: none;
        text-transform: uppercase;
        -webkit-transition: .3s;
        transition: .3s;
    }
    .modal-footer .createScheme-btn:hover {
        color: #00B9F5;
        background-color: transparent;
    }

    .product_list button {
        margin-left: 0px;
    }
    .main-contents .nav {
        width: 72%;
        gap: 20px;
        margin-left: 30px;
    }
    .dt-buttons.btn-group {
        margin-left: 0px;
    }
    .dataTables_filter label {
        top: -40px !important;
    }
    .formdield {
        gap: 10px;
    }
    .dataTables_filter .form-control {
        width: 200px !important;
    }
    #product{
        display: none;
    }
    /* multi select */
    .select2-container{
        margin-right: 10px;
    }
    .select2-container--default .select2-selection--multiple {
    height: 58px;
    overflow-y: auto;
}
.select2-selection--multiple::-webkit-scrollbar {
	width: 3px;
    display: block;
}
.select2-selection--multiple::-webkit-scrollbar-track {
	background-color: rgb(255, 255, 255);
	-webkit-border-radius: 1px;
}
.select2-selection--multiple::-webkit-scrollbar-thumb:vertical {
	background-color: rgb(142, 142, 142);
	-webkit-border-radius: 0px;
    -webkit-width:5;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    margin-left: 5px;
}
.select2-selection--multiple::-webkit-scrollbar-thumb:vertical:hover {
	background: rgba(0, 245, 255, 0.65);
}
span {
    padding: 0;
}
.form-control {
    margin: 20px 0;
}
.dataTables_filter select.form-control{
    border: 1px solid var(--primary-color);
    color: var(--primary-color);
}
.singleSelect{
    border: 1px solid #ccc;
    padding: 10px;
    border-radius: 6px;
    margin: 0px 10px 0px 0;
    height: 58px;
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
        <section class="bg-white brad-4 full-height" id="toggle5">
            <div class="product_header_container">
                <div class="header-details ">
                    <h1 class="header_main">Sales Order Count</h1>
                    <p class="table_count">Total - <span id="total_count">0</span></p>
                    <p class="table_count1" hidden>Total - <span id="total_count1">0</span></p>
                </div>
            </div>
            <!-- Nav tabs -->
            <div class="dataTables_filter">
             <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate"  type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate"  type="text" placeholder="To Date" readonly>
                        </div>
                    </form>

                    <form class="formdield">
                    <div class="form-group">
                         <select id="selectState" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                         <select id="selectRegion" class="form-control">
                            <option value="">Select Region</option>
                        </select>
                    </div>
                    <!-- <div class="form-group">
                         <select id="distributor" class="form-control">
                         <option value="">Select Distributor</option>
                        </select>
                    </div> -->
                        <div class="form-group">
                            <button id="stateGoBtn" type="button"  class="primary-btn" >Go</button>
                        </div>
                    </form>
                    <!-- <ul class="nav nav-pills mb-3 mt-3 ml-4" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Order Placed</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">No Order</a>
                </li>
            </ul> -->

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <th>Disrtibutor</th>
                                <th>State</th>
                                <th>Region</th>
                                <th>Order Taken Shop Count</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody id="table_body"></tbody>
                    </table>
                </div>
                <div class="tab-pane  fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <th>Disrtibutor</th>
                                <th>State</th>
                                <th>Region</th>
                                <th>Order Taken Shop Count</th>
                            </tr>
                        </thead>
                        <tbody id="table_body1"></tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>


    <!-- jquery CDN -->
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
    <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
    <script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>

    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

   <script>
    // PREVENT DATATABLES ALERT POPUPS GLOBALLY
    $.fn.dataTable.ext.errMode = 'none';

    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table1;
    var fromDate;
    var toDate;
    
    $(".se-pre-con").hide();

    //date picker
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#datePicker').attr('min',today);
    
    $('#fromDate').datepicker({
        autoclose: true,
        todayHighlight: true,
        maxDate:0,
        dateFormat: 'yy-mm-dd'
    });
    $('#toDate').datepicker({
        autoclose: true,
        todayHighlight: true,
        maxDate:0,
        dateFormat: 'yy-mm-dd'
    });

    $(document).ready(function() {
        //allstate
        let state = {
            type: "allstate",
        };
        var json_data = JSON.stringify(state);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/scheduleSalesRep.php",
            data:json_data,
        }).done(function(datas){
            let data = datas.data;
            let html_text = '<option value="">Select State</option>';
            for (let key in data) {
                html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
            }
            $('#selectState').html(html_text);
        });
    });

    $(document).on('change','#selectState',function(){
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
        });
    });

    // 1. INITIAL LOAD
    $(document).ready(function(){
        var data = { type : "order_placed" }
        var json_data = JSON.stringify(data);
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/sales_order_count.php",
            data: json_data,
        }).done(function(res_datas) {
            var total = res_datas.data;
            $("#total_count").html(total ? total.length : 0);
            
            // EXACT FIX: Destroy old table before adding new HTML
            if ($.fn.DataTable.isDataTable('#table_data')) {
                $('#table_data').DataTable().clear().destroy();
            }

            var html_text = '';
            var count = 1;
            if(res_datas && res_datas.data && Array.isArray(res_datas.data)) {
                res_datas.data.forEach(function(item,index){
                    html_text += `<tr>
                        <td> ${count++} </td>
                        <td> ${item.distributor_name} </td>
                        <td> ${item.state_name} </td>
                        <td> ${item.region_name} </td>
                        <td> ${item.order_taken_shop_count.toLocaleString('en-IN')} </td>
                        <td> ${item.total_amount.toLocaleString('en-IN')} </td>
                    </tr>`;
                });
            }
            $('#table_body').html(html_text);

            table1 = $("#table_data").DataTable({
                destroy: true, // <--- IMPORTANT FIX
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn-primary buttonprint',
                    title :'Sales_order_count',
                    exportOptions: { columns: [0,1,2,3,4,5] },
                    orientation: 'landscape',
                    footer: true,
                    pageSize: 'LEGAL',
                },{
                    extend: 'csv',
                    className: 'btn-info buttonprint',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }],
                "columnDefs": [{ "visible": false, "searchable": false }],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">',
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">',
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                    }
                }
            });
        })
    });

    // 2. STATE CHANGE LOAD
    $(document).on('change','#selectState',function(){
        fromDate = $("#fromDate").val();
        toDate = $("#toDate").val();
        var state = $('#selectState :selected').val();
        
        var data = {
            type : "filters_date",
            state_token : state,
            fromDate: fromDate,
            toDate:toDate
        }
        var json_data = JSON.stringify(data);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/sales_order_count.php",
            data: json_data,
        }).done(function(res_datas) {
            
            // EXACT FIX: Destroy old table before adding new HTML
            if ($.fn.DataTable.isDataTable('#table_data')) {
                $('#table_data').DataTable().clear().destroy();
            }

            var html_text = '';
            var count = 1;
            if(res_datas && res_datas.data && Array.isArray(res_datas.data)) {
                res_datas.data.forEach(function(item,index){
                    html_text += `<tr>
                        <td> ${count++} </td>
                        <td> ${item.distributor_name} </td>
                        <td> ${item.state_name} </td>
                        <td> ${item.region_name} </td>
                        <td> ${item.order_taken_shop_count.toLocaleString('en-IN')} </td>
                        <td> ${item.total_amount.toLocaleString('en-IN')} </td>
                    </tr>`;
                });
            }
            $('#table_body').html(html_text);
            $(".table_count").hide();
            $(".table_count1").show();
            var rowCount = $('#table_body tr').length;
            $("#total_count1").html(rowCount);
            
            table1 = $("#table_data").DataTable({
                destroy: true, // <--- IMPORTANT FIX
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn-primary buttonprint',
                    title :'Sales_order_count:' + $('#fromDate').val() +  'to'  +$('#toDate').val(),
                    exportOptions: { columns: [0,1,2,3,4,5] },
                    orientation: 'landscape',
                    footer: true,
                    pageSize: 'LEGAL',
                },{
                    extend: 'csv',
                    className: 'btn-info buttonprint',
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }],
                "columnDefs": [{ "visible": false, "searchable": false }],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">',
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">',
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                    }
                }
            });
        })
    });

    // 3. GO BUTTON LOAD
    $(document).on('click','#stateGoBtn',function(){
        fromDate = $("#fromDate").val();
        toDate = $("#toDate").val();
        var state = $('#selectState :selected').val();
        var selectRegion_token =  $('#selectRegion :selected').val();

        if (fromDate != ""  && toDate != "" && state.length != 0 && selectRegion_token.length != 0) {
            var data = {
                type : "filters_date",
                state_token : state,
                region_token: selectRegion_token,
                fromDate: fromDate,
                toDate:toDate
            }
            var json_data = JSON.stringify(data);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/sales_order_count.php",
                data: json_data,
            }).done(function(res_datas) {
                
                // EXACT FIX: Destroy old table before adding new HTML
                if ($.fn.DataTable.isDataTable('#table_data')) {
                    $('#table_data').DataTable().clear().destroy();
                }

                var html_text = '';
                var count = 1;
                if(res_datas && res_datas.data && Array.isArray(res_datas.data)) {
                    res_datas.data.forEach(function(item,index){
                        html_text += `<tr>
                            <td> ${count++} </td>
                            <td> ${item.distributor_name} </td>
                            <td> ${item.state_name} </td>
                            <td> ${item.region_name} </td>
                            <td> ${item.order_taken_shop_count.toLocaleString('en-IN')} </td>
                            <td> ${item.total_amount.toLocaleString('en-IN')} </td>
                        </tr>`;
                    });
                }
                $('#table_body').html(html_text);
                $(".table_count").hide();
                $(".table_count1").show();
                var rowCount = $('#table_body tr').length;
                $("#total_count1").html(rowCount);
                
                table1 = $("#table_data").DataTable({
                    destroy: true, // <--- IMPORTANT FIX
                    dom: 'Bfrtip',
                    buttons: [{
                        extend: 'pdfHtml5',
                        className: 'btn-primary buttonprint',
                        title :'Sales_order_count:' + $('#fromDate').val() +  'to'  +$('#toDate').val(),
                        exportOptions: { columns: [0,1,2,3,4,5] },
                        orientation: 'landscape',
                        footer: true,
                        pageSize: 'LEGAL',
                    },{
                        extend: 'csv',
                        className: 'btn-info buttonprint',
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }],
                    "columnDefs": [{ "visible": false, "searchable": false }],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
            })
        } else {
            swal('Please select all dropdown value');
        }
    });

    $(document).on('click','.nav-link',function(){
        const id = $(this).attr('href');
        
        if (id == '#pills-home') {
            var datas = { type: "order_placed" };
            var json_data = JSON.stringify(datas);
        } else {
            var datas = { type: "no_order" };
            var json_data = JSON.stringify(datas);
        }

        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/sales_order_count.php",
            data: json_data,
        }).done(function(data){
            
            // EXACT FIX: Destroy old table before adding new HTML
            if ($.fn.DataTable.isDataTable('#table_data1')) {
                $('#table_data1').DataTable().clear().destroy();
            }

            var html_text = "";
            var count = 1;
            if(data && data.data && Array.isArray(data.data)) {
                data.data.forEach(function(item,index){
                    html_text += `<tr>
                        <td> ${count++} </td>
                        <td> ${item.distributor_name} </td>
                        <td> ${item.state_name} </td>
                        <td> ${item.region_name} </td>
                        <td> ${item.order_taken_shop_count} </td>
                    </tr>`;
                });
            }

            $("#table_body1").html(html_text);
            var rowCount = $('#table_body1 tr').length;
            $("#total_count").html(rowCount);
            
            table1 = $("#table_data1").DataTable({
                destroy: true, // <--- IMPORTANT FIX
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn-primary buttonprint',
                    title :'No order Distributor:' + $('#fromDate').val() +  'to'  +$('#toDate').val(),
                    exportOptions: { columns: [0,1,2,3,4] }, // Fixed to 5 columns
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                },{
                    extend: 'csv',
                    className: 'btn-primary buttonprint',
                    title :'No order Distributor:' + $('#fromDate').val() +  'to'  +$('#toDate').val(),
                    exportOptions: { columns: [0,1,2,3,4] }, // Fixed to 5 columns
                    orientation: 'landscape',
                    pageSize: 'LEGAL'
                }],
                "columnDefs": [{ "visible": false, "searchable": false }],
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
    });
    </script>

</body>

</html>
<?php
}
mysqli_close($link);
?>