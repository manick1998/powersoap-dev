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
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Profile</title>
        <link rel="shortcut icon" href="assets/favi.png">
        <!-- bootstrap css  -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <!-- css files -->
        <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/header.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/custom-table.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/employee.css<?php echo $js_cache_string; ?>">
        <link rel="stylesheet" href="css/mediaquery.css<?php echo $js_cache_string; ?>">
        <!-- <link rel="stylesheet" href="css/myprofile.css<?php echo $js_cache_string; ?>"> -->

        <style>
            .brad-4{
                overflow: hidden;
            }
            .attach, .address_field {
                padding: 0 20px;
            }

 </style>
    </head>
    <body>
        <header id="main-dash-header" class="dash-header">
        </header>
        <input type="checkbox" id="sidebar-toggle">
        <div class="sidebar" id="sidebar15"></div>
        <div class="se-pre-con"></div>
        <!-- main-contents -->
        <main class="main-contents">
            <section class="bg-white brad-4 full-height">
                <div class="header_container">
                    <div>
                        <h1 class="header_main" data-i18n="my_account">My Account</h1>
                    </div>
                </div>
                <div class="add_new_top bot_line inventory-body-section">
                    <div class="inventory-body-left">
                        <div class="upload_files">
                        <img class="uploadimgs" id="single_employee_view_image" alt="" src="">
                        </div>
                    </div>
                    <div class="inventory-body-right">
                        <h2 class="name_box" id="single_employee_name"></h2>
                        <div class="part-card">
                            <div class="part">
                                <div class="codelevel">
                                <p><span data-i18n="mobile_number">Mobile Number</span> : <span id="single_employee_number"></span></p>
                                <!-- <p>Gender : <span id="single_employee_gender"></span></p> -->
                                <!-- <p>Department : <span id="single_employee_department"></span></p> -->
                            </div>
                        </div>
                        <div class="part">
                            <div class="codelevel">
                                <!-- <p>Age : <span id="single_employee_age"></span></p> -->
                                <p><span data-i18n="email_address">Email Address</span> : <span id="single_employee_email"></span></p>
                                <!-- <p>Date of Birth : <span id="single_employee_dob"></span></p> -->
                                </div>
                            </div>
                        <div class="part">
                            <div class="codelevel">
                                <p><span data-i18n="joining_date">Joining Date</span> : <span id="single_employee_join_date"></span></p>
                                <!-- <p>Employee Code : <span id="single_employee_code"></span></p> -->
                                <!-- <p>Blood Group : <span id="single_employee_bloodgroup"></span></p> -->
                                </div>
                            </div>
                        <div class="part">
                            <div class="codelevel">
                                <p><span data-i18n="select_language">Select Language</span> : </p>
                                <select id="language_select" class="form-control" style="width: 150px; display: inline-block; margin-left: 10px;" onchange="updateProfileLanguage(this.value)">
                                    <option value="en">English</option>
                                    <option value="ta">Tamil</option>
                                </select>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="address_field">
                    <div class="address-inner-set">
                        <div class="address_note">
                            <h2 data-i18n="address">Address :</h2>
                            <p id="single_employee_address"></p>
                        </div>
                    </div>
                    <div class="address-inner-set">
                        <img class="pancard proff-doc" style="max-width: 100px;" id="single_employee_address_proof" alt="" src="">
                    </div>
                </div>
                <div class="attach">
                    <div class="attach-iiner-set">
                        <h2 data-i18n="other_attachments">Other Attachments :</h2>
                        <div class="attach_img" id="single_other_attachement">
                        </div>
                    </div>
                </div>

            </section>
        </main>
        <script src="js/jquery.min.js<?php echo $js_cache_string; ?>"></script>
        <!--    datepicker-->
        <!-- <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
        <script src="js/jquery-ui.js<?php echo $js_cache_string; ?>"></script>
        <!-- jquery CDN -->
        <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script> -->
        <!-- js file -->
        <script src="js/header.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/sidebar.js<?php echo $js_cache_string; ?>"></script>
        <script src="js/function.js<?php echo $js_cache_string; ?>"></script>
        <script>
            var Distributor_name = "<?php echo $_SESSION["name"]; ?>";
            var region_name = "<?php echo $_SESSION["region_name"]; ?>";
        </script>
        <script>
            var notiCount = "<?php echo $notiCount; ?>";
            const myTimeout = setTimeout(stopLoader, 1000);

            function stopLoader() {
                $(".se-pre-con").hide();
                clearTimeout(myTimeout);
            }
            var verfication_code = "<?php echo $verification_code; ?>";
            var distributor_token = "<?php echo $_SESSION['distributor_token']; ?>";
            var api_path = "<?php echo $api_path; ?>";
        </script>
        <script>
        $(document).ready(function(){
         $(".se-pre-con").show();
        var datas = {
            dashboard_code: verfication_code,
            distributor_token:distributor_token
        };
        var json_data = JSON.stringify(datas);
        $.ajax({
            type: "POST",
            dataType: "json",
            url : api_path+"/distributor/profileDetails.php",
            data: json_data,
        }).done(function(data) {
           var emp_data = data.data;
            $("#single_employee_name").html(emp_data[0].employee_name);
            $("#single_employee_gender").html(emp_data[0].employee_gender);
            $("#single_employee_department").html(emp_data[0].employee_deparment_name);
            $("#single_employee_join_date").html(emp_data[0].employee_join_date);
            $("#single_employee_age").html(emp_data[0].employee_age);
            $("#single_employee_number").html(emp_data[0].employee_mobile_number);
            $("#single_employee_dob").html(emp_data[0].employee_dob);
            $("#single_employee_code").html(emp_data[0].employee_code);
            $("#single_employee_email").html(emp_data[0].employee_email_id);
            $("#single_employee_bloodgroup").html(emp_data[0].employee_blood_group);
            $("#single_employee_address").html(emp_data[0].employee_address);
            $("#single_employee_view_image").attr("src",emp_data[0].profile_image);
            $("#single_employee_address_proof").attr("src",emp_data[0].employee_address_proof);
            
            if(emp_data[0].employee_language) {
                currentLang = emp_data[0].employee_language;
                localStorage.setItem('selectedLang', currentLang);
            }
            $("#language_select").val(currentLang);
            applyTranslations(currentLang);

            var html = "";
            var attachement_data = emp_data[0].employee_attachment;
            for (var key1 in attachement_data) {
                html += '<img src="'+attachement_data[key1].attachment+'" alt="">';
            }

            $("#single_other_attachement").html(html);
             $(".se-pre-con").hide();
        });
    });

    function updateProfileLanguage(lang) {
        changeGlobalLanguage(lang);
    }
            </script>
    </body>

    </html>
<?php
}
?>