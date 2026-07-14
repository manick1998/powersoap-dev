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
    <title>Power soap</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/daily-shedule.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">

    <style>
        .nav-pills .nav-link, .nav-pills .show>.nav-link{
            background-color: #fff;
            border: #00b9f5 2px solid;
            color: #00b9f5;
            transition: 1s;
            border-radius: 4px;
        }
        .nav-pills .nav-link:hover, 
        .nav-pills .show>.nav-link:hover{
            background-color: #00b9f5;
            color: #fff !important;
        }
        .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
            color: #fff;
            background-color: #00b9f5 !important;
        }
        .nav-item-center{
            margin-left: 100px;
        }
        .rightbot{
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }
        .leftbot{
            border-top-left-radius: 0 !important;
            border-bottom-left-radius: 0 !important;
        }
        .dataTables_scrollHeadInner {
            width: 100% !important;
        }
        .table-filter {
            text-align: right;
            margin-bottom: 12px;
            padding: 0 20px;
        }
        .table-filter-box{
            display: inline-block;
            position: relative;
        }
        .search-input {
            padding: 10px 10px 10px 36px;
            outline: none;
            border: 1px solid #cfcfcf;
            width: 200px;
            border-radius: 4px;
        }
        .search-label {
            position: absolute;
            left: 12px;
            top: 11px;
        }
    </style>
</head>

<body>
    <header id="main-dash-header" class="dash-header"></header>
    <div class="se-pre-con"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar6"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="head">
            <div class="header_container">
                <div>
                    <h1 class="header_main">Daily Schedule</h1>
                </div>
            </div>

            <ul class="nav nav-pills mb-3 mt-3 ml-4" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Schedule Beat</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link leftbot skuListBtn" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Customised Schedule Beat</a>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent" >
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-box">
                            <table class="custom-table" id="table_data">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Unit Name</th>
                                        <th>Shop Number</th>
                                        <th>Schedule Status</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body_id"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="table-box">
                            <div class="table-filter">
                                <div class="table-filter-box">
                                    <input type="search" class="search-input" id="custom_table_search" placeholder="search">
                                    <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>
                                    <!-- for="table-search" -->
                                </div>
                            </div>
                            <table class="custom-table" id="table_data1">
                                <thead>
                                    <tr>
                                        <th>Sl. No</th>
                                        <th>Custom Unit Name</th>
                                        <th>Unit Number</th>
                                        <th>Schedule Status</th>
                                    </tr>
                                </thead>
                                <tbody id="custom_table_body_id"></tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </section>
        <!--next section -link - mylapore--------------------->
        <section class="bg-white brad-4 full-height" id="first"  style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tohead()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                    <h1 class="header_main" id="single_unit_name"></h1>
                    <div class="view-shop">
                    <p class="table_count">Shop Number - <span id="single_shop_count"></span></p> 
                    <div id="single_view_button">
                        <a href="javascript:void(0)" class="view_link" onClick="view_list()">View Shop List</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <table class="custom-table" id="schedule_table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>    
                            <th>Day</th>
                            <th>Sales Employee</th>
                            <th>Delivery Employee</th>
                        </tr>
                    </thead>
                    <tbody id="schedule_table_body"></tbody>
                </table>
            </div>
            <div class="save-shedule">
                <input id="update_schedule_token" type="hidden">
                <input id="update_schedule_key" type="hidden">
                <button class="primary-btn" id="update_schedule_button_id" onclick="update_schedule()" >Save Schedule</button>
            </div>
        </section>

        <!--next section -link - mylapore--------------------->
        <section class="bg-white brad-4 full-height" id="second"  style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tohead()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                    <h1 class="header_main" id="custom_single_unit_name"></h1>
                    <div class="view-shop">
                    <p class="table_count">Units Number - <span id="single_unit_count"></span></p> 
                    <div id="single_view_button">
                        <a href="javascript:void(0)" class="view_link" onclick="view_unit()">View Unit List</a>
                        <input type="hidden" id="hide_date" value="">
                    </div>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <div class="table-filter">
                    <div class="table-filter-box">
                        <input type="search" class="search-input" id="table_body_search" placeholder="search">
                        <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>

                    </div>
                </div>
                <table class="custom-table" id="schedule_table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>    
                            <th>Day</th>
                            <th>Sales Employee</th>
                            <th>Delivery Employee</th>
                        </tr>
                    </thead>
                    <tbody id="custom_schedule_table_body"></tbody>
                </table>
            </div>
            <div class="save-shedule">
                <input id="custom_update_schedule_token" type="hidden">
                <input id="custom_update_schedule_key" type="hidden">
                <button class="primary-btn" id="custom_update_schedule_button_id" onclick="cus_update_schedule()" >Save Schedule</button>
            </div>
        </section>

        <!--next section -link - mylapore--------------------->
        <section class="bg-white brad-4 full-height" id="view_shoplist" style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tofirst()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                    <h1 class="header_main">Shop List</h1>
                    <div class="view-shop">
                        <p class="table_count">Available Shop - <span id="single_shop_count2"></span></p> 
                    </div>
                </div>
            </div>
            <div class="header_container">
                <div class="shopname">
                    <p>Unit Name</p>
                    <h2 id="single_unit_name2"></h2>
                </div>
            </div>
            <div class="table-box">
               <table class="custom-table" id="shop_list_table">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Shop Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody id="shop_list_body">
                    </tbody>
                </table>
            </div>
        </section>
        <!--next section -link - mylapore--------------------->
        <section class="bg-white brad-4 full-height" id="view_unitlist" style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tosecond()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                    <h1 class="header_main">Unit List</h1>
                    <div class="view-shop">
                        <p class="table_count">Available Customise Unit - <span id="single_unit_count2"></span></p> 
                    </div>
                </div>
            </div>
            <div class="header_container">
                <div class="shopname">
                    <p>Customise Unit</p>
                    <h2 id="single_cus_unit_name2"></h2>
                </div>
            </div>
            <div class="table-box">
                <div class="table-filter">
                    <div class="table-filter-box">
                        <input type="search" class="search-input" id="table_unit_search" placeholder="search">
                        <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>     
                    </div>
                </div>
               <table class="custom-table" id="unit_list_table">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Unit Name</th>
                            <th>Shop Count</th>
                        </tr>
                    </thead>
                    <tbody id="unit_list_body">
                    </tbody>
                </table>
            </div>
        </section>

         <!--next section -link - mylapore--------------------->
         <section class="bg-white brad-4 full-height" id="view_unit" style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tounitlist()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                <h1 class="header_main">Shop Details</h1>
                <div class="view-shop">
                    <p class="table_count">Available unit - <span id="single_shop_count3"></span></p> 
                </div>
                </div>
            </div>
            <div class="header_container">
            <div class="shopname">
                <p>Unit Name</p>
                <h2 id="single_unit_name3"></h2>
            </div>
            </div>
            <div class="table-box">
                <div class="table-filter">
                    <div class="table-filter-box">
                        <input type="search" class="search-input" id="table_unit_body_search" placeholder="search">
                        <label  class="search-label"><img src="assets/svg/Search_icon.svg" class="search-icon"></label>          
                    </div>
                </div>
               <table class="custom-table" id="unit_table">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Shop Name</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody id="unit_body">
                    </tbody>
                </table>
            </div>
        </section>
        
    </main>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<!--    datepicker-->
