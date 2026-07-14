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
    <title>Power Soaps </title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/employee.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
        <!-- playground-hide -->
    <script>
      const process = { env: {} };
      process.env.GOOGLE_MAPS_API_KEY =
        "AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00";
    </script>
</head>
<style>
  #blockedemployee{
    background-color:#ff9d87;
  }
</style>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <div class="se-pre-con"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar3"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="employee" >
            <div class="product_header_container">
                <div class="header-details ">
                    <h1 class="header_main"><span data-i18n="employees_list">Employees List</span> <span class="total_emp"><span data-i18n="total_employees">Total Employees</span> -<span id="total_employee_count"></span></span></h1>
                </div>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                <li class="nav-item " role="presentation">
                <button onclick="show_employee()" class=" empshow nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span><img class="icon_add" src="assets/icons/add_employee.svg" alt=""></span><span data-i18n="add_employee">Add Employee</span></button>
                </li>
                <li class="nav-item">
                    <button class="nav-link upload_csv_btn" type="button" data-toggle="modal" data-target="#myModal" data-i18n="upload_csv">Upload CSV</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link btn_employees sample_csv_btn" type="button"><a class="a_button" href="assets/csv/sampleEmployeeCsv.csv" download data-i18n="sample_csv_file">Sample CSV File</a></button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent" >
                <div class="tab-pane active fade show" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="table-box">
                        <table class="custom-table" id="table_data">
                            <thead>
                                <tr>
                                    <th data-i18n="sl_no">Sl No</th>
                                    <th data-i18n="employee_code">Employee Code</th>
                                    <th data-i18n="employee_name">Employee Name</th>
                                    <th data-i18n="department">Department</th>
                                    <th data-i18n="mobile_number">Mobile Number</th>
                                    <th data-i18n="email_address">Email Address</th>
                                    <th data-i18n="joining_date">Joining Date</th>
                                    <th data-i18n="date_of_birth">Date Of Birth</th>
                                    <th data-i18n="track_location">Track Location</th>
                                    <th data-i18n="view_log">View Log</th>
                                    <th data-i18n="action">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_body_id">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div id="payments" class="table-box w3-border city" >
                        <div class="table-box">
                            <table class="custom-table" id="dataTables_filter">
                                <thead>
                                    <tr>
                                        <th>SI.No</th>
                                        <th>Date & Time</th>
                                        <th>Mode</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>06/25/2022 <span>11:48 PM</span></td>
                                        <td>Cash</td>
                                        <td>Rs.1000</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>06/03/2022 <span>07:48 PM</span></td>
                                        <td>Cheque</td>
                                        <td>Rs.2,285</td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-white brad-4 full-height" id="employee_add" style="display: none;">
            <div class="header_container" >
                <div class="header-section">
                    <div class="inventory-top">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_add_employee()" alt=""> <span data-i18n="add_new_employee">Add New Employee</span></span></h1>
                    </div>
                </div>
                <div class="add_new_top">
                    <div class="col-lg-2 col-md-12 col-sm-6 col-xs-12">
                        <label class="upload_label" for="employee_image_upload">
                            <div class="upload_file">
                                <img class="uploadimg" id="employee_view_image_url" alt="" src="assets/upload.png">
                                <input id="employee_image_valid" type="hidden" >    
                                <input id="employee_image_upload" onchange="file_upload('employee_image','employee_view_image_url','assets/upload.png')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form  class="forms">
                            <div class="form-control add_employee_name_box">
                                <p class="add_employee_name"><span data-i18n="employee_name">Employee Name</span> <span id="mandatory_icon">*</span></p>
                                <input class="input-field" id="add_employee_name" placeholder="Please Enter Name" data-i18n-placeholder="enter_name">
                            </div>   
<!--
                             <div class="form-control add_employee_code_box">
                                <p class="add_employee_code">Employee Code</p>
                                <input class="input-field" id="add_employee_code" placeholder="Please Enter code">
                            </div> 
