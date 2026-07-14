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
        <title>Power Soaps </title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- <link rel="stylesheet" href="css/bootstrap-select.min.css<?php echo $js_cache_string; ?>"> -->
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> -->
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    </head>
    <style>
        a {
            cursor: pointer;
        }

        select {
            appearance: none;
            outline: none;
            background: url(assets/down-arrow.png) no-repeat;
            background-size: 16px;
            background-position: 96% 50%;
            cursor: pointer;
        }

        .selection .select2-selection--multiple {
            border: 1px solid #ced4da;
        }

        .select2-search__field {
            width: 663px !important;
        }

        span#mandatory_icon {
            color: red;
        }
        .custom-table tbody tr td button{
            padding: 6px 18px;
            color: #fff;
            background: #00b9f6;
            border-radius: 4px;
            border: none;
        }
        .reupload{
            color: #00b9f5;
            cursor: pointer;
        }
        .pdf-btn {
            background: #bc87f0 !important;
            padding: 6px 15px;
            border-radius: 4px;
        }
        .attach_img iframe {
            border: 1px solid #ccc;
            margin: 5px;
            width: 100px;
            height: 100px;
            object-fit: contain;
        }
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
        @media only screen and (max-width:1600px) {
            #table_data_wrapper .row:nth-child(2) .col-sm-12 {
                display: block;
            }
            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar {
                display: block;
                background-color: #000;
                height: 4px;
                border-radius: 16px;
            }
            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar-thumb {
                background-color: #232a77;
            }

            #table_data_wrapper .row:nth-child(2) .col-sm-12::-webkit-scrollbar-track {
                background-color: #cacaca;
            }
        }
        table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before {
            content: "";
        }
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            content: "";
        }
    </style>

    <body class = "bodytoken" data-token = "<?php echo $_POST['usertoken'] ?>">
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar44"></div>
        <!-- main-contents -->
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
                                        
                                        <td><a href="javascript:void(0)" class="view_link employee_code_view">DIST95542951</a></td>
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
        
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
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
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="js/select2.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script>
            var pdfjsLib = window['pdfjs-dist/build/pdf'];
            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>
        
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            $(".se-pre-con").hide();
            $(document).ready(function() {
               var distributorToken =  localStorage.getItem("distributor_token");
              
            });
            var all_arr = [];
        $(document).ready(function(){
            var distributor_token =  localStorage.getItem("distributor_token");
            console.log('distributor_token',distributor_token);
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
                });

                $(document).on("click","#pending_btn",function(){
                    $('#total_count').html(pending_arr.length);
                });

                var pending_arr = [];
                function pendind_table(datas){
                console.log('hekk',datas);
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
                        html +='</tr>'
                            }     
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
        }
            //========= approved table
        $(document).on("click","#approved_btn",function(){
                $('#total_count').html(app_arr.length);
        })
        var app_arr = [];
        function approved_table(datas){
                        var html = ''
                        var slno = 0;
                        datas.forEach(function(item,index){
                            if (item.shop_status == '1') {
                                app_arr.push(item.retail_code);
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
                                <select class="select__status" name=""data-Approved_distributor_token='${item.distributor_token}'data-Approved_shop_token = ${item.shop_token} data-Approved_status_token='${item.shop_status}' id="Approved_change_status">
                                <option data-Approved_status_val = '1' value="complited${item.shop_status}"${item.shop_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-Approved_status_val = '0' value="Pending${item.shop_status}"${item.shop_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-Approved_status_val = '2' value="reject${item.shop_status}"${item.shop_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`
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
            

        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>