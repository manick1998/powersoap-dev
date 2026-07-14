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
        <link rel="stylesheet" href="css/bootstrap-select.min.css<?php echo $js_cache_string; ?>">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/employee.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
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

        .main-contents {
            width: calc(100% - 300px);
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

        .custom-table tbody tr td button {
            padding: 6px 18px;
            color: #fff;
            background: #00b9f6;
            border-radius: 4px;
            border: none;
        }

        .reupload {
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

        .custom-nav {
            border-bottom: 1px solid #D9D9D9;
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            white-space: nowrap;
            /* overflow: auto; */
        }

        .scrollbar {
            overflow-x: scroll;
        }

        #style-1::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            border-radius: 0;
            background-color: #F5F5F5;
        }

        #style-1::-webkit-scrollbar {
            height: 10px;
            background-color: #F5F5F5;
            display: block !important;
        }

        #style-1::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
            background-color: #c9c9c9;
        }


        .custom-nav__item {
            padding: 8px 6px;
            border-bottom: 1px solid transparent;
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
            text-transform: capitalize;
        }

        .custom-nav__item a.active {
            background-color: #f3f7fa;
            border-bottom: 2px solid #04bcf4;
        }

        .dt-buttons.btn-group {
            margin-left: 2rem;
        }

        .dataTables_filter label {
            top: 20px;
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

        @media only screen and (max-width:1200px) {
            .main-contents {
                width: calc(100% - 60px);
            }
        }

        @media screen and (max-width: 1555px) {
            #table_data {
                overflow-x: scroll;
                display: block;
            }
        }
    </style>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar3"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4" style="padding: 24px 16px;margin-bottom:16px;display: none;">
                <!-- <div class="scrollbar" id="style-1">
                <ul class="custom-nav nav nav-pills statewise force-overflow" id="stateList">
                </ul>

            </div> -->
            </section>
            <!-- tab method -->
            <div class="tab-content clearfix" id="employee">

                <div class="tab-pane active" id="state1">
                    <section class="bg-white brad-4 full-height" style="">
                        <div class="product_header_container">
                            <div class="header-details ">
                                <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span></h1>
                                <!-- <h1 class="header_main">Distributor List <span class="total_emp">Total Distributor -<span id="total_employee_count"></span></span></h1> -->
                                <!-- <h1 class="header_main">Distributor List <span class="total_emp">Total Distributor -<span id="total_employee_count"></span></span></h1> -->
                                <h1 class="header_main">Distributor List 
                                    <span class="total_emp">Total Distributor - <span id="total_employee_count"></span> 
                                    | <b style="color: #00b9f6;">Total Active - <span id="total_active_employee_count"></span></b>
                                    </span>
                                </h1>
                           
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button onclick="show_employee()" class="empshow nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><img class="icon_add" src="assets/icons/add_employee.svg" alt=""></span>Add Distributor</button>
                            </li>
                            <li class="nav-item " role="presentation">
                                <div class="form-group">
                                    <select name="" id="selectState" class="selectClass form-control">
                                    </select>
                                </div>
                            </li>
                            <li class="nav-item " role="presentation">
                                <div class="form-group">
                                    <select name="" id="selectRegion" class="selectClass form-control">
                                    </select>
                                </div>
                            </li>
                            <!-- <li>
                                <div class="form-group">
                                    <button id="stateGoBtn" type="button" onclick="gobutton();" class="primary-btn">Go</button>
                                </div>
                            </li> -->
                            

                           <li>
                            <div class="form-group">
                                <button id="stateGoBtn" type="button" onclick="gobutton();" class="primary-btn">Go</button>
                            </div>
                        </li>

                        <!-- <li style="margin-left: 20px; position: relative; width: 50px; height: 50px;">
                            <canvas id="distributorChart"></canvas>
                            <div id="chartCenterText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 13px; font-weight: bold; color: #000;">0</div>
                        </li> -->

                        <li style="margin-left: 25px; display: flex; align-items: center;">
                                <div style="position: relative; width: 90px; height: 90px;">
                                    <canvas id="distributorChart"></canvas>
                                    <div id="chartCenterText" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 18px; font-weight: bold; color: #000; line-height: 1;">0</div>
                                </div>
                                <!-- <div style="margin-left: 15px; font-size: 14px; line-height: 1.5;">
                                    <span style="color:#00b9f6; font-weight:bold;">■ Active : <span id="text_active_count">0</span></span><br>
                                    <span style="color:#ff9d87; font-weight:bold;">■ Inactive : <span id="text_inactive_count">0</span></span>
                                </div> -->
                            </li>


                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Distributor Code</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email Address</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Area</th>
                                            <th>Joining Date</th>
                                            <th>Full address</th>
                                            <th>Status</th>
                                            <th>Division</th>
                                            <th>Action</th>
                                             <th>Status</th>
                                            <th>Credentials</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="tab-pane" id="state2">
                    <section class="bg-white brad-4 full-height">
                        <div class="product_header_container">
                            <div class="header-details ">
                                <!-- <h1 class="header_main">Distributor List <span class="total_emp">Total Distributor -<span id="total_employee_count"></span></span></h1> -->
                                <h1 class="header_main">Distributor List 
                                    <span class="total_emp">Total Distributor - <span id="total_employee_count"></span> 
                                    | <b style="color: #00b9f6;">Total Active - <span id="total_active_employee_count"></span></b>
                                    </span>
                                </h1>
                            
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button onclick="show_employee()" class="empshow nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><img class="icon_add" src="assets/icons/add_employee.svg" alt=""></span>Add Distributor</button>
                            </li>
                            <!--
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeeCSV()" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                            </li>
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeePDF()"  class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                            </li>
-->
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Distributor Code</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email Address</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Area</th>
                                            <th>Joining Date</th>
                                            <th>Action</th>
                                            <th>Credentials</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="tab-pane" id="state3">
                    <section class="bg-white brad-4 full-height">
                        <div class="product_header_container">
                            <div class="header-details ">
                                <!-- <h1 class="header_main">Distributor List <span class="total_emp">Total Distributor -<span id="total_employee_count"></span></span></h1> -->
                                    <h1 class="header_main">Distributor List 
                                    <span class="total_emp">Total Distributor - <span id="total_employee_count"></span> 
                                    | <b style="color: #00b9f6;">Total Active - <span id="total_active_employee_count"></span></b>
                                    </span>
                                </h1>
                            
                            
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button onclick="show_employee()" class="empshow nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><img class="icon_add" src="assets/icons/add_employee.svg" alt=""></span>Add Distributor</button>
                            </li>
                            <!--
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeeCSV()" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                            </li>
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeePDF()"  class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                            </li>
-->
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Distributor Code</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email Address</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Area</th>
                                            <th>Joining Date</th>
                                            <th>Action</th>
                                            <th>Credentials</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="tab-pane" id="state4">
                    <section class="bg-white brad-4 full-height">
                        <div class="product_header_container">
                            <div class="header-details ">
                                <!-- <h1 class="header_main">Distributor List <span class="total_emp">Total Distributor -<span id="total_employee_count"></span></span></h1> -->
                                    <h1 class="header_main">Distributor List 
                                    <span class="total_emp">Total Distributor - <span id="total_employee_count"></span> 
                                    | <b style="color: #00b9f6;">Total Active - <span id="total_active_employee_count"></span></b>
                                    </span>
                                </h1>
                            
                            </div>
                        </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button onclick="show_employee()" class="empshow nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><img class="icon_add" src="assets/icons/add_employee.svg" alt=""></span>Add Distributor</button>
                            </li>
                            <!--
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeeCSV()" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                            </li>
                            <li class="nav-item " role="presentation">
                                <button onclick="show_EmployeePDF()"  class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                            </li>
