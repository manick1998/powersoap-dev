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
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
        <style>
            .a_button {
                color: #00b9f5;
            }

            .edit_input,
            .de_activate {
                cursor: pointer;
            }

            .twoback {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
            }

            .mrgzro {
                margin: 0 !important;
            }

            .header_container {
                width: 100%;
                margin: auto;
                padding: 20px;
            }

            .sep_word {
                display: flex !important;
                padding: 10px;
                width: 100%;
                align-items: center;
                justify-content: space-between;
            }

            /*
    .header-section {
    display: block;
    width: 100%;
    position: relative;
    padding: 10px;
    }
*/
            .twoinspace {
                margin-left: 20px;
                color: #000 !important;
            }

            .header_main img {
                width: 30px;
                cursor: pointer;
                margin-right: 20px;
            }

            .bot_line {
                margin-bottom: 20px;
                border-bottom: 1px solid #DDECEF;
                padding-bottom: 20px;
            }

            .add_new_top {
                margin-top: 20px;
                display: flex;
                width: 100%;
            }

            .uploadimgs {
                width: 100%;
                object-fit: contain;
            }

            .add_new_top h2 {
                font-size: 18px;
                line-height: 20px;
            }

            .nav-item button {
                width: auto;
                height: 38px;
                color: #fff;
                margin: 0 5px;
            }

            .nav-pills .nav-link.active,
            .nav-pills .show>.nav-link {
                background-color: #00b9f5;
                border: 1px solid #04bcf4;
            }

            .pdf-btn {
                background: #bc87f0 !important;
                border: 1px solid #bc87f0;
                padding: 6px 15px;
                border-radius: 4px;
            }

            .name_box {
                color: #000;
                font-weight: 600;
                letter-spacing: 1px;
            }

            .codelevel p {
                font-size: 16px;
                line-height: 20px;
            }

            .codelevel p span {
                font-weight: 600;
                letter-spacing: 0.5px;
            }

            .address_field {
                display: flex;
                margin: 30px 0;
            }

            .address_note h2 {
                font-size: 18px;
                line-height: 20px;
                font-weight: 600;
            }

            .address_note p {
                font-size: 16px;
                line-height: 26px;
                width: 100%;
                margin: 0;
            }

            .attach {
                display: block;
                width: 100%;
            }

            .attach h2 {
                font-size: 18px;
                line-height: 20px;
                font-weight: 600;
            }

            .attach_img {
                width: 100%;
                display: flex;
            }

            .attach_img img {
                border: 1px solid #ccc;
                margin: 5px;
                width: 100px;
                height: 100px;
                object-fit: contain;
            }

            .form-control {
                display: block;
                width: 100%;
                padding: .375rem .75rem;
                font-size: 1rem;
                line-height: 1.5;
                color: #495057;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid #ced4da;
                border-radius: .25rem;
                transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            }

            select.form-control {
                border: 1px solid var(--primary-color);
                color: var(--primary-color);
            }

            div.dataTables_wrapper div.dataTables_filter {
                text-align: right;
            }

            .product_list {
                row-gap: 12px;
            }

            .dataTables_filter label {
                position: relative;
                top: 0;
            }

            .dt-buttons.btn-group {
                margin-left: 1.3rem;
            }

            @media only screen and (max-width:1600px) {
                .custom-table.dataTable.no-footer {
                    display: block;
                    overflow-x: scroll;
                }
            }
        </style>
    </head>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar4"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="retailer_table">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main">Retailer List</h1>
                        </div>
                        <p class="table_count">Total Retailer - <span id="total_retailer_count"></span></p>
                    </div>
                </div>
                <ul class="nav nav-pills product_list mb-3 px-3" id="pills-tab" role="tablist">
                    <!--
            <li class="nav-item " role="">
                <button onclick="show_RetailerCSV()" class="nav-link active" >CSV</button>
            </li>
            <li class="nav-item " role="">
                <button onclick="show_RetailerPDF()"  class="pdf-btn" >PDF</button>
            </li>
-->
                    <li class="nav-item mx-1" role="">
                        <select name="" id="selectState" class="form-control">
                        </select>
                    </li>
                    <li class="nav-item mx-1" role="">
                        <select name="" id="selectCity" class="form-control">
                        </select>
                    </li>
                    <li class="nav-item mx-1" role="">
                        <select name="" id="selectdist" class="form-control">
                        </select>
                    </li>
                    <li class="nav-item " role="">
                        <button onclick="gobutton();" class="nav-link active">Go</button>
                    </li>
                </ul>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <!--
                <div class="form-group"> 
                    <button class="btn_employee "class="btn btn-danger" data-toggle="modal" data-target="#form" type="button"><span><img src="assets/retailer.png" class="icon_add"></span> Add Retail</button>
                </div>
                <div class="form-group">
                    <button class="btn_employees active"  type="button" data-toggle="modal" data-target="#myModal">Upload CSV</button>
                </div>
                <div class="form-group">
                    <button class="btn_employees active" type="button"><a  class="a_button" href="assets/csv/sampleRetailerCsv.csv" download>Sample CSV File</a></button>
                </div>
