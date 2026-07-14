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
        <title>Product list</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
    </head>
    <style>
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: none !important;
            outline: 0;
        }

        .select2-container--default .select2-selection--multiple {
            border: none !important;
        }

        a {
            cursor: pointer;
        }

        .header-details {
            display: flex;
            align-items: center;
        }

        .product_header_container .header-details h1 {
            padding: 20px 32px;
        }

        .a_button {
            color: #00b9f5 !important;
        }

        #item_code_color {
            color: red;
        }

        .modal-footer .deactive-btn {
            font: 16px var(--semibold-font);
            width: 140px;
            height: 40px;
            border: 1px solid #F44336;
            border-radius: 2px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .modal-footer .deactive-btn:hover {
            color: #F44336;
            background-color: transparent;
        }

        .chosen-container-single .chosen-single {
            position: relative;
            display: block;
            overflow: hidden;
            padding: 0px 5px;
            height: 23px;
            border: none;
            border-radius: 4px;
            background-color: transparent;
            box-shadow: none;
            color: #444;
            text-decoration: none;
            white-space: nowrap;
            line-height: 22px;
        }

        .header-section {
            width: 100%;
        }

        .select_field {
            position: relative;
        }

        .inventory-top {
            width: 80%;
        }

        .tab-content {
            position: relative;
        }

        .select_field select {
            color: #03bcf5;
            padding: 8px 16px;
            border: 1px solid;
            border-color: #03bcf5;
            cursor: pointer;
            border-radius: 5px;
            width: 300px;
            margin: 0;
            outline: none;
        }

        .view_link1 {
            font: 16px var(--semibold-font);
            color: #00B9F5 !important;
            margin-right: 20px;
            cursor: pointer;
            text-decoration: underline;
        }

        .view_link2 {
            font: 16px var(--semibold-font);
            color: #28ce7e !important;
            margin-right: 20px;
            cursor: pointer;
            text-decoration: underline;
        }

        .flex-set {
            display: flex;
        }

        .pdf-btn {
            background: #bc87f0 !important;
            padding: 8px 15px;
            border-radius: 4px;
            color: #fff !important;
            border: 1px solid #bc87f1 !important;
        }

        .cust-select-box {
            margin-left: 15px;
            width: 150px;
        }

        .ui-datepicker {
            z-index: 9999 !important;
        }

        .field_data {
            margin-right: 35px;
        }

        input#btndeactive {
            font: 16px var(--semibold-font);
            width: 130px;
            height: 40px;
            border: 1px solid #f54336;
            border-radius: 2px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .upload_file {
            cursor: pointer;
        }

        .module-option {
            width: 33.33%;
            padding: 0px 5px;
        }

        .module-option label {
            display: flex;
            align-items: center;
            gap: 7px;
            cursor: pointer;
            position: relative;
        }

        .modal-input:checked~.cust-checkbox {
            background-color: #51c568;
            border-color: #51c568;
            animation-name: input-animate;
            animation-duration: 0.7s;
        }

        .modal-dialog-scrollable {
            height: calc(100% - 1rem);
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            flex: 1 1 auto;
        }

        .bodyheight {
            height: 400px;
        }

        /* width */
        .bodyheight::-webkit-scrollbar {
            width: 10px;
            display: block;
        }

        /* Track */
        .bodyheight::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .bodyheight::-webkit-scrollbar-thumb {
            background: #2196F3;
        }

        /* Handle on hover */
        .bodyheight::-webkit-scrollbar-thumb:hover {
            background: #00bcd4;
        }


        @media (min-width: 576px) {
            .modal-dialog-scrollable {
                height: calc(100% - 3.5rem);
            }
        }



        .cust-checkbox {
            width: 18px;
            height: 18px;
            border: 1px solid #51c568;
            border-radius: 3px;
            display: inline-block;
            position: relative;
            transition: 0.4s;
        }

        .modal-input:checked~.cust-checkbox::before {
            content: '';
            display: inline-block;
            width: 12px;
            height: 5px;
            border-bottom: 2px solid #fff;
            border-left: 2px solid #fff;
            transform: scale(1) rotate(-45deg);
            position: absolute;
            top: 4px;
            left: 2px;
            transition: 0.4s;
        }

        .remove-btn {
            font: 16px var(--semibold-font);
            width: 160px;
            height: 40px;
            border: 1px solid #f54336;
            border-radius: 6px;
            background-color: #f44336;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        #removeGiftField {
            margin: 15px 0;
        }

        .remove-btn:hover {
            background-color: #fff;
            color: #f44336;
        }

        .modal-footer .createScheme-btn {
            font: 16px var(--semibold-font);
            width: 150px;
            height: 40px;
            border: 1px solid #00B9F5;
            border-radius: 2px;
            background-color: #00B9F5;
            color: #fff;
            outline: none;
            text-transform: uppercase;
            -webkit-transition: .3s;
            transition: .3s;
        }

        .modal-footer .createScheme-btn:hover {
            color: #00B9F5;
            background-color: transparent;
        }

        .input-field {
            outline: none;
        }

        .product_list button {
            margin-left: 0px;
        }

        .main-contents .nav {
            width: 72%;
            gap: 20px;
            margin-left: 30px;
        }

        .dt-buttons.btn-group {
            margin-left: 30px;
        }

        .dataTables_filter label {
            top: 30px !important;
        }


        .voice-search-container {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.mic-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.mic-btn:hover {
    transform: scale(1.1);
}

.mic-btn.listening {
    animation: pulse 1.5s infinite;
}

.mic-btn.listening img {
    filter: brightness(0) saturate(100%) invert(31%) sepia(98%) saturate(1500%) hue-rotate(346deg) brightness(95%) contrast(91%);
}

@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.2);
    }
    100% {
        transform: scale(1);
    }
}
    </style>

    <body>
        <div class="se-pre-con"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar2"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle5">
                <div class="product_header_container">
                    <div class="header-details ">
                        <h1 class="header_main">Product List</h1>
                        <p class="table_count">Total Product - <span id="total_product_count"></span></p>
                        <p class="table_count">Total Active Product - <span id="active_product_count"></span></p>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item " role="presentation">
                        <button onclick="showmodal4()" class="nav-link active"><span><img class="icon_add" src="assets/product.svg" alt=""></span> Add Product</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link a_button" type="button" data-toggle="modal" data-target="#myModal">Upload
                            CSV</button>
                    </li>
                    <li class="nav-item">
                        <a class="a_button" href="assets/csv/Sample_Product_CSV.csv" download><button class="nav-link" type="button">Sample CSV</button></a>
                    </li>
                    <li>
                        <div class="select_field">
                            <select style="width:250px" name='division' id='divisionlist'>
                            </select>
                        </div>
                    </li>
                    <!--
                <li class="nav-item " role="presentation">
                    <button onclick="show_ProductCSV()" class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>CSV</button>
                </li>
                <li class="nav-item " role="presentation">
                    <button onclick="show_ProductPDF()"  class="pdf-btn" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><span></span>PDF</button>
                </li>
