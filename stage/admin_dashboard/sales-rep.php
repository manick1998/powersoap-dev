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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.30.2/minified.js"></script>
        <script>
            const process = { env: {} };
            process.env.GOOGLE_MAPS_API_KEY =
            "AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00";
        </script>
        <style>
            .form-control {
                margin: 20px 0;
            }

            .form-control p {
                margin: 0;
                color: #798893;
                font-size: 14px;
                font-weight: 600;
                line-height: 20px;
                text-align: left;
            }

            .input-field {
                border: none;
                color: #333;
                width: 100%;
                font-size: 16px;
                line-height: 20px;
                outline: none;
            }
            h1.header_main img {
              width: 40px;
             margin-right: 1rem;
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

            /* .custom-nav{
                border-bottom: 1px solid #D9D9D9;
                display:flex;
                align-items: center;
            } */
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
        /* .custom-nav.statewise::-webkit-scrollbar {
            display: block;
            background-color: #000;
            height: 4px;
            border-radius: 16px;
        }
        .custom-nav.statewise::-webkit-scrollbar-thumb {
            background-color: #232a77;
        }
        .custom-nav.statewise::-webkit-scrollbar-track {
            background-color: #cacaca;
        } */

        .custom-file {
            display: block;
            width: 180px;
            height: 40px;
            border: #00b9f5 1px solid;
            color: #00b9f5;
            border-radius: 4px;
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

            @media only screen and (max-width:1100px){
                #table_data1{
                    display: block;
                    overflow: hidden;
                    overflow-x: scroll;
                }
            }

            /* --- INACTIVE SALES REP ROW COLOR STYLE --- */
            table.dataTable tbody tr.inactive-row,
            table.dataTable tbody tr.inactive-row td,
            table.custom-table tbody tr.inactive-row td {
                background-color: #ffe2e2 !important;
                color: #c62828 !important;
                font-weight: 600;
            }
            table.dataTable tbody tr.inactive-row:hover td,
            table.custom-table tbody tr.inactive-row:hover td {
                background-color: #ffcaca !important;
            }

        </style>
    </head>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar16"></div>
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
                    <h1 class="header_main">Sales Rep List</h1>
<div class="cred-btn-box">
                            <button class="primary-btn" data-toggle="modal" data-target="#exampleModal">Add Sales Rep</button>
                        </div>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data1">
                        <thead>
                            <tr>
                                <th>slno</th>
                                <th>Sales Rep Name</th>
                                <th>State</th>
                                <th>Region</th>
                                <th>Email Id</th>
                                <th>Phone Number</th>
                                <th>Created Date</th>
                                <th>Action</th>
                                </tr>
                        </thead>
                        <tbody id="table_body_Sales">
                        </tbody>
                    </table>
                </div>
            </section>
            
        </main>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Add Sales Rep</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                    <div class="form-control sales_rep_name_box">
                                        <p for="offer_name" class="input-field sales_rep_name">Sales Rep Name</p>
                                        <input type="text" class="input-field" id="sales_rep_name" required placeholder="Please Enter Name">
                                    </div>
                                    <div class="form-control sales_rep_mailid_box">
                                        <p for="offer_percentage" class="input-field sales_rep_mailid">Email Address</p>
                                        <input type="text" id="sales_rep_mailid" class="input-field " placeholder="Please Enter Email Id" >
                                    </div>
                                    <div class="form-control sales_rep_mobilenumber_box">
                                        <p for="purchase_amount" class="input-field sales_rep_mobilenumber">Phone Number</p>
                                        <input type="text" id="sales_rep_mobilenumber" class="input-field floatonly" placeholder="Please Enter Phone Number" maxlength="10">
                                    </div>
                                    
                                    <div class="form-control state_name_box">
                                        <p class="state_name">State</p>
                                    </div>
                                    <div class="form-control region_token_box">
                                        <p for="offer_division" class="input-field region_token">Region</p>
                                        <select class="input-field" id="region_token">
                                        </select>
                                    </div>
                                    <div class="form-control rolls_token_box">
                                        <p for="offer_rolls" class="input-field rolls_token">Designation</p>
                                        <select class="input-field" id="rolls_token">
                                        </select>
                                    </div>
                                     <div class="form-control img---uplod" style="border: none;">
                                        <h6 style='    text-align: start;'>Attach</h6>
                                        <label for="salesrep_image_upload" style='text-align: start;'>
                                            <div class="custom-file">
                                                <input id="salesrep_image_valid" type="hidden">    
                                                <input id="salesrep_image_upload" onchange="file_upload_sales('salesrep_image','salesrep_view_image_url','assets/upload.png')"  type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                                <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                            </div>
                                            <img class="show_upload_image" style="max-height: 200px;max-width: 400px;padding-top: 10px;" id="salesrep_view_image_url"/>
                                            <span>Image format should be in jpg/png/</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="add_sales_button" onclick="add_sales_rep()">Create</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="apply_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Apply Leave</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                    
                                    <div class="form-control edit_sales_rep_mailid_box datepicker">
                                        <p class="input-field ">Date</p>
                                        <input type="date" id="datepicker" class="input-field " placeholder="DD-MM-YYYY" min="2022-11-17">
                                    </div>
                                    <div class="form-control edit_sales_rep_mailid_box">
                                        <p class="input-field ">Reason</p>
                                        <input type="text" id="reason" class="input-field " placeholder="Enter Your Reason" >
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="apply_sales_button" >Apply</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Edit Sales Rep</h2>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <div class="banner-option-box">
                                <div class="popup-image-box">
                                    <div class="form-control edit_sales_rep_name_box">
                                        <p for="offer_name" class="input-field edit_sales_rep_name">Sales Rep Name</p>
                                        <input id="update_sales_rep_token" type="hidden">
                                        <input type="text" class="input-field" id="edit_sales_rep_name" required placeholder="Please Enter Name">
                                    </div>
                                    <div class="form-control edit_sales_rep_mailid_box">
                                        <p for="offer_percentage" class="input-field edit_sales_rep_mailid">Email Address</p>
                                        <input type="text" id="edit_sales_rep_mailid" class="input-field " placeholder="Please Enter Email Id" >
                                    </div>
                                    <div class="form-control edit_sales_rep_mobilenumber_box">
                                        <p for="purchase_amount" class="input-field edit_sales_rep_mobilenumber">Phone Number</p>
                                        <input type="text" id="edit_sales_rep_mobilenumber" class="input-field floatonly" placeholder="Please Enter Phone Number" maxlength="10">
                                    </div>
                                    
                                    <div class="form-control edit_state_name_box">
                                        <p class="edit_state_name">State</p>
                                    </div>
                                    <div class="form-control edit_region_token_box">
                                        <p for="offer_division" class="input-field edit_region_token">Region</p>
                                        <select class="input-field" id="edit_region_token">
                                        </select>
                                    </div>
                                    <div class="form-control edit_rolls_token_box">
                                        <p for="offer_rolls" class="input-field edit_rolls_token">Designation</p>
                                        <select class="input-field" id="edit_rolls_token">
                                        </select>
                                    </div>

                                    <div class="form-control img---uplod" style="border: none;">
                                        <h6 style='    text-align: start;'>Attach</h6>
                                        <label for="edit_salesrep_image_upload" style='    text-align: start;'>
                                            <div class="custom-file">
                                                <input id="edit_salesrep_image_valid" type="hidden">    
                                                <input id="edit_salesrep_image_upload"  type="file" onchange="file_upload_sales('edit_salesrep_image','edit_salesrep_view_image_url','assets/upload.png')" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                                <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                            </div>
                                            <img class="show_upload_image" style="max-height: 200px;max-width: 400px;padding-top: 10px;" id="edit_salesrep_view_image_url"/>
                                            <span>Image format should be in jpg/png/</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                        <button class="create-btn" id="update_sales_button" onclick="update_sales_rep()">Update</button>
                    </div>
                </div>
            </div>
        </div>
         <div class="modal fade" id="exampleModalMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>View on Map</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="map"></div>
                    </div>
                    <div class="modal-footer">
</div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="table_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="employee_name_data"></h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <table class="custom-table" id="shop_logList_table">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Shop Name</th>
                                    <th>Lat and Log</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody id="log_table">
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
    </div>
                </div>
          </div>
    </div>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var gl_admin_token = "<?php echo $token; ?>";
        </script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>

        
        
        
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>  
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script src="js/polyfill.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00"></script>
        <script src="https://unpkg.com/@googlemaps/js-api-loader@1.0.0/dist/index.min.js"></script>
<script>
             function back_view_order(){
                location.reload();
            }
            var admin_state_id="<?php echo $cookie_admin_state;?>";
            $(document).ready(function(){
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
                $("#datepicker").on("click",function(){
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();

                today = yyyy + '-' + mm + '-' + dd;
                $('#datepicker').attr('min',today);

                });
            });
            $("body").on("click",".statewise li" ,function(){
                    admin_state_id = $(this).data("id"); 
                    table.clear();
                    table.destroy();
                    datavalue(admin_state_id);
                });
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var table;

            $(document).ready(function() {


            //   console.log('state_token',state_token);
                var datas = {
                    dashboard_code: verfication_code,
                    state_id: admin_state_id,
                    type: "All"
                };

                var json_data = JSON.stringify(datas);
                console.log('json_data',json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/addRegion.php",
                    data: json_data,
                }).done(function(datas) {
                        var data = datas.data;
                        var html_text = '<option value="">Select Region</option>';
                        for (var key in data) {
                            html_text += '<option value="' + data[key].region_token + '" >' + data[key].region_name + '</option>';
                        }
                        //$("#region_token").html(html_text);
                        $("#edit_region_token").html(html_text);

                        var stateList = datas.data_state;
                        var state_html = '';
                            if(stateList.length == 1){
                                state_html += '<input class="input-field" id="state" value="'+stateList[0].state_name+'" readonly>';
                                state_html += '<input type="hidden" class="input-field" id="state_name" value="'+stateList[0].state_token+'">';
                            }else{
                                state_html += '<select class="input-field" id="state_name">';
                                      state_html += '<option value="">Select state</option>';
                                      for(var key in stateList){
                                        state_html += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                                      }
                                state_html += '</select>'; 
                            }
                       $(".state_name_box").append(state_html);

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
                       $(".edit_state_name_box").append(edit_state_html);
                    
                });

                datavalue(admin_state_id);

                //======================= Rolls

                var data1 = {
                    dashboard_code: verfication_code,
                    type: "designation"
                };
                var json_data1 = JSON.stringify(data1);
                console.log('json_data',json_data1);
                $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : api_path + "/admin/salesRep.php",
                    data: json_data1,
                }).done(function(result){
                    console.log('result',result);
                     var htmt_data = '<option value="">Select Role</option>';
                    result.rollsdata.forEach(function(item,index){
                        htmt_data += `<option value='${item.rolls_token}'>${item.rolls_name}</option>`;
                    });
                    $('#rolls_token').append(htmt_data);
                });

            
            });
            function datavalue(admin_state_id){
                var datas = {
                    dashboard_code: verfication_code,
                    state_id: admin_state_id,
                    type: "AllSalesRep"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesRep.php",
                    data: json_data,
                    success: success,
                });
            }
            var table_main_data;
            function success(data) {
                console.log("data",data);
                
                var sortedData = Object.values(data.data);
                sortedData.sort(function(a, b) {
                    function getStatePriority(stateName) {
                        var normalizedState = String(stateName || "")
                            .toLowerCase()
                            .replace(/\s+/g, "");

                        if (normalizedState === "tamilnadu" || normalizedState === "tamilnad") {
                            return 1;
                        }
                        if (normalizedState === "karaikal") {
                            return 2;
                        }
                        if (normalizedState === "puducherry" || normalizedState === "pondicherry") {
                            return 3;
                        }
                        return 4;
                    }

                    var statePriorityCompare = getStatePriority(a.state_name) - getStatePriority(b.state_name);
                    if (statePriorityCompare !== 0) {
                        return statePriorityCompare;
                    }

                    var stateCompare = String(a.state_name || "").localeCompare(
                        String(b.state_name || ""),
                        undefined,
                        { sensitivity: "base" }
                    );
                    if (stateCompare !== 0) {
                        return stateCompare;
                    }

                    var regionCompare = String(a.region_name || "").localeCompare(
                        String(b.region_name || ""),
                        undefined,
                        { sensitivity: "base" }
                    );
                    if (regionCompare !== 0) {
                        return regionCompare;
                    }

                    var statusA = (a.block_status == '1' || a.block_status == 1 || a.block_status == 'Active') ? 1 : 0;
                    var statusB = (b.block_status == '1' || b.block_status == 1 || b.block_status == 'Active') ? 1 : 0;
                    if (statusA !== statusB) {
                        return statusB - statusA;
                    }

                    return String(a.employee_name || "").localeCompare(
                        String(b.employee_name || ""),
                        undefined,
                        { sensitivity: "base" }
                    );
                });

                table_main_data = sortedData;
                var html_text = "";
                var slno = 0;
                
                for (var key in table_main_data) {
                    slno++;
                    
                    var statusField = String(table_main_data[key].block_status).trim().toLowerCase();
                    var rowClass = (statusField === "0" || statusField === "inactive" || statusField === "deactivated")
                        ? "inactive-row"
                        : "";

                    html_text += '<tr class="' + rowClass + '">';
                    html_text += '<td>' + slno + '</td>';
                    html_text += '<td>' + table_main_data[key].employee_name + '</td>';
                    html_text += '<td>' + (table_main_data[key].state_name || '') + '</td>';
                    html_text += '<td>' + table_main_data[key].region_name + '</td>';
                    html_text += '<td>' + table_main_data[key].email_id + '</td>';
                    html_text += '<td>' + table_main_data[key].mobile_number + '</td>';
                    html_text += '<td>' + table_main_data[key].date_time + '</td>';
                    html_text += '<td><a><img src="assets/edit.png" id="editbtn" data-state_id="'+table_main_data[key].state_token+'" data-deparment_token="'+table_main_data[key].deparment_token+'" class="edit_input" data-emp_token = "'+table_main_data[key].employee_token+'"" alt=""></a></td>';
                    html_text += '</tr>';
                }
                
                $(".se-pre-con").hide();
                $("#table_body_Sales").html(html_text);
                
                $("#total_shopType_count").html(slno);
                
                // DATATABLE INIT
                table = $("#table_data1").DataTable({
                    dom: 'Bfrtip',
                    buttons: [],
                    scrollX: true,
                    order: [[0, 'asc']], 
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

                //state drop down 
               if(admin_state_id==0){
                $(document).on("change","#state_name",function(){
                var state_token = $(this).val();
                var data = {
                "state_token" : state_token 
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/state_and_region.php",
                data: json_data,
                }).done(function(res_data){
                console.log(res_data);
                var html_text = '<option value="">Select Region</option>';
                res_data.area_data.forEach(function(item,index){
                    html_text += '<option value="' + item.region_token + '">' + item.region_name + '</option>';
                });
                $("#region_token").html(html_text);
            });
        });
            }else{
                var data = {
                "state_token" : admin_state_id 
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/state_and_region.php",
                data: json_data,
                }).done(function(res_data){
                console.log(res_data);
                var html_text = '<option value="">Select Region</option>';
                res_data.area_data.forEach(function(item,index){
                    html_text += '<option value="' + item.region_token + '">' + item.region_name + '</option>';
                });
                $("#region_token").html(html_text);
                });
          }
                //edit state name 
                $(document).on("change","#edit_state_name",function(){
                var state_token = $(this).val();
                var data = {
                "state_token" : state_token 
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/state_and_region.php",
                data: json_data,
                }).done(function(res_data){
                console.log(res_data);
                var html_text = '<option value="">Select Region</option>';
                res_data.area_data.forEach(function(item,index){
                    html_text += '<option value="' + item.region_token + '">' + item.region_name + '</option>';
                });
                $("#edit_region_token").html(html_text);

                });
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/state_and_region.php",
                data: json_data,
                }).done(function(res_data){
                console.log(res_data);
                var html_text = '<option value="">Select Region</option>';
                for (var key in res_data) {
                   // "'+res_data[key].region_token === res_data[key].region_token ? "No Region":res_data[key].region_token+'"
                    html_text += '<option value="' + res_data[key].region_token + '">' + res_data[key].region_name + '</option>';
                }
                    $("#region_token").html(html_text);
                    // $("#edit_region_token").html(html_text);
                    });
                });

                function add_sales_rep(){
                $(".se-pre-con").show();
                var sales_rep_name = $("#sales_rep_name").val();
                var val1 = value_check('sales_rep_name', sales_rep_name, 'text_box');
                var sales_rep_mailid = $("#sales_rep_mailid").val();
                var val2 = value_check('sales_rep_mailid', sales_rep_mailid, 'text_box_email', 'Email Address');
                var sales_rep_mobilenumber = $("#sales_rep_mobilenumber").val();
                var val3 = value_check('sales_rep_mobilenumber', sales_rep_mobilenumber, 'mobile');
                var region_token = $("#region_token").val();
                var val4 = value_check('region_token', region_token, 'text_box');
                var state_token = $("#state_name").val();
                var val5 = value_check('state_name', state_token, 'text_box');
                console.log('val5',val5);
                var rolls_token = $('#rolls_token').val();
                var val6 = value_check('rolls_token', rolls_token, 'text_box');
                console.log('val6',val6);
               // var salesrep_image= $("#salesrep_image_valid").val();
                // var val6 = value_check('',salesrep_image,'image');
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val6 == true) {
                    $('#add_sales_button').prop('disabled', true);
                    image_upload_loop(0);
                }else{
           if(val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val6 == true){
               var all_check = true;
           }else{
               var all_check = false;
           }
           if(all_check==false){
               swal("Please enter all details!");
               $(".se-pre-con").hide();
           }else{
               swal("Please Upload profile image");
               $(".se-pre-con").hide();
           }  
       }
            }