<!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
<script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
<!-- jquery CDN -->
<script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->

<!-- datatable -->
<script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
<script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><!---- For S3 bucket upload ---->
<script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
<script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
<!-- js file -->
<script src="js/header.js<?php echo $js_cache_string; ?>"></script>
<script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script> 
    <script>var notiCount = "<?php echo $notiCount; ?>";</script>
<script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    function back_tofirst() {
        $('#first').show();
        $('#view_shoplist').hide();
        $('#head').hide();
    } 
    function back_tosecond() {
        $('#second').show();
        $('#view_unitlist').hide();
        $('#head').hide();
    }
    function back_tohead() {
        $('#head').show();
        $('#first').hide();
        $('#second').hide();
    }
    function view_unitpage() {
        $("#view_unitlist").hide();
        $("#view_unit").show();
    }
    function back_tounitlist() {
        $("#view_unitlist").show();
        $("#view_unit").hide();
    }

    var verfication_code = "<?php echo $verification_code; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table;  
    var table1;
    var table2;
    var table_main_data;
    var table_main_data1;
    $(document).ready(function(){
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/unit_list.php",
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
                html_text += '<td><div class=""><a href="javascript:void(0)" class="view_link" onClick="view_page('+key+')">'+table_main_data[key].name+'</a></div></td>';
                html_text += '<td>'+table_main_data[key].shop_count+'</td>';
                html_text += '<td>'+table_main_data[key].status+'</td>';
            html_text += '</tr>';
        }
        $("#total_count").html(slno);
        $("#table_body_id").html(html_text);
        table = $("#table_data").DataTable({
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
        $(".se-pre-con").hide();
    }
    var table1_check = false;
    function view_page(keyMain){
        $(".se-pre-con").fadeIn();
        $("#update_schedule_button_id").css("display","block");
        $("#update_schedule_button_id").prop('disabled', false);
        if(table1_check){
            table1.clear();
            table1.destroy();
        }
        //$("#update_schedule_key").val(keyMain);
        $("#update_schedule_token").val(table_main_data[keyMain].token);
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            unit_token:table_main_data[keyMain].token,
            type: "schedule_list"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            cache: false,
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/unit_schedule_list.php",
            data: json_data,
        }).done(function(data) {
            var schedule_data = data.data;
            var sales_data    = data.salesData;
            var delivery_data = data.deliveryData;
            var html_text1 = "";
            for (var key in schedule_data) {
                html_text1 += '<tr>';
                    html_text1 += '<td>'+schedule_data[key].sl_no+'</td>';
                    html_text1 += '<td>'+schedule_data[key].day_val+'</td>';
                    html_text1 += '<td>';
                   
                        html_text1 += '<select class="table-select option" id="'+schedule_data[key].day_val+'_sales_employee">';
                         html_text1 += '<option value="">-Select Employee-</option>';
                        for (var key1 in sales_data) {     
                            html_text1 += '<option value="'+sales_data[key1].token+'">'+sales_data[key1].name+'</option>';
                        }
                        html_text1 += '</select>';
                    html_text1 += '</td>';
                    html_text1 += '<td>';
                        html_text1 += '<select class="table-select option" id="'+schedule_data[key].day_val+'_delivery_employee">';
                        html_text1 += '<option value="">-Select Employee-</option>';
                        for (var key2 in delivery_data) {   
                            html_text1 += '<option value="'+delivery_data[key2].token+'">'+delivery_data[key2].name+'</option>';
                        }
                        html_text1 += '</select>';    
                    html_text1 += '</td>';
                html_text1 += '</tr>';
            }
            $("#schedule_table_body").html(html_text1);
            for (var key in schedule_data) {
                
                    $("#"+schedule_data[key].day_val+"_sales_employee" ).val(schedule_data[key].sales_employee_token);
                    $("#"+schedule_data[key].day_val+"_delivery_employee" ).val(schedule_data[key].delivery_employee_token);
                    $("#"+schedule_data[key].day_val+"_sales_employee").prop('disabled', false);
                    $("#"+schedule_data[key].day_val+"_delivery_employee").prop('disabled', false);
            }
        });
        $(".se-pre-con").fadeOut();
        $('#head').hide();
        $('#first').show();
        $("#single_unit_name").html(table_main_data[keyMain].name);
        $("#single_shop_count").html(table_main_data[keyMain].shop_count);
        $("#single_view_button").html('<a href="javascript:void(0)" class="view_link" onClick="view_list('+keyMain+')">View Shop List</a>');
        table1 = $("#schedule_table").DataTable({
            scrollX: true,
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
        table1_check = true;
    }
    
    var table2_check = false;
    function view_list(key) {
        if(table2_check){
            table2.clear();
            table2.destroy();
        }
        $("#single_unit_name2").html(table_main_data[key].name);
        $("#single_shop_count2").html(table_main_data[key].shop_count);
        var token = table_main_data[key].token;
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            token: token,
            type: "single"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/unit_list.php",
            data: json_data,
        }).done(function(data) {
            exist_shop_data = data.data;
            var slno = 0;
            var html_text = "";
            for (var key in exist_shop_data) {
                slno++;
                html_text += '<tr>';
                    html_text += '<td>'+slno+'</td>';
                    html_text += '<td>'+exist_shop_data[key].name+'</td>';
                    html_text += '<td>'+exist_shop_data[key].address+'</td>';
                html_text += '</tr>';
            }
            $("#shop_list_body").html(html_text);
            $('#view_shoplist').show();
            $('#head').hide();
            $('#first').hide();
            table2 = $("#shop_list_table").DataTable({
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
            table2_check = true;
        });
    }

    var schedule_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    function update_schedule(){
        $(".se-pre-con").fadeIn();
        var token = $("#update_schedule_token").val();
        var update_array = []
        for (var key in schedule_days) {
            var sales_employee_token   = $("#"+schedule_days[key]+"_sales_employee").val();
            var delivery_employee_token = $("#"+schedule_days[key]+"_delivery_employee").val();
            var data = {
                day_value: schedule_days[key],
                sale_employee: sales_employee_token,
                delivery_employee: delivery_employee_token
            };
            update_array.push(data);
        }
        var datas = {
            unit_token: token,
            update_array: update_array,
            dashboard_code: verfication_code,
             distributor_token: distributor_token
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/schedule_update.php",
            data: json_data,
        }).done(function(data) {
            if(data.code == 200){ 
                $(".se-pre-con").fadeOut();
                swal("Scheduled Successfully!", {icon: "success",}).then((value) => {
                    location.reload();
                });           
            }else{
                $(".se-pre-con").fadeOut();
                let htmlData = ``;
                $.each(data.employee_data, function(index,data) {
                    htmlData += `<div>${data.employee_name} already assigned in ${data.unit_token} unit on ${data.schedule_date}</div>`;
                });
                var htmlObject = document.createElement('div');
                htmlObject.innerHTML = htmlData;
                swal(htmlObject).then((value) => {
                    location.reload();
                });
            }
        });
    }

    // search box
    $(document).ready(function(){
        $("#custom_table_search").keyup(function(){
            var value = $(this).val().toLowerCase();
            $("#custom_table_body_id tr").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);
            });
        });

        $("#table_body_search").keyup(function(){
            var value1 = $(this).val().toLowerCase();
            $("#custom_schedule_table_body tr").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value1)>-1)
            });
        });

        $("#table_unit_search").keyup(function(){
           var value2 = $(this).val().toLowerCase();
            $("#unit_list_body tr").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value2)>-1);
            });
        });

        $("#table_unit_body_search").keyup(function(){
            var value3 = $(this).val().toLowerCase();
            $("#unit_body tr").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(value3)>-1)
            });
        });
    });

    //custom daily schedule
    $(document).ready(function(){
           var data = {
            distributor_token: distributor_token,
        };
        var json_data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/custom_daily_schedule_table.php",
            data: json_data,
        }).done(function(response){      
        table_main_data1 = response.data;
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data1) {
                slno++;
                html_text += '<tr>';
                    html_text += '<td>'+slno+'</td>';

                    html_text += '<td><div class=""><a href="javascript:void(0)" class="view_link custom_view_link" data-total_count="'+table_main_data1[key].total_unit+'" data-custom_beat_token="'+table_main_data1[key].token+'" data-custom_name="'+table_main_data1[key].customunit_name+'">'+table_main_data1[key].customunit_name+'</a></div></td>';
                    html_text += '<td>'+table_main_data1[key].total_unit+'</td>';
                    html_text += '<td>'+table_main_data1[key].status+'</td>';
                html_text += '</tr>';
            }
            $("#custom_table_body_id").append(html_text);
            $("#custom_table_body_id").attr('data-row',slno);
            table = $("#table_data1").DataTable({
                                    "scrollX": true,
                                    dom: 'rtip',
                                    buttons: [],
                                    language: {
                                        searching: false,
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

    $(document).on("click",".custom_view_link",function(){
        $('#second').show();
        $('#head').hide();
        $("#single_unit_count,#single_unit_count2").html($(this).attr("data-total_count"));
        $("#hide_date").val($(this).attr("data-custom_beat_token"));
        var custom_beat_token = $("#hide_date").val();
        $("#custom_single_unit_name,#single_cus_unit_name2").html($(this).attr("data-custom_name"));
        var datas = {
            distributor_token: distributor_token, 
            custom_beat_token:custom_beat_token 
        }
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/custom_unit_schedule.php",
            data: json_data,
        }).done(function(data) {
            var schedule_data = data.data1;
            var sales_data    = data.salesData;
            var delivery_data = data.deliveryData;
            
            var html_text = "";
            var count = 1;
            var sales_token ="";
            for (var key in schedule_data) {
                html_text += '<tr>';
                    html_text += '<td>'+ count++ +'</td>';
                    html_text += '<td>'+schedule_data[key].day_val+'</td>';
                    html_text += '<td>';
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_sales_employee">';
                        html_text += '<option value="">-Select Employee-</option>';
                        for (var key1 in sales_data) {     
                            html_text += '<option  value="'+sales_data[key1].token+'">'+sales_data[key1].name+'</option>';
                        }
                        html_text += '</select>';
                    html_text += '</td>';
                    html_text += '<td>';
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_delivery_employee">';
                        html_text += '<option value="">-Select Employee-</option>';
                        for (var key2 in delivery_data) {   
                            html_text += '<option  value="'+delivery_data[key2].token+'">'+delivery_data[key2].name+'</option>';
                        }
                        html_text += '</select>';    
                    html_text += '</td>';
                html_text += '</tr>';
            }
            $("#custom_schedule_table_body").html(html_text);
            for (var key in schedule_data) {
                $("#"+schedule_data[key].day_val+"_sales_employee" ).val(schedule_data[key].sales_employee_token);
                $("#"+schedule_data[key].day_val+"_delivery_employee" ).val(schedule_data[key].delivery_employee_token);
            }
        });
    });

    var schedule_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    function cus_update_schedule(){
        // $(".se-pre-con").fadeIn();
        var update_array = [] 
        var custom_beat_token =$("#hide_date").val();
         for (var key in schedule_days) {             
            var sales_employee_token =$("#"+schedule_days[key]+"_sales_employee").val();
            var delivery_employee_token = $("#"+schedule_days[key]+"_delivery_employee").val();
            var data = {
                day_value: schedule_days[key],
                sale_employee: sales_employee_token,
                delivery_employee: delivery_employee_token
            };
            update_array.push(data);
         }
       var datas = {
            custom_beat_token: custom_beat_token,
            update_array: update_array,
             distributor_token: distributor_token
        };
        var json_data = JSON.stringify(datas);
        console.log('json_data',json_data);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/custom_beat_schedule_update.php",
            data: json_data,
        }).done(function(data) {
            if(data.code == 200){ 
                $(".se-pre-con").fadeOut();
                swal("Scheduled Successfully!", {icon: "success",}).then((value) => {
                location.reload();
                });           
            }else{
                $(".se-pre-con").fadeOut();
                let htmlData = ``;
                $.each(data.employee_data, function(index,data) {
                    htmlData += `<div>${data.employee_name} already assigned in ${data.unit_token} unit on ${data.schedule_date}</div>`;
                });
                var htmlObject = document.createElement('div');
                htmlObject.innerHTML = htmlData;
                swal(htmlObject).then((value) => {
                location.reload();
                });
            }
        });
    }

    function view_unit(){
        $('#view_unitlist').show();
        $('#second').hide();
        var custom_beat_token = $("#hide_date").val();
        var data ={
            type : 'unit_list',
            custom_beat_token : custom_beat_token,
            distributor_token : distributor_token
        }
        var json_data = JSON.stringify(data);
        console.log(json_data);
        $.ajax({
            type : "POST",
            url :api_path +"/distributor/custom_beat_units_list.php",
            data: json_data,
        }).done(function(res){
                var count = 1;
                var html = ""
                res.unit_data.forEach(function(item,index){
                    html += '<tr>'
                    html+='<td>'+ count++ +'</td>'
                    html+='<td><a class="view_link" id ="beat_token" data-cus_shops_count="'+item.shop_count+'" data-beat_token="'+item.beat_tokens+'" data-beats="'+item.beat_names+'" onclick="view_unitpage()">'+ item.beat_names+ '</a></td>'
                    html+='<td>'+ item.shop_count+'</td>'
                    html+='</tr>';
                });
                // for (var key in res) {
                   
                // }
                $("#unit_list_body").html(html);
            });
        
    }
    $(document).on("click","#beat_token",function(){
        $("#single_shop_count3").html($(this).attr("data-cus_shops_count"));
        $("#single_unit_name3").html($(this).attr("data-beats"));

          var unit_token=$(this).attr("data-beat_token");
          var data ={
            distributor_token : distributor_token,
            unit_token:unit_token
          }
          var json_data = JSON.stringify(data);
          $.ajax({
                    type :"POST",
                    url : api_path +"/distributor/get_shops.php",
                    data : json_data
          }).done(function(res){
            var count = 1;
                var html = ""
                for (var key in res) {
                    html += '<tr>'
                    html+='<td>'+ count++ +'</td>'
                    html+='<td><a class="view_link" id ="beat_andshop_token" data-unit_token="'+res[key].beat_tokens+'"">'+ res[key].shop_names+ '</a></td>'
                    html+='<td>'+ res[key].shop_add+'</td>'
                    html+='</tr>';
                }
                $("#unit_body").html(html);
          });
    });
    
</script>
</body>
</html>
<?php
}
?>