-->
                             <div class="form-control add_employee_mobilenumber_box">
                                <p class="add_employee_mobilenumber"><span data-i18n="mobile_number">Mobile Number</span> <span id="mandatory_icon">*</span></p>
                                <input class="input-field" id="add_employee_mobilenumber" placeholder="Please Enter Mobilenumber" onkeypress="return isNumber(event)" data-i18n-placeholder="enter_mobile">
                            </div> 
                            <div class="rate">
                                <div class="rates add_employee_joindate_box">
                                     <input class="form-control box_form" name="date" id="add_employee_joindate" type="text"  placeholder="Joining Date" readonly data-i18n-placeholder="joining_date"> 
                                </div>
                                <div class="rates add_employee_dob_box">
                                    <input class="form-control box_form" name="date" id="add_employee_dob" type="text" placeholder="Date of Birth"  readonly data-i18n-placeholder="date_of_birth">     
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form class="form">
                        <div class="radio_field">
                            <h4 data-i18n="gender">Gender</h4>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="male" value="Male" name="gender" class="custom-control-input" checked>
                                <label class="custom-control-label" for="male" data-i18n="male">Male</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="female" value="Female" name="gender" class="custom-control-input">
                                <label class="custom-control-label" for="female" data-i18n="female">Female</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="others" value="Other" name="gender" class="custom-control-input">
                                <label class="custom-control-label" for="others" data-i18n="other">Other</label>
                            </div>
                        </div> 
                        <div class="form-control add_employee_department_box">
                            <p class="add_employee_department"><span data-i18n="department">Department</span> <span id="mandatory_icon">*</span></p>
                             <select class="input-field" id="add_employee_department">
                                 <option value="" data-i18n="select_department">Select Department</option>
                                 <option value="93402780">Delivery</option>
                                 <option value="45916684">Sales</option>
                             </select>
                        </div>
                        <div class="form-control add_employee_email_id_box">
                            <p class="add_employee_email_id" data-i18n="email_address">Email Address</p>
                            <input class="input-field" id="add_employee_email_id" placeholder="Enter email address" data-i18n-placeholder="email_placeholder">
                        </div>  
                        <div class="rate add_employee_blood_group_box">
                            <div class="rates">
                             <select class="input-field selectbox" id="add_employee_blood_group" >
                                 <option value="" data-i18n="select_blood_group">Select Blood Group</option>
                                 <option value="O+ive">O+ive</option>
                                 <option value="A+ive">A+ive</option>
                                 <option value="B+ive">B+ive</option>
                                 <option value="AB+ive">AB+ive</option>
                                 <option value="A-ive">A-ive</option>
                                 <option value="B-ive">B-ive</option>
                                 <option value="O-ive">O-ive</option>
                                 <option value="AB-ive">AB-ive</option>
                             </select>   
                            </div>   
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bottom_container" >
                <div class="col-lg-12">
                    <h2 class="address" data-i18n="address">Address</h2>
                </div>
                 <div class="add_new_top">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form  class="forms">
                            <div class="form-control add_employee_address_box">
                                <input class="input-field" id="add_employee_address" placeholder="Address" data-i18n-placeholder="address">
                            </div>   
                            <div class="form-control add_employee_city_box">
                                <input class="input-field" id="add_employee_city" placeholder="City" data-i18n-placeholder="city">
                            </div> 
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
                        <form  class="forms">
                            <div class="form-control add_employee_street_box">
                                <input class="input-field" id="add_employee_street" placeholder="Street" data-i18n-placeholder="street">
                            </div>   
                            <div class="form-control add_employee_pincode_box">
                                <input class="input-field" id="add_employee_pincode" placeholder="Pincode" onkeypress="return isNumber(event)" data-i18n-placeholder="pincode">
                            </div> 
                        </form>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <label class="upload_label1" for="address_proof1_upload">
                            <div class="upload_file1 remove_upload_mobile">
                                <img class="uploadimg1" id="address_proof1_image_url" alt="" src="assets/icons/address_proof_upload.svg">
                                <input id="address_proof1_valid" type="hidden" >   
                                <input id="address_proof1_upload" onchange="file_upload('address_proof1','address_proof1_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">    
                            </div>
                        </label>
                    </div>
                </div>
                <div class="add_disp">
                    <div class="text_data remove_upload_mobile">
                        <div class="col-lg-12">
                            <h2 data-i18n="other_attachments">Other attachment :</h2> 
                        </div>
                        <div class="add_new_top">
                            <div class="data_view_image">
                                <label class="upload_label2" for="address_proof2_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" alt="" id="address_proof2_image_url" src="assets/icons/proof1.png">
                                    <input id="address_proof2_valid" type="hidden" >   
                                    <input id="address_proof2_upload" onchange="file_upload('address_proof2','address_proof2_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">    
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="address_proof3_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" id="address_proof3_image_url" alt="" src="assets/icons/proof2.png">
                                    <input id="address_proof3_valid" type="hidden" >   
                                    <input id="address_proof3_upload" onchange="file_upload('address_proof3','address_proof3_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="address_proof4_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" alt="" id="address_proof4_image_url" src="assets/icons/proof3.png">
                                    <input id="address_proof4_valid" type="hidden" >       
                                    <input id="address_proof4_upload" onchange="file_upload('address_proof4','address_proof4_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="address_proof5_upload">
                                    <div class="upload_file1">
                                        <img class="uploadimg1" alt="" id="address_proof5_image_url" src="assets/icons/proof4.png">
                                        <input id="address_proof5_valid" type="hidden" >   
                                        <input id="address_proof5_upload" onchange="file_upload('address_proof5','address_proof5_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button class="btn_product" onclick="add_employee()" id="add_employee_button" data-i18n="add_employee">Add Employee</button>
                </div>
            </div>
        </section>
         <section class="bg-white brad-4 full-height" id="employee_edit" style="display: none;">
            <div class="header_container" >
                <div class="header-section">
                    <div class="inventory-top">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_edit_employee()" alt=""> <span data-i18n="edit_employee">Edit Employee</span></span></h1>
                    </div>
                </div>
                <div class="add_new_top">
                    <div class="col-lg-2 col-md-12 col-sm-6 col-xs-12">
                        <label class="upload_label" for="edit_employee_image_upload">
                            <div class="upload_file">
                                <img class="uploadimg" id="edit_employee_view_image_url" alt="" src="assets/upload.png">
                                <input id="edit_employee_image_valid" type="hidden" >    
                                <input id="edit_employee_image_upload" onchange="file_upload('edit_employee_image','edit_employee_view_image_url','assets/upload.png')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                            </div>
                        </label>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form  class="forms">
                            <input type="hidden" id="edit_employee_token">
                            <div class="form-control edit_employee_name_box">
                                <p class="edit_employee_name" data-i18n="employee_name">Employee Name</p>
                                <input class="input-field" id="edit_employee_name" placeholder="Please Enter Name" data-i18n-placeholder="enter_name">
                            </div>   
<!--
                             <div class="form-control edit_employee_code_box">
                                <p class="edit_employee_code">Employee Code</p>
                                <input class="input-field" id="edit_employee_code" placeholder="Please Enter code">
                            </div> 
