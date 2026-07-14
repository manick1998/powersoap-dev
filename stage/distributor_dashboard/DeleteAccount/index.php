<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <!-- Primary Meta Tags -->
    <title>Delete Account</title>
    <!-- ===== css ===== -->
    <link rel="shortcut icon" href="assets/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css" />
    <link rel="stylesheet" href="../css/fonts.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="../css/login-mediaquery.css">
    <style>
        .hidden {
            display: none;
        }

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
                <img class="logo_big" src="assets//logo@2x.png" alt="logo">
            </div>
            <h2 class="form__title">Account Delete</h2>
            <p class="sub__title">Please enter your credentials to delete your account</p>
            <div class="form__detail">
                <input type="text" id="user_email" class="form__input" placeholder="Enter Email Address" autocomplete="off">
                <img alt="mail" class="mail_img" src="assets/mail_icon.png">
            </div>
            <div class="form__detail">
                <input type="password" id="user_password" class="form__input" placeholder="Enter Password" maxlength="20" autocomplete="off">
                <img alt="mail" class="pass_img" src="assets/password_icon.png">
                <!-- <a href="forgot.php" class="forgot">Forgot Password?</a> -->
                <div class="eye_icon">
                    <p><i class=" user_password fa fa-eye-slash toggle-password" aria-hidden="true"></i></p>
                </div>
            </div>
            <div class="form-group">
                <button type="button" class="form__button" id="delete_button" onclick="deleteAccount()">Delete Account</button>
            </div>
        </form>
    </div>
    <script src="../js/jquery.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    <script>
        var api_path = "<?php echo $api_path; ?>";
        
        $(".toggle-password").click(function() {
            var id = this.classList[0];
            $(this).toggleClass("fa-eye-slash fa-eye");
            if ($('#' + id).attr("type") == "password") {
                $('#' + id).attr("type", "text");
            } else {
                $('#' + id).attr("type", "password");
            }
        });
        function deleteAccount() {
            var user_email = $("#user_email").val();
            var user_password = $("#user_password").val();
            if (user_email == "") {
                var val = false;
                $("#user_email").css('border', 'solid 1px rgba(241, 6, 6, 0.7)'); 
            } else {
                var check = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (check.test(user_email)) {
                    var val = true;
                    $("#user_email").css('border', 'solid 1px rgba(197,214,222,.7)');
                } else {
                    var val = false;
                    $("#user_email").css('border', 'solid 1px rgba(241, 6, 6, 0.7)');
                }
            }
            if (user_password == "") {
                var val1 = false;
                $("#user_password").css('border', 'solid 1px rgba(241, 6, 6, 0.7)'); 
            } else {
                var val1 = true;
                $("#user_password").css('border', 'solid 1px rgba(197,214,222,.7)');
            }
            var datas = {
                'user_email': user_email,
                'user_password': user_password
            };
            var json = JSON.stringify(datas);
            if (val == true && val1 == true) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url:   "delete_account.php",
                    data: json
                }).done(function(data) {
                    if (data.status_code == "200") {
                        swal({
                            title: "Success",
                            text: data.message,
                            icon: "success",
                            // buttons: true, 
                        }).then((willReload) => {
                        if (willReload) {
                         window.location.href = '../login';
                         }
        });
                    } else {
                        swal({
                            title: data.title,
                            text: data.message,
                            icon: "error",
                            // buttons: true, 
                        }).then((willReload) => {
                        if (willReload) {
                         window.location.href = 'index';
                         }
        });
                    }
                });
            } else {
                $('#delete_button').prop('disabled', false);
                if (val == false && val1 == false) {
                    swal("Please enter Email address and Password!");
                } else if (val == false) {
                    swal("Please enter Email address!");
                } else if (val1 == false) {
                    swal("Please enter the Password!");
                }
            }
        }
    </script>
</body>

</html>