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
    <title>Scheme Management</title>
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
    <link rel="stylesheet" href="css/order.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
<style> 
  .nav-item button {
            white-space: nowrap;
        }

.product_header_container .header-details h1 {
    padding: 29px 40px;
}
.table_count{
    margin-left: 40px;
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
                    <h1 class="header_main">Scheme </h1>
                    <p class="table_count">Total Scheme - <span id="total_count"></span></p>
                </div>
            </div>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane active fade show" id="pills-home">
                    <table class="custom-table" id="table_data">
                        <thead>
                            <tr>
                                <th>Slno</th>
                                <th>Image</th>
                                <th>Scheme Name</th>
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
    <script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    var notiCount = "<?php echo $notiCount; ?>";
</script>
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
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script>

    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
    var distributor_token = "<?php echo $_SESSION['distributor_token'] ?>";
    </script>
    <script>
    $(document).ready(function() {
        $(".se-pre-con").hide();
    let data = {
                    dashboard_code: verfication_code
                };
                var json_data = JSON.stringify(data);
                //console.log(json_data);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/schemeList.php",
                    data:json_data,
                }).done(function(data){
                   success(data);
                   console.log(data);
                });
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
                var images = table_main_data[key].image || 'assets/upload.png';
                html_text += '<td><img src="' + images + '" alt="Scheme Image" width="100" height="100" onerror="this.onerror=null;this.src=\'assets/upload.png\';"></td>';
                html_text += '<td>' + table_main_data[key].scheme_name + '</td>';
                html_text += '<td>' + table_main_data[key].product_name + '</td>';
                html_text += '<td>' + table_main_data[key].limit_box + '</td>';
                html_text += '<td>' + table_main_data[key].free_box + '</td>';
                html_text += '<td>' + table_main_data[key].free_product + '</td>';
                html_text += '</tr>';
            }
            $("#total_count").html(slno);
            $("#table_body").html(html_text);
            table1 = $("#table_data").DataTable({
                dom: 'Bfrtip',
                buttons:[],
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