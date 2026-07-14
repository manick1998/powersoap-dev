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
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css'>
</head>
<style> 
.select2-container--default.select2-container--focus .select2-selection--multiple {
                border: none !important;
                outline: 0;
}
.select2-container--default .select2-selection--multiple{
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
.input-field{
    outline: none;
}
.product_list button {
    margin-left: 0px;
    margin-top: 10px;
}
.main-contents .nav {
    width: 72%;
    gap: 20px;
    margin-left: 30px;
}
    .dt-buttons.btn-group {
        margin-left: 30px;
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
                    <h1 class="header_main"> Scheme Products Report</h1>
                    <p class="table_count">Total - <span id="total_count"></span></p>
                </div>
            </div>
            <!-- Nav tabs -->
            <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                <!-- <li class="nav-item " role="presentation"> -->
                    <!-- <button data-toggle="modal" data-target="#addscheme"  id="req_input" class="nav-link active"><span><img class="icon_add"
                                src="assets/product.svg" alt=""></span> Add Scheme</button> -->
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="fromDate" type="text" placeholder="From Date" readonly>
                            </div>
                            <div class="form-group">
                                <input class="form-control box_form" name="date" id="toDate" type="text" placeholder="To Date" readonly>
                            </div>
                            <div class="form-group">
                                <button type="button"  class="primary-btn" >Go</button>
                            </div>
                        </div> 
                <!-- </li>  -->

            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <!-- <th>Image</th> -->
                                <th>Scheme Name</th>
                                <th>Limit Box</th>
                                <th>Free Products Box</th>
                                <th>Product Name</th>
                                <th>Buy</th>
                                <th>Get</th>
                                <th>Free Item</th>
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
    var fromDate;
    var toDate;
    var table1;
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
    let data = {
        type: "all"
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/schemproduct_report.php",
                    data:json_data,
                }).done(function(data){
                   success(data);
                   console.log(data);
                });
            });

            // $(document).on('click','.primary-btn',function(){
             $(".primary-btn").click(function(){
                $('#table_data').DataTable().destroy();
                // $(".se-pre-con").fadeIn();
                    fromDate = $("#fromDate").val();
                    toDate = $("#toDate").val();
                    if (fromDate != ""  && toDate != '') {
                        let region = {
                            type :"datefilter",
                            fromDate: fromDate,
                            toDate: toDate
                        };
                        var json_data = JSON.stringify(region);
                        console.log(json_data);
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: api_path + "/admin/schemproduct_report.php",
                            data:json_data,
                        }).done(function(data){
                            
                        success(data);
                        
                        });
                    }else{
                        swal('Please select all dropdown value');
                    }                     
            });
                            
    var table_main_data;
        function success(data) {
            table_main_data = data.data;
            console.log(data);
            var html_text = "";
            var slno = 0;
             for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>'+slno+'</td>';
                
                // if(images!=''){
                // html_text += '<td><img src="' + images + '" alt="" width="100" height="100"></td>';
                // }else{
                //     html_text += '<td>-</td>';
                // }
                html_text += '<td>' + table_main_data[key].scheme_name + '</td>';
                    html_text += '<td>' + table_main_data[key].limit_box + '</td>';
                    html_text += '<td>' + table_main_data[key].free_product_box + '</td>';
                    html_text += '<td>' + table_main_data[key].product_name + '</td>';
                    html_text += '<td>' + table_main_data[key].buy_box + '</td>';
                    html_text += '<td>' + table_main_data[key].free_box + '</td>';
                    html_text += '<td>' + table_main_data[key].free_product + '</td>';
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#total_count").html(slno);
            $("#table_body").html(html_text);
           
            table1 = $("#table_data").DataTable({
                dom: 'Bfrtip',
                buttons: [{
                                extend: 'pdfHtml5',
                                className: 'btn-primary buttonprint',
                                exportOptions: {
                                   columns: [0,2,3,4,5,6,7,8]
                                },
                                orientation: 'landscape',
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
        }

        
       

    </script>

</body>

</html>
<?php
}
mysqli_close($link);
?>