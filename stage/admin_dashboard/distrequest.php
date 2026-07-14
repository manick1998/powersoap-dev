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
        <link rel="stylesheet" href="css/distqust.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/3.30.2/minified.js"></script>
       
        <style>
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
               .select__status {
                    outline: none;
                    padding: 6px;
                    border-radius: 2px;
                    width: 107px;
                    border: 1px solid #11a14a;
                    background-color: #11a14a;
                    color: #fff;
                    background-image: url(assets/Down--Arrow@2x.svg);
                    background-size: 16px;
                    background-repeat: no-repeat;
                    background-position: 96% 50%;
                    
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
                    margin-top: 1rem;
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
                <!-- <li class="custom-nav__item" data-id="70085140"><a href="#" data-toggle="tab">andhra</a></li>
                <li class="custom-nav__item" data-id="73874978"><a href="#" data-toggle="tab">Andhra Pradesh</a></li>
                <li class="custom-nav__item" data-id="53620154"><a href="#" data-toggle="tab">Delhi</a></li>
                <li class="custom-nav__item" data-id="69274517"><a href="#" data-toggle="tab">goa</a></li>
                <li class="custom-nav__item" data-id="25396355"><a href="#" data-toggle="tab">Gujarath</a></li>
                <li class="custom-nav__item" data-id="12248706"><a href="#" data-toggle="tab">Hariyana</a></li>
                <li class="custom-nav__item" data-id="70606040"><a href="#" data-toggle="tab">Harriyana</a></li>
                <li class="custom-nav__item" data-id="19401422"><a href="#" data-toggle="tab">Karnataka</a></li> -->
                </ul>

            </div>
            </section>
            <section class="bg-white brad-4 full-height" id="distributor-con">
                <div class="header_container">
                    <div>
                    <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png"  alt=""></span></h1>
                        <h1 class="header_main">Distributor List</h1>
                        <span class="table_count">Total Distributor -<span id='count'></span></span>
                        
                        <div id="exTab">	
                            <ul  class="nav nav-pills">
                                <!-- <li class="active"><a class="active" >All</a></li>
                                <li><a class="">Approved</a></li>
                                <li><a class="">Pending</a></li>
                                <li><a class="">Rejected</a></li> -->
                                <li class="active"><a  href="#All" id='all_btn' class="active show" data-toggle="tab">All</a></li>
                                <li><a href="#Approved" id='approved_btn' data-toggle="tab">Approved</a></li>
                                <li><a href="#Pending" id='Pending_btn' data-toggle="tab">Pending</a></li>
                                <li><a href="#Rejected" id='Rejected_btn' data-toggle="tab">Rejected</a></li>
                            </ul>
                            
                        </div>

                        
                    </div>
                </div>

            <div class="tab-content clearfix">
                 <div class="tab-pane active" id="All">

                            <div class="table-box">
                                <table class="custom-table" id="all_table_data">
                                    <thead>
                                        <tr>    
                                                <!-- <th></th> -->
                                                <th>Distributor Code</th>
                                                <th>Distributor Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                                <th>State</th>
                                                <th>Region</th>
                                                <th>Area</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id='all_data_dis'>
                                        <!-- <tr>
                                            <td></td>
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
                                                <td>
                                                    <a onclick="showeditehadler()"><img src="assets/edit.png" class="edit_input employee_code_edit" alt="" /></a>
                                                </td>
                                            </tr> -->
                                    </tbody>
                                </table>
                            </div>
                            </div>
                            <div class="tab-pane" id="Approved">
                                
                                <div class="table-box">
                                    <table class="custom-table" id="approved_table_data">
                                        <thead>
                                            <tr>
                                            <!-- <th></th> -->
                                                <th>Distributor Code</th>
                                                <th>Distributor Name</th>
                                                <th>Mobile Number</th>
                                                <th>Email Address</th>
                                                <th>State</th>
                                                <th>Region</th>
                                                <th>Area</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id='Approved_data_dis'>
                                            <!-- <tr>
                                                <td></td>
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
                                                <td>
                                                    <a onclick="showeditehadler()"><img src="assets/edit.png" class="edit_input" alt="" /></a>
                                                </td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="Rejected"> 
                            <div class="table-box">
                                <table class="custom-table" id="rejected_table_data">
                                    <thead>
                                        <tr>
                                           <!-- <th></th> -->
                                            <th>Distributor Code</th>
                                            <th>Distributor Name</th>
                                            <th>Mobile Number</th>
                                            <th>Email Address</th>
                                            <th>State</th>
                                            <th>Region</th>
                                            <th>Area</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id='Rejected_data_dis'>
                                        <!-- <tr>
                                            <td></td>
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
                                            <td>
                                                <a onclick="showeditehadler()"><img src="assets/edit.png" class="edit_input" alt="" /></a>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                     </div>
                            <div class="tab-pane" id="Pending"> 
                                <!-- <div class="tab-pane active"> -->

                                    <div class="table-box">
                                        <table class="custom-table" id="emp_table_data">
                                            <thead>
                                                <tr>    
                                                    <!-- <th></th> -->
                                                    <th>Distributor Code</th>
                                                    <th>Distributor Name</th>
                                                    <th>Mobile Number</th>
                                                    <th>Email Address</th>
                                                    <th>State</th>
                                                    <th>Region</th>
                                                    <th>Area</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                    
                                                </tr>
                                            </thead>
                                <tbody id = 'emp_data'>
                                       <!-- <tr>
                                           <td></td>
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
                                            <td>
                                                <a onclick="showeditehadler()"><img src="assets/edit.png" class="edit_input" alt="" /></a>
                                            </td>
                                        </tr> -->
                                </tbody>
                            </table>
                        </div>
                    <!-- </div> -->
                    
                   
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
                                </div>
                                <div class="form-control edit_employee_mobilenumber_box">
                                    <p class="edit_employee_mobilenumber">Mobile Number</p>
                                    <input class="input-field numberonly" id="edit_employee_mobilenumber" placeholder="Please Enter Mobilenumber" maxlength="10">
                                </div>
                                <div class="form-control edit_employee_joindate_box">
                                    <p class="edit_employee_joindate">Joining Date</p>
                                    <input class="input-field box_form no_border" id="edit_employee_joindate" placeholder="Joining Date" maxlength="10" autocomplete="off">
                                </div>
                                <div class="form-control edit_employee_region_box">
                                    <p class="edit_employee_region">Region</p>
                                    <select class="input-field" id="edit_employee_region">
                                    </select>
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
                                </div>
                                <div class="form-control edit_employee_license_number_box">
                                    <p class="edit_employee_license_number">Distributor GST Number</p>
                                    <input class="input-field" id="edit_employee_license_number" placeholder="Please Enter GST Number" maxlength="16">
                                </div>
                                <div class="form-control edit_employee_state_box">
                                    <p class="edit_employee_state">State <span id="mandatory_icon">*</span></p>
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
                        <span class="close_btn" id="address_proof1_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
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
                                <span class="close_btn" id="edit1_address_proof2_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
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
                                <span class="close_btn" id="edit2_address_proof2_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
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
                                <span class="close_btn" id="edit3_address_proof2_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
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
                                    <span class="close_btn" id="edit4_address_proof2_url_close" style="display:none;" onclick="edit_file_removes('edit_address_proof1','edit_address_proof1_url','assets/icons/proof1.png')">X</span>
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
                        <button class="btn_product" onclick="update_employee()" id="update_employee_button">Update Details</button>
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
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
         <!---- For S3 bucket upload ---->
         <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>

        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/polyfill.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbV6guze9AOGJf91eU07rfrrK0qnICW1E&callback=initMap&v=weekly"
      defer
></script>        -->
        <script>

function showeditehadler (){
    $('#employee_edit').show();
    $('#distributor-con').hide();
}
function showbackhadler (){
    $('#distributor-con').show();
    $('#employee_edit').hide();
}

$('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
    $($.fn.dataTable.tables(true)).DataTable()
        .columns.adjust()
        .responsive.recalc();
});

