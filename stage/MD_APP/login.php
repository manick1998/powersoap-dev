<?php
include "config.php";
include "$api_path/config/core.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <!-- Primary Meta Tags -->
    <title>Login</title>
    <!-- ===== css ===== -->
    <link rel="shortcut icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css" />
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/login-mediaquery.css">
    <title>Admin Login</title>
    <style>
        .mail_img {
            width: 24px;
            position: relative;
            top: 15px;
            left: 10px;
            z-index: 99;
        }

        .pass_img {
            width: 20px;
            position: relative;
            top: 15px;
            left: 10px;
            z-index: 99;
        }

        @media screen and (max-width:1175px) {
            .login-form {
                background-size: cover;
                
            }
        }
    </style>
</head>

<body>
    <div class="login-form">
        <form action="" class="form">
            <div class="login-logo">
                <img class="logo_big" src="assets/svg/logo@2x.png" alt="logo">
            </div>
            <h2 class="form__title">MD Dashboard Login</h2>
            <p class="sub__title">Please enter your credentials to login</p>
            <div class="form__detail">
                <input type="text" id="user_email" class="form__input" placeholder=" Enter Email Address">
                <img alt="mail" class="mail_img" src="assets/mail_icon.png">
                <!--            <label for="" class="form__label">Enter Email Address</label>-->
            </div>
            <div class="form__detail">
                <input type="password" id="user_password" class="form__input" placeholder="Enter Password " maxlength="20">
                <img alt="mail" class="pass_img" src="assets/password_icon.png">
                <!--            <label for="" class="form__label">Enter Password</label>-->
              <!-- <a href="forgot.php" class="forgot">Forgot Password?</a> -->
                <div class="eye_icon">
                    <p><i class=" user_password fa fa-eye-slash toggle-password" aria-hidden="true"></i></p>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="form__button" id="login_button" onclick="login()">Login</button>
            </div>
        </form>
    </div>
    <script src="js/jquery.min.js"></script>
    
    <!-- <script src="https://code.jquery.com/jquery-latest.min.js"></script> -->
    <script src="js/jquery-latest.min.js"></script>
    
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
     <script src="js/sweetalert.min.js"></script>
    <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
   console.log(api_path);
        $(".toggle-password").click(function() {
            var id = this.classList[0];
            $(this).toggleClass("fa-eye-slash fa-eye");
            if ($('#' + id).attr("type") == "password") {
                $('#' + id).attr("type", "text");
            } else {
                $('#' + id).attr("type", "password");
            }
        });

        function login() {
            $('#login_button').prop('disabled', true);
            var user_email = $("#user_email").val();
            var user_password = $("#user_password").val();
            if (user_email != "" && user_password != "") {
                var datas = {
                    'user_email': user_email,
                    'user_password': user_password,
                    'dashboard_code': verfication_code
                }
                var json_data = JSON.stringify(datas);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: api_path + "/login.php",
                    data: json_data,
                }).done(function(data) {
                    $('#login_button').prop('disabled', false);
                    if (data.code == 503) {
                        swal(data.message);
                    } else if (data.code == 201) {
                        $("#user_password").val('');
                        window.location.href = "index.php";
                    }
                });
            } else {
                $('#login_button').prop('disabled', false);
                if (user_email == "" && user_password == "") {
                    swal("Please enter Employee id/Email address and Password!");
                } else if (user_email == "") {
                    swal("Please enter Employee id/Email address!");
                } else if (user_password == "") {
                    swal("Please enter the Password!!");
                }
            }
        }
        $(document).ready(function(){
            var input = document.getElementById("user_password");
            input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("login_button").click();
            }
            });
        })
    </script>
</body>

</html>