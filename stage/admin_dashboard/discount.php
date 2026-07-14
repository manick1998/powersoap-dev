<?php
include "config.php";
include "$api_path/config/core_distributor.php";
//    if($cookie_admin_name ==""){
//        header("Location:shop_type.php");
//    }else{
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
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <!-- <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>"> -->
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/retailer.css<?php echo $js_cache_string; ?>">
    <style>
        .a_button {
            color: #00b9f5;
        }

        .a_button:hover {
            color: #fff;
        }

        a {
            cursor: pointer;
        }

        .btn_employees:hover .a_button {
            color: #fff;
        }
    </style>
</head>

<body>
    <header id="main-dash-header" class="dash-header">
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar4"></div>
    <div class="se-pre-con" style="display: none;"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main">Discount</h1>
                    </div>
                    <p class="table_count">Total Discount - <span id="total_shopType_count"></span></p>
                </div>
            </div>
            <div class="dataTables_filter">
                <form class="formdield">
                    <div class="form-group">
                        <button class="btn_employee " class="btn btn-danger" data-toggle="modal" data-target="#form" type="button">Add Discount</button>
                        <input type="hidden" id="hiden" value="">
                    </div>
                </form>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data1" style="display:table;">
                    <thead>
                        <tr>
                            <th>Token</th>
                            <th>Sl No</th>
                            <th>Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="table_body_discount">
                    </tbody>
                </table>
            </div>
        </section>
        <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel"><span><img src="assets/retailer.png" class="icon_add"></span> Add Discount</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="forms">
                            <div class="form-control shop_type_box">
                                <p class="shop_type">Discount</p>
                                <input class="input-field" id="discount" placeholder="Enter discount" value="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <a class="btn" data-dismiss="modal" style="color: #02b9f4;">Close</a>
                        <button type="button" class="btn model-btn" onclick="add_discount()">Add Discount</button>
                    </div>
                </div>
            </div>
        </div>


    </main>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datepicker-->

    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>  -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>

    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
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
    <script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
        var gl_admin_token = "<?php echo $token; ?>";
        var Admin_token = localStorage.getItem("Admin_token");


        $('#datepicker').datepicker({
            autoclose: true,
            todayHighlight: true,
        });
        $('#datepicker1').datepicker({
            autoclose: true,
            todayHighlight: true,
        });
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        $(document).ready(function() {
            $(".se-pre-con").show();
            var datas = {
                dashboard_code: verfication_code,
                type: "All"
            };
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/discount.php",
                data: json_data,
                success: success,
            });
        });
        var table_main_data;

        function success(data) {
            table_main_data = data.data;
            var html_text = "";
            var slno = 0;
            for (var key in table_main_data) {
                slno++;
                html_text += '<tr>';
                html_text += '<td>' + table_main_data[key].token + '</td>';
                html_text += '<td>' + slno + '</td>';
                html_text += '<td>' + table_main_data[key].percentage + '</td>';
                html_text += '<td><a href="javascript:void(0)" style="color:red !important;" class="discount_delete">Delete</a></td>';
                html_text += '</tr>';
            }
            $(".se-pre-con").hide();
            $("#table_body_discount").html(html_text);
            key++;
            $("#total_shopType_count").html(key);
            table = $("#table_data1").DataTable({
                dom: 'Bfrtip',
                scrollX: true,
                buttons: [],
                order: [1, 'asc'],
                "columnDefs": [{
                    "targets": [0],
                    "visible": false,
                    "searchable": false
                }],
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

        function add_discount() {
            var discount = $("#discount").val();
            console.log(discount);
            var val1 = value_check('discount', discount, 'text_box');
            gl_admin_token = Admin_token;
            if (val1 == true) {
                var datas = {
                    'dashboard_code': verfication_code,
                    'discount': discount,
                    'admin_token': gl_admin_token,
                    'type': "addDiscount"
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/discount.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.status_code == "200") {
                        swal("Discount Added Successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal(data.message);
                    }
                });

            } else {
                swal("Please Enter Discount Value");
            }
        }

        $('#table_data1 tbody').on('click', '.discount_delete', function() {
            var td_div = $(this).parent().parent();
            var table_data = table.row(td_div).data();
            var token = table_data[0];
            console.log(token);
            var datas = {
                dashboard_code: verfication_code,
                type: "single_division_delete",
                discount_token: token,
                admin_token: Admin_token
            };
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/discount.php",
                data: json_data,
            }).done(function(data) {
                if (data.status_code == 200) {
                    swal("Discount Deleted Successfully!", {
                        icon: "success",
                    }).then((value) => {
                        location.reload();
                    });
                }

            });
        });
    </script>
</body>

</html>
<?php
//}
mysqli_close($link);
?>