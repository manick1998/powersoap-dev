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
        <title>Out Standing Management</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/outstand.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <style>
            .field_data {
                padding-right: 10px;
            }

            .down_btn {
                color: #fff;
                background-color: #04bcf4 !important;
                border: 1px solid #04bcf4;
                font-size: 18px;
                line-height: 21px;
                font-weight: 600;
                letter-spacing: 1px;
                padding: 10px 15px;
                width: 200px;
                border-radius: 4px;

            }
        </style>
    </head>

    <body>
        <header id="main-dash-header" class="dash-header">
        </header>

        <!-- sidebar -->
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar4"></div>
        <div class="se-pre-con"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height" id="toggles">
                <div class="header_container">
                    <div class="header-section">
                        <div>
                            <h1 class="header_main" data-i18n="outstanding">OutStanding </h1>
                        </div>
                        <p class="table_count"><span data-i18n="total_outstanding">Total OutStanding</span> - <span id="total_order_count"></span></p>
                    </div>
                </div>
                <div class="table-box">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th data-i18n="sl_no">Slno</th>
                                <th data-i18n="token">Shop Token</th>
                                <th data-i18n="retailer_code">Retailer Code</th>
                                <th data-i18n="retailer_name">Retailer Name</th>
                                <th data-i18n="shop_type">Shop Type</th>
                                <th data-i18n="mobile_number">Mobile Number</th>
                                <th data-i18n="contact_person">Contact Person</th>
                                <th data-i18n="outstanding">Outstanding</th>
                            </tr>
                        </thead>
                        <tbody id="table_body_id">
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="bg-white brad-4 full-height" id="toggles1" style="display: none;">
                <div class="header_container">
                    <div class="header-details">
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div id="payments" class="table-box w3-border city">
                            <div class="data-table">
                                <table class="custom-table" id="item_list_table">
                                    <thead>
                                        <tr>
                                            <th data-i18n="sl_no">SI.No</th>
                                            <th data-i18n="date_time">Date & Time</th>
                                            <th data-i18n="mode">Mode</th>
                                            <th data-i18n="paid_amount">Paid Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        </script>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->

        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->

        <!-- datatable -->
        <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>

        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
        </script>
        <script>
            var table;
            var distributor_token = "<?php echo $_SESSION["distributor_token"]; ?>";
            var verfication_code = "<?php echo $verification_code; ?>";
            var api_path = "<?php echo $api_path; ?>";
            //var retailerToken = localStorage.getItem("retailertoken");   
            var retailerToken = "<?php echo $_SESSION["retailer_token"]; ?>";

            function back_view_order() {
                $('#toggles1').hide();
                $('#toggles').show();
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

            $(document).ready(function() {
                var datas = {
                    dashboard_code: verfication_code,
                    is_redirect_retailer_sub_page: "true",
                    type: "shop_redirect_status"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/order_details.php",
                    data: json_data,
                }).done(function(data) {});
                $(".new_desing").css("display", "none");
                var datas = {
                    dashboard_code: verfication_code,
                    distributor_token: distributor_token,
                    retailer_token: retailerToken,
                    type: "count"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/shop_outstanding.php",
                    data: json_data,
                }).done(function(data) {
                    var count = data;
                    $("#total_order_count").html(count);
                });

                table = $('#table_data').DataTable({
                    scrollX: true,
                    'processing': true,
                    'serverSide': true,
                    'serverMethod': 'post',
                    "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0]
                    }],
                    order: [
                        [0, 'desc']
                    ],
                    'ajax': {
                        'url': api_path + "/distributor/server_shop_outstanding.php?v_id=" + verfication_code + "&&dist_id=" + distributor_token + "&&retail_id=" + retailerToken,
                        'dataSrc': function(data) {
                            $("#total_order_count").html(data.iTotalDisplayRecords);
                            return data.aaData;
                        }
                    },
                    'columns': [{
                            data: 'slno'
                        },
                        {
                            data: 'shop_token'
                        },
                        {
                            data: 'retail_code'
                        },
                        {
                            data: 'retailer_name'
                        },
                        {
                            data: 'shop_type'
                        },
                        {
                            data: 'mobile_number'
                        },
                        {
                            data: 'contact_person'
                        },
                        {
                            data: 'outstanding'
                        }
                    ],
                    language: {
                        search: '<img src="assets/svg/Search_icon.svg">',
                        searchPlaceholder: getGlobalTranslation("search")
                    }
                });
                table.columns([0, 1]).visible(false);
                $('.dataTables_length').css("display", "none");
                $(".se-pre-con").hide();
            });

            var order_table_check = false;
            var order_table;
            $('#table_data tbody').on('click', '.view_link', function() {
                var td_div = $(this).parent().parent();
                var table_data = table.row(td_div).data();
                var shop_token = table_data.shop_token;
                var outstanding = table_data.outstanding;
                particular_order_detail(shop_token, outstanding);
            });
            var item_data;
            var shop_data;

            function particular_order_detail(token, outstanding) {
                $(".se-pre-con").show();
                var datas = {
                    dashboard_code: verfication_code,
                    shop_token: token,
                    distributor_token: distributor_token,
                    type: "particular_shop_detail"
                };
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/shop_outstanding.php",
                    data: json_data
                }).done(function(data) {
                    shop_data = data.data;
                    var order_text1 = "";
                    order_text1 += '<div class="title_box">';
                    order_text1 += '<div class="header_box">';
                    order_text1 += '<h1 class="header_main"><span class="twoinspace"><img src="assets/back.png" onclick="back_view_order()" alt=""></span>' + shop_data.shop_name + '</h1>';
                    order_text1 += '</div>';
                    order_text1 += '</div>';
                    order_text1 += '<p class="table_count">' + shop_data.shop_token + '</p>';
                    order_text1 += '<div class="details-top-section">';
                    order_text1 += '<div class="details-top-div">';
                    order_text1 += '<p>Amount: ' + numberFormatComma(shop_data.billing_amount) + '</p>';
                    order_text1 += '</div>';
                    order_text1 += '<div class="details-top-div">';
                    order_text1 += '<p>Paid: ' + numberFormatComma(shop_data.paid_amount) + '</p>';
                    order_text1 += '</div>';
                    order_text1 += '<div class="details-top-div">';
                    order_text1 += '<p>Outstanding: <span style="color: tomato;">' + outstanding + '</span></p>';
                    order_text1 += '</div>';
                    order_text1 += '</div>';
                    $(".header-details").html(order_text1);
                    if (order_table_check) {
                        order_table.clear();
                        order_table.destroy();
                    }
                    item_data = data.data_item;
                    var html_text = "";
                    var slno1 = "";
                    for (var key in item_data) {
                        slno1++;
                        html_text += '<tr>';
                        html_text += '<td>' + slno1 + '</td>';
                        html_text += '<td>' + item_data[key].date_time + '</td>';
                        html_text += '<td>' + item_data[key].payment_mode + '</td>';
                        html_text += '<td>' + numberFormatComma(item_data[key].amount) + '</td>';
                        html_text += '</tr>';
                    }
                    $("#item_table_body").html(html_text);
                    order_table = $("#item_list_table").DataTable({
                        scrollX: true,
                        bLengthChange: false,
                        searching: false,
                        info: true,
                        buttons: [],
                        language: {
                            search: '<img src="assets/svg/Search_icon.svg">',
                            searchPlaceholder: getGlobalTranslation("search"),
                            paginate: {
                                next: '<img src="assets/svg/Right_arrow_icon.svg">',
                                previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                            }
                        }
                    });
                    order_table_check = true;
                    $(".se-pre-con").hide();
                    setTimeout(() => {
                        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                    }, 70);
                    $('#toggles').hide();
                    $('#toggles1').show();
                });
            }
        </script>
    </body>

    </html>
<?php
}
?>