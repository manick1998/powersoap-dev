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
        <title>Inventory Management</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
        <style>
            a {
                cursor: pointer;
            }

            .stoInhad_BkgClr {
                background-color: #ffb3b3;
            }

            .header-section p {
                padding: 5px 10px;
            }
            .header_container {
                justify-content: space-between;
            }
            .header-section {
                display: flex;
                display: -webkit-box;
                display: -moz-box;
                display: -ms-flexbox;
                display: -webkit-flex;
                jusstify-content: space-between;
            }
            .input_value {
                background-color: #fff;
            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar2"></div>
        <div class="se-pre-con" style="display: none;"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle3">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main" data-i18n="stock_in_hand">Stock in Hand</h1>
                        </div>
                        <p class="table_count"><span data-i18n="total_stocks">Total Stocks</span> - <span id="project_count"></span></p>
                    </div>
                    <p class='stack_total_amount'><span data-i18n="total_stock_amount">Total Stock Amount</span> - ₹ <span id="stack_total_amount"></span></p>
                    <input type="hidden" name="name1" id='hide_input' value="">
                </div>
                <div class="table-box">
                    <!-- <button class="primary-btn" id='btn' style="margin-left: 20px; margin-top:16px;">button</button> -->
                    <table class="custom-table" id="dataTables_filter">
                        <thead>
                            <tr>
                                <th data-i18n="sl_no">Sl No</th>
                                <th data-i18n="item_code">Item Code</th>
                                <th data-i18n="item_name">Item Name</th>
                                <th data-i18n="division">Division</th>
                                <th data-i18n="retailer_price">Retailer Price</th>
                                <th data-i18n="stock_in_hand_pieces">Stock in Hand  (In Pieces)</th>
                                <th data-i18n="mfs">MFS</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id">

                        </tbody>
                    </table>
                </div>
            </section>
            <section class="bg-white brad-4 full-height" id="toggle4" style="display: none;">
                <div class="twoback">
                    <img src="assets/back.png" onclick="hidemodal()" alt="" class="backword">
                    <div class="side-position">

                    </div>
                </div>
            </section>
        </main>
        <!-- js file -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>


        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";

            function dataTableIn() {
                $("#dataTables_filter").DataTable({
                    scrollX: true,
                    dom: 'Bfrtip',
                    buttons: [],
                    
                    "columnDefs": [{
                        "targets": [0],
                        "visible": false,
                        "searchable": false
                    }],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: getGlobalTranslation("search"),
                        paginate: {
                            next: '<img src="assets/svg/Right_arrow_icon.svg">',
                            previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                        }
                    }
                });
            }
            /* Radion button box */
            $('.ratio-btn-selecter').on('click', function() {
                var quickcheck = $(this).attr('data-value');
                if (quickcheck == "image") {
                    $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
                    $('.popup-image-box').removeClass('hidden');
                    $('.popup-video-box').addClass('hidden');
                } else {
                    $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
                    $('.popup-image-box ').addClass('hidden');
                    $('.popup-video-box').removeClass('hidden');
                }
            });

            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
            $(document).ready(function() {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token
                };
                var json_data = JSON.stringify(datas);
                
                
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stock_in_hand.php",
                    data: json_data,
                    success: success,
                });
            });
            var table_main_data;
            var activeField;

            function success(data) {
                console.log(data);
                table_main_data = data.data;
                activeField = data.data1;
                var html_text = "";
                var slno = 0;
                for (var key in table_main_data) {
                    // console.log('prod',table_main_data[key].product_token);
                    slno++;
                    html_text += '<tr>';
                    html_text += '<td>' + slno + '</td>';
                    html_text += '<td><a class="view_link" onclick="view_stock_in_hand(' + table_main_data[key].product_token + ')">' + table_main_data[key].item_code + '</a></td>';
                    html_text += '<td>' + table_main_data[key].product_name + '</td>';
                    html_text += '<td>' + table_main_data[key].product_category + '</td>';
                    html_text += '<td>' + table_main_data[key].retailer_price + '</td>';
                    if (table_main_data[key].stock_in_hand <= 0) {
                        html_text += '<td class="stoInhad_BkgClr">' + table_main_data[key].stock_in_hand + ' ' + getGlobalTranslation("pieces") + '</td>';
                    } else {
                        html_text += '<td><div style="display:flex;align-items:center;justify-content:space-between;">' + table_main_data[key].stock_in_hand + ' ' + getGlobalTranslation("pieces") + '</div></td>';
                    }
                   
                    if (activeField[0].active_status == 1) {
                        html_text += '<td><div class="form_input"><input class="input_value" name="input_mfs' + key + '" onchange="input_mfs_changed(' + key + ')" type="text" value="' + table_main_data[key].mfs + '" readonly onkeypress="return isNumber(event)"><a><img src="assets/edit.png" class="edit_input" onclick="edit_input_mfs(' + key + ')"  alt=""></a></div></td>';
                    } else {
                        html_text += '<td><div class="form_input"><input class="input_value" name="input_mfs' + key + '" onchange="input_mfs_changed(' + key + ')" type="text" value="' + table_main_data[key].mfs + '" readonly onkeypress="return isNumber(event)"></div></td>';
                    }
               

                    html_text += '</tr>';
                }
                $("#project_count").text(slno);
                console.log(html_text.length);
                $("#table_body_id").html(html_text);
                dataTableIn();
                $(".se-pre-con").hide();
            }
                
                    
                  
            $(document).on('click','#btn1',function(){
                console.log( 'tds',$(this).closest('tr').find('td:eq(5)').val());
                $(this).each(function(){
                    var product_token = $(this).data('prodcut');
                    var stock_count = $('#hide_input').val();
                    var datas = {
                                stock_count: stock_count,
                                distributor_token : distributor_token,
                                product_token: product_token
                            };
                                var json_data = JSON.stringify(datas);
                                console.log(json_data);
                                $.ajax({
                                    type: "POST",
                                    dataType: "json",
                                    url: api_path + "/distributor/update_pre_stock.php",
                                    data: json_data,
                                }).done(function(data){
                                    
                                    for (var key in data) {
                                        console.log(data[key].status_code);
                                        if (data[key].status_code == 200) {
                                            $(".se-pre-con").hide();
                                        swal(data[key].message, "your stock added successfully").then((value) => {
                                            location.reload();
                                        });
                                    }
                                    }
                                    
                                });
                    
                });
                    
            });
                

                 $(document).ready(function(){
                    var datas=0;
                    $(document).on('change','#temp',function(){
                                
                                $(this).each(function(datas){
                                     datas = $(this).val();
                                     $('#hide_input').val(datas);
                                    $(this).data('prodcut');   
                                });
                                console.log('ja',$('#hide_input').val());
                               
                    });
                    
                });


            //Remove readonly from MFS input field
            function edit_input_mfs(key) {
                var value = $('input[name=input_mfs' + key + ']').val();
                $('input[name=input_mfs' + key + ']').removeAttr('readonly').focus().val('').val(value);
            }

            function edit_input_aog(key) {
                var value1 = $('input[name=input_aog' + key + ']').val();
                $('input[name=input_aog' + key + ']').removeAttr('readonly').focus().val('').val(value1);
            }

            //Changing the input value of mfs 
            function input_mfs_changed(key) {
                $(".se-pre-con").show();
                $('input[name=input_mfs' + key + ']').attr("readonly", true);
                var mfs = $('input[name=input_mfs' + key + ']').val();
                var product_token = table_main_data[key].product_token;
                var datas = {
                    mfs: mfs,
                    product_token: product_token,
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "UpdateMfs"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/update_mfs.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 200) {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "success").then((value) => {
                            location.reload();
                        });
                    } else {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "error").then((value) => {
                            location.reload();
                        });
                    }

                });
            }

            function input_aog_add(key) {
                $(".se-pre-con").show();
                $('input[name=input_aog' + key + ']').attr("readonly", true);
                var aog = $('input[name=input_aog' + key + ']').val();
                var product_token = table_main_data[key].product_token;
                var datas = {
                    aog: aog,
                    product_token: product_token,
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "UpdateAog"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/update_mfs.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 200) {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "success").then((value) => {
                            location.reload();
                        });
                    } else {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "error").then((value) => {
                            location.reload();
                        });
                    }

                });

            }
            function view_stock_in_hand(product_token) {
                $('#toggle3').hide();
                $(".se-pre-con").show();
                var datas = {
                    product_token: product_token,
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stock_in_hand_detail_page.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 200) {
                        var stock = data.data
                        var html_text = "";
                        html_text += '<div class="header_container">';
                        html_text += '<div class="header-section">';
                        html_text += '<div class="inventory-top">';
                        html_text += '<h1 class="header_main">' + stock.product_name + '</h1>';
                        html_text += '<span>' + getGlobalTranslation("item_code") + ': ' + stock.item_code + '</span>';
                        html_text += '<span id="indi_product_token" style="display:none;">' + stock.product_token + '</span>';
                        html_text += '</div>';
                        html_text += '</div>';
                        html_text += '</div>';
                        html_text += '<div class="inventory-body-section ">';
                        html_text += '<div class="inventory-body-left">';
                        html_text += '<img src="' + stock.image + '" alt="">';
                        html_text += '</div>';
                        html_text += '<div class="inventory-body-right">';
                        html_text += '<div class="">';
                        html_text += '<div class="part-card">';
                        html_text += '<div class="part1">';
                        html_text += '<h4>' + getGlobalTranslation("product_details") + '</h4>';
                        html_text += '<p>' + getGlobalTranslation("manufacture") + ' : <span>' + stock.manufacturer + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("item_code") + ' : <span>' + stock.item_code + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("location") + ' : <span>' + stock.location + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("origin") + ' : <span>India</span></p>';
                        html_text += '<p>' + getGlobalTranslation("piece_count_for_box") + ' : <span>' + stock.piece_count + '</span></p>';
                        html_text += '</div>';
                        html_text += '<div class="part2">';
                        html_text += '<p>' + getGlobalTranslation("barcode") + ' : <span>' + stock.batch_number + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("net_weight") + ' : <span>' + stock.net_weight + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("division") + ' : <span>' + stock.product_category + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("mrp") + ' : <span>' + stock.mrp + '</span></p>';
                        html_text += '<p>' + getGlobalTranslation("price_inclusive_tax") + ' : <span>' + stock.total_cost + '</span></p>';
                        html_text += '</div>';
                        html_text += '<div class="part3">';
                        html_text += '<p>' + stock.description + '</p>';
                        html_text += '</div>';
                        html_text += '</div>';
                        html_text += '</div>';
                        html_text += '</div>';
                        html_text += '</div>';
                        $(".side-position").html(html_text);
                        $(".se-pre-con").hide();
                    } else {
                        $(".se-pre-con").hide();
                    }
                });
                $('#toggle4').show();
            }

            //click mfs edit icon
            function clickEdit() {
                var new_val = $('input[name=input_mfs]').val();
                $('input[name=input_mfs]').prop('readonly', false).focus().val('').val(new_val);
            }

            //input field for mfs
            function changedMFSvalue() {
                $(".se-pre-con").show();
                $('input[name=input_mfs]').attr("readonly", true);
                var mfs = $('input[name=input_mfs]').val();
                var product_token = $("#indi_product_token").text();
                var datas = {
                    mfs: mfs,
                    product_token: product_token,
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    type: "UpdateMfs"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/update_mfs.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == 200) {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "success").then((value) => {
                            location.reload();
                        });
                    } else {
                        $(".se-pre-con").hide();
                        swal(data.title, data.message, "error").then((value) => {
                            location.reload();
                        });
                    }

                });

            }
            //====== Total Stack Value
            $(document).ready(function(){
                var datas = {
                    distributor_token :distributor_token
                };
                var json_datas = JSON.stringify(datas);
                 $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/stack_total_amount.php",
                    data: json_datas,
                }).done(function(data) {
                           var total_amount =  data[0].total;
                        //    var grand_total = total_amount.toFixed(2);
                           console.log(Math.round(total_amount)); 
                     $('#stack_total_amount').append(Math.round(total_amount));
                });
              var total_count =  $('#dataTables_filter tbody td').length;
               console.log(total_count);
            });

            /* ============== Only Allow Numeric value in Phone Field code ============== */
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        </script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    </body>

    </html>
<?php
}
?>