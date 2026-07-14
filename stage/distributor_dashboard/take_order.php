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
    <title>Take Order List</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>5">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/take_order.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <style>
    input[type="checkbox"].toggle {
        display: none;
    }

    input[type="checkbox"].toggle+label {
        height: 35px;
        line-height: 32px;
        background-color: #48baf5;
        padding: 0px 10px;
        border-radius: 16px;
        display: inline-block;
        position: relative;
        cursor: pointer;
        -moz-transition: all 0.25s ease-in;
        -o-transition: all 0.25s ease-in;
        -webkit-transition: all 0.25s ease-in;
        transition: all 0.25s ease-in;
        -moz-box-shadow: inset 0px 0px 2px rgba(0, 0, 0, 0.5);
        -webkit-box-shadow: inset 0px 0px 2px rgba(0, 0, 0, 0.5);
        box-shadow: inset 0px 0px 2px rgba(0, 0, 0, 0.5);
    }

    table.dataTable thead .sorting:after,
    table.dataTable thead .sorting_asc:after,
    table.dataTable thead .sorting_desc:after,
    table.dataTable thead .sorting_asc_disabled:after,
    table.dataTable thead .sorting_desc_disabled:after {
        content: '' !important;
    }

    table.dataTable thead .sorting:before,
    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:before,
    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:before {
        content: '' !important;
    }

    input[type="checkbox"].toggle+label:before,
    input[type="checkbox"].toggle+label:hover:before {
        content: ' ';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 40px;
        height: 30px;
        background: #fff;
        z-index: 2;
        -moz-transition: all 0.25s ease-in;
        -o-transition: all 0.25s ease-in;
        -webkit-transition: all 0.25s ease-in;
        transition: all 0.25s ease-in;
        -moz-border-radius: 14px;
        -webkit-border-radius: 14px;
        border-radius: 14px;
    }

    input[type="checkbox"].toggle+label .off,
    input[type="checkbox"].toggle+label .on {
        color: #fff;
    }

    input[type="checkbox"].toggle+label .off {
        margin-left: 38px;
        display: inline-block;
    }

    input[type="checkbox"].toggle+label .on {
        display: none;
    }

    input[type="checkbox"].toggle:checked+label .off {
        display: none;
    }

    input[type="checkbox"].toggle:checked+label .on {
        margin-right: 42px;
        display: inline-block;
    }

    input[type="checkbox"].toggle:checked+label,
    input[type="checkbox"].toggle:focus:checked+label {
        background-color: #48baf5;
    }

    input[type="checkbox"].toggle:checked+label:before,
    input[type="checkbox"].toggle:checked+label:hover:before,
    input[type="checkbox"].toggle:focus:checked+label:before,
    input[type="checkbox"].toggle:focus:checked+label:hover:before {
        background-position: 0 0;
        top: 2px;
        left: 100%;
        margin-left: -42px;
    }

    p {
        font-size: 16px;
        color: #717171;
        margin: 0;
    }

    p:first-of-type {
        margin-top: 24px;
    }

    .product_val {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .value_list {
        width: 200px;
    }

    .value_list h2 {
        font-size: 18px;
        line-height: 28px;
        text-align: left;
        margin: 0;
    }

    .text_input {
        width: 65px;
    }

    .sidebar-menu {
        text-align: left;
    }



    .prod_list {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 5px;
        border-radius: 4px;
    }

    .prod_list h2 {
        font: 22px/32px var(--bold-font);
        margin: 0;
        color: #000;
    }

    .prod_list h3 {
        font: 22px/32px var(--bold-font);
        margin: 0;
        color: #000;
    }

    .prod_list p {
        font: 16px/22px var(--regular-font);
        margin: 0;
    }

    .final_list {
        display: block;
        float: left;
        width: 100%;
    }

    .final_list h2 {
        font: 22px/32px var(--bold-font);
        margin: 0;
        color: #000;
    }

    .final_list h3 {
        font: 22px/32px var(--bold-font);
        margin: 0;
        color: #000;
    }

    .custom-table tr th:first-child {
        z-index: 2;
    }

    .custom-table tbody tr td:first-child {
        z-index: 2;
        background-color: #fff;
    }

    .dataTables_scroll::-webkit-scrollbar {
        display: block;
    }

    .summary-table-container {
        max-height: 100%;
        overflow-y: auto;
        margin-bottom: 16px;
    }

    .summary-table-container::-webkit-scrollbar {
        display: block;
        width: 6px;
        background-color: #cfcfcf;
    }

    .summary-table-container::-webkit-scrollbar-track {
        background-color: #cfcfcf;
    }

    .summary-table-container::-webkit-scrollbar-thumb {
        background-color: #232a77;
    }

    .summary-table-container table {
        width: 100%;
    }

    .summary-table-container table th {
        position: sticky;
        top: 0;
        background-color: #fff;
        z-index: 1;
    }

    .summary-table-container table th,
    .summary-table-container table td {
        padding: 10px;
    }

    .cancelbtn {
        color: red;
    }

    .custom-table tbody tr td {
        vertical-align: top;
    }

    #table_list_filter {
        position: relative;
    }

    #divisionlist {
        color: #69a7ff;
        padding: 8px 16px;
        border: 1px solid;
        border-color: #69a7ff;
        cursor: pointer;
        border-radius: 5px;
        width: 253px;
        margin: 5px 0 5px 775px;
        position: absolute;
        top: -7px;
        right: 236px;
    }

    @media screen and (max-width: 550px) {
        .table-box {
            overflow-x: scroll;
        }

        #divisionlist {
            width: 100%;
            position: unset;
            margin: 0;
        }

        .dataTables_filter label {
            margin-top: .5rem;
        }
    }

    select.form-control {
        width: 110px !important;
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
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main"><span class="twoinspace"><img src="assets/back.png"
                                    onclick="back_view_order()" alt=""></span><span id="single_shop_name"> </span></h1>
                        <h1 class="header_main" data-i18n="take_order_list">Take Order List</h1>
                    </div>
                </div>
            </div>
            <!-- <select name='devision' id='divisionlist'></select> -->
            <div class="table-box">

                </select>
                <table class="custom-table" id="table_list">
                    <thead>
                        <tr>
                            <!-- <th>slno</th> -->
                            <!-- <th>Item Code</th> -->
                            <!-- <th>Item Image</th> -->
                            <th data-i18n="item_name">Item Name</th>
                            <!-- <th>Scheme name</th> -->
                            <!-- <th>Net Price</th> -->
                            <!-- <th>PieceCount</th>
                            <th>Mrp</th> -->
                            <th data-i18n="discount">Discount</th>
                            <th data-i18n="quantity">Quantity</th>
                            <th data-i18n="toggle_box">Toggle Box</th>
                        </tr>
                    </thead>
                    <tbody id="tableView">
                    </tbody>
                </table>
            </div>
            <div class="product_val">
                <button class="btn_product" onclick="orderSummary()" id="" data-target="#order-summary"
                    data-toggle="modal" data-i18n="create_order_product">Create Order</button>
                <div class="value_list">
                    <!-- <h2>Total items : <span>20</span></h2>
                     <h2>Amount - <span>1200 Rs</span></h2> -->
                </div>
            </div>
        </section>
        <section class="bg-white brad-4 full-height twoback" id="toggle4" style="display: none;">
            <img src="assets/back.png" onclick="hidemodal()" alt="" class="backword">
            <div class="side-position">

            </div>
        </section>
    </main>



    <!-- Modal -->
    <!-- <div class="modal fade" id="submited" role="dialog">
    <div class="modal-dialog">
     -->
    <!-- Modal content-->
    <!-- <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Order Summary</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="prod_list">
                <h2>Soaps</h2>
                <p>5 Nos<span> | </span> 60 piece <span> | </span>1 Box</p>
                <h3>₹ 265</h3>
          </div>
        </div>
        <div class="modal-footer">
        <div class="final_list">
            <h2>Total Items : <span id="total_item"></span> </h2>
            <h2>Amount - <span id="total_amount"></span></h2>
        </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="createorderProduct()">Place Order</button>
        </div>
      </div>
      
    </div>
  </div> -->

    <!-- The Modal -->
    <div class="modal" id="order-summary">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" data-i18n="order_summary">Order Summary</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="summary-table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th data-i18n="item_name">Item Name</th>
                                    <th data-i18n="quantity">Quantity</th>
                                    <th data-i18n="box_price">Box Price</th>
                                </tr>
                            </thead>
                            <tbody id="orderDetails">
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer justify-content-between">
                    <h5 style="margin-left:10px;font-weight: 600;"><span data-i18n="total_amount">Total Amount</span> - <span class="total_emp"></span></h5>
                    <div>
                        <button type="button" class="savebtn mr-3" id="" onclick="createorderProduct()"
                            data-dismiss="modal" data-i18n="place_order">Place order</button>
                        <button type="button" class="cancelbtn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- js file -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/dataTables.fixedColumns.min.js<?php echo $js_cache_string; ?>"></script>

    <script>
    var notiCount = "<?php echo $notiCount; ?>";
    // console.log(notiCount);
    </script>
    <script>
    var api_path = "<?php echo $api_path; ?>";
    var verfication_code = "<?php echo $verification_code; ?>";
    var dashboardLink = "<?php echo $baseUrlPath; ?>";
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    var token = "<?php echo $_SESSION["retailer_token"]; ?>";
    var unitToken = "<?php echo $_SESSION["unitToken"]; ?>";
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

        var datas = {
            'dashboard_code': verfication_code,
            'distributor_token': distributor_token,
            'token': token,
        };
        var json_data = JSON.stringify(datas);
        // console.log(json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/takeOrder.php",
            data: json_data,
            success: success
        });
        $(".new_desing").css("display", "none");
    });

    function back_view_order() {
        var val = Math.floor(1000 + Math.random() * 9000);
        var globalToken = val + unitToken;
        location.href = dashboardLink + 'distributor_dashboard/retailer?unitToken=' + globalToken;


    }
    var table_main_data1;
    var product;
    var discount;

    function success(data) {
        table_main_data1 = data.data;
        var html_text2 = "";
        var html_text3 = `<select id="divisionlist"><option value='' data-i18n="select_division">${getGlobalTranslation("select_division")}</option>`;
        product = table_main_data1.array;
        discount = table_main_data1.array1;

        // for (var key in product) {
        //     //slno++;
        //     html_text2 += '<tr>';
        //     //html_text2 += '<td>'+slno+'</td>';
        //     //html_text2 += '<td>'+table_main_data1[key].item_code+'</a></td>';

        //     // if (table_main_data1[key].product_image == '') {
        //     //     html_text2 += '<td>-</td>';
        //     // } else {
        //     //     html_text2 += '<td><img src="' + table_main_data1[key].product_image + '" style="height:50px;max-width:50px">'
        //     //     '</td>';
        //     // }
        //     html_text2 += '<td>' + product[key].name + '</td>';
        //     //    if(table_main_data1[key].scheme_name != ''){
        //     //         html_text2 += '<td>'+table_main_data1[key].scheme_name+'</td>';
        //     //    }else{
        //     //         html_text2 += '<td>-</td>';
        //     //    }
        //     //    html_text2 += '<td>'+table_main_data1[key].total_cost+'</td>';
        //     //    html_text2 += '<td>'+table_main_data1[key].piece_count+'</td>';
        //     //    html_text2 += '<td>'+table_main_data1[key].mrp+'</td>';
        //     html_text2 += '<td><select class="form-control select" id="' + product[key].product_token + '_prodoct_discount">';
        //     html_text3 += `<option value='${product[key].division}'>${product[key].division}</option>`;
        //     for (var key1 in discount) {
        //         var value = (discount[key1].percentage).replace('%', '');
        //         html_text2 += '<option value="' + value + '">' + discount[key1].percentage + '</option>';
        //     }

        //     html_text2 += '</select></td>';
        //     html_text2 += '<td><input class="form-control text_input" id="' + product[key].product_token + '_prodoct_itemCode" value="" type="text" onkeypress="return isNumber(event)" onchange="warningSchemeName(' + key + ',' + product[key].product_token + ',' + product[key].limit_box + ')"><span id="schemeWarning' + key + '" style="display:none;">' + product[key].scheme_name + '</span></div></td>';
        //     html_text2 += '<td><input class="toggle" id="' + product[key].product_token + '_prodoct_toggle"  type="checkbox" /><label for="' + product[key].product_token + '_prodoct_toggle"><span id="val" class="on">Box</span><span id="val" class="off">Nos</span></label></td>';
        //     html_text2 += '</tr>';
        //     // html_text3 += `<option value='${table_main_data1[key].name}'>${table_main_data1[key].name}</option>`;
        // }

        for (var key in product) {
            html_text2 += `<tr data-division="${product[key].division}">`; // Add division data attribute here
            html_text2 += '<td>' + product[key].name + '</td>';
            html_text2 += '<td><select class="form-control select" id="' + product[key].product_token +
                '_prodoct_discount">';
            html_text3 +=
                `<option value='${product[key].division}'>${product[key].division}</option>`; // Use division for the option value
            for (var key1 in discount) {
                var value = (discount[key1].percentage).replace('%', '');
                html_text2 += '<option value="' + value + '">' + discount[key1].percentage + '</option>';
            }

            html_text2 += '</select></td>';
            html_text2 += '<td><input class="form-control text_input" id="' + product[key].product_token +
                '_prodoct_itemCode" value="" type="text" onkeypress="return isNumber(event)" onchange="warningSchemeName(' +
                key + ',' + product[key].product_token + ',' + product[key].limit_box + ')"><span id="schemeWarning' +
                key + '" style="display:none;">' + product[key].scheme_name + '</span></div></td>';
            html_text2 += '<td><input class="toggle" id="' + product[key].product_token +
                '_prodoct_toggle"  type="checkbox" /><label for="' + product[key].product_token +
                '_prodoct_toggle"><span id="val" class="on" data-i18n="box">' + getGlobalTranslation("box") + '</span><span id="val" class="off" data-i18n="nos">' + getGlobalTranslation("nos") + '</span></label></td>';
            html_text2 += '</tr>';
        }

        $(".se-pre-con").hide();
        $("#tableView").html(html_text2);
        html_text3 += `</select>`
        var opt = [];

        $("#table_list").DataTable({
            scrollX: true,
            scrollY: '70vh',
            scrollCollapse: true,
            fixedColumns: true,
            // scrollY: screen.width > 768 ? '550' : '500',
            "bPaginate": false,
            dom: 'Bfrtip',
            buttons: [],
            "order": [
                [1, "asc"]
            ],
            "columnDefs": [{
                "targets": [],
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
        $('#table_list_filter').prepend(html_text3);
        $("#divisionlist > option").each(function() {
            if (opt[$(this).val()]) {
                $(this).remove();
            } else {
                opt[$(this).text()] = $(this).val();
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

    function warningSchemeName(key, ordProdVal, limitBox) {
        let order = $("#" + ordProdVal + "_prodoct_itemCode").val();
        let x = parseInt(order) % parseInt(limitBox);
        if (x != 0 && order != '') {
            $('#schemeWarning' + key).show();
        } else {
            $('#schemeWarning' + key).hide();
        }
    }

    function createorder() {
        var order_array = [];
        var billing_amount = 0;
        for (var key in product) {
            var discount = $("#" + product[key].product_token + "_prodoct_discount").val();
            var quantity = $("#" + product[key].product_token + "_prodoct_itemCode").val();
            var toggle = $("#" + product[key].product_token + "_prodoct_toggle").prop("checked") ? "Nos" : "Box";
            if (parseInt(quantity) > 0) {
                var data = {
                    product_token: product[key].product_token,
                    quantity: quantity,
                    discount: discount,
                    toggle: toggle
                };
                order_array.push(data);
            }
        }
        if (order_array.length != 0) {
            var datas = {
                order_array: order_array,
                distributor_token: distributor_token,
                token: token
            };
            var json_data = JSON.stringify(datas);
            //console.log(json_data);
            $.ajax({
                async: false,
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/takeOrderPlaced.php",
                data: json_data,
            });
        }
    }

    function orderSummary() {

        var order_array = [];
        var billing_amount = 0;
        for (var key in product) {
            var quantity = $("#" + product[key].product_token + "_prodoct_itemCode").val();
            var toggle = $("#" + product[key].product_token + "_prodoct_toggle").prop("checked") ? "Box" : "Nos";
            if (parseInt(quantity) > 0) {
                var data = {
                    product_token: product[key].product_token,
                    name: product[key].name,
                    quantity: quantity,
                    toggle: toggle
                };
                order_array.push(data);
            }
        }
        if (order_array.length != 0) {
            var datas = {
                order_array: order_array,
                distributor_token: distributor_token
            };
            var json_data = JSON.stringify(datas);
            console.log(json_data);

            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/takeOrderSummary.php",
                data: json_data,
            }).done(function(data) {
                //console.log(data);
                var table_main = data.data;
                var sum = data.final;
                console.log(sum);
                var html_text = "";
                for (var key in table_main) {
                    html_text += '<tr>';
                    html_text += '<td>' + table_main[key].product_name + '</td>';
                    html_text += '<td>' + table_main[key].quantity + '</td>';
                    html_text += '<td>' + table_main[key].box_price + '</td>';
                    html_text += '</td>';
                }

                $(".total_emp").html(sum);
                $("#orderDetails").html(html_text);
            });
        }
    }

    $(document).on('change', '#divisionlist', function() {
        var selectedDivision = $(this).val();
        var rows = $('#tableView tr');
        rows.hide();
        var noMatchFound = true;

        rows.each(function(i, el) {
            var division = $(el).data(
                'division'); // Retrieve the division value from the data attribute
            if (division == selectedDivision || selectedDivision == '') {
                $(el).show();
                noMatchFound = false;
            }
        });

        if (noMatchFound) {
            rows.show(); // Show all rows if no match is found
        }
    });



    function createorderProduct() {
        var order_array = [];
        var billing_amount = 0;
        for (var key in product) {
            var discount = $("#" + product[key].product_token + "_prodoct_discount").val();
            var quantity = $("#" + product[key].product_token + "_prodoct_itemCode").val();
            var toggle = $("#" + product[key].product_token + "_prodoct_toggle").prop("checked") ? "Nos" : "Box";
            if (parseInt(quantity) > 0) {
                var data = {
                    product_token: product[key].product_token,
                    quantity: quantity,
                    discount: discount,
                    toggle: toggle
                };
                order_array.push(data);
            }
        }
        if (order_array.length != 0) {
            var datas = {
                order_array: order_array,
                distributor_token: distributor_token,
                token: token
            };
            var json_data = JSON.stringify(datas);
            console.log('order', json_data);
            $.ajax({
                async: false,
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/takeOrderPlaced.php",
                data: json_data,
            }).done(function(data) {
                //console.log(data);
                $("#total_item").html(`${data.item}`);
                $("#total_amount").html(`${data.total}`);
                if (data.status_code == "200") {
                    var datas1 = {
                        'order_token': data.order_id,
                        'distributor_token': distributor_token,
                        'invoice_name': data.invoice_name,
                        'oustanding_amount': data.outstanding_amount
                    };
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "../TCPDF-main/examples/salesOrderInvoiceUpdate.php",
                        data: datas1,
                    }).done(function(data) {
                        console.log(data);
                        $(".se-pre-con").fadeOut();
                        swal("Order Created Successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    });
                } else if (data.status_code == "400") {
                    $(".se-pre-con").fadeOut();
                    swal(data.message);
                }
            });
        } else {
            swal("Provide the Quantity!");
        }
    }
    </script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
</body>

</html>
<?php
}
?>