-->
                             <div class="form-control edit_employee_mobilenumber_box">
                                <p class="edit_employee_mobilenumber" data-i18n="mobile_number">Mobile Number</p>
                                <input class="input-field numberonly" id="edit_employee_mobilenumber" placeholder="Please Enter Mobilenumber" maxlength="10" data-i18n-placeholder="enter_mobile">
                            </div> 
                              <div class="form-control edit_employee_joindate_box">
                                <p class="edit_employee_joindate" data-i18n="joining_date">Joining Date</p>
                                <input class="input-field box_form" id="edit_employee_joindate" placeholder="Joining Date" maxlength="10" data-i18n-placeholder="joining_date">
                            </div> 
                              <div class="form-control edit_employee_dob_box">
                                <p class="edit_employee_dob" data-i18n="date_of_birth">Date of Birth</p>
                                <input class="input-field box_form" id="edit_employee_dob" placeholder="Date of Birth" maxlength="10" data-i18n-placeholder="date_of_birth">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form class="form">
                            <div class="form-control edit_employee_gender_box">
                                <p class="edit_employee_gender" data-i18n="gender">Gender</p>
                                 <select class="input-field" id="edit_employee_gender">
                                     <option value="" data-i18n="select_gender">Select Gender</option>
                                     <option value="Male" data-i18n="male">Male</option>
                                     <option value="Female" data-i18n="female">Female</option>
                                     <option value="Others" data-i18n="other">Other</option>
                                 </select>
                            </div>
                            <div class="form-control edit_employee_department_box">
                                <p class="edit_employee_department" data-i18n="department">Department</p>
                                 <select class="input-field" id="edit_employee_department">
                                      <option value="93402780" data-i18n="delivery">Delivery</option>
                                      <option value="45916684" data-i18n="sales">Sales</option>
                                 </select>
                            </div>
                            <div class="form-control edit_employee_email_id_box">
                                <p class="edit_employee_email_id" data-i18n="email_address">Email Address</p>
                                <input class="input-field" id="edit_employee_email_id" placeholder="Enter email address" data-i18n-placeholder="email_placeholder">
                            </div> 
                             <div class="form-control edit_employee_blood_group_box">
                                <p class="edit_employee_blood" data-i18n="select_blood_group">Select Blood Group</p>
                                <select class="input-field" id="edit_employee_blood_group">
                                    <option value="" data-i18n="select_blood_group">Select Blood Group</option>
                                    <option value="O+ive">O+ive</option>
                                    <option value="A+ive">A+ive</option>
                                    <option value="B+ive">B+ive</option>
                                    <option value="AB+ive">AB+ive</option>
                                    <option value="A-ive">A-ive</option>
                                    <option value="B-ive">B-ive</option>
                                    <option value="O-ive">O-ive</option>
                                    <option value="AB-ive">AB-ive</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
<!--
                <div class="col-md-10">
                    <form  class="forms">
                        <select id="edit_employee_division"  multiple="multiple"></select>
                    </form>
                </div>
