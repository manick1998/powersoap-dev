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
    .a_button{
        color: #00b9f5;
    }
    .edit_input{
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
    height: 50px;
    color: #fff;
    margin: 0 10px;
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
    .btn_employee {
        width: 150px !important;
    }
    .attach_img img {
        border: 1px solid #ccc;
        margin: 5px;
        width: 100px;
        height: 100px;
        object-fit: contain;
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
<div class="sidebar" id="sidebar44"></div>
<!-- main-contents -->
<main class="main-contents">
    <section class="bg-white brad-4 full-height" id="retailer_table">
        <div class="header_container">
            <div class="header-section">
                <div>
                    <h1 class="header_main">Retailer View List</h1>
                </div>
                <p class="table_count">Total Retailer - <span id="total_retailer_count"></span></p>
            </div>
        </div>
        <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
            <!-- <li class="nav-item " role="">
                <button onclick="show_RetailerCSV()" class="nav-link active" >CSV</button>
            </li>
            <li class="nav-item " role="">
                <button onclick="show_RetailerPDF()"  class="pdf-btn" >PDF</button>
            </li> -->
            <li class="nav-item " role="">
            <div class="form-group"> 
                    <button class="btn_employee "class="btn btn-danger" data-toggle="modal" data-target="#form" type="button"><span><img src="assets/retailer.png" class="icon_add"></span> Add Retail</button>
                </div>
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
                        <th>Type</th>
                        <th>Mobile Number</th>
                        <th>Contact Person</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Joining Date</th>
                        <th>GST Number</th>
                        <th>Remove Mapping</th>
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
                    <h4 class="modal-title" id="myModalLabel">Add Retailer</h4>
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
                                 <option value="52373582">Departmental Store</option>
                                 <option value="49856576">Supermarket</option>
                                 <option value="80189244">Hypermarket</option>
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
                                <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="retailer_view_image_url"/>
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
                    <h4 class="modal-title" id="myModalLabel">Edit Retailer</h4>
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
                                 <option value="">Select Shop Type</option>
                                 <option value="52373582">Departmental Store</option>
                                 <option value="49856576">Supermarket</option>
                                 <option value="80189244">Hypermarket</option>
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
                                <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="edit_retailer_view_image_url"/>
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
</main>
<script>
    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var admin_state_id = "<?php echo $cookie_admin_state; ?>";
</script>    
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
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
<script src="js/function.js<?php echo $js_cache_string; ?>"></script>   
<script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
<script>
     function back_view_retailer(){
         $("#retailer_table").show();
        $("#retailer_view").hide();
    }
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    let distributor_token = localStorage.getItem("distributor_token");
    var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
    console.log('admin_token',admin_token);
    $(document).ready(function(){
        let datas = {
            dashboard_code: verfication_code
        }
        let jdata = JSON.stringify(datas);

        console.log(jdata);

        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/list_shop_types.php",
            data: jdata,
        }).done(function(data){
          let shopTypeData = data;
    var optionText;
    optionText += '<option value="">Select Shop Type</option>';
    for (var key in shopTypeData) {
        optionText += '<option value="' + shopTypeData[key].shop_token + '">' + shopTypeData[key].shop_type + '</option>';
    }
    $("#shop_type").html(optionText);
        });
    });
   

    $(document).ready(function () {
       
        var datas = {
            dashboard_code: verfication_code,
            state_id: admin_state_id,
            distributor_token :distributor_token,
            type: "distributor_count"
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/retailerDetails.php",
            data: json_data,
        }).done(function(data) {
            var count = data.data;
            $("#total_retailer_count").html(numberWithCommas(count));
        });
        
    });
    
    $(document).ready(function () {
        // var rep_token = '';
        $(".se-pre-con").hide();
        table = $('#table_data').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            "aoColumnDefs": [
                { "bSortable": false, "aTargets": [ 0 ] }, 
            ],
            'ajax': {'url':api_path+"/admin/serverDistributorRetailerList.php?v_id="+verfication_code+"&state_id="+admin_state_id+"&distributor_token="+distributor_token},
            pageLength: <?php echo $page_length; ?>,
            lengthMenu: [10,25,100,500,1000,5000,10000,100000],
            "order": [[0, "DESC" ]],
            'columns': [
                { data: 'token' },
                { data: 'retail_code' },
                { data: 'retailer_name' },
                { data: 'distributor' },
                { data: 'shop_type' },
                { data: 'mobile_number' },
                { data: 'contact_person' },
                { data: 'city' },
                { data: 'state' },
                { data: 'join_date' },
                { data: 'license_number' },
                { data: 'remove_btn' }
 
            ],
            dom: 'Bfrltip',
            language: {
                search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
            },
            buttons: [{
                                extend: 'pdfHtml5',
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [2,3,4,5,6,7]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                             },{
                                extend: 'csv',
                                className: 'btn-info buttonprint',
                                exportOptions: {
                                   columns: [2,3,4,5,6,7]
                                },
                                orientation: 'landscape',
                                pageSize: 'LEGAL'
                 }]
          
          
        });
        // console.log(rep_token);
        // console.log(table.columns.data);
        table.column(0).visible(false);
        $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");
    });
    
        $('#table_data tbody').on( 'click', '.item_code_view', function () {
        var td_div = $(this).parent().parent();
        var table_data = table.row( td_div ).data();
        var token = table_data.token;
        var datas = {
            dashboard_code: verfication_code,
            type: "single_retailer",
            retailer_token: token
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/admin/retailerDetails.php",
            data: json_data,
        }).done(function(data){
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
                if(retailer_data.license_image==""){
                    $("#single_shop_view_image").attr("src", "");
                    $("#single_shop_view_image").css("display", "none");
                }else{
                    $("#single_shop_view_image").attr("src", retailer_data.license_image);
                    $("#single_shop_view_image").css("display", "block");
                }
                if(retailer_data.shop_show_status=="Active"){
                    $(".de_activate").html('<span>Active Shop</span>');
                    $(".de_activate > span").css('color','green');
                    $(".de_activate > span").css('text-decoration','none');
                }else{
                    $(".de_activate").html('<span class="view_link">Inactive Shop</span>');
                    $(".de_activate > span").css('color','red');
                    $(".de_activate > span").css('text-decoration','none');
                }
                $("#retailer_table").hide();
                $("#retailer_view").show();
        });
    }); 


    function add_retailer(){
       var shop_name     = $("#shop_name").val();
       var val1          = value_check('shop_name',shop_name,'text_box');
       var contact_person= $("#contact_person").val();
       var val2          = value_check('contact_person',contact_person,'text_box');
       var contact_number= $("#contact_number").val();
       var val3          = value_check('contact_number',contact_number,'text_box');
       var shop_type     = $("#shop_type").val();
       var val4          = value_check('shop_type',shop_type,'text_box');
    //    var license_number= $("#license_number").val();
    //    var val5          = value_check('license_number',license_number,'text_box');
       var shop_address  = $("#shop_address").val();
       var val6          = value_check('shop_address',shop_address,'text_box');
       var shop_city     = $("#shop_city").val();
       var val7          = value_check('shop_city',shop_city,'text_box');
       var shop_pincode  = $("#shop_pincode").val();
       var val8          = value_check('shop_pincode',shop_pincode,'text_box');
    //    var shop_coordinates= $("#shop_coordinates").val();
    //    var val9          = value_check('shop_coordinates',shop_coordinates,'text_box');
    //    var retailer_image= $("#retailer_image_valid").val();
    //    var val10         = value_check('',retailer_image,'image');
       if(val1==true && val2==true && val3==true && val4==true &&  val6==true && val7==true && val8==true){
           $("#form").modal('hide');
           setTimeout(function () {  
               $(".se-pre-con").show();
           }, 5);
           $('#add_retailer_button').prop('disabled', true);
           image_upload_loop(0);
       }else{
           if(val1==true && val2==true && val3==true && val4==true &&  val6==true && val7==true && val8==true ){
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
    var image_id = ['retailer_image'];
    function image_upload_loop(key){
       var valid   = $("#"+image_id[key]+"_valid").val();
       var checkkey = key+1;
       if(valid=="true"){
           if(checkkey>image_id.length){
               add_retailer_finish(admin_token);
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
               add_retailer_finish(admin_token);
           }
       }
    }
    function add_retailer_finish(admin_token){
       var shop_name     = $("#shop_name").val();
       var contact_person= $("#contact_person").val();
       var contact_number= $("#contact_number").val();
       var shop_type     = $("#shop_type").val();
       var license_number= $("#license_number").val();
       var shop_address  = $("#shop_address").val();
       var shop_city     = $("#shop_city").val();
       var shop_pincode  = $("#shop_pincode").val();
       var shop_coordinates= $("#shop_coordinates").val();
       var retailer_image  = $("#retailer_image_valid").val();
       var datas ={
           'shop_name':shop_name,
           'contact_person':contact_person,
           'contact_number':contact_number,
           'shop_type':shop_type,
           'license_number':license_number,
           'shop_address':shop_address,
           'shop_city':shop_city,
           'shop_pincode':shop_pincode,
           'shop_coordinates':shop_coordinates,
           'distributor_token':distributor_token,
           'retailer_image':retailer_image,
           'dashboard_code':verfication_code,
           'admin_token':admin_token

       }
       var json_data = JSON.stringify(datas);
       console.log('admin',json_data);
       $.ajax({
           type: "POST",
           dataType: "json",
           url : api_path+"/admin/distributor_add_retailer.php",
           data: json_data,
       }).done(function(data) {
           $(".se-pre-con").hide();
           if(data.status_code=="200"){
               swal(data.message, {icon: "success",}).then((value) => {
                   location.reload();
               });
           }else{
               $("#form").modal('show');
               $('#add_employee_button').prop('disabled', false);
               swal(data.message);
           }
       });
    }
        // shop remove 
        var bool = true;
        $('#table_data tbody').on( 'click', '.button3', function () {
            swal({
                    title: "Are you sure?",
                    text: "You Want to Remove the shop?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                if (willDelete) {
                    var distributor_token =  $(this).attr('data-distributor_token');
                    var  shop_token =  $(this).attr('data-shop_token');
                    var data = {
                        type : "remove",
                        distributor_token : distributor_token,
                        shop_token : shop_token
                    }
                    var json_data = JSON.stringify(data);
                        $.ajax({
                        type: "POST",
                        dataType: "json",
                        url : api_path+"/admin/retailerDetails.php",
                        data: json_data,
                    }).done(function(data) {
                    $(".se-pre-con").hide();
                    if(data.status_code=="200"){
                        swal(data.message, {icon: "success",}).then((value) => {
                            location.reload();
                        });
                    }else{
                            swal(data.message);
                        }
                    });
                }
            });   
        });
    //upload CSV
    function show_RetailerCSV(){
        var csv_data = [];
        var rows = document.getElementsByTagName('tr');
        for (var i = 0; i < rows.length; i++) {
            var cols = rows[i].querySelectorAll('td,th');
            var csvrow = [];
            for (var j = 0; j < cols.length; j++) {
                csvrow.push(cols[j].innerText.replace("/<a.*>.*?<\/a>/ig,''"));
               
            } 
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

        temp_link.download = "RetailerList.csv";
        var url = window.URL.createObjectURL(CSVFile);
        temp_link.href = url;
        temp_link.style.display = "none";
        document.body.appendChild(temp_link);
        temp_link.click();
        document.body.removeChild(temp_link);
}
//upload PDF
    function show_RetailerPDF(){
    var data={
    'invoice_name': "",
    }
    $.ajax({
    type: "POST",
    dataType: "json",
    url : "../TCPDF-main/examples/retailerListPdf.php?state_id="+admin_state_id,
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
</body>
</html>
<?php
}
mysqli_close($link);
?>