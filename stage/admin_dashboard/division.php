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
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
        <style>
            .a_button {
                color: #00b9f5;
            }

            .edit_input {
                cursor: pointer;
            }

            .custom-table.dataTable.no-footer {
                display: table;
                overflow-x: auto;
            }
            .swal2-show{
                display: none;
            }
        </style>
    </head>

    <body>
        <div class="se-pre-con"></div>
        <header id="main-dash-header" class="dash-header">
        </header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar2"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main">Division List</h1>
                        </div>
                        <p class="table_count">Total Division - <span id="total_division_count"></span></p>
                    </div>
                </div>
                <div class="dataTables_filter">
                    <form class="formdield">
                        <div class="form-group">
                            <button class="btn_employee " class="btn btn-danger" data-toggle="modal" data-target="#form" type="button"><span><img src="assets/retailer.png" class="icon_add"></span> Add Division</button>
                        </div>
                    </form>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>token</th>
                                <th>Sl No</th>
                                <th>Division Name</th>
                                <th>Product List</th>
                                <th>Action</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id">
                        </tbody>
                    </table>
                </div>
            </section>
            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Add Division</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <div class="form-control division_name_box">
                                    <p class="division_name">Division Name</p>
                                    <input class="input-field" id="division_name" placeholder="Enter Division Name">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="add_division_button" onclick="add_division()">Add Division</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="formUpdate" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Edit Division</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="forms">
                                <input id="edit_division_token" type="hidden">
                                <div class="form-control edit_division_name_box">
                                    <p class="edit_division_name">Division Name</p>
                                    <input class="input-field" id="edit_division_name" placeholder="Enter Division Name">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                            <button type="button" class="btn model-btn" id="update_division_button" onclick="update_division()">Update Division</button>
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
            <!-- Product View Modal -->
            <div class="modal fade" id="viewProductsModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="productModalLabel">Product List</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                            <div id="product_list_container"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
            var gl_admin_token = "<?php echo $token; ?>";
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
         <script src="https://jsdelivr.net"></script>
         <!-- 1. Load jQuery Library first -->
        <script src="https://jquery.com"></script>
        <!-- 2. Load SweetAlert2 Library second -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            $(document).ready(function() {
                var datas = {
                    dashboard_code: verfication_code,
                    type: "count_check"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(datas) {
                    var count = datas.Count;
                    $("#total_division_count").html(numberWithCommas(count));
                });
            });
            $(document).ready(function() {
                $(".se-pre-con").fadeIn();
                table = $('#table_data').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [1, 3, 4, 5]
                    }, ],
                    'ajax': {
                        'url': api_path + "/admin/divisionDetails.php?v_id=" + verfication_code
                    },
                    "order": [
                        [0, "DESC"]
                    ],
                    'columns': [{
                            data: 'division_token'
                        },
                        {
                            data: 'sl_no'
                        },
                        {
                            data: 'division_name'
                        },
                        {
                            data: 'product_list',
                            render: function(data, type, row) {
                                if (data) {
                                    return '<a class="view_products a_button" style="cursor:pointer; text-decoration:underline;">View Products</a>';
                                } else {
                                    return '-';
                                }
                            }
                        },
                        {
                            data: 'action'
                        },
                        {
                            data: 'delete'
                        }
                    ],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    }
                });
                table.column(0).visible(false);
                $('.dataTables_length').css("display", "none");
                $(".se-pre-con").fadeOut();
            });
            $("#division_name,#edit_division_name").keydown(function(event) {
                if (event.keyCode == 32 && this.value.length == 0) {
                    event.preventDefault();
                }
            });

            function add_division() {
                var division_name = $("#division_name").val();
                var val1 = value_check('division_name', division_name, 'text_box');
                if (val1 == true) {
                    $("#form").modal('hide');
                    setTimeout(function() {
                        $(".se-pre-con").show();
                    }, 5);
                    $('#add_division_button').prop('disabled', true);
                    var datas = {
                        'division_name': division_name,
                        'dashboard_code': verfication_code,
                        'admin_token': gl_admin_token
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/addDivision.php",
                        data: json_data,
                    }).done(function(data) {
                        $(".se-pre-con").hide();
                        if (data.code == "201") {
                            swal("Division added successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            $("#form").modal('show');
                            $('#add_division_button').prop('disabled', false);
                            swal(data.message);
                        }
                    });
                } else {
                    swal("Please enter all details!");
                }
            }
            $('#table_data tbody').on('click', '.item_code_edit', function() {
                clear_update_modal();
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.division_token;
                $("#edit_division_token").val(token);
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_division",
                    division_token: token,
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(data) {
                    var division_data = data.data;
                    $("#edit_division_name").val(division_data[0].division_name);
                    $("#formUpdate").modal('show');
                });
            });
            $('#table_data tbody').on('click', '.view_products', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var product_list = table_data.product_list;
                var division_name = table_data.division_name;

                $("#productModalLabel").text("Products in " + division_name);
                var products = product_list.split(', ');
                var html = '<ul class="list-group">';
                products.forEach(function(product) {
                    html += '<li class="list-group-item">' + product + '</li>';
                });
                html += '</ul>';
                $("#product_list_container").html(html);
                $("#viewProductsModal").modal('show');
            });
            $('#table_data tbody').on('click', '.division_delete', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.division_token;
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_division_delete",
                    division_token: token,
                    admin_token: gl_admin_token
                };
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/singleDivisionDetails.php",
                    data: json_data,
                }).done(function(data) {
                    console.log(data);
                    if (data.code == 201) {
                        swal("Division Deleted successfully");
                        location.reload();
                    } else {
                        swal("Division Already Mapped");
                    }

                });
            });

            function clear_update_modal() {
                value_check('edit_division_name', 1, 'text_box');
            }

            function update_division() {
                var division_token = $("#edit_division_token").val();
                var division_name = $("#edit_division_name").val();
                var val1 = value_check('edit_division_name', division_name, 'text_box');
                if (val1 == true) {
                    $("#formUpdate").modal('hide');
                    $('#update_division_button').prop('disabled', false);
                    setTimeout(function() {
                        $(".se-pre-con").show();
                    }, 5);
                    var datas = {
                        'division_token': division_token,
                        'division_name': division_name,
                        'dashboard_code': verfication_code,
                        'admin_token': gl_admin_token
                    }
                    var json_data = JSON.stringify(datas);
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateDivision.php",
                        data: json_data,
                    }).done(function(data) {
                        $(".se-pre-con").hide();
                        if (data.code == "201") {
                            swal("Division updated successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            $('#update_division_button').prop('disabled', false);
                            swal(data.message, {
                                icon: "error",
                            }).then((value) => {
                                $("#formUpdate").modal('show');
                            });
                        }
                    });
                } else {
                    swal("Please enter all details!");
                }
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
                ////            $.ajax({
                ////                dataType: "json",
                ////                url: api_path+"/admin/uploadRetailerCsv.php",
                ////                type: 'POST',
                ////                async: false,
                ////                processData: false, // important
                ////                contentType: false, // important
                ////                data: myFormData,
                ////                success: function(data){
                ////                    $(".se-pre-con").hide();
                ////                    if(data.code==503){
                ////                        $('#csv_upload_button').prop('disabled', false);
                ////                        swal(data.message);
                ////                    }else if(data.code==201){
                ////                        swal("Csv data uploaded successfully!", {icon: "success",}).then((value) => {
                ////                            location.reload();
                ////                        });
                ////                    }
                ////                }
                ////            });
                //        }else{
                //            swal("Please select a csv file!");
                //        }
            }
        $(document).ready(function(){
           const style = localStorage.getItem('style_data');
            console.log(style);
           
        let value = {
            type : 'stock_in_hand_alert'
        }
        let data = JSON.stringify(value);
        if(style == 'show'){
         $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/stock_in_hand_alert.php",
                data: data,// Converts JS object to JSON string for php://input
                success: function(response) {
                // 1. Check if the server returned a success status code
                    if (response.status_code === 200 && response.data1.length > 0) {
                        
                        let flaggedProducts = [];

                        // 2. Scan items to check if any item triggers the condition
                        response.data1.forEach(function(item, index) {
                            if (item.stock_in_hand < 1000) {
                                // Save as an object so you can access .name and .stock inside the table loop
                                flaggedProducts.push({
                                    name: item.stock_name || "Unknown Product",
                                    stock: item.stock_in_hand
                                });
                            }
                        });

                        // 3. Show exactly ONE alert if any products were flagged
                        if (flaggedProducts.length > 0) {
                            
                            // Build the table layout inside the check block
                            let tableHtml = `
                                <div style="max-height: 250px; overflow-y: auto; margin-top: 15px;">
                                    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 14px;">
                                        <thead>
                                            <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                                                <th style="padding: 10px; font-weight: 600;">Product Name</th>
                                                <th style="padding: 10px; font-weight: 600; text-align: right;">Stock in Hand</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            `;

                            // Loop and safely append each object property
                            flaggedProducts.forEach(function(product) {
                                tableHtml += `
                                    <tr style="border-bottom: 1px solid #dee2e6;">
                                        <td style="padding: 10px; color: #495057;">${product.name}</td>
                                        <td style="padding: 10px; color: #dc3545; font-weight: bold; text-align: right;">${product.stock}</td>
                                    </tr>
                                `;
                            });

                            tableHtml += `
                                        </tbody>
                                    </table>
                                </div>
                            `;

                            // Changed from swal() to Swal.fire() to support HTML
                            Swal.fire({
                                title: "Stock Alert!",
                                html: tableHtml, 
                                icon: "warning",
                                confirmButtonText: "Ok",
                                confirmButtonColor: "#3085d6",
                                width: "500px"
                            });

                            localStorage.clear();
                        }
                        
                    } else {
                        // Handles 400/404 statuses returned from your PHP structure
                        Swal.fire({
                            title: "Error!",
                            text: response.message || "An unexpected error occurred.",
                            icon: "error",
                            confirmButtonText: "Ok",
                            confirmButtonColor: "#dc3545"
                        });
                    }
                }, // <--- ✅ ADDED THIS MISSING COMMA TO SEPARATE THE AJAX PROPERTIES

                error: function(xhr, status, error) {
                    // Handles hard network failures or crash bugs
                    Swal.fire({ // ✅ UPDATED TO SWAL.FIRE FOR CONSISTENCY
                        title: "Connection Error!",
                        text: "Could not reach the server.",
                        icon: "error",
                        confirmButtonText: "Ok",
                        confirmButtonColor: "#dc3545"
                    });
                }
            });
                    
                }
        });

        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>