-->
                    <!-- <li class="nav-item " role="presentation">
                    <button data-toggle="modal" data-target="#viewGlobal" class="nav-link active" >Global Scheme</button>
                </li> -->
                </ul>
                <div class="tab-content" id="pills-tabContent">

                    <div class="tab-pane active fade show" id="pills-home">
                        <table class="custom-table" id="table_data">
                            <thead>
                                <tr>
                                    <th>Delete Status</th>
                                    <th>SI.No</th>
                                    <th>Item Code</th>
                                    <th>Image</th>
                                    <th>Item Name</th>
                                    <th>Division</th>
                                    <th>HSN Code</th>
                                    <th>Net Price</th>
                                    <th>MRP</th>
                                    <th>GST</th>
                                    <th>Box Pieces</th>
                                    <th>Agent Rate</th>
                                    <th>Scheme</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_body_id"></tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="bg-white brad-4 full-height twoback" id="toggle6" style="display: none;">
                <img src="assets/back.png" onclick="back_view()" alt="" class="backword">
                <div class="side-position">
                    <div class="header_container">
                        <div class="header-section">
                            <div class="inventory-top">
                                <h1 class="header_main" id="single_product_name"></h1>
                                <span id="single_product_code"></span>
                            </div>
                            <input id="update_status_token" type="hidden">
                            <div class="de_activate"></div>
                        </div>
                    </div>
                    <hr />
                    <div class="inventory-body-section ">
                        <div class="inventory-body-left">
                            <img id="single_image" src="" alt="">
                        </div>
                        <div class="inventory-body-right">
                            <div class="container">
                                <div class="row">
                                    <div class="part1">
                                        <h4>Product Details</h4>
                                        <p>Manufacture : <span id="single_manufacture"></span></p>
                                        <p>Item Code : <span id="single_item_code2"></span></p>
                                        <p>Location : <span id="single_location"></span></p>
                                        <p>Origin : <span id="single_orgin"></span></p>
                                        <p>Piece Count For Box : <span id="single_piece_count"></span></p>
                                        <p>HSN Code: <span id="single_hsn_code"></span></p>
                                    </div>
                                    <div class="part2">
                                        <p>Barcode : <span id="single_batch_number"></span></p>
                                        <p>Net Weight : <span id="single_net_weight"></span></p>
                                        <p>Division : <span id="single_type"></span></p>
                                        <p>MRP : <span id="single_mrp"></span></p>
                                        <p>Price Inclusive Tax : <span id="single_price"></span></p>
                                    </div>
                                    <div class="part3">
                                        <p id="single_description"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-white brad-4 full-height" id="toggle7" style="display: none;">
                <div class="header_container">
                    <div class="header-section">
                        <div class="inventory-top">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_add()" alt=""> Add New Product</span></h1>
                        </div>
                    </div>
                    <div class="add_new_top">
                        <div class="col-md-4">
                            <label class="upload_label" for="product_image_upload">
                                <div class="upload_file">
                                    <img class="uploadimg" alt="" id="product_image_url" style="max-width:300px;" src="assets/icons/upload.png">
                                    <input id="product_image_valid" type="hidden">
                                    <input id="product_image_upload" onchange="file_upload('product_image','product_image_url','assets/icons/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg , image/png" style="display:none;">
                                    <p>Product Image </p>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <div class="form-control product_name_box">
                                    <p class="product_name">Product Name <span style="color:red">*</span></p>
                                    <input class="input-field" id="product_name" placeholder="Please Enter Product Name">
                                </div>
                                <div class="form-control product_code_box">
                                    <p class="product_code">Product Code <span style="color:red">*</span></p>
                                    <input class="input-field" id="product_code" maxlength="9" placeholder="Please Enter Product Code">
                                </div>
                                <div class="form-control product_weight_box">
                                    <p class="product_weight">Net Weight<span style="color:red">*</span></p>
                                    <input class="input-field" id="product_weight" placeholder="Please Enter Net Weight">
                                </div>
                                <div class="form-control product_total_cost_box">
                                    <p class="product_total_cost">Price inclusive GST(Per unit price)<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="product_total_cost" placeholder="Please Enter Price">
                                </div>
                                <div class="form-control product_total_cost_box">
                                    <p class="product_total_cost">GST(%)<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="product_gst" placeholder="Please Enter GST">
                                </div>
                                <div class="form-control product_piece_count_box">
                                    <p class="product_piece_count">Piece Count For box<span style="color:red">*</span></p>
                                    <input class="input-field numberonly" id="product_piece_count" placeholder="Please Enter Piece Count">
                                </div>
                                <div class="form-control product_hsn_code_box">
                                    <p class="product_hsn_code">Product HSN Code<span style="color:red">*</span></p>
                                    <input class="input-field" id="product_hsn_code" placeholder="Please Enter Product HSN Code" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]{5}">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form class="form">
                                <div class="form-control product_division_box">
                                    <p class="product_division">Division<span style="color:red">*</span></p>
                                    <select class="input-field" id="product_division" onchange="add_value_check('product_division')">
                                    </select>
                                </div>
                                <div class="form-control product_batch_number_box">
                                    <p class="product_batch_number">Barcode</p>
                                    <input class="input-field" id="product_batch_number" placeholder="Please Enter Barcode">
                                </div>
                                <div class="form-control product_location_box">
                                    <p class="product_location">Location<span style="color:red">*</span></p>
                                    <input class="input-field" id="product_location" placeholder="Please Enter Location">
                                </div>
                                <div class="form-control product_mrp_box">
                                    <p class="product_mrp">MRP<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="product_mrp" placeholder="Please Enter Mrp">
                                </div>

                                <div class="form-control product_name_shortform">
                                    <p class="product_name_shortform">Product Name ShortForm<span style="color:red">*</span></p>
                                    <input class="input-field" id="product_name_shortform" placeholder="Please Enter Product Name short">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bottom_container">
                    <div class="add_disp">
                        <div class="text_data">
                            <h2 class="product_description">Product Description :</h2>
                            <textarea class="textarea_field" type="text" id="product_description" placeholder="Type Message..."></textarea>
                        </div>
                        <button class="btn_product" id="add_product_button" onclick="add_product()">Add New Product</button>
                    </div>
                </div>
            </section>
            <section class="bg-white brad-4 full-height" id="toggleEdit" style="display: none;">
                <div class="header_container">
                    <div class="header-section">
                        <div class="inventory-top">
                            <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_edit()" alt=""> Edit Product</span></h1>
                        </div>
                    </div>
                    <div class="add_new_top">
                        <div class="col-md-4">
                            <label class="upload_label" for="edit_product_image_upload">
                                <div class="upload_file">
                                    <img class="uploadimg" alt="" id="edit_product_image_url" style="max-width:300px;" src="assets/icons/upload.png">
                                    <input id="edit_product_image_valid" type="hidden">
                                    <input id="edit_product_image_upload" onchange="file_upload('edit_product_image','edit_product_image_url','assets/icons/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg,image/png" style="display:none;">
                                    <p>Product Image </p>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-4">
                            <form class="forms">
                                <input id="edit_product_token" type="hidden">
                                <div class="form-control edit_product_name_box">
                                    <p class="edit_product_name">Product Name<span style="color:red">*</span></p>
                                    <input class="input-field" id="edit_product_name" placeholder="Please Enter Product Name">
                                </div>
                                <div class="form-control edit_product_code_box">
                                    <p class="edit_product_code">Product Code<span style="color:red">*</span></p>
                                    <input class="input-field" id="edit_product_code" placeholder="Please Enter Product Code">
                                </div>
                                <div class="form-control edit_product_weight_box">
                                    <p class="edit_product_weight">Net Weight<span style="color:red">*</span></p>
                                    <input class="input-field" id="edit_product_weight" placeholder="Please Enter Net Weight">
                                </div>
                                <div class="form-control edit_product_total_cost_box">
                                    <p class="edit_product_total_cost">Price inclusive GST(Per unit price)<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="edit_product_total_cost" placeholder="Please Enter Price">
                                </div>
                                <div class="form-control edit_product_total_cost_box">
                                    <p class="edit_product_total_cost">GST<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="edit_product_gst" placeholder="Please Enter GST">
                                </div>
                                <div class="form-control edit_product_piece_count_box">
                                    <p class="edit_product_piece_count">Piece Count For box<span style="color:red">*</span></p>
                                    <input class="input-field numberonly" id="edit_product_piece_count" placeholder="Please Enter Piece Count">
                                </div>
                                <div class="form-control edit_product_hsnCode_box">
                                    <p class="edit_product_hsnCode">HSN code<span style="color:red">*</span></p>
                                    <input class="input-field numberonly" id="edit_product_hsnCode" placeholder="Please Enter Product HSN Code">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form class="form">
                                <div class="form-control edit_product_division_box">
                                    <p class="edit_product_division">Division<span style="color:red">*</span></p>
                                    <select class="input-field" id="edit_product_division" onchange="add_value_check('edit_product_division')">
                                    </select>
                                </div>
                                <div class="form-control edit_product_batch_number_box">
                                    <p class="edit_product_batch_number">Barcode</p>
                                    <input class="input-field" id="edit_product_batch_number" placeholder="Please Enter Barcode">
                                </div>
                                <div class="form-control edit_product_location_box">
                                    <p class="edit_product_location">Location<span style="color:red">*</span></p>
                                    <input class="input-field" id="edit_product_location" placeholder="Please Enter Location">
                                </div>
                                <div class="form-control edit_product_mrp_box">
                                    <p class="edit_product_mrp">MRP<span style="color:red">*</span></p>
                                    <input class="input-field floatonly" id="edit_product_mrp" placeholder="Please Enter Mrp">
                                </div>
                                <div class="form-control edit_product_name_short">
                                    <p class="edit_product_name_short">Product Name ShortForm</p>
                                    <input class="input-field" id="edit_product_name_short" placeholder="Please Enter Product Name short">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="bottom_container">
                    <div class="add_disp">
                        <div class="text_data">
                            <h2 class="edit_product_description">Product Description :</h2>
                            <textarea class="textarea_field" type="text" id="edit_product_description" placeholder="Type Message..."></textarea>
                        </div>
                        <button class="btn_product" id="edit_product_button" onclick="edit_product()">Update
                            Product</button>
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
        <div class="modal fade" id="addscheme" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body bodyheight">
                        <div class="scheme-form-set">

                        </div>
                    </div>
                    <div class="modal-footer modal-footer-button">
                        <!-- <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a> -->
                        <!-- <button type="button" class="create-btn addmore" id="req_input" onclick="">Add Scheme</button> -->
                        <button type="button" class="createScheme-btn" id="add_scheme_product" onclick="addSchemeProduct()">Create Scheme</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- viewGlobal -->
        <div class="modal fade" id="viewGlobal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Global Scheme</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="scheme-form-sets">
                            <div class="form-control product_division">
                                <p class="product_division">Selector<span style="color:red">*</span></p>
                                <select class="input-field" id="selectordist" onchange="">
                                    <option value="distributor">Distributor</option>
                                    <option value="retailer">Retailer</option>
                                </select>
                            </div>
                            <div class="form-control product_division_box">
                                <p class="product_division">Division<span style="color:red">*</span></p>
                                <select class="mySelect for input-field divisionView" id="product_division1" multiple="multiple">
                                </select>
                            </div>
                            <div class="form-control product_division_box">
                                <p class="product_division">Product<span style="color:red">*</span></p>
                                <select class="mySelect for input-field productView" multiple="multiple" style="width: 100%" id="product_view"></select>
                            </div>
                            <div class="form-control">
                                <p class="scheme_name">Scheme Name</p>
                                <input class="input-field" id="scheme_name" value="">
                            </div>
                            <div class="flex-set">
                                <div class="form-control">
                                    <p class="buy_product_box_count">Buy</p>
                                    <input class="input-field" id="buy_product_box_count" value="">
                                </div>
                                <div class="form-control cust-select-box">
                                    <p class="division_name">UOM</p>
                                    <input class="input-field uom_type_box" value="Box">
                                </div>
                            </div>
                            <!-- <div class="form-control product_division_box">
                                <p class="product_division">Division<span style="color:red">*</span></p>
                                <select class="mySelect for input-field divisionGlobal" id="division_option">
                                </select>
                            </div> -->
                            <div class="form-control product_division_box">
                                <p class="product_division">Free Product<span style="color:red">*</span></p>
                                <select class="mySelect for input-field productGlobal" id="product_option"></select>
                            </div>
                            <div class="flex-set">
                                <div class="form-control">
                                    <p class="get_product_box_count">Get</p>
                                    <input class="input-field" id="get_product_box_count" value="">
                                </div>
                                <div class="form-control cust-select-box">
                                    <p class="division_name">UOM</p>
                                    <input class="input-field uom_type_box" value="Box">
                                </div>
                            </div>
                            <div class="sale-head-right">
                                <form class="formdield">
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="fromStatDateScheme" placeholder="From Date" type="text" value="">
                                    </div>
                                    <div class="form-group field_data">
                                        <input class="form-control box_form" name="date" id="toEndDateScheme" placeholder="To Date" type="text" value="">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-button">
                        <!-- <button type="button" class="deactive-btn" id="btndeactive" >Deactive</button> -->
                        <button type="button" class="create-btn" id="add_scheme" onclick="addSchemeProductGlobal()">Add Scheme</button>
                        <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- jquery CDN -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->

        <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <!---- For S3 bucket upload ---->
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/select.js<?php echo $js_cache_string; ?>"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js'></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <script>
            // Select2 js 
            // $('#product_option').select2({
            //     closeOnSelect: false,
            //     placeholder: "Please select Area"
            // });
            // $('#product_option1').select2({
            //     closeOnSelect: false,
            //     placeholder: "Please select Area"
            // });
            $(document).ready(function() {
                $("#req_input").click(function() {
                    $("#addmorefield").append(`<div id="removeGiftField"><div class="flex-set"> 
            <div class="module-option">
            <label for="samecheckbox">
            <input type="radio" id="samecheckbox" data-token="1" name="modules"  value="Same" class="modal-input hidden" checked>
            <span class="cust-checkbox"></span> Same </label>
            </div>
            <div class="module-option">
            <label for="differentcheckbox">
            <input type="radio" id="differentcheckbox" data-token="2" name="modules" value="Different" class="modal-input hidden">
            <span class="cust-checkbox"></span> Different </label>
            </div>
            </div>
            <div class="form-control product_division">
            <p class="product_division">Selector<span style="color:red">*</span></p>
            <select class="input-field" id="selectordist" onchange="">
            <option value="0">Distributor</option>
            <option value="1">Retailer</option>
            </select>
            </div>
            <div class="form-control scheme_name_box">
            <p class="scheme_name">Scheme Name</p>
            <input class="input-field" id="scheme_name" placeholder="Enter Scheme Name">
            </div>
            <div class="flex-set">
            <div class="form-control buy_product_box_count_box">
            <p class="buy_product_box_count">Buy</p>
            <input class="input-field" id="buy_product_box_count" onkeypress="return isNumber(event)" placeholder="Enter the buy box count">
            </div>
            <div class="form-control cust-select-box">
            <p class="division_name">UOM</p>
            <input class="input-field uom_type_box" value="Box" readonly>
            </div>
            </div>
            <div class="form-control product_division_box" style="display:none">
            <p class="product_division">Division<span style="color:red">*</span></p>
            <select class="input-field" id="product_division"> </select>
            </div>
            <div class="form-control product_division_box" style="display:none">
            <p class="product_division">Product<span style="color:red">*</span></p>
            <select class="input-field" id="product_view"> </select>
            </div>
            <div class="flex-set">
            <div class="form-control get_product_box_count_box">
            <p class="get_product_box_count">Get</p>
            <input class="input-field" id="get_product_box_count" keypress="return isNumber(event)" placeholder="Enter the free box count">
            </div>
            <div class="form-control cust-select-box">
            <p class="division_name">UOM</p>
            <input class="input-field uom_type_box" value="Box" readonly>
            </div>
            </div>
            <div class="sale-head-right">
            <form class="formdield">
            <div class="form-group field_data fromStatDateScheme_box">
            <input class="form-control box_form" name="date" id="fromStatDateScheme" type="text" placeholder="From Date" readonly>
            </div>
            <div class="form-group field_data toEndDateScheme_box">
            <input class="form-control box_form" name="date" id="toEndDateScheme" type="text" placeholder="To Date" readonly>
            </div>
            </form></div>
            </div> `);
                });

            });

            function removeScheme() {
                $('#removeGiftField').remove()
            }
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var gl_admin_token = "<?php echo $token; ?>";
        </script>
        <script>
            function showmodal4() {
                $('#toggle5').hide();
                $('#toggle7').show();
            }

            function back_add() {
                $('#toggle7').hide();
                $('#toggle5').show();
            }

            function back_edit() {
                $('#toggleEdit').hide();
                $('#toggle5').show();
            }

            function back_view() {
                $('#toggle6').hide();
                $('#toggle5').show();
            }

            $('#fromStatDateScheme').datepicker({
                autoclose: true,
                // todayHighlight: true,
                minDate: 'today',
                maxDate: '+2Y'
            });
            $('#toEndDateScheme').datepicker({
                autoclose: true,
                // todayHighlight: true,
                minDate: 'today',
                maxDate: '+2Y'
            });


            $("#product_code,#edit_product_code").keydown(function(event) {
                if (event.keyCode == 32 && this.value.length == 0) {
                    event.preventDefault();
                }
            });
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var product;
            var division;
            var divisionToken = " ";
            $(document).ready(function() {
                data_fetch();
                var datas = {
                    dashboard_code: verfication_code,
                    type: "count_check"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/productList.php",
                    data: json_data,
                }).done(function(datas) {
                    // console.log(datas);

                    var count = datas.Count;
                    $("#active_product_count").html(datas.activeprod_count);
                    // $("#total_product_count").html(numberWithCommas(count));
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
                    var html_text = '<option>Select Division</option>';
                    for (var key in data) {
                        html_text += '<option value="' + data[key].division_token + '">' + data[key]
                            .division_name + '</option>';
                    }
                    division = html_text;
                    $("#divisionlist").html(html_text);
                    $("#product_division").html(html_text);
                    $(".divisionView").html(html_text);
                    $(".divisionGlobal").html(html_text);
                    $("#product_division").chosen({
                        allow_single_deselect: true
                    });
                    add_value_check('product_division');
                    $("#edit_product_division").html(html_text);
                    $("#edit_product_division").chosen({
                        allow_single_deselect: true
                    });
                    add_value_check('edit_product_division');
                });

                var datas = {
                    dashboard_code: verfication_code,
                    type: "productall"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    var data = datas.data;
                    var html_text = '<option value="">Select Product</option>';
                    for (var key in data) {
                        html_text += '<option value="' + data[key].token + '">' + data[key]
                            .name + '</option>';
                    }
                    product = html_text;
                    $(".productView").html(html_text);
                    $(".productGlobal").html(html_text);
                });

            });
            var table;
            var arrdata=[];
            function data_fetch() {
                table = $('#table_data').DataTable({
                    "scrollX": true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [7]
                    }, ],
                    'ajax': {
                        'url': api_path + "/admin/serverProductList.php?v_id=" + verfication_code + "&&division=" + divisionToken,
                        'dataSrc': function(data) {
                            // console.log(data);
                            $("#total_product_count").html(data.iTotalDisplayRecords);
                            // let deletedCount = data.aaData.filter(i => i.delete_status == "1").length;
                            // console.log("Filtered items size:", deletedCount);
                            // console.log(data.aaData)
                            return data.aaData;
                        }
                    },
                    // "order": [
                    //     [0, "DESC"]
                    // ],
                    'columns': [

                        {
                            data: 'delete_status'
                        },
                        {
                            data: 'token'
                        },
                        {
                            data: 'item_code'
                        },
                        {
                            data: "image",
                            "render": function(data) {
                                if (data != "") {
                                    var img = '' + data;
                                   return '<div class="img-container"><img class="zoom-img" style="cursor: pointer;" src="' + img + '" height="50px" width="50px" alt="Zooming Image1"></div>';
                                }
                                return '<img src="assets/user.png" height="50px" width="50px" alt="Zooming Image2">';
                            }

                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'hsn_code'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'total_cost'
                        },
                        {
                            data: 'mrp'
                        },
                        {
                            data: 'gst'
                        },
                        {
                            data: 'piece_count'
                        },
                        {
                            data: 'Agent_Rate'
                        },
                        {
                            data: 'scheme'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if(aData.delete_status == "1"){
                                arrdata.push(aData.name);
                                
                        }
                        if (aData.delete_status == "2") {
                            $('td', nRow).css('background-color', '#ff9d87');
                        }
                    },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    // language: {
                    //     search: '<img src="assets/svg/Search_icon.svg">',
                    //     searchPlaceholder: "Search"
                    // },

                   language: {
                        search: '<div class="voice-search-container"><img src="assets/svg/Search_icon.svg"><button class="mic-btn" id="micButton" title="Voice Search"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#00b9f5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg></button></div>',
                        searchPlaceholder: "Search or speak..."
                    },
                    dom: 'Bfrltip',
                    buttons: [{
                            extend: 'pdfHtml5',
                            className: 'btn-primary buttonprint',
                            exportOptions: {
                                columns: [2, 4, 5, 6, 7, 8, 9]
                            },
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        },
                        {
                            extend: 'csv',
                            className: 'btn-info buttonprint',
                            exportOptions: {
                                columns: [2, 4, 5, 6, 7, 8, 9]
                            },
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        }
                    ],

                });
                table.columns([0, 1]).visible(false);
                //$('.dataTables_length').css("display", "none");
                $(".se-pre-con").hide();
            }
            console.log('arradata count:', arrdata);
            $(document).ready(function() {
                // $(document).on('click', '.zoom-img', function() {
                //     var src = $(this).attr('src');
                //     var modal = '<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-body"><img src="' + src + '" style="width: 100%; height: auto;"></div></div></div></div>';
                //     $('body').append(modal);
                //     $('#imageModal').modal('show');
                //     $('#imageModal').on('hidden.bs.modal', function() {
                //         $('#imageModal').remove();
                //     });
                // });

                // $(document).on({
                //     mouseenter: function() {
                //         $(this).css({
                //             'transform': 'scale(1.3)',
                //             'width': '100px',
                //             'height': '100px',
                //             'object-fit': 'cover',
                //             'transition': 'transform 0.3s ease'
                //         });                  
                //     },
                //     mouseleave: function() {
                //         $(this).css({
                //             'transform': 'scale(1.3)',
                //             'width': '50px',
                //             'height': '50px',
                //              'object-fit': 'cover',
                //             'transition': 'transform 0.3s ease'
                //             // Note: width, height, and object-fit will stay at 100px unless changed here
                //         });
                //     }
                // }, '.zoom-img');



                $(document).on({
                    mouseenter: function(e) {
                        var src = $(this).attr('src');
                        // Create a large preview container and append it to the body
                        var $preview = $('<div id="amazon-zoom-preview" style="position:fixed; z-index:99999; border:2px solid #00b9f5; background:#fff; padding:5px; box-shadow:0 8px 16px rgba(0,0,0,0.3); border-radius:8px; pointer-events:none;"><img src="' + src + '" style="max-width:350px; max-height:350px; object-fit:contain;"></div>');
                        $('body').append($preview);
                        
                        // Position it near the cursor
                        $('#amazon-zoom-preview').css({ top: (e.clientY + 15) + 'px', left: (e.clientX + 15) + 'px' });
                    },
                    mousemove: function(e) {
                        // Make the zoomed image follow the cursor smoothly
                        $('#amazon-zoom-preview').css({ top: (e.clientY + 15) + 'px', left: (e.clientX + 15) + 'px' });
                    },
                    mouseleave: function() {
                        // Remove the preview when the mouse leaves
                        $('#amazon-zoom-preview').remove();
                    }
                }, '.zoom-img');
                
            });

            //filter divisionWise
            $("#divisionlist").on('change', function() {
                divisionToken = $("#divisionlist option:selected").val();
                table.clear();
                table.destroy();
                data_fetch();
            });
            //division product change
            // $("#product_division1").on('change', function() {
            //     // $("#area_dis").css("display", "block");
            //     let divisionToken = $(this).val();
            //     let divisionobj = {
            //         dashboard_code: verfication_code,
            //         divisionToken: divisionToken,
            //         type: 'divisionToken'
            //     }
            //     var json_data = JSON.stringify(divisionobj);
            //     //console.log(json_data);
            //     $.ajax({
            //         type: "POST",
            //         dataType: "json",
            //         url: api_path + "/admin/singleDivisionDetails.php",
            //         data: json_data,
            //     }).done(function(datas) {
            //         let data = datas.data;
            //         // console.log(datas);
            //         let html_text = '<option value="">Select Division</option>';

            //         data.forEach(function(item, index) {
            //             html_text += `<option value="${item.token}">${item.name}</option>`;
            //         });
            //         productdivisionchange = html_text;
            //         $(".productView").html(html_text);
            //         $('#product_division1').select2({
            //             closeOnSelect: false,
            //             placeholder: "Please select Product"
            //         });


            //     });
            // });


            $('#table_data tbody').on('click', '.item_code_view', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                view_product(token);
            });

            function view_product(token) {
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_product",
                    product_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/productList.php",
                    data: json_data,
                }).done(function(data) {
                    var product_data = data.data;
                    $("#single_image").attr("src", product_data[0].image);
                    $("#single_product_name").html(product_data[0].item_name);
                    $("#single_product_code").html("Item Code:" + product_data[0].item_code);
                    $("#single_manufacture").html(product_data[0].manufacturer);
                    $("#single_item_code2").html(product_data[0].item_code);
                    $("#single_location").html(product_data[0].location);
                    $("#single_orgin").html(product_data[0].origin);
                    $("#single_batch_number").html(product_data[0].batch_number);
                    $("#single_net_weight").html(product_data[0].net_weight);
                    $("#single_type").html(product_data[0].item_type);
                    $("#single_mrp").html(product_data[0].item_mrp);
                    $("#single_price").html(product_data[0].item_price);
                    $("#single_description").html(product_data[0].description);
                    $("#single_piece_count").html(product_data[0].piece_count);
                    $("#single_additional_offer").html(product_data[0].additional_offer);
                    $("#single_hsn_code").html(product_data[0].item_hsnCode);
                    $("#update_status_token").val(product_data[0].item_token);
                    if (product_data[0].delete_status == 1) {
                        $(".de_activate").html('<a class="view_link" onclick="deactivate()">Deactivate Product</a>');
                        $(".de_activate > a").css('color', 'red');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    } else {
                        $(".de_activate").html('<a class="view_link" onclick="activate()">Activate Product</a>');
                        $(".de_activate > a").css('color', 'green');
                        $(".de_activate > a").css('text-decoration', 'underline');
                    }
                    $('#toggle5').hide();
                    $('#toggle6').show();
                });
            }

            function percentCalculation(a, b) {
                var c = (Math.round(a * b) / 100).toFixed(2);
                return c;
            }

            function add_product() {
                var product_name = $("#product_name").val();
                var val1 = value_check('product_name', product_name, 'text_box');
                var product_code = $("#product_code").val();
                var val2 = value_check('product_code', product_code, 'text_box');
                var product_weight = $("#product_weight").val();
                var val3 = value_check('product_weight', product_weight, 'text_box');
                var product_mrp = $("#product_mrp").val();
                var val4 = value_check('product_mrp', product_mrp, 'text_box');
                var product_division = $("#product_division").val();
                var val5 = value_check('product_division', product_division, 'text_box');
                var product_batch_number = $("#product_batch_number").val();
                //var val6 = value_check('product_batch_number', product_batch_number, 'text_box');
                var product_location = $("#product_location").val();
                var val7 = value_check('product_location', product_location, 'text_box');
                var product_total_cost = $("#product_total_cost").val();
                var val8 = value_check('product_total_cost', product_total_cost, 'text_box');
                var product_description = $("#product_description").val();
                var val9 = value_check('product_description', product_description, 'text');
                var product_piece_count = $("#product_piece_count").val();
                var val10 = value_check('product_piece_count', product_piece_count, 'text_box');
                var product_image_valid = $("#product_image_valid").val();
                // var val11 = value_check('', product_image_valid, 'image');
                var product_name_short = $("#product_name_shortform").val();
                // var val12 = value_check('', product_name_short, 'text_box');
                var product_hsnCode = $("#product_hsn_code").val();
                var val11 = value_check('product_hsn_code', product_hsnCode, 'text_box');
                var product_gst = $("#product_gst").val();
                var val12 = value_check('product_gst', product_gst, 'text_box');

                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val7 ==
                    true && val8 == true && val9 == true && val10 == true && val11 == true && val12 == true) {
                    $('#add_product_button').prop('disabled', true);
                    setTimeout(function() {
                        $(".se-pre-con").show();
                    }, 5);
                    image_upload_loop(0);
                } else {
                    if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val7 ==
                        true && val8 == true && val9 == true && val10 == true && val11 == true && val12 == true) {
                        var all_check = true;
                    } else {
                        var all_check = false;
                    }
                    if (all_check == true) {
                        //swal("Please Upload Product image");
                    } else {
                        swal("Please enter all details!");
                    }
                }
            }
            var image_id = ['product_image']

            function image_upload_loop(key) {
                var valid = $("#" + image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > image_id.length) {
                        add_product_finish();
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
                        add_product_finish();
                    }
                }
            }

            function add_product_finish() {
                var percentX = 6;
                var product_total_cost = $("#product_total_cost").val();
                var result = percentCalculation(product_total_cost, percentX); //calculate percentX% of number
                var retailer_price = (parseFloat(product_total_cost) + parseFloat(result)).toFixed(2);
                var product_name = $("#product_name").val();
                var product_code = $("#product_code").val();
                var product_weight = $("#product_weight").val();
                var product_mrp = $("#product_mrp").val();
                var product_division = $("#product_division").val();
                var product_batch_number = $("#product_batch_number").val();
                var product_location = $("#product_location").val();
                var product_description = $("#product_description").val();
                var product_piece_count = $("#product_piece_count").val();
                var product_image_valid = $("#product_image_valid").val();
                var product_name_short = $("#product_name_shortform").val();
                var product_hsnCode = $("#product_hsn_code").val();
                var product_gst = $("#product_gst").val();
                var datas = {
                    'product_name': product_name,
                    'product_code': product_code,
                    'product_weight': product_weight,
                    'product_mrp': product_mrp,
                    'product_batch_number': product_batch_number,
                    'product_location': product_location,
                    'product_total_cost': product_total_cost,
                    'product_description': product_description,
                    'product_image': product_image_valid,
                    'product_type': product_division,
                    'product_piece_count': product_piece_count,
                    'product_name_shortform': product_name_short,
                    'product_hsnCode': product_hsnCode,
                    'product_gst': product_gst,
                    'dashboard_code': verfication_code,
                    'admin_token': gl_admin_token,
                    'retailer_price': retailer_price
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/addProduct.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    if (data.code == "201") {
                        swal("Product added successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        $('#add_product_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }

            function upload_csv_file() {
                var valid = $('#csv_file_valid').val();
                if (valid == "true") {
                    $("#myModal").modal('hide');
                    $(".se-pre-con").show();
                    $('#csv_upload_button').prop('disabled', true);
                    var myFormData = new FormData();
                    myFormData.append('file_upload', csv_file_upload.files[0]);
                    $.ajax({
                        dataType: "json",
                        url: api_path + "/admin/uploadProductCsv.php",
                        type: 'POST',
                        async: false,
                        processData: false, // important
                        contentType: false, // important
                        data: myFormData,
                        success: function(data) {
                            if (data.code == 503) {
                                $(".se-pre-con").hide();
                                $('#csv_upload_button').prop('disabled', false);
                                swal(data.message);
                                $("#myModal").modal('show');
                            } else if (data.code == 201) {
                                swal(data.message, {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    swal("Please select a csv file!");
                }
            }
            $(".cancelbtn").click(function() {
                $("#csv_view_url").attr("src", "assets/csvfile.png");
                $("#csv_file_name").text("Upload Files");
                $('#csv_file_valid').val(false);
                $("#csv_file_upload").val('');
            });
            $('#table_data tbody').on('click', '.item_code_edit', function() {
                clear_update_modal();
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_product",
                    product_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/productList.php",
                    data: json_data,
                }).done(function(data) {
                    var product_data = data.data;
                    $("#edit_product_token").val(product_data[0].item_token);
                    $("#edit_product_name").val(product_data[0].item_name);
                    $("#edit_product_code").val(product_data[0].item_code);
                    $("#edit_product_weight").val(product_data[0].net_weight);
                    $("#edit_product_mrp").val(product_data[0].item_mrp);
                    $("#edit_product_gst").val(product_data[0].item_gst);
                    $("#edit_product_batch_number").val(product_data[0].batch_number);
                    $("#edit_product_location").val(product_data[0].location);
                    $("#edit_product_total_cost").val(product_data[0].item_price);
                    $("#edit_product_description").val(product_data[0].description);
                    $("#edit_product_name_short").val(product_data[0].item_nameshort);
                    $("#edit_product_hsnCode").val(product_data[0].item_hsnCode);
                    if (product_data[0].image == "") {
                        $("#edit_product_image_url").attr("src", "assets/icons/upload.png");
                    } else {
                        $("#edit_product_image_url").attr("src", product_data[0].image);
                    }
                    $("#edit_product_image_valid").val(product_data[0].image);
                    $("#edit_product_division").val(product_data[0].category_token).trigger("chosen:updated");
                    add_value_check('edit_product_division');
                    $("#edit_product_piece_count").val(product_data[0].piece_count);
                    //            $("#edit_product_additional_offer").val(product_data[0].additional_offer);
                    $('#toggle5').hide();
                    $('#toggleEdit').show();
                });
            });

            function clear_update_modal() {
                value_check('edit_product_name', 1, 'text_box');
                value_check('edit_product_code', 1, 'text_box');
                value_check('edit_product_weight', 1, 'text_box');
                value_check('edit_product_mrp', 1, 'text_box');
                value_check('edit_product_division', 1, 'text_box');
                value_check('edit_product_batch_number', 1, 'text_box');
                value_check('edit_product_location', 1, 'text_box');
                value_check('edit_product_total_cost', 1, 'text_box');
                value_check('edit_product_description', 1, 'text');
                value_check('edit_product_piece_count', 1, 'text_box');
                value_check('edit_product_name_short', 1, 'text_box');
                value_check('edit_product_hsnCode', 1, 'text_box');
            }

            function edit_product() {
                var product_name = $("#edit_product_name").val();
                var val1 = value_check('edit_product_name', product_name, 'text_box');
                var product_code = $("#edit_product_code").val();
                var val2 = value_check('edit_product_code', product_code, 'text_box');
                var product_weight = $("#edit_product_weight").val();
                var val3 = value_check('edit_product_weight', product_weight, 'text_box');
                var product_mrp = $("#edit_product_mrp").val();
                var val4 = value_check('edit_product_mrp', product_mrp, 'text_box');
                var product_division = $("#edit_product_division").val();
                var val5 = value_check('edit_product_division', product_division, 'text_box');
                var product_batch_number = $("#edit_product_batch_number").val();
                // var val6 = value_check('edit_product_batch_number', product_batch_number, 'text_box');
                var product_location = $("#edit_product_location").val();
                var val7 = value_check('edit_product_location', product_location, 'text_box');
                var product_total_cost = $("#edit_product_total_cost").val();
                var val8 = value_check('edit_product_total_cost', product_total_cost, 'text_box');
                var product_description = $("#edit_product_description").val();
                var val9 = value_check('edit_product_description', product_description, 'text');
                var product_piece_count = $("#edit_product_piece_count").val();
                var val10 = value_check('edit_product_piece_count', product_piece_count, 'text_box');
                var product_image_valid = $("#edit_product_image_valid").val();
                var product_hsnCode = $("#edit_product_hsnCode").val();
                var val11 = value_check('edit_product_hsnCode', product_hsnCode, 'text_box');
                var product_gst = $("#edit_product_gst").val();
                var val12 = value_check('edit_product_gst', product_gst, 'text_box');
                // var product_short_name = $("#edit_product_name_short").val();
                // var val12 = value_check('', product_short_name, 'text_box');
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val7 ==
                    true && val8 == true && val9 == true && val10 == true && val11 == true && val12 == true) {
                    $('#edit_product_button').prop('disabled', false);
                    setTimeout(function() {
                        $(".se-pre-con").show();
                    }, 5);
                    $('#update_retailer_button').prop('disabled', true);
                    if (product_image_valid == "true") {
                        edit_image_upload_loop(0);
                    } else {
                        update_product_finish();
                    }
                } else {
                    if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true && val7 ==
                        true && val8 == true && val9 == true && val10 == true && val11 == true && val12 == true) {
                        var all_check = true;
                    } else {
                        var all_check = false;
                    }
                    if (all_check == true) {
                        //swal("Please Upload Product image");
                    } else {
                        swal("Please enter all details!");
                    }
                }
            }
            var edit_image_id = ['edit_product_image'];

            function edit_image_upload_loop(key) {
                var valid = $("#" + edit_image_id[key] + "_valid").val();
                var checkkey = key + 1;
                if (valid == "true") {
                    if (checkkey > edit_image_id.length) {
                        update_product_finish();
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
                        update_product_finish();
                    }
                }
            }

            function update_product_finish() {
                var percentX = 6;
                var product_total_cost = $("#edit_product_total_cost").val();
                var result = percentCalculation(product_total_cost, percentX); //calculate percentX% of number
                var retailer_price = (parseFloat(product_total_cost) + parseFloat(result)).toFixed(2);
                var product_token = $("#edit_product_token").val();
                var product_name = $("#edit_product_name").val();
                var product_code = $("#edit_product_code").val();
                var product_weight = $("#edit_product_weight").val();
                var product_mrp = $("#edit_product_mrp").val();
                var product_division = $("#edit_product_division").val();
                var product_batch_number = $("#edit_product_batch_number").val();
                var product_location = $("#edit_product_location").val();
                var product_description = $("#edit_product_description").val();
                var product_piece_count = $("#edit_product_piece_count").val();
                var product_image_valid = $("#edit_product_image_valid").val();
                var product_name_short = $("#edit_product_name_short").val();
                var product_hsnCode = $("#edit_product_hsnCode").val();
                var product_gst = $("#edit_product_gst").val();
                var datas = {
                    'product_token': product_token,
                    'product_name': product_name,
                    'product_code': product_code,
                    'product_weight': product_weight,
                    'product_mrp': product_mrp,
                    'product_batch_number': product_batch_number,
                    'product_location': product_location,
                    'product_total_cost': product_total_cost,
                    'product_description': product_description,
                    'product_image': product_image_valid,
                    'product_type': product_division,
                    'product_piece_count': product_piece_count,
                    'product_name_short': product_name_short,
                    'product_hsnCode': product_hsnCode,
                    'product_gst': product_gst,
                    'dashboard_code': verfication_code,
                    'admin_token': gl_admin_token,
                    'retailer_price': retailer_price
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/updateProduct.php",
                    data: json_data,
                }).done(function(data) {
                    $(".se-pre-con").hide();
                    // if (data.code == "201") {
                    //     swal("Product updated successfully!", {
                    //         icon: "success",
                    //     }).then((value) => {
                    //         location.reload();
                    //     });
                    // } 


                    if (data.code == "201") {
                    swal("Product updated successfully!", {
                        icon: "success",
                    }).then((value) => {
                        $('#toggleEdit').hide();
                        $('#toggle5').show();
                        
                        table.ajax.reload(null,false);
                    });
                }
                    
                    
                    else {
                        $('#add_product_button').prop('disabled', false);
                        swal(data.message);
                    }
                });
            }

            function add_value_check(id) {
                var product_division = $("#" + id).val();
                if (product_division != "") {
                    $(".chosen-single > span").css("color", "#333333 !important");
                } else {
                    $(".chosen-single > span").css("color", "#757575 !important");
                }
            }

            function deactivate() {
                var token = $("#update_status_token").val();
                swal({
                    title: "Are you sure?",
                    text: "You want to deactivate this product?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'product_token': token,
                            'product_status': 2,
                            'dashboard_code': verfication_code,
                            'admin_token': gl_admin_token,
                            'type': 'productStatusChange'
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/productList.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Product deactivated successfully!", {
                                    icon: "success",
                                }).then((value) => {
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
                    text: "You want to activate this product?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        var datas = {
                            'product_token': token,
                            'product_status': 1,
                            'dashboard_code': verfication_code,
                            'type': 'productStatusChange'
                        }
                        var json_data = JSON.stringify(datas);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/productList.php",
                            data: json_data,
                        }).done(function(data) {
                            if (data.code == 503) {
                                swal("Something happened!");
                            } else if (data.code == 201) {
                                swal("Product activated successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            }
                        });
                    }
                });
            }

            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
            var prod_token_number;
            var product_token = [];
            var differproducttoken = [];
            $('#table_data tbody').on('click', '.item_code_view1', function() {
                $(".se-pre-con").show();
                $(".scheme-form-set").empty();
                var td_div = $(this).parent()
                var table_data = table.row(td_div).data();
                prod_token_number = table_data.token;
                product_token.push(table_data.token);
                //console.log(product_token);
                var schemetext = '';
                var token = '';
                if ($(this).hasClass("view_link1")) {
                    schemetext += '<div class="flex-set">';
                    schemetext += '<div class="module-option">';
                    schemetext += '<label for="samecheckbox">';
                    schemetext += '<input type="radio" id="samecheckbox" data-token="1" name="modules"  value="Same" class="modal-input hidden" checked>';
                    schemetext += '<span class="cust-checkbox"></span> Same </label>';
                    schemetext += '</div>';
                    schemetext += '<div class="module-option">';
                    schemetext += '<label for="differentcheckbox">';
                    schemetext += '<input type="radio" id="differentcheckbox" data-token="2" name="modules" value="Different" class="modal-input hidden">';
                    schemetext += '<span class="cust-checkbox"></span> Different </label>';
                    schemetext += '</div>';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control product_division">';
                    schemetext += '<p class="product_division">Selector<span style="color:red">*</span></p>';
                    schemetext += '<select class="input-field" id="selectordist" onchange="">';
                    schemetext += '<option value="distributor">Distributor</option>';
                    schemetext += '<option value="retailer">Retailer</option>';
                    schemetext += '</select>';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control scheme_name_box">';
                    schemetext += '<p class="scheme_name">Scheme Name</p>';
                    schemetext += '<input class="input-field" id="scheme_name" placeholder="Enter Scheme Name">';
                    schemetext += '</div>';
                    schemetext += '<div class="flex-set">';
                    schemetext += '<div class="form-control buy_product_box_count_box">';
                    schemetext += '<p class="buy_product_box_count">Buy</p>';
                    schemetext += '<input class="input-field" id="buy_product_box_count" onkeypress="return isNumber(event)" placeholder="Enter the buy box count">';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control cust-select-box">';
                    schemetext += '<p class="division_name">UOM</p>';
                    schemetext += '<input class="input-field uom_type_box" value="Box" readonly>';
                    schemetext += '</div>';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control product_division_box" style="display:none">';
                    schemetext += '<p class="product_division">Division<span style="color:red">*</span></p>';
                    schemetext += '<select class="input-field divisionView" id="product_division2"></select>';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control product_division_box" style="display:none">';
                    schemetext += '<p class="product_division">Product<span style="color:red">*</span></p>';
                    schemetext += '<select class="input-field productView" id="product_view2"> </select>';
                    schemetext += '</div>';
                    schemetext += '<div class="flex-set">';
                    schemetext += '<div class="form-control get_product_box_count_box">';
                    schemetext += '<p class="get_product_box_count">Get</p>';
                    schemetext += '<input class="input-field" id="get_product_box_count" keypress="return isNumber(event)" placeholder="Enter the free box count">';
                    schemetext += '</div>';
                    schemetext += '<div class="form-control cust-select-box">';
                    schemetext += '<p class="division_name">UOM</p>';
                    schemetext += '<input class="input-field uom_type_box" value="Box" readonly>';
                    schemetext += '</div>';
                    schemetext += '</div>';
                    schemetext += '<div class="sale-head-right">';
                    schemetext += '<form class="formdield">';
                    schemetext += '<div class="form-group field_data fromStatDateScheme_box">';
                    schemetext += '<input class="form-control box_form" name="date" id="fromStatDateScheme" type="text" placeholder="From Date" readonly>';
                    schemetext += '</div>';
                    schemetext += '<div class="form-group field_data toEndDateScheme_box">';
                    schemetext += '<input class="form-control box_form" name="date" id="toEndDateScheme" type="text" placeholder="To Date" readonly>';
                    schemetext += '</div>';
                    schemetext += '</form>';
                    schemetext += '</div>';
                    $(".modal-footer-button").show();
                    $(".se-pre-con").hide();
                    $(".scheme-form-set").append(schemetext);
                    $(".productView").append(product);
                    $(".divisionView").append(division);
                    $(".divisionView").on('change', function() {
                        let divisionToken = $(this).val();
                        let divisionobj = {
                            dashboard_code: verfication_code,
                            divisionToken: divisionToken,
                            type: 'divisionToken'
                        }
                        var json_data = JSON.stringify(divisionobj);
                        //console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/singleDivisionDetails.php",
                            data: json_data,
                        }).done(function(datas) {
                            let data = datas.data;
                            // console.log(datas);
                            let html_text = '<option value="">Select Division</option>';

                            data.forEach(function(item, index) {
                                html_text += `<option value="${item.token}">${item.name}</option>`;
                            });
                            productdivisionchange = html_text;
                            $('.productView').select2({
                                closeOnSelect: false,
                                placeholder: "Please select Product"
                            });
                            $(".productView").html(html_text);
                            $(".productGlobal").html(html_text);
                        });
                    });
                    $('#fromStatDateScheme').datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        minDate: 'today',
                        maxDate: '+2Y'
                    });
                    $('#toEndDateScheme').datepicker({
                        autoclose: true,
                        todayHighlight: true,
                        minDate: 'today',
                        maxDate: '+2Y'
                    });

                    //hide and show
                    $("#differentcheckbox").click(function() {
                        $(".product_division_box").show();
                        $(".product_division_box").show();
                    });
                    $("#samecheckbox").click(function() {
                        if ($(this).is(":checked")) {
                            $(".product_division_box").hide();
                            $(".product_division_box").hide();
                        }
                    });

                    // multi select
                    $("#selectordist").chosen({
                        allow_single_deselect: true
                    });

                    $('#addscheme').modal('show');
                } else {
                    var datas = {
                        dashboard_code: verfication_code,
                        type: "ViewAddedScheme",
                        product_token: prod_token_number
                    };
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/productList.php",
                        data: json_data,
                    }).done(function(data) {
                        var schemedata = data.data;
                        schemedata.forEach(function(item, index) {
                            console.log('item :', item);
                            $("#myModalLabel").text(item.free_product);
                            token = item.product_token;
                            schemetext += '<div class="form-control ">';
                            schemetext += '<p class="scheme_name">Scheme Name</p>';
                            schemetext += '<input class="input-field" id="scheme_name" value="' + item.scheme_name + '" readonly>';
                            schemetext += '</div>';
                            schemetext += '<div class="flex-set">';
                            schemetext += '<div class="form-control">';
                            schemetext += '<p class="buy_product_box_count">Buy</p>';
                            schemetext += '<input class="input-field" id="buy_product_box_count" value="' + item.limit_box + '" readonly>';
                            schemetext += '</div>';
                            schemetext += '<div class="form-control cust-select-box">';
                            schemetext += '<p class="division_name">UOM</p>';
                            schemetext += '<input class="input-field uom_type_box" value="Box" readonly>';
                            schemetext += '</div>';
                            schemetext += '</div>';
                            schemetext += '<div class="flex-set">';
                            schemetext += '<div class="form-control">';
                            schemetext += '<p class="get_product_box_count">Get</p>';
                            schemetext += '<input class="input-field" id="get_product_box_count" value="' + item.free_box + '" readonly>';
                            schemetext += '</div>';
                            schemetext += '<div class="form-control cust-select-box">';
                            schemetext += '<p class="division_name">UOM</p>';
                            schemetext += '<input class="input-field uom_type_box" value="Box" readonly>';
                            schemetext += '</div>';
                            schemetext += '</div>';
                            schemetext += '<div class="sale-head-right">';
                            schemetext += '<form class="formdield">';
                            schemetext += '<div class="form-group field_data">';
                            schemetext += '<input class="form-control box_form" name="date" id="fromStatDateScheme" type="text" value="' + item.start_date + '" readonly>';
                            schemetext += '</div>';
                            schemetext += '<div class="form-group field_data">';
                            schemetext += '<input class="form-control box_form" name="date" id="toEndDateScheme" type="text" value="' + item.end_date + '" readonly>';
                            schemetext += '</div>';
                            schemetext += '</form>';
                            schemetext += '</div>';
                        });

                        $(".modal-footer-button").hide();
                        $(".se-pre-con").hide();
                        $(".scheme-form-set").append(schemetext);
                        $('#addscheme').modal('show');

                        //deactivate
                        $("body").on("click", ".btndeact", function() {
                            let datas = {
                                dashboard_code: verfication_code,
                                type: "deactivate_scheme",
                                product_token: product_token
                            }
                            let data = JSON.stringify(datas);
                            //console.log(data);
                            swal({
                                title: `Are you sure you want to Deactivate the Scheme?`,
                                icon: "warning",
                                buttons: [
                                    'No, cancel it!',
                                    'Yes, I am sure!'
                                ],
                                dangerMode: true,
                            }).then(function(isConfirm) {
                                if (isConfirm) {
                                    $.ajax({
                                        type: "POST",
                                        dataType: "json",
                                        url: api_path + "/admin/productList.php",
                                        data: data,
                                    }).done(function(data) {
                                        if (data.code == 201) {
                                            swal(data.message, {
                                                icon: "success",
                                            }).then((value) => {
                                                location.reload();
                                            });
                                        } else {
                                            swal("Something Went Wrong!");
                                        }
                                    })
                                } else {
                                    swal("Cancelled", "", "error");
                                }
                            })
                        })
                        // })

                    });

                }
            });

            function addSchemeProduct() {
                var check = $("#samecheckbox").is(":checked");
                if (check == true) {
                    differproducttoken = 0;
                    var department = $('#selectordist :selected').val();
                    var scheme_name = $("#scheme_name").val();
                    var val1 = value_check('scheme_name', scheme_name, 'text_box');
                    var buy_product_box = $("#buy_product_box_count").val();
                    var val2 = value_check('buy_product_box_count', buy_product_box, 'text_box');
                    var get_product_box = $("#get_product_box_count").val();
                    var val3 = value_check('get_product_box_count', get_product_box, 'text_box');
                    var fromStatDateScheme = $("#fromStatDateScheme").val();
                    var val4 = value_check('fromStatDateScheme', fromStatDateScheme, 'text_box');
                    var toEndDateScheme = $("#toEndDateScheme").val();
                    var val5 = value_check('toEndDateScheme', toEndDateScheme, 'text_box');
                    if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true) {
                        $(".se-pre-con").show();
                        $('#add_scheme_product').prop('disabled', true);
                        var datas = {
                            'dashboard_code': verfication_code,
                            'department': department,
                            'scheme_name': scheme_name,
                            'buy_product_box': buy_product_box,
                            'get_product_box': get_product_box,
                            'product_token': product_token,
                            'differproducttoken': differproducttoken,
                            'additional_offer': "Buy " + buy_product_box + " Box get " + get_product_box + " Box free",
                            'from_Date': fromStatDateScheme,
                            'to_Date': toEndDateScheme,
                            'type': 'AddSchemeForProduct'
                        }
                        var json_data = JSON.stringify(datas);
                        //console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/productList.php",
                            data: json_data,
                        }).done(function(data) {
                            $(".se-pre-con").hide();
                            if (data.code == "201") {
                                $('#addscheme').modal('hide');
                                swal("Scheme Added Successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            } else {
                                $(".se-pre-con").hide();
                                $('#add_scheme_product').prop('disabled', false);
                                swal(data.message);
                            }
                        });
                    }
                } else {
                    var department = $('#selectordist :selected').val();
                    var differproducttoken = [];
                    $('#product_view2 :selected').each(function() {
                        differproducttoken.push($(this).val());
                    });
                    var scheme_name = $("#scheme_name").val();
                    var val1 = value_check('scheme_name', scheme_name, 'text_box');
                    var buy_product_box = $("#buy_product_box_count").val();
                    var val2 = value_check('buy_product_box_count', buy_product_box, 'text_box');
                    var get_product_box = $("#get_product_box_count").val();
                    var val3 = value_check('get_product_box_count', get_product_box, 'text_box');
                    var fromStatDateScheme = $("#fromStatDateScheme").val();
                    var val4 = value_check('fromStatDateScheme', fromStatDateScheme, 'text_box');
                    var toEndDateScheme = $("#toEndDateScheme").val();
                    var val5 = value_check('toEndDateScheme', toEndDateScheme, 'text_box');
                    if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true) {
                        var datas = {
                            'dashboard_code': verfication_code,
                            'department': department,
                            'scheme_name': scheme_name,
                            'buy_product_box': buy_product_box,
                            'get_product_box': get_product_box,
                            'product_token': product_token,
                            'differproducttoken': differproducttoken,
                            'additional_offer': "Buy " + buy_product_box + " Box get " + get_product_box + " Box free",
                            'from_Date': fromStatDateScheme,
                            'to_Date': toEndDateScheme,
                            'type': 'AddSchemeForProduct'
                        }
                        var json_data = JSON.stringify(datas);
                        //console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/productList.php",
                            data: json_data,
                        }).done(function(data) {
                            $(".se-pre-con").hide();
                            if (data.code == "201") {
                                $('#viewGlobal').modal('hide');
                                swal("Scheme Added Successfully!", {
                                    icon: "success",
                                }).then((value) => {
                                    location.reload();
                                });
                            } else {
                                $(".se-pre-con").hide();
                                $('#add_scheme').prop('disabled', false);
                                swal(data.message);
                            }
                        });
                    }
                }
            }

            //global scheme
            function addSchemeProductGlobal() {
                var department = $('#selectordist :selected').val();
                var product_token = [];
                $('#product_view :selected').each(function() {
                    product_token.push($(this).val());
                });
                var differproducttoken = [];
                $('#product_option :selected').each(function() {
                    differproducttoken.push($(this).val());
                });
                var scheme_name = $("#scheme_name").val();
                var val1 = value_check('scheme_name', scheme_name, 'text_box');
                var buy_product_box = $("#buy_product_box_count").val();
                var val2 = value_check('buy_product_box_count', buy_product_box, 'text_box');
                var get_product_box = $("#get_product_box_count").val();
                var val3 = value_check('get_product_box_count', get_product_box, 'text_box');
                var fromStatDateScheme = $("#fromStatDateScheme").val();
                var val4 = value_check('fromStatDateScheme', fromStatDateScheme, 'text_box');
                var toEndDateScheme = $("#toEndDateScheme").val();
                var val5 = value_check('toEndDateScheme', toEndDateScheme, 'text_box');
                if (val1 == true && val2 == true && val3 == true && val4 == true && val5 == true) {
                    var datas = {
                        'dashboard_code': verfication_code,
                        'department': department,
                        'scheme_name': scheme_name,
                        'buy_product_box': buy_product_box,
                        'get_product_box': get_product_box,
                        'product_token': product_token,
                        'differproducttoken': differproducttoken == "" ? 0 : differproducttoken,
                        'additional_offer': "Buy " + buy_product_box + " Box get " + get_product_box + " Box free",
                        'from_Date': fromStatDateScheme,
                        'to_Date': toEndDateScheme,
                        'type': 'AddSchemeForProduct'
                    }
                    var json_data = JSON.stringify(datas);
                    //console.log(json_data);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/productList.php",
                        data: json_data,
                    }).done(function(data) {
                        console.log(data);
                        $(".se-pre-con").hide();
                        if (data.code == "201") {
                            $('#viewGlobal').modal('hide');
                            swal("Scheme Added Successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            $(".se-pre-con").hide();
                            $('#add_scheme').prop('disabled', false);
                            swal(data.message);
                        }
                    });
                }
                $('.productView').select2({
                    closeOnSelect: false,
                    placeholder: "Please select Area"
                });
            }

            //csv download
            //    function show_ProductCSV(){
            //        var csv_data = [];
            //        var rows = document.getElementsByTagName('tr');
            //        for (var i = 0; i < rows.length; i++) {
            //            var cols = rows[i].querySelectorAll('td,th');
            //            var csvrow = [];
            //            for (var j = 0; j < cols.length; j++) {
            //                csvrow.push(cols[j].innerText.replace("/<a.*>.*?<\/a>/ig,''"));
            //               
            //            }
            //            csvrow.pop(cols[7].innerHTML);
            //            csvrow.pop(cols[8].innerHTML);    
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
            //        temp_link.download = "ProductList.csv";
            //        var url = window.URL.createObjectURL(CSVFile);
            //        temp_link.href = url;
            //        temp_link.style.display = "none";
            //        document.body.appendChild(temp_link);
            //        temp_link.click();
            //        document.body.removeChild(temp_link);
            //}

            //pdf download
            //function show_ProductPDF(){
            //    var data={
            //        'invoice_name': "",
            //    }
            //    $.ajax({
            //                type: "POST",
            //                dataType: "json",
            //                url : "../TCPDF-main/examples/ProductListPdf.php",
            //                data: data,
            //                }).done(function(data) {
            //                    if(data.status_code==200){
            //                    $(".se-pre-con").hide();
            //                    window.open('../invoice_pdf/'+data.data, '_blank');
            //                    }else{
            //                        swal("Something Happened!", {icon: "failed"});
            //                    }
            //                });
            //}




            // Voice Search Implementation
