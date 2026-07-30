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
        <title>Power Soaps</title>
        <link rel="shortcut icon" href="assets/favi.png">

        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
        <style>
        .a_button {
            color: #00b9f5;
        }
        .twoinspace img{
            width: 30px;
            margin: 10px
        }
        .a_button:hover {
            color: #fff;
        }
        a {
            cursor: pointer;
        }
        #table_data1{
            display:table;
        } 
        .btn_employees:hover .a_button {
            color: #fff;
        }
        #area_select{
            display: none;
        }
        
        h1.header_main img {
            width: 40px;
            margin-right: 1rem;
        }
        .custom-nav{
            border-bottom: 1px solid #D9D9D9;
            display:flex;
            align-items: center;
            flex-wrap: nowrap;
            white-space: nowrap;
        }
        .scrollbar {    
            overflow-x: scroll;
        }
        
        #style-1::-webkit-scrollbar-track
        {
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
            border-radius: 0;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar
        {
            height: 10px;
            background-color: #F5F5F5;
            display: block !important;
        }

        #style-1::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            background-color: #c9c9c9;
        }
        .custom-nav__item{
            padding: 8px 24px;
            border-bottom:1px solid transparent;
            cursor: pointer;
            color: var(--light-gray);
            font: 15px var(--medium-font);
        }
        .custom-nav__item a {
            padding: 7px 15px;
            color: #000;
        }
        .custom-nav__item a.active {
            background-color: #f3f7fa;
            border-bottom: 2px solid #04bcf4;
        }
        label {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .dataTables_filter label {
            top: 10px;
        }
        </style>
    </head>

    <body>
        <div class="se-pre-con"></div>
        <div><p>region management</p></div>

        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar15"></div>

        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;">
                <div class="scrollbar" id="style-1">
                    <ul class="custom-nav nav nav-pills statewise force-overflow" id="stateList"></ul>
                </div>
            </section>
            
            <section class="bg-white brad-4 full-height" id="region_close">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main">region</h1>
                        </div>
                        <p class="table_count">Total region - <span id="total_shopType_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter" id="button">
                    <form class="formdield">
                        <div class="form-group">
                            <button class="btn_employee " class="btn btn-danger" data-toggle="modal" data-target="#state" type="button">Add State </button>
                        </div>
                        <div class="form-group">
                            <button class="btn_employee " class="btn btn-danger" data-toggle="modal" data-target="#form" type="button">Add Region </button>
                        </div>
                        <div class="form-group">
                            <button class="btn_employee " data-toggle="modal" data-target="#select_area_from" type="button">Add Area </button>
                        </div>
                    </form>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Region Name</th>
                                <th>State Name</th>
                                <th style="display:none;">Area Search</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_Shop">
                        </tbody>
                    </table>
                </div>
            </section>
            
            <section class="bg-white brad-4 full-height" id="area_select">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="close_area()" alt=""></span><span id="regionName"></span></h1>
                        </div>
                        <p class="table_count"><span id="total_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter1"></div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>Area Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class = "table_body">
                        </tbody>
                    </table>
                </div>
            </section>
            
            <!-- Modals -->
            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add Region Name</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control state_name_box">
                                    <p class="state_name">State</p>
                                </div>
                                <div class="form-control region">
                                    <p class="region_name">Region Name</p>
                                    <input class="input-field" id="region_name" placeholder="Enter Region Name" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" onclick="add_region_name()">Add Region Name</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="state" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add State Name</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control region_name_box">
                                    <p class="region_name">State Name</p>
                                    <input class="input-field newStatevalue" id="State_name" placeholder="Enter State Name" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" onclick="addStatefunction()">Add State</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="select_area_from" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add Area Name</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control staName">
                                    <p class="state_name">State</p>
                                    <select class="input-field state" id="staName"></select>
                                </div>
                                <div class="form-control regName">
                                    <p class="region_name">Region</p>
                                    <select class="input-field" id="rName"></select>
                                </div>
                                <div class="form-control">
                                    <p class="area_name">Area Name</p>
                                    <input class="input-field newAreaValue" id="Area_name" placeholder="Enter Area Name" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" onclick="addAreaFunction()">Add Area Name</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="formUpdate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Region Name</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms edit_regionStateData">
                                <input id="edit_region_name_token" type="hidden">
                                <div class="form-control edit_region_name_box">
                                    <p class="edit_region_name">Region Name</p>
                                    <input class="input-field" id="edit_region_name" placeholder="Enter Region Name" value="">
                                </div>
                                <div class="form-control edit_state_name_box">
                                    <p class="edit_state_name">State</p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="update_region_button" onclick="update_regionname()">Update Region Name</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="formarea" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Area Name</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms edit_areaData">
                                <input id="edit_area_name_token" type="hidden">
                                <div class="form-control edit_area_name_box">
                                    <p class="edit_region_name">Area Name</p>
                                    <input class="input-field" id="edit_area_name" placeholder="Enter Area Name" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="update_region_button" onclick="update_areaname()">Update Area Name</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
            
            var current_active_region_token = "";
            var current_active_state_token = "";

            $('#datepicker').datepicker({ autoclose: true, todayHighlight: true });
            $('#datepicker1').datepicker({ autoclose: true, todayHighlight: true });

            function open_area(){
                $("#area_select").show();
                $("#region_close").hide();
            }
             
            function close_area(){
                $("#region_close").show();
                $("#area_select").hide();
            }
            
            function back_view_order(){
                location.reload();
            }
            
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";

            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas){
                    let data = datas;
                    let html_text="";
                    for (let key in data) {
                         html_text += `<li class="custom-nav__item" data-id="${data[key].state_token}"><a href="#" data-toggle="tab">${data[key].state_name}</a></li>`;
                    }
                    $('#stateList').html(html_text);
                });
                datavalue(admin_state_id);
            });

            function datavalue(admin_state_id){
                var datas = {
                    dashboard_code: verfication_code,
                    state_id:admin_state_id,
                    type: "All"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/addRegion.php",
                    data: json_data,
                    success: success,
                });
            }

            $("body").on("click",".statewise li" ,function(){
                $("#button").hide();
                close_area();
                admin_state_id = $(this).data("id"); 
                table.clear();
                table.destroy();
                datavalue(admin_state_id);
            });

            var table_main_data;
            function success(data) {
                table_main_data = data.data;
                var html_text = "";
                var slno = 0;
                for (var key in table_main_data) {
                    slno++;
                    html_text += '<tr>';
                    html_text += '<td>' + slno + '</td>';
                    html_text += `<td><a href="javascript:void(0)" id="opendata" data-token="${table_main_data[key].region_token}" data-tok="${table_main_data[key].state_token}"> ${table_main_data[key].region_name} </a></td>`;
                    html_text += '<td>' + table_main_data[key].state_name + '</td>';
                    
                    // --- புதிய ஏரியா சர்ச் லாஜிக் (மறைமுக <td>) ---
                    // ஆரம்பத்தில் காலியாக இருக்கும், கீழே உள்ள AJAX லூப் மூலம் இது நிரப்பப்படும்
                    html_text += `<td style="display:none;" class="search_areas_${table_main_data[key].region_token}"></td>`;
                    
                    html_text += '<td><a><img src="assets/edit.png" class="edit_input" onclick="edit(' + key + ')" alt=""></a><a style="margin-left: 10px"><img style="width: 30px;height: 30px;" src="assets/delete.svg" class="edit_input" onclick="delete_data(' + key + ')" alt=""></a></td>';
                    html_text += '</tr>';
                }
                $(".se-pre-con").hide();
                $("#table_body_Shop").html(html_text);
                key++;
                $("#total_shopType_count").html(key);
                
                // DataTables-ஐ இனிஷியலைஸ் செய்கிறோம்
                table = $("#table_data1").DataTable({
                    lengthChange:true,
                    dom: 'Bfrltip',
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
                    buttons: [],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search",
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });

                // --- டிராப் டவுன் டேட்டாக்களைப் பின்னணியில் எடுத்து சர்ச் பாக்ஸிற்குள் சேர்க்கிறோம் ---
                for (var k in table_main_data) {
                    (function(reg_token, st_token) {
                        var area_req = { 'region_token': reg_token, 'state_token': st_token };
                        $.ajax({
                            type: "POST",
                            url: api_path + "/admin/areaViewPage.php",
                            dataType: "json",
                            data: JSON.stringify(area_req),
                            success: function(area_res) {
                                if(area_res && area_res.length > 0) {
                                    var names_arr = [];
                                    area_res.forEach(function(a_item) {
                                        names_arr.push(a_item.area_name);
                                    });
                                    var all_areas_string = names_arr.join(", ");
                                    
                                    // டேட்டாபேஸ் லெவலில் புதுப்பித்து, டேட்டா டேபிளை ரீ-இண்டெக்ஸ் செய்கிறோம்
                                    var cell_selector = `.search_areas_${reg_token}`;
                                    $(cell_selector).html(all_areas_string);
                                    
                                    // DataTables-க்கு இந்த புதிய டேட்டாவைத் தெரியப்படுத்துகிறோம் (பக்கத்தை ரீலோடு செய்யாமல்)
                                    var row_element = $(cell_selector).closest('tr');
                                    if(row_element.length > 0) {
                                        table.row(row_element).invalidate().draw(false);
                                    }
                                }
                            }
                        });
                    })(table_main_data[k].region_token, table_main_data[k].state_token);
                }

                var stateList = data.data_state;
                var state_html = '';
                if(stateList.length == 1){
                    state_html += '<input class="input-field" id="state" value="'+stateList[0].state_name+'" readonly>';
                    state_html += '<input type="hidden" class="input-field" id="state_name" value="'+stateList[0].state_token+'">';
                }else{
                    state_html += '<select class="input-field state" id="state_name">';
                    state_html += '<option value="">Select state</option>';
                    for(var key in stateList){
                        state_html += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                    }
                    state_html += '</select>'; 
                }
                $(".state_name_box").html("<p class='state_name'>State</p>" + state_html);
               
                var state_html_area = '';
                if(stateList.length == 1){
                    state_html_area += '<option value="'+stateList[0].state_token+'">'+stateList[0].state_name+'</option>';
                    state_html_area += '<input type="hidden" class="input-field" id="staName" value="'+stateList[0].state_token+'">';
                }else{
                    state_html_area += '<option value="">Select state</option>';
                    for(var key in stateList){
                        state_html_area += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                    }
                }
                $("#staName").html(state_html_area);

                var edit_state_html = '';
                if(stateList.length == 1){
                    edit_state_html += '<input class="input-field" id="edit_state" value="'+stateList[0].state_name+'" readonly>';
                    edit_state_html += '<input type="hidden" class="input-field" id="edit_state_name" value="'+stateList[0].state_token+'">';
                }else{
                    edit_state_html += '<select class="input-field" id="edit_state_name">';
                    edit_state_html += '<option value="">Select state</option>';
                    for(var key in stateList){
                        edit_state_html += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                    }
                    edit_state_html += '</select>'; 
                }
                $(".edit_state_name_box").html("<p class='edit_state_name'>State</p>" + edit_state_html);
            }

            $("#shop_type,#edit_shop_type_name").keydown(function(event) {
                if (event.keyCode == 32 && this.value.length == 0) {
                    event.preventDefault();
                }
            });

            if(admin_state_id == 0){
                $(document).on("change","#staName",function(){
                     var state_token = $(this).val();
                     var data = { "state_token" : state_token };
                     var json_data = JSON.stringify(data);
                     $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/state_and_region.php",
                        data: json_data,
                     }).done(function(res_data){
                            var html_text = '<option value="">Select Region</option>';
                            res_data.area_data.forEach(function(item,index){
                                html_text += `<option value="${item.region_token}">${item.region_name}</option>`;
                            });
                            $("#rName").html(html_text);
                     });
                });
            }else{
                var data = { "state_token" : admin_state_id };
                var json_data = JSON.stringify(data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/state_and_region.php",
                    data: json_data,
                }).done(function(res_data){
                    var html_text = '<option value="">Select Region</option>';
                    res_data.area_data.forEach(function(item,index){
                        html_text += `<option value="${item.region_token}">${item.region_name}</option>`;
                    });
                    $("#rName").html(html_text);
                });
            }

            function addAreaFunction() {
                var state_token = $("#staName").val();
                var region_token = $("#rName").val();
                var area=$('.newAreaValue').val();
                var val3= value_check('newAreaValue', area, 'text_box');
                if(val3==true){
                    var datas={
                        'state_token':state_token,
                        'region_token':region_token,
                        'area':area
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/areaViewInsert.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.code == "201") {
                            swal("Area Added Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                $('#select_area_from').modal('hide');
                                $('.newAreaValue').val('');
                                if(current_active_region_token != ""){
                                    particular_area(current_active_region_token, current_active_state_token);
                                } else {
                                    location.reload();
                                }
                            });
                        } else {
                            swal(data.message);
                        }
                    });
                } else {
                    swal("Please Enter Area Name");
                 }
            }

            $(document).on("click", '#opendata', function() {
                current_active_region_token = $(this).attr('data-token');
                current_active_state_token = $(this).attr('data-tok');
                
                open_area();
                particular_area(current_active_region_token, current_active_state_token);
            });
               
            function particular_area(region_token,state_token){
                var datas={
                    'region_token':region_token,
                    'state_token':state_token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    url: api_path + "/admin/areaViewPage.php",
                    dataType: "json",
                    data: json_data,
                    success : function(response){
                        if(response.length > 0){
                            $("#regionName").html(response[0].region_name);
                        }
                        $("#total_count").html(`Total area - ${response.length}`);
                        let accessList = "";
                        response.forEach(function(item,index){
                            accessList += `<tr>
                                <td>${index+1}</td>
                                <td>${item.area_name}</td>
                                <td>
                                    <a><img src="assets/edit.png" class="edit" data-token="${item.area_token}" data-tok="${item.area_name}"></a>
                                    <a style="margin-left: 10px"><img style="width: 30px;height: 30px; cursor:pointer;" src="assets/delete.svg" onclick="delete_area('${item.area_token}')" alt="Delete"></a>
                                </td>
                            </tr>`;
                        });
                        $(".table_body").html(accessList);
                    }
                 });
            }

            function add_region_name() {
                var region_name = $("#region_name").val();
                var val1 = value_check('region_name', region_name, 'text_box');
                var state_token = $("#state_name").val();
                var val2 = value_check('state_name', state_token, 'text_box');
                if (val1 == true && val2 == true) {
                    var datas = {
                        'dashboard_code': verfication_code,
                        'region_name': region_name,
                        'state_token': state_token,
                        'type': "AddRegionName"
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/addRegion.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == "200") {
                            swal("Region Added Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal(data.message);
                        }
                    });
                } else {
                    swal("Please Enter Region Name");
                }
            }

            function addStatefunction(){
                let stateName = $(".newStatevalue").val();
                let datas = { 'stateName': stateName };
                let data = JSON.stringify(datas);
                if(stateName != ""){
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/addState.php",
                        data: data,
                    }).done(function(data) {
                        if (data.status_code == "200") {
                            swal("State Added Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal(data.message);
                        }
                    });
                }else{
                    swal("Please Enter State Name");
                }
            }

            function edit(key) {
                $("#edit_region_name_token").val(table_main_data[key].region_token);
                $("#edit_region_name").val(table_main_data[key].region_name);
                $("#edit_state_name").val(table_main_data[key].state_token);
                $("#edit_state").val(table_main_data[key].state_name);
                $("#formUpdate").modal('show');
            }

            function update_regionname() {
                var region_token = $("#edit_region_name_token").val();
                var region_name = $("#edit_region_name").val();
                var val1 = value_check('edit_region_name', region_name, 'text_box');
                var state_token = $("#edit_state_name").val();
                var val2 = value_check('edit_state_name', state_token, 'text_box');
                if (val1 == true && val2 == true) {
                    var datas = {
                        'dashboard_code': verfication_code,
                        'region_token': region_token,
                        'region_name': region_name,
                        'state_token': state_token,
                        'type': "UpdateRegionName"
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/addRegion.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == "200") {
                            swal("Updated Region Name Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal(data.message);
                        }
                    });
                } else {
                    swal("Please Enter Region Name");
                }
            }

            $(document).on("click",'.edit',function() {
                var area_token=$(this).attr('data-token');
                var area_name = $(this).attr('data-tok');
                updatearea(area_token,area_name);
            });

            function updatearea(area_token,area_name){
                $("#edit_area_name_token").val(area_token);
                $("#edit_area_name").val(area_name);
                $("#formarea").modal('show');
            }

            function update_areaname(){
                var area_token= $("#edit_area_name_token").val();
                var area_name =$("#edit_area_name").val();
                var val1 = value_check('edit_area_name', area_name, 'text_box');
                if(val1==true){
                    var datas={
                         'area_token':area_token,
                         'area_name':area_name
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateArea.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.code == "201") {
                            swal("Updated Area Name Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                $("#formarea").modal('hide');
                                particular_area(current_active_region_token, current_active_state_token);
                                
                                // மெயின் பக்கத்தில் மறைமுகமாக இருக்கும் ஏரியா பெயரையும் உடனே ரீஃப்ரெஷ் செய்கிறோம்
                                var cell_selector = `.search_areas_${current_active_region_token}`;
                                var area_req = { 'region_token': current_active_region_token, 'state_token': current_active_state_token };
                                $.ajax({
                                    type: "POST",
                                    url: api_path + "/admin/areaViewPage.php",
                                    dataType: "json",
                                    data: JSON.stringify(area_req),
                                    success: function(area_res) {
                                        if(area_res) {
                                            var names_arr = [];
                                            area_res.forEach(function(a_item) { names_arr.push(a_item.area_name); });
                                            $(cell_selector).html(names_arr.join(", "));
                                            table.row($(cell_selector).closest('tr')).invalidate().draw(false);
                                        }
                                    }
                                });
                            });
                        } else {
                            swal(data.message);
                        }
                    });
                }else{
                    swal("Please Enter Area Name");
                }
            }

            function delete_area(area_token) {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this area!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var datas = { 'area_token': area_token };
                        var json_data = JSON.stringify(datas);
                        
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/deleteArea.php", 
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == "200" || data.code == "201") { 
                                swal("Area has been deleted!", {
                                    icon: "success",
                                }).then((value) => {
                                    particular_area(current_active_region_token, current_active_state_token);
                                    
                                    // டெலீட் ஆனதும் மெயின் டேபிள் குள்ள இருக்கும் மறைமுக ஏரியா பெயரையும் ரீஃப்ரெஷ் செய்கிறோம்
                                    var cell_selector = `.search_areas_${current_active_region_token}`;
                                    var area_req = { 'region_token': current_active_region_token, 'state_token': current_active_state_token };
                                    $.ajax({
                                        type: "POST",
                                        url: api_path + "/admin/areaViewPage.php",
                                        dataType: "json",
                                        data: JSON.stringify(area_req),
                                        success: function(area_res) {
                                            var names_arr = [];
                                            if(area_res) {
                                                area_res.forEach(function(a_item) { names_arr.push(a_item.area_name); });
                                            }
                                            $(cell_selector).html(names_arr.join(", "));
                                            table.row($(cell_selector).closest('tr')).invalidate().draw(false);
                                        }
                                    });
                                });
                            } else {
                                swal(data.message);
                            }
                        });
                    }
                });
            }

            function delete_data(key) {
                var region_token = table_main_data[key].region_token;
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this region!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'dashboard_code': verfication_code,
                            'region_token': region_token,
                            'type': "DeleteRegionName"
                        };
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/addRegion.php", 
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == "200") {
                                swal("Region has been deleted!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            } else {
                                swal(data.message);
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