var image_id = ['salesrep_image'];
    function image_upload_loop(key){
       var valid   = $("#"+image_id[key]+"_valid").val();
       var checkkey = key+1;
       if(valid=="true"){
           if(checkkey>image_id.length){
            add_sales_rep_finish();
           }else{
               var fileUpload = document.getElementById(image_id[key]+"_upload");
               var file = fileUpload.files[0];
               s3_file_upload(file, key);
           }
       }else{
           if(valid!=undefined){
               $("#"+image_id[key]+"_valid").val(valid);
               key++;
               image_upload_loop(key);
           }else{
            add_sales_rep_finish();
           }
       }
    }

            function add_sales_rep_finish(){
                $(".se-pre-con").show();
                var sales_rep_name = $("#sales_rep_name").val();
                //var val1 = value_check('sales_rep_name', sales_rep_name, 'text_box');
                var sales_rep_mailid = $("#sales_rep_mailid").val();
                //var val2 = value_check('sales_rep_mailid', sales_rep_mailid, 'text_box_email', 'Email Address');
                var sales_rep_mobilenumber = $("#sales_rep_mobilenumber").val();
                //ar val3 = value_check('sales_rep_mobilenumber', sales_rep_mobilenumber, 'mobile');
                var region_token = $("#region_token").val();
                //var val4 = value_check('region_token', region_token, 'text_box');
                var state_token = $("#state_name").val();
                //var val5 = value_check('state_name', state_token, 'text_box');
                var salesrep_image= $("#salesrep_image_valid").val();
                 //var val6 = value_check('',salesrep_image,'image');
                 var rolls_token = $('#rolls_token').val();
                    var datas = {
                        'sales_rep_name': sales_rep_name,
                        'sales_rep_mailid': sales_rep_mailid,
                        'sales_rep_mobilenumber': sales_rep_mobilenumber,
                        'region_token': region_token,
                        'state_token': state_token,
                        'dashboard_code': verfication_code,
                        'salesrep_image':salesrep_image,
                        'rolls_token':rolls_token,
                        'admin_token':gl_admin_token,
                        'type':'AddNewSalesRep'
                    }
                    var json_data = JSON.stringify(datas);
                    console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/salesRep.php",
                        data: json_data,
                    }).done(function(data) {
                        console.log(data);
                        $(".se-pre-con").hide();
                        if (data.status_code == 200) {
                            swal("Sales Rep added successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            $('#add_sales_button').prop('disabled', false);
                            swal(data.message);
                            $(".se-pre-con").hide();
                        }
                    });
            }
 
           // function editSalesRep(employee_token) {
            $(document).on('click',"#editbtn",function(){
                var employee_token = $(this).attr('data-emp_token');

               var state_token =  $(this).attr('data-state_id');
               var deparment_token = $(this).attr('data-deparment_token');
               console.log('deparment_token',deparment_token);
               var data = {
                "state_token" : state_token 
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/state_and_region.php",
                data: json_data,
                }).done(function(res_data){
                console.log(res_data);
                var html_text = '<option value="">Select Region</option>';
                res_data.area_data.forEach(function(item,index){
                    html_text += '<option value="' + item.region_token + '">' + item.region_name + '</option>';
                });
                $("#edit_region_token").html(html_text);
                });
                //==========edit show department rolls
                var data1 = {
                    dashboard_code: verfication_code,
                    type: "designation"
                };
                var json_data1 = JSON.stringify(data1);
                console.log('json_data',json_data1);
                $.ajax({
                    type : 'POST',
                    dataType : 'json',
                    url : api_path + "/admin/salesRep.php",
                    data: json_data1,
                }).done(function(result){
                    console.log('result',result);
                    var htmt_data = '<option value="">Select Role</option>';
                    result.rollsdata.forEach(function(item,index){
                        htmt_data += `<option value='${item.rolls_token}'${item.rolls_token === deparment_token ? 'selected' : ''}>${item.rolls_name}</option>`;
                    });
                    $('#edit_rolls_token').html(htmt_data);
                });
               // edit show all data =========
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    type: "SelectSingleSalesRep",
                    employee_token: employee_token
                };
                var json_data = JSON.stringify(datas);
                console.log('json_data',json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/salesRep.php",
                    data: json_data,
                }).done(function(data) {
                    var emp_data = data.data;
                    console.log(emp_data);
                    $("#update_sales_rep_token").val(emp_data[0].employee_token);
                    $("#edit_sales_rep_name").val(emp_data[0].employee_name);
                    $("#edit_region_token").val(emp_data[0].region_token);
                    $("#edit_sales_rep_mailid").val(emp_data[0].email_id);
                    $("#edit_sales_rep_mobilenumber").val(emp_data[0].mobile_number);
                    $("#edit_state_name").val(emp_data[0].state_token);
                    if (emp_data[0].employee_image == "") {
                        $("#edit_salesrep_view_image_url").attr("src","");
                    } else {
                        $("#edit_salesrep_view_image_url").attr("src", emp_data[0].employee_image);
                    }
                    $("#edit_salesrep_image_valid").val(emp_data[0].employee_image);
                    $('#exampleModal1').modal('show');
                    $(".se-pre-con").hide();
                });
            }); 
           // }
            function update_sales_rep() {
                var sales_rep_token = $("#update_sales_rep_token").val();
                var sales_rep_name = $("#edit_sales_rep_name").val();
                var val1 = value_check('edit_sales_rep_name', sales_rep_name, 'text_box');
                var region_token = $("#edit_region_token").val();
                var val2 = value_check('edit_region_token', region_token, 'text_box');
                var sales_rep_mailid = $("#edit_sales_rep_mailid").val();
                var val3 = value_check('edit_sales_rep_mailid', sales_rep_mailid, 'text_box_email', 'Email Address');
                var sales_rep_mobilenumber = $("#edit_sales_rep_mobilenumber").val();
                var val4 = value_check('edit_sales_rep_mobilenumber', sales_rep_mobilenumber, 'mobile');
                var state_token = $("#edit_state_name").val();
                var val5 = value_check('edit_state_name', state_token, 'text_box');

                var rolls_token = $("#edit_rolls_token").val();
                var val6 = value_check('edit_rolls_token', rolls_token, 'text_box');

                var employee_image = $("#edit_salesrep_image_valid").val();
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val6 == true) {
                    $('#update_sales_button').prop('disabled', true);
                    $(".se-pre-con").show();
                    edit_image_upload_loop(0);
                } else {
                    swal("Please enter mandatory details!");
                }
            }

            var edit_image_id = ['edit_salesrep_image'];
            function edit_image_upload_loop(key) {
                var valid = $("#" + edit_image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > edit_image_id.length) {
                        update_sales_rep_finish();
                    } else {
                        var fileUpload = document.getElementById(edit_image_id[key] + "_upload");
                        var file = fileUpload.files[0];
                        s3_file_update(file, key);
                    }
                } else {
                    if (valid != undefined) {
                        $("#" + edit_image_id[key] + "_valid").val(valid);
                        key++;
                        edit_image_upload_loop(key);
                    } else {
                        update_sales_rep_finish();
                    }
                }
            }


            function update_sales_rep_finish() {
                var sales_rep_token = $("#update_sales_rep_token").val();
                var sales_rep_name = $("#edit_sales_rep_name").val();
                //var val1 = value_check('edit_sales_rep_name', sales_rep_name, 'text_box');
                var region_token = $("#edit_region_token").val();
                //var val2 = value_check('edit_region_token', region_token, 'text_box');
                var sales_rep_mailid = $("#edit_sales_rep_mailid").val();
                //var val3 = value_check('edit_sales_rep_mailid', sales_rep_mailid, 'text_box_email', 'Email Address');
                var sales_rep_mobilenumber = $("#edit_sales_rep_mobilenumber").val();
                //var val4 = value_check('edit_sales_rep_mobilenumber', sales_rep_mobilenumber, 'mobile');
                var state_token = $("#edit_state_name").val();
                //var val5 = value_check('edit_state_name', state_token, 'text_box');
                var employee_image = $("#edit_salesrep_image_valid").val();
                var rolls_token = $("#edit_rolls_token").val();
                    var datas = {
                        dashboard_code: verfication_code,
                        type: "UpdateSalesRep",
                        sales_rep_token: sales_rep_token,
                        sales_rep_name: sales_rep_name,
                        region_token: region_token,
                        sales_rep_mailid: sales_rep_mailid,
                        sales_rep_mobilenumber: sales_rep_mobilenumber,
                        state_token: state_token,
                        employee_image:employee_image,
                        rolls_token : rolls_token,
                        admin_token:gl_admin_token
                    };
                    var json_data = JSON.stringify(datas);
                    console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/salesRep.php",
                        data: json_data,
                    }).done(function(data) {
                        console.log(data);
                        if(data.status_code == 200){
                            $(".se-pre-con").hide();
                            swal("Updated Sales Rep successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        }else{
                            $(".se-pre-con").hide();
                            $('#update_sales_button').prop('disabled', false);
                            swal(data.message);
                        } 
                    });
            }


            //apply leave
            $('body').on('click','#apply_leave',function(){
                let sales_rep_token = $(this).attr('data-token');
                
                $('#apply_sales_button').click(function(){
                    let date = $('#datepicker').val();
                    let reason = $('#reason').val();
                    if(date !="" && reason !=""){

                    
                    let datas = {
                        gl_admin_token:gl_admin_token,
                        sales_rep_token:sales_rep_token,
                        date:date,
                        reason:reason
                    }
                    let data = JSON.stringify(datas);
                    $.ajax({
                        type:'POST',
                        dataType: "json",
                        url: api_path + "/admin/addLeave.php",
                        data: data,
                        success:function(response){
                            if(response.code ==201){
                            swal("Leave Submited!", {
                            icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                            }else{
                                $('#apply_sales_button').prop('disabled', false);
                                swal(response.message);
                            }
                        }
                    });
                    }else{
                        swal("Please enter mandatory details!");
                    }
                });
                
            })
            //Map
            function view_Location(employeeToken){
                var datas = {
                        dashboard_code: verfication_code,
                        type: "SalesRepLocation",
                        employee_token: employeeToken
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/salesRep.php",
                        data: json_data,
                        success: function(result){
           
                            var new_data = result.data;
                            var map = new google.maps.Map(document.getElementById('map'), {
                                zoom: 10,
                                center: new google.maps.LatLng(12.963701130874837, 80.21385233256576),
                                mapTypeId: "terrain",
                            });
                            var infowindow = new google.maps.InfoWindow();
                            var marker, i;
                            for(var key in new_data){
                                if(new_data[key].employee_lat != "" && new_data[key].employee_lat != "0"){ 
                                    marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(new_data[key].employee_lat, new_data[key].employee_lon),
                                    map: map
                                    });
                                    google.maps.event.addListener(marker, 'click', (function(marker, key) {
                                    return function() {
                                        infowindow.setContent(new_data[key].shop_name+"</br>Time : "+new_data[key].employee_date_time);
                                        infowindow.open(map, marker);
                                    }
                                    })(marker, key));
                                }
                            }
                        },
                        error: function (request, error) {
                            alert(" Can't do because:1 " + error);
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