function back_edit_employee() {
                $('#distributor-con').show();
                $('#employee_edit').hide();
            }

$('#edit_employee_joindate').datepicker({
                autoclose: true,
                todayHighlight: true,
                maxDate: new Date(),
                changeYear: true,
                yearRange: '1970:2060',
                defaultDate: 'today'
                });

        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var table;
        var table1;
        var arr_all = [];

        // $(document).on('click','#edit_address_proof1_url_image',function(){
        //         var image = $(this).attr("src");
        //         if (image == image) {
        //             $("#address_proof1_url_close").show();
        //         }
        //         console.log('image',image);
        //     });
        //     $(document).on('click','#address_proof1_url_close',function(){
        //         $(this).hide();
        //     });
        //     //2
        //     $(document).on('click','#edit_address_proof2_url_image',function(){
        //         var image = $(this).attr("src");
        //         if (image == image) {
        //             $("#edit1_address_proof2_url_close").show();
        //         }
        //         console.log('image',image);
        //     });
        //     $(document).on('click','#edit1_address_proof2_url_close',function(){
        //         $('#edit_address_proof2_url_image').attr("src","assets/icons/proof1.png");
        //         $(this).hide();
        //     });
        //     //3
        //     $(document).on('click','#edit_address_proof3_url_image',function(){
        //         var image = $(this).attr("src");
        //         if (image == image) {
        //             $("#edit2_address_proof2_url_close").show();
        //         }
        //         console.log('image',image);
        //     });
        //     $(document).on('click','#edit2_address_proof2_url_close',function(){
        //         $(this).hide();
        //     });
        //     //4
        //     $(document).on('click','#edit_address_proof4_url_image',function(){
        //         var image = $(this).attr("src");
        //         if (image == image) {
        //             $("#edit3_address_proof2_url_close").show();
        //         }
        //         console.log('image',image);
        //     });
        //     $(document).on('click','#edit3_address_proof2_url_close',function(){
        //         $(this).hide();
        //     });
        //     //5
        //     $(document).on('click','#edit_address_proof5_url_image',function(){
        //         var image = $(this).attr("src");
        //         if (image == image) {
        //             $("#edit4_address_proof2_url_close").show();
        //         }
        //         console.log('image',image);
        //     });
        //     $(document).on('click','#edit4_address_proof2_url_close',function(){
        //         $(this).hide();
        //     });

        $(document).ready(function() {
            
            let state = {
                type: "all_emp"
            };
            var json_data = JSON.stringify(state);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/serverEmployeeApprovedList.php",
                data:json_data,
            }).done(function(datas){
                pending_data(datas);
                approved_data(datas);
                rejected_data(datas);
                $('#count').html(datas.data.length);
                var html = '';
                console.log("datas",datas);
                datas.data.forEach(function(item,index){
                    arr_all.push(item.employee_code);
                        html += '<tr>'
                        html += `<td>${item.employee_code}</td>`
                        html += `<td>${item.employee_name}</td>`
                        html += `<td>${item.employee_mobile_number}</td>`
                        html += `<td>${item.employee_email_id }</td>`
                        html += `<td>${item.state_name }</td>`
                        html += `<td>${item.region }</td>`
                        html += `<td>${item.employee_area }</td>`
                        // if (item.delete_status == '2') {
                        //   html += `<option data-status_val = '0' value="complited${item.delete_status}">Approved</option>`
                        // }
                        html += `<td>
                                <select class="select__status" name="" data-emp_token='${item.employee_token}' data-status_token='${item.delete_status}' id="all_change_status">
                                <option data-all_status_val='1' value='complited${item.delete_status}' ${item.delete_status === '1' ? 'selected' : ''}>Approved</option>
                                <option data-all_status_val='0' value='Pending${item.delete_status}' ${item.delete_status === '0' ? 'selected' : ''}>Pending</option>
                                <option data-all_status_val='2' value='reject${item.delete_status}' ${item.delete_status === '2' ? 'selected' : ''}>Rejected</option>
                                </select>
                            </td>`
                            html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                        html +='</tr>'
                });
                $("#all_data_dis").html(html);
                table = $("#all_table_data").DataTable({
                                    "scrollX": true,
                                    dom: 'Bfrtip',
                                    "ordering": false,
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
            $(".se-pre-con").hide();
        })
            //All drop down work
            $(document).on("change","#all_change_status",function(){
                        var status_token = $('option:selected',this).attr('data-all_status_val');
                        console.log('status_token',status_token);
                        var distributor_token = $(this).attr('data-emp_token'); 
                        var data = {
                            type : "status_updated",
                            status_token : status_token,
                            distributor_token : distributor_token,
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/admin/serverEmployeeApprovedList.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.code == 200){ 
                                $(".se-pre-con").hide();
                                swal("Status Updated Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });    
                });

                $(document).on('click','#all_btn',function(){
                    //var rowCount = $('#all_data_dis tr').length;
                    $("#count").html(arr_all.length);
                });


                $(document).on('click','#Pending_btn',function(){
                    //var rowCount = $('#emp_data tr').length;
                    $("#count").html(arr_pending.length);
                });

                var arr_pending = [];
        function pending_data(datas){
            //console.log('hekk',datas);
                        var html = '';
                        datas.data.forEach(function(item,index){
                            console.log('status',item.delete_status);
                            if (item.delete_status=='0') {
                                arr_pending.push(item.delete_status)
                                html += '<tr>'
                                html += `<td>${item.employee_code}</td>`
                                html += `<td>${item.employee_name}</td>`
                                html += `<td>${item.employee_mobile_number}</td>`
                                html += `<td>${item.employee_email_id }</td>`
                                html += `<td>${item.state_name }</td>`
                                html += `<td>${item.region }</td>`
                                html += `<td>${item.employee_area }</td>`
                                
                                html += `<td>
                                        <select class="select__status" name="" data-emp_token='${item.employee_token}' data-status_token='${item.delete_status}' id="pending_change_status">
                                        <option data-pending_status_val = '1' value="complited${item.delete_status}">Approved</option>
                                        <option data-pending_status_val = '0' value="Pending${item.delete_status}" selected>Pending</option>
                                        <option data-pending_status_val = '2' value="reject${item.delete_status}">Rejected</option>
                                        </select>
                                    </td>`
                                    html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                                html +='</tr>'
                            }
                       
                });
                $("#emp_data").html(html);
                table = $("#emp_table_data").DataTable({
                                    "scrollX": true,
                                    "ordering": false,
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

                                $(".se-pre-con").hide();
                                //console.log('new_bending',);
            
        }
    
         //pending drop down work
        $(document).on("change","#pending_change_status",function(){
                        var status_token = $('option:selected',this).attr('data-pending_status_val');
                        console.log('status_token',status_token);
                        var distributor_token = $(this).attr('data-emp_token'); 
                        var data = {
                            type : "status_updated",
                            status_token : status_token,
                            distributor_token : distributor_token,
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/admin/serverEmployeeApprovedList.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.code == 200){ 
                                $(".se-pre-con").hide();
                                swal("Status Updated Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });    
                });
                $(document).on('click','#approved_btn',function(){
                    //var rowCount = $('#Approved_data_dis tr').length;
                    $("#count").html(arr_approved.length);
                });
                var arr_approved = [];
        function approved_data(datas){
            $('#count').html(datas.data.length);
                        var html = ''
                        datas.data.forEach(function(item,index){
                            if (item.delete_status=='1') {
                                arr_approved.push(item.delete_status)
                        html += '<tr>'
                        html += `<td>${item.employee_code}</td>`
                        html += `<td>${item.employee_name}</td>`
                        html += `<td>${item.employee_mobile_number}</td>`
                        html += `<td>${item.employee_email_id }</td>`
                        html += `<td>${item.state_name }</td>`
                        html += `<td>${item.region }</td>`
                        html += `<td>${item.employee_area }</td>`
                        html += `<td>
                                <select class="select__status" name="" data-emp_token='${item.employee_token}' data-status_token='${item.delete_status}' id="approved_change_status">
                                <option data-approved_status_val = '1' value="complited${item.delete_status}" selected>Approved</option>
                                <option data-approved_status_val = '0' value="Pending${item.delete_status}">Pending</option>
                                <option data-approved_status_val = '2' value="reject${item.delete_status}">Rejected</option>
                                </select>
                            </td>`
                            html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                        html +='</tr>'
                            }
                });
                $("#Approved_data_dis").html(html);
                table = $("#approved_table_data").DataTable({
                                    "scrollX": true,
                                    "ordering": false,
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
                                $(".se-pre-con").hide();
        }

         //approved drop down work
         $(document).on("change","#approved_change_status",function(){
                        var status_token = $('option:selected',this).attr('data-approved_status_val');
                        console.log('status_token',status_token);
                        var distributor_token = $(this).attr('data-emp_token'); 
                        var data = {
                            type : "status_updated",
                            status_token : status_token,
                            distributor_token : distributor_token,
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/admin/serverEmployeeApprovedList.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.code == 200){ 
                                $(".se-pre-con").hide();
                                swal("Status Updated Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });    
                });
                $(document).on('click','#Rejected_btn',function(){
                    //var rowCount = $('#Rejected_data_dis tr').length;
                    $("#count").html(arr_rejected.length);
                });
                var arr_rejected = [];
        function rejected_data(datas){
            $('#count').html(datas.data.length);
                        var html = ''
                        datas.data.forEach(function(item,index){
                            if (item.delete_status=='2') {
                                arr_rejected.push(item.delete_status);
                            html += '<tr>'
                            html += `<td>${item.employee_code}</td>`
                            html += `<td>${item.employee_name}</td>`
                            html += `<td>${item.employee_mobile_number}</td>`
                            html += `<td>${item.employee_email_id }</td>`
                            html += `<td>${item.state_name }</td>`
                            html += `<td>${item.region }</td>`
                            html += `<td>${item.employee_area }</td>`
                            html += `<td>
                                    <select class="select__status" name="" data-emp_token='${item.employee_token}' data-status_token='${item.delete_status}' id="rejected_change_status">
                                    <option data-rejected_status_val = '1' value="complited${item.delete_status}">Approved</option>
                                    <option data-rejected_status_val = '0' value="Pending${item.delete_status}">Pending</option>
                                    <option data-rejected_status_val = '2' value="reject${item.delete_status}" selected>Rejected</option>
                                    </select>
                                </td>`
                                html += `<td> <a onclick="showeditehadler()"><img src="assets/edit.png" data-emp_token = '${item.employee_token}' class="edit_input employee_code_edit" alt="" /></a></td>`
                            html +='</tr>'
                        }
                });
                $("#Rejected_data_dis").html(html);
                table = $("#rejected_table_data").DataTable({
                                    "scrollX": true,
                                    "ordering": false,
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
                                $(".se-pre-con").hide();
        }
            //rejected drop down work
            $(document).on("change","#rejected_change_status",function(){
                        var status_token = $('option:selected',this).attr('data-rejected_status_val');
                        console.log('status_token',status_token);
                        var distributor_token = $(this).attr('data-emp_token'); 
                        var data = {
                            type : "status_updated",
                            status_token : status_token,
                            distributor_token : distributor_token,
                        }
                        var json_data = JSON.stringify(data);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url : api_path+"/admin/serverEmployeeApprovedList.php",
                            data: json_data, 
                        }).done(function(msg_data){
                            if(msg_data.code == 200){ 
                                $(".se-pre-con").hide();
                                swal("Status Updated Successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                                });  
                            }     
                        });    
                });

                    //--------EDIT DISTRIBUTOR

             $(document).ready(function() {
                 //------- DIVISION
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
                    console.log('only',datas);
                    var data = datas.data;
                    var html_text = '';
                        html_text += '<option class="all" value="all">Select All Division</option>';
                    for (var key in data) {
                        html_text += '<option value="' + data[key].division_token + '">' + data[key].division_name + '</option>';
                        
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
                        //------------- STATE
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: api_path + "/admin/state_list.php",
                }).done(function(datas){
                    console.log('datas',datas);
                let data = datas;
                let html_text="";
                    for (let key in data) {
                        html_text += `<li class="custom-nav__item" data-id="${data[key].state_token}"><a href="#" data-toggle="tab">${data[key].state_name}</a></li>`;
                    }
                    $('#stateList').html(html_text);
                    $(".statewise li").on("click", function(){
                    admin_state_id = 0?0:$(this).data("id");
                    table.clear();
                    table.destroy();
                    data_fetch();
                });
                            //-------------- REGION
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
                            html_text1 += '<option id="user_region" value="' + data[key].region_token + '">' + data[key].region_name + '</option>';
                        }
                        $("#add_employee_region").append(html_text1);
                        $("#edit_employee_region").append(html_text1);


                        
                            var stateList = datas.data_state;
                                console.log('stateList',stateList);
                            var state_html = '';
                                if(stateList.length == 1){
                                    state_html += '<input class="input-field" id="state" value="'+stateList[0].state_name+'" readonly>';
                                    state_html += '<input type="hidden" class="input-field" id="add_employee_state" value="'+stateList[0].state_token+'">';
                                }else{
                                    state_html += '<select class="input-field" id="add_employee_state">';
                                            state_html += '<option value="">Select state</option>';
                                            for(var key in stateList){
                                            state_html += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                                            }
                                    state_html += '</select>'; 
                                }
                            $(".add_employee_state_box").append(state_html);
                            var edit_state_html = '';
                                if(stateList.length == 1){
                                    edit_state_html += '<input class="input-field" id="edit_state" value="'+stateList[0].state_name+'" readonly>';
                                    edit_state_html += '<input type="hidden" class="input-field" id="edit_employee_state" value="'+stateList[0].state_token+'">';
                                }else{
                                    edit_state_html += '<select class="input-field" id="edit_employee_state">';
                                            edit_state_html += '<option value="">Select state</option>';
                                            for(var key in stateList){
                                            edit_state_html += '<option value="'+stateList[key].state_token+'">'+stateList[key].state_name+'</option>';  
                                            }
                                    edit_state_html += '</select>'; 
                                }
                            $(".edit_employee_state_box").append(edit_state_html);
                    });

                });
            });  

        $(document).on('click','.employee_code_edit',function(){
            var token = $(this).attr('data-emp_token');
                // console.log('this ',token);
                edit_employee(token);
            });

            function edit_employee(token) {
                $(".se-pre-con").show();
                var datas = {
                    //dashboard_code: verfication_code,
                    type: "single",
                    employee_token: token
                };
                var json_data = JSON.stringify(datas);
                console.log('json_data',json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/serverEmployeeApprovedList.php",
                    data: json_data,
                }).done(function(data) {
                    var area_dropdown='';
                   console.log(data);
                    var emp_data = data.data;
                    //console.log(emp_data);
                   
                    $("#edit_employee_token").val(emp_data[0].employee_token);
                    $("#edit_employee_name").val(emp_data[0].employee_name);
                    $("#edit_employee_mobilenumber").val(emp_data[0].employee_mobile_number);
                    $("#edit_employee_joindate").val(emp_data[0].employee_join_date);
                    $("#edit_employee_department").val(emp_data[0].employee_deparment_token);
                    $("#edit_employee_email_id").val(emp_data[0].employee_email_id);
                    $("#edit_employee_license_number").val(emp_data[0].employee_license_number);
                    $("#edit_employee_address").val(emp_data[0].employee_address);
                    $("#edit_employee_area").val(emp_data[0].employee_area);
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
                    } else if(extension == "pdf"){
                        $("#edit_address_proof1_url_image").attr("src", "");
                        $("#edit_address_proof1_url_image").css("display", "none");
                        $("#edit_address_proof1_url_pdf").attr("src", emp_data[0].employee_address_proof);
                        $('#edit_address_proof1_upload').after('<p class="reupload">Reupload</p>');
                    }else{
                        $("#edit_address_proof1_url_pdf").css("display", "none");
                        $("#edit_address_proof1_url_image").attr("src", emp_data[0].employee_address_proof);
                        $('#edit_address_proof1_upload').after('<p class="reupload">Reupload</p>');
                    }
                    $("#edit_address_proof1_valid").val(emp_data[0].employee_address_proof);
                    var array = emp_data[0].employee_division;
                    console.log('array',array);
                    $("#edit_employee_division").val(array);
                    $('#edit_employee_division').not('.manual').select2();
                    var proof_array = emp_data[0].employee_attachment;
                    var slno = 2;
                    for (var key in proof_array) {
                        $("#edit_address_proof" + slno + "_upload").next(".reupload").remove();
                        var attachemntImageURL = proof_array[key].attachment;
                        var attachmentExtension = attachemntImageURL.split(".").pop();
                        $("#edit_address_proof" + slno + "_valid_id").val(proof_array[key].attachment_id);
                        $("#edit_address_proof" + slno + "_valid").val(proof_array[key].attachment);
                        if(attachmentExtension == "pdf"){
                           $("#edit_address_proof" + slno + "_url_image").attr("src", "");
                           $("#edit_address_proof" + slno + "_url_image").css("display", "none");
                           $("#edit_address_proof" + slno + "_url_pdf").css("display", "block");
                           $("#edit_address_proof" + slno + "_url_pdf").attr("src", proof_array[key].attachment);
                           $("#edit_address_proof" + slno + "_upload").after('<p class="reupload">Reupload</p>');
                        }else{
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

                    var area_token = emp_data[0].employee_area;
                    var data1={
                              "area_token":area_token
                             }
                    var json_data = JSON.stringify(data1);
                    console.log(json_data);
                    $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/get_employee_area.php",
                            data: json_data,
                    }).done(function(data){
                        var edit_insert_area="";
                        data.forEach(function(item,index){
                                console.log(item.employee_area_name);
                               edit_insert_area += `<option  value="${item.employee_area_token}">${item.employee_area_name}</option>`;
                                
                    });
                    $("#edit_employee_area").append(edit_insert_area);
                });
                

                            $("#edit_employee_area").empty();
                        var region_token =$("#edit_employee_region").val();

                                        var data={
                                            "region_token":region_token
                                        }
                                        var json_data = JSON.stringify(data);
                                        console.log(json_data);
                                        $.ajax({
                                            type: "POST",
                                            dataType: "json",
                                            url: api_path + "/admin/select_employee_area.php",
                                            data: json_data,
                                        }).done(function(response){
                                            var edit_insert_area='';
                                            response.area_data.forEach(function(item,index){
                                            edit_insert_area += `<option  id="area_drop" value="${item.area_token}">${item.area_name}</option>`;  
                                        });
                                            $("#edit_employee_area").append(edit_insert_area);
                                    });
                       
                   
                                                
                                    //     $('#edit_employee_area').change(function() {
                                    //        $(this).data('clicked', true);
                                    //     // if ($("#edit_employee_area").data('clicked')) {
                                    //     //     $("#edit_employee_area").empty();
                                    //     // }
                                        
                                    //     $("#edit_employee_area").empty();
                                    //         //$("#edit_employee_area").append(edit_insert_area);
                                    // });

                                   // $("#edit_employee_area").empty();

                // # EDITE REGION CHANGE ==========
                                     $(document).ready(function(){
                                            // $("#edit_employee_area").change(function(){
                                            //     alert("hi");
                                            // });

                                    $('#edit_employee_region').change(function(){

                                        //$("#edit_employee_area").empty();
                                            var region_token =$(this).find(':selected').val()

                                        var data={
                                            "region_token":region_token
                                        }
                                        var json_data = JSON.stringify(data);

                                        $.ajax({
                                            type: "POST",
                                            dataType: "json",
                                            url: api_path + "/admin/select_employee_area.php",
                                            data: json_data,

                                            success:function(response){
                                        $("#edit_employee_area").empty();
                                        var edit_insert_area='';
                                        edit_insert_area += '<option  value="">Select Area</option>';
                                        response.forEach(function(item,index){
                                                
                                                //if (item.area_token == item.area_token) {
                                                    
                                                    // $("#area_drop").remove("#area_drop")
                                                    edit_insert_area += `<option  id="area_drop" value="${item.area_token}">${item.area_name}</option>`;
                                                
                                        });
                                        $("#edit_employee_area").append(edit_insert_area);
                                            // $("#edit_employee_area").empty();
                                            //  $("#edit_employee_area").append(insert_area);
                                                // $("#add_employee_area").add("#add_employee_area");
                                    }
       
                           });
    
                    });

                                        
                                      });

                                        
               
                                      
                });
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
               
                if (val1 == true && val3 == true && val7 == true && val8 == true && val10 == true && val11 == true && val12 == true && val13 == true &&  val14 == true  &&  val15 == true && val16 == true && val17 == true) {
                    $('#update_employee_button').prop('disabled', true);
                    $(".se-pre-con").show();
                    edit_image_upload_loop(0);
                } else {
                    swal("Please enter all details!");
                }
            }
            var edit_image_id = ['edit_employee_image', 'edit_address_proof1', 'edit_address_proof2', 'edit_address_proof3', 'edit_address_proof4', 'edit_address_proof5']

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
                var datas = {
                    'employee_token': employee_token,
                    'employee_name': employee_name,
                    'employee_number': employee_number,
                    'employee_joindate': employee_joindate,
                    'employee_department': employee_department,
                    'employee_email_id': employee_email_id,
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
                    'employee_license_number': employee_license_number,
                    'dashboard_code': verfication_code,
                    'employee_region': employee_region,
                    'employee_state':employee_state
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
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
        //             case 'complited0':
        //                 bgColor = '#11a14a';
        //                 color = '#fff';
        //                 break;
                        
        //             case 'Pending1':
        //                 bgColor = '#d0893a';
        //                 color = '#fff';
        //                 break;
        //             case 'reject2':
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
mysqli_close($link);
?>
