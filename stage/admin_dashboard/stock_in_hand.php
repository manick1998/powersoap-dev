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
        <title>Inventory Management</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/product_list.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">

        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <style>
            .stock_btn {
                color: #00b9f5;
                font-size: 18px;
                line-height: 20px;
                text-decoration: underline;
                border: none;
                background: transparent;
            }

            .cancelbtn {
                font-size: 18px;
                line-height: 20px;
                color: #04bcf4;
                border: none;
                background: transparent;
            }

            .savebtn {
                font-size: 18px;
                line-height: 20px;
                color: #fff;
                background-color: #04bcf4 !important;
                border: 1px solid #04bcf4;
                border-radius: 4px;
                padding: 5px 15px;
            }

            .inventory-body-left img {
                min-width: 96px;
            }

            a {
                cursor: pointer;
            }

            .header-section {
                display: flex !important;
            }

            .btn-group,
            .btn-group-vertical {
                padding-left: 30px;
            }

            .dataTables_filter label {
                top: 30px !important;
            }
        </style>
    </head>

    <body>
        <div class="se-pre-con" style="display: block;"></div>
        <header id="main-dash-header" class="dash-header"></header>
        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar2"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggle3">
                <div class="header_container">
                    <div class="header-section">
                        <h1 class="header_main">Stock in Hand</h1>
                        <p class="table_count">Total Stock - <span id="total_stock_count"></span></p>
                    </div>
                </div>
                <!-- Nav tabs -->
                <ul class="nav nav-pills product_list mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link a_button" type="button" data-toggle="modal" data-target="#myModal">Upload
                            CSV</button>
                    </li>
                    <li class="nav-item">
                        <a class="a_button" href="assets/csv/Sample_Stock_CSV.csv" download><button class="nav-link" type="button">Sample CSV</button></a>
                    </li>
                </ul>
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Token</th>
                                <th>Item Code</th>
                                <th>Item Name</th>
                                <th>Division</th>
                                <th>Stock in Hand(In Box)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id"></tbody>
                    </table>
                </div>
            </section>
            <section class="bg-white brad-4 full-height twoback" id="toggle4" style="display: none;">
                <img src="assets/back.png" onclick="back_view()" alt="" class="backword">
                <div class="side-position">
                    <div class="header_container">
                        <div class="header-section">
                            <div class="inventory-top">
                                <h1 class="header_main" id="single_product_name"></h1>
                                <span id="single_product_code"></span>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <!--
            <div class="header_container" >
                <div class="header-section">
                    <div class="inventory-top2">
                        <div class="box">
                            <h6>Stock in Hand</h6>
                            <p id="single_stock_in_hand"></p>
                        </div>
                        <div class="box">
                            <h6>Monthly Avg Sale</h6>
                            <p id="single_avg_sale"></p>
                        </div>
                    </div>
                </div>
            </div>
                <hr/>
