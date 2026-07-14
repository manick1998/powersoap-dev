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
    <title>Powersoaps</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/unit-grouping.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
</head>
<style>
.nav-pills .nav-link,
.nav-pills .show>.nav-link {
    background-color: #fff;
    border: #00b9f5 2px solid;
    color: #00b9f5;
    transition: 1s;
    border-radius: 4px;
}

.nav-pills .nav-link:hover,
.nav-pills .show>.nav-link:hover {
    background-color: #00b9f5;
    color: #fff !important;
}

.nav-pills .nav-link.active,
.nav-pills .show>.nav-link {
    color: #fff;
    background-color: #00b9f5 !important;
}

.nav-item-center {
    margin-left: 100px;
}

.rightbot {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
}

.leftbot {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}

.table-filter {
    text-align: right;
    margin-bottom: 12px;
    padding: 0 20px;
}

.table-filter-box {
    display: inline-block;
    position: relative;
}

.search-input {
    padding: 10px 10px 10px 36px;
    outline: none;
    border: 1px solid #cfcfcf;
    width: 200px;
    border-radius: 4px;
}

.search-label {
    position: absolute;
    left: 12px;
    top: 11px;
}

.unit_name {
    padding: 12px 20px;
    margin: 8px 0;
    box-sizing: border-box;
    border: none;
    border-bottom: 2px solid #00e600;
    font-size: 20px;
    text-align: center;
}

.selected-shop-right {
    overflow: hidden;
    height: auto;
    overflow-y: auto;
}

.choose-shop-inner {
    width: 100%;
}

.colors {
    background-color: #ffb3b3;
}
</style>