-->

                    </form>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Retailer Code</th>
                                <th>Retailer Name</th>
                                <th>Distibutor Name</th>
                                <!-- <th>Distributor Token</th> -->
                                <th>Type</th>
                                <th>Mobile Number</th>
                                <th>Contact Person</th>
                                <th>Region</th>
                                <th>State</th>
                                <th>Area</th>
                                <th>GST Number</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Pincode</th>
                                <th>Action</th>
                                <th>reason</th>
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
                        <input id="distributor_token" type="hidden">
                        <div class="de_activate">
                        </div>
                    </div>
                    <div class="add_new_top bot_line">
                        <div class="col-md-12">
                            <h2 class="name_box" id="single_shop_name"></h2>
                            <div class="row">
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Shop Name : <span id="single_shop_name1"></span></p>
                                        <p>Shop Type : <span id="single_shop_type"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Contact Person : <span id="single_shop_person">34 Years</span></p>
                                        <!--                        <p>Slot : <span id="single_shop_slot"></span></p>-->
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Contact Number : <span id="single_shop_contact"></span></p>
                                        <p>GST Number : <span id="single_shop_license"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="address_field">
                        <div class="col-md-12">
                            <div class="address_note">
                                <h2>Address :</h2>
                                <p id="single_shop_address"></p>
                            </div>
                            <div class="address_note">
                                <h2>City :</h2>
                                <p id="single_shop_city"></p>
                            </div>
                            <div class="address_note">
                                <h2>Pincode :</h2>
                                <p id="single_shop_pincode"></p>
                            </div>
                            <div class="address_note">
                                <h2>Coordinates :</h2>
                                <p id="single_shop_coordinates"></p>
                            </div>
                        </div>
                    </div>
                    <div class="attach">
                        <div class="col-md-12">
                            <h2>Other Attachments :</h2>
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
                            <h4 class="modal-title" id="myModalLabel1">Add Retailer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control shop_name_box">
                                    <p class="shop_name">Shop Name</p>
                                    <input class="input-field" id="shop_name" placeholder="Enter Shop Name" value="">
                                </div>
                                <div class="form-control contact_person_box">
                                    <p class="contact_person">Contact Person</p>
                                    <input class="input-field" id="contact_person" placeholder="Enter details" value="">
                                </div>
                                <div class="form-control contact_number_box">
                                    <p class="contact_number">Contact Number</p>
                                    <input class="input-field numberonly" maxlength="10" id="contact_number" placeholder="Enter Contact Number" value="">
                                </div>
                                <div class="form-control shop_type_box">
                                    <p class="shop_type">Shop Type</p>
                                    <select class="input-field" id="shop_type">
                                        <option value="">Select Shop Type</option>
                                    </select>
                                </div>
                                <div class="form-control license_number_box">
                                    <p class="license_number">GST Number</p>
                                    <input class="input-field" id="license_number" placeholder="Enter License Number" value="">
                                </div>
                                <div class="form-control" style="border: none;">
                                    <h6>Attach License</h6>
                                    <label for="retailer_image_upload">
                                        <div class="custom-file">
                                            <input id="retailer_image_valid" type="hidden">
                                            <input id="retailer_image_upload" onchange="file_upload_retailer('retailer_image','retailer_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                            <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                        </div>
                                        <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="retailer_view_image_url" />
                                        <span>Image format should be in jpg/png/pdf</span>
                                    </label>
                                </div>
                                <div class="form-control shop_address_box">
                                    <p class="shop_address">Address</p>
                                    <input class="input-field" id="shop_address" placeholder="Enter Address" value="">
                                </div>
                                <div class="form-control shop_city_box">
                                    <p class="shop_city">City</p>
                                    <input class="input-field" id="shop_city" placeholder="Enter City" value="">
                                </div>
                                <div class="form-control shop_pincode_box">
                                    <p class="shop_pincode">Pincode</p>
                                    <input class="input-field" id="shop_pincode" placeholder="Enter Pincode" value="">
                                </div>
                                <div class="form-control shop_coordinates_box">
                                    <p class="shop_coordinates">Coordinates</p>
                                    <input class="input-field" id="shop_coordinates" placeholder="Enter Coordinates" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="add_retailer_button" onclick="add_retailer()">Add Retailer</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="formUpdate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel2">Edit Retailer</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <input id="edit_shop_token" type="hidden">
                                <div class="form-control edit_shop_name_box">
                                    <p class="edit_shop_name">Shop Name</p>
                                    <input class="input-field" id="edit_shop_name" placeholder="Enter Shop Name" value="">
                                    <input type="hidden" id="old_name" value="">
                                </div>
                                <div class="form-control edit_contact_person_box">
                                    <p class="edit_contact_person">Contact Person</p>
                                    <input class="input-field" id="edit_contact_person" placeholder="Enter details" value="">
                                </div>
                                <div class="form-control edit_contact_number_box">
                                    <p class="edit_contact_number">Contact Number</p>
                                    <input class="input-field numberonly" id="edit_contact_number" maxlength="10" placeholder="Enter Contact Number" value="">
                                    <input type="hidden" id="old_number" value="">
                                </div>
                                <div class="form-control edit_shop_type_box">
                                    <p class="edit_shop_type">Shop Type</p>
                                    <select class="input-field" id="edit_shop_type">
                                    </select>
                                </div>
                                <div class="form-control edit_license_number_box">
                                    <p class="edit_license_number">GST Number</p>
                                    <input class="input-field" id="edit_license_number" placeholder="Enter License Number" value="">
                                    <input type="hidden" id="old_licens" value="">
                                </div>
                                <div class="form-control" style="border: none;">
                                    <h6>Attach License</h6>
                                    <label for="edit_retailer_image_upload">
                                        <div class="custom-file">
                                            <input id="edit_retailer_image_valid" type="hidden">
                                            <input id="edit_retailer_image_upload" onchange="file_upload_retailer('edit_retailer_image','edit_retailer_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                            <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                        </div>
                                        <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="edit_retailer_view_image_url" />
                                        <span>Image format should be in jpg/png/pdf</span>
                                    </label>
                                </div>
                                <div class="form-control edit_shop_address_box">
                                    <p class="edit_shop_address">Address</p>
                                    <input class="input-field" id="edit_shop_address" placeholder="Enter Address">
                                    <input type="hidden" id="old_address" value="">
                                </div>
                                <div class="form-control edit_shop_city_box">
                                    <p class="edit_shop_city">City</p>
                                    <input class="input-field" id="edit_shop_city" placeholder="Enter City">
                                    <input type="hidden" id="old_city" value="">
                                </div>
                                <div class="form-control edit_shop_pincode_box">
                                    <p class="edit_shop_pincode">Pincode</p>
                                    <input class="input-field" id="edit_shop_pincode" placeholder="Enter Pincode">
                                    <input type="hidden" id="old_pincode" value="">
                                </div>
                                <div class="form-control edit_shop_coordinates_box">
                                    <p class="edit_shop_coordinates">Coordinates</p>
                                    <input class="input-field" id="edit_shop_coordinates" placeholder="Enter Coordinates">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="update_retailer_button" onclick="update_retailer()">Update Retailer</button>
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
                            <h4 class="modal-title">Upload CSV File</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="row">
                                <label class="upload_filed" for="csv_file_upload">
                                    <input id="csv_file_valid" type="hidden">
                                    <input id="csv_file_upload" onchange="file_upload_csv('csv_file','csv_view_url','assets/upload_csv_done.png')" type="file" accept=".csv" style="display:none;">
                                    <img alt="" src="assets/csvfile.png" class="csvfile" id="csv_view_url" />
                                    <h2 id="csv_file_name">Upload Files</h2>
                                </label>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                            <button type="button" class="savebtn" id="csv_upload_button" onclick="upload_csv_file()">Upload</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACTVATE SHOP -->
            <div class="modal fade" id="activate-shop" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel3">Deactivate shop</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control shop_name_box">
                                    <p class="shop_name">Shop Name</p>
                                    <input class="input-field" id="shop_reason" placeholder="Enter Reason" value="">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <!-- <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Cancel</a> -->
                            <button type="button" class="btn model-btn" onclick="inactivate();">Deactivate</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
            var region_change = "";
            var dist_change = "";
        </script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->

        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var retailerToken = "<?php echo $_SESSION["retailer_token"]; ?>";
            var cookie_token = "<?php echo $cookie_token; ?>";
            localStorage.setItem("Admin_token", cookie_token);
            console.log('cookie_token', cookie_token);

            // console.log(retailerToken);
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            //console.log(api_path);
            function back_view_retailer() {
                $("#retailer_table").show();
                $("#retailer_view").hide();
            }
            $(document).ready(function() {
                data_fetch();
            });
            $(document).ready(function() {
                var datas = {
                    dashboard_code: verfication_code,
                    state_id: admin_state_id,
                    type: "count"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/retailerDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var count = data.data;
                    $("#total_retailer_count").html(numberWithCommas(count));
                });
            });
            //shop_type
            $(document).ready(function() {
                $("#edit_contact_number").attr("maxlength", "10");
                $("#edit_license_number").attr("maxlength", "16");
                $("#edit_contact_number").keypress(function(e) {
                    var kk = e.which;
                    if (kk < 48 || kk > 57)
                        e.preventDefault();
                });
                $("#edit_contact_person").keypress(function(e) {
                    var rr = e.which;
                    if ((rr < 31 || rr > 32) && (rr < 97 || rr > 122) && (rr < 65 || rr > 90))
                        e.preventDefault();
                });
                $("#edit_shop_pincode").attr("maxlength", "6");
                $("#edit_shop_pincode").keypress(function(e) {
                    var kk = e.which;
                    if (kk < 48 || kk > 57)
                        e.preventDefault();
                });

                var datas = {
                    dashboard_code: verfication_code,
                    type: "All"
                };
                var json_data = JSON.stringify(datas);
                // console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/retailerDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    let data = datas.data;
                    var optionText;
                    optionText += '<option value="">Select Shop Type</option>';
                    for (var key in data) {
                        optionText += '<option value="' + data[key].shop_token + '">' + data[key].shop_type + '</option>';
                    }
                    $("#edit_shop_type").html(optionText);
                });
            });
            //get states
            $.ajax({
                type: "GET",
                dataType: "json",
                url: api_path + "/admin/state_list.php",
            }).done(function(datas) {
                let data = datas;
                let html_text = '<option value="">Select State</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
                }
                $('#selectState').html(html_text);
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
                data: json_data,
            }).done(function(datas) {
                let data = datas.data;
                let html_text = '<option value="">Select Region</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
                }
                $('#selectCity').html(html_text);
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
                data: json_data,
            }).done(function(datas) {
                let data = datas.data;
                //console.log(data);
                let html_text = '<option value="">Select distributors</option>';
                for (let key in data) {
                    html_text += `<option value="${data[key].token}">${data[key].name}</option>`;
                }
                $('#selectdist').html(html_text);
            });

            //state change region affect
            $('#selectState').on('change', function() {
                let stateToken = $(this).find(':selected').val();
                let obj = {
                    stateToken: stateToken,
                    type: 'stateToken'
                }
                var json_data = JSON.stringify(obj);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/scheduleSalesRep.php",
                    data: json_data,
                }).done(function(datas) {
                    let data = datas.data;
                    let html_text = '<option value="">Select Region</option>';
                    for (let key in data) {
                        html_text += `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
                    }
                    $('#selectCity').html(html_text);
                });
            });
            //region change affect area

            $("#selectCity").on('change', function() {
                let regionToken = $(this).find(':selected').val();
                let regobj = {
                    dashboard_code: verfication_code,
                    regionToken: regionToken,
                    type: 'regionToken'
                }
                var json_data = JSON.stringify(regobj);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/retailerDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    let data = datas.data;
                    console.log(data);
                    let html_text = '<option value="">Select Distributor</option>';
                    data.forEach(function(item, index) {
                        html_text += `<option id='areas_name' value="${item.token}">${item.name}</option>`;
                    });
                    $('#selectdist').html(html_text);
                });
            });



            function data_fetch() {
                $(".se-pre-con").hide();
                table = $('#table_data').DataTable({
                    'stateSave': true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }, ],
                    'ajax': {
                        'url': api_path + "/admin/serverRetailerList.php?v_id=" + verfication_code + "&state_id=" + admin_state_id + "&region_token=" + region_change + "&dist_token=" + dist_change
                    },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
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
                            data: 'distributor'
                        },
                        // { data: 'distributor_token'},
                        {
                            data: 'shop_type'
                        },
                        {
                            data: 'mobile_number'
                        },
                        {
                            data: 'contact_person'
                        },
                        {
                            data: 'region_name'
                        },
                        {
                            data: 'state'
                        },
                        {
                            data: 'area_name'
                        },
                        {
                            data: 'license_number'
                        },
                        {
                            data: 'shop_address'
                        },
                        {
                            data: 'shop_city'
                        },
                        {
                            data: 'pincode'
                        },
                        {
                            data: 'action'
                        },
                        {
                            data: 'reason'
                        }
                    ],
                    dom: 'Bfrltip',
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.shop_show_status == "Inactive") {
                            $('td', nRow).css('background-color', '#ff9d87');
                        }
                    },
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    },
                    buttons: [{
                        extend: 'pdfHtml5',
                        className: 'btn-primary buttonprint',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15]
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }, {
                        extend: 'csv',
                        className: 'btn-info buttonprint',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 15]
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }]
                });
                table.column(0).visible(false);
                //$('.dataTables_length').css("display","none");
                $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");

            }
            //filter change
            function gobutton() {
                admin_state_id = $("#selectState :selected").val();
                region_change = $("#selectCity :selected").val();
                dist_change = $("#selectdist :selected").val();
                table.clear();
                table.destroy();
                data_fetch();
            }

            //edit retailer
            $('#table_data tbody').on('click', '.item_code_edit', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_retailer",
                    retailer_token: token,
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/retailerDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var retailer_data = data.data;
                    $("#edit_shop_token").val(retailer_data.shop_token);
                    $("#edit_shop_name").val(retailer_data.shop_name);
                    $("#old_name").val(retailer_data.shop_name);
                    $("#edit_contact_person").val(retailer_data.contact_person);
                    $("#edit_contact_number").val(retailer_data.shop_mobile_number);
                    $("#old_number").val(retailer_data.shop_mobile_number);
                    $("#edit_shop_type").val(retailer_data.shop_type_code);
                    $("#edit_license_number").val(retailer_data.license_number);
                    $("#old_licens").val(retailer_data.license_number);
                    $("#edit_shop_address").val(retailer_data.address);
                    $("#old_address").val(retailer_data.address);
                    $("#edit_shop_city").val(retailer_data.city);
                    $("#old_city").val(retailer_data.city);
                    $("#edit_shop_pincode").val(retailer_data.pincode);
                    $("#old_pincode").val(retailer_data.pincode);
                    $("#edit_shop_coordinates").val(retailer_data.coordinates);
                    if (retailer_data.license_image == "") {
                        $("#edit_shop_view_image").attr("src", "");
                        $("#edit_shop_view_image").css("display", "none");
                    } else {
                        $("#edit_shop_view_image").attr("src", retailer_data.license_image);
                        $("#edit_shop_view_image").css("display", "block");
                    }
                    $("#edit_retailer_image_valid").val(retailer_data.license_image);
                    $("#formUpdate").modal('show');
                });
            });
            $('#table_data tbody').on('click', '.item_code_view', function() {
                var td_div = $(this).parent().parent();
                // console.log('td_div',td_div);
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var emp_token = table_data.distributor_token;
                $("#distributor_token").val(emp_token);
                particularShopDetail(token);
            });

            function particularShopDetail(token) {
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_retailer",
                    retailer_token: token,
                    particular_shop_redirect: "true"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/retailerDetails.php",
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
                    $("#single_shop_slot").html(retailer_data.slot);
                    $("#update_status_token").val(retailer_data.shop_token);
                    if (retailer_data.license_image == "") {
                        $("#single_shop_view_image").attr("src", "");
                        $("#single_shop_view_image").css("display", "none");
                    } else {
                        $("#single_shop_view_image").attr("src", retailer_data.license_image);
                        $("#single_shop_view_image").css("display", "block");
                    }
                    if (retailer_data.shop_show_status == "Active") {
                        $(".de_activate").html('<span class="view_link" data-target="#activate-shop" data-toggle="modal">Inactive Shop</span>');
                        $(".de_activate > span").css('color', 'red');
                        $(".de_activate > span").css('text-decoration', 'underline');
                    } else {
                        $(".de_activate").html('<a class="view_link" onclick="activate()">Activate Shop</a>');
                        $(".de_activate > span").css('color', '#11b8f4');
                        $(".de_activate > span").css('text-decoration', 'underline');
                    }
                    $("#retailer_table").hide();
                    $("#retailer_view").show();
                });
            }
            //shop type
            var shopTypeData;

            function shop_type(data) {
                shopTypeData = data.data;
                var optionText;
                optionText += '<option value="">Select Shop Type</option>';
                for (var key in shopTypeData) {
                    optionText += '<option value="' + shopTypeData[key].shop_token + '">' + shopTypeData[key].shop_type + '</option>';
                }
                $("#edit_shop_type").html(optionText);
                //$("#shop_type").html(optionText);
            }


            function add_retailer() {
                //        var shop_name     = $("#shop_name").val();
                //        var val1          = value_check('shop_name',shop_name,'text_box');
                //        var contact_person= $("#contact_person").val();
                //        var val2          = value_check('contact_person',contact_person,'text_box');
                //        var contact_number= $("#contact_number").val();
                //        var val3          = value_check('contact_number',contact_number,'text_box');
                //        var shop_type     = $("#shop_type").val();
                //        var val4          = value_check('shop_type',shop_type,'text_box');
                //        var license_number= $("#license_number").val();
                //        var val5          = value_check('license_number',license_number,'text_box');
                //        var shop_address  = $("#shop_address").val();
                //        var val6          = value_check('shop_address',shop_address,'text_box');
                //        var shop_city     = $("#shop_city").val();
                //        var val7          = value_check('shop_city',shop_city,'text_box');
                //        var shop_pincode  = $("#shop_pincode").val();
                //        var val8          = value_check('shop_pincode',shop_pincode,'text_box');
                //        var shop_coordinates= $("#shop_coordinates").val();
                //        var val9          = value_check('shop_coordinates',shop_coordinates,'text_box');
                //        var retailer_image= $("#retailer_image_valid").val();
                //        var val10         = value_check('',retailer_image,'image');
                //        if(val1==true && val2==true && val3==true && val4==true && val5==true && val6==true && val7==true && val8==true && val9==true && val10==true){
                //            $("#form").modal('hide');
                //            setTimeout(function () {  
                //                $(".se-pre-con").show();
                //            }, 5);
                //            $('#add_retailer_button').prop('disabled', true);
                //            image_upload_loop(0);
                //        }else{
                //            if(val1==true && val2==true && val3==true && val4==true && val5==true && val6==true && val7==true && val8==true && val9==true){
                //                var all_check = true;
                //            }else{
                //                var all_check = false;
                //            }
                //            if(all_check==false){
                //                swal("Please enter all details!");
                //            }else{
                //                swal("Please Upload profile image");
                //            }  
                //        }
            }
            var image_id = ['retailer_image'];

            function image_upload_loop(key) {
                //        var valid   = $("#"+image_id[key]+"_valid").val();
                //        var checkkey = key+1;
                //        if(valid=="true"){
                //            if(checkkey>image_id.length){
                //                add_retailer_finish();
                //            }else{
                //                var fileUpload = document.getElementById(image_id[key]+"_upload");
                //                var file = fileUpload.files[0];
                //                s3_file_upload(file, key);
                //            }
                //        }else{
                //            if(valid!=undefined){
                //                $("#"+image_id[key]+"_valid").val(valid);
                //                key++;
                //                image_upload_loop(key);
                //            }else{
                //                add_retailer_finish();
                //            }
                //        }
            }

            function add_retailer_finish() {
                //        var shop_name     = $("#shop_name").val();
                //        var contact_person= $("#contact_person").val();
                //        var contact_number= $("#contact_number").val();
                //        var shop_type     = $("#shop_type").val();
                //        var license_number= $("#license_number").val();
                //        var shop_address  = $("#shop_address").val();
                //        var shop_city     = $("#shop_city").val();
                //        var shop_pincode  = $("#shop_pincode").val();
                //        var shop_coordinates= $("#shop_coordinates").val();
                //        var retailer_image  = $("#retailer_image_valid").val();
                //        var datas ={
                //            'shop_name':shop_name,
                //            'contact_person':contact_person,
                //            'contact_number':contact_number,
                //            'shop_type':shop_type,
                //            'license_number':license_number,
                //            'shop_address':shop_address,
                //            'shop_city':shop_city,
                //            'shop_pincode':shop_pincode,
                //            'shop_coordinates':shop_coordinates,
                //            'retailer_image':retailer_image,
                //            'dashboard_code':verfication_code
                //        }
                //        var json_data = JSON.stringify(datas);
                //        $.ajax({
                //            type: "POST",
                //            dataType: "json",
                //            url : api_path+"/admin/addRetailer.php",
                //            data: json_data,
                //        }).done(function(data) {
                //            $(".se-pre-con").hide();
                //            if(data.code=="201"){
                //                swal("Retailer added successfully!", {icon: "success",}).then((value) => {
                //                    location.reload();
                //                });
                //            }else{
                //                $("#form").modal('show');
                //                $('#add_employee_button').prop('disabled', false);
                //                swal(data.message);
                //            }
                //        });
            }

            function upload_csv_file() {
                //        var valid = $('#csv_file_valid').val();
                //        if(valid=="true"){
                //            $("#myModal").modal('hide');
                //            setTimeout(function () {  
                //                $(".se-pre-con").show();
                //            }, 5);
                //            $('#csv_upload_button').prop('disabled', true);
                //            var myFormData = new FormData();
                //            myFormData.append('file_upload', csv_file_upload.files[0]);
                //            $.ajax({
                //                dataType: "json",
                //                url: api_path+"/admin/uploadRetailerCsv.php",
                //                type: 'POST',
                //                async: false,
                //                processData: false, // important
                //                contentType: false, // important
                //                data: myFormData,
                //                success: function(data){
                //                    $(".se-pre-con").hide();
                //                    if(data.code==503){
                //                        $('#csv_upload_button').prop('disabled', false);
                //                        swal(data.message);
                //                    }else if(data.code==201){
                //                        swal("Csv data uploaded successfully!", {icon: "success",}).then((value) => {
                //                            location.reload();
                //                        });
                //                    }
                //                }
                //            });
                //        }else{
                //            swal("Please select a csv file!");
                //        }
            }

            function edit(key) {
                //        $("#edit_shop_token").val(table_main_data[key].shop_token);
                //        $("#edit_shop_name").val(table_main_data[key].shop_name);
                //        $("#edit_contact_person").val(table_main_data[key].contact_person);
                //        $("#edit_contact_number").val(table_main_data[key].shop_mobile_number);
                //        $("#edit_shop_type").val(table_main_data[key].shop_type_token);
                //        $("#edit_license_number").val(table_main_data[key].license_number);
                //        $("#edit_shop_address").val(table_main_data[key].address);
                //        $("#edit_shop_city").val(table_main_data[key].city);
                //        $("#edit_shop_pincode").val(table_main_data[key].pincode);
                //        $("#edit_shop_coordinates").val(table_main_data[key].coordinates);
                //        if(table_main_data[key].license_image==""){
                //            $("#edit_retailer_view_image_url").attr("src", "");
                //            $("#edit_retailer_view_image_url").css("display", "none");
                //        }else{
                //            $("#edit_retailer_view_image_url").attr("src", table_main_data[key].license_image);
                //            $("#edit_retailer_view_image_url").css("display", "block");
                //        }
                //        $("#edit_retailer_image_valid").val(table_main_data[key].license_image);
                //        $("#formUpdate").modal('show');
            }

            function update_retailer() {
                var shop_name = $("#edit_shop_name").val();
                var val1 = value_check('edit_shop_name', shop_name, 'text_box');
                var contact_person = $("#edit_contact_person").val();
                // var val2          = value_check('edit_contact_person',contact_person,'text_box');
                var contact_number = $("#edit_contact_number").val();
                var val3 = value_check('edit_contact_number', contact_number, 'text_box');
                var shop_type = $("#edit_shop_type").val();
                var val4 = value_check('edit_shop_type', shop_type, 'text_box');
                var license_number = $("#edit_license_number").val();
                // var val5          = value_check('edit_license_number',license_number,'text_box');
                var shop_address = $("#edit_shop_address").val();
                var val6 = value_check('edit_shop_address', shop_address, 'text_box');
                var shop_city = $("#edit_shop_city").val();
                var val7 = value_check('edit_shop_city', shop_city, 'text_box');
                var shop_pincode = $("#edit_shop_pincode").val();
                var val8 = value_check('edit_shop_pincode', shop_pincode, 'text_box');
                var shop_coordinates = $("#edit_shop_coordinates").val();
                // var val9          = value_check('edit_shop_coordinates',shop_coordinates,'text_box');
                var retailer_image = $("#edit_retailer_image_valid").val();
                // var val10         = value_check('',retailer_image,'image');
                if (val1 == true && val3 == true && val4 == true && val6 == true && val7 == true && val8 == true) {
                    $("#formUpdate").modal('hide');
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
                    if (val1 == true && val3 == true && val4 == true && val6 == true && val7 == true && val8 == true) {
                        var all_check = true;
                    } else {
                        var all_check = false;
                    }
                    if (all_check == false) {
                        swal("Please enter all details!");
                    } else {
                        swal("Please Upload profile image");
                    }
                }
            }
            var edit_image_id = ['edit_retailer_image'];

            function edit_image_upload_loop(key) {
                var valid = $("#" + edit_image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > edit_image_id.length) {
                        update_retailer_finish(cookie_token);
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
                        update_retailer_finish(cookie_token);
                    }
                }
            }

            function update_retailer_finish() {
                var shop_token = $("#edit_shop_token").val();
                var shop_name = $("#edit_shop_name").val();
                var old_name = $("#old_name").val();
                var contact_person = $("#edit_contact_person").val();
                var contact_number = $("#edit_contact_number").val();
                var old_number = $('#old_number').val();
                var shop_type = $("#edit_shop_type").val();
                var license_number = $("#edit_license_number").val();
                var old_licens = $("#old_licens").val();
                var shop_address = $("#edit_shop_address").val();
                var old_address = $("#old_address").val();
                var shop_city = $("#edit_shop_city").val();
                var old_city = $("#old_city").val();
                var shop_pincode = $("#edit_shop_pincode").val();
                var old_pincode = $("#old_pincode").val();
                var shop_coordinates = $("#edit_shop_coordinates").val();
                var retailer_image = $("#edit_retailer_image_valid").val();
                var datas = {
                    'shop_token': shop_token,
                    'shop_name': shop_name,
                    'old_name': old_name,
                    'contact_person': contact_person,
                    'contact_number': contact_number,
                    'old_number': old_number,
                    'shop_type': shop_type,
                    'license_number': license_number,
                    'old_licens': old_licens,
                    'shop_address': shop_address,
                    'old_address': old_address,
                    'shop_city': shop_city,
                    'old_city': old_city,
                    'shop_pincode': shop_pincode,
                    'old_pincode': old_pincode,
                    'shop_coordinates': shop_coordinates,
                    'retailer_image': retailer_image,
                    'dashboard_code': verfication_code,
                    'admin_token': cookie_token
                }
                var json_data = JSON.stringify(datas);
                console.log('admin', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/updateRetailer.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if (data.code == "201") {
                        swal("Retailer updated successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $("#formUpdate").modal('show');
                        $('#update_retailer_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }
            //deactive shop
            function inactivate() {
                var token = $("#update_status_token").val();
                var reason = $("#shop_reason").val();
                var distributor_token = $("#distributor_token").val();
                var shop_name = $("#single_shop_name").html();
                var mobile_number = $('#single_shop_contact').html();
                var licens_number = $("#single_shop_license").html();
                var address = $("#single_shop_address").html();
                var city = $("#single_shop_city").html();
                var pincode = $("#single_shop_pincode").html();
                //console.log(reason);
                if (reason != "") {
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
                                'shop_name': shop_name,
                                'mobile_number': mobile_number,
                                'licens_number': licens_number,
                                'address': address,
                                'city': city,
                                'pincode': pincode,
                                'admin_token': cookie_token,
                                'reason': reason,
                                'shop_show_status': 'Inactive',
                                'shop_mapping_status': '1',
                                'dashboard_code': verfication_code,
                                'distributor_token': distributor_token,
                                'type': 'shopStatusChange'
                            }
                            var json_data = JSON.stringify(datas);
                            console.log('inactivate', json_data);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: api_path + "/admin/retailerDetails.php",
                                data: json_data,
                            }).done(function(data) {
                                if (data.status_code == 400) {
                                    swal("Something happened!");
                                } else if (data.status_code == 200) {
                                    swal("Shop deactivated successfully!", {
                                        icon: "success",
                                    }).then((value) => {
                                        particularShopDetail(token);
                                        location.reload();
                                    });
                                }
                            });
                        }
                    });
                } else {
                    swal("Enter the Reason");
                }
            }

            //activate shop

            function activate() {
                var token = $("#update_status_token").val();
                var distributor_token = $("#distributor_token").val();
                var shop_name = $("#single_shop_name").html();
                var mobile_number = $('#single_shop_contact').html();
                var licens_number = $("#single_shop_license").html();
                var address = $("#single_shop_address").html();
                var city = $("#single_shop_city").html();
                var pincode = $("#single_shop_pincode").html();
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
                            'shop_name': shop_name,
                            'mobile_number': mobile_number,
                            'licens_number': licens_number,
                            'address': address,
                            'city': city,
                            'pincode': pincode,
                            'admin_token': cookie_token,
                            'shop_show_status': 'Active',
                            'dashboard_code': verfication_code,
                            'distributor_token': distributor_token,
                            'shop_mapping_status': '0',
                            'type': 'shopStatusChange'
                        }
                        var json_data = JSON.stringify(datas);
                        console.log('activate', json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/retailerDetails.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.status_code == 400) {
                                swal("Something happened!");
                            } else if (data.status_code == 200) {
                                swal("Shop activated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    particularShopDetail(token);
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }

            //upload CSV
            //    function show_RetailerCSV(){
            //        var csv_data = [];
            //        var rows = document.getElementsByTagName('tr');
            //        for (var i = 0; i < rows.length; i++) {
            //            var cols = rows[i].querySelectorAll('td,th');
            //            var csvrow = [];
            //            for (var j = 0; j < cols.length; j++) {
            //                csvrow.push(cols[j].innerText.replace("/<a.*>.*?<\/a>/ig,''"));
            //               
            //            } 
            //            csv_data.push(csvrow.join(","));
            //        }
            //        csv_data = csv_data.join('\n');
            //        downloadCSVFile(csv_data);
            //
            //        }
            //
            //        function downloadCSVFile(csv_data) {
            //        CSVFile = new Blob([csv_data], {
            //            type: "text/csv"
            //        });
            //        var temp_link = document.createElement('a');
            //
            //        temp_link.download = "RetailerList.csv";
            //        var url = window.URL.createObjectURL(CSVFile);
            //        temp_link.href = url;
            //        temp_link.style.display = "none";
            //        document.body.appendChild(temp_link);
            //        temp_link.click();
            //        document.body.removeChild(temp_link);
            //}
            //upload PDF
            //function show_RetailerPDF(){
            //                var data={
            //                    'invoice_name': "",
            //                }
            //                $.ajax({
            //                            type: "POST",
            //                            dataType: "json",
            //                            url : "../TCPDF-main/examples/retailerListPdf.php?state_id="+admin_state_id+"&region_token="+region_change+"&dist_token="+dist_change,
            //                            data: data,
            //                            }).done(function(data) {
            //                                if(data.status_code==200){
            //                                $(".se-pre-con").hide();
            //                                window.open('../invoice_pdf/'+data.data, '_blank');
            //                                }else{
            //                                    swal("Something Happened!", {icon: "failed"});
            //                                }
            //                            });
            //                        }
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>