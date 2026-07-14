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
    <title>Power Soap | Offer</title>
    <link rel="shortcut icon" href="assets/favicon.ico">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/datatables.min.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/offer.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/select.css<?php echo $js_cache_string; ?>">
    <style>
        .form-control {
            margin: 20px 0;
        }
        .form-control p {
            margin: 0;
            color: #798893;
            font-size: 14px;
            font-weight: 600;
            line-height: 20px;
            text-align:left;
        }
        .input-field {
            border: none;
            color: #333;
            width: 100%;
            font-size: 16px;
            line-height: 20px;
            outline:none;
        }
        .delete-cls{
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="se-pre-con"></div>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar7"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height">
            <div class="header_container">
                <h1 class="header_main">Offer List </h1>
                <span class="table_count">Total Offer - <span id="total_offer_count"></span></span>
            </div>
            <div class="table-box">
                <table class="custom-table" id="table_data">
                    <thead>
                        <tr>
                            <th>Sl.No</th>
                            <th>Offer Name</th>
                            <th>Division</th>
                            <th>Offer</th>
                            <th>Minimum Purchase amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

<script>var Distributor_name = "<?php echo $_SESSION["name"]; ?>";</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
<!--    datepicker-->
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> 
<!-- jquery CDN -->
<script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script>-->
<!-- datatable -->
<script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
<script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
<!-- js file -->
<script src="js/header.js<?php echo $js_cache_string; ?>"></script>
<script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
<script src="js/select.js<?php echo $js_cache_string; ?>"></script>
<script>var notiCount = "<?php echo $notiCount; ?>";</script>    
<script>
var verfication_code = "<?php echo $verification_code; ?>";
var distributor_token ="<?php echo $_SESSION["distributor_token"]; ?>";   
var api_path = "<?php echo $api_path; ?>";
var table;
$(document).ready(function () {
    var datas = {
        dashboard_code: verfication_code,
        distributor_token:distributor_token,
        type: "count_check"
    };
    var json_data = JSON.stringify(datas);
    $.ajax({
        type: "POST",
        dataType: "json",
        url : api_path+"/distributor/offer_details.php",
        data: json_data,
    }).done(function(datas) {
        var count = datas.Count;
        $("#total_offer_count").html(numberWithCommas(count));
    });
    table = $('#table_data').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [ 4 ] }, 
        ],
        'ajax': {'url':api_path+"/distributor/server_offer_list.php?v_id="+verfication_code+"&&dist_id="+distributor_token},
        "order": [[0, "DESC" ]],
        'columns': [
            { data: 'token' },
            { data: 'name' },
            { data: 'division' },
            { data: 'offer' },
            { data: 'amount' }
        ],
        language: {
            search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search"
        }
    });
    table.column(0).visible(false);
    $('.dataTables_length').css("display","none");
     $(".se-pre-con").hide();
});
</script>
</body>
</html>
<?php
}
mysqli_close($link);
?>