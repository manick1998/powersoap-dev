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
            border: #00b9f5 1px solid;
            color: #00b9f5;
            transition: 1s;
            border-radius: 0px;
                padding: 10px 24px;
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
        .select__status {
                    outline: none;
                    padding: 6px;
                    border-radius: 2px;
                    width: 107px;
                    border: 1px solid #11a14a;
                    background-color: #11a14a;
                    color: #fff;
                    background-image: url(assets/Down--Arrow@2x.svg)  !important;
                    background-size: 16px;
                    background-repeat: no-repeat;
                    background-position: 99% 50%;
                    
                }
                 .old_desing {
                display: none;
            }
            /* .new_desing{
                display: none;
            } */
    </style>
</head>

<body>
    <header id="main-dash-header" class="dash-header"></header>
    <div class="se-pre-con"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar4"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="head">
            <div class="header_container">
                <div>
                    <h1 class="header_main">Retailer List </h1>  <span class="table_count" style="margin-left: 1rem; font-size: 18px">Total unit - <span id="total_count">15</span></span>
                </div>
            </div>

            <ul class="nav nav-pills mb-3 mt-3 ml-4" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                    <a class="nav-link rightbot shopListBtn active" id="all_btn" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link leftbot skuListBtn" id="approved_btn"  data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Approved</a>
                </li>
              
                <li class="nav-item" role="presentation">
                    <a class="nav-link leftbot skuListBtn" id="pending_btn" data-toggle="pill" href="#pills-profile2" role="tab" aria-controls="pills-profile" aria-selected="false">Pending</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link leftbot skuListBtn" id="rejected_btn" data-toggle="pill" href="#pills-profile3" role="tab" aria-controls="pills-profile" aria-selected="false">Rejected</a>
                </li>
            </ul>
                <!-- All data -->
            <div class="tab-content" id="pills-tabContent" >
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                         <div class="table-box">
                            <table class="custom-table" id="table_data_my">
                                <thead>
                                    <tr>    
                                            <th>Slno</th>
                                            <th>Retailer Code</th>
                                            <th>Retailer Name</th>
                                            <th>Type</th>
                                            <th>Mobile Number</th>
                                            <th>Contact Person</th>
                                            <th>Joinina Date</th>
                                            <th>License Number</th>
                                            <th>Status</th>
                                          
                                           
                                    </tr>
                                </thead>
                                <tbody id='table_body_id'>
                                       <!-- <tr>
                                           
                                           <td ><a href="javascript:void(0)" class="view_link employee_code_view">DIST95542951</a></td>
                                            <td>RAMA AGENCIES</td>
                                            <td>9849316824</td>
                                            <td>omjaju3132@yahoo.com</td>
                                            <td>Telangana</td>
                                            <td>ADILABAD</td>
                                            <td>Mancherial</td>
                                            <td>
                                                 <select class="select__status" name="" id="">
                                                    <option value="success">Approved</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="reject">Rejected</option>
                                                </select>
                                            </td>
                                           
                                        </tr>
                                       <tr>
                                           
                                           <td ><a href="javascript:void(0)" class="view_link employee_code_view">DIST95542951</a></td>
                                            <td>RAMA AGENCIES</td>
                                            <td>9849316824</td>
                                            <td>omjaju3132@yahoo.com</td>
                                            <td>Telangana</td>
                                            <td>ADILABAD</td>
                                            <td>Mancherial</td>
                                            <td>
                                                 <select class="select__status" name="" id="">
                                                    <option value="success">Approved</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="reject">Rejected</option>
                                                </select>
                                            </td>
                                           
                                        </tr>
                                       <tr>
                                           
                                           <td ><a href="javascript:void(0)" class="view_link employee_code_view">DIST95542951</a></td>
                                            <td>RAMA AGENCIES</td>
                                            <td>9849316824</td>
                                            <td>omjaju3132@yahoo.com</td>
                                            <td>Telangana</td>
                                            <td>ADILABAD</td>
                                            <td>Mancherial</td>
                                            <td>
                                                 <select class="select__status" name="" id="">
                                                    <option value="success">Approved</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="reject">Rejected</option>
                                                </select>
                                            </td>
                                           
                                        </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>  
                             <!-- Approved data -->
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                         <div class="table-box">
                             <table class="custom-table" id="approved_table">
                                <thead>
                                    <tr>    
                                            <th>Count</th>
                                            <th>Retailer Code</th>
                                            <th>Retailer Name</th>
                                            <th>Type</th>
                                            <th>Mobile Number</th>
                                            <th>Contact Person</th>
                                            <th>Joinina Date</th>
                                            <th>License Number</th>
                                            <th>Status</th>     
                                    </tr>
                                </thead>
                                <tbody id='approved_body_table'>
                                       
                                </tbody>
                            </table>
                        </div>
                    </div>
                             <!-- Pending data -->
                    <div class="tab-pane fade" id="pills-profile2" role="tabpanel" aria-labelledby="pills-profile-tab">
                         <div class="table-box">
                             <table class="custom-table" id="pending_table">
                                <thead>
                                    <tr>    
                                            <th>Count</th>
                                            <th>Retailer Code</th>
                                            <th>Retailer Name</th>
                                            <th>Type</th>
                                            <th>Mobile Number</th>
                                            <th>Contact Person</th>
                                            <th>Joinina Date</th>
                                            <th>License Number</th>
                                            <th>Status</th>     
                                    </tr>
                                </thead>
                                <tbody id='pending_body_table'>
                                       
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile3" role="tabpanel" aria-labelledby="pills-profile-tab">
                         <div class="table-box">
                             <table class="custom-table" id="rejected_table">
                                <thead>
                                    <tr>    
                                            <th>Count</th>
                                            <th>Retailer Code</th>
                                            <th>Retailer Name</th>
                                            <th>Type</th>
                                            <th>Mobile Number</th>
                                            <th>Contact Person</th>
                                            <th>Joinina Date</th>
                                            <th>License Number</th>
                                            <th>Status</th>     
                                    </tr>
                                </thead>
                                <tbody id='rejected_body_table'>
                                       
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
    var all_arr = [];
    $(document).ready(function(){
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            type: "all_shop"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/rep_add_retailer.php",
            data: json_data,
            success: success,
        });
    });
    function success(data) {
        console.log('mydata',data);
        table_main_data = data.get_shop_data;
        console.log('table_main_data',table_main_data);
        approved_table(table_main_data);
        pendind_table(table_main_data);
        rejected_table(table_main_data);
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
            all_arr.push(table_main_data[key].retail_code)
            slno++;
            html_text += `<tr>`;
                html_text += `<td>`+slno+`</td>`;
                html_text += `<td>`+table_main_data[key].retail_code+`</td>`;
                html_text += `<td>`+table_main_data[key].shop_name+`</td>`;
                html_text += `<td>`+table_main_data[key].shop_type+`</td>`;
                html_text += `<td>`+table_main_data[key].shop_mobile_number+`</td>`;
              
                    if (table_main_data[key].contact_person == "") {
                        html_text += `<td>`+'-'+`</td>`;
                    }else{
                        html_text += `<td>`+table_main_data[key].contact_person+`</td>`;
                    }
                html_text += `<td>`+table_main_data[key].join_date+`</td>`;
                if (table_main_data[key].license_number == "") {
                        html_text += `<td>`+'-'+`</td>`;
                    }else{
                        html_text += `<td>`+table_main_data[key].license_number+`</td>`;
                    }
                
                //html_text += `<td>`+table_main_data[key].shop_status+`</td>`;
                html_text += `<td>
                                <select class="select__status" name="" data-All_distributor_token='${table_main_data[key].distributor_token}' data-All_shop_token='${table_main_data[key].shop_token}' data-All_status_value='${table_main_data[key].shop_status}' id="change_status">
                                <option data-status_val = '1' value="complited${table_main_data[key].shop_status}" ${table_main_data[key].shop_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-status_val = '0' value="Pending${table_main_data[key].shop_status}" ${table_main_data[key].shop_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-status_val = '2' value="reject${table_main_data[key].shop_status}" ${table_main_data[key].shop_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`

            html_text += `</tr>`;
        }
        $("#total_count").html(slno);
        $("#table_body_id").html(html_text);
        table = $("#table_data_my").DataTable({
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
    //All table status chage 
    $(document).on("change","#change_status",function(){
                        var shop_status = $('option:selected',this).attr('data-status_val');
                        var shop_token = $(this).attr('data-All_shop_token');
                        var distributor_token = $(this).attr('data-All_distributor_token');
                        
                        var data = {
                            type : "status_update",
                            shop_status : shop_status,
                            distributor_token : distributor_token,
                            shop_token : shop_token
                        }
                        var json_data = JSON.stringify(data);
                        console.log('all',json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/distributor/rep_add_retailer.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.status_code == 200){ 
                                //$(".se-pre-con").fadeOut();
                                swal("Status Update Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });     
                })
                $(document).on("click","#all_btn",function(){
                $('#total_count').html(all_arr.length);
        })

                $(document).on("click","#pending_btn",function(){
                $('#total_count').html(pending_arr.length);
        })
        var pending_arr = [];
    function pendind_table(datas){
        // console.log('datas',datas);
            console.log('hekk',datas);
                // console.log('this',datas[0].shop_status);
                        var html = ''
                        var slno = 0;
                        datas.forEach(function(item,index){
                            if (item.shop_status == '0') {
                                pending_arr.push(item.retail_code)
                                slno++;
                        html += '<tr>'
                        html += `<td>${slno}</td>`
                        html += `<td>${item.retail_code}</td>`
                        html += `<td>${item.shop_name}</td>`
                        html += `<td>${item.shop_type}</td>`
                        html += `<td>${item.shop_mobile_number }</td>`
                        html += `<td>${item.contact_person }</td>`
                        html += `<td>${item.join_date }</td>`
                        html += `<td>${item.license_number }</td>`
                        
                        html += `<td>
                                <select class="select__status" name="" data-pending_distributor_token='${item.distributor_token}' data-pending_shop_token = ${item.shop_token} data-pending_status_token='${item.shop_status}' id="pending_change_status">
                                <option data-pending_status_val = '1' value="complited${item.shop_status}"  ${item.shop_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-pending_status_val = '0' value="Pending${item.shop_status}"    ${item.shop_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-pending_status_val = '2' value="reject${item.shop_status}"     ${item.shop_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`
                           // html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                        html +='</tr>'
                            }
                            //console.log('status',item.shop_status);       
                });
                $("#pending_body_table").html(html);
                table = $("#pending_table").DataTable({
                                    "scrollX": true,
                                    dom: 'Bfrtip',
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
                
               //}
            
        }
            //pending drop work
        $(document).on("change","#pending_change_status",function(){
                        var shop_status = $('option:selected',this).attr('data-pending_status_val');
                        var distributor_token = $(this).attr('data-pending_distributor_token');
                        var shop_token = $(this).attr('data-pending_shop_token');
                        var data = {
                            type : "status_update",
                            shop_status : shop_status,
                            distributor_token : distributor_token,
                            shop_token : shop_token
                        }
                        var json_data = JSON.stringify(data);
                        console.log('pending',json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/distributor/rep_add_retailer.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.status_code == 200){ 
                                //$(".se-pre-con").fadeOut();
                                swal("Status Update Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });     
                 });
        //========= approved table
        $(document).on("click","#approved_btn",function(){
                $('#total_count').html(app_arr.length);
        })
        var app_arr = [];
        function approved_table(datas){
            // if (datas[0].shop_status == '1') {
                        var html = ''
                        var slno = 0;
                        datas.forEach(function(item,index){
                            //console.log('status',item.shop_status);
                            if (item.shop_status == '1') {
                                app_arr.push(item.retail_code);
                            slno++;
                        html += '<tr>'
                        html += `<td>${slno}</td>`
                        html += `<td>${item.retail_code}</td>`
                        // html += `<td>${item.retail_code}</td>`
                        html += `<td>${item.shop_name}</td>`
                        html += `<td>${item.shop_type}</td>`
                        html += `<td>${item.shop_mobile_number }</td>`
                        html += `<td>${item.contact_person }</td>`
                        html += `<td>${item.join_date }</td>`
                        html += `<td>${item.license_number }</td>`
                        
                        html += `<td>
                                <select class="select__status" name=""data-Approved_distributor_token='${item.distributor_token}'data-Approved_shop_token = ${item.shop_token} data-Approved_status_token='${item.shop_status}' id="Approved_change_status">
                                <option data-Approved_status_val = '1' value="complited${item.shop_status}"${item.shop_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-Approved_status_val = '0' value="Pending${item.shop_status}"${item.shop_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-Approved_status_val = '2' value="reject${item.shop_status}"${item.shop_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`
                           // html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                        html +='</tr>'
                        }
                });
                $("#approved_body_table").html(html);
                table = $("#approved_table").DataTable({
                                    "scrollX": true,
                                    dom: 'Bfrtip',
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
                
               //}
        }

        //Approved drop work
        $(document).on("change","#Approved_change_status",function(){
                        var shop_status = $('option:selected',this).attr('data-Approved_status_val');
                        var distributor_token = $(this).attr('data-Approved_distributor_token');
                        var shop_token = $(this).attr('data-Approved_shop_token');
                        var data = {
                            type : "status_update",
                            shop_status : shop_status,
                            distributor_token : distributor_token,
                            shop_token : shop_token
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/distributor/rep_add_retailer.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.status_code == 200){ 
                                //$(".se-pre-con").fadeOut();
                                swal("Status Update Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });     
                });
        //===== rejected table
        $(document).on("click","#rejected_btn",function(){
                $('#total_count').html(rejected_arr.length);
        })
        var rejected_arr = [];
        function rejected_table(datas){
            //if (datas[0].shop_status == '2') {
                        var html = ''
                        var slno = 0;
                        datas.forEach(function(item,index){
                            if (item.shop_status == '2') {
                                rejected_arr.push(item.retail_code);
                            slno++;
                        html += '<tr>'
                        html += `<td>${slno}</td>`
                        html += `<td>${item.retail_code}</td>`
                        // html += `<td>${item.retail_code}</td>`
                        html += `<td>${item.shop_name}</td>`
                        html += `<td>${item.shop_type}</td>`
                        html += `<td>${item.shop_mobile_number }</td>`
                        html += `<td>${item.contact_person }</td>`
                        html += `<td>${item.join_date }</td>`
                        html += `<td>${item.license_number }</td>`
                        
                        html += `<td>
                                <select class="select__status" name="" data-reject_distributor_token='${item.distributor_token}'data-reject_shop_token = ${item.shop_token} data-reject_status_token='${item.shop_status}' id="rejected_change_status">
                                <option data-rejected_status_val = '1' value="complited${item.shop_status}"${item.shop_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-rejected_status_val = '0' value="Pending${item.shop_status}"${item.shop_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-rejected_status_val = '2' value="reject${item.shop_status}"${item.shop_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`
                           // html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                        html +='</tr>'
                     }
                });
                $("#rejected_body_table").html(html);
                table = $("#rejected_table").DataTable({
                                    "scrollX": true,
                                    dom: 'Bfrtip',
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
                
               //}
        }
        //reject drop work
        $(document).on("change","#rejected_change_status",function(){
                        var shop_status = $('option:selected',this).attr('data-rejected_status_val');
                        var distributor_token = $(this).attr('data-reject_distributor_token');
                        var shop_token = $(this).attr('data-reject_shop_token');
                        var data = {
                            type : "status_update",
                            shop_status : shop_status,
                            distributor_token : distributor_token,
                            shop_token : shop_token
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/distributor/rep_add_retailer.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.status_code == 200){ 
                                //$(".se-pre-con").fadeOut();
                                swal("Status Update Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });     
                });
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
           var data ={
            distributor_token: distributor_token,
        };
        var json_data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/custom_daily_schedule_table.php",
            data: json_data,
        }).done(function(response){
                
        table_main_data = response.data;
        //console.log(table_main_data);
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
           // console.log(table_main_data[key].token);
            slno++;
            html_text += '<tr>';
                html_text += '<td>'+slno+'</td>';
                
                html_text += '<td><div class=""><a class="view_link" id="custom_view_link" data-total_count="'+table_main_data[key].total_unit+'" data-custom_beat_token="'+table_main_data[key].token+'" data-custom_name='+table_main_data[key].customunit_name+'>'+table_main_data[key].customunit_name+'</a></div></td>';
                html_text += '<td>'+table_main_data[key].total_unit+'</td>';
                html_text += '<td>'+table_main_data[key].status+'</td>';
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

    $(document).on("click","#custom_view_link",function(){
        $('#second').show();
        $('#head').hide();
        $("#single_unit_count").html($(this).attr("data-total_count"));
        $("#hide_date").val($(this).attr("data-custom_beat_token"));
        var custom_beat_token = $("#hide_date").val();
        //console.log($("#custom_view_link").attr("data-custom_name"));
        //const custUnitName =;
        $("#custom_single_unit_name").html($("#custom_view_link").attr("data-custom_name"));
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
            console.log(data);
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
                    //console.log(schedule_data[key]);
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_sales_employee">';
                        html_text += '<option value="">-Select Employee-</option>';
                        for (var key1 in sales_data) {     
                            html_text += '<option  value="'+sales_data[key1].token+'">'+sales_data[key1].name+'</option>';
                        }
                        //console.log(sales_data[key1].name);
                        //sales_token = sales_data[key1].token;
                        //console.log("this",sales_token);
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
                // $("#"+schedule_data[key]+"_sales_employee").prop('disabled', false);
                // $("#"+schedule_data[key]+"_delivery_employee").prop('disabled', false);
        }
        // for (var key1 in sales_data) {
        //     $("#sales_man_name").val(sales_data[key1].token);
        // }
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
            console.log(delivery_employee_token,sales_employee_token);
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
        console.log(json_data);
        $.ajax({
            //async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/custom_beat_schedule_update.php",
            data: json_data,
        }).done(function(data) {
            if(data.code == 200){ 
                //$(".se-pre-con").fadeOut();
                swal("Scheduled Successfully!", {icon: "success",}).then((value) => {
                location.reload();
                });           
            }else{
                //$(".se-pre-con").fadeOut();
                let htmlData = ``;
                $.each(data.employee_data, function(index,data) {
                        console.log("data",data);
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
        $("#single_unit_count2").html($("#custom_view_link").attr("data-total_count"));
        $("#single_cus_unit_name2").html($("#custom_view_link").attr("data-custom_name"));

        var custom_beat_token = $("#hide_date").val();
        var data ={
            custom_beat_token : custom_beat_token,
            distributor_token : distributor_token
        }
        var json_data = JSON.stringify(data);
        $.ajax({
            type : "POST",
            url :api_path +"/distributor/custom_beat_units_list.php",
            data: json_data,
        }).done(function(res){
                var count = 1;
                var html = ""
                for (var key in res) {
                    html += '<tr>'
                    html+='<td>'+ count++ +'</td>'
                    html+='<td><a class="view_link" id ="beat_token" data-cus_shops_count="'+res[key].shop_count+'" data-beat_token="'+res[key].beat_tokens+'" data-beats="'+res[key].beat_names+'" onclick="view_unitpage()">'+ res[key].beat_names+ '</a></td>'
                    html+='<td>'+ res[key].shop_count+'</td>'
                    html+='</tr>';
                }
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
    var table1_check = false;
    function view_page(key){
        //$(".se-pre-con").fadeIn();
        $("#update_schedule_button_id").css("display","block");
        $("#update_schedule_button_id").prop('disabled', false);
        if(table1_check){
            table1.clear();
            table1.destroy();
        }
        $("#update_schedule_key").val(key);
        var token = table_main_data[key].token;
        //console.log(token);
        $("#update_schedule_token").val(token);
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            unit_token:token,
            type: "schedule_list"
        };
        var json_data = JSON.stringify(datas);
        console.log(json_data);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/unit_schedule_list.php",
            data: json_data,
        }).done(function(data) {
            console.log(data);
            var schedule_data = data.data;
            var sales_data    = data.salesData;
            var delivery_data = data.deliveryData;
            var html_text = "";
            for (var key in schedule_data) {
                html_text += '<tr>';
                    html_text += '<td>'+schedule_data[key].sl_no+'</td>';
                    html_text += '<td>'+schedule_data[key].day_val+'</td>';
                    html_text += '<td>';
                   
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_sales_employee">';
                         html_text += '<option value="">-Select Employee-</option>';
                        for (var key1 in sales_data) {     
                            html_text += '<option value="'+sales_data[key1].token+'">'+sales_data[key1].name+'</option>';
                        }
                        html_text += '</select>';
                    html_text += '</td>';
                    html_text += '<td>';
                        html_text += '<select class="table-select option" id="'+schedule_data[key].day_val+'_delivery_employee">';
                        html_text += '<option value="">-Select Employee-</option>';
                        for (var key2 in delivery_data) {   
                            html_text += '<option value="'+delivery_data[key2].token+'">'+delivery_data[key2].name+'</option>';
                        }
                        html_text += '</select>';    
                    html_text += '</td>';
                html_text += '</tr>';
            }
            $("#schedule_table_body").html(html_text);
            for (var key in schedule_data) {
                
                    $("#"+schedule_data[key].day_val+"_sales_employee" ).val(schedule_data[key].sales_employee_token);
                    $("#"+schedule_data[key].day_val+"_delivery_employee" ).val(schedule_data[key].delivery_employee_token);
                    $("#"+schedule_data[key].day_val+"_sales_employee").prop('disabled', false);
                    $("#"+schedule_data[key].day_val+"_delivery_employee").prop('disabled', false);
            }
        });
        // $(".se-pre-con").fadeOut();
        $('#head').hide();
        $('#first').show();
        $("#single_unit_name").html(table_main_data[key].name);
        $("#single_shop_count").html(table_main_data[key].shop_count);
        $("#single_view_button").html('<a href="javascript:void(0)" class="view_link" onclick="view_list('+key+')">View Shop List</a>');
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
        //$(".se-pre-con").fadeIn();
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
            //$(".se-pre-con").fadeOut();
        });
    }

    var schedule_days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    function update_schedule(){
      //$(".se-pre-con").fadeIn();
        var token = $("#update_schedule_token").val();
        //console.log(token);
        var update_array = []
        for (var key in schedule_days) {
            var sales_employee_token   = $("#"+schedule_days[key]+"_sales_employee").val();
            var delivery_employee_token = $("#"+schedule_days[key]+"_delivery_employee").val();
            console.log(delivery_employee_token,sales_employee_token);
            var data = {
                day_value: schedule_days[key],
                sale_employee: sales_employee_token,
                delivery_employee: delivery_employee_token
            };
            update_array.push(data);
        }
        //console.log(update_array);
        var datas = {
            unit_token: token,
            update_array: update_array,
            dashboard_code: verfication_code,
             distributor_token: distributor_token
        };
        var json_data = JSON.stringify(datas);
        //console.log(json_data);
        $.ajax({
            async:false,
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/schedule_update.php",
            data: json_data,
        }).done(function(data) {
            console.log(data);
            if(data.code == 200){ 
                $(".se-pre-con").fadeOut();
                swal("Scheduled Successfully!", {icon: "success",}).then((value) => {
                location.reload();
                });           
            }else{
                //$(".se-pre-con").fadeOut();
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

</script>
<script>
        //  const statusSelectBtn = document.querySelectorAll('.select__status');

        //         document.body.addEventListener('change', function(e) {
        //         console.log(e);
        //         const clickedSelectBtn = e.target.classList.contains('select__status');
        //         const statusSelectBtn = e.srcElement;
        //         const statusSelectBtnValue = statusSelectBtn.value;
                
        //         if(clickedSelectBtn) {
        //             let bgColor;
        //             let color;
                    
        //             switch (statusSelectBtnValue) {
        //             case 'success':
        //                 bgColor = '#11a14a';
        //                 color = '#fff';
        //                 break;
                        
        //             case 'pending':
        //                 bgColor = '#d0893a';
        //                 color = '#fff';
        //                 break;
        //             case 'reject':
        //                 bgColor = '#ba212e';
        //                 color = '#fff';
        //                 break;
                        
        //             }
        //             console.log(bgColor, color);
        //             statusSelectBtn.style.backgroundColor = bgColor;
        //             statusSelectBtn.style.color = color;
        //             statusSelectBtn.style.border = bgColor;
        //         }
        //         })
    </script>
</body>
</html>
<?php
}
?>