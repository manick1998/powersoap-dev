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
        <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <style>
            @media screen and (max-width:1200px) {
                /* .main-contents{
                    margin-left: 0px !important;
                } */
            }

            .twoback {

                margin-left: 0px;
            }

            .old_desing {
                display: none;
            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar4"></div>
        <div class="se-pre-con"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="retailer_table" style="display: none;">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main" data-i18n="retailer_list">Retailer List</h1>
                        </div>
                        <p class="table_count"><span data-i18n="total_retailer">Total Retailer</span> - <span id="total_retailer_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="btn-set">
                            <button class="btn_employee btn" data-toggle="modal" data-target="#form" type="button" data-i18n="add_retail">Add Retail</button>
                        </div>
                        <div class="btn-set remove_upload_mobile">
                            <button class="btn_employees active" type="button" data-toggle="modal" data-target="#myModal" data-i18n="upload_csv">Upload CSV</button>
                        </div>
                        <div class="btn-set remove_upload_mobile">
                            <button class="btn_employees active" type="button"><a class="a_button" href="assets/csv/Sample_Retailer_CSV.csv" download data-i18n="sample_csv_file">Sample CSV File</a></button>
                        </div>
                        <div class="btn-set">
                            <select id="unitSelectedName" class="form-control sel_drop">
                            </select>
                        </div>
                        <div class="btn-set">
                            <button class="btn_employee" onclick="unitFilterBtn()" type="button" data-i18n="go">Go</button>
                        </div>
                        <div class="btn-set">
                            <button class="btn_employee" id="download_pdf_btn" onclick="unitWiseShopList()" type="button" data-i18n="download_as_pdf">Download As PDF</button>
                        </div>
                        <div class="btn-set">
                            <button class="btn_employee" id="download_excel_btn" onclick="unitWiseShopExcelList()" type="button">Download As Excel</button>
                        </div>
                    </form>
                </div>
                <!-- <div class="dataTables_filter">
                    <form class="formdield">
                        
                    </form>
                </div> -->
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th data-i18n="token">Token</th>
                                <th data-i18n="retailer_code">Retailer Code</th>
                                <th data-i18n="retailer_name">Retailer Name</th>
                                <th data-i18n="type">Type</th>
                                <th data-i18n="unit_name">Unit Name</th>
                                <th data-i18n="mobile_number">Mobile Number</th>
                                <th data-i18n="contact_person">Contact Person</th>
                                <th data-i18n="joining_date">Joining Date</th>
                                <th data-i18n="gst_number">GST Number</th>
                                <th data-i18n="paid_amount">Paid Amount</th>
                                <th data-i18n="outstanding_amount">Outstanding Amount</th>
                                <th data-i18n="action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id">
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="bg-white brad-4 full-height twoback" id="retailer_view" style="display: none;">
                <div class="header_container mrgzro">
                    <div class="header-section sep_word">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_retailer()" alt=""></span></h1>
                        <input id="update_status_token" type="hidden">
                        <div class="de_activate">
                        </div>
                    </div>
                    <div class="add_new_top bot_line">
                        <div class="col-md-12">
                            <h2 class="name_box" id="single_shop_name"></h2>
                            <div class="part-card details-part-card-set">
                                <div class="part">
                                    <div class="codelevel">
                                        <p><span data-i18n="shop_name">Shop Name</span> : <span id="single_shop_name1"></span></p>
                                        <p><span data-i18n="shop_type">Shop Type</span> : <span id="single_shop_type"></span></p>
                                    </div>
                                </div>
                                <div class="part">
                                    <div class="codelevel">
                                        <p><span data-i18n="contact_person">Contact Person</span> : <span id="single_shop_person"></span></p>
                                        <!--                                        <p>Slot : <span id="single_shop_slot"></span></p>-->
                                    </div>
                                </div>
                                <div class="part">
                                    <div class="codelevel">
                                        <p><span data-i18n="contact_number">Contact Number</span> : <span id="single_shop_contact"></span></p>
                                        <p><span data-i18n="gst_number">GST Number</span> : <span id="single_shop_license"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="address_field">
                        <div class="address_field_inner_set">
                            <div class="address_note">
                                <h2 data-i18n="address">Address :</h2>
                                <p id="single_shop_address"></p>
                            </div>
                            <div class="address_note">
                                <h2 data-i18n="city">City :</h2>
                                <p id="single_shop_city"></p>
                            </div>
                            <div class="address_note">
                                <h2 data-i18n="pincode">Pincode :</h2>
                                <p id="single_shop_pincode"></p>
                            </div>
                            <div class="address_note">
                                <h2 data-i18n="coordinates">Coordinates :</h2>
                                <p id="single_shop_coordinates"></p>
                            </div>
                        </div>
                    </div>
                    <div class="attach">
                        <div class="col-md-12">
                            <h2 data-i18n="other_attachments">Other Attachments :</h2>
                            <div class="attach_img">
                                <img class="uploadimgs" id="single_shop_view_image" alt="" src="">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> <span data-i18n="add_retail">Add Retailer</span></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control shop_name_box">
                                    <p class="shop_name"><span data-i18n="shop_name">Shop Name</span> <span class="mandatory_icon">*</span></p>
                                    <input class="input-field" id="shop_name" placeholder="Enter Shop Name" value="" data-i18n-placeholder="enter_shop_name">
                                </div>
                                <div class="form-control contact_person_box">
                                    <p class="contact_person" data-i18n="contact_person">Contact Person</p>
                                    <input class="input-field" id="contact_person" placeholder="Enter details" value="" data-i18n-placeholder="enter_details">
                                </div>
                                <div class="form-control contact_number_box">
                                    <p class="contact_number"><span data-i18n="contact_number">Contact Number</span> <span class="mandatory_icon">*</span></p>
                                    <input class="input-field" id="contact_number" placeholder="Enter Contact Number" value="" onkeypress="return isNumber(event)" data-i18n-placeholder="enter_contact_number">
                                </div>
                                <div class="form-control shop_type_box">
                                    <p class="shop_type"><span data-i18n="shop_type">Shop Type</span> <span class="mandatory_icon">*</span></p>
                                    <select class="input-field" id="shop_type">
                                    </select>
                                </div>
                                <!--
                                <div class="form-control slot_type_box">
                                    <p class="slot">Slot</p>
                                    <select class="input-field" id="slot_type">
                                        <option value="0%">0%</option>
                                        <option value="1%">1%</option>
                                        <option value="2%">2%</option>
                                    </select>
                                </div>
-->
                                <div class="form-control license_number_box">
                                    <p class="license_number" data-i18n="gst_number">GST Number</p>
                                    <input class="input-field" id="license_number" placeholder="Enter GST Number" value="" data-i18n-placeholder="gst_number">
                                </div>
                                <div class="form-control remove_upload_mobile" style="border: none;">
                                    <h6 data-i18n="attach_license">Attach License</h6>
                                    <label for="retailer_image_upload">
                                        <div class="custom-file">
                                            <input id="retailer_image_valid" type="hidden">
                                            <input id="retailer_image_upload" onchange="file_upload_retailer('retailer_image','retailer_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                            <h5 style="cursor: pointer;"><span data-i18n="upload_image"><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /> Upload Image</span></h5>
                                        </div>
                                        <img class="show_upload_image" style="max-height: 200px;max-width: 400px;object-fit: contain;display: block;padding: 10px 0;" id="retailer_view_image_url" />
                                        <span data-i18n="image_format_pdf">Image format should be in jpg/png/pdf</span>
                                    </label>
                                </div>
                                <div class="form-control shop_address_box">
                                    <p class="shop_address"><span data-i18n="address">Address</span> <span class="mandatory_icon">*</span></p>
                                    <input class="input-field" id="shop_address" placeholder="Enter Address" value="" data-i18n-placeholder="enter_address">
                                </div>
                                <div class="form-control shop_city_box">
                                    <p class="shop_city"><span data-i18n="city">City</span> <span class="mandatory_icon">*</span></p>
                                    <input class="input-field" id="shop_city" placeholder="Enter City" value="" data-i18n-placeholder="enter_city">
                                </div>
                                <div class="form-control shop_pincode_box">
                                    <p class="shop_pincode"><span data-i18n="pincode">Pincode</span> <span class="mandatory_icon">*</span></p>
                                    <input class="input-field" id="shop_pincode" placeholder="Enter Pincode" value="" onkeypress="return isNumber(event)" data-i18n-placeholder="enter_pincode">
                                </div>
                                <div class="form-control shop_coordinates_box">
                                    <p class="shop_coordinates" data-i18n="coordinates">Coordinates</p>
                                    <input class="input-field" id="shop_coordinates" placeholder="Enter Coordinates" value="" data-i18n-placeholder="enter_coordinates">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;" data-i18n="close">Close</a>
                            <button type="button" class="btn model-btn" onclick="add_retailer()" data-i18n="add_retail">Add Retailer</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- The Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title" data-i18n="upload_csv_file">Upload CSV File</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <label class="upload_filed" for="csv_file_upload">
                                    <input id="csv_file_valid" type="hidden">
                                    <input id="csv_file_upload" onchange="file_upload_csv('csv_file','csv_view_url','assets/upload_csv_done.png')" type="file" accept=".csv" style="display:none;">
                                    <img alt="" src="assets/csvfile.png" class="csvfile" id="csv_view_url" />
                                    <h2 id="csv_file_name" data-i18n="upload_files">Upload Files</h2>
                                </label>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                            <button type="button" class="savebtn" id="csv_upload_button" onclick="upload_csv_file()" data-dismiss="modal" data-i18n="upload">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="formUpdate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel" data-i18n="edit_retailer">Edit Retailer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <input id="edit_shop_token" type="hidden">
                                <div class="form-control edit_shop_name_box">
                                    <p class="edit_shop_name" data-i18n="shop_name">Shop Name</p>
                                    <input class="input-field" id="edit_shop_name" placeholder="Enter Shop Name" value="" data-i18n-placeholder="enter_shop_name">
                                </div>
                                <div class="form-control edit_contact_person_box">
                                    <p class="edit_contact_person" data-i18n="contact_person">Contact Person</p>
                                    <input class="input-field" id="edit_contact_person" placeholder="Enter details" value="" data-i18n-placeholder="enter_details">
                                </div>
                                <div class="form-control edit_contact_number_box">
                                    <p class="edit_contact_number" data-i18n="contact_number">Contact Number</p>
                                    <input class="input-field" id="edit_contact_number" placeholder="Enter Contact Number" value="" data-i18n-placeholder="enter_contact_number">
                                </div>
                                <div class="form-control edit_shop_type_box">
                                    <p class="edit_shop_type" data-i18n="shop_type">Shop Type</p>
                                    <select class="input-field" id="edit_shop_type">
                                    </select>
                                </div>
                                <!--
                                <div class="form-control slot_type_box">
                                    <p class="slot">Slot</p>
                                    <select class="input-field" id="edit_slot_type">
                                        <option value="0%">0%</option>
                                        <option value="1%">1%</option>
                                        <option value="2%">2%</option>
                                    </select>
                                </div>
-->
                                <div class="form-control edit_license_number_box">
                                    <p class="edit_license_number" data-i18n="gst_number">GST Number</p>
                                    <input class="input-field" id="edit_license_number" placeholder="Enter GST Number" value="" data-i18n-placeholder="gst_number">
                                </div>
                                <div class="form-control remove_upload_mobile" style="border: none;">
                                    <h6 data-i18n="attach_license">Attach License</h6>
                                    <label for="edit_retailer_image_upload">
                                        <div class="custom-file">
                                            <input id="edit_retailer_image_valid" type="hidden">
                                            <input id="edit_retailer_image_upload" onchange="file_upload_retailer('edit_retailer_image','edit_retailer_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                            <h5 style="cursor: pointer;"><span data-i18n="upload_image"><img class="fa-upload" src="assets/upload_image_arrow_icon.png"> Upload Image</span></h5>
                                        </div>
                                        <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="edit_retailer_view_image_url" />
                                        <span data-i18n="image_format_pdf">Image format should be in jpg/png/pdf</span>
                                    </label>
                                </div>
                                <div class="form-control edit_shop_address_box">
                                    <p class="edit_shop_address" data-i18n="address">Address</p>
                                    <input class="input-field" id="edit_shop_address" placeholder="Enter Address" data-i18n-placeholder="enter_address">
                                </div>
                                <div class="form-control edit_shop_city_box">
                                    <p class="edit_shop_city" data-i18n="city">City</p>
                                    <input class="input-field" id="edit_shop_city" placeholder="Enter City" data-i18n-placeholder="enter_city">
                                </div>
                                <div class="form-control edit_shop_pincode_box">
                                    <p class="edit_shop_pincode" data-i18n="pincode">Pincode</p>
                                    <input class="input-field" id="edit_shop_pincode" placeholder="Enter Pincode" data-i18n-placeholder="enter_pincode">
                                </div>
                                <div class="form-control edit_shop_coordinates_box">
                                    <p class="edit_shop_coordinates" data-i18n="coordinates">Coordinates</p>
                                    <input class="input-field" id="edit_shop_coordinates" placeholder="Enter Coordinates" data-i18n-placeholder="enter_coordinates">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;" data-i18n="close">Close</a>
                            <button type="button" class="btn model-btn" id="update_retailer_button" onclick="update_retailer()" data-i18n="update_retailer">Update Retailer</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var token;
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var redirectUrl="<?php echo $baseUrlPath; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
            var state_token = "<?php echo $_SESSION["state_id"]; ?>";
            var shop_redirect = "<?php echo $_SESSION["particular_shop_redirect"]; ?>";
            var is_redirect_retailer_sub_page = "<?php echo $_SESSION["is_redirect_retailer_sub_page"]; ?>";
            var token = "<?php echo $_SESSION["retailer_token"]; ?>";
            $('#datepicker').datepicker({
                autoclose: true,
                todayHighlight: true,
            });
            $('#datepicker1').datepicker({
                autoclose: true,
                todayHighlight: true,
            });
            var verfication_code = "<?php echo $verification_code; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
            var api_path = "<?php echo $api_path; ?>";
            var tcpf_file = "<?php echo $tcpf_file; ?>";
            var table;
            var unitToken;
            // var globalToken="<?php echo $_GET['unitToken'] ?>";
            // unitToken =globalToken.substring(4);
            var globalToken = "<?php echo isset($_GET['unitToken']) ? $_GET['unitToken'] : ''; ?>";
            var unitToken = globalToken.length >= 4 ? globalToken.substring(4) : "";
            $(document).ready(function() {
                $("#contact_number,#edit_contact_number").attr("maxlength", "10");
                $("#license_number,#edit_license_number").attr("maxlength", "16");
                $("#contact_number,#edit_contact_number").keypress(function(e) {
                    var kk = e.which;
                    if (kk < 48 || kk > 57)
                        e.preventDefault();
                });
                $("#contact_person,#edit_contact_person").keypress(function(e) {
                    var rr = e.which;
                    if ((rr < 31 || rr > 32) && (rr < 97 || rr > 122) && (rr < 65 || rr > 90))
                        e.preventDefault();
                });
                $("#shop_pincode,#edit_shop_pincode").attr("maxlength", "6");
                $("#shop_pincode,#edit_shop_pincode").keypress(function(e) {
                    var kk = e.which;
                    if (kk < 48 || kk > 57)
                        e.preventDefault();
                });

                var datasUnit = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "unit_List"
                };
                var json_data_unit = JSON.stringify(datasUnit);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data_unit,
                    success: unitLists,
                });

                var datas = {
                    dashboard_code: verfication_code,
                    type: "All"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/shop_type.php",
                    data: json_data,
                    success: shop_type,
                });
                if (shop_redirect == "false") {
                    $("#retailer_table").show();
                    $("#retailer_view").hide();
                    data_fetch();
                } else {
                    $("#retailer_table").hide();
                    particularShopDetail(retailerToken);
                    $("#retailer_view").show();
                }
            });

            function back_view_retailer() {
                console.log('hello1');
                $(".new_desing").css("display", "block");
                var datas = {
                    dashboard_code: verfication_code,
                    particular_shop_redirect: "false",
                    type: "shop_back_view_retailer"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data,
                }).done(function(data) {

                });
                $(".old_desing").css("display", "none");
                // $(".main-contents").css("margin-left", "0");
                $("#table_data").css("width", "100%");
                if (is_redirect_retailer_sub_page == "true") {
                    var datas = {
                        dashboard_code: verfication_code,
                        is_redirect_retailer_sub_page: "false",
                        type: "shop_redirect_status"
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/distributor/order_details.php",
                        data: json_data,
                    }).done(function(data) {});
                }
                $("#retailer_view").hide();
                $("#retailer_table").show();
            }

            function unitLists(data) {
                var unitList = data.data;
                var optionText1;
                optionText1 += '<option value=" ">Select Unit</option>';
                for (var key in unitList) {
                    optionText1 += '<option value="' + unitList[key].unit_token + '">' + unitList[key].unit_name + '</option>';
                }
                $(".sel_drop").html(optionText1);
            }

            function data_fetch() {
                $(".se-pre-con").fadeIn();
                $(".old_desing").css("display", "none");
                // $(".main-contents").css("margin-left", "0");
                $("#table_data").css("width", "100%");
                
                // var globalUnitToken=localStorage.getItem("globalUnitToken");
                // if(globalUnitToken=='' || globalUnitToken==undefined){ 
                  $("#unitSelectedName").val(unitToken);
                 
                // }else{
                //     var unitToken =globalUnitToken;
                //     $("#unitSelectedName").val(globalUnitToken);
                // }
                if ($.fn.DataTable.isDataTable('#table_data')) {
                    $('#table_data').DataTable().clear().destroy();
                }
                table = $('#table_data').DataTable({
                    stateSave: true, 
                    scrollX: true,
                    scrollY: true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }, ],
                    'ajax': {
                        'url': api_path + "/distributor/server_retailer_list.php?unitToken=" + unitToken + "&v_id=" + verfication_code + "&dist_id=" + distributor_token,
                        'dataSrc': function(data) {
                            $("#total_retailer_count").html(data.iTotalDisplayRecords || 0);
                            return data.aaData || [];
                        },
                        'error': function() {
                            $("#total_retailer_count").html(0);
                            $(".se-pre-con").fadeOut();
                            swal("Retailer data load failed. Please try again.");
                        }
                    },
                    "order": [
                        [0, "DESC"]
                    ],

                    'columns': [{
                            data: 'token'
                        },
                        {
                            data: 'retail_code'
                        },
                        {
                            data: 'retailer_name'
                        },
                        {
                            data: 'shop_type'
                        },
                        {
                            data: 'unit_name'
                        },
                        {
                            data: 'mobile_number'
                        },
                        {
                            data: 'contact_person'
                        },
                        {
                            data: 'join_date'
                        },
                        {
                            data: 'license_number'
                        },
                        {
                            data: 'paid_amount'
                        },
                        {
                            data: 'outstanding_amt'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.shop_show_status == "Inactive") {
                            $('td', nRow).css('background-color', '#ff9d87');
                        }
                    },
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    },
                    initComplete: function() {
                        $(".se-pre-con").fadeOut();
                    }
                });
                table.column(0).visible(false);
                $('.dataTables_length').css("display", "none");
                $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");
            }
            

            function unitFilterBtn() {
                unitToken = $("#unitSelectedName").val();
                if (unitToken != undefined) {
                    //localStorage.setItem("globalUnitToken",unitToken);
                    data_fetch();
                }
            }

            $('#table_data tbody').on('click', '.item_code_edit', function() {
                var td_div = $(this).parent().parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "single_retailer",
                    retailer_token: token,
                    particular_shop_redirect: "false"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data,
                }).done(function(data) {
                    var retailer_data = data.data;
                    $("#edit_shop_token").val(retailer_data.shop_token);
                    $("#edit_shop_name").val(retailer_data.shop_name);
                    $("#edit_contact_person").val(retailer_data.contact_person);
                    $("#edit_contact_number").val(retailer_data.shop_mobile_number);
                    $("#edit_shop_type").val(retailer_data.shop_type_code);
                    $("#edit_license_number").val(retailer_data.license_number);
                    $("#edit_shop_address").val(retailer_data.address);
                    $("#edit_shop_city").val(retailer_data.city);
                    $("#edit_shop_pincode").val(retailer_data.pincode);
                    $("#edit_shop_coordinates").val(retailer_data.coordinates);
                    //$("#edit_slot_type").val(retailer_data.slot);
                    if (retailer_data.license_image == "") {
                        $("#edit_retailer_view_image_url").attr("src", "");
                        $("#edit_retailer_view_image_url").css("display", "none");
                    } else {
                        $("#edit_retailer_view_image_url").attr("src", retailer_data.license_image);
                        $("#edit_retailer_view_image_url").css("display", "block");
                    }
                    $("#edit_retailer_image_valid").val(retailer_data.license_image);
                    $("#formUpdate").modal('show');
                });
            });

            $('#table_data tbody').on('click', '.item_code_view', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                token = table_data.token;
                var unitToken = $("#unitSelectedName").val();
                var datas = {
                    type: "token",
                    dashboard_code: verfication_code,
                    token: token,
                    unitToken:unitToken
                };
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data,
                    success: function(data) {
                         window.location.href = redirectUrl + "distributor_dashboard/take_order";
                    }
                });

            });

            $('#table_data tbody').on('click', '.item_code_viewSingle', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                token = table_data.token;
                particularShopDetail(token);
            });

            function particularShopDetail(token) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "single_retailer",
                    retailer_token: token,
                    particular_shop_redirect: "true"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data,
                }).done(function(data) {
                    var retailer_data = data.data;
                    $("#single_shop_name").html(retailer_data.shop_name);
                    $("#single_shop_name1").html(retailer_data.shop_name);
                    $("#single_shop_person").html(retailer_data.contact_person);
                    $("#single_shop_contact").html(retailer_data.shop_mobile_number);
                    $("#single_shop_type").html(retailer_data.shop_type);
                    $("#single_shop_license").html(retailer_data.license_number);
                    $("#single_shop_address").html(retailer_data.address);
                    $("#single_shop_city").html(retailer_data.city);
                    $("#single_shop_pincode").html(retailer_data.pincode);
                    $("#single_shop_coordinates").html(retailer_data.coordinates);
                    //$("#single_shop_slot").html(retailer_data.slot);
                    $("#update_status_token").val(retailer_data.shop_token);
                    if (retailer_data.license_image == "") {
                        $("#single_shop_view_image").attr("src", "");
                        $("#single_shop_view_image").css("display", "none");
                    } else {
                        $("#single_shop_view_image").attr("src", retailer_data.license_image);
                        $("#single_shop_view_image").css("display", "block");
                    }
                    if (retailer_data.shop_show_status == "Active") {
                        $(".de_activate").html('<a class="view_link" onclick="inactivate()">Inactivate Shop</a>');
                        $(".de_activate > a").css('color', 'red');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    } else {
                        $(".de_activate").html('<a class="view_link" onclick="activate()">Activate Shop</a>');
                        $(".de_activate > a").css('color', 'green');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    }
                    $(".se-pre-con").hide();
                    $("#retailer_table").hide();
                    $(".new_desing").css("display", "none");
                    $(".old_desing").css("display", "block");
                    // $(".main-contents").css("margin-left", "300px");
                    $("#table_data").css("width", "1544px");
                    $("#retailer_view").show();
                });
            }


            var shopTypeData;

            function shop_type(data) {
                shopTypeData = data.data;
                var optionText;
                optionText += '<option value="">Select Shop Type</option>';
                for (var key in shopTypeData) {
                    optionText += '<option value="' + shopTypeData[key].shop_token + '">' + shopTypeData[key].shop_type + '</option>';
                }
                $("#edit_shop_type").html(optionText);
                $("#shop_type").html(optionText);
            }

            function add_retailer() {
                var shop_name = $("#shop_name").val();
                var val1 = value_check('shop_name', shop_name, 'text_box');
                var contact_person = $("#contact_person").val();
                var contact_number = $("#contact_number").val();
                var val2 = value_check('contact_number', contact_number, 'mobile', 'Contact Number');
                var shop_type = $("#shop_type").val();
                var val3 = value_check('shop_type', shop_type, 'text_box');
                var license_number = $("#license_number").val();
                var shop_address = $("#shop_address").val();
                var val4 = value_check('shop_address', shop_address, 'text_box');
                var shop_city = $("#shop_city").val();
                var val5 = value_check('shop_city', shop_city, 'text_box');
                var shop_pincode = $("#shop_pincode").val();
                var val6 = value_check('shop_pincode', shop_pincode, 'pin_code', 'Pincode');
                var shop_coordinates = $("#shop_coordinates").val();
                var retailer_image = $("#retailer_image_valid").val();
                //                var slot_type = $("#slot_type").val();
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val6 == true) {
                    $(".se-pre-con").show();
                    image_upload_loop(0);
                } else {
                    swal("Please enter mandatory details!");
                }
            }

            var image_id = ['retailer_image'];

            function image_upload_loop(key) {
                var valid = $("#" + image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > image_id.length) {
                        add_retailer_finish();
                    } else {
                        var fileUpload = document.getElementById(image_id[key] + "_upload");
                        var file = fileUpload.files[0];
                        s3_file_upload(file, key);
                    }
                } else {
                    if (valid != undefined) {
                        $("#" + image_id[key] + "_valid").val(valid);
                        key++;
                        image_upload_loop(key);
                    } else {
                        add_retailer_finish();
                    }
                }
            }

            function add_retailer_finish() {
                var shop_name = $("#shop_name").val();
                var contact_person = $("#contact_person").val();
                var contact_number = $("#contact_number").val();
                var shop_type = $("#shop_type").val();
                var license_number = $("#license_number").val();
                var shop_address = $("#shop_address").val();
                var shop_city = $("#shop_city").val();
                var shop_pincode = $("#shop_pincode").val();
                var shop_coordinates = $("#shop_coordinates").val();
                var retailer_image = $("#retailer_image_valid").val();
                //                var slot_type = $("#slot_type").val();
                var datas = {
                    'shop_name': shop_name,
                    'contact_person': contact_person,
                    'contact_number': contact_number,
                    'shop_type': shop_type,
                    'license_number': license_number,
                    'shop_address': shop_address,
                    'shop_city': shop_city,
                    'shop_pincode': shop_pincode,
                    'shop_coordinates': shop_coordinates,
                    'retailer_image': retailer_image,
                    //                    'slot_type': slot_type,
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token,
                    'state_token': state_token
                }
                var json_data = JSON.stringify(datas);
                console.log('addshop', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/add_retailer.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == "200") {
                        $(".se-pre-con").hide();
                        swal("Shop Added Successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $(".se-pre-con").hide();
                        $('#add_employee_button').prop('disabled', false);
                        swal(data.message);

                    }
                });
            }
            /* ============== Only Allow Numeric value in Phone Field code ============== */
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }

            function upload_csv_file() {
                $(".se-pre-con").fadeIn();
                var valid = $('#csv_file_valid').val();
                if (valid == "true") {
                    $('#myModal').modal('hide');
                    $('#csv_upload_button').prop('disabled', true);
                    var myFormData = new FormData();
                    myFormData.append('file_upload', csv_file_upload.files[0]);
                    $.ajax({
                        dataType: "json",
                        url: api_path + "/distributor/uploadRetailerCsv.php",
                        type: 'POST',
                        // async: false,
                        processData: false, // important
                        contentType: false, // important
                        data: myFormData,
                        success: function(data) {
                            console.log(data);
                            if (data.code == 503) {
                                $('#csv_upload_button').prop('disabled', false);
                                var err_msg = "";
                                if (data.message != undefined) {
                                    err_msg += data.message + "\n";
                                }
                                if (data.message1 != undefined) {
                                    err_msg += data.message1;
                                }
                                if (err_msg != "") {
                                    $(".se-pre-con").fadeOut();
                                    swal(err_msg).then((value) => {
                                        location.reload();
                                    });
                                }
                            } else if (data.code == 201) {
                                $(".se-pre-con").fadeOut();
                                swal("Csv data uploaded successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    $(".se-pre-con").fadeOut();
                    swal("Please select a csv file!");
                }
            }
            $(".cancelbtn").click(function() {
                $("#csv_view_url").attr("src", "assets/csvfile.png");
                $("#csv_file_name").text("Upload Files");
                $('#csv_file_valid').val(false);
                $("#csv_file_upload").val('');
            });

            function update_retailer() {
                var shop_name = $("#edit_shop_name").val();
                var val1 = value_check('edit_shop_name', shop_name, 'text_box');
                var contact_person = $("#edit_contact_person").val();
                var contact_number = $("#edit_contact_number").val();
                var val2 = value_check('edit_contact_number', contact_number, 'mobile', 'Contact Number');
                var shop_type = $("#edit_shop_type").val();
                var val3 = value_check('edit_shop_type', shop_type, 'text_box');
                var license_number = $("#edit_license_number").val();
                var shop_address = $("#edit_shop_address").val();
                var val4 = value_check('edit_shop_address', shop_address, 'text_box');
                var shop_city = $("#edit_shop_city").val();
                var val5 = value_check('edit_shop_city', shop_city, 'text_box');
                var shop_pincode = $("#edit_shop_pincode").val();
                var val6 = value_check('edit_shop_pincode', shop_pincode, 'pin_code', 'Pincode');
                var shop_coordinates = $("#edit_shop_coordinates").val();
                var retailer_image = $("#edit_retailer_image_valid").val();
                //                var slot_type = $("#edit_slot_type").val();
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val6 == true) {
                    setTimeout(function() {
                        $(".se-pre-con").show();
                    }, 5);
                    $('#update_retailer_button').prop('disabled', true);
                    if (retailer_image == "true") {
                        edit_image_upload_loop(0);
                    } else {
                        update_retailer_finish();
                    }
                } else {
                    swal("Please enter mandatory details!");
                }
            }
            var edit_image_id = ['edit_retailer_image'];

            function edit_image_upload_loop(key) {
                var valid = $("#" + edit_image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > edit_image_id.length) {
                        update_retailer_finish();
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
                        update_retailer_finish();
                    }
                }
            }

            function update_retailer_finish() {
                var shop_token = $("#edit_shop_token").val();
                var shop_name = $("#edit_shop_name").val();
                var contact_person = $("#edit_contact_person").val();
                var contact_number = $("#edit_contact_number").val();
                var shop_type = $("#edit_shop_type").val();
                var license_number = $("#edit_license_number").val();
                var shop_address = $("#edit_shop_address").val();
                var shop_city = $("#edit_shop_city").val();
                var shop_pincode = $("#edit_shop_pincode").val();
                var shop_coordinates = $("#edit_shop_coordinates").val();
                var retailer_image = $("#edit_retailer_image_valid").val();
                //                var slot_type = $("#edit_slot_type").val();
                var datas = {
                    'shop_token': shop_token,
                    'shop_name': shop_name,
                    'contact_person': contact_person,
                    'contact_number': contact_number,
                    'shop_type': shop_type,
                    'license_number': license_number,
                    'shop_address': shop_address,
                    'shop_city': shop_city,
                    'shop_pincode': shop_pincode,
                    'shop_coordinates': shop_coordinates,
                    'retailer_image': retailer_image,
                    //                    'slot_type': slot_type,
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token
                }
                var json_data = JSON.stringify(datas);
                console.log('edit', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/update_retailer.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if (data.status_code == 200) {
                        swal("Retailer updated successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#update_retailer_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }

            function inactivate() {
                var token = $("#update_status_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this shop?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'shop_token': token,
                            'shop_show_status': 'Inactive',
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'shop_mapping_status': '1',
                            'type': 'shopStatusChange'
                        }
                        var json_data = JSON.stringify(datas);
                        console.log('Inactive', json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/retailer_list.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                swal("Shop deactivated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    particularShopDetail(token);
                                });
                            }
                        });
                    }
                });
            }

            function activate() {
                var token = $("#update_status_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to activate this shop?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'shop_token': token,
                            'shop_show_status': 'Active',
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'shop_mapping_status': '0',
                            'type': 'shopStatusChange'
                        }
                        var json_data = JSON.stringify(datas);
                        console.log('Active', json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/distributor/retailer_list.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                swal("Shop activated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    particularShopDetail(token);
                                });
                            }
                        });
                    }
                });
            }

            function unitWiseShopList() {
                var unitToken = $("#unitSelectedName").val();
                var unitName = $("#unitSelectedName option:selected").text();
                if (unitName != " " && unitToken != " ") {
                    var pdfBtn = $("#download_pdf_btn");
                    pdfBtn.prop("disabled", true).text("Generating...");
                    var unitNam = '';
                    if (unitName != 'Without Unit') {
                        unitNam = '( ' + unitName + ' )';
                    }
                    var datas1 = {
                        'unitToken': unitToken,
                        'distributor_token': distributor_token,
                        'unitName': unitNam
                    };
                    var json_data = JSON.stringify(datas1);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "../TCPDF-main/examples/unitWiseShopList.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.status_code == 200 && data.data) {
                            window.open('../invoice_pdf/' + data.data, '_blank');
                            if (typeof Android !== "undefined" && Android.showToast) {
                                Android.showToast(`${tcpf_file+data.data}`);
                            }
                        } else {
                            swal("PDF generation failed. Please try again.");
                        }
                    }).fail(function() {
                        swal("PDF generation failed. Please try again.");
                    }).always(function() {
                        pdfBtn.prop("disabled", false).text("Download As PDF");
                    });
                } else {
                    swal("Please Select Unit Name");
                }
            }

            function unitWiseShopExcelList() {
                var unitToken = $("#unitSelectedName").val();
                var unitName = $("#unitSelectedName option:selected").text();
                if (unitName != " " && unitToken != " ") {
                    var unitNam = '';
                    if (unitName != 'Without Unit') {
                        unitNam = '( ' + unitName + ' )';
                    }

                    var form = $('<form>', {
                        method: 'POST',
                        action: api_path + "/distributor/unitWiseShopListExcel.php",
                        target: '_blank'
                    });
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'unitToken',
                        value: unitToken
                    }));
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'distributor_token',
                        value: distributor_token
                    }));
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'unitName',
                        value: unitNam
                    }));
                    form.append($('<input>', {
                        type: 'hidden',
                        name: 'v_id',
                        value: verfication_code
                    }));
                    $('body').append(form);
                    form.submit();
                    form.remove();
                } else {
                    swal("Please Select Unit Name");
                }
            }

            $('body').on('change', '#contact_number', function() {
                var datas = {
                    'dashboard_code': verfication_code,
                    'distributor_token': distributor_token,
                    'contact_number': $("#contact_number").val(),
                    'type': 'is_mobNo_exist'
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/retailer_list.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 400) {
                        swal("Mobile Number already exist!");
                        $('#contact_number').val('');
                    } else if (data.status_code == 200) {}
                });
            });
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>
