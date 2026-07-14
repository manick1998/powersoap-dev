<?php
include "config.php";
include "$api_path/config/core_distributor.php";
session_start();
if (!$_SESSION['distributor_token'] || $_SESSION["verification_code"] != $verification_code){   
    header("Location:login.php");
} else {
    $_SESSION["particular_shop_redirect"] = "false";
    $_SESSION["is_redirect_retailer_sub_page"] = '';
    $_SESSION["retailer_token"] = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" href="assets/favi.png">
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/home.css<?php echo $js_cache_string; ?>">
    <style>
        .floatonly {
            padding: 10px;
            width: 100%;
            border: 1px solid #aeaeae;
            border-radius: 5px;
        }
        p.input-field.admin_mobilenumber {
            margin-bottom: 7px;
        }
        .hide-suport {
            display: block !important;
        }
        .lang-btn {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #00B9F5;
            color: #00B9F5;
            padding: 4px 10px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            font-family: 'SFPRODISPLAY-MEDIUM';
            transition: all 0.3s ease;
        }
        .lang-btn.active {
            background: #00B9F5;
            color: #fff;
        }
    </style>

<script>
    var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
    var region_name = "<?php echo $_SESSION["region_name"]; ?>";
    var Distributor_token = "<?php echo $_SESSION['distributor_token'];?>"
    // alert(Distributor_token);
</script>
<script>var notiCount = "<?php echo $notiCount; ?>";</script>
    <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
    <!-- js file -->
    <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
    <!-- jquery CDN -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script> 
    <!-- datatable -->
    <script src="js/datatables.min.js<?php echo $js_cache_string; ?>"></script>
</head>
<body>
    <header id="main-dash-header" class="dash-header">      
    </header>
    <main class="home-main">
        <section>
            <div class="flex-grid">
                
                <a href="order_products" class="flex-box" data-value="order_products">
                    <div class="home-widget-box">
                        <img src="assets/home/inventory_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="inventory_management">Inventory Management</span>
                    </div>
                </a>
                <a href="sales_order" class="flex-box" data-value="sales_order">
                    <div class="home-widget-box">
                        <img src="assets/home/order_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="order_management">Order Management</span>
                    </div>
                </a>
                <a href="employees" class="flex-box" data-value="employees">
                    <div class="home-widget-box">
                        <img src="assets/home/employee.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="employee_management">Employee Management</span>
                    </div>
                </a>
                <a href="retailer" class="flex-box" data-value="retailer">
                    <div class="home-widget-box">
                        <img src="assets/home/retailer_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="retailer_management">Retailer Management</span>
                    </div>
                </a>
                <a href="daily-shedule" class="flex-box" data-value="daily-shedule">
                    <div class="home-widget-box">
                        <img src="assets/home/schedule_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="schedule_management">Schedule Management</span>
                    </div>
                </a>
<!--
                <div class="flex-box" data-value="out_standing">
                    <div class="home-widget-box">
                        <img src="assets/home/outstanding_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span>Outstanding Management</span>
                    </div>
                </div>
-->
                <a href="daily" class="flex-box" data-value="daily">
                    <div class="home-widget-box">
                        <img src="assets/home/daily_summary.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="daily_summary">Daily Summary Management</span>
                    </div>
                </a>
<!-- 
                <div class="flex-box" data-value="offer">
                    <div class="home-widget-box">
                        <img src="assets/home/offer_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span>Offer Management</span>
                    </div>
                </div> -->

                <a href="report_dashboard" class="flex-box" data-value="report_dashboard">
                    <div class="home-widget-box">
                        <img src="assets/home/reoprts_and_analytics.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="reports_analytics">Reports and Analytics</span>
                    </div>
                </a>
<!--
                <div class="flex-box" data-value="gift_slot">
                    <div class="home-widget-box">
                        <img src="assets/home/gift_management.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span>Gift Management</span>
                    </div>
                </div>
-->
                <a href="notification_list" class="flex-box" data-value="notification_list">
                    <div class="home-widget-box">
                        <img src="assets/home/communication.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="communication">Communication</span>
                    </div>
                </a>
<!--
                <div class="flex-box" data-value="setting">
                    <div class="home-widget-box">
                        <img src="assets/home/settings.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span>Settings</span>
                    </div>
                </div>
-->
<!--
                <div class="flex-box" data-value="working">
                    <div class="home-widget-box">
                        <img src="assets/home/user_roles.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span>User Roles and Access</span>
                    </div>
                </div>
-->
                <a href="privacy-policy" class="flex-box" data-value="privacy-policy">
                    <div class="home-widget-box">
                        <img src="assets/home/policy.png" class="home-widget" alt="">
                    </div>
                    <div class="module-box">
                        <span data-i18n="policy">Policy</span>
                    </div>
                </a>
            </div>
        </section>
    </main>
    
     <div class="modal" id="support_pop">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title" data-i18n="support">Support</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body controler__box_set">
                        <div class="">
                            <div class="custom-boxss">
                               <label for="description" data-i18n="description">Description:</label>
                              <textarea id="description" name="description" class="custom-textarea" placeholder="Only 250 Letters" data-i18n-placeholder="desc_placeholder"></textarea>
                            </div>
                            <div class="">
                                <p for="purchase_amount" class="input-field admin_mobilenumber" data-i18n="phone_number">Phone Number</p>
                                <input type="number" id="admin_mobilenumber" class="input-field floatonly" placeholder="Please Enter Phone Number" data-i18n-placeholder="phone_placeholder" maxlength="10" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                            </div>
                        </div>
                        <p style="margin: 0;     margin-top: 9px;" class="Attac" data-i18n="attachment">Attachment</p>
                        <label for="support_image_upload" style="text-align: start;">
                            <div class="custom-file">
                                <input id="support_image_valid" type="hidden" value="">    
                                <input id="support_image_upload" onchange="file_upload_support('support_image','support_view_image_url','assets/upload.png')" type="file" accept="image/x-png, image/gif, image/jpeg, image/jpg" style="display:none;">
                                <h5><span><img id='img' class="fa-upload" src="assets/upload_image_arrow_icon.png"></span> <span data-i18n="upload_image">Upload Image</span></h5>
                            </div>
                            <img class="show_upload_image" style="max-height: 200px;max-width: 400px" id="support_view_image_url"/>
                          <span class="span" data-i18n="image_format">Image format should be in jpg/png</span>
                        </label>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="cancel-btn" data-dismiss="modal" data-i18n="cancel">Cancel</button>
                        <button type="button" id='btn' onclick="add_issue()" class="create-btn" data-i18n="save">Save</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/aws-sdk.min.js<?php echo $js_cache_string; ?>"></script>
    <!---- For S3 bucket upload ---->
    <script src="js/upload.js<?php echo $js_cache_string; ?>"></script>
    <script src="js/needed_jquerys.js<?php echo $js_cache_string; ?>"></script>
    <script>
         var verfication_code = "<?php echo $verification_code; ?>";
         var api_path = "<?php echo $api_path; ?>";
         var sessionLang = "<?php echo $_SESSION['language']; ?>";

         if (sessionLang) {
             currentGlobalLang = sessionLang;
             localStorage.setItem('selectedLang', sessionLang);
         }

         function changeLanguage(lang) {
             changeGlobalLanguage(lang);
         }

         function getTranslation(key) {
             return getGlobalTranslation(key);
         }

        $('.flex-box').on('click',function(){
            
            var url_link = $(this).attr('data-value');
            
            if(url_link == "working"){
                swal(getTranslation("work_in_progress"), "");
            }else{
                window.open(url_link,'_self');
            }
            
        });

               function  add_issue(){
                var text = $("#description").val();
                var val1 = value_check('description', text, 'text_box');
                var mobile_number = $("#admin_mobilenumber").val();
                var val2 = value_check('admin_mobilenumber', mobile_number, 'text_box');
                if(val1 == true && val2==true) {
                    $('#add_sales_button').prop('disabled', true);
                    image_upload_loop(0);
                }else{
                    if(val1 == true && val2==true ){
                        var all_check = true;
                    }else{
                        var all_check = false;
                    }
                    if(all_check==false){
                        swal(getTranslation("enter_details"));
                    }else{
                        swal(getTranslation("upload_profile_image"));
                    }  
                }
            }

 var image_id = ['support_image'];
    function image_upload_loop(key){
       var valid   = $("#"+image_id[key]+"_valid").val();
       var checkkey = key+1;
       if(valid=="true"){
           if(checkkey>image_id.length){
            add_sales_rep_finish();
           }else{
               var fileUpload = document.getElementById(image_id[key]+"_upload");
               var file = fileUpload.files[0];
               s3_file_upload(file, key);
           }
       }else{
           if(valid!=undefined){
               $("#"+image_id[key]+"_valid").val(valid);
               key++;
               image_upload_loop(key);
           }else{
            add_sales_rep_finish();
           }
       }
    }
    function add_sales_rep_finish(){
        var text = $('#description').val();
        var distributor_image= $("#support_image_valid").val();
        var distributor_mobilenumber = $("#admin_mobilenumber").val();
        var data = {
            type: "distributor_issue",
            text:text,
            distributor_image:distributor_image,
            distributor_mobilenumber:distributor_mobilenumber,
            Distributor_name:Distributor_name,
            Distributor_token:Distributor_token,
            //Distributor_departmenttoken : Distributor_token,
        }
        var json_data = JSON.stringify(data);
        console.log(json_data);
        $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/distributor/distributor_support_add.php",
                    data: json_data,
                }).done(function(datas) {
                    if (datas.code == "200") {
                    swal(datas.message);
                        location.reload();
                } else {
                    $('#update_employee_button').prop('disabled', false);
                    swal(datas.message);
                }
                })
    }

    </script>
</body>
</html>
<?php
}
?>