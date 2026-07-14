<?php
    include "config.php";
    include "$api_path/config/core.php";
    if($cookie_admin_name ==""){
        header("Location:login.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerSoap Setting</title>
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
    <link rel="stylesheet" href="css/report.css<?php echo $js_cache_string; ?>">
<style>
.rep-filter-set {
    display: flex;
    width: 98%;
    margin: 30px auto;
    flex-direction: column;
    align-items: flex-start;

}
.filter-left {
    width: 25%;
    display: flex;
    justify-content: space-evenly;
}
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

</style>


</head>
<body>
    <div class="se-pre-con" style="display: block;"></div>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <!-- sidebar -->
    <input type="checkbox" id="sidebar-toggle">
    <div class="sidebar" id="sidebar14"></div>
    <!-- main-contents -->
    <main class="main-contents">
        <section class="bg-white brad-4 full-height" id="employee" >
            <div class="header_container">
                <div class="header-section">
                    <div>
                        <h1 class="header_main">Setup</h1>
                    </div>
                    <div class="underline-dev"></div>
                </div>
            </div>
            <div class="rep-filter-set">
                <div class="filter-left">
                    <h2>AOG</h2>
                    <label class="switch">
                      <input type="checkbox" id="aog_Icheck" name="aog_check">
                      <span class="slider"></span>
                    </label>
                </div>
                <div class="filter-left">
                    <h2>MFS</h2>
                    <label class="switch">
                      <input type="checkbox"  id="mfs_Icheck" name="mfs_check">
                      <span class="slider"></span>
                    </label>
                </div>
            </div>
        </section>
    </main>
  
<script>
        var gl_admin_name = "<?php echo $cookie_admin_name; ?>";
    </script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!--    datepicker-->
    
    <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
    <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>  
    
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" ></script> -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
    <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
        var controlStatus;
         $(document).ready(function () {
            $(".se-pre-con").show();
            var datas = {
            dashboard_code: verfication_code,
            type: "get_Control"
        };
        var json_data = JSON.stringify(datas);
             
            $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/controlMFS_AOG.php",
                data: json_data
                }).done(function(data) {
                    console.log(data);
                    controlStatus = data.data
                   for(var key in controlStatus){
                       if(controlStatus[key].control_name == "mfs" && controlStatus[key].active_status == "1"){
                          $('#mfs_Icheck').prop('checked',true);
                        }
                       if(controlStatus[key].control_name == "aog" && controlStatus[key].active_status == "1"){
                           $('#aog_Icheck').prop('checked',true);
                       }
                   }
                });
            $(".se-pre-con").hide();
        });
    
        $('input[name="aog_check"]').click(function(){
             $(".se-pre-con").show();
            if($('input[name="aog_check"]').is(':checked')) {
               var active_status = 1;
            } else {
                var active_status = 2;
            }
             var datas = {
            dashboard_code: verfication_code,
            token : controlStatus[1].control_token,     
            status: active_status,   
            type: "checkedStatus"
            };
            //console.log(datas);
            var json_data = JSON.stringify(datas);
                  $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/controlMFS_AOG.php",
                data: json_data
                }).done(function(data) {
                   if(data.code == 201){
                     swal('Updated AOG Status');  
                   }
                });
            $(".se-pre-con").hide();
        });
        
        $('input[name="mfs_check"]').click(function(){
             $(".se-pre-con").show();
            if($('input[name="mfs_check"]').is(':checked')) {
               var active_status = 1;
            } else {
                var active_status = 2;
            }
             var datas = {
            dashboard_code: verfication_code,
            status: active_status,
            token : controlStatus[0].control_token,     
            type: "checkedStatus"
            };
            var json_data = JSON.stringify(datas);
                  $.ajax({
                type: "POST",
                dataType: "json",
                url : api_path+"/admin/controlMFS_AOG.php",
                data: json_data
                }).done(function(data) {
                     if(data.code == 201){
                     swal('Updated MFS Status');  
                   }
                });
            $(".se-pre-con").hide();
        });
    </script>
</body>
</html>
<?php
}
?>