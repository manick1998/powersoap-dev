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
        <title>Power Soap | Offer</title>
        <link rel="shortcut icon" href="assets/favicon.ico">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.30.2/minified.js"></script>
       
        <style>
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
                    background-position: 96% 50%;
                    
                }
            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border: none !important;
                outline: 0;
            }
            .select2-container--default .select2-selection--multiple{
                border: none !important;
            }
            .form-control {
                margin: 20px 0;
            }
            .marginzero{
                margin: 0;
            }
            .form-control p {
                margin: 0;
                color: #798893;
                font-size: 14px;
                font-weight: 600;
                line-height: 20px;
                text-align: left;
            }
            #exTab {
                padding: 10px 0;
            }
            #exTab .nav-pills > li > a {
                border-radius: 0;
                padding: 10px 15px;
                border: 1px solid #00b9f6;
                color: #00b9f6;
            }
            #exTab .nav-pills > li > a.active {
                background-color: #00b9f6;
                color: #fff;
            }
            .tab-content {
                padding : 0;
            }
            h1.header_main img {
              width: 40px;
             margin-right: 1rem;
           }
            .input-field {
                border: none;
                color: #333;
                width: 100%;
                font-size: 16px;
                line-height: 20px;
                outline: none;
            }
            #map-canvas {
                width: 100%;
                height: 400px;
            }
            .delete-cls {
                cursor: pointer;
            }
            #map {
                height: 500px;
            }
            .gm-style-iw.gm-style-iw-c {
                padding-right: 12px !important;
                padding-bottom: 10px !important;
            }
            .cred-btn-box .nav-link.active {
            color: #fff;
            background-color: #04bcf4 !important;
            border: 1px solid #04bcf4;
            border-radius: 4px;
            }
            .product_list button {
            margin-left: 30px;
            border: 1px solid #03bcf4;
            background: #fff;
            color: #03bcf4;
            }
            .cred-btn-box {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            .pdf-btn {
                background: #bc87f0 !important;
                padding: 8px 15px;
                border-radius: 4px;
                color: #fff !important;
                border: 1px solid #bc87f1 !important;
                height: 38px;
            }

            @media only screen and (max-width:1100px){
                #table_data1{
                    display: block;
                    overflow: hidden;
                    overflow-x: scroll;
                }
            }
            #regionrep{
                display:none;
            }
            #areaRep{
                display:none;
            }
            #area_dis{
                display:none;
                
            }

            .custom-nav{
                border-bottom: 1px solid #D9D9D9;
                display:flex;
                align-items: center;
            }
            .custom-nav{
            border-bottom: 1px solid #D9D9D9;
            display:flex;
            align-items: center;
            flex-wrap: nowrap;
            white-space: nowrap;
            /* overflow: auto; */
        }

                    .scrollbar
            {	
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

            #style-1::-webkit-scrollbar-thumb
            {
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
            .custom-nav__item:hover {
                background-color: #f3f7fa;
            }
            .custom-nav__item a {
                padding: 7px 15px;
                color: #000;
            }
            .custom-nav__item a.active {
                background-color: #f3f7fa;
                border-bottom: 2px solid #04bcf4;
            }

            .custom-nav.statewise {
                flex-wrap: nowrap;
                padding-bottom: 12px;
                /* overflow-x: auto; */
            }
            .custom-nav.statewise a {
                white-space: nowrap;
            }
           
        </style>
    </head>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar3"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;">
            <div class="scrollbar" id="style-1">
                <ul class="custom-nav nav nav-pills statewise force-overflow" id="stateList">
                </ul>

            </div>
            </section>
            <section class="bg-white brad-4 full-height" id="salesrep">
                <div class="header_container">
                    <div>
                    <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span></h1>
                        <h1 class="header_main">Schedule List</h1>
                        <!--<span class="table_count">Total Sales Rep<span id="total_salesRep_count"></span></span>-->
                        <div id="exTab">	
                            <ul  class="nav nav-pills">
                                <li class="active"><a  href="#1b" class="active show" data-toggle="tab">Today's History</a></li>
                                <li><a href="#2b" data-toggle="tab">Schedule History</a></li>
                                <li><a href="#routerequest" data-toggle="tab">Route Request</a></li>
                            </ul>
                            
                        </div>

                        
                    </div>
                </div>

                <div class="tab-content clearfix">
                    <div class="tab-pane active" id="1b">

                         <div class="cred-btn-box">
                            <button class="primary-btn" data-toggle="modal" data-target="#Create_mod">Create Schedule</button>
                            <button onclick="show_ProductCSV()" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                            <button onclick="show_ProductPDF()" class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                        </div>
                        <div class="table-box">
                            <table class="custom-table" id="table_data1">
                                <thead>
                                    <tr>
                                        <th>slno</th>
                                        <th>Sales Rep Name</th>
                                        <th>Scheduled Date</th>
                                        <th>State</th>
                                        <th>Region</th>
                                        <th>TA</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body_Sales1">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="2b">
                            <div class="cred-btn-box">
                                <div>
                                    <input class="form-control box_form" name="date" id="fromDate" onchange="date_filter()"  type="text" placeholder="From Date" readonly>
                                </div>
                                <div>
                                    <input class="form-control box_form" name="date" id="toDate"  onchange="date_filter()" type="text" placeholder="To Date" readonly>
                                </div>
                                    <button onclick="show_ScheduleListPDF()" class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                            </div>
                            <div class="table-box">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>slno</th>
                                            <th>Sales Rep Name</th>
                                            <th>Track Location</th>
                                            <th>View Log</th>
                                            <th>Scheduled Date</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Expense Amount</th>
                                            <th>TA</th>
                                            <!-- /<th>Total Order Amount</th> -->
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_Sale">
                                    </tbody>
                                </table>
                            </div>
                     </div>
                    <div class="tab-pane" id="routerequest">
                            <div class="cred-btn-box">
                               <button class="primary-btn" style="margin-bottom: 1rem;">Create Schedule</button>
                            </div>
                            <div class="table-box">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>slno</th>
                                            <th>Scheduled Date</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Action</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Test Sales Rep 4</td>
                                            <td>09-08-2023</td>
                                            <td>Tamilnadu</td>
                                            <td>Chennai</td>
                                            <td>
                                                <a id="editSales" data-toggle="modal" data-target="#editmod" data-date="09-08-2023" data-token="95202743"><img src="assets/edit.png" class="edit_input" alt="" /></a>
                                            </td>
                                            <td>
                                                 <select class="select__status" name="" id="">
                                                    <option value="success">Approved</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="reject">Rejected</option>
                                                </select>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                     </div>
        </div>
                  

            </section>
            
        </main>
      
    
        

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        </script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
       <!-- datepicker-->
       <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/polyfill.min.js<?php echo $js_cache_string; ?>"></script>
        <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbV6guze9AOGJf91eU07rfrrK0qnICW1E&callback=initMap&v=weekly"
      defer
></script>

         
        
        
        <script>
            //date picker
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                $('#datePicker').attr('min',today);
            //multi select
        var data = ["Chennai", "Thrichy", "Madurai", "Theni", "Coimbatore"]; // Programatically-generated options array with > 5 options
        var placeholder = "select";
        $(".mySelect").select2({
            data: data,
            placeholder: placeholder,
            allowClear: false,
            minimumResultsForSearch: 5
        });
        var placeholder = "select";
        $(".myselect").select2({
            data: data,
            placeholder: placeholder,
            allowClear: false,
            minimumResultsForSearch: 5
        });
    
        
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
      
            function back_view_order(){
                location.reload();
            }

        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table;
        var table1;
        $(document).ready(function() {
            let value = {
                type: "salesRep"
            };
            var json_data = JSON.stringify(value);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas) {
                let data = datas.data;
                let html_text = '<option value="">Select SalesRep</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].employee_token}">${data[key].employee_name}</option>`;
                    }
                    $('#sales_rep_names').html(html_text);
            });
            //allstate
            let state = {
                type: "allstate"
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
                $('#salesState').html(html_text);
                $('#selectsalesState').html(html_text);
            });

            //all region
            let region = {
                type: "allregion"
            };
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
                $('#selectsalesRegion').html(html_text);
            });

            //all Areas
            let areas = {
                type: "allareas"
                
            };
            var json_data = JSON.stringify(areas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                let html_text = '<option value="">Select Area</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].area_token}">${data[key].area_name}</option>`;
                }
                    $('#scheduleArea').html(html_text);
                        $('#scheduleArea').select2({
                            closeOnSelect: false,
                            placeholder: "Please select Area"
                        });
            });

             //all distributor
             let dist = {
                type: "alldistributor",
            };
            var json_data = JSON.stringify(dist);
            //console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data:json_data,
            }).done(function(datas){
                let data = datas.data;
                //console.log(data);
                let html_text = '<option value="">Select distributors</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].token}">${data[key].name}</option>`;
                }
                    $('#scheduledistributor').html(html_text);
                        $('#scheduledistributor').select2({
                            closeOnSelect: false,
                            placeholder: "Please select distributor"
                        });
            });

            //stateonchange
            $('#salesState').on('change',function(){
                $("#regionrep").css("display", "block");
                let stateToken = $(this).find(':selected').val();
                let obj={
                    stateToken:stateToken,
                    type:'stateToken'
                }
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
                        $('#salesRegion').html(html_text);
                        $('#selectsalesRegion').html(html_text)
                });
            });
            //Edit onchange state
            $('#selectsalesState').on('change',function(){
                let stateToken = $(this).find(':selected').val();
                let obj={
                    stateToken:stateToken,
                    type:'stateToken'
                }
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
                        $('#selectsalesRegion').html(html_text);
                });
            });


            //Regiononchange


            $("#salesRegion").on('change',function(){
                $("#areaRep").css("display", "block");
                let regionToken = $(this).find(':selected').val();
                let regobj={
                    regionToken:regionToken,
                    type:'regionToken'
                }
                var json_data = JSON.stringify(regobj);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    let data = datas.data;
                    let html_text = '<option value="">Select Area</option>';

                    data.forEach(function(item,index){
                                //console.log('hao',item.area_token);
                                html_text += `<option id='areas_name' value="${item.area_token}">${item.area_name}</option>`;
                    });
                    // for (let key in data) {
                    //     html_text += `<option id='areas_name' value="${data[key].area_token}">${data[key].area_name}</option>`;
                    //     console.log(data[key].area_token);
                    // }
                    $('#selectArea').html(html_text);
                    
                    $('#selectArea').select2({
                        closeOnSelect: false,
                        placeholder: "Please select Area"
                    });
                });
            });


            // area distributor
              $("#salesRegion").on('change',function(){
                $("#area_dis").css("display", "block");
                let regionToken = $(this).find(':selected').val();
                let areaobj={
                    regionToken:regionToken,
                    type:'areaToken'
                }
                var json_data = JSON.stringify(areaobj);
               console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    //console.log(datas);
                    let data = datas.data;
                    let html_text = '<option value="">Select Distributor</option>';

                    data.forEach(function(item,index){
                                html_text += `<option id='areas_dis' value="${item.token}">${item.name}</option>`;
                    });
                    $('#area_distributor').html(html_text);
                    
                    $('#area_distributor').select2({
                        closeOnSelect: false,
                        placeholder: "Please select Area distributor"
                    });
                });
            });
       
            // $(document).on('change','#selectArea',function(){
            //     // var datas = $(this).val()
            //     $(this).each(function(){
            //              datas = $(this).val();
            //              datas.forEach(function(item,index){
            //                 $('#hide_input').val(item);
            //             });

            //         }); 
            // });

            // $(document).on('change','#selectArea',function(){
            //     var areas_token = $('#hide_input').val();
            //             console.log('hauuuuuuuu',areas_token);
            //     $('#area_dis').css("display", "block");
                        
            //             var datas={areas_token : areas_token};
            //             var json_data = JSON.stringify(datas);
            //             console.log(json_data);
            //             $.ajax({
            //                 type : "POST",
            //                 dataType : "json",
            //                  url :api_path + "/admin/area_distributor.php",
            //                 data:json_data,
            //             }).done(function(res){
                            
            //                     var res_data =``;
                                
            //                     res.forEach(function(item,index){
            //                         console.log(item.name);
            //                         console.log(item.token);
            //                         res_data += `<option value='${item.token}'>${item.name}</option>`
            //                     });
            //                     $('#area_distributor').append(res_data);
            //                     $("#area_distributor option").each(function() {
            //                             $(this).siblings('[value="'+ this.value +'"]').remove();
                                        
            //                     });
                                
            //             });
            //  });
            


            //Edit Regiononchange
            $("#selectsalesRegion").on('change',function(){
                let regionToken = $(this).find(':selected').val();
                let regobj={
                    regionToken:regionToken,
                    type:'regionToken'
                }
                var json_data = JSON.stringify(regobj);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    let data = datas.data;
                    let html_text = '<option value="">Select Area</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].area_token}">${data[key].area_name}</option>`;
                    }
                    $('#scheduleArea').html(html_text);
                    $('#selecscheduleAreatArea').select2({
                        closeOnSelect: false,
                        placeholder: "Please select Area"
                    });
                });
            });
        

             //Edit areaonchange
             $("#scheduleArea").on('change',function(){
                  let regionToken = $(this).find(':selected').val();
                let areaobj={
                    regionToken:regionToken,
                    type:'areaToken'
                }
                var json_data = JSON.stringify(areaobj);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    console.log(data);
                    let data = datas.data;
                    let html_text = '<option value="">Select distributor</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].token}">${data[key].name}</option>`;
                    }
                    $('#scheduledistributor').html(html_text);
                    $('#scheduledistributor').select2({
                        closeOnSelect: false,
                        placeholder: "Please select distributor"
                    });
                });
            });
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
                datavalue1(admin_state_id);
        });
        function date_filter() {
                var from_date = $("#fromDate").val();
                var to_date = $("#toDate").val();
                if (from_date > to_date && to_date != "" && to_date != undefined) {
                    $("#toDate").val(from_date);
                }
                var to_date = $("#toDate").val();
                if (from_date != "" && to_date != "" && from_date != undefined && to_date != undefined) {
                    table.clear();
                    table.destroy();
                    datavalue1(admin_state_id,from_date,to_date);
                }
            }
        $("body").on("click",".statewise li" ,function(){
                    admin_state_id = $(this).data("id"); 
                    table1.clear();
                    table1.destroy();
                    datavalue(admin_state_id);
                });
                $("body").on("click",".statewise li" ,function(){
                    admin_state_id = $(this).data("id"); 
                    table.clear();
                    table.destroy();
                    datavalue1(admin_state_id,from_date,to_date);
                });
        function datavalue(admin_state_id){
            var datas = {
                state_id:admin_state_id,
                type: "AlltodayScheduledSalesRep"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data: json_data,
                success: success,
            });
        }
        function datavalue1(admin_state_id,from_date,to_date){
        var datas = {
                from_date:from_date,
                to_date:to_date,
                state_id:admin_state_id,
                type: "AllScheduledSalesRep"
            };
            var json_data = JSON.stringify(datas);
            console.log("json_data",json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/scheduleSalesRep.php",
                data: json_data,
                success: succes,
            });
        }

        //schedule_sales_rep
        function schedule_sales_rep(){
            let sales_rep_name = $("#sales_rep_names ").find(':selected').val();
            let date = $("#datePicker").val();
            let travelAllowance = $("#travel").find(":selected").val();
            let stateToken = $("#salesState").find(":selected").val();
            let regionToken = $("#salesRegion").find(":selected").val();
            let areaToken = [];
            $('#selectArea :selected').each(function() {
                areaToken.push($(this).val());
            });
            let areaDisToken = [];
            $('#area_distributor :selected').each(function() {
                areaDisToken.push($(this).val());
            });
            if(sales_rep_name !="" && date !="" && travelAllowance!="" && stateToken !="" && regionToken !="" && areaToken !="" && areaDisToken !=""){
                    let datas = {
                    sales_rep_name:sales_rep_name,
                    date:date,
                    travelAllowance:travelAllowance,
                    stateToken:stateToken,
                    regionToken:regionToken,
                    areaToken:areaToken,
                    areaDisToken:areaDisToken,
                    type:'scheduleSaleRep'
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(data){
                    //console.log(data);
                    if (data.status_code == 200) {
                        swal("Sales Rep was scheduled successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#add_sales_button').prop('disabled', false);
                        swal(data.message);
                    }
                })
            }else {
            swal("Please enter all details!");
             }
        }

        //table fatch
        var table_main_data;
        function success(data) {
            table_main_data = data.data;
            console.log(table_main_data);
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>' + slno + '</td>';
                html_text += '<td>' + table_main_data[key].salesRepName + '</td>';
                html_text += '<td>' + table_main_data[key].schedule_date + '</td>';
                html_text += '<td>' + table_main_data[key].state_name + '</td>';
                html_text += '<td>' + table_main_data[key].region_name + '</td>';
                html_text += '<td>' + table_main_data[key].travel + '</td>';
                html_text += `<td><a id="editSalesRep" data-toggle="modal" data-target="#edit_mod" data-date="${table_main_data[key].schedule_date}" data-token = "${table_main_data[key].saleRepToken}" data-token1 = "${table_main_data[key].region_token}"><img src="assets/edit.png" class="edit_input" alt=""></a></td>`;
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#table_body_Sales1").html(html_text);
            key++;
            $("#total_shopType_count").html(key);
            table1 = $("#table_data1").DataTable({
                dom: 'Bfrtip',
                buttons: [],
                order: [[0, 'desc']],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">',
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">',
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                    }
                }
            });
        }
        var table_main_data;
        function succes(data) {
            table_main_data = data.data;
            
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>' + slno + '</td>';
                html_text += '<td>' + table_main_data[key].salesRepName + '</td>';
                html_text += `<td><a href="javascript:void(0);" class="view_link view_location" data-toggle="modal" data-target="#exampleModalMap" data-token = "${table_main_data[key].saleRepToken}">View Location</a></td>`;
                html_text += `<td><a href="javascript:void(0);" class="view_link view_log" data-toggle="modal" data-token = "${table_main_data[key].saleRepToken}" data-target="#table_modal">View Log</a></td>`;
                html_text += '<td>' + table_main_data[key].schedule_date + '</td>';
                html_text += '<td>' + table_main_data[key].state_name + '</td>';
                html_text += '<td>' + table_main_data[key].region_name + '</td>';
                html_text += '<td>' + table_main_data[key].amount + '</td>';
                html_text += '<td>' + table_main_data[key].travel + '</td>';
                //var amt = table_main_data[key].order_total_amt == null ? '-' : parseInt(table_main_data[key].order_total_amt);

                
                //html_text += '<td>' + amt + '</td>';
                html_text += `<td><a id="editSales" data-toggle="modal" data-target="#editmod" data-date="${table_main_data[key].schedule_date}" data-token = "${table_main_data[key].saleRepToken}"><img src="assets/edit.png" class="edit_input" alt=""></a></td>`;
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#table_body_Sale").html(html_text);
            key++;
            $("#total_shopType_count").html(key);
            table = $("#table_data").DataTable({
                dom: 'Bfrtip',
                buttons: [],
                order: [[0, 'desc']],
                "columnDefs": [
                    {
                        "targets": [ 0 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">',
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">',
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                    }
                }
            });
        }
        //view view_log
        $(document).on('click','.view_log',function(){
                    var employeeToken = $(this).attr('data-token');
                var date = $(this).closest('tr').find('td:eq(3)').text();
                var datas = {
                    employee_token: employeeToken,
                    date : date,
                    type: 'VisitShopLog'
                };
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/rep_history_view_log.php",
                    data: json_data,
                }).done(function(data){
                    console.log(data);
                    $('#log_table').empty();
                    var dailyLog = data.data;;
                    var srno = 0;
                    var top_html = '';
                    if (data.status_code == 200) {
                        for (var key in dailyLog) {
                            srno++;
                            top_html += '<tr>';
                            top_html += '<td>' + srno + '</td>';
                            top_html += '<td>' + dailyLog[key].shop_name + '</td>';
                            top_html += '<td>' + dailyLog[key].position + '</td>';
                            top_html += '<td>' + dailyLog[key].date_time + '</td>';
                            top_html += '</tr>';
                        }
                    } else {
                        top_html += '<tr>';
                        top_html += '<td colspan="4" style="text-align: center;">No Records Found</td>';
                        top_html += '</tr>';
                    }
                    // $(".se-pre-con").fadeOut();
                    $("#log_table").html(top_html);
                });
            });
            //map
            
            // $(document).on('click','.view_location',function(){
            $(document).on('click','.view_location',function(){
                var employeeToken = $(this).attr('data-token');
                var date = $(this).closest('tr').find('td:eq(3)').text(); 
                function initMap() {
                var option = {
                    zoom: 8,
                    center : { lat: 11.8822394, lng: 79.7300253 }
                };
                var map = new google.maps.Map(document.getElementById("map-canvas"),option);
                // map.panTo(this.getPosition());
                  map.setZoom(16);
                var datas = {
                        type: "SalesRepLocation",
                        employee_token: employeeToken,
                        date : date
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/rep_history_view_log.php",
                        data: json_data,
                    }).done(function(res_data){
                            console.log(res_data);
                            var arr = [];
                            res_data.data.forEach(function(item,index){
                                
                                arr.push({coord : {'lat' : parseFloat(item.employee_lat),'lng' : parseFloat(item.employee_lon)}});
                            });
                            var polyarrays = [];
                            for (let index = 0; index < arr.length; index++) {
                                const element = arr[index];  
                             polyarrays.push(element.coord);
                                lats(element);
                            }
                            function lats(props){
                                    var image = {
                                    url: 'assets/ride-a-bike.png',
                                    scaledSize : new google.maps.Size(50, 50),
                                    
                                };   
                            var marker = new google.maps.Marker({
                                map :map,
                                position : props.coord,
                                icon : image,
                                animation: google.maps.Animation.DROP,
                            });
                            const flightPath = new google.maps.Polyline({
                                                path:polyarrays,
                                                geodesic: true,
                                                strokeColor: "#FF0000",
                                                strokeOpacity: 1.0,
                                                strokeWeight: 2,
                                            });

                                            flightPath.setMap(map);
                        }
                    });
                     
                }
            initMap();
            });   
            
        //edit salesrep
        $('body').on('click','#editSalesRep',function(){
            let salesReoToken = $(this).attr('data-token');
            // $("#rep_token").val(salesReoToken);
            let date = $(this).attr('data-date');
            $("#updateBtn").attr("data-token",salesReoToken);
            $("#updateBtn").attr("data-date",$(this).attr('data-date'));
            let datas = {
                salesReoToken:salesReoToken,
                date:date,
                type:'repAreas'
            }
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    let value = datas.data;
                    console.log(value);
                    $("#salesTravel").val(value.travel);
                    $("#selectsalesState").val(value.state_token);
                    $("#selectsalesRegion").val(value.region_token);
                    $("#rep_schedule_token").val(value.rep_schedule_token);
                    var module_name = [];
                    value.modules_data.forEach(function(item,index){
                        module_name.push(item.area_id);
                    })
                    $('#scheduleArea').val(module_name);
                    $('#scheduleArea').not('.manual').select2(); 
                    var modulename = [];
                    value.modules.forEach(function(item,index){
                        modulename.push(item.token);
                    })
                    $('#scheduledistributor').val(modulename);
                    $('#scheduledistributor').not('.manual').select2(); 
                })
        });
        //schedule history

        $('body').on('click','#editSales',function(){
            let salesReoToken = $(this).attr('data-token');
            let date = $(this).attr('data-date');
            let datas = {
                salesReoToken:salesReoToken,
                date:date,
                type:'repAreas'
            }
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data:json_data,
                }).done(function(datas){
                    let value = datas.data;
                    console.log(value);
                    $("#edit_travel").val(value.travel);
                    $("#edit_state_name").val(value.state_name);
                    $("#edit_region_name").val(value.region_name);
                    var module_name = [];
                    value.modules_data.forEach(function(item,index){
                        module_name.push(item.area_name);
                    })
                    $('#edit_rep_area').val(module_name);
                    var modulename = [];
                    value.modules.forEach(function(item,index){
                        modulename.push(item.name);
                    })
                    $('#edit_area_distributor').val(modulename);
                })
        });

        //update schedule
        function update_schedule_sales_rep(token){
            let date = $(token).attr("data-date");
            let salesRepToken = $(token).attr("data-token");
            let travelAllowance = $("#salesTravel").val();
            let stateToken = $("#selectsalesState").find(":selected").val();
            let regionToken = $("#selectsalesRegion").find(":selected").val();
            let rep_schedule_token = $("#rep_schedule_token").val();
            let areaToken = [];
            $('#scheduleArea :selected').each(function() {
                areaToken.push($(this).val());
            });
            let areaDisToken = [];
            $('#scheduledistributor :selected').each(function() {
                areaDisToken.push($(this).val());
            });
            if(salesRepToken !="" && travelAllowance!="" && stateToken !="" && regionToken !="" && areaToken !="" && areaDisToken !=""){
                let datas = {
                        salesRepToken:salesRepToken,
                        date:date,
                        travelAllowance:travelAllowance,
                        stateToken:stateToken,
                        regionToken:regionToken,
                        areaToken:areaToken,
                        areaDisToken:areaDisToken,
                        rep_schedule_token:rep_schedule_token,
                        type:'updateScheduleSaleRep'
                    }
                    var json_data = JSON.stringify(datas);
                    console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/scheduleSalesRep.php",
                        data:json_data,
                    }).done(function(data){
                        if (data.status_code == 200) {
                            swal("Update scheduled successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            $('#updateBtn').prop('disabled', false);
                            swal(data.message);
                        }
                    });
            }else {
                swal("Please enter all details!");
            }
        }

        function show_ProductCSV(){
            var csv_data = [];
        var rows = document.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var cols = rows[i].querySelectorAll('td,th');
            var csvrow = [];
            for (var j = 0; j < cols.length; j++) {
                csvrow.push(cols[j].innerText.replace("/<a.*>.*?<\/a>/ig,''"));
               
            }
            // csvrow.shift(cols[0].innerHTML);
            csvrow.pop(cols[3].innerHTML); 
            // csvrow.pop(cols[7].innerHTML);  
            csv_data.push(csvrow.join(","));
        }
        csv_data = csv_data.join('\n');
        downloadCSVFile(csv_data);

        }

        function downloadCSVFile(csv_data) {
        CSVFile = new Blob([csv_data], {
            type: "text/csv"
        });
        var temp_link = document.createElement('a');

        temp_link.download = "ScheduleList.csv";
        var url = window.URL.createObjectURL(CSVFile);
        temp_link.href = url;
        temp_link.style.display = "none";
        document.body.appendChild(temp_link);
        temp_link.click();
        document.body.removeChild(temp_link);
}
function show_ProductPDF(){
var data={
                    'invoice_name': "",
                }
                $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : "../TCPDF-main/examples/ScheduleListPdf.php?state_id="+admin_state_id,
                            data: data,
                            }).done(function(data) {
                                if(data.status_code==200){
                                $(".se-pre-con").hide();
                                window.open('../invoice_pdf/'+data.data, '_blank');
                                }else{
                                    swal("Something Happened!", {icon: "failed"});
                                }
                            });
            }
