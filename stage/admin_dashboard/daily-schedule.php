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
    <title>Power soap</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/daily-shedule.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<body>
    <div class="se-pre-con" style="display: block;"></div>
    <header id="main-dash-header" class="dash-header"></header>
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
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Unit Name</th>
                            <th>Shop Number</th>
                            <th>Distributor</th>
                            <th>Schedule Status</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_id"></tbody>
                </table>
            </div>
        </section>
        <!--next section -link - mylapore--------------------->
        <section class="bg-white brad-4 full-height" id="first"  style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tohead()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                    <h1 class="header_main" id="single_unit_name">Mylapore</h1>
                    <div class="view-shop">
                    <p class="table_count mrg_count">Total Shop Count - <span id="single_shop_count">34</span></p> 
                    <div id="single_view_button">
                        <a href="javascript:void(0)" class="view_link" onclick="view_list()">View Shop List</a>
                    </div>
                    </div>
                </div>
            </div>
            <div class="table-box">
                <table class="custom-table" id="schedule_table">
                    <thead>
                        <tr>
                            <th>Sl No</th>    
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
        <section class="bg-white brad-4 full-height" id="view_shoplist" style="display:none">
            <div class="header_container">
                <div class="back-arrow" onclick="back_tofirst()">
                    <img src="assets/back.png" alt="#">
                </div>
                <div>
                <h1 class="header_main">Shop List</h1>
                <div class="view-shop">
                    <p class="table_count mrg_count">Total Shop Count - <span id="single_shop_count2"></span></p> 
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
    </main>
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var admin_state_id = "<?php echo $cookie_admin_state; ?>";
</script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
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
<script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
<script>
    function back_tofirst() {
        $('#first').show();
        $('#view_shoplist').hide();
        $('#head').hide();
    } 
    function back_tohead() {
        $('#head').show();
        $('#first').hide();
    }
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table;  
    var table1;
    var table2;
    var table_main_data;
    $(document).ready(function () {
        var datas = {
            dashboard_code: verfication_code,
            state_id: admin_state_id,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitList.php",
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
                html_text += '<td><div class=""><a class="view_link" onclick="view_page('+key+')">'+table_main_data[key].name+'</a></div></td>';
                html_text += '<td>'+table_main_data[key].shop_count+'</td>';
                html_text += '<td>'+table_main_data[key].distributor+'</td>';
                html_text += '<td>'+table_main_data[key].status+'</td>';
            html_text += '</tr>';
        }
        $("#total_count").html(slno);
        $("#table_body_id").html(html_text);
        table = $("#table_data").DataTable({
            dom: 'Bfrltip',
            pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10,25,100,500,1000,5000,10000,100000],
            buttons: ['csv','pdf'],
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
        $(".se-pre-con").show();
        if(table_main_data[keyMain].distributor =="Admin"){
            $("#update_schedule_button_id").css("display","block");
            $("#update_schedule_button_id").prop('disabled', false);
        }else{
            $("#update_schedule_button_id").css("display","none");
            $("#update_schedule_button_id").prop('disabled', true);
        }
        if(table1_check){
            table1.clear();
            table1.destroy();
        }
        var token = table_main_data[keyMain].token;
        $("#update_schedule_token").val(token);
        $("#update_schedule_key").val(keyMain);
        var datas = {
            dashboard_code: verfication_code,
            unit_token: token,
            type: "schedule_list"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitScheduleList.php",
            data: json_data,
        }).done(function(data) {
            var schedule_data = data.data;
            var sales_data    = data.salesData;
            var delivery_data = data.deliveryData;
            var html_text = "";
            for (var key in schedule_data) {
                html_text += '<tr>';
                    html_text += '<td>'+schedule_data[key].sl_no+'</td>';
                    html_text += '<td>'+schedule_data[key].day_val+'</td>';
                    html_text += '<td>';
                    if(table_main_data[keyMain].distributor =="Admin"){
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_sales_employee">';
                        html_text += '<option value="">-Select Employee-</option>';
                        for (var key1 in sales_data) {
                            html_text += '<option value="'+sales_data[key1].token+'">'+sales_data[key1].name+'</option>';
                        }
                        html_text += '</select>';
                    }else{
                        html_text += '<p>'+schedule_data[key].sales_employee_name+'</p>';
                    }
                    html_text += '</td>';
                    html_text += '<td>';
                    if(table_main_data[keyMain].distributor =="Admin"){
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_delivery_employee">';
                            html_text += '<option value="">-Select Employee-</option>';
                        for (var key2 in delivery_data) {
                            html_text += '<option value="'+delivery_data[key2].token+'">'+delivery_data[key2].name+'</option>';
                        }
                        html_text += '</select>';
                    }else{
                        html_text += '<p>'+schedule_data[key].delivery_employee_name+'</p>';
                    }      
                    html_text += '</td>';
                html_text += '</tr>';
            }
            $("#schedule_table_body").html(html_text);
            for (var key in schedule_data) {
                if(table_main_data[keyMain].distributor =="Admin"){
                    $("#"+schedule_data[key].day_val+"_sales_employee" ).val(schedule_data[key].sales_employee_token);
                    $("#"+schedule_data[key].day_val+"_delivery_employee" ).val(schedule_data[key].delivery_employee_token);
                    $("#"+schedule_data[key].day_val+"_sales_employee").prop('disabled', false);
                    $("#"+schedule_data[key].day_val+"_delivery_employee").prop('disabled', false);
                }else{
                    $("#"+schedule_data[key].day_val+"_sales_employee").prop('disabled', false);
                    $("#"+schedule_data[key].day_val+"_delivery_employee").prop('disabled', false);
                }
            }
        });
        
        $('#head').hide();
        $('#first').show();
        $("#single_unit_name").html(table_main_data[keyMain].name);
        $("#single_shop_count").html(table_main_data[keyMain].shop_count);
        $("#single_view_button").html('<a href="javascript:void(0)" class="view_link" onclick="view_list('+keyMain+')">View Shop List</a>');
        table1 = $("#schedule_table").DataTable({
            dom: 'Bfrltip',
            pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10,25,100,500,1000,5000,10000,100000],
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
        $(".se-pre-con").hide();
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
            token: token,
            type: "single"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/unitList.php",
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
            table2 = $("#shop_list_table").DataTable({
                dom: 'Bfrltip',
            pageLength: <?php echo $page_length; ?>,
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
            table2_check = true;
            $('#view_shoplist').show();
            $('#head').hide();
            $('#first').hide();
        });
    }
    var schedule_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    function update_schedule(){
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
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/scheduleUpdate.php",
            data: json_data,
        }).done(function(data) {
            swal("Success!", "Updated Succssfully!", "success");
            var key = $("#update_schedule_key").val();
            view_page(key);
            
        });
    }
</script>
</body>
</html>
<?php
}
mysqli_close($link);
?>