-->
            </div>
            <div class="bottom_container">
                <div class="col-lg-12">
                    <h2 class="address" data-i18n="address">Address</h2>
                </div>
                 <div class="add_new_top">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                        <form  class="forms">
                            <div class="form-control edit_employee_address_box">
                                <input class="input-field" id="edit_employee_address" placeholder="Address" data-i18n-placeholder="address">
                            </div> 
                            <div class="form-control edit_employee_city_box">
                                <input class="input-field" id="edit_employee_city" placeholder="City" data-i18n-placeholder="city">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                        <form  class="forms">
                            <div class="form-control edit_employee_street_box">
                                <input class="input-field" id="edit_employee_street" placeholder="Street" data-i18n-placeholder="street">
                            </div>
                            <div class="form-control edit_employee_pincode_box">
                                <input class="input-field numberonly" id="edit_employee_pincode" maxlength="6" placeholder="Pincode" data-i18n-placeholder="pincode">
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                        <label class="upload_label1 remove_upload_mobile" for="edit_address_proof1_upload">
                            <div class="upload_file1">
                                <img class="uploadimg1" id="edit_address_proof1_image_url" alt="" src="assets/icons/address_proof_upload.svg">
                                <input id="edit_address_proof1_valid" type="hidden" >
                                <input id="edit_address_proof1_upload" onchange="file_upload('edit_address_proof1','edit_address_proof1_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                            </div>
                        </label>
                    </div>
                </div>
                <div class="add_disp">
                    <div class="text_data remove_upload_mobile">
                        <div class="col-lg-12">
                            <h2 data-i18n="other_attachments">Other attachment :</h2> 
                        </div>
                        <div class="add_new_top">
                            <div class="data_view_image">
                                <label class="upload_label2" for="edit_address_proof2_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" alt="" id="edit_address_proof2_image_url" src="assets/icons/proof1.png">
                                    <input id="edit_address_proof2_valid_id" type="hidden">
                                    <input id="edit_address_proof2_valid" type="hidden" >   
                                    <input id="edit_address_proof2_upload" onchange="file_upload('edit_address_proof2','edit_address_proof2_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">    
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="edit_address_proof3_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" id="edit_address_proof3_image_url" alt="" src="assets/icons/proof2.png">
                                    <input id="edit_address_proof3_valid_id" type="hidden">
                                    <input id="edit_address_proof3_valid" type="hidden" >   
                                    <input id="edit_address_proof3_upload" onchange="file_upload('edit_address_proof3','edit_address_proof3_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="edit_address_proof4_upload">
                                <div class="upload_file1">
                                    <img class="uploadimg1" alt="" id="edit_address_proof4_image_url" src="assets/icons/proof3.png">
                                    <input id="edit_address_proof4_valid_id" type="hidden">
                                    <input id="edit_address_proof4_valid" type="hidden" >       
                                    <input id="edit_address_proof4_upload" onchange="file_upload('edit_address_proof4','edit_address_proof4_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                </div>
                                </label>
                            </div>
                            <div class="data_view_image">
                                <label class="upload_label2" for="edit_address_proof5_upload">
                                    <div class="upload_file1">
                                        <img class="uploadimg1" alt="" id="edit_address_proof5_image_url" src="assets/icons/proof4.png">
                                        <input id="edit_address_proof5_valid_id" type="hidden">
                                        <input id="edit_address_proof5_valid" type="hidden" >   
                                        <input id="edit_address_proof5_upload" onchange="file_upload('edit_address_proof5','edit_address_proof5_image_url','assets/icons/address_proof_upload.svg')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;"> 
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <button class="btn_product" onclick="update_employee()" id="update_employee_button" data-i18n="update_employee">Update Employee</button>
                </div>
            </div>
        </section>
        <section class="bg-white brad-4 full-height twoback" id="employee_view" style="display: none;">
            <div class="header_container mrgzro" >
                <div class="header-section sep_word">
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_employee()" alt=""></span></h1>
                        <div class="de_activate">
                        <a href="#" data-i18n="deactive_employee">Deactive Employee</a>
                        </div>
                </div>
                <div class="add_new_top bot_line inventory-body-section">
                    <div class="inventory-body-left">
                        <div class="upload_files">
                        <img class="uploadimgs" id="single_employee_view_image" alt="" src="">
                        </div>
                    </div>
                    <div class="inventory-body-right">
                        <h2 class="name_box" id="single_employee_name"></h2>
                        <div class="part-card">
                            <div class="part">
                                <div class="codelevel">
                                <p><span data-i18n="gender">Gender</span> : <span id="single_employee_gender"></span></p>
                                <p><span data-i18n="department">Department</span> : <span id="single_employee_department"></span></p>
                                <p><span data-i18n="joining_date">Joining Date</span> : <span id="single_employee_join_date"></span></p>
                            </div>
                        </div>
                        <div class="part">
                            <div class="codelevel">
                                <p><span data-i18n="age">Age</span> : <span id="single_employee_age">34 Years</span></p>
                                <p><span data-i18n="mobile_number">Mobile Number</span> : <span id="single_employee_number"></span></p>
                                <p><span data-i18n="date_of_birth">Date of Birth</span> : <span id="single_employee_dob"></span></p>
                                </div>
                            </div>
                        <div class="part">
                            <div class="codelevel">
                                <p><span data-i18n="employee_code">Employee Code</span> : <span id="single_employee_code"></span></p>
                                <p><span data-i18n="email_address">Email Address</span> : <span id="single_employee_email"></span></p>
                                <p><span data-i18n="blood_group">Blood Group</span> : <span id="single_employee_bloodgroup"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="address_field">
                    <div class="address-inner-set">
                        <div class="address_note">
                            <h2 data-i18n="address">Address :</h2>
                            <p id="single_employee_address"></p>
                        </div>
                    </div>
                    <div class="address-inner-set">
                        <img class="pancard proff-doc" style="max-width: 100px;" id="single_employee_address_proof" alt="" src="">
                    </div>
                </div>
                <div class="attach">
                    <div class="attach-iiner-set">
                        <h2 data-i18n="other_attachments">Other Attachments :</h2>
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
          <h4 class="modal-title" data-i18n="upload_csv_file">Upload CSV File</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <label class="upload_filed" for="csv_file_upload">
                    <input id="csv_file_valid" type="hidden">    
                    <input id="csv_file_upload" onchange="file_upload_csv('csv_file','csv_view_url','assets/upload_csv_done.png')" type="file"  accept=".csv" style="display:none;">
                    <img alt="" src="assets/csvfile.png" class="csvfile" id="csv_view_url"/>
                    <h2 id="csv_file_name" data-i18n="upload_files">Upload Files</h2>
                </label>
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="cancelbtn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
            <button type="button" class="savebtn" id="csv_upload_button" onclick="upload_csv_file()" data-i18n="upload">Upload</button>
        </div>
        
      </div>
    </div>
  </div>

    <div class="modal fade" id="exampleModalMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 data-i18n="view_on_map">View on Map</h2>
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
                                <th data-i18n="sl_no">Sl No</th>
                                <th data-i18n="shop_name">Shop Name</th>
                                <th data-i18n="lat_log">Lat and Log</th>
                                <th data-i18n="time">Time</th>
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

    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->
    <!-- wript src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script><!---- For S3 bucket upload ---->
    <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script> 
    <script>var notiCount = "<?php echo $notiCount; ?>";</script>
    
    <!-- <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script> -->
     <script src="https://cdnjs.cloudflare.com/polyfill/v3/polyfill.min.js?features=default"></script>
    <script src="js/polyfill.min.js<?php echo $js_cache_string; ?>"></script>
    
    
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBnA5GAtJFECfmRwsSWmQ_svQ4sBGFtw00"></script> -->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBbV6guze9AOGJf91eU07rfrrK0qnICW1E&callback=initMap&v=weekly"
      defer
    ></script>
    <script src="https://unpkg.com/@googlemaps/js-api-loader@1.0.0/dist/index.min.js"></script>