<body>
    <header id="main-dash-header" class="dash-header"></header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar6"></div>
    <div class="se-pre-con"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <div class="total-unit">
                    <h1 class="header_main" data-i18n="unit_grouping">Unit Grouping</h1>
                    <p class="table_count"><span data-i18n="total_unit">Total unit</span> - <span id="total_count"></span></p>
                    <div class="cred-btn-box"></div>
                    <ul class="nav nav-pills mb-3 mt-3" id="pills-tab" role="tablist">
                        <li class="nav-item " role="presentation">
                            <a class="nav-link rightbot shopListBtn active" id="pills-home-tab" data-toggle="pill"
                                href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true" data-i18n="create_new_unit">Create New
                                Unit</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link leftbot skuListBtn" id="pills_profile_tab" data-toggle="pill"
                                href="#pills-profile" role="tab" aria-controls="pills-profile"
                                aria-selected="false" data-i18n="create_customized_beat">Create Customized Beat</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <button class="primary-btn" onclick="open_modal()" style="margin-left:20px;"><span><img
                                src="assets/unit_group.png" class="icon_add"></span><span data-i18n="create_new_unit">Create New Unit</span></button>
                    <div class="table-box">
                        <table class="custom-table" id="table_data">
                            <thead>
                                <tr>
                                    <th data-i18n="sl_no">Sl.No</th>
                                    <th data-i18n="unit_name">Unit Name</th>
                                    <th data-i18n="shop_numbers">Shop Numbers</th>
                                    <th data-i18n="shop_names">Shop Names</th>
                                    <th data-i18n="edit">Edit</th>
                                    <th data-i18n="action">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table_body_id"></tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <button class="primary-btn" data-target="#exampleModal2" id="create_customized_beat"
                                data-toggle="modal" style="margin-left:20px;"><span><img src="assets/unit_group.png"
                                class="icon_add"></span><span data-i18n="create_customized_beat">Create Customized Beat</span></button>
                    <div class="table-box">
                        <!-- <p class="table_count">Total unit - <span id="custom_total_count"></span></p> -->
                        <table class="custom-table custom-table2" id="table_data1">
                            <div class="table-filter">
                                <div class="table-filter-box">
                                    <input type="search" class="search-input" id="custom_table_search"
                                        placeholder="search" data-i18n-placeholder="search">
                                    <label class="search-label"><img src="assets/svg/Search_icon.svg"
                                            class="search-icon"></label>
                                    <input type="hidden" id="custom_hidden_data" value="">
                                    <!-- for="table-search" -->
                                </div>
                            </div>
                            <thead>
                                <tr>
                                    <th data-i18n="sl_no">Sl.No</th>
                                    <th data-i18n="custom_unit_name">Custom Unit Name</th>
                                    <th data-i18n="shop_numbers">Shop Numbers</th>
                                    <th data-i18n="unit_names">Unit Names</th>
                                    <th data-i18n="action">Action</th>
                                </tr>
                            </thead>
                            <tbody id="custom_table_body_id"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 data-i18n="create_new_unit">Create New Unit</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="form__detail">
                            <input type="text" id="unit_name" class="form__input" placeholder="Unit Name" data-i18n-placeholder="unit_name">
                            <!-- <label for="" class="form__label unit_name">Unit Name</label> -->
                        </div>
                        <div class="border-underline"></div>
                    </div>
                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p data-i18n="choose_shops">Choose Shops :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="text" id="add_search_text" onkeyup="add_search()" name="search"
                                                class="search-input" placeholder="Search" data-i18n-placeholder="search">
                                        </div>
                                        <div class="filter-box">
                                            <img src="assets/icons/filter_icon.svg">
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="add_shop_html">
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="selected-shop">
                            <p data-i18n="selected_shops">Selected Shops :</p>
                            <div class="shop-table-box">
                                <div class="shop-common-box">
                                    <div class="choose-shop-inner">
                                        <div class="choose-shop-left">
                                            <div class="search-filter-common">
                                                <div class="search-box">
                                                    <img src="assets/icons/search_icon.svg" class="search_icon">
                                                    <input type="text" id="add_filter_search"
                                                        onkeyup="add_filter_search()" name="search" class="search-input"
                                                        placeholder="Search" data-i18n-placeholder="search">
                                                </div>
                                            </div>
                                            <div class="selected-shop-right">
                                                <div class="table-box">
                                                    <table class="custom-table mob-d-table">
                                                        <thead>
                                                            <tr>
                                                                <!-- <th>Sl.no</th> -->
                                                                <th data-i18n="shop_names">Shop Name</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="selectedShop" id="added_shop_html">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="cancel-btn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                        <button class="create-btn" id="add_unit_button" onclick="add_unit()" data-i18n="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 data-i18n="create_new_unit">Create New Unit</h2>
                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="form__detail">
                            <input type="text" id="cus_unit_name" class="form__input" placeholder=" " data-i18n-placeholder="customize_unit_name">
                            <label for="" class="form__label" data-i18n="customize_unit_name">Customize Unit Name</label>
                        </div>
                        <div class="border-underline"></div>
                    </div>

                    <!-- customiz beets -->

                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p data-i18n="choose_unit">Choose Unit :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="search" id="add_units_html" onkeyup="add_search()"
                                                name="search" class="search-input" placeholder="Search" data-i18n-placeholder="search">
                                        </div>
                                        <div class="filter-box">
                                            <!-- <img src="assets/icons/filter_icon.svg"> -->
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="add_units_list">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="selected-shop">
                            <p data-i18n="selected_units">Selected Units :</p>
                            <div class="shop-table-box">
                                <div class="search-filter-common">
                                    <div class="search-box">
                                        <img src="assets/icons/search_icon.svg" class="search_icon">
                                        <input type="text" id="add_search_text" onkeyup="add_search()" name="search"
                                            class="search-input" placeholder="Search" data-i18n-placeholder="search">
                                    </div>
                                    <div class="filter-box">
                                        <img src="assets/icons/filter_icon.svg">
                                    </div>
                                </div>
                                <div class="selected-shop-right">
                                    <div class="table-box">
                                        <input type="hidden" name="just" id="hide_input" value="">
                                        <table class="custom-table mob-d-table" id="added_unit_count">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Sl.no</th> -->
                                                    <th data-i18n="unit_name">Unit Name</th>

                                                </tr>
                                            </thead>
                                            <tbody id="added_units_html">


                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                    <button class="create-btn" id="add_unit_btn" data-i18n="save">Save</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 data-i18n="edit_unit">Edit Unit</h2>
                    <h2 id="edit_view_name"></h2>

                </div>
                <div class="modal-body">
                    <div class="modal-inner-body">
                        <div class="form__detail">
                            <h2 id="custom_unit_name"></h2>
                            <input type="hidden" name="" id="custom_hide" value="">
                        </div>
                        <div class="border-underline"></div>
                    </div>

                    <!-- customiz beets -->

                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p data-i18n="choose_unit">Choose Unit :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="text" id="edit_units_html" onkeyup="add_search()" name="search"
                                                class="search-input" placeholder="Search" data-i18n-placeholder="search">
                                        </div>
                                        <div class="filter-box">
                                            <!-- <img src="assets/icons/filter_icon.svg"> -->
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="edit_add_units_list">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="selected-shop">
                            <p data-i18n="selected_units">Selected Units :</p>
                            <div class="shop-table-box">
                                <div class="selected-shop-right">
                                    <div class="table-box">
                                        <input type="hidden" name="just" id="hide_input" value="">
                                        <table class="custom-table mob-d-table" id="added_unit_count">
                                            <thead>
                                                <tr>

                                                    <th data-i18n="unit_name">Unit Name</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <input type="hidden" name="just1" id="rows_hidden" value="">
                                            <tbody id="edite_units_html">


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                    <button class="create-btn" id="update_unit_btn" data-i18n="update">Update</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h2 id="update_view_name"></h2> -->
                    <input type="text" class='unit_name' id="update_view_name" name="fname">
                    <input id="update_token" type="hidden">
                </div>
                <div class="modal-body">
                    <div class="shop-common-box">
                        <div class="choose-shop">
                            <p data-i18n="choose_shops">Choose Shops :</p>
                            <div class="choose-shop-inner">
                                <div class="choose-shop-left">
                                    <div class="search-filter-common">
                                        <div class="search-box">
                                            <img src="assets/icons/search_icon.svg" class="search_icon">
                                            <input type="text" id="edit_search_text" onkeyup="edit_add_search()"
                                                name="search" class="search-input" placeholder="Search" data-i18n-placeholder="search">
                                        </div>
                                        <div class="filter-box">
                                            <img src="assets/icons/filter_icon.svg">
                                        </div>
                                    </div>
                                    <ul class="choose-shop-list" id="edit_shop_html">

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="selected-shop">
                             <p data-i18n="selected_shops">Selected Shops :</p>
                            <div class="shop-common-box">
                                    <div class="choose-shop-inner">
                                        <div class="choose-shop-left">
                                            <div class="search-filter-common">
                                                <div class="search-box">
                                                    <img src="assets/icons/search_icon.svg" class="search_icon">
                                                    <input type="text" id="edit_filter_search"
                                                        onkeyup="edit_filter_search()" name="search" class="search-input"
                                                        placeholder="Search" data-i18n-placeholder="search">
                                                </div>
                                            </div>
                                    <table class="custom-table  mob-d-table" id="dataTables_filter">
                                        <thead>
                                            <tr>
                                                <!-- <th>Sl.no</th> -->
                                                <th data-i18n="shops">Shops</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="edit_added_shop_html"></tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                    <button class="create-btn" id="update_unit_button" onclick="update_unit()" data-i18n="update">Update</button>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>

    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>

    <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
    <!---- For S3 bucket upload ---->
    <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script>
    var notiCount = "<?php echo $notiCount; ?>";
    </script>
    <script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    </script>
    <script>
    var verfication_code = "<?php echo $verification_code; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    var api_path = "<?php echo $api_path; ?>";
    var table;
    var table_main_data;
    var gl_shop_data;
    var slno = 0;

    $(document).ready(function() {
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token,
            type: "all"
        };
        var json_data = JSON.stringify(datas);
        console.log('json_data', json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/unit_list.php",
            data: json_data,
            success: success,
        });
        shop_data();
    });

    function success(data) {
        table_main_data = data.data;
        var html_text = "";
        var slno = 0;
        for (var key in table_main_data) {
            if (table_main_data[key].active_status != 0) {
                slno++;

                if (table_main_data[key].active_status == 2) {
                    html_text += '<tr>';
                    html_text += '<td class="colors">' + slno + '</td>';
                    html_text += '<td class="colors">' + table_main_data[key].name + '</td>';
                    html_text += '<td class="colors">' + table_main_data[key].shop_count + '</td>';
                    html_text += '<td class="colors">' + table_main_data[key].shop_name + '</td>';
                    html_text += '<td><div><a onclick="get_unit_data(' + key +
                        ')" class="view_link">' + getGlobalTranslation("view_details") + '</a></div></td>';
                    if (table_main_data[key].active_status == 0) {
                        html_text += '<td><div><button data-avtive="' + table_main_data[key].active_status +
                            '" data-unit_token="' + table_main_data[key].token + '" data-count="' + table_main_data[key]
                            .shop_count + '" id="actions" class="tb-btn red">' + getGlobalTranslation("deactivate") + '</button><button data-unit_token="' + table_main_data[key].token + '" class="tb-btn red delete_unit_btn ml-2">' + getGlobalTranslation("delete") + '</button></div></td>';
                    } else {
                        html_text += '<td><div><button data-avtive="' + table_main_data[key].active_status +
                            '" data-unit_token="' + table_main_data[key].token + '" data-count="' + table_main_data[key]
                            .shop_count + '" id="actions" class="tb-btn greenbtn">' + getGlobalTranslation("activate") + '</button><button data-unit_token="' + table_main_data[key].token + '" class="tb-btn red delete_unit_btn ml-2">' + getGlobalTranslation("delete") + '</button></div></td>';
                    }
                    html_text += '</tr>';
                } else if (table_main_data[key].active_status == 1) {
                    html_text += '<tr>';
                    html_text += '<td>' + slno + '</td>';
                    html_text += '<td>' + table_main_data[key].name + '</td>';
                    html_text += '<td>' + table_main_data[key].shop_count + '</td>';
                    html_text += '<td>' + table_main_data[key].shop_name + '</td>';
                    html_text += '<td><div><a onclick="get_unit_data(' + key +
                        ')" class="view_link">' + getGlobalTranslation("view_details") + '</a></div></td>';
                    if (table_main_data[key].active_status == 0) {
                        html_text += '<td>';
                        html_text += '<div>';
                        // html_text += '<button data-avtive="' + table_main_data[key].active_status +'" data-unit_token="' + table_main_data[key].token + '" data-count="' + table_main_data[key].shop_count + '" id="actions" class="tb-btn red">' + getGlobalTranslation("deactivate") + '</button>';
                        html_text += '<button data-unit_token="' + table_main_data[key].token + '" class="tb-btn red delete_unit_btn ml-2">' + getGlobalTranslation("delete") + '</button>';
                        html_text += '</div>';
                        html_text += '</td>';
                    } else {
                        html_text += '<td>';
                        html_text += '<div>';
                        //html_text += '<button data-avtive="' + table_main_data[key].active_status +'" data-unit_token="' + table_main_data[key].token + '" data-count="' + table_main_data[key].shop_count + '" id="actions" class="tb-btn greenbtn">' + getGlobalTranslation("activate") + '</button>';
                        html_text += '<button data-unit_token="' + table_main_data[key].token + '" class="tb-btn red delete_unit_btn ml-2">' + getGlobalTranslation("delete") + '</button>';
                        html_text += '</div>';
                        html_text += '</td>';
                    }
                    html_text += '</tr>';
                }
            }

        }
        $("#total_count").text(slno);
        $("#table_body_id").html(html_text);
        table = $("#table_data").DataTable({
            "scrollX": true,
            dom: 'frtip',
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
        $("#table_body_id").attr('data-row', slno);
        $(".se-pre-con").hide();
    }

    $(document).on('click', '#actions', function() {
        var token = $(this).attr('data-unit_token');
        var active = $(this).attr('data-avtive');
        if (active == 0) {
            var data = {
                unit_token: token,
                distributor_token
            }
            var json_data = JSON.stringify(data);
            console.log('token', json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/deactive_unit.php",
                data: json_data,
            }).done(function(data) {
                if (data.code == "201") {
                    swal("Unit Updated Successfully!", {
                        icon: "success",
                    }).then((value) => {
                        location.reload();
                    });
                } else {
                    $('#update_unit_button').prop('disabled', false);
                    swal(data.message);
                }
            })
        } else {
            var id = $(this).closest("tr").find('td:eq(1)').text();
            $("#update_view_name").val(id);
            $("#update_token").val(token);
            $("#viewmodal").modal('show');
        }



    });

    $(document).on('click', '.delete_unit_btn', function() {
        var token = $(this).attr('data-unit_token');
        swal({
            title: getGlobalTranslation("are_you_sure"),
            text: "Once deleted, you will not be able to recover this unit and its schedules!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                var data = {
                    unit_token: token,
                    distributor_token: distributor_token,
                    dashboard_code: verfication_code
                }
                var json_data = JSON.stringify(data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/delete_unit.php",
                    data: json_data,
                }).done(function(data) {
                    if (data.code == "201") {
                        swal(getGlobalTranslation("successfully_deleted"), {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal(data.message);
                    }
                })
            }
        });
    });

    // search bars
    $(document).ready(function() {
        $("#custom_table_search").keyup(function() {
            var values = $(this).val().toLowerCase();
            $("#custom_table_body_id tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(values) > -1);
            });
        });
        $("#add_units_html").keyup(function() {
            var values1 = $(this).val().toLowerCase();
            $("#add_units_list li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(values1) > -1);
            });
        });
        $("#edit_units_html").keyup(function() {
            var values2 = $(this).val().toLowerCase();
            $("#edit_add_units_list li").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(values2) > -1)
            });
        });
    });


    // customize unit list
    $(document).ready(function() {
        $("#create_customized_beat").click(function() {
            var datas = {
                type: 'customize_unit_list',
                distributor_token: distributor_token
            };
            var json_data = JSON.stringify(datas);
            //console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/customize_unit_list.php",
                data: json_data,

            }).done(function(data1) {

                var data = data1.datas;
                // console.log('data',data);
                var show_data = '';
                var myarray = [];
                for (var key in data) {
                    // console.log('fdau',data[key]); 
                    beat_token = data[key].beat_token;
                    //console.log("oooo",beat_token);
                    beat_name = data[key].beat_name
                    myarray.push(data[key]);
                    // console.log("myarr",myarray);
                    //   data.forEach(function(item,index) {
                    //     show_data +=`<li> ${item.beat_name} <a onclick="add_()"class="view_link">Add</a></li>`
                    // show_data +='<li id="unit_cuz'+ data[key].beat_token+"'>'"+data[key].beat_name+ "'<a onclick="add_units("'+data[key]+'")" class="view_link" id='"add_unit"'>Add</a></li>'

                    show_data += '<li  data-beat_token="' + data[key].beat_token +
                        '" data-beat_name="' + data[key].beat_name + '" id="unit_cuz">';
                    show_data += '<p > ' + data[key].beat_name + '</p>';
                    show_data += '<a  id="units" data-my_beat_token="' + data[key]
                        .beat_token + '"  class="view_link">' + getGlobalTranslation("add") + '</a>';
                    // show_data += '<a onclick="add_unit(' + beat_name +','+beat_token+')" class="view_link">Add</a>';
                    show_data += '</li>';
                    //    })
                }
                $("#add_units_list").html(show_data);


                var bla = $('#custom_hidden_data').val();

                var number = bla.split(',').map(Number);




                $('#add_units_list li').each(function(i) {
                    for (var i = 0; i < number.length; i++) {
                        // console.log($(this).attr("data-beat_token"));
                        if ($(this).attr('data-beat_token') == number[i]) {
                            $(this).hide();

                        } else {

                        }
                    }
                });



                //    var show_data1='';
                //    for (var key1 in data) {
                //     var beat_token = data[key1].beat_token;
                //     var beat_name = data[key1].beat_name;
                //     show_data1 += '<li data-beat_token="'+ data[key1].beat_token +'" data-beat_name="'+ data[key1].beat_name +'" id="edit_selected_unit_cuz">';
                //     show_data1 += '<p > ' + data[key1].beat_name + '</p>';
                //     show_data1 += '<a data-my_beat_token="'+ data[key1].beat_token+ '"  class="view_link">Add</a>';
                //     show_data1 += '</li>';
                // }   
                //   $("#edit_add_units_list").html(show_data1);
                //   var bla = $('#custom_hidden_data').val();


            });
        });
    });

    //Add cuz unit
    $(document).ready(function() {
        var array_data = [];

        $(document).on("click", "#unit_cuz", function() {

            var html_text = "";

            $(this).each(function() {
                $(this).remove();
                var beat_token = $(this).attr("data-beat_token");

                var beat_name = $(this).attr("data-beat_name");
                array_data.push(beat_token);

                html_text +=
                    '<tr class="added_shops_class" id="remove_data" data-add_beat_token="' +
                    array_data + '" data-add_beat_name="' + beat_name + '" >';

                html_text += '<td id="add_unit_cuz">' + beat_name + '</td>';
                html_text += '<td><span  class="remove">' + getGlobalTranslation("remove") + '</span></td>';
                html_text += '</tr>';

                $("#added_units_html").append(html_text);
                $("#hide_input").val(array_data);

                // $("#add_units_list").append(html_text);
                //$("#rows_hidden").val(html_text)
            });
            //console.log("hide_datas",hide_datas);
        });

    });
    //remove cuz unit
    $(document).ready(function() {
        // console.log($("#add_units_list").val());

        $(document).on("click", "#remove_data", function() {


            $(this).each(function() {
                $(this).remove();
                var beat_token = $(this).attr("data-add_beat_token");
                var beat_name = $(this).attr("data-add_beat_name");
                console.log(beat_token);
                console.log(beat_name);
                var show_data = "";
                show_data += '<li  data-beat_token="' + beat_token + '" data-beat_name="' +
                    beat_name + '" id="unit_cuz">';
                show_data += '<p > ' + beat_name + '</p>';
                show_data += '<a  id="units" data-my_beat_token="' + beat_token + ',' +
                    beat_name + '"  class="view_link">Add</a>';
                show_data += '</li>';
                $("#add_units_list").append(show_data);

            });
        });
    });

    //save cuz unit
    $(document).ready(function() {
        $("#add_unit_btn").click(function() {
            var unitName = $("#cus_unit_name").val();
            console.log("unitName", unitName);
            var beat_tokens = [];
            var array_token = $("#hide_input").val();
            var beat_tokens = array_token.split(',').map(parseFloat);
            //console.log("hai", ids.length);
            //beat_tokens.push(ids);
            var rowCount = $('#added_units_html tr').length;


            if (unitName != "" && rowCount > 0) {
                var datas = {
                    distributor_token: distributor_token,
                    unitName: unitName,
                    beat_tokens: beat_tokens,
                }
                var json_data = JSON.stringify(datas);
                console.log(json_data);
                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    url: api_path + "/distributor/add_custamiz_beat.php",
                    data: json_data,
                }).done(function(data) {
                    console.log("response", data);
                    if (data.code == "201") {
                        swal("Customise Unit Created Successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal("Something Went to Wrong", {});
                    }
                });

            } else {
                if (rowCount == 0) {
                    swal("Please Select Units");
                } else {
                    swal("Please enter all details!");
                }

            }

        });

    });

    var hide_arr_data = [];
    $(document).ready(function() {
        var data = {
            type: 'customize_unit_data',
            distributor_token: distributor_token
        }
        var json_data = JSON.stringify(data);
        $.ajax({
            type: "POST",
            url: api_path + "/distributor/custom_unit_table_data.php",
            data: json_data
        }).done(function(data) {
            var html_text = "";
            var unit_customise_token = "";
            var count = 0;
            data.datas.forEach(function(item, index) {
                count++;
                unit_customise_token = item.unit_customise_token;
                var u_token = item.unit_token;
                hide_arr_data.push(u_token);
                html_text += '<tr class="customise_table"  data-unit_customise_token="' +
                    item.shop_token + '" data-unit_customise_token="' + item
                    .unit_customise_token + '" data-particuler_unit_token="' + item
                    .unit_token + '">';
                html_text += '<td>' + count + '</td>';
                html_text += '<td>' + item.customunit_name + '</td>';
                html_text += '<td>' + item.total_shops + '</td>';
                html_text += '<td>' + item.unit_name + '</td>';
                html_text +=
                    '<td><a class="view_link" id="custom_data_table" onclick="custom_unit_data_table(' +
                    unit_customise_token +
                    ')" data-toggle="modal" data-unit_customise_token="' + item
                    .unit_customise_token + '" data-target="#editModal">Edit</a></td>';
                html_text += '</tr>';
            });
            $('#custom_table_body_id').attr('data-row', count);
            $("#custom_table_body_id").append(html_text);
            $("#custom_hidden_data").val(hide_arr_data);
            table = $("#table_data1").DataTable({
                "scrollX": true,
                dom: 'rtip',
                buttons: [],
                language: {
                    searching: false,
                    search: '<img src="assets/svg/Search_icon.svg">',
                    searchPlaceholder: "Search",
                    paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">',
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">'
                    }
                }
            });
        });
    });

    //edit customize unit list

    function custom_unit_data_table(unit_customise_token) {
        var datas = {
            type: 'customize_unit_data',
            distributor_token: distributor_token
        };
        var json_data = JSON.stringify(datas);
        //console.log(json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/customize_unit_list.php",
            data: json_data,

        }).done(function(data1) {
            var data = data1.datas;
            console.log('datamy', data);
            var show_data1 = '';
            for (var key1 in data) {
                var beat_token = data[key1].beat_token;
                var beat_name = data[key1].beat_name;
                show_data1 += '<li data-beat_token="' + data[key1].beat_token + '" data-beat_name="' + data[
                    key1].beat_name + '" id="edit_selected_unit_cuz">';
                show_data1 += '<p > ' + data[key1].beat_name + '</p>';
                show_data1 += '<a data-my_beat_token="' + data[key1].beat_token +
                    '"  class="view_link">Add</a>';
                show_data1 += '</li>';
            }
            $("#edit_add_units_list").html(show_data1);
            var bla = $('#custom_hidden_data').val();
            var number = bla.split(',').map(Number);
            $('#edit_add_units_list li').each(function(i) {
                for (var i = 0; i < number.length; i++) {
                    // console.log($(this).attr("data-beat_token"));
                    if ($(this).attr('data-beat_token') == number[i]) {
                        $(this).hide();
                    } else {

                    }

                }
            });

        });



        var data = {
            type: 'edit_custom_unit',
            custom_token: unit_customise_token
        }
        $("#custom_hide").val(unit_customise_token);
        var json_data = JSON.stringify(data);
        console.log("this", json_data);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/edit_custom_unit.php",
            data: json_data
        }).done(function(res_data1) {
            var res_data = res_data1.datas;
            console.log(res_data);
            var html_text = "";
            // $("#edit_hide_input").val(res_data[2].unit_token); 
            //console.log(res_data);
            console.log(res_data[0].customunit_name);
            $("#custom_unit_name").html(res_data[0].customunit_name);
            var cus_name = "";
            res_data.forEach(function(item, index) {
                // cus_name += itme.customunit_name;
                //token_unit.push(item.unit_token);
                // var item_unit_token = item.unit_customise_token
                // console.log("item_unit_token",item_unit_token);
                html_text +=
                    '<tr class="edit_added_unit_class" id="edit_remove_data" data-unit_customise_token="' +
                    item.unit_customise_token + '" data-edit_beat_token="' + item.unit_token +
                    '"data-edit_beat_name="' + item.unit_name + '">';
                html_text += '<td id="edit_unit_cuz">' + item.unit_name + '</td>';
                html_text += '<td><span  class="remove">Remove</span></td>';
                html_text += '</tr>';

            });
            //console.log("hello",token_unit);
            $("#edite_units_html").empty();
            $("#edite_units_html").html(html_text);

            // $("#edit_hide_input").val(token_unit);
        });
    }

    //edit cuz unit Remove
    $(document).ready(function() {
        var array_data = [];
        $(document).on("click", "#edit_selected_unit_cuz", function() {
            $(this).remove();
            var html_text = "";
            //var beat_token = $(this).attr("data-beat_token");
            $(this).each(function() {

                var beat_token = $(this).attr("data-beat_token");
                // console.log(beat_token);
                var beat_name = $(this).attr("data-beat_name");
                array_data.push(beat_token);
                html_text +=
                    '<tr class="edit_added_unit_class" id="edit_remove_data" data-edit_beat_token="' +
                    beat_token + '" data-edit_beat_name="' + beat_name + '" >';
                html_text += '<td id="edit_unit_cuz">' + beat_name + '</td>';
                html_text += '<td><span  class="remove">Remove</span></td>';
                html_text += '</tr>';
            });
            $("#edite_units_html").append(html_text);


        });

    });
    //edit cuz unit add

    $(document).on("click", "#edit_remove_data", function() {
        $(this).remove();
        //    console.log("ree",$(this).attr("data-edit_beat_token"));
        //    console.log("ree",$(this).attr("data-edit_beat_name"));

        var beat_token = $(this).attr("data-edit_beat_token");
        var beat_name = $(this).attr("data-edit_beat_name");
        var array = [];
        array.push(beat_token);
        var show_data2 = "";
        show_data2 += '<li data-beat_token="' + beat_token + '" value="' + beat_token +
            '" data-beat_name="' + beat_name + '" id="edit_selected_unit_cuz">';
        show_data2 += '<p > ' + beat_name + '</p>';
        show_data2 += '<a data-my_beat_token="' + beat_token + '"  class="view_link">Add</a>';
        show_data2 += '</li>';

        $("#edit_add_units_list").append(show_data2);

    });
    $(document).ready(function() {
        //var grey = 

        $("#update_unit_btn").on("click", function() {
            // var pre_token=$("#edit_hide_input").val().split(',').map(parseFloat);
            // var next_add_token = $("#edit_hide_input_data").val().split(',').map(parseFloat);
            // var next_remove_token = $("#edit_hide_input_remove").val().split(',').map(parseFloat);
            // var total_arr = [];
            // total_arr.push(...pre_token,...next_add_token,...next_remove_token);
            // //arra.push(...aa,...bb);
            // //console.log(total_arr);
            // var new_array = total_arr.filter(function(item, pos) {
            //     return total_arr.indexOf(item) == pos;
            // });
            // console.log(new_array)
            // $(".added_shops_class_" + item_unit_token);
            // var arr = document.getElementsByClassName("added_shops_class_"+item_unit_token);
            //console.log($(".added_shops_class_" + item_unit_token).val());
            //console.log($("#edit_remove_data").data("edit_beat_token"));
            var rowCount = $("#edite_units_html tr").length;
            if (rowCount != 0) {
                var edit_arr1 = [];
                $(".edit_added_unit_class").each(function(i, obj) {
                    var token_of_unit = $(this).attr("data-edit_beat_token");
                    edit_arr1.push(token_of_unit);

                });
                $("#rows_hidden").val(edit_arr1);
                var beat_tokes = $("#rows_hidden").val();
                var token = $("#custom_hide").val();
                console.log("token", token);
                // console.log("unit_customise_token",unit_customise_token);
                // console.log(edit_arr);
                var beat_tokens = beat_tokes.split(',').map(parseFloat);
                console.log(beat_tokens);

                var data = {
                    token: token,
                    beat_tokens: beat_tokens,
                    distributor_token: distributor_token
                };
                var json_data = JSON.stringify(data);
                console.log(json_data);
                $.ajax({
                    type: "POST",
                    url: api_path + "/distributor/update_customiz_beat.php",
                    data: json_data
                }).done(function(seccess) {
                    console.log("msg", seccess);
                    if (seccess.code == "201") {
                        swal("Customise Unit Updated Successfully!", {
                            icon: "success",
                        }).then((value) => {
                            location.reload();
                        });
                    } else {
                        swal("Something Went to Wrong", {});
                    }
                });
            } else {
                swal("Please entet the unit");
                // swal("Please entet the unit !", {
                //             //icon: "success",
                //         })
                // .then((value) => {
                //     location.reload();
                // });
            }

        });
    })




    function shop_data() {
        var datas = {
            dashboard_code: verfication_code,
            distributor_token: distributor_token
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/unit_shop_list.php",
            data: json_data,
        }).done(function(data) {
            //  console.log('data',data);
            gl_shop_data = data.data;

            var html_text = "";
            for (var key in gl_shop_data) {
                // console.log('shop_data1',gl_shop_data[key].shop_uniq_token);
                html_text += '<li class="shop_list_class" data-shop_uniq_token1 = "' + gl_shop_data[key]
                    .shop_uniq_token + '" id="add_' + gl_shop_data[key].token + '">';
                html_text += '<p>' + gl_shop_data[key].name + '</p>';
                html_text += '<p class="mobile"  hidden>' + gl_shop_data[key].mobile + '</p>';
                html_text += '<a onclick="add_shop(' + key + ')" class="view_link">Add</a>';
                html_text += '</li>';
            }
            $("#add_shop_html").html(html_text);

            var html_text = "";
            for (var key in gl_shop_data) {
                // console.log('shop_data2',gl_shop_data[key].shop_uniq_token);
                html_text += '<li class="edit_shop_list_class" data-shop_token_uniq ="' + gl_shop_data[key]
                    .shop_uniq_token + '"  id="edit_' + gl_shop_data[key].token + '">';
                html_text += '<p>' + gl_shop_data[key].name + '</p>';
                html_text += '<a onclick="edit_add_shop(' + key + ')" class="view_link">Add</a>';
                html_text += '</li>';
            }
            $("#edit_shop_html").html(html_text);
        });
    }

    function add_shop(key) {
        var token = gl_shop_data[key].token;
        $("#add_" + gl_shop_data[key].token).remove();
        // console.log('shop_data3',gl_shop_data[key].shop_uniq_token);
        var html_text = "";
        html_text += '<tr class="added_shops_class" data-shop_token_uniq1 = "' + gl_shop_data[key].shop_uniq_token +
            '" id="' + gl_shop_data[key].token + '">';
        html_text += '<input value="' + gl_shop_data[key].token + '" hidden>';
        html_text += '<td>' + gl_shop_data[key].name + '</td>';
        html_text += '<td><span onclick="remove_shop(' + key + ')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#added_shop_html").append(html_text);
    }

    function remove_shop(key) {
        var token = gl_shop_data[key].token;
        $("#" + gl_shop_data[key].token).remove();
        // console.log('shop_data4',gl_shop_data[key].shop_uniq_token);
        var html_text = "";
        html_text += '<li class="shop_list_class" data-shop_token_uniq = "' + gl_shop_data[key].shop_uniq_token +
            '" id="add_' + gl_shop_data[key].token + '">';
        html_text += '<p>' + gl_shop_data[key].name + '</p>';
        html_text += '<a onclick="add_shop(' + key + ')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#add_shop_html").append(html_text);
    }

    function add_search() {
        var text = $("#add_search_text").val();
        text = text.toLowerCase();
        $('.shop_list_class').each(function(i, obj) {
            var id = this.id;
            var name = $("#" + id + " > p").html();
            name = name.toLowerCase();
            var mobile = $("#" + id + " > .mobile").html();
            if (name.startsWith(text) || mobile.startsWith(text)) {
                $("#" + id).css("display", "flex");
            } else {
                $("#" + id).css("display", "none");
            }
        });
    }

    //add_filter_search


    function add_filter_search() {
        var text1 = $("#add_filter_search").val();
        textvalue = text1.toLowerCase();
        $('.added_shops_class').each(function(i, obj) {
            var id = this.id;
            var name = $("#" + id + " > td").html();
            console.log(name);
            name = name.toLowerCase();
            if (name.startsWith(textvalue)) {
                $("#" + id).css("display", "flex");
            } else {
                $("#" + id).css("display", "none");
            }
        });
    }

    //edit serach 
    function edit_filter_search() {
        var text1 = $("#edit_filter_search").val();
        textvalue = text1.toLowerCase();
        $('.edit_added_shops_class').each(function(i, obj) {
            var id = this.id;
            var name = $("#" + id + " > td").html();
            console.log(name);
            name = name.toLowerCase();
            if (name.startsWith(textvalue)) {
                $("#" + id).css("display", "flex");
            } else {
                $("#" + id).css("display", "none");
            }
        });
    }

    function add_unit() {
        var unit_name = $("#unit_name").val();
        var val1 = value_check('unit_name', unit_name, 'text');
        //console.log( val1);
        var shop_tokens = [];
        var shop_token_uniq = [];
        $('.added_shops_class').each(function(i, obj) {
            var token = this.id;
            var uniq_token = $(this).attr('data-shop_token_uniq1');
            console.log('uniq_token', uniq_token);
            shop_tokens.push(token);
            shop_token_uniq.push(uniq_token);
            console.log(shop_tokens);
        });
        if (val1 == true && shop_tokens.length > 0) {
            var datas = {
                'unit_name': unit_name,
                'shop_tokens': shop_tokens,
                'shop_token_uniq': shop_token_uniq,
                'dashboard_code': verfication_code,
                'distributor_token': distributor_token
            }
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/add_unit.php",
                data: json_data,
            }).done(function(data) {
                if (data.code == "201") {
                    swal("Unit Created Successfully!", {
                        icon: "success",
                    }).then((value) => {
                        location.reload();
                    });
                } else {
                    $('#add_unit_button').prop('disabled', false);
                    swal(data.message);
                }
            });
        } else {
            if (shop_tokens.length == 0) {
                swal("Please Select Shop");
            } else {
                swal("Please enter all details!");
            }
        }
    }

    function open_modal() {
        shop_data();
        $("#edit_added_shop_html").html('');
        $("#exampleModal").modal("show");
    }
    var exist_shop_data;

    function get_unit_data(key) {
        $("#update_view_name").val(table_main_data[key].name);
        $("#update_token").val(table_main_data[key].token);
        var token = table_main_data[key].token;
        shop_data();
        $("#added_shop_html").html('');
        var datas = {
            dashboard_code: verfication_code,
            token: token,
            'distributor_token': distributor_token,
            type: "single"
        };
        var json_data = JSON.stringify(datas);
        console.log(json_data);
        $.ajax({
            async: false,
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/unit_list.php",
            data: json_data,
        }).done(function(data) {
            console.log('view Details', data);
            exist_shop_data = data.data;
            var html_text = "";
            for (var key in exist_shop_data) {
                //console.log('shop_data5',exist_shop_data[key].uniq_token);
                //
                html_text += '<tr class="edit_added_shops_class" data-shop_token_uniq = "' +
                    exist_shop_data[key].uniq_token + '" id="' + exist_shop_data[key].token + '">';
                html_text += '<input value="' + exist_shop_data[key].token + '" hidden>';
                html_text += '<td>' + exist_shop_data[key].name + '</td>';
                html_text += '<td><span onclick="edit_remove_shop_exist(' + key +
                    ')" class="remove">Remove</span></td>';
                html_text += '</tr>';
            }
            $("#edit_added_shop_html").html(html_text);
        });
        $("#viewmodal").modal('show');
    }
    //exist shop add and remove while update
    function edit_remove_shop_exist(key) {
        var token = exist_shop_data[key].token;
        $("#" + exist_shop_data[key].token).remove();
        console.log('shop_data6', exist_shop_data[key].uniq_token);
        //data-shop_token_uniq = "'+ exist_shop_data[key].uniq_token +'"
        var html_text = "";
        html_text += '<li class="edit_shop_list_class"  id="edit_' + exist_shop_data[key].token + '">';
        html_text += '<p>' + exist_shop_data[key].name + '</p>';
        html_text += '<a onclick="edit_add_shop_exist(' + key + ')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#edit_shop_html").append(html_text);
    }

    function edit_add_shop_exist(key) {
        var token = exist_shop_data[key].token;
        $("#edit_" + exist_shop_data[key].token).remove();
        console.log('shop_data7', exist_shop_data[key].uniq_token);
        // data-shop_token_uniq = "'+ exist_shop_data[key].uniq_token +'"
        var html_text = "";
        html_text += '<tr class="edit_added_shops_class"  id="' + exist_shop_data[key].token + '">';
        html_text += '<input value="' + exist_shop_data[key].token + '" hidden>';
        html_text += '<td>' + exist_shop_data[key].name + '</td>';
        html_text += '<td><span onclick="edit_remove_shop_exist(' + key + ')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#edit_added_shop_html").append(html_text);
    }

    //new add and remove while update
    function edit_add_shop(key) {
        console.log('hello');
        console.log('key', key);
        var token = gl_shop_data[key].token;
        $("#edit_" + gl_shop_data[key].token).remove();
        console.log('shop_data8', gl_shop_data[key].shop_uniq_token);
        var html_text = "";
        html_text += '<tr class="edit_added_shops_class" data-shop_token_uniq = "' + gl_shop_data[key]
            .shop_uniq_token + '" id="' + gl_shop_data[key].token + '">';
        html_text += '<input value="' + gl_shop_data[key].token + '" hidden>';
        html_text += '<td>' + gl_shop_data[key].name + '</td>';
        html_text += '<td><span onclick="edit_remove_shop(' + key + ')" class="remove">Remove</span></td>';
        html_text += '</tr>';
        $("#edit_added_shop_html").append(html_text);
    }

    function edit_remove_shop(key) {
        var token = gl_shop_data[key].token;
        $("#" + gl_shop_data[key].token).remove();
        console.log('shop_data9', gl_shop_data[key].shop_uniq_token);
        //data-shop_token_uniq = "'+ gl_shop_data[key].shop_uniq_token +'"
        var html_text = "";
        html_text += '<li class="edit_shop_list_class"  id="edit_' + gl_shop_data[key].token + '">';
        html_text += '<p>' + gl_shop_data[key].name + '</p>';
        html_text += '<a onclick="edit_add_shop(' + key + ')" class="view_link">Add</a>';
        html_text += '</li>';
        $("#edit_shop_html").append(html_text);
    }

    function edit_add_search() {
        var text = $("#edit_search_text").val();
        text = text.toLowerCase();
        $('.edit_shop_list_class').each(function(i, obj) {
            var id = this.id;
            var name = $("#" + id + " > p").html();
            name = name.toLowerCase();
            if (name.startsWith(text)) {
                $("#" + id).css("display", "flex");
            } else {
                $("#" + id).css("display", "none");
            }
        });
    }

    function update_unit() {
        var unit_token = $("#update_token").val();
        //console.log("unit",unit_token);
        var shop_tokens = [];
        var shop_token_uniq1 = [];
        // $('.edit_added_shops_class').each(function (item,index) {
        //     var retailer_token_uniq = $(this).attr('data-shop_token_uniq5');
        //     shop_token_uniq1.push(retailer_token_uniq);
        // })
        $('.edit_added_shops_class').each(function(i, obj) {
            var token = this.id;
            var shop_token_uniq = $(this).attr('data-shop_token_uniq');
            shop_tokens.push(token);
            shop_token_uniq1.push(shop_token_uniq);
        });
        var edit_unit_name = $('#update_view_name').val();
        if (shop_tokens.length > 0) {
            var datas = {
                'edit_unit_name': edit_unit_name,
                'unit_token': unit_token,
                'shop_tokens': shop_tokens,
                'shop_token_uniq1': shop_token_uniq1,
                'dashboard_code': verfication_code,
                'distributor_token': distributor_token
            }
            var json_data = JSON.stringify(datas);
            console.log(json_data);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/update_unit.php",
                data: json_data,
            }).done(function(data) {
                if (data.code == "201") {
                    swal("Unit Updated Successfully!", {
                        icon: "success",
                    }).then((value) => {
                        location.reload();
                    });
                } else {
                    $('#update_unit_button').prop('disabled', false);
                    swal(data.message);
                }
            });
        } else {
            if (shop_tokens.length == 0) {
                swal("Please Select Shop");
            } else {
                swal("Please enter all details!");
            }
        }
    }

    // set total count and heading at the top 
    $('.nav-link').on('click', function() {
        const id = $(this).attr('href');
        console.log('this', id);
        const tableRowCount = $(`${id} tbody`).attr('data-row');
        console.log("tableRowCount", tableRowCount);
        $('#total_count').text(tableRowCount);

        let heading;
        switch (id) {
            case '#pills-home':
                heading = 'Unit Grouping';
                break;
            case '#pills-profile':
                heading = 'Customized Unit Grouping';
                break;
        }
        $('.header_main').text(heading);

    })

    $('a[data-toggle="pill"]').on('shown.bs.tab', function(e) {
        $.fn.dataTable.tables({
            visible: true,
            api: true
        }).columns.adjust();
    });
    </script>
</body>

</html>
<?php
}
mysqli_close($link);
?>