$(document).ready(function() {
 
    setTimeout(function() {
        initializeVoiceSearch();
    }, 1000);
});

function initializeVoiceSearch() {
    const micButton = document.getElementById('micButton');
    
    if (!micButton) {
        console.log('Microphone button not found');
        return;
    }
    
   
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    
    if (!SpeechRecognition) {
        micButton.style.display = 'none';
        console.log('Speech Recognition not supported');
        return;
    }
    
    const recognition = new SpeechRecognition();
    recognition.lang = 'en-US'; 
    recognition.interimResults = false;
    recognition.maxAlternatives = 1;
    recognition.continuous = false;
    
    let isListening = false;
    
    micButton.addEventListener('click', function() {
        if (isListening) {
            recognition.stop();
            return;
        }
        
        try {
            recognition.start();
            isListening = true;
            micButton.classList.add('listening');
            
            const searchInput = document.querySelector('input[type="search"]');
            const originalPlaceholder = searchInput.placeholder;
            searchInput.placeholder = '🎤 Listening...';
            
            setTimeout(() => {
                if (isListening) {
                    searchInput.placeholder = originalPlaceholder;
                }
            }, 5000);
            
        } catch (error) {
            console.error('Speech recognition error:', error);
            isListening = false;
            micButton.classList.remove('listening');
        }
    });
    
    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        console.log('Voice input:', transcript);
        
        const searchInput = document.querySelector('input[type="search"]');
        
        if (searchInput) {
            searchInput.value = transcript;
            
            if (typeof table !== 'undefined' && table) {
                table.search(transcript).draw();
            }
            
            searchInput.placeholder = '✓ ' + transcript;
            setTimeout(() => {
                searchInput.placeholder = 'Search or speak...';
            }, 2000);
        }
        
        isListening = false;
        micButton.classList.remove('listening');
    };
    
    recognition.onerror = function(event) {
        console.error('Speech recognition error:', event.error);
        isListening = false;
        micButton.classList.remove('listening');
        
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
            searchInput.placeholder = 'Search or speak...';
        }
        
        if (event.error === 'not-allowed') {
            alert('Microphone access denied. Please allow microphone permission.');
        } else if (event.error === 'no-speech') {
            console.log('No speech detected');
        }
    };
    
    recognition.onend = function() {
        isListening = false;
        micButton.classList.remove('listening');
        
        const searchInput = document.querySelector('input[type="search"]');
        if (searchInput) {
            searchInput.placeholder = 'Search or speak...';
        }
    };
}



            
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>