-->
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <table class="custom-table" id="table_data">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th></th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email Address</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Area</th>
                                            <th>Joining Date</th>
                                            <th>Action</th>
                                            <th>Credentials</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_body_id"></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>


            <!-- Add/view/edit section for common to all  -->

            <section class="bg-white brad-4 full-height" id="employee_add" style="display: none;">
                <div class="header_container">
                    <div class="header-section">
                        <div class="inventory-top">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_add_employee()" alt=""> Add New Distributor</span></h1>
                        </div>
                    </div>
                    <div class="add_new_top">
                        <div class="col-md-2">
                            <label class="upload_label" for="employee_image_upload">
                                <div class="upload_file">
                                    <img class="uploadimg" id="employee_view_image_url" alt="" src="assets/upload.png">
                                    <input id="employee_image_valid" type="hidden">
                                    <input id="employee_image_upload" onchange="file_upload('employee_image','employee_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, image/png" style="display:none;">
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <div class="form-control add_employee_name_box">
                                    <p class="add_employee_name">Distributor Name <span id="mandatory_icon">*</span></p>
                                    <input class="input-field" id="add_employee_name" placeholder="Please Enter Name">
                                </div>
                                <div class="form-control add_employee_mobilenumber_box">
                                    <p class="add_employee_mobilenumber">Mobile Number <span id="mandatory_icon">*</span>
                                    </p>
                                    <input class="input-field numberonly" id="add_employee_mobilenumber" placeholder="Please Enter Mobile Number" maxlength="10">
                                </div>
                                <div class="form-control add_employee_joindate_box">
                                    <p class="add_employee_joindate">Joining Date</p>
                                    <input class="input-field box_form no_border" id="add_employee_joindate" placeholder="Joining Date" maxlength="10" autocomplete="off">
                                </div>
                                <!-- <div class="form-control add_employee_region_box">
                                    <p class="add_employee_region">Region <span id="mandatory_icon">*</span></p>
                                    <select class="input-field" id="add_employee_region">
                                    </select>
                                </div> -->
                                <div class="form-control add_employee_state_box">
                                    <p class="add_employee_state">State <span id="mandatory_icon">*</span></p>
                                </div>
                            </form>
                        </div>
                        <form class="formsend" id="formsend" action="employees_detail.php" method="post"></form>

                        <div class="col-md-4">
                            <form class="form">
                                <div class="form-control add_employee_department_box">
                                    <p class="add_employee_department">Department</p>
                                    <select class="input-field" id="add_employee_department">
                                        <option value="18028120">Distributor</option>
                                    </select>
                                </div>
                                <div class="form-control add_employee_email_id_box">
                                    <p class="add_employee_email_id">Email Address <span id="mandatory_icon">*</span></p>
                                    <input class="input-field" id="add_employee_email_id" placeholder="Enter Email Address">
                                </div>
                                <div class="form-control add_employee_license_number_box">
                                    <p class="add_employee_license_number">Distributor GST number <span id="mandatory_icon">*</span></p>
                                    <input class="input-field" id="add_employee_license_number" placeholder="Please Enter GST Number" maxlength="16">
                                </div>
                                <!-- <div class="form-control add_employee_state_box">
                                    <p class="add_employee_state">State <span id="mandatory_icon">*</span></p>
                                </div> -->
                                <div class="form-control add_employee_region_box">
                                    <p class="add_employee_region">Region <span id="mandatory_icon">*</span></p>
                                    <select class="input-field" id="add_employee_region">
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <form class="forms">
                            <select id="add_employee_division" class="form-control" multiple="multiple"></select>
                        </form>
                    </div>
                </div>
                <div class="bottom_container">
                    <h2 class="address">Address <span id="mandatory_icon">*</span></h2>
                    <div class="add_new_top">
                        <div class="col-md-4 padz">
                            <form class="forms">
                                <div class="form-control add_employee_address_box">
                                    <input class="input-field" id="add_employee_address" placeholder="Address">
                                </div>
                                <div class="form-control add_employee_area_box">
                                    <!-- <p class="add_employee_area">Area <span id="mandatory_icon">*</span></p> -->
                                    <select class="input-field" id="add_employee_area" placeholder="Area">
                                        <!-- <option>Madurai</option>
                                    <option>Thrichy</option>
                                    <option>Chennai</option>
                                    <option>Theni</option> -->
                                    </select>
                                </div>

                            </form>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <!--
                    <div class="form-control add_employee_street_box">
                    <input class="input-field" id="add_employee_street" placeholder="Street">
                    </div>
                    -->
                                <div class="form-control add_employee_city_box">
                                    <input class="input-field" id="add_employee_city" placeholder="City">
                                </div>
                                <div class="form-control add_employee_pincode_box">
                                    <input class="input-field numberonly" id="add_employee_pincode" maxlength="6" placeholder="Pincode">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <span class="close_btn" id="address_proof1_url_close" style="display:none;" onclick="file_removes('address_proof1','address_proof1_url','assets/icons/address_proof_upload.svg')">X</span>
                            <label class="upload_label1" for="address_proof1_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" id="address_proof1_url_image" alt="" src="assets/icons/address_proof_upload.svg">
                                    <iframe class="uploadimg1" id="address_proof1_url_pdf" frameBorder="0" style="display:none;"></iframe>
                                    <!--                                    <span class="close_btn" id="address_proof1_url_close" style="display:none;">X</span>-->
                                    <input id="address_proof1_valid" type="hidden">
                                    <input id="address_proof1_upload" onchange="file_upload_image_or_pdf('address_proof1','address_proof1_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                </div>
                            </label>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="add_disp">
                        <div class="text_data">
                            <h2>Other attachment :</h2>
                            <div class="add_new_top">
                                <div class="data_view_image">
                                    <span class="close_btn" id="address_proof2_url_close" style="display:none;" onclick="file_removes('address_proof2','address_proof2_url','assets/icons/proof1.png')">X</span>
                                    <label class="upload_label2" for="address_proof2_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="address_proof2_url_image" src="assets/icons/proof1.png">
                                            <iframe class="uploadimg1" id="address_proof2_url_pdf" frameBorder="0" style="display:none;"></iframe>
                                            <input id="address_proof2_valid" type="hidden">
                                            <input id="address_proof2_upload" onchange="file_upload_image_or_pdf('address_proof2','address_proof2_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <span class="close_btn" id="address_proof3_url_close" style="display:none;" onclick="file_removes('address_proof3','address_proof3_url','assets/icons/proof2.png')">X</span>
                                    <label class="upload_label2" for="address_proof3_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" id="address_proof3_url_image" alt="" src="assets/icons/proof2.png">
                                            <iframe class="uploadimg1" id="address_proof3_url_pdf" frameBorder="0" style="display:none;"></iframe>
                                            <input id="address_proof3_valid" type="hidden">
                                            <input id="address_proof3_upload" onchange="file_upload_image_or_pdf('address_proof3','address_proof3_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <span class="close_btn" id="address_proof4_url_close" style="display:none;" onclick="file_removes('address_proof4','address_proof4_url','assets/icons/proof3.png')">X</span>
                                    <label class="upload_label2" for="address_proof4_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="address_proof4_url_image" src="assets/icons/proof3.png">
                                            <iframe class="uploadimg1" id="address_proof4_url_pdf" frameBorder="0" style="display:none;"></iframe>
                                            <input id="address_proof4_valid" type="hidden">
                                            <input id="address_proof4_upload" onchange="file_upload_image_or_pdf('address_proof4','address_proof4_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <span class="close_btn" id="address_proof5_url_close" style="display:none;" onclick="file_removes('address_proof5','address_proof5_url','assets/icons/proof4.png')">X</span>
                                    <label class="upload_label2" for="address_proof5_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="address_proof5_url_image" src="assets/icons/proof4.png">
                                            <iframe class="uploadimg1" id="address_proof5_url_pdf" frameBorder="0" style="display:none;"></iframe>
                                            <input id="address_proof5_valid" type="hidden">
                                            <input id="address_proof5_upload" onchange="file_upload_image_or_pdf('address_proof5','address_proof5_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn_product" onclick="add_employee()" id="add_employee_button">Add New
                            Distributor</button>
                    </div>
                </div>
            </section>

            <section class="bg-white brad-4 full-height" id="employee_edit" style="display: none;">
                <div class="header_container">
                    <div class="header-section">
                        <div class="inventory-top">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_edit_employee()" alt=""> Edit Distributor</span></h1>
                        </div>
                    </div>
                    <div class="add_new_top">
                        <div class="col-md-2">
                            <label class="upload_label" for="edit_employee_image_upload">
                                <div class="upload_file">
                                    <img class="uploadimg" id="edit_employee_view_image_url" alt="" src="assets/upload.png">
                                    <input id="edit_employee_image_valid" type="hidden">
                                    <input id="edit_employee_image_upload" onchange="file_upload('edit_employee_image','edit_employee_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg,image/png" style="display:none;">
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <input type="hidden" id="edit_employee_token">
                                <div class="form-control edit_employee_name_box">
                                    <p class="edit_employee_name">Distributor Name</p>
                                    <input class="input-field" id="edit_employee_name" placeholder="Please Enter Name">
                                    <input type="hidden" id="old_name" value="">
                                </div>
                                <div class="form-control edit_employee_mobilenumber_box">
                                    <p class="edit_employee_mobilenumber">Mobile Number</p>
                                    <input class="input-field numberonly" id="edit_employee_mobilenumber" placeholder="Please Enter Mobilenumber" maxlength="10">
                                    <input type="hidden" id="old_mobilenumber" value="">
                                </div>
                                <div class="form-control edit_employee_joindate_box">
                                    <p class="edit_employee_joindate">Joining Date</p>
                                    <input class="input-field box_form no_border" id="edit_employee_joindate" placeholder="Joining Date" maxlength="10" autocomplete="off">
                                </div>
                                <div class="form-control edit_employee_state_box">
                                    <p class="edit_employee_state">State <span id="mandatory_icon">*</span></p>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form class="form">
                                <div class="form-control edit_employee_department_box">
                                    <p class="edit_employee_department">Department</p>
                                    <select class="input-field" id="edit_employee_department">
                                        <option value="18028120">Distributor</option>
                                    </select>
                                </div>
                                <div class="form-control edit_employee_email_id_box">
                                    <p class="edit_employee_email_id">Email Address</p>
                                    <input class="input-field" id="edit_employee_email_id" placeholder="Enter Email Address">
                                    <input type="hidden" id="old_email" value="">
                                </div>
                                <div class="form-control edit_employee_license_number_box">
                                    <p class="edit_employee_license_number">Distributor GST Number</p>
                                    <input class="input-field" id="edit_employee_license_number" placeholder="Please Enter GST Number" maxlength="16">
                                    <input type="hidden" id="old_licens" value="">
                                </div>
                                <div class="form-control edit_employee_region_box">
                                    <p class="edit_employee_region">Region</p>
                                    <select class="input-field" id="edit_employee_region">
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <form class="forms">
                            <select id="edit_employee_division" multiple="multiple"></select>
                        </form>
                        <input type="hidden" id="old_division" value="">
                    </div>
                </div>
                <div class="bottom_container">
                    <h2 class="address">Address</h2>
                    <div class="add_new_top">
                        <div class="col-md-4 padz">
                            <form class="forms">
                                <div class="form-control edit_employee_address_box">
                                    <input class="input-field" id="edit_employee_address" placeholder="Address">
                                </div>

                                <div class="form-control edit_employee_area_box">
                                    <select class="input-field" id="edit_employee_area" placeholder="Area">
                                        <!-- <option>Madurai</option>
                                    <option>Thrichy</option>
                                    <option>Chennai</option>
                                    <option>Theni</option> -->
                                    </select>
                                </div>


                            </form>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <!--
                        <div class="form-control edit_employee_street_box">
                        <input class="input-field" id="edit_employee_street" placeholder="Street">
                        </div>
                        -->
                                <div class="form-control edit_employee_city_box">
                                    <input class="input-field" id="edit_employee_city" placeholder="City">
                                </div>
                                <div class="form-control edit_employee_pincode_box">
                                    <input class="input-field numberonly" id="edit_employee_pincode" maxlength="6" placeholder="Pincode">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-2">
                            <span class="close_btn" id="edit1_address_proof1_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
                            <label class="upload_label1" for="edit_address_proof1_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" id="edit_address_proof1_url_image" alt="" src="assets/icons/address_proof_upload.svg">
                                    <iframe class="uploadimg1" id="edit_address_proof1_url_pdf" frameborder="0" style="display:none;"></iframe>
                                    <!--                                    <span class="close_btn" id="edit_address_proof1_url_close" style="display:none;">X</span>-->
                                    <input id="edit_address_proof1_valid" type="hidden">
                                    <input id="edit_address_proof1_upload" onchange="file_upload_image_or_pdf('edit_address_proof1','edit_address_proof1_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                </div>
                            </label>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                    <div class="add_disp">
                        <div class="text_data">
                            <h2>Other attachment :</h2>
                            <div class="add_new_top">
                                <div class="data_view_image">
                                    <!-- <span>haia</span> -->
                                    <span class="close_btn" id="edit2_address_proof2_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof2','edit_address_proof2_url','assets/icons/proof2.png')">X</span>
                                    <label class="upload_label2" for="edit_address_proof2_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="edit_address_proof2_url_image" src="assets/icons/proof1.png">
                                            <iframe class="uploadimg1" id="edit_address_proof2_url_pdf" frameborder="0" style="display:none;"></iframe>
                                            <input id="edit_address_proof2_valid_id" type="hidden">
                                            <input id="edit_address_proof2_valid" type="hidden">
                                            <input id="edit_address_proof2_upload" onchange="file_upload_image_or_pdf('edit_address_proof2','edit_address_proof2_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <span class="close_btn" id="edit3_address_proof3_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof3','edit_address_proof3_url','assets/icons/proof3.png')">X</span>
                                    <label class="upload_label2" for="edit_address_proof3_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" id="edit_address_proof3_url_image" alt="" src="assets/icons/proof2.png">
                                            <iframe class="uploadimg1" id="edit_address_proof3_url_pdf" frameborder="0" style="display:none;"></iframe>
                                            <input id="edit_address_proof3_valid_id" type="hidden">
                                            <input id="edit_address_proof3_valid" type="hidden">
                                            <input id="edit_address_proof3_upload" onchange="file_upload_image_or_pdf('edit_address_proof3','edit_address_proof3_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <span class="close_btn" id="edit4_address_proof4_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof4','edit_address_proof4_url','assets/icons/proof4.png')">X</span>
                                    <label class="upload_label2" for="edit_address_proof4_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="edit_address_proof4_url_image" src="assets/icons/proof3.png">
                                            <iframe class="uploadimg1" id="edit_address_proof4_url_pdf" frameborder="0" style="display:none;"></iframe>
                                            <input id="edit_address_proof4_valid_id" type="hidden">
                                            <input id="edit_address_proof4_valid" type="hidden">
                                            <input id="edit_address_proof4_upload" onchange="file_upload_image_or_pdf('edit_address_proof4','edit_address_proof4_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                                <div class="data_view_image">
                                    <!--  -->
                                    <span class="close_btn" id="edit5_address_proof5_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof5','edit_address_proof5_url','assets/icons/proof5.png')">X</span>
                                    <label class="upload_label2" for="edit_address_proof5_upload">
                                        <div class="upload_file1">
                                            <img class="uploadimg1" alt="" id="edit_address_proof5_url_image" src="assets/icons/proof4.png">
                                            <iframe class="uploadimg1" id="edit_address_proof5_url_pdf" frameborder="0" style="display:none;"></iframe>
                                            <input id="edit_address_proof5_valid_id" type="hidden">
                                            <input id="edit_address_proof5_valid" type="hidden">
                                            <input id="edit_address_proof5_upload" onchange="file_upload_image_or_pdf('edit_address_proof5','edit_address_proof5_url','assets/icons/address_proof_upload.svg')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg, application/pdf" style="display:none;">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="btn_product" onclick="update_employee()" id="update_employee_button">Update
                            Details</button>
                        <button class="btn_product" onclick="deactivate_from_edit()" id="deactivate_edit_button" style="background:#e53e3e;border-color:#e53e3e;margin-left:10px;">Deactivate Distributor</button>
                    </div>
                </div>
            </section>

            <section class="bg-white brad-4 full-height twoback" id="employee_view" style="display: none;">
                <div class="header_container mrgzro">
                    <div class="header-section sep_word">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_employee()" alt=""></span></h1>
                        <button class="btn_product float_right" onclick="retailer_view()" id="">Retailer Details</button>
                        <!-- <button class="btn_product float_right" onclick="stocks()" id="">Retailer Details</button> -->
                        <input id="update_status_token" type="hidden">
                        <div class="de_activate"></div>


                    </div>
                    <div class="add_new_top bot_line">
                        <div class="col-md-2">
                            <div class="upload_files">
                                <img class="uploadimgs" id="single_employee_view_image" alt="" src="">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <h2 class="name_box" id="single_employee_name"></h2>
                            <div class="row">
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Department : <span id="single_employee_department"></span></p>
                                        <p>Joining Date : <span id="single_employee_join_date"></span></p>
                                        <p>State : <span id="single_employee_state"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Distributor Code : <span id="single_employee_code"></span></p>
                                        <p>Mobile Number : <span id="single_employee_number"></span></p>
                                        <p>GST Number: <span id="single_employee_licenseNumber"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Email Address : <span id="single_employee_email"></span></p>
                                        <p>Region : <span id="single_employee_region"></span></p>
                                        <p>Area : <span id="single_employee_area"></span></p>
                                    </div>
                                </div>
                                <div class="col-md-4 padz">
                                    <div class="codelevel">
                                        <p>Email Address : <span id="single_employee_email"></span></p>
                                        <p>Region : <span id="single_employee_region"></span></p>
                                    </div>
                                </div>
                                <div>
                                    <p>Division : </p>
                                    <ol id="single_employee_division_name" style="list-style-position: inside;"></ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="address_field">
                        <div class="col-md-8">
                            <div class="address_note">
                                <h2>Address :</h2>
                                <p id="single_employee_address"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <img class="pancard" style="max-width: 100px;" id="single_employee_address_proof_img" alt="" src="">
                            <iframe class="uploadimg1" id="single_employee_address_proof_pdf" frameborder="0"></iframe>
                        </div>
                    </div>
                    <div class="attach">
                        <div class="col-md-12">
                            <h2>Other Attachments :</h2>
                            <div class="attach_img" id="single_other_attachement">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
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
                            <label class="upload_filed" for="file_csv">
                                <input type="file" id="file_csv" accept="application/pdf" hidden>
                                <img alt="" src="assets/csvfile.png" class="csvfile">
                                <h2>Upload Files</h2>
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                        <button type="button" class="savebtn">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal" id="samples">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Sampe CSV File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="row">
                            <label class="upload_filed" for="file_csv">
                                <input type="file" id="file_csv" accept="application/pdf" hidden>
                                <img alt="" src="assets/csvfile.png" class="csvfile">
                                <h2>Upload Files</h2>
                            </label>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert"></script> -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datepicker-->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
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
        <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
        <script src="js/select2.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="js/chart.js<?php echo $js_cache_string; ?>"></script> -->
         <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->

         <script src="https://cdn.jsdelivr.net/npm/chart.js<?php echo $js_cache_string; ?>"></script>
        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script>
            // var pdfjsLib = window['pdfjs-dist/build/pdf'];
            // pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var admin_state_id = "<?php echo $cookie_admin_state; ?>";
            var region_token = "";
        </script>
        <script>
            //            $('#add_employee_joindate').datepicker({
            //                autoclose: true,
            //                todayHighlight: true,
            //                minDate: 'today',
            //                maxDate: '+2Y'
            //            });
            $('#add_employee_joindate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: new Date(),
                changeYear: true,
                yearRange: '1970:2060',
                defaultDate: 'today'
            });
            $('#edit_employee_joindate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: new Date(),
                changeYear: true,
                yearRange: '1970:2060',
                defaultDate: 'today'
            });
            //            $('#add_employee_dob,#edit_employee_dob').datepicker({
            //                autoclose: true,
            //                todayHighlight: true,
            //                maxDate: new Date(),
            //                changeYear: true,
            //                yearRange: '1970:2060',
            //                defaultDate: new Date(1990, 1 - 1, 1)
            //            });

            function show_employee() {
                $('#employee_add').show();
                $('#employee').hide();
            }

            function back_view_employee() {
                $('#employee').show();
                $('#employee_view').hide();
            }

            function back_add_employee() {
                $('#employee').show();
                $('#employee_add').hide();
            }

            function back_edit_employee() {
                $('#employee').show();
                $('#employee_edit').hide();
            }

            function back_view_order() {
                location.reload();
            }
        </script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";

            $(document).ready(function() {
                data_fetch();

                //get states
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas) {
                    let data = datas;
                    let html_text = '<option value="">Select State</option>';
                    for (let key in data) {
                        html_text +=
                            `<option value="${data[key].state_token}">${data[key].state_name}</option>`;
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
                        html_text +=
                            `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
                    }
                    $('#selectRegion').html(html_text);
                });
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
                            html_text +=
                                `<option value="${data[key].region_token}">${data[key].region_name}</option>`;
                        }
                        $('#selectRegion').html(html_text);
                    });
                });
            });


            $(document).on('click', '#edit_address_proof1_url_image', function() {
                var image = $(this).attr("src");
                if (image == image) {
                    $("#edit1_address_proof1_url_close").show();
                }
                console.log('image', image);
            });
            $(document).on('click', '#edit1_address_proof1_url_close', function() {
                $(this).hide();
            });
            //2
            $(document).on('click', '#edit_address_proof2_url_image', function() {
                var image = $(this).attr("src");
                if (image == image) {
                    $("#edit2_address_proof2_url_close").show();
                }
                console.log('image', image);
            });
            $(document).on('click', '#edit2_address_proof2_url_close', function() {
                $(this).hide();
            });
            //3
            $(document).on('click', '#edit_address_proof3_url_image', function() {
                var image = $(this).attr("src");
                if (image == image) {
                    $("#edit3_address_proof3_url_close").show();
                }
                console.log('image', image);
            });
            $(document).on('click', '#edit3_address_proof3_url_close', function() {
                $(this).hide();
            });
            //4
            $(document).on('click', '#edit_address_proof4_url_image', function() {
                var image = $(this).attr("src");
                if (image == image) {
                    $("#edit4_address_proof4_url_close").show();
                }
                console.log('image', image);
            });
            $(document).on('click', '#edit4_address_proof4_url_close', function() {
                $(this).hide();
            });
            //5
            $(document).on('click', '#edit_address_proof5_url_image', function() {
                var image = $(this).attr("src");
                if (image == image) {
                    $("#edit5_address_proof5_url_close").show();
                }
                console.log('image', image);
            });
            $(document).on('click', '#edit5_address_proof5_url_close', function() {
                $(this).hide();
            });


            // // Chart-kaga oru global variable
            // var distChart;

            $(document).ready(function() {

            update_chart_data(); 
                var datas = {
                    dashboard_code: verfication_code,
                    state_id: admin_state_id,
                    type: "count"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/employeeDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var count = data.data;
                    $("#total_employee_count").html(count);
                    $("#total_active_employee_count").html(data.active_count); 


                    var count = parseInt(data.data) || 0;
                    var active_count = parseInt(data.active_count) || 0;
                    var inactive_count = count - active_count; // Inactive count calculation

                    $("#total_employee_count").html(count);
                    $("#total_active_employee_count").html(active_count); 
                    
                    // // --- PUTHU PIE CHART LOGIC START ---
                    // $("#chartCenterText").html(count); // Naduvula text
                    
                    // var ctxElement = document.getElementById('distributorChart');
                    // if(ctxElement) {
                    //     var ctx = ctxElement.getContext('2d');
                    //     if (distChart) {
                    //         distChart.data.datasets[0].data = [active_count, inactive_count];
                    //         distChart.update();
                    //     } else {
                    //         distChart = new Chart(ctx, {
                    //             type: 'doughnut',
                    //             data: {
                    //                 labels: ['Active', 'Inactive'],
                    //                 datasets: [{
                    //                     data: [active_count, inactive_count],
                    //                     backgroundColor: ['#00b9f6', '#ff9d87'], // Blue for Active, Red for Inactive
                    //                     borderWidth: 0
                    //                 }]
                    //             },
                    //             options: {
                    //                 responsive: true,
                    //                 maintainAspectRatio: false,
                    //                 cutout: '75%', // Donut shape otai
                    //                 plugins: {
                    //                     legend: { display: false },
                    //                     tooltip: { enabled: true }
                    //                 }
                    //             }
                    //         });
                    //     }
                    // }
                    // // --- PUTHU PIE CHART LOGIC END ---


                });
                var datas = {
                    dashboard_code: verfication_code,
                    type: "all"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    var data = datas.data;
                    var html_text = '';
                    html_text += '<option class="all" value="all">Select All Division</option>';
                    for (var key in data) {
                        html_text += '<option value="' + data[key].division_token + '">' + data[key]
                            .division_name + '</option>';

                    }
                    $("#add_employee_division").html(html_text);

                    $('#add_employee_division').select2({
                        closeOnSelect: false,
                        placeholder: "Please select a divisions"
                    });
                    $("#edit_employee_division").html(html_text);
                    $('#edit_employee_division').select2({
                        closeOnSelect: false,
                        placeholder: "Please select a divisions"
                    });
                });




                //getRegion and getState depend upon admin
                var datas = {
                    dashboard_code: verfication_code,
                    state_id: admin_state_id,
                    type: "All"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/addRegion.php",
                    data: json_data,
                }).done(function(datas) {
                    var data = datas.data;
                    var html_text1 = '';
                    html_text1 += '<option  value="">Select Region</option>';
                    for (var key in data) {
                        html_text1 += '<option id="user_region" value="' + data[key].region_token + '">' + data[
                            key].region_name + '</option>';
                    }
                    $("#add_employee_region").append(html_text1);
                    $("#edit_employee_region").append(html_text1);





                    //states
                    var stateList = datas.data_state;
                    console.log('stateList', stateList);
                    var state_html = '';
                    if (stateList.length == 1) {
                        state_html += '<input class="input-field" id="state" value="' + stateList[0]
                            .state_name + '" readonly>';
                        state_html +=
                            '<input type="hidden" class="input-field" id="add_employee_state" value="' +
                            stateList[0].state_token + '">';
                    } else {
                        state_html += '<select class="input-field" id="add_employee_state">';
                        state_html += '<option value="">Select state</option>';
                        for (var key in stateList) {
                            state_html += '<option value="' + stateList[key].state_token + '">' + stateList[key]
                                .state_name + '</option>';
                        }
                        state_html += '</select>';
                    }
                    $(".add_employee_state_box").append(state_html);
                    var edit_state_html = '';
                    if (stateList.length == 1) {
                        edit_state_html += '<input class="input-field" id="edit_state" value="' + stateList[0]
                            .state_name + '" readonly>';
                        edit_state_html +=
                            '<input type="hidden" class="input-field" id="edit_employee_state" value="' +
                            stateList[0].state_token + '">';
                    } else {
                        edit_state_html += '<select class="input-field" id="edit_employee_state">';
                        edit_state_html += '<option value="">Select state</option>';
                        for (var key in stateList) {
                            edit_state_html += '<option value="' + stateList[key].state_token + '">' +
                                stateList[key].state_name + '</option>';
                        }
                        edit_state_html += '</select>';
                    }
                    $(".edit_employee_state_box").append(edit_state_html);
                });

                // if($('#edit_address_proof1_url_image').attr('src') == "") {
                //     console.log('Image has no src');

                //         } else {
                //             console.log('Image has src');
                //         }

            });



var distChart;

// Chart-a update pandra puthu function
function update_chart_data() {
    var datas = {
        dashboard_code: verfication_code,
        state_id: admin_state_id,
        region_id: region_token, 
        type: "count"
    };
    var json_data = JSON.stringify(datas);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: api_path + "/admin/employeeDetails.php",
        data: json_data,
    }).done(function(data) {
        var count = parseInt(data.data) || 0;
        var active_count = parseInt(data.active_count) || 0;
        var inactive_count = count - active_count;

        // Update Text
        $("#total_employee_count").html(count);
        $("#total_active_employee_count").html(active_count);
        $("#chartCenterText").html(active_count);


        $("#text_active_count").html(active_count);
        $("#text_inactive_count").html(inactive_count);

        // Update Chart
        var ctxElement = document.getElementById('distributorChart');
        if(ctxElement) {
            var ctx = ctxElement.getContext('2d');
            if (distChart) {
                distChart.data.datasets[0].data = [active_count, inactive_count];
                distChart.update();
            } else {
                distChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Active', 'Inactive'],
                        datasets: [{
                            data: [active_count, inactive_count],
                            backgroundColor: ['#00b9f6', '#ff9d87'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { display: false },
                            tooltip: { enabled: true }
                        },
                        layout: { padding: 0 }
                    }
                });
            }
        }
    });
}


            //inser_area_employee

            // $(document).on("click","#add_employee_region",function(){
            //                 var gg = $('#add_employee_region option:selected').val();
            //                 //alert("hai");
            //                 console.log(gg);
            //             });

            $(document).on('change', '#add_employee_region', function() {
                // $('#add_employee_region').change(function(){
                var region_token = $(this).val();
                var data = {
                    type: "area",
                    "region_token": region_token
                }
                var json_data = JSON.stringify(data);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/select_employee_area.php",
                    data: json_data,
                }).done(function(response) {
                    console.log("response", response);
                    if (response.code == 200) {
                        var insert_area = `<option value=''> Select Area </option>`;
                        response.area_data.forEach(function(item, index) {
                            console.log(item.area_name);
                            insert_area +=
                                `<option id="area_drop" value="${item.area_token}">${item.area_name}</option>`;
                        });
                    } else {
                        var insert_area = `<option value=''> Select Area </option>`;
                    }
                    $("#add_employee_area").html(insert_area);

                });
            });
            //state drop down

            $(document).on("change", "#add_employee_state", function() {
                var state_token = $(this).val();
                var data = {
                    type: "state",
                    "state_token": state_token
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/state_and_region.php",
                    data: json_data,
                }).done(function(res_data) {
                    console.log(res_data.area_data);
                    var extract = res_data.area_data;
                    var html_text = '<option value="">Select Region</option>';
                    for (var key in extract) {
                        html_text += '<option value="' + extract[key].region_token + '">' + extract[key]
                            .region_name + '</option>';
                    }
                    //$("#region_token").html(html_text);
                    $("#add_employee_region").html(html_text);
                    $("#add_employee_area").html('<option value="">Select Area</option>');
                });
            });
            //edit employee state
            $(document).on("change", "#edit_employee_state", function() {
                var state_token = $(this).val();
                var data = {
                    type: "state",
                    "state_token": state_token
                };
                var json_data = JSON.stringify(data);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/state_and_region.php",
                    data: json_data,
                }).done(function(res_data) {
                    console.log(res_data);
                    var extract = res_data.area_data;
                    var html_text = '<option value="">Select Region</option>';
                    for (var key in extract) {
                        html_text += '<option value="' + extract[key].region_token + '">' + extract[key]
                            .region_name + '</option>';
                    }
                    $("#edit_employee_region").html(html_text);
                    $("#edit_employee_area").html('<option value="">Select Area</option>');
                });
            });

            // function data_fetch() {
            //     $(".se-pre-con").hide();
            //     table = $('#table_data').DataTable({
            //         'stateSave': true,
            //         'processing': true,
            //         'serverSide': true,
            //         'serverMethod': 'post',
            //         "aoColumnDefs": [{
            //             "bSortable": false,
            //             "aTargets": [10]
            //         }, ],
            //         'ajax': {
            //             'url': api_path + "/admin/serverEmployeeList.php?v_id=" + verfication_code + "&state_id=" +
            //                 admin_state_id + "&region_id=" + region_token,
            //         },
            //         pageLength: <?php echo $page_length; ?>,
            //         lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
            //         "order": [
            //             [0, "DESC"]
            //         ],
            //         'columns': [{
            //                 data: 'employee_token'
            //             },
            //             {
            //                 data: 'employee_code'
            //             },
            //             {
            //                 data: 'employee_name'
            //             },
            //             {
            //                 data: 'employee_mobile_number'
            //             },
            //             {
            //                 data: 'employee_email_id'
            //             },
            //             {
            //                 data: 'state_name'
            //             },
            //             {
            //                 data: 'region'
            //             },
            //             {
            //                 data: 'employee_area'
            //             },
            //             {
            //                 data: 'employee_join_date'
            //             },
            //             {
            //                 data: 'full_address'
            //             },
            //             {
            //                 data: 'status'
            //             },
            //             {
            //                 data: 'division'
            //             },
            //              {
            //                 data: 'action'
            //             },
            //             {
            //                 data: 'deactivate'
            //             },
            //             {
            //                 data: 'send_password'
            //             },
            //         ],
            //         dom: 'Bfrltip',
            //         "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //             if (aData.block_status == "2") {
            //                 $('td', nRow).css('background-color', '#ff9d87');
            //             }
            //         },
            //         language: {
            //             search: '<img src="assets/svg/Search_icon.svg">',
            //             searchPlaceholder: "Search"
            //         },
            //         // buttons: [{
            //         //     extend: 'pdfHtml5',
            //         //     className: 'btn-primary buttonprint',
            //         //     exportOptions: {
            //         //         columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            //         //     },
            //         //     orientation: 'landscape',
            //         //     pageSize: 'LEGAL'
            //         // }, {
            //         //     extend: 'csv',
            //         //     className: 'btn-info buttonprint',
            //         //     exportOptions: {
            //         //         columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            //         //     },
            //         //     orientation: 'landscape',
            //         //     pageSize: 'LEGAL'
            //         // }],

            //         buttons: [{
            //             extend: 'pdfHtml5',
            //             className: 'btn-primary buttonprint',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            //                 rows: function (idx, data, node) {
            //                     return data.block_status != "2"; 
            //                 }
            //             },
            //             orientation: 'landscape',
            //             pageSize: 'LEGAL'
            //         }, {
            //             extend: 'csv',
            //             className: 'btn-info buttonprint',
            //             exportOptions: {
            //                 columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
            //                 rows: function (idx, data, node) {
            //                     return data.block_status != "2"; 
            //                 }
            //             },
            //             orientation: 'landscape',
            //             pageSize: 'LEGAL'
            //         }],



                    
            //     });
            //     table.column(0).visible(false);
            //     table.column(9).visible(false);
            //     table.column(10).visible(false);
            //     table.column(11).visible(false);
            //     //$('.dataTables_length').css("display", "none");
            //     $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");
            // }





// function newExportAction(e, dt, button, config) {

//    // var self = this;
//     var oldLength = dt.page.len();

//     $(".se-pre-con").show();

//     dt.page.len(100000).draw();

//     dt.one('draw', function () {

//         if (button.hasClass('buttons-csv')) {
//             $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config);
//         }
//         else if (button.hasClass('buttons-pdf')) {
//             $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config);
//         }

//         setTimeout(function () {
//             dt.page.len(oldLength).draw(false);
//             $(".se-pre-con").hide();
//         }, 500);
//     });
// }


function newExportAction(e, dt, button, config) {
    var self = this;
    var oldLength = dt.page.len();

    $(".se-pre-con").show();

    dt.page.len(100000).draw();

    dt.one('draw', function () {

        if (button.hasClass('buttons-csv')) {
            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config);
        }
        else if (button.hasClass('buttons-pdf')) {
            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config);
        }
        // Intha condition puthusa add pannirukom (Excel kaga)
        else if (button.hasClass('buttons-excel')) {
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
        }

        setTimeout(function () {
            dt.page.len(oldLength).draw(false);
            $(".se-pre-con").hide();
        }, 500);
    });
}

// 2. Main data_fetch 
function data_fetch() {
    $(".se-pre-con").hide();
    
    if ($.fn.DataTable.isDataTable('#table_data')) {
        $('#table_data').DataTable().destroy();
    }

    var defaultLength = <?php echo (!empty($page_length)) ? $page_length : 10; ?>;

    table = $('#table_data').DataTable({
        'stateSave': true, 
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aoColumnDefs": [{
            "bSortable": false,
            "aTargets": [10]
        }],
        'ajax': {
            'url': api_path + "/admin/serverEmployeeList.php?v_id=" + verfication_code + "&state_id=" +
                admin_state_id + "&region_id=" + region_token,
        },
        pageLength: defaultLength, 
        lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
        "order": [
            [0, "DESC"]
        ],
        'columns': [
            { data: 'employee_token' },
            { data: 'employee_code' },
            { data: 'employee_name' },
            { data: 'employee_mobile_number' },
            { data: 'employee_email_id' },
            { data: 'state_name' },
            { data: 'region' },
            { data: 'employee_area' },
            { data: 'employee_join_date' },
            { data: 'full_address' },
            { data: 'status' },
            { data: 'division' },
            { data: 'action' },
            { data: 'deactivate' },
            { data: 'send_password' }
        ],
        dom: 'Bfrltip',
        "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData.block_status == "2") {
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
            action: newExportAction, 
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11], 
                rows: function (idx, data, node) {
                    return data.block_status != "2"; 
                }
            },
            orientation: 'landscape',
            pageSize: 'LEGAL'
        }, {
            extend: 'csvHtml5',
            className: 'btn-info buttonprint',
            action: newExportAction, 
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                rows: function (idx, data, node) {
                    return data.block_status != "2"; 
                }
            }
        }, 
        
        {
            extend: 'excelHtml5',
            text: 'Excel',
            className: 'btn-success buttonprint',
            action: newExportAction,
            exportOptions: {
                columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                
            }
        }]
    });
    
    table.column(0).visible(false);
    table.column(9).visible(false);
    table.column(10).visible(false);
    table.column(11).visible(false);
    
    $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");
}

            













            function gobutton() {
                admin_state_id = $("#selectState :selected").val();
                region_token = $("#selectRegion :selected").val();
                table.clear();
                table.destroy();
                data_fetch();

                update_chart_data();
            }
            $('#table_data tbody').on('click', '.employee_code_view', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.employee_token;

                view_employee(token);

                $("#formsend").append(`<input type="hidden" name="usertoken" value="${token}" >`);
                $("#formsend").submit();

            });
            $('#table_data tbody').on('click', '.sendcrds', function() {
                var sendbtn = $(this).parent().parent();
                // var btn = $('.sendcrds').html();
                // alert(btn);
                var fetchToken = table.row(sendbtn).data();
                var distributor_token = fetchToken.employee_token;
                var distributor_email = fetchToken.employee_email_id;
                var distributor_name = fetchToken.employee_name;
                var distributor_mobile = fetchToken.employee_mobile_number;
                let datas = {
                    distributor_token: distributor_token,
                    distributor_email: distributor_email,
                    distributor_name: distributor_name,
                    distributor_mobile: distributor_mobile
                }
                let datavalue = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/send_crd.php",
                    data: datavalue,
                }).done(function(data) {
                    if (data.code == "201") {
                        swal("Distributor Credentials sent to mail and Phone number successfully!", {
                            icon: "success"
                        });
                        location.reload();
                    } else {
                        swal(data.message);
                    }
                });
            });



            function view_employee(token) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single",
                    employee_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/employeeDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var emp_data = data.data;
                    $("#single_employee_name").html(emp_data[0].employee_name);
                    $("#single_employee_department").html(emp_data[0].employee_deparment_name);
                    $("#single_employee_join_date").html(emp_data[0].employee_join_date);
                    $("#single_employee_state").html(emp_data[0].state_name);
                    $("#single_employee_number").html(emp_data[0].employee_mobile_number);
                    $("#single_employee_code").html(emp_data[0].employee_code);
                    $("#single_employee_email").html(emp_data[0].employee_email_id);
                    $("#single_employee_licenseNumber").html(emp_data[0].employee_license_number);
                    $("#single_employee_region").html(emp_data[0].employee_region_name);
                    $("#single_employee_area").html(emp_data[0].employee_area_name);
                    $("#single_employee_address").html(emp_data[0].employee_address_full);
                    $("#single_employee_view_image").attr("src", emp_data[0].profile_image);
                    var imageURL = emp_data[0].employee_address_proof;
                    var extension = imageURL.split(".").pop();
                    if (extension == 'pdf') {
                        $("#single_employee_address_proof_img").attr("src", "");
                        $("#single_employee_address_proof_img").css("display", "none");
                        $("#single_employee_address_proof_pdf").css("display", "block");
                        $("#single_employee_address_proof_pdf").attr("src", emp_data[0].employee_address_proof);
                    } else {
                        $("#single_employee_address_proof_pdf").attr("src", "");
                        $("#single_employee_address_proof_pdf").css("display", "none");
                        $("#single_employee_address_proof_img").css("display", "block");
                        $("#single_employee_address_proof_img").attr("src", emp_data[0].employee_address_proof);
                    }
                    li_html = '';
                    var division_name1 = emp_data[0].division_name;
                    for (var key2 in division_name1) {
                        li_html += '<li>' + division_name1[key2] + '</li>';
                    }
                    $("#single_employee_division_name").html(li_html);
                    var html = "";
                    var attachement_data = emp_data[0].employee_attachment;
                    for (var key1 in attachement_data) {
                        var attachImageUrl = attachement_data[key1].attachment
                        var attachImgExten = attachImageUrl.split(".").pop();
                        if (attachImgExten == 'pdf') {
                            html += '<iframe class="uploadimg1" src="' + attachement_data[key1].attachment +
                                '" frameborder="0"></iframe>';
                        } else {
                            html += '<img src="' + attachement_data[key1].attachment + '" alt="">';
                        }
                    }
                    $("#update_status_token").val(token);
                    if (emp_data[0].block_status == 1) {
                        $(".de_activate").html(
                            '<a class="view_link" onclick="deactivate()">Deactivate Distributor</a>');
                        $(".de_activate > a").css('color', 'red');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    } else {
                        $(".de_activate").html('<a class="view_link" onclick="activate()">Activate Distributor</a>');
                        $(".de_activate > a").css('color', 'green');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    }
                    $("#single_other_attachement").html(html);
                    // $('#employee_view').show();
                    $('#employee').hide();
                    $(".se-pre-con").hide();
                });
            }

            function add_employee() {
                var employee_name = $("#add_employee_name").val();
                var val1 = value_check('add_employee_name', employee_name, 'text_box');
                var employee_number = $("#add_employee_mobilenumber").val();
                var val3 = value_check('add_employee_mobilenumber', employee_number, 'mobile');
                var employee_joindate = $("#add_employee_joindate").val();
                var employee_department = $("#add_employee_department").val();
                var val7 = value_check('add_employee_department', employee_department, 'text_box');
                var employee_email_id = $("#add_employee_email_id").val();
                var val8 = value_check('add_employee_email_id', employee_email_id, 'text_box_email', 'Email Address');
                var employee_division = $("#add_employee_division").val();
                if (employee_division.length > 0) {
                    var val10 = true;
                    $(".selection .select2-selection--multiple").css("border", "1px solid #ced4da");
                } else {
                    var val10 = false;
                    $(".selection .select2-selection--multiple").css("border", "1px solid #ed3833");
                }
                console.log("division", employee_division);
                var employee_license_number = $("#add_employee_license_number").val();
                var val11 = value_check('add_employee_license_number', employee_license_number, 'text_box');
                var employee_address = $("#add_employee_address").val();
                var val12 = value_check('add_employee_address', employee_address, 'text_box');
                var employee_city = $("#add_employee_city").val();
                var val13 = value_check('add_employee_city', employee_city, 'text_box');
                var employee_area = $("#add_employee_area").val();
                var val14 = value_check('add_employee_area', employee_area, 'text_box');
                //                var employee_street = $("#add_employee_street").val();
                //                var val14 = value_check('add_employee_street', employee_street, 'text_box');
                var employee_pincode = $("#add_employee_pincode").val();
                var val15 = value_check('add_employee_pincode', employee_pincode, 'pin_code');
                var add_employee_region = $("#add_employee_region").val();
                var val16 = value_check('add_employee_region', add_employee_region, 'text_box');
                var add_employee_state = $("#add_employee_state").val();
                var val17 = value_check('add_employee_state', add_employee_state, 'text_box');
                var employee_image = $("#employee_image_valid").val();
                var address_proof1 = $("#address_proof1_valid").val();
                var address_proof2 = $("#address_proof2_valid").val();
                var address_proof3 = $("#address_proof3_valid").val();
                var address_proof4 = $("#address_proof4_valid").val();
                var address_proof5 = $("#address_proof5_valid").val();

                if (val1 == true && val3 == true && val7 == true && val8 == true && val10 == true && val11 == true && val12 ==
                    true && val13 == true && val14 == true && val15 == true && val16 == true && val17 == true) {
                    $('#add_employee_button').prop('disabled', true);
                    $(".se-pre-con").show();
                    image_upload_loop(0);
                } else {
                    swal("Please enter all details!");
                }
            }
            var image_id = ['employee_image', 'address_proof1', 'address_proof2', 'address_proof3', 'address_proof4',
                'address_proof5'
            ]

            function image_upload_loop(key) {
                var valid = $("#" + image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > image_id.length) {
                        add_employee_finish();
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
                        add_employee_finish();
                    }
                }
            }

            function add_employee_finish() {
                var employee_name = $("#add_employee_name").val();
                var employee_number = $("#add_employee_mobilenumber").val();
                var employee_joindate = $("#add_employee_joindate").val();
                if (employee_joindate == '') {
                    var employee_joindate = new Date();
                    var dd = String(employee_joindate.getDate()).padStart(2, '0');
                    var mm = String(employee_joindate.getMonth() + 1).padStart(2, '0'); //January is 0!
                    var yyyy = employee_joindate.getFullYear();
                    employee_joindate = mm + '/' + dd + '/' + yyyy;
                }
                var employee_department = $("#add_employee_department").val();
                var employee_email_id = $("#add_employee_email_id").val();
                var employee_division = $("#add_employee_division").val();
                var employee_address = $("#add_employee_address").val();
                var employee_city = $("#add_employee_city").val();
                var employee_area = $("#add_employee_area").val();
                //                var employee_street = $("#add_employee_street").val();
                var employee_pincode = $("#add_employee_pincode").val();
                var employee_image = $("#employee_image_valid").val();
                var address_proof1 = $("#address_proof1_valid").val();
                var address_proof2 = $("#address_proof2_valid").val();
                var address_proof3 = $("#address_proof3_valid").val();
                var address_proof4 = $("#address_proof4_valid").val();
                var address_proof5 = $("#address_proof5_valid").val();
                var employee_license_number = $("#add_employee_license_number").val();
                var employee_region = $("#add_employee_region").val();
                var employee_state = $("#add_employee_state").val();
                var datas = {
                    'employee_name': employee_name,
                    'employee_number': employee_number,
                    'employee_joindate': employee_joindate,
                    'employee_department': employee_department,
                    'employee_email_id': employee_email_id,
                    'employee_address': employee_address,
                    'employee_city': employee_city,
                    'employee_area': employee_area,
                    //                    'employee_street': employee_street,
                    'employee_pincode': employee_pincode,
                    'employee_image': employee_image,
                    'address_proof1': address_proof1,
                    'address_proof2': address_proof2,
                    'address_proof3': address_proof3,
                    'address_proof4': address_proof4,
                    'address_proof5': address_proof5,
                    'employee_division': employee_division,
                    'employee_license_number': employee_license_number,
                    'dashboard_code': verfication_code,
                    'employee_region': employee_region,
                    'employee_state': employee_state,
                    'admin_token': admin_token
                }
                var json_data = JSON.stringify(datas);
                console.log('json_data', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/addEmployee.php",
                    data: json_data,
                }).done(function(data) {
                    console.log('datass', data);
                    $(".se-pre-con").hide();
                    if (data.code == "201") {
                        swal("Distributor added successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#add_employee_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }

            function deactivate_from_edit() {
                var token = $("#edit_employee_token").val();
                var employee_name = $("#edit_employee_name").val();
                var employee_number = $("#edit_employee_mobilenumber").val();
                var employee_email_id = $("#edit_employee_email_id").val();
                var employee_division = $("#edit_employee_division").val();
                var employee_license_number = $("#edit_employee_license_number").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this distributor?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'employee_token': token,
                            'employee_name': employee_name,
                            'employee_number': employee_number,
                            'employee_email_id': employee_email_id,
                            'employee_division': employee_division,
                            'employee_license_number': employee_license_number,
                            'admin_token': admin_token,
                            'employee_status': 2,
                            'dashboard_code': verfication_code
                        };
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Distributor deactivated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }

            function deactivate(key) {
                var token = $("#update_status_token").val();
                var employee_name = $("#edit_employee_name").val();
                var employee_number = $("#edit_employee_mobilenumber").val();
                var employee_email_id = $("#edit_employee_email_id").val();
                var employee_division = $("#edit_employee_division").val();
                var employee_license_number = $("#edit_employee_license_number").val();
                var datas = {
                    'employee_token': employee_token,

                }
                var json_data = JSON.stringify(datas);
                console.log('json_data', json_data);
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this employee?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'employee_token': token,
                            'employee_name': employee_name,
                            'employee_number': employee_number,
                            'employee_email_id': employee_email_id,
                            'employee_division': employee_division,
                            'employee_license_number': employee_license_number,
                            'admin_token': admin_token,
                            'employee_status': 2,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        console.log('json_data', json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Distributor deactivated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    view_employee(token);
                                    location.reload();
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
                    text: "You want to activate this employee?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'employee_token': token,
                            'employee_status': 1,
                            'dashboard_code': verfication_code
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Distributor activated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    view_employee(token);
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }


            $('#table_data tbody').on('click', '.employee_code_edit', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                //console.log(table_data);
                var token = table_data.employee_token;
                // console.log(token);
                var region_name = table_data.region;
                //console.log(region_name);

                edit_employee(token);
            });

            $('#table_data tbody').on('click', '.table_deactivate_btn', function() {
                var token = $(this).data('token');
                var status = $(this).data('status');
                var name = $(this).data('name');
                var mobile = $(this).data('mobile');
                var email = $(this).data('email');
                var license = $(this).data('license');
                var isActive = (status == 1 || status == '1');
                var actionLabel = isActive ? 'deactivate' : 'activate';
                var newStatus  = isActive ? 2 : 1;
                var successMsg = isActive ? 'Distributor deactivated successfully!' : 'Distributor activated successfully!';
                swal({
                    title: "Are you sure?",
                    text: "You want to " + actionLabel + " this distributor?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: isActive,
                }).then((willDo) => {
                    if (willDo) {
                        var datas = {
                            'employee_token': token,
                            'name': name,
                            'mobile_numbr': mobile,
                            'gmail': email,
                            'licens': license,
                            'admin_token': admin_token,
                            'employee_status': newStatus,
                            'dashboard_code': verfication_code
                        };
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/employeeStatusChange.php",
                            data: JSON.stringify(datas),
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal(successMsg, { icon: "success" }).then(() => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            });

            function edit_employee(token) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single",
                    employee_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/employeeDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var area_dropdown = '';
                    console.log(data);
                    var emp_data = data.data;
                    //console.log(emp_data);

                    $("#edit_employee_token").val(emp_data[0].employee_token);
                    $("#edit_employee_name").val(emp_data[0].employee_name);
                    $("#old_name").val(emp_data[0].employee_name);
                    $("#edit_employee_mobilenumber").val(emp_data[0].employee_mobile_number);
                    $("#old_mobilenumber").val(emp_data[0].employee_mobile_number);
                    $("#edit_employee_joindate").val(emp_data[0].employee_join_date);
                    $("#edit_employee_department").val(emp_data[0].employee_deparment_token);
                    $("#edit_employee_email_id").val(emp_data[0].employee_email_id);
                    $("#old_email").val(emp_data[0].employee_email_id);
                    $("#edit_employee_license_number").val(emp_data[0].employee_license_number);
                    $("#old_licens").val(emp_data[0].employee_license_number);
                    $("#edit_employee_address").val(emp_data[0].employee_address);
                    var saved_area_token = emp_data[0].employee_area; // save for after dropdown loads
                    // console.log(emp_data[0].employee_area);
                    $("#edit_employee_city").val(emp_data[0].employee_city);
                    $("#edit_employee_pincode").val(emp_data[0].employee_pincode);
                    $("#edit_employee_region").val(emp_data[0].region_id);
                    $("#edit_employee_state").val(emp_data[0].state_token);



                    if (emp_data[0].profile_image == "") {
                        $("#edit_employee_view_image_url").attr("src", "assets/upload.png");
                    } else {
                        $("#edit_employee_view_image_url").attr("src", emp_data[0].profile_image);
                    }
                    $("#edit_employee_image_valid").val(emp_data[0].profile_image);
                    var imageURL = emp_data[0].employee_address_proof;
                    var extension = imageURL.split(".").pop();
                    $('#edit_address_proof1_upload').next(".reupload").remove();
                    if (emp_data[0].employee_address_proof == "" || emp_data[0].employee_address_proof == null) {
                        $("#edit_address_proof1_url_image").attr("src", "assets/icons/address_proof_upload.svg");
                    } else if (extension == "pdf") {
                        $("#edit_address_proof1_url_image").attr("src", "");
                        $("#edit_address_proof1_url_image").css("display", "none");
                        $("#edit_address_proof1_url_pdf").attr("src", emp_data[0].employee_address_proof);
                        $('#edit_address_proof1_upload').after('<p class="reupload">Reupload</p>');
                    } else {
                        $("#edit_address_proof1_url_pdf").css("display", "none");
                        $("#edit_address_proof1_url_image").attr("src", emp_data[0].employee_address_proof);
                        $('#edit_address_proof1_upload').after('<p class="reupload">Reupload</p>');
                    }
                    $("#edit_address_proof1_valid").val(emp_data[0].employee_address_proof);
                    var array = emp_data[0].employee_division;
                    $("#edit_employee_division").val(array);
                    $("#old_division").val(array);
                    $('#edit_employee_division').not('.manual').select2();
                    var proof_array = emp_data[0].employee_attachment;
                    var slno = 2;
                    for (var key in proof_array) {
                        $("#edit_address_proof" + slno + "_upload").next(".reupload").remove();
                        var attachemntImageURL = proof_array[key].attachment;
                        var attachmentExtension = attachemntImageURL.split(".").pop();
                        $("#edit_address_proof" + slno + "_valid_id").val(proof_array[key].attachment_id);
                        $("#edit_address_proof" + slno + "_valid").val(proof_array[key].attachment);
                        if (attachmentExtension == "pdf") {
                            $("#edit_address_proof" + slno + "_url_image").attr("src", "");
                            $("#edit_address_proof" + slno + "_url_image").css("display", "none");
                            $("#edit_address_proof" + slno + "_url_pdf").css("display", "block");
                            $("#edit_address_proof" + slno + "_url_pdf").attr("src", proof_array[key].attachment);
                            $("#edit_address_proof" + slno + "_upload").after('<p class="reupload">Reupload</p>');
                        } else {
                            $("#edit_address_proof" + slno + "_url_pdf").attr("src", "");
                            $("#edit_address_proof" + slno + "_url_pdf").css("display", "none");
                            $("#edit_address_proof" + slno + "_url_image").css("display", "block");
                            $("#edit_address_proof" + slno + "_url_image").attr("src", proof_array[key].attachment);
                            $("#edit_address_proof" + slno + "_upload").after('<p class="reupload">Reupload</p>');
                        }
                        slno++;
                    }
                    for (var i = slno; i <= 5; i++) {
                        var j = parseInt(i) - 1;
                        $("#edit_address_proof" + i + "_valid_id").val('');
                        $("#edit_address_proof" + i + "_valid").val('');
                        $("#edit_address_proof" + i + "_url_image").css("display", "block");
                        $("#edit_address_proof" + i + "_url_image").attr("src", "assets/icons/proof" + j + ".png");
                        $("#edit_address_proof" + i + "_url_pdf").attr("src", "");
                        $("#edit_address_proof" + i + "_upload").next(".reupload").remove();
                    }
                    $('#employee_edit').show();
                    $('#employee').hide();
                    $(".se-pre-con").hide();

                    // Load all areas for the region, then select the correct one
                    $("#edit_employee_area").empty();
                    var region_token = $("#edit_employee_region").val();
                    var data = {
                        "region_token": region_token
                    };
                    var json_data = JSON.stringify(data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/select_employee_area.php",
                        data: json_data,
                    }).done(function(response) {
                        var edit_insert_area = '<option value="">Select Area</option>';
                        response.area_data.forEach(function(item, index) {
                            edit_insert_area +=
                                `<option id="area_drop" value="${item.area_token}">${item.area_name}</option>`;
                        });
                        $("#edit_employee_area").html(edit_insert_area);
                        // Set correct area AFTER options exist
                        $("#edit_employee_area").val(saved_area_token);
                    });

                    // # EDITE REGION CHANGE ==========
                    $(document).ready(function() {
                        $('#edit_employee_region').change(function() {

                            //$("#edit_employee_area").empty();
                            var region_token = $(this).find(':selected').val()
                            var data = {
                                "region_token": region_token
                            }
                            var json_data = JSON.stringify(data);
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: api_path + "/admin/select_employee_area.php",
                                data: json_data,
                            }).done(function(response) {
                                console.log('response', response);
                                $("#edit_employee_area").empty();
                                var edit_insert_area = '';
                                edit_insert_area += '<option  value="">Select Area</option>';
                                response.area_data.forEach(function(item, index) {
                                    console.log(item.area_name);
                                    edit_insert_area +=
                                        `<option  id="area_drop" value="${item.area_token}">${item.area_name}</option>`;
                                });
                                $("#edit_employee_area").append(edit_insert_area);
                            })

                        });


                    });




                });
            }
            // $(document).ready(function(){
            //     var area_token = $("#edit_employee_area").val();
            //    console.log(area_token);
            //     var data1 ={
            //         "area_token" :area_token
            //     }
            //     var json_data1 = JSON.stringify(data1);
            //     // console.log(data1);
            //     $.ajax({
            //         type: "POST",
            //         dataType: "json",
            //         url: api_path + "/admin/get_employee_area.php",
            //         data: json_data1,
            //     }).done(function(response){
            //             console.log(response);
            //             //console.log(response[0].employee_area_name);
            //             $("#edit_employee_area").empty();

            //              area_dropdown +=`<option  value="${emp_data[0].employee_area}">${response[0].employee_area_name}</option>`;
            //              area_dropdown +=`<option  value="Select Area">Select Area</option>`;
            //             $("#edit_employee_area").html(area_dropdown);


            //     });
            // });



            function retailer_view() {
                window.location.href = "retailer_view";
            }


            function update_employee() {
                var employee_name = $("#edit_employee_name").val();
                var val1 = value_check('edit_employee_name', employee_name, 'text_box');
                var employee_number = $("#edit_employee_mobilenumber").val();
                var val3 = value_check('edit_employee_mobilenumber', employee_number, 'mobile');
                var employee_joindate = $("#edit_employee_joindate").val();
                var employee_department = $("#edit_employee_department").val();
                var val7 = value_check('edit_employee_department', employee_department, 'text_box');
                var employee_email_id = $("#edit_employee_email_id").val();
                var val8 = value_check('edit_employee_email_id', employee_email_id, 'text_box_email', 'Email Address');
                var employee_division = $("#edit_employee_division").val();
                if (employee_division.length > 0) {
                    var val10 = true;
                    $(".selection .select2-selection--multiple").css("border", "1px solid #ced4da");
                } else {
                    var val10 = false;
                    $(".selection .select2-selection--multiple").css("border", "1px solid #ed3833");
                }
                var employee_license_number = $("#edit_employee_license_number").val();
                var val11 = value_check('edit_employee_license_number', employee_license_number, 'text_box');
                var employee_address = $("#edit_employee_address").val();
                var val12 = value_check('edit_employee_address', employee_address, 'text_box');
                var employee_city = $("#edit_employee_city").val();
                var val13 = value_check('edit_employee_city', employee_city, 'text_box');
                var employee_area = $("#edit_employee_area").val();

                var val14 = value_check('edit_employee_area', employee_area, 'text_box');
                //    console.log("haiiiiii",val14);
                var employee_pincode = $("#edit_employee_pincode").val();
                var val15 = value_check('edit_employee_pincode', employee_pincode, 'pin_code');
                var employee_region = $("#edit_employee_region").val();
                var val16 = value_check('edit_employee_region', employee_region, 'text_box');
                var employee_state = $("#edit_employee_state").val();
                var val17 = value_check('edit_employee_state', employee_state, 'text_box');
                var employee_image = $("#edit_employee_image_valid").val();
                var address_proof1 = $("#edit_address_proof1_valid").val();
                var address_proof2 = $("#edit_address_proof2_valid").val();
                var address_proof3 = $("#edit_address_proof3_valid").val();
                var address_proof4 = $("#edit_address_proof4_valid").val();
                var address_proof5 = $("#edit_address_proof5_valid").val();

                if (val1 == true && val3 == true && val7 == true && val8 == true && val10 == true && val11 == true && val12 ==
                    true && val13 == true && val14 == true && val15 == true && val16 == true && val17 == true) {
                    $('#update_employee_button').prop('disabled', true);
                    $(".se-pre-con").show();
                    edit_image_upload_loop(0);
                } else {
                    swal("Please enter all details!");
                }
            }
            var edit_image_id = ['edit_employee_image', 'edit_address_proof1', 'edit_address_proof2', 'edit_address_proof3',
                'edit_address_proof4', 'edit_address_proof5'
            ]

            function edit_image_upload_loop(key) {
                var valid = $("#" + edit_image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > edit_image_id.length) {
                        update_employee_finish();
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
                        update_employee_finish();
                    }
                }
            }

            function update_employee_finish() {
                var employee_token = $("#edit_employee_token").val();
                var employee_name = $("#edit_employee_name").val();
                var employee_number = $("#edit_employee_mobilenumber").val();
                var employee_joindate = $("#edit_employee_joindate").val();
                var employee_department = $("#edit_employee_department").val();
                var employee_email_id = $("#edit_employee_email_id").val();
                var employee_division = $("#edit_employee_division").val();
                var employee_address = $("#edit_employee_address").val();
                var employee_area = $("#edit_employee_area").val();
                var employee_city = $("#edit_employee_city").val();
                var employee_street = $("#edit_employee_street").val();
                var employee_pincode = $("#edit_employee_pincode").val();
                var employee_image = $("#edit_employee_image_valid").val();
                var address_proof1 = $("#edit_address_proof1_valid").val();
                var proof2_id = $("#edit_address_proof2_valid_id").val();
                var proof3_id = $("#edit_address_proof3_valid_id").val();
                var proof4_id = $("#edit_address_proof4_valid_id").val();
                var proof5_id = $("#edit_address_proof5_valid_id").val();
                var address_proof2 = $("#edit_address_proof2_valid").val();
                var address_proof3 = $("#edit_address_proof3_valid").val();
                var address_proof4 = $("#edit_address_proof4_valid").val();
                var address_proof5 = $("#edit_address_proof5_valid").val();
                var employee_license_number = $("#edit_employee_license_number").val();
                var employee_region = $("#edit_employee_region").val();
                var employee_state = $("#edit_employee_state").val();

                var old_name = $("#old_name").val();
                var old_mobilenumber = $("#old_mobilenumber").val();
                var old_email = $("#old_email").val();
                var old_licens = $("#old_licens").val();
                var old_division = $("#old_division").val().split(',');


                var datas = {
                    'employee_token': employee_token,
                    'employee_name': employee_name,
                    'old_name': old_name,
                    'employee_number': employee_number,
                    'old_mobilenumber': old_mobilenumber,
                    'employee_joindate': employee_joindate,
                    'employee_department': employee_department,
                    'employee_email_id': employee_email_id,
                    'old_email': old_email,
                    'employee_address': employee_address,
                    'employee_area': employee_area,
                    'employee_city': employee_city,
                    'employee_street': employee_street,
                    'employee_pincode': employee_pincode,
                    'employee_image': employee_image,
                    'address_proof1': address_proof1,
                    'proof2_id': proof2_id,
                    'proof3_id': proof3_id,
                    'proof4_id': proof4_id,
                    'proof5_id': proof5_id,
                    'address_proof2': address_proof2,
                    'address_proof3': address_proof3,
                    'address_proof4': address_proof4,
                    'address_proof5': address_proof5,
                    'employee_division': employee_division,
                    'old_division': old_division,
                    'employee_license_number': employee_license_number,
                    'old_licens': old_licens,
                    'dashboard_code': verfication_code,
                    'employee_region': employee_region,
                    'employee_state': employee_state,
                    'admin_token': admin_token
                }
                var json_data = JSON.stringify(datas);
                console.log('json_data', json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/updateEmployee.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if (data.code == "201") {
                        swal("Distributor Updated successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#update_employee_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }


            //            function show_EmployeePDF(){
            //                var data={
            //                    'invoice_name': employee.invoice_name,
            //                }
            //                $.ajax({
            //                            type: "POST",
            //                            dataType: "json",
            //                            url : "../TCPDF-main/examples/employeeListPdf.php?state_id="+admin_state_id,
            //                            data: data,
            //                            }).done(function(data) {
            //                                if(data.status_code==200){
            //                                $(".se-pre-con").hide();
            //                                window.open('../invoice_pdf/'+data.data, '_blank');
            //                                }else{
            //                                    swal("Something Happened!", {icon: "failed"});
            //                                }
            //                            });
            //            }

            //     function show_EmployeeCSV(){
            //        var csv_data = [];
            //        var rows = document.getElementsByTagName('tr');
            //        for (var i = 0; i < rows.length; i++) {
            //            var cols = rows[i].querySelectorAll('td,th');
            //            var csvrow = [];
            //            for (var j = 0; j < cols.length; j++) {
            //                csvrow.push(cols[j].innerText.replace("/<a.*>.*?<\/a>/ig,''"));
            //
            //            }
            //            // csvrow.shift(cols[0].innerHTML);
            //            csvrow.pop(cols[6].innerHTML);
            //            csvrow.pop(cols[7].innerHTML);
            //            csv_data.push(csvrow.join(","));
            //        }
            //        csv_data = csv_data.join('\n');
            //        downloadCSVFile(csv_data);
            //
            //        }

            //        function downloadCSVFile(csv_data) {
            //        CSVFile = new Blob([csv_data], {
            //            type: "text/csv"
            //        });
            //        var temp_link = document.createElement('a');
            //
            //        temp_link.download = "DistributorList.csv";
            //        var url = window.URL.createObjectURL(CSVFile);
            //        temp_link.href = url;
            //        temp_link.style.display = "none";
            //        document.body.appendChild(temp_link);
            //        temp_link.click();
            //        document.body.removeChild(temp_link);
            //}


            // $(document).on('keypress', '#add_employee_name,#edit_employee_name', function(event) {
            //     var regex = new RegExp("^[a-zA-Z ]+$");
            //     var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            //     if (!regex.test(key) || (event.which === 32 && this.value.length === 0)) {
            //         event.preventDefault();
            //         return false;
            //     }
            // });
            $('#add_employee_division').on("select2:select", function(e) {
                var data = e.params.data.text;
                if (data == 'Select All Division') {
                    $("#add_employee_division > option").prop("selected", "selected");
                    $(".all").prop("selected", false);
                    $("#add_employee_division").trigger("change");
                }
                console.log($(this).val());
            });
            $('#edit_employee_division').on("select2:select", function(e) {
                var data = e.params.data.text;
                if (data == 'Select All Division') {
                    $("#edit_employee_division > option").prop("selected", "selected");
                    $(".all").prop("selected", false);
                    $("#edit_employee_division").trigger("change");
                }
            });
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>