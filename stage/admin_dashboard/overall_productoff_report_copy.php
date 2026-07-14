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
    <link rel="stylesheet" href="css/select2.min.css<?php echo $js_cache_string; ?>">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>

</head>
<style> 
.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: 1px solid #ccc !important;
                outline: 0;
}
.select2-container--default .select2-selection--multiple{
    border: 1px solid #ccc !important;
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
#item_code_color{
    color:red;
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

.inventory-top {
    width: 80%;
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
.modal-input:checked ~ .cust-checkbox {
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
    .bodyheight{
    height: 400px;
    }
    /* image upload  */
    .custom-file {
        display: block;
        width: 180px;
        height: 40px;
        border: #00b9f5 1px solid;
        color: #00b9f5;
        border-radius: 4px;
        cursor: pointer;
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

    @media (min-width: 576px){
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
    .modal-input:checked ~ .cust-checkbox::before {
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
    #removeGiftField{
        margin: 15px 0;
    }
    .remove-btn:hover {
        background-color: #fff;
        color: #f44336;
    }
    .modal-footer .createScheme-btn{
        font:16px var(--semibold-font);
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
    #product{
        display: none;
    }
    /* multi select */
    .select2-container{
        margin-right: 10px;
    }
    .select2-container--default .select2-selection--multiple {
    height: 60px;
    overflow: scroll;
}
.select2-selection--multiple::-webkit-scrollbar {
	width: 3px;
    display: block;
}
.select2-selection--multiple::-webkit-scrollbar-track {
	background-color: rgb(255, 255, 255);
	-webkit-border-radius: 1px;
}
.select2-selection--multiple::-webkit-scrollbar-thumb:vertical {
	background-color: rgb(142, 142, 142);
	-webkit-border-radius: 0px;
    -webkit-width:5;
}
.select2-selection--multiple::-webkit-scrollbar-thumb:vertical:hover {
	background: rgba(0, 245, 255, 0.65);
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
                    <h1 class="header_main">Over All Products Offer Report </h1>
                    <p class="table_count">Total - <span id="total_count"></span></p>
                </div>
            </div>
            <!-- Nav tabs -->
            <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="fromDate"  type="text" placeholder="From Date" readonly>
                        </div>
                        <div class="form-group">
                            <input class="form-control box_form" name="date" id="toDate"  type="text" placeholder="To Date" readonly>
                        </div>
                    </form>
                    
                    <form class="formdield">
                        <div class="form-group">
                        <select class="myselect input-field" multiple="multiple"  style="width: 270px" id="state_filter">
                        </select>
                        </div>
                        <div class="form-group">
                        <select class="myselect input-field" multiple="multiple"  style="width: 270px" id="division">
                                        </select>
                        </div>
                        <div class="form-group">
                        <select class="myselect input-field" multiple="multiple"  style="width: 270px" id="product">
                                        </select>
                        </div>
                        <div class="form-group">
                            <button id="stateGoBtn" type="button"  class="primary-btn" >Go</button>
                        </div>
                    </form>
                </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th class="sum">Discount</th>
                                <th>Total Sales Amount</th>
                            </tr>
                        </thead>
                        <tbody id="table_body"></tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
    <!-- Add Scheme Modal -->
    <div class="modal fade" id="addscheme" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Add Scheme</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bodyheight">
                    <div class="scheme-form-set" >
                    <div id="removeGiftField"><div class="flex-set"> 
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
                    
                    <div class="form-control">
                    <p class="product_division">Division<span style="color:red">*</span></p>
                    <select class="input-field " id="product_division">
                    </select>
                    </div>
                    <div class="form-control ">
                    <p class="product_division">Product<span style="color:red">*</span></p>
                    <select class="input-field" id="product_view"> </select>
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
                    <select class="mySelect for input-field divisionView" id="product_division1">
                    </select>
                    </div>
                    <div class="form-control product_division_box" style="display:none">
                    <p class="product_division">Product<span style="color:red">*</span></p>
                    <select class="input-field" id="product_view1" multiple="multiple"> </select>
                    </div>
                    <div class="flex-set">
                    <div class="form-control get_product_box_count_box">
                    <p class="get_product_box_count">Get</p>
                    <input class="input-field" id="get_product_box_count" onkeypress="return isNumber(event)" placeholder="Enter the free box count">
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
                    </form>
                    </div>
                    <div class="form-control img---uplod" style="border: none;">
                                        <h6 style='    text-align: start;'>Attach</h6>
                                        <label for="product_scheme_image_upload" style='text-align: start;'>
                                            <div class="custom-file">
                                                <input id="product_scheme_image_valid" type="hidden">    
                                                <input id="product_scheme_image_upload" onchange="file_upload_scheme('product_scheme_image','product_scheme_image_url','assets/upload.png')"  type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                                <h5><span><img class="fa-upload" src="assets/upload_image_arrow_icon.png" /></span> Upload Image</h5>
                                            </div>
                                            <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="product_scheme_image_url"/>
                                            <span>Image format should be in jpg/png/</span>
                                        </label>
                                    </div>
                    </div> 
                </div>
                <div class="modal-footer modal-footer-button">
                    <button type="button" class="createScheme-btn" id="add_scheme_product" onclick="addschemeProductSameCheck()">Create Scheme</button>
                </div>
            </div>
        </div>
    </div>
    </div>


     <!-- EDIT Scheme Modal -->
     <div class="modal fade" id="editscheme" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" >Edit Scheme</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bodyheight">
                <input id="edit_token" type="hidden">
                <input id="edit_product_token" type="hidden">
                <input id="edit_free_token" type="hidden">
                    <div class="form-control scheme_name_box">
                    <p class="scheme_name">Scheme Name</p>
                    <input class="input-field" id="edit_scheme_name" placeholder="Enter Scheme Name">
                    </div>
                    <div class="flex-set">
                    <div class="form-control buy_product_box_count_box">
                    <p class="buy_product_box_count">Buy</p>
                    <input class="input-field" id="edit_buy_product_box_count" onkeypress="return isNumber(event)" placeholder="Enter the buy box count">
                    </div>
                    <div class="form-control cust-select-box">
                    <p class="division_name">UOM</p>
                    <input class="input-field uom_type_box" value="Box" readonly>
                    </div>
                    </div>
                    
                    <div class="flex-set">
                    <div class="form-control get_product_box_count_box">
                    <p class="get_product_box_count">Get</p>
                    <input class="input-field" id="edit_get_product_box_count" onkeypress="return isNumber(event)" placeholder="Enter the free box count">
                    </div>
                    <div class="form-control cust-select-box">
                    <p class="division_name">UOM</p>
                    <input class="input-field uom_type_box" value="Box" readonly>
                    </div>
                    </div>
                    <div class="sale-head-right">
                    <form class="formdield">
                    <div class="form-group field_data fromStatDateScheme_box">
                    <input class="form-control box_form" name="date" id="edit_fromStatDateScheme" type="text" placeholder="From Date" readonly>
                    </div>
                    <div class="form-group field_data toEndDateScheme_box">
                    <input class="form-control box_form" name="date" id="edit_toEndDateScheme" type="text" placeholder="To Date" readonly>
                    </div>
                    </form>
                    </div>
                </div>
                <div class="modal-footer modal-footer-button">
                    <button type="button" class="createScheme-btn" id="edit_scheme_product" onclick="updateScheme()">Edit Scheme</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery CDN -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    
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

    var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table1;
    var fromDate;
    var toDate;
        $(".se-pre-con").hide();
        //hide and show
        $("#differentcheckbox").click(function(){
            $(".product_division_box").show();
            $(".product_division_box").show();
        });
        $("#samecheckbox").click(function(){
            if($(this).is(":checked")){
            $(".product_division_box").hide();
            $(".product_division_box").hide();

            }
        });
    //     var placeholder = "select";
    //    $(".mySelect").select2({
    //         data: data,
    //         placeholder: placeholder,
    //         allowClear: false,
    //         minimumResultsForSearch: 5
    //     });
    //     var placeholder = "select";
    //     $(".myselect").select2({
    //         data: data,
    //         placeholder: placeholder,
    //         allowClear: false,
    //         minimumResultsForSearch: 5
    //     });
         //date picker
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = yyyy + '-' + mm + '-' + dd;
        $('#datePicker').attr('min',today);
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
    </script>
    <script>
    $(document).ready(function() {
//allstate
            let state = {
                type: "allstate",
                
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
                $('#state_filter').html(html_text);
                $('#state_filter').select2({
                            closeOnSelect: false,
                            placeholder: "Please select State"
                        });
            });

            let division = {
                type: "all"
            };
            var json_data1 = JSON.stringify(division);
            console.log(json_data1);
            $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/singleDivisionDetails.php",
            data: json_data1,
        }).done(function(datas) {
            console.log('data',datas);
            var data = datas.data;
            var html_text1 = '<option value="">Select Division</option>';
            for (var key in data) {
                html_text1 += '<option class="all" value="' + data[key].division_token + '">' + data[key]
                    .division_name + '</option>';
            }
            division = html_text1;
            $("#division").html(html_text1);
            $('#division').select2({
                            closeOnSelect: false,
                            placeholder: "Please select division"
                        });
                    });

            let data = {
                type: "all"
            };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/overall_item_product_report.php",
                    data:json_data,
                }).done(function(data){
                   success(data);
                   console.log(data);
                });
            });
                            
    var table_main_data;
        function success(data) {
        //     table_main_data = data.data;
        //     console.log(data);
        //     var html_text = "";
        //     var slno = 0;
        //      for (var key in table_main_data) {
        //         slno++;
        //         html_text += '<tr>';
        //         html_text += '<td>'+slno+'</td>';
        //         var images = table_main_data[key].image
        //         if(images!=''){
        //         html_text += '<td><img src="' + images + '" alt="" width="100" height="100"></td>';
        //         }else{
        //             html_text += '<td>-</td>';
        //         }
        //         html_text += '<td>' + table_main_data[key].scheme_name + '</td>';
        //             html_text += '<td>' + table_main_data[key].limit_box + '</td>';
        //             html_text += '<td>' + table_main_data[key].free_product_box + '</td>';
        //             html_text += '<td>' + table_main_data[key].product_name + '</td>';
        //             html_text += '<td>' + table_main_data[key].buy_box + '</td>';
        //             html_text += '<td>' + table_main_data[key].free_box + '</td>';
        //             html_text += '<td>' + table_main_data[key].free_product + '</td>';
        //         html_text += '</tr>';
        //     }
        //     $(".se-pre-con").hide();
        //     $("#total_count").html(slno);
        //     $("#table_body").html(html_text);
        //     table1 = $("#table_data").DataTable({
        //         dom: 'Bfrtip',
        //         buttons: [{
        //                         extend: 'pdfHtml5',
        //                         className: 'btn-primary buttonprint',
        //                         exportOptions: {
        //                            columns: [0,2,3,4,5,6]
        //                         },
        //                         orientation: 'landscape',
        //                         pageSize: 'LEGAL'
        //                      },{
        //                         extend: 'csv',
        //                         className: 'btn-info buttonprint',
        //                         exportOptions: {
        //                            columns: [0,2,3,4,5,6]
        //                         },
        //                         orientation: 'landscape',
        //                         pageSize: 'LEGAL'
        //                      }],
        //         "columnDefs": [
        //             {
        //                 "targets": [ 0 ],
        //                 "visible": false,
        //                 "searchable": false
        //             }
        //         ],
        //         language: {
        //             search: '<img src="assets/svg/Search_icon.svg">',
        //             searchPlaceholder: "Search",
        //             paginate: {
        //                 next: '<img src="assets/svg/Right_arrow_icon.svg">',
        //                 previous: '<img src="assets/svg/Left_arrow_icon.svg">'
        //             }
        //         }
        //     });
         }

         let areaDisToken = [];
         $('#division').on("select2:select", function (e) { 
        //  $(document).on("change","#division",function(){
            $('#division :selected').each(function() {
                areaDisToken.push($(this).val());
            });
                        var result = [];
            $.each(areaDisToken, function(i, e) {
                if ($.inArray(e, result) == -1) result.push(e);
            });
                var data = {
                    type: "products",
                    division_token : result
                } 
                var json_data = JSON.stringify(data);
                console.log(json_data);
                $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/admin/singleDivisionDetails.php",
            data: json_data,
        }).done(function(datas) {
            console.log('data',datas);
            var data = datas.data;
            var html_text1 = '<option class="all" value="">Select Division</option>';
            for (var key in data) {
                html_text1 += '<option value="' + data[key].products_token + '">' + data[key].products_name + '</option>';
            }
            division = html_text1;
            $("#product").html(html_text1);
            $('#product').select2({
                            closeOnSelect: false,
                            placeholder: "Please select division"
                        });
                    });
                    $("#product").show();

         });
        //  let prodocutss = [];
        //  var results = [];
        //  $('#product').on("select2:select", function (e) {  
        //     $('#product :selected').each(function() {
        //         prodocutss.push($(this).val());
        //     });            
        //     $.each(prodocutss, function(i, e) {
        //         if ($.inArray(e, results) == -1) results.push(e);
        //     });
        //     //console.log("results",results);
        //  });
           
         $("#stateGoBtn").on("click",function(){
            fromDate = $("#fromDate").val();
            toDate = $("#toDate").val();
            if (fromDate != ""  && toDate != '') {
                let state = [];
            $('#state_filter :selected').each(function() {
                state.push($(this).val());
            });   
            let division_token = [];
            $('#division :selected').each(function() {
                division_token.push($(this).val());
            });  
            let prodocutss = [];
            $('#product :selected').each(function() {
                prodocutss.push($(this).val());
            });   
            var json_data = ""
            if (prodocutss.length != 0) {
                var data = {
                    type : "generel",
                    type1 : 'three',
                    state : state,
                    division_token: division_token,
                    prodocutss : prodocutss,
                    fromDate: fromDate,
                    toDate:toDate
                }
                 json_data = JSON.stringify(data);
            }else {
                var data1 = {
                    type : "generel",
                    type1 : 'tow',
                    state : state,
                    division_token: division_token,
                    fromDate: fromDate,
                    toDate:toDate
                }
                 json_data = JSON.stringify(data1);
            }
            console.log('myjson_data',json_data);
                    $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/overall_item_product_report.php",
                    data: json_data,
                }).done(function(res_datas) {
                    var html_text = '';
                    let name1='';
                    let name2='';
                    let sum = 0;
                    let sum1 = '';
                    console.log('sum',res_datas.data[9].total_sales_amount);
                    res_datas.data.forEach(function(item,index){
                        html_text += '<tr>';

                        if (name1 != item.state_name && name2 != item.division_name) {
                            name1=item.state_name;
                            name2 =item.division_name;
                            html_text += '<td>'+ name1 +'<div><span>'+name2+'</span></div></td>';
                        }else if(name1 == item.state_name && name2 == item.division_name){
                             html_text += '<td>'+ item.product_name +'</td>';
                        }
                        // html_text += '<td>'+  +'</td>';
                         html_text += '<td>'+ item.quantity +'</td>';
                         html_text += '<td>'+ item.price_per_unit +'</td>';
                        //  html_text += '<td>'+ +'</td>'
                         html_text += '<td>'+ item.total_offer_amount +'</td>';
                         html_text += '<td>'+ item.total_sales_amount +'</td>';
                        html_text += '</tr>';
                    });
                    $('#table_body').html(html_text);
                    console.log(res_datas.data);
                        table1 = $("#table_data").DataTable({
                        dom: 'Bfrtip',
                        "initComplete": function (settings, json) {
                        if((this.api().data().length) > 0){
                            this.api().columns('.sum').every(function () {
                                var column = this;

                                var sum = column
                                .data()
                                .reduce(function (a, b) { 
                                    a = parseInt(a, 10);
                                    if(isNaN(a)){ a = 0; }
                                    
                                    b = parseInt(b, 10);
                                    if(isNaN(b)){ b = 0; }
                                    
                                    return a + b;
                                });
                                $(column.footer()).html('Sum: ' + sum);
                            });
                        }else{
                            // this.api().clear('.sum');
                            table1.column('.sum').visible(false);
                        }
                        },
                        buttons: [{
                                        extend: 'pdfHtml5',
                                        className: 'btn-primary buttonprint',
                                        exportOptions: {
                                        columns: [0,2,3,4,5,6]
                                        },
                                        orientation: 'landscape',
                                        footer: true,
                                        pageSize: 'LEGAL'
                                    },{
                                        extend: 'csv',
                                        className: 'btn-info buttonprint',
                                        exportOptions: {
                                        columns: [0,2,3,4,5,6]
                                        },
                                        orientation: 'landscape',
                                        footer: true,
                                        pageSize: 'LEGAL'
                                    }],
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
                })
            
            }else{
                swal('Please select all dropdown value');
            }        
         });


    </script>

</body>

</html>
<?php
}
mysqli_close($link);
?>