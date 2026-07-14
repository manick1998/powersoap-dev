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
    <title>Power Soap | Notification List</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?><?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/inventory.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/notification_list.css<?php echo $js_cache_string; ?>">
</head>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <div class="se-pre-con"></div>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar13"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="toggle5" >
            <div class="header_container">
                <div class="header-details ">
                    <div class="title_box">
                        <div class="header_box">
                            <div class="header_box_contnent">
                                <h1 class="header_main">Notification List</h1>
                                <p class="table_count notify">Total Notification - <span id="project_count"></span></p>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
            <div class="tab-content" id="" >
                <div class="tab-pane active fade show" id="" role="" aria-labelledby="">
                    <div class="table-box">
                        <table class="custom-table" id="dataTables_filter1">
                            <thead>
                                <tr>
                                    <th>SI.No</th>
                                    <th>Notification Title</th>
                                    <th>Description</th>
                                    <th>Created Date</th>
                                    <th>Created Time</th>
                                </tr>
                            </thead>
                            <tbody id="table_body_notify">
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>     
        </section>
    </main>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script>
        var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
        var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        var notiCount = "<?php echo $notiCount; ?>";
    </script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <script>
    var table;    
    var distributor_token = "<?php echo $_SESSION["distributor_token"]; ?>";
    var verfication_code = "<?php echo $verification_code; ?>";
    var api_path = "<?php echo $api_path; ?>";
        
        /* Radion button box */ 
        $('.ratio-btn-selecter').on('click',function(){
            var quickcheck = $(this).attr('data-value');
           if(quickcheck == "image"){
               $('input[name=radio_btn_option][value="image"]').attr('checked', 'checked');
               $('.popup-image-box').removeClass('hidden');
               $('.popup-video-box').addClass('hidden');
           }
           else{
              $('input[name=radio_btn_option][value="video"]').attr('checked', 'checked');
              $('.popup-image-box ').addClass('hidden');
               $('.popup-video-box').removeClass('hidden');
           }
        });
        
        $(document).ready(function(){
            var datas1 = {
                'dashboard_code':verfication_code,
                'distributor_token':distributor_token,
                'type':'selectAll_notify'
            }
            var json_data1 = JSON.stringify(datas1);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path+"/distributor/notification.php", 
                data: json_data1,
                success: success
            });
        });
        var notify_data;
        var table;
        function success(data){
        $('#bell-btn').addClass('hidden');
        $('#bell-btn1').removeClass('hidden');
          notify_data = data.data;
          html_text = '';
          slno = 0;    
          for(var key in notify_data){
              slno++;
                 html_text += '<tr>';
                    html_text += '<td>'+slno+'</td>';
                    html_text += '<td>'+notify_data[key].notification_title+'</td>';
                    html_text += '<td>'+notify_data[key].notification_description+'</td>';
                    html_text += '<td>'+notify_data[key].onlyDate+'</td>';
                    html_text += '<td>'+notify_data[key].onlyTime+'</td>';
                 html_text += '</tr> ';
          }
            $("#table_body_notify").html(html_text);
            $("#project_count").text(slno);
            table = $("#dataTables_filter1").DataTable({
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
                ],
                language: {
                    search: '<img src="assets/svg/Search_icon.svg">', searchPlaceholder: "Search" ,
                   paginate: {
                        next: '<img src="assets/svg/Right_arrow_icon.svg">', 
                        previous: '<img src="assets/svg/Left_arrow_icon.svg">' 
                    }
                }
            });
            $(".se-pre-con").hide();
        }
    </script>
</body>
</html>
<?php
}
mysqli_close($link);
?>