-->
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
                                        <!--                                <p>Company Invoice Number : <span id="single_invoice_number"></span></p>-->
                                        <p>Location : <span id="single_location"></span></p>
                                        <!--                                <p>Transporter : <span id="single_transporter"></span></p>-->
                                        <p>Origin : <span id="single_orgin"></span></p>
                                        <p>Piece Count For Box : <span id="single_piece_count"></span></p>
                                    </div>
                                    <div class="part2">
                                        <p>Batch Number : <span id="single_batch_number"></span></p>
                                        <p>Net Weight : <span id="single_net_weight"></span></p>
                                        <p>Division : <span id="single_type"></span></p>
                                        <p>MRP : <span id="single_mrp"></span></p>
                                        <!--                                <p>GST : <span id="single_gst"></span></p>-->
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
        </main>
        <!-- The Modal -->
        <div class="modal" id="update_stock">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Update Stock</h4>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="modal-inner-body">
                            <fieldset>
                                <input type="radio" id="add" name="radio" value="add" checked>
                                <label for="add">Add Stocks</label>
                                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" id="remove" name="radio" value="remove">
                                <label for="remove">Remove Stocks</label>
                            </fieldset>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="info-set">
                            <input id="token" hidden>
                            <div class="form__detail">
                                <input type="text" id="stocks_in_hand" id="user_email" class="form__input numberonly">
                                <label for="" class="form__label">Enter Stocks</label>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="cancelbtn" data-dismiss="modal">Cancel</button>
                            <!-- onclick="update_stocks()" -->
                            <input type="hidden" id="beforevalue" value="">
                            <button type="button" class="savebtn" id="updatebtn">Save</button>
                        </div>

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

        <!-- jquery CDN -->
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>

        <script>
            var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        </script>
        <script>
            function back_view() {
                $('#toggle4').hide();
                $('#toggle3').show();
            }
            var admin_token = "<?php echo $_COOKIE["token_admin_dashboard_development"]; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            var table;

            $(document).ready(function() {
                var datas = {
                    dashboard_code: verfication_code,
                    type: "all"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/stockInHand.php",
                    data: json_data,
                }).done(function(data) {
                    var count = data.data;
                    $("#total_stock_count").html(count);
                });
            });

            $(document).ready(function() {
               
                $(".se-pre-con").hide();
                table = $('#table_data').DataTable({
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0, 1, 4, 5]
                    }, ],
                    'ajax': {
                        'url': api_path + "/admin/serverStockInHand.php?v_id=" + verfication_code
                    },
                    pageLength: <?php echo $page_length; ?>,
                    lengthMenu: [10, 25, 100, 500, 1000, 5000, 10000, 100000],
                    "order": [
                        [0, "DESC"]
                    ],
                  
                    'columns': [{
                            data: 'token'
                        },
                        {
                            data: 'item_code'
                        },
                        {
                            data: 'item_name'
                        },
                        {
                            data: 'item_type'
                        },
                        {
                            data: 'stock_in_hand'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    dom: 'Bfrltip',
                    "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                        if (aData.delete_status == "2") {
                            $('td', nRow).css('background-color', '#ff9d87');
                        }
                    },
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: "Search"
                    },
                    destroy: true,
                    searching: true,
                    buttons: [{
                        extend: 'pdfHtml5',
                        className: 'btn-primary buttonprint',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }, {
                        extend: 'csv',
                        className: 'btn-info buttonprint',
                        exportOptions: {
                            columns: [1, 2, 3, 4]
                        },
                        orientation: 'landscape',
                        pageSize: 'LEGAL'
                    }],
                });
                table.column(0).visible(false);
                //$('.dataTables_length').css("display", "none");
                $("#table_data_wrapper > .row > .col-sm-12 > .custom-table").parent().css("overflow-x", "auto");
                
            });

            $(document).ready(function() {
                var stockDataArray = [];

                // 1. Loop through every table body row (excluding the header row)
                $('#table_data tbody').each(function() {
                    // 2. Find the 4th column cell (index 3) inside the current row
                    var stockText = $(this).find('td').eq(3).text().trim();

                    // Check if the cell has text to avoid empty spacer rows
                    if (stockText) {
                        // 3. Extract only the numeric digits (removes the word "Box")
                        var stockNumber = parseInt(stockText.replace(/[^0-9]/g, ''), 10);
                        
                        // 4. Push the clean number into our array
                        stockDataArray.push(stockNumber);
                    }
                });

                // View your complete array of stock numbers in the console
                console.log("All Stock Values:", stockDataArray); 
                // Example Output: [49204, 48472, 17954]
            });

            $('#table_data tbody').on('click', '.item_code_view', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var stock_in_hand = parseInt(table_data.stock_in_hand);
                var monthly_avg = parseFloat(table_data.monthly_avg);
                $(".se-pre-con").show();
                //            $("#single_stock_in_hand").html(numberWithCommas(stock_in_hand));
                //            $("#single_avg_sale").html(numberWithCommas(monthly_avg));
                var datas = {
                    dashboard_code: verfication_code,
                    type: "single_product",
                    product_token: token
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/admin/stockInHand.php",
                    data: json_data,
                }).done(function(data) {
                    var product_data = data.data;
                    console.log(product_data);
                    $("#single_image").attr("src", product_data[0].image);
                    $("#single_product_name").html(product_data[0].item_name);
                    $("#single_product_code").html("Item Code:" + product_data[0].item_code);
                    $("#single_manufacture").html(product_data[0].manufacturer);
                    $("#single_item_code2").html(product_data[0].item_code);
                    $("#single_invoice_number").html(product_data[0].invoice_number);
                    $("#single_location").html(product_data[0].location);
                    $("#single_transporter").html(product_data[0].transporter);
                    $("#single_orgin").html(product_data[0].origin);
                    $("#single_batch_number").html(product_data[0].batch_number);
                    $("#single_net_weight").html(product_data[0].net_weight);
                    $("#single_type").html(product_data[0].item_type);
                    $("#single_mrp").html(product_data[0].item_mrp);
                    $("#single_gst").html(product_data[0].item_gst);
                    $("#single_price").html(product_data[0].item_price);
                    $("#single_description").html(product_data[0].description);
                    $("#single_piece_count").html(product_data[0].piece_count);
                    $('#toggle3').hide();
                    $('#toggle4').show();
                    $(".se-pre-con").hide();
                });
            })
            $('#table_data tbody').on('click', '.item_code_edit', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var token = table_data.token;
                var stock_in_hand = parseInt(table_data.stock_in_hand);
                var value = $(this).closest('tr').find('td:eq(3)').text().split(' ');
                $('#beforevalue').val(value[0]);
                $("#token").val(token);
                // $("#stocks_in_hand").val(stock_in_hand);
                $("#update_stock").modal('show');
            });

            // function update_stocks() {
            $(document).on('click', '#updatebtn', function() {
                var stocktype = $('input[type=radio][name=radio]:checked').val();
                var beforestack = $('#beforevalue').val();
                var token = $("#token").val();
                var stock_in_hand = $("#stocks_in_hand").val();

                var datas = {

                    dashboard_code: verfication_code,
                    product_token: token,
                    stocktype: stocktype,
                    beforestack: beforestack,
                    stock_in_hand: stock_in_hand,
                    admin_token: admin_token,
                };
                var json_data = JSON.stringify(datas);
                // console.log('json_data', json_data);
                if (stock_in_hand != "" && stock_in_hand != 0) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: api_path + "/admin/updateStock.php",
                        data: json_data,
                    }).done(function(data) {
                        if (data.code == 201) {
                            swal("Stock Updated successfully!", {
                                icon: "success",
                            }).then((value) => {
                                location.reload();
                            });
                        } else {
                            swal("You Enter Value Greater Than Opening!", {
                                icon: "error",
                            }).then((value) => {
                                location.reload();
                            });
                        }
                    });
                } else {
                    swal("Enter The Box Count");
                }
            });


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
                        url: api_path + "/admin/uploadStockCsv.php",
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
        </script>
    </body>

    </html>
<?php
}
mysqli_close($link);
?>