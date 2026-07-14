    <?php
        include "config.php";
        include "$api_path/config/core.php";
        if($cookie_admin_name ==""){
            header("Location:login.php");
        }else{
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Power Soaps</title>
        <link rel="shortcut icon" href="assets/favi.png">

        <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet"/>

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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
    <style>
            .a_button{
            color: #00b9f5;
            }
            .edit_input,.de_activate{
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
            .distributor_list {
            padding: 20px;
            }
            .distributor_list li {
            list-style-type: disc;
            }
            .distributor_list p {
            font-weight: 600;
            font-size: 16px;
            color: #000;
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
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
            .nav-link.active{
            color: #fff;
            background-color: #0aa602 !important;
            border: 1px solid #0aa602;
            border-radius: 12px;
            }
            .split_TwoPage {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            margin-bottom: 20px;
            }

            .fulWidth{
            width: 100% !important;
            padding: 10px 10px;
            max-height: 300px;
            overflow: auto;
            }
            /* mywork */
            .form-control.edit_shop_name_box1{    
            width: 49%;
            float: left;
            height: 350px;
            overflow: auto;
            }


            .edit_shop_name_box1::-webkit-scrollbar ,
            .fulWidth::-webkit-scrollbar {
            display: block;
            width: 10px;
            }

            /* Track */
            .edit_shop_name_box1::-webkit-scrollbar-track,
            .fulWidth::-webkit-scrollbar-track {
            background: #f1f1f1; 
            }

            /* Handle */
            .edit_shop_name_box1::-webkit-scrollbar-thumb,
            .fulWidth::-webkit-scrollbar-thumb {
            background: #888; 
            }

            /* Handle on hover */
            .edit_shop_name_box1::-webkit-scrollbar-thumb:hover ,
            .fulWidth::-webkit-scrollbar-thumb:hover{
            background: #555; 
            }

            .select_data{
            width: 49%;
            height: 350px;
            overflow: auto;
            padding: 10px 0;
            float: right;
            border: 1px solid #ced4da;
            border-radius: 8px;

            }
            .edit_shop_name_box2{
            clear: both;
            }
            div.dataTables_wrapper div.dataTables_filter {
            text-align: right;
            float: right;
            }
            .select2-container--default.select2-container--focus .select2-selection--multiple {
                border: none !important;
                outline: 0;
            }
            .select2-container--default .select2-selection--multiple{
                border: none !important;
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
                <!-- <li class="nav-item mx-1" role="">
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
                    <button onclick="gobutton();"  class="nav-link active" >Go</button>
                </li> -->
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
                            <th>Retailer Code</th>
                            <th>Retailer Name</th>
                            <th>Type</th>
                            <th>Mobile Number</th>
                            <th>Contact Person</th>
                            <th>GST Number</th>
                            <th>City</th>
                            <th>Action</th>
                            <th>Mapping</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_id">
                    </tbody>
                </table>
            </div>
        </section>
                
        <section class="bg-white brad-4 full-height twoback" id="retailer_view" style="display: none;">
                <div class="header_container mrgzro" >
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
                        <form  class="forms">
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
                                <input class="input-field" id="license_number" placeholder="Enter License Number" value="" >
                            </div> 
                            <div class="form-control" style="border: none;">
                                <h6>Attach License</h6>
                                <label for="retailer_image_upload">
                                    <div class="custom-file">
                                        <input id="retailer_image_valid" type="hidden">    
                                        <input id="retailer_image_upload" onchange="file_upload_retailer('retailer_image','retailer_view_image_url','assets/upload.png')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                        <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                    </div>
                                    <img class="show_upload_image" style="max-height: 200px;max-width: 400px;padding-top:10px" id="retailer_view_image_url"/>
                                    <span>Image format should be in jpg/png/pdf</span>
                                </label>
                            </div>
                            <div class="form-control shop_address_box">    
                                <p class="shop_address">Address</p>
                                <input class="input-field" id="shop_address" placeholder="Enter Address" value="" >
                            </div> 
                            <div class="form-control shop_city_box">
                                <p class="shop_city">City</p>
                                <input class="input-field" id="shop_city" placeholder="Enter City" value="">
                            </div> 
                            <div class="form-control shop_pincode_box">
                                <p class="shop_pincode">Pincode</p>
                                <input class="input-field" id="shop_pincode" placeholder="Enter Pincode" value="" >
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
                        <form  class="forms">
                            <input id="edit_shop_token" type="hidden">
                            <div class="form-control edit_shop_name_box">
                                <p class="edit_shop_name">Shop Name</p>
                                <input class="input-field" id="edit_shop_name" placeholder="Enter Shop Name" value="">
                            </div>   
                            <div class="form-control edit_contact_person_box">
                                <p class="edit_contact_person">Contact Person</p>
                                <input class="input-field" id="edit_contact_person" placeholder="Enter details" value="">
                            </div> 
                            <div class="form-control edit_contact_number_box">
                                <p class="edit_contact_number">Contact Number</p>
                                <input class="input-field numberonly" id="edit_contact_number" maxlength="10" placeholder="Enter Contact Number" value="">
                            </div> 
                            <div class="form-control edit_shop_type_box">
                                <p class="edit_shop_type">Shop Type</p>
                                <select class="input-field" id="edit_shop_type">
                                </select>
                            </div>
                            <div class="form-control edit_license_number_box">
                                <p class="edit_license_number">GST Number</p>
                                <input class="input-field" id="edit_license_number" placeholder="Enter License Number" value="" >
                            </div> 
                            <div class="form-control" style="border: none;">
                                <h6>Attach License</h6>
                                <label for="edit_retailer_image_upload">
                                    <div class="custom-file">
                                        <input id="edit_retailer_image_valid" type="hidden">    
                                        <input id="edit_retailer_image_upload" onchange="file_upload_retailer('edit_retailer_image','edit_retailer_view_image_url','assets/upload.png')" type="file"  accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                        <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                    </div>
                                    <img class="show_upload_image" style="max-height: 200px;max-width: 400px;padding-top:10px" id="edit_retailer_view_image_url"/>
                                    <span>Image format should be in jpg/png/pdf</span>
                                </label>
                            </div>
                            <div class="form-control edit_shop_address_box">    
                                <p class="edit_shop_address">Address</p>
                                <input class="input-field" id="edit_shop_address" placeholder="Enter Address" >
                            </div> 
                            <div class="form-control edit_shop_city_box">
                                <p class="edit_shop_city">City</p>
                                <input class="input-field" id="edit_shop_city" placeholder="Enter City">
                            </div> 
                            <div class="form-control edit_shop_pincode_box">
                                <p class="edit_shop_pincode">Pincode</p>
                                <input class="input-field" id="edit_shop_pincode" placeholder="Enter Pincode" >
                            </div> 
                            <div class="form-control edit_shop_coordinates_box">
                                <p class="edit_shop_coordinates">Coordinates</p>
                                <input class="input-field" id="edit_shop_coordinates" placeholder="Enter Coordinates" >
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
        <!-- Mapping -->
        <div class="modal fade" id="formUpdate1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel4">Retailer Onboard</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class="forms">
                        <input id="edit_shop_token" type="hidden">
                        <div class="split_TwoPage">
                            <div class="form-control edit_shop_name_box1">
                                <input type="hidden" id="hiddendata">
                                <p class="requested_divion">Retailer Address</p>
                                    <ul id='requst_Address'>
                                        <!-- <li>hai</li>
                                        <li>hello</li>
                                        <li>welcome</li> -->
                                    </ul>
                                <p class="requested_divion">Retailer Requested Division</p>
                                    <ul id='requst_division'>
                                        <!-- <li>hai</li>
                                        <li>hello</li>
                                        <li>welcome</li> -->
                                    </ul>
                            </div> 
                            <div class="select_data"> 
                                    <div class="form-control edit_contact_person_box">
                                        <p class="distributot_list salesState">State list</p>
                                        <select class="input-field" id="salesState" >
                                            <!-- <option>tamilnadu</option>
                                            <option>kerala</option>
                                            <option>andra</option> -->
                                        </select>
                                    </div>
                                    <div class="form-control edit_contact_person_box">
                                        <p class="distributot_list salesRegion">Region list</p>
                                        <select class="input-field" id="salesRegion" >
                                            <!-- <option>Chennai</option>
                                            <option>Trichy</option> -->
                                        </select>
                                    </div> 
                                    <div class="form-control edit_contact_person_box">
                                        <p class="distributot_list area_distributor">Distributor list</p>
                                        <select  multiple="multiple" style="width: 100%" class="myselect input-field" id="area_distributor" >
                                            <!-- <option>Sale rep</option> -->
                                        </select>
                                    </div>
                            </div>
                        </div>
                        <div class="form-control edit_shop_name_box2 fulWidth" >
                            <p class="requested_divion distributor_division">Distributor Division</p>
                                <ul id='distributor_division' class="distributor_list">
                                    <!-- <li>hai</li> -->
                                </ul>
                        </div> 
                    </form>
                </div>
            
                <div class="modal-footer">
                    <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                    <!-- onclick="mapp_retailer()" -->
                    <button type="button" class="btn model-btn" id="mapp_retailer_button" >Update Retailer</button>
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
                                <input id="csv_file_upload" onchange="file_upload_csv('csv_file','csv_view_url','assets/upload_csv_done.png')" type="file"  accept=".csv" style="display:none;">
                                <img alt="" src="assets/csvfile.png" class="csvfile" id="csv_view_url"/>
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
                        <form  class="forms">
                            <div class="form-control shop_name_box">
                                <p class="shop_name">Shop Name</p>
                                <input class="input-field" id="shop_reason" placeholder="Enter Reason" value="">
                            </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Cancel</a> -->
                        <button type="button" class="btn model-btn"  onclick="inactivate();">Deactivate</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        var admin_state_id = "<?php echo $cookie_admin_state; ?>";
        var region_change="";
        var dist_change="";
    </script>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script> 
    <script>
        var retailerToken = "<?php echo $_SESSION["retailer_token"]; ?>";
    // console.log(retailerToken);
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        //console.log(api_path);
        // function back_view_retailer(){
        //      $("#retailer_table").show();
        //     $("#retailer_view").hide();
        // }
        
        $(document).ready(function(){
        $(".se-pre-con").hide();
        //allstate
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

            var data = {
                type :'onboard_details'
            }
            var json_data = JSON.stringify(data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/admin/retailer_onboard.php",
                data:json_data,
            }).done(function(result){
                console.log('result',result);
                var html = '';
                $('#total_retailer_count').html(result.data.length);
                result.data.forEach(function(item,index){
                    html += `<tr>`
                    html += `<td>${item.retail_code}</td>`
                    html += `<td>${item.retailer_name}</td>`
                    html += `<td>${item.shopType_name}</td>`
                    html += `<td>${item.mobile_number}</td>`
                    if (item.contact_person == "") {
                        html += `<td><span>-</span></td>`
                    }else{
                        html += `<td>${item.contact_person}</td>`
                    }
                    if (item.license_number == "") {
                        html += `<td><span>-</span></td>`
                    }else{
                        html += `<td>${item.license_number}</td>`
                    }
                    // html += `<td>${item.license_number}</td>`
                    html += `<td>${item.city}</td>`
                    html += `<td><a data-toggle="modal" data-shop_token='${item.shop_token}' id='edit_btn'><img src="assets/edit.png" class="edit_input " alt="" /></a></td>`
                    if (item.shop_mapping_uniq_token == null) {
                        html += `<td><button  data-shop1_token='${item.shop_token}' class="nav-link active mapbtn" style="color: #fff;
        background-color: #fca605 !important;
        border: 1px solid #fca605;
        border-radius: 12px;">Map</button></td>`
                    }else{
                        // id='mapbtn'
                        html += `<td><button  data-shop1_token='${item.shop_token}' class="nav-link active mapbtn">Updated</button></td>`
                    }
                
                    html += `</tr>`
                });
                $('#table_body_id').html(html);
                $("#table_data").DataTable({
                            "scrollX": false,
                            lengthChange:true,
                    dom: 'Bfrltip',
                    lengthMenu: [10,25,100,500,1000,5000,10000,100000],
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
                //=========== edit shop types
                    var datas = {
                        dashboard_code: verfication_code,
                        type: "All"
                        };
                    var json_data = JSON.stringify(datas);
                        $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/retailerDetails.php",
                        data: json_data,
                    }).done(function(datas){
                    let data = datas.data;
                    var optionText;
                    optionText += '<option value="">Select Shop Type</option>';
                    for (var key in data) {
                        optionText += '<option value="' + data[key].shop_token + '">' + data[key].shop_type + '</option>';
                    }
                    $("#edit_shop_type").html(optionText);
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
                // area distributor
                $("#salesRegion").on('change',function(){
                    $("#area_dis").css("display", "block");
                    let regionToken = $(this).find(':selected').val();
                    let areaobj={
                        regionToken:regionToken,
                        type:'regionToken'
                    }
                    var json_data = JSON.stringify(areaobj);
                console.log('hello',json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/scheduleSalesRep.php",
                        data:json_data,
                    }).done(function(datas){
                        let data = datas.data;
                        let html_text = '<option value="">Select Distributor</option>';

                        data.forEach(function(item,index){
                                    html_text += `<option id='areas_dis' value="${item.token}">${item.name}</option>`;
                        });
                        $('#area_distributor').html(html_text);
                    });
                });
                
                $("#area_distributor").on('change',function(){
                    let disToken = [];
                $('#area_distributor :selected').each(function() {
                    disToken.push($(this).val());
                });
                    let distobj={
                        disToken:disToken,
                        type:'divisionmap'
                    }
                    var json_data = JSON.stringify(distobj);
                // console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/scheduleSalesRep.php",
                        data:json_data,
                    }).done(function(datas){
                        let data = datas.data;
                        console.log(data);
                        var html_text ='';
                        let name='';
                        data.forEach(function(item,index){
                            if(name!=item.distname){
                                html_text += `<p>${item.distname}</p>`;
                                name=item.distname;
                            }
                            html_text += `<li>
                                    ${item.name}
                                    </li>`;
                        });
                        $('#distributor_division').html(html_text);
                    });
                });

                    //============== show update shops

            $('#table_data tbody').on( 'click', '#edit_btn', function () {
                var retailer_token = $(this).attr('data-shop_token');
                var datas = {
                dashboard_code: verfication_code,
                type: "single_retailer",
                retailer_token: retailer_token,
            };
            var json_data = JSON.stringify(datas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/retailerDetails.php",
                data: json_data,
            }).done(function(data){
                console.log(data);
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
                    if(retailer_data.license_image==""){
                        $("#edit_retailer_view_image_url").attr("src", "");
                        $("#edit_retailer_view_image_url").css("display", "none");
                    }else{
                        $("#edit_retailer_view_image_url").attr("src", retailer_data.license_image);
                        $("#edit_retailer_view_image_url").css("display", "block");
                    }
                    //$("#edit_retailer_image_valid").val(retailer_data.license_image);
                        $("#formUpdate").modal('show');
            });

            });
        });   
            //========== update shops
                function update_retailer(){
                var shop_name     = $("#edit_shop_name").val();
                var val1          = value_check('edit_shop_name',shop_name,'text_box');
                var contact_person= $("#edit_contact_person").val();
                // var val2          = value_check('edit_contact_person',contact_person,'text_box');
                var contact_number= $("#edit_contact_number").val();
                var val3          = value_check('edit_contact_number',contact_number,'text_box');
                var shop_type     = $("#edit_shop_type").val();
                    var val4          = value_check('edit_shop_type',shop_type,'text_box');
                    var license_number= $("#edit_license_number").val();
                // var val5          = value_check('edit_license_number',license_number,'text_box');
                    var shop_address  = $("#edit_shop_address").val();
                    var val6          = value_check('edit_shop_address',shop_address,'text_box');
                    var shop_city     = $("#edit_shop_city").val();
                    var val7          = value_check('edit_shop_city',shop_city,'text_box');
                    var shop_pincode  = $("#edit_shop_pincode").val();
                    var val8          = value_check('edit_shop_pincode',shop_pincode,'text_box');
                var shop_coordinates= $("#edit_shop_coordinates").val();
                // var val9          = value_check('edit_shop_coordinates',shop_coordinates,'text_box');
                    var retailer_image= $("#edit_retailer_image_valid").val();
                // var val10         = value_check('',retailer_image,'image');
                    if(val1==true  && val3==true && val4==true && val6==true && val7==true && val8==true){
                        $("#formUpdate").modal('hide');
                        setTimeout(function () {  
                            $(".se-pre-con").show();
                        }, 5);
                        $('#update_retailer_button').prop('disabled', true);
                        if(retailer_image=="true"){
                            edit_image_upload_loop(0);
                        }else{
                            update_retailer_finish();
                        }
                    }else{
                        if(val1==true && val3==true && val4==true &&  val6==true && val7==true && val8==true){
                            var all_check = true;
                        }else{
                            var all_check = false;
                        }
                        if(all_check==false){
                            swal("Please enter all details!");
                        }else{
                            swal("Please Upload profile image");
                        }  
                }
            }
            var edit_image_id = ['edit_retailer_image'];
                function edit_image_upload_loop(key){
                var valid   = $("#"+edit_image_id[key]+"_valid").val();
                var checkkey = key+1;
                    if(valid=="true"){
                        if(checkkey>edit_image_id.length){
                            update_retailer_finish();
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
                            update_retailer_finish();
                    }
                    }
                }
                function update_retailer_finish(){
                var shop_token    = $("#edit_shop_token").val();
                var shop_name     = $("#edit_shop_name").val();
                var contact_person= $("#edit_contact_person").val();
                var contact_number= $("#edit_contact_number").val();
                    var shop_type     = $("#edit_shop_type").val();
                    var license_number= $("#edit_license_number").val();
                    var shop_address  = $("#edit_shop_address").val();
                    var shop_city     = $("#edit_shop_city").val();
                    var shop_pincode  = $("#edit_shop_pincode").val();
                    var shop_coordinates= $("#edit_shop_coordinates").val();
                    var retailer_image  = $("#edit_retailer_image_valid").val();
                    var datas ={
                        'shop_token':shop_token,
                        'shop_name':shop_name,
                        'contact_person':contact_person,
                        'contact_number':contact_number,
                        'shop_type':shop_type,
                        'license_number':license_number,
                        'shop_address':shop_address,
                        'shop_city':shop_city,
                        'shop_pincode':shop_pincode,
                        'shop_coordinates':shop_coordinates,
                        'retailer_image':retailer_image,
                        'dashboard_code':verfication_code
                    }
                    var json_data = JSON.stringify(datas);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url : api_path+"/admin/updateRetailer.php",
                        data: json_data,
                    }).done(function(data) {
                        $(".se-pre-con").hide();
                        if(data.code=="201"){
                            swal("Retailer updated successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                            });
                        }else{
                            $("#formUpdate").modal('show');
                            $('#update_retailer_button').prop('disabled', false);
                            swal(data.message);
                        }
                    });
                }  
                //============Mapping

                $(document).on('click','.mapbtn',function(){
                        var shop_token = $(this).attr('data-shop1_token');
                        $('#hiddendata').val(shop_token);
                            var divi = {
                                type: "division",
                                shop_token : shop_token
                            }
                            var json_data = JSON.stringify(divi);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/retailer_onboard.php",
                            data:json_data,
                        }).done(function(divi_data){
                            var html='';
                            var html1 = '';
                            //console.log('divi_data',divi_data);
                            divi_data.retailer_address.forEach(function(item,index){
                                html+= `<li>${item.address}</li>`
                                html+= `<li>${item.city}</li>`
                                html+= `<li>${item.pincode}</li>`
                            });
                            $('#requst_Address').html(html);

                            divi_data.division_data.forEach(function(item,index){
                                html1+= `<li>${item.division_name}</li>`
                            });
                            $('#requst_division').html(html1);
                        });

                        //all state
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
                            $('#salesRegion').html(html_text);
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
                                $('#area_distributor').html(html_text);
                        });
                    $("#formUpdate1").modal('show');
                });
                
                $(document).on('click','#mapp_retailer_button',function(){
                    let disToken1 = [];
                    $('#area_distributor :selected').each(function() {
                        disToken1.push($(this).val());
                    });
                    var shop_token = $('#hiddendata').val();
                    var state_token = $('#salesState').val();
                    var val1 = value_check('salesState', state_token,'text_box');
                    var salesRegion = $('#salesRegion').val();
                    var val2 = value_check('salesRegion', salesRegion,'text_box');
                    var area_distributor = $('#area_distributor').val();
                    var val3 = value_check('area_distributor', area_distributor,'text_box');
                    if (val1 == true && val2 == true && val3 == true) {
                    
                        var data = {
                            type : 'request_updated',
                            distributor_token : disToken1,
                            shop_token:shop_token
                        }
                    var json_data = JSON.stringify(data);
                    console.log('json_data',json_data);
                $.ajax({
                        type: "POST",
                        dataType: "json",
                        url : api_path+"/admin/retailer_onboard.php",
                        data: json_data,
                    }).done(function(data) {
                        $(".se-pre-con").hide();
                        if(data.status_code=="200"){
                            swal("Retailer updated successfully!", {icon: "success",}).then((value) => {
                                location.reload();
                            });
                        }else{
                            var alert_data = ``;
                        data.check_datas.forEach(function(item,index){
                            alert_data += `${item.dis_name}`
                        });
                            swal(alert_data,data.message);
                        }
                    });
                    }else{
                    // $('.form-control').css({'border':'1px solid #ed3833'});
                        swal("Please enter all details!");
                    }
                    
                });
            
        
    </script>
    </body>
    </html>
    <?php
    }
    mysqli_close($link);
    ?>