function show_ScheduleListPDF(){
        var from_date=$("#fromDate").val();
        var to_date=$("#toDate").val();
    var data={
        'invoice_name': "",
    }
    $.ajax({
                type: "POST",
                dataType: "json",
                url : "../TCPDF-main/examples/ScheduleHistoryPdf.php?from_date="+from_date+"&&to_date="+to_date+"&&state_id="+admin_state_id,
                data: data,
                }).done(function(data) {
                    if(data.status_code==200){
                    $(".se-pre-con").hide();
                    window.open('../invoice_pdf/'+data.data, '_blank');
                    }else{
                        swal("Something Happened!", {icon: "failed"});
                    }
                });
}
    </script>
    <script>
         const statusSelectBtn = document.querySelectorAll('.select__status');

                document.body.addEventListener('change', function(e) {
                console.log(e);
                const clickedSelectBtn = e.target.classList.contains('select__status');
                const statusSelectBtn = e.srcElement;
                const statusSelectBtnValue = statusSelectBtn.value;
                
                if(clickedSelectBtn) {
                    let bgColor;
                    let color;
                    
                    switch (statusSelectBtnValue) {
                    case 'success':
                        bgColor = '#11a14a';
                        color = '#fff';
                        break;
                        
                    case 'pending':
                        bgColor = '#d0893a';
                        color = '#fff';
                        break;
                    case 'reject':
                        bgColor = '#ba212e';
                        color = '#fff';
                        break;
                        
                    }
                    console.log(bgColor, color);
                    statusSelectBtn.style.backgroundColor = bgColor;
                    statusSelectBtn.style.color = color;
                    statusSelectBtn.style.border = bgColor;
                }
                })
    </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>