<script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    $('#add_employee_joindate,#edit_employee_joindate').datepicker({
        autoclose: true,
        todayHighlight: true,
        maxDate: new Date(),
        changeYear: true,
        yearRange: '1970:2060',
        defaultDate: 'today'
    });
    $('#add_employee_dob,#edit_employee_dob').datepicker({
        autoclose: true,
        todayHighlight: true,
        maxDate: new Date(),
        changeYear: true,
        yearRange: '1950:2010',
        defaultDate: 'today'
    });
    function show_employee(){
        $('#employee_add').show();
        $('#employee').hide(); 
    }
    function back_view_employee(){
        $('#employee').show();
        $('#employee_view').hide();
    }
     function back_add_employee(){
        $('#employee').show();
        $('#employee_add').hide();
    }
    function back_edit_employee(){
        $('#employee').show();
        $('#employee_edit').hide();
    }
    /* Radion button box */ 
    $('.ratio-btn-selecter').on('click',function(){
        var quickcheck = $(this).attr('data-value');
        if(quickcheck == "image"){
           $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
           $('.popup-image-box').removeClass('hidden');
           $('.popup-video-box').addClass('hidden');
        }else{
          $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
          $('.popup-image-box ').addClass('hidden');
          $('.popup-video-box').removeClass('hidden');
       }
    });

    var verfication_code = "<?php echo $verification_code; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token']; ?>";
    var api_path = "<?php echo $api_path; ?>";
    $(document).ready(function () {
      $("#add_employee_mobilenumber,#edit_employee_mobilenumber").attr("maxlength", "10");
      $("#add_employee_pincode,#edit_employee_pincode").attr("maxlength", "6");
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/employeeDetails.php",
            data: json_data,
            success: success,
        });
    });
    var table_main_data;
    function success(data) {
        table_main_data = data.data;
        console.log('table_main_data',table_main_data);
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
            slno++;
            if(table_main_data[key].blockStatus=='2'){
                      var gh='blockedemployee';
                }
                else{
                    var gh='';
                }
            html_text += `<tr id='${gh}'>`;
                html_text += '<td>'+slno+'</td>';
                
                
                html_text += '<td><a href="javascript:void(0);" class="view_link" onclick="view_employee('+key+')">'+table_main_data[key].employee_code+'</a></td>';

                html_text += '<td>'+table_main_data[key].employee_name+'</td>';
                html_text += '<td>'+table_main_data[key].employee_deparment_name+'</td>';
                html_text += '<td>'+table_main_data[key].employee_mobile_number+'</td>';
                if (table_main_data[key].employee_email_id =='') {
                    html_text += '<td>'+'-'+'</td>';
                }else{
                    html_text += '<td>'+table_main_data[key].employee_email_id+'</td>';
                }
                if (table_main_data[key].employee_join_date == "01/01/1970") {
                    html_text += '<td>'+'-'+'</td>';
                }else{
                    html_text += '<td>'+table_main_data[key].employee_join_date+'</td>';
                }
                if (table_main_data[key].employee_dob == "01/01/1970") {
                    html_text += '<td>'+'-'+'</td>';
                }else{
                    html_text += '<td>'+table_main_data[key].employee_dob +'</td>';
                }


               
                html_text += '<td><a href="javascript:void(0);" class="view_link" data-toggle="modal" data-target="#exampleModalMap" onclick="view_Location('+table_main_data[key].employee_token+')">View Location</a></td>';
                html_text += '<td><a href="javascript:void(0);" class="view_link" data-toggle="modal" data-target="#table_modal" onclick="view_log('+key+')">View Log</a></td>';
                html_text += '<td><a><img src="assets/edit.png" class="edit_input" onclick="edit_employee('+key+')" alt=""></a></td>';
            html_text += '</tr>';
        }
        
        $("#table_body_id").html(html_text);
        key++;
        $("#total_employee_count").html(key);
        table = $("#table_data").DataTable({
            scrollX: true,
            dom: 'Bfrtip',
            buttons: [
            ],
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
        $(".se-pre-con").hide();
    }
    function view_employee(key){
         $(".se-pre-con").show();
        var datas = {
            dashboard_code: verfication_code,
            type: "single",
            employee_token: table_main_data[key].employee_token,
            distributor_token:distributor_token
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/employeeDetails.php",
            data: json_data,
        }).done(function(data) {
            var emp_data = data.data;
            $("#single_employee_name").html(emp_data[0].employee_name);
            $("#single_employee_gender").html(emp_data[0].employee_gender);
            $("#single_employee_department").html(emp_data[0].employee_deparment_name);
            $("#single_employee_join_date").html(emp_data[0].employee_join_date);
            $("#single_employee_age").html(emp_data[0].employee_age);
            $("#single_employee_number").html(emp_data[0].employee_mobile_number);
            $("#single_employee_dob").html(emp_data[0].employee_dob);
            $("#single_employee_code").html(emp_data[0].employee_code);
            $("#single_employee_email").html(emp_data[0].employee_email_id);
            $("#single_employee_bloodgroup").html(emp_data[0].employee_blood_group);
            $("#single_employee_address").html(emp_data[0].employee_address);
            $("#single_employee_view_image").attr("src",emp_data[0].profile_image);
            $("#single_employee_address_proof").attr("src",emp_data[0].employee_address_proof);
            var html = "";
            var attachement_data = emp_data[0].employee_attachment;
            for (var key1 in attachement_data) {
                html += '<img src="'+attachement_data[key1].attachment+'" alt="">';
            }
            if(emp_data[0].block_status==1){
                $(".de_activate").html('<a class="view_link" onclick="deactivate('+key+')">Deactivate Employee</a>');
                $(".de_activate > a").css('color','red');
                $(".de_activate > a").css('text-decoration','underline');
            }else{
                $(".de_activate").html('<a class="view_link" onclick="activate('+key+')">Activate Employee</a>');
                $(".de_activate > a").css('color','green');
                $(".de_activate > a").css('text-decoration','underline');
            }

            $("#single_other_attachement").html(html);
             $(".se-pre-con").hide();
            $('#employee_view').show();
            $('#employee').hide();
        });
    }  
    function add_employee(){
        var employee_name  = $("#add_employee_name").val();
        var val1           = value_check('add_employee_name',employee_name,'text_box');
        var employee_number= $("#add_employee_mobilenumber").val();
        var val3           = value_check('add_employee_mobilenumber',employee_number,'mobile','Mobile Number *');
        var employee_joindate= $("#add_employee_joindate").val();
        var employee_dob   = $("#add_employee_dob").val();
        var employee_department= $("#add_employee_department").val();
        var val6           = value_check('add_employee_department',employee_department,'text_box');
        var employee_email_id= $("#add_employee_email_id").val();
        var employee_blood_group= $("#add_employee_blood_group").val();
        var employee_address= $("#add_employee_address").val();
        var employee_city  = $("#add_employee_city").val();
        var employee_street= $("#add_employee_street").val();
        var employee_pincode= $("#add_employee_pincode").val();
        var employee_image  = $("#employee_image_valid").val();
        var address_proof1  = $("#address_proof1_valid").val();
        var address_proof2  = $("#address_proof2_valid").val();
        var address_proof3  = $("#address_proof3_valid").val();
        var address_proof4  = $("#address_proof4_valid").val();
        var address_proof5  = $("#address_proof5_valid").val();
        if(val1==true && val3==true && val6==true){ 
            $('#add_employee_button').prop('disabled', true);
            image_upload_loop(0);
        }else{     
            swal("Please enter mandatory details!");
        }
    }
    var image_id = ['employee_image','address_proof1','address_proof2','address_proof3','address_proof4','address_proof5']
    function image_upload_loop(key){
        var valid  = $("#"+image_id[key]+"_valid").val();
        var checkkey = key+1;
        if(checkkey>image_id.length){
           add_employee_finish();
        }else{
            if(valid=="true"){
                var fileUpload = document.getElementById(image_id[key]+"_upload");
                var file = fileUpload.files[0];
                s3_file_upload(file, key);
            }else{
                $("#"+image_id[key]+"_valid").val(valid);
                key++;
                image_upload_loop(key);
            }
        }
    }
    function add_employee_finish(){
        var employee_name  = $("#add_employee_name").val();
        var employee_number= $("#add_employee_mobilenumber").val();
        var employee_joindate= $("#add_employee_joindate").val();
        var employee_dob   = $("#add_employee_dob").val();
        var employee_department= $("#add_employee_department").val();
        var employee_email_id= $("#add_employee_email_id").val();
        var employee_blood_group= $("#add_employee_blood_group").val();
        var employee_address= $("#add_employee_address").val();
        var employee_city  = $("#add_employee_city").val();
        var employee_street= $("#add_employee_street").val();
        var employee_pincode= $("#add_employee_pincode").val();
        var employee_image  = $("#employee_image_valid").val();
        var address_proof1  = $("#address_proof1_valid").val();
        var address_proof2  = $("#address_proof2_valid").val();
        var address_proof3  = $("#address_proof3_valid").val();
        var address_proof4  = $("#address_proof4_valid").val();
        var address_proof5  = $("#address_proof5_valid").val();
        var gender          = $('input[name="gender"]:checked').val();
        
        var datas ={
            'employee_name':employee_name,
            'employee_number':employee_number,
            'employee_joindate':employee_joindate,
            'employee_dob':employee_dob,
            'employee_department':employee_department,
            'employee_email_id':employee_email_id,
            'employee_blood_group':employee_blood_group,
            'employee_address':employee_address,
            'employee_city':employee_city,
            'employee_street':employee_street,
            'employee_pincode':employee_pincode,
            'employee_image':employee_image,
            'address_proof1':address_proof1,
            'address_proof2':address_proof2,
            'address_proof3':address_proof3,
            'address_proof4':address_proof4,
            'address_proof5':address_proof5,
            'gender':gender,
            'dashboard_code':verfication_code,
            'distributor_token':distributor_token,
            'type':'AddEmployee'
        }
        var json_data = JSON.stringify(datas);
        console.log(json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/addEmployee.php",
            data: json_data,
        }).done(function(data) {
            if(data.code=="201"){
                 swal("Employee Added Successfully!", {icon: "success",}).then((value) => {
                location.reload();
            });
            }else{
                $('#add_employee_button').prop('disabled', false);
                swal(data.message);
            }
        });

    }
    function deactivate(key){
        swal({
            title: "Are you sure?",
            text: "You want to deactivate this employee?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var datas ={
                    'employee_token':table_main_data[key].employee_token,
                    'employee_status':2,
                    'dashboard_code':verfication_code
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url : api_path+"/distributor/employeeStatusChange.php",
                    data: json_data,
                }).done(function(data) {
                    if(data.code==503){
                        swal("Something happened!");
                    }else if(data.code==201){
                        swal("Employee deactivated successfully!", {icon: "success",}).then((value) => {
                            view_employee(key);
                        });
                    }
                });
            }
        });
    }
    function activate(key){
        swal({
            title: "Are you sure?",
            text: "You want to activate this employee?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var datas ={
                    'employee_token':table_main_data[key].employee_token,
                    'employee_status':1,
                    'dashboard_code':verfication_code
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url : api_path+"/distributor/employeeStatusChange.php",
                    data: json_data,
                }).done(function(data) {
                    if(data.code==503){
                        swal("Something happened!");
                    }else if(data.code==201){
                        swal("Employee activated successfully!", {icon: "success",}).then((value) => {
                            view_employee(key);
                        });
                    }
                });
            }
        });
    }
    function upload_csv_file(){
         $(".se-pre-con").fadeIn();
        var valid = $('#csv_file_valid').val();
        if(valid=="true" && valid != "" && valid != undefined){
            $('#csv_upload_button').prop('disabled', true);
            var myFormData = new FormData();
            myFormData.append('file_upload', csv_file_upload.files[0]);
            $.ajax({
                dataType: "json",
                url: api_path+"/distributor/uploadEmployeeCsv.php",
                type: 'POST',
                //async: false,
                processData: false, 
                contentType: false,
                data: myFormData,
                success: function(data){
                    if(data.code==503){
                        $('#csv_upload_button').prop('disabled', false);
                        var msg = "";
                        if(data.message != undefined){
                           msg += data.message+ "\n";
                        }
                        if(data.message1 != undefined){
                            msg += data.message1+ "\n";
                        }
                        if(data.message2 != undefined){
                             msg += data.message2;  
                        }
                        if(msg != ''){
                            $(".se-pre-con").fadeOut();
                           swal(msg).then((value) => {
                            location.reload();
                        });
                        }

                    }else if(data.code==201){
                        $(".se-pre-con").fadeOut();
                        swal("Csv data uploaded successfully!", {icon: "success",}).then((value) => {
                            location.reload();
                        });
                    }
                }
            });
        }else{
            $(".se-pre-con").fadeOut();
            swal("Please select a csv file!");
        }
    }    
    $(".cancelbtn").click(function(){
        $("#csv_view_url").attr("src","assets/csvfile.png");
        $("#csv_file_name").text("Upload Files");
        $('#csv_file_valid').val(false);
        $("#csv_file_upload").val('');
    });  
    function edit_employee(key){
            $(".se-pre-con").show();
            $("#edit_employee_token").val(table_main_data[key].employee_token);
            $("#edit_employee_name").val(table_main_data[key].employee_name);
            $("#edit_employee_mobilenumber").val(table_main_data[key].employee_mobile_number);
            $("#edit_employee_joindate").val(table_main_data[key].employee_join_date);
            $("#edit_employee_dob").val(table_main_data[key].employee_dob);
            $("#edit_employee_gender").val(table_main_data[key].gender);
            $("#edit_employee_department").val(table_main_data[key].deparment_token);
            $("#edit_employee_email_id").val(table_main_data[key].employee_email_id);
            $("#edit_employee_blood_group").val(table_main_data[key].blood_group);
            $("#edit_employee_address").val(table_main_data[key].address);
            $("#edit_employee_city").val(table_main_data[key].city);
            $("#edit_employee_street").val(table_main_data[key].street);
            $("#edit_employee_pincode").val(table_main_data[key].pincode);
                if(table_main_data[key].employee_image==""){
                    $("#edit_employee_view_image_url").attr("src", "assets/upload.png");
                }else{
                    $("#edit_employee_view_image_url").attr("src", table_main_data[key].employee_image);
                }
            $("#edit_employee_image_valid").val(table_main_data[key].employee_image);
                if(table_main_data[key].address_proof=="" || table_main_data[key].address_proof==null){
                    $("#edit_address_proof1_image_url").attr("src", "assets/icons/address_proof_upload.svg");
                }else{
                    $("#edit_address_proof1_image_url").attr("src", table_main_data[key].address_proof);
                }
            $("#edit_address_proof1_valid").val(table_main_data[key].address_proof);
            var proof_array = table_main_data[key].attachment_image;
            var slno = 2;
                for (var key in proof_array) {
                    $("#edit_address_proof"+slno+"_valid_id").val(proof_array[key].attachment_id);
                    $("#edit_address_proof"+slno+"_valid").val(proof_array[key].attachment);
                    $("#edit_address_proof"+slno+"_image_url").attr("src", proof_array[key].attachment);
                    slno++;
                }
                for(var i=slno;i<=5;i++){
                    var j = parseInt(i)-1;
                    $("#edit_address_proof"+i+"_valid_id").val('');
                    $("#edit_address_proof"+i+"_valid").val('');
                    $("#edit_address_proof"+i+"_image_url").attr("src", "assets/icons/proof"+j+".png");
                }
            $(".se-pre-con").hide();
            $('#employee').hide();
            $('#employee_edit').show(); 
        }
        function update_employee(){
            var employee_name  = $("#edit_employee_name").val();
            var val1           = value_check('edit_employee_name',employee_name,'text_box');
            var employee_number= $("#edit_employee_mobilenumber").val();
            var val3           = value_check('edit_employee_mobilenumber',employee_number,'mobile');
            var employee_joindate= $("#edit_employee_joindate").val();
            var employee_dob   = $("#edit_employee_dob").val();
            var employee_gender= $("#edit_employee_gender").val();
            var val6           = value_check('edit_employee_gender',employee_gender,'text_box');
            var employee_department= $("#edit_employee_department").val();
            var val7           = value_check('edit_employee_department',employee_department,'text_box');
            var employee_email_id= $("#edit_employee_email_id").val();
            var employee_blood_group= $("#edit_employee_blood_group").val();
            var employee_address= $("#edit_employee_address").val();
            var employee_city  = $("#edit_employee_city").val();
            var employee_street= $("#edit_employee_street").val();
            var employee_pincode= $("#edit_employee_pincode").val();
            var employee_image  = $("#edit_employee_image_valid").val();
            var address_proof1  = $("#edit_address_proof1_valid").val();
            var address_proof2  = $("#edit_address_proof2_valid").val();
            var address_proof3  = $("#edit_address_proof3_valid").val();
            var address_proof4  = $("#edit_address_proof4_valid").val();
            var address_proof5  = $("#edit_address_proof5_valid").val();
            if(val1==true && val3==true && val6==true && val7==true){
                $('#update_employee_button').prop('disabled', true);
                $(".se-pre-con").show();
                edit_image_upload_loop(0);
            }else{
                swal("Please enter mandatory details!");
            }
        }
        var edit_image_id = ['edit_employee_image','edit_address_proof1','edit_address_proof2','edit_address_proof3','edit_address_proof4','edit_address_proof5']
        function edit_image_upload_loop(key){
            var valid  = $("#"+edit_image_id[key]+"_valid").val();
            var checkkey = key+1;
            if(valid=="true"){
                if(checkkey>edit_image_id.length){
                    update_employee_finish();
                }else{
                    var fileUpload = document.getElementById(edit_image_id[key]+"_upload");
                    var file = fileUpload.files[0];
                    s3_file_update(file, key);
                }
            }else{
                if(valid!=undefined){
                    $("#"+edit_image_id[key]+"_valid").val(valid);
                    key++;
                    edit_image_upload_loop(key);
                }else{
                    update_employee_finish();
                }
            }
        }
        function update_employee_finish(){
            var employee_token  = $("#edit_employee_token").val();
            var employee_name   = $("#edit_employee_name").val();
            var employee_number = $("#edit_employee_mobilenumber").val();
            var employee_joindate= $("#edit_employee_joindate").val();
            var employee_dob    = $("#edit_employee_dob").val();
            var employee_gender = $("#edit_employee_gender").val();
            var employee_department = $("#edit_employee_department").val();
            var employee_email_id   = $("#edit_employee_email_id").val();
            var employee_blood_group= $("#edit_employee_blood_group").val();
            var employee_address= $("#edit_employee_address").val();
            var employee_city   = $("#edit_employee_city").val();
            var employee_street = $("#edit_employee_street").val();
            var employee_pincode= $("#edit_employee_pincode").val();
            var employee_image  = $("#edit_employee_image_valid").val();
            var address_proof1  = $("#edit_address_proof1_valid").val();
            var proof2_id       = $("#edit_address_proof2_valid_id").val();
            var proof3_id       = $("#edit_address_proof3_valid_id").val();
            var proof4_id       = $("#edit_address_proof4_valid_id").val();
            var proof5_id       = $("#edit_address_proof5_valid_id").val();
            var address_proof2  = $("#edit_address_proof2_valid").val();
            var address_proof3  = $("#edit_address_proof3_valid").val(); 
            var address_proof4  = $("#edit_address_proof4_valid").val();
            var address_proof5  = $("#edit_address_proof5_valid").val();
            var datas ={
                'employee_token':employee_token,
                'employee_name':employee_name,
                'employee_number':employee_number,
                'employee_joindate':employee_joindate,
                'employee_dob':employee_dob,
                'employee_department':employee_department,
                'employee_email_id':employee_email_id,
                'employee_blood_group':employee_blood_group,
                'employee_address':employee_address,
                'employee_city':employee_city,
                'employee_street':employee_street,
                'employee_pincode':employee_pincode,
                'employee_image':employee_image,
                'address_proof1':address_proof1,
                'proof2_id':proof2_id,
                'proof3_id':proof3_id,
                'proof4_id':proof4_id,
                'proof5_id':proof5_id,
                'address_proof2':address_proof2,
                'address_proof3':address_proof3,
                'address_proof4':address_proof4,
                'address_proof5':address_proof5,
                'gender':employee_gender,
                'distributor_token':distributor_token,
                'dashboard_code':verfication_code
            }
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/distributor/update_employee.php",
                data: json_data,
            }).done(function(data) {
                $(".se-pre-con").hide();
                if(data.code=="201"){
                    swal("Employee Updated successfully!", {icon: "success",}).then((value) => {
                        location.reload();
                    });
                }else{
                    $('#update_employee_button').prop('disabled', false);
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

    $(document).on('keypress', '#add_employee_name,#edit_employee_name', function (event) {
        var regex = new RegExp("^[a-zA-Z ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key) || (event.which === 32 && this.value.length === 0)){
            event.preventDefault();
            return false;
        }
    });
    
    function view_Location(employeeToken){
        var datas = {
                dashboard_code: verfication_code,
                employee_token: employeeToken,
                type: "TrackLocation"
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/track_location.php",
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
                              infowindow.setContent(new_data[key].shop_name+"</br> Time : "+new_data[key].date_time);
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

    ///////////////////////  View on Map  //////////////////////////////
    //function initMap() {
    //
    //      const map = new google.maps.Map(document.getElementById("map"), {
    //        zoom: 10,
    //        center: myLatlng,
    //      });
    //
    //      // Create the initial InfoWindow.
    //      let infoWindow = new google.maps.InfoWindow({
    //        content: employee_name,
    //        position: myLatlng,
    //      });
    //
    //      infoWindow.open(map);
    //}
    //let markers = [];   
    //function initMap(myLatlng,employee_name){
    ////const myLatlng = { lat: 12.963701130874837, lng: 80.21385233256576 }; 
    //     const map = new google.maps.Map(document.getElementById("map"), {
    //       zoom: 10,
    //       center: myLatlng,
    //     });
    //
    //      const marker = new google.maps.Marker({
    //        position: myLatlng,
    //        map: map,
    //      });
    //      const infowindow = new google.maps.InfoWindow({
    //        content: "<p>" + employee_name + "</p>",
    //      });
    //
    //      google.maps.event.addListener(marker, "click", () => {
    //        infowindow.open(map, marker);
    //      });
    //}    
    // window.initMap = initMap;
   
    function view_log(key){
        $(".se-pre-con").show();
        var employeeToken = table_main_data[key].employee_token;
        $("#employee_name_data").text(table_main_data[key].employee_name);
        var datas = {
            dashboard_code: verfication_code,
            employee_token: employeeToken,
            type: 'VisitShopLog'
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/track_location.php",
            data: json_data,
        }).done(function(data){
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
            $(".se-pre-con").fadeOut();
            $("#log_table").html(top_html);
        });
    }        
</script>
</body>
</html>
<?php
}
?>