<?php
include "config.php";
include "$api_path/config/core_distributor.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <title>Login</title>
    <link rel="shortcut icon" href="assets/favicon.ico?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.css" />
    <link rel="stylesheet" href="css/fonts.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/login-mediaquery.css?v=<?php echo time(); ?>">
    <style>
        .hidden {
            display: none !important;
        }

        .mail_img {
            width: 24px;
            position: absolute;
            top: 12px;
            left: 10px;
            z-index: 99;
        }

        .pass_img {
            width: 18px;
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 99;
        }

        /* Tab Styling */
        .login-tabs {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: #8a99a7;
            font-family: 'SFPRODISPLAY-MEDIUM';
            font-size: 16px;
            padding: 8px 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab-btn.active {
            color: #00B9F5;
        }

        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 0;
            width: 100%;
            height: 3px;
            background: #00B9F5;
            border-radius: 3px;
        }

        @media screen and (max-width:1175px) {
            .login-form {
                background-size: cover;
            }
        }
        .send_otp_btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #00B9F5;
            cursor: pointer;
            font-family: 'SFPRODISPLAY-MEDIUM';
            font-size: 14px;
            z-index: 10;
        }
        .send_otp_btn:disabled {
            color: #ccc;
            cursor: not-allowed;
        }
        .none{
            display: none;
        }
    </style>
</head>

<body>
    <div class="login-form">
        <form action="" class="form">
            <div class="login-logo">
                <img class="logo_big" src="assets//logo@2x.png" alt="logo">
            </div>
            <h2 class="form__title" data-i18n="login_title">Distributor Login</h2>
            
            <div class="login-tabs none">
                <button type="button" class="tab-btn active" id="tab_password" onclick="switchLoginMode('password')">Password Login</button>
                <button type="button" class="tab-btn" id="tab_otp" onclick="switchLoginMode('otp')">OTP Login</button>
            </div>

            <p class="sub__title" id="login_subtitle" data-i18n="sub_title">Please enter your credentials to login</p>
            
            <div class="form__detail">
                <input type="email" id="user_email" class="form__input" placeholder="Enter Email Address" data-i18n-placeholder="email_placeholder" autocomplete="off" oninput="validateForm()">
                <img alt="mail" class="mail_img" src="assets/mail_icon.png">
                <button type="button" id="send_otp_btn" class="send_otp_btn hidden" onclick="sendOTP()" data-i18n="send_otp">Send OTP</button>
            </div>

            <div class="form__detail" id="password_container">
                <input type="password" id="user_password" class="form__input" placeholder="Enter Password" autocomplete="off" oninput="validateForm()">
                <img alt="lock" class="pass_img" src="assets/password_icon.png">
                <span class=" eye_icon" onclick="togglePassword()"><i class="fa fa-eye-slash" id="togglePasswordIcon"></i></span>
            </div>

            <div class="form__detail hidden" id="otp_container">
                <input type="text" id="user_otp" class="form__input" placeholder="Enter 6-digit OTP" data-i18n-placeholder="otp_placeholder" maxlength="6" inputmode="numeric" pattern="[0-9]*" autocomplete="off" oninput="validateForm()">
                <img alt="mail" class="pass_img" src="assets/password_icon.png">
            </div>

            <div id="forgot_pwd_link" style="text-align: right; margin-top: 5px; margin-bottom: 15px; width: 100%;">
                <a href="forgot.php" style="color: #00B9F5; font-size: 14px; text-decoration: none; font-family: 'SFPRODISPLAY-MEDIUM';">Forgot Password?</a>
            </div>

            <div class="form-group">
                <button type="button" class="form__button" id="login_button" disabled onclick="handleLogin()" style="margin-top: 10px;" data-i18n="login_button">Login</button>
            </div>
        </form>
    </div>
    <script src="js/jquery.min.js?v=<?php echo time(); ?>"></script>
    <script src="js/sweetalert.min.js?v=<?php echo time(); ?>"></script>
    <script>
        var api_path = "<?php echo $api_path; ?>";
        var resendTimer;
        var emp_token = "";

        $(document).ready(function() {
            var savedLang = 'en';
            try {
                savedLang = localStorage.getItem('selectedLang') || 'en';
            } catch (e) {
                console.warn('localStorage not accessible:', e);
            }
            currentLang = savedLang;

            $.getJSON('js/translations.json', function(data) {
                translations = data;
                applyTranslations(currentLang);
            });
        });

        function changeLanguage(lang) {
            currentLang = lang;
            try {
                localStorage.setItem('selectedLang', lang);
            } catch (e) {
                console.warn('localStorage not accessible:', e);
            }
            applyTranslations(lang);
        }

        function applyTranslations(lang) {
            $('.lang-btn').removeClass('active');
            $('#lang_' + lang).addClass('active');

            $('[data-i18n]').each(function() {
                var key = $(this).data('i18n');
                if (translations[lang] && translations[lang][key]) {
                    $(this).text(translations[lang][key]);
                }
            });

            $('[data-i18n-placeholder]').each(function() {
                var key = $(this).data('i18n-placeholder');
                if (translations[lang] && translations[lang][key]) {
                    $(this).attr('placeholder', translations[lang][key]);
                }
            });
        }

        function getTranslation(key) {
            return (translations[currentLang] && translations[currentLang][key]) ? translations[currentLang][key] : key;
        }

        var currentMode = 'password'; // default mode

        function switchLoginMode(mode) {
            currentMode = mode;
            $('.tab-btn').removeClass('active');
            if (mode === 'password') {
                $('#tab_password').addClass('active');
                $('#password_container').removeClass('hidden');
                $('#otp_container').addClass('hidden');
                $('#send_otp_btn').addClass('hidden');
                $('#forgot_pwd_link').removeClass('hidden');
                $('#login_subtitle').text("Please enter your email and password to login");
                $("#user_email").css('padding-right', '15px');
            } else {
                $('#tab_otp').addClass('active');
                $('#password_container').addClass('hidden');
                $('#otp_container').removeClass('hidden');
                $('#send_otp_btn').removeClass('hidden');
                $('#forgot_pwd_link').addClass('hidden');
                $('#login_subtitle').text("Please enter your email to receive OTP");
                $("#user_email").css('padding-right', '100px');
            }
            validateForm();
        }

        function togglePassword() {
            var passwordField = $('#user_password');
            var icon = $('#togglePasswordIcon');
            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        }

        function validateForm() {
            var user_email = $("#user_email").val();
            var email_check = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            var is_email_valid = email_check.test(user_email);

            if (currentMode === 'password') {
                var user_password = $("#user_password").val();
                if (is_email_valid && user_password.length >= 4) {
                    $('#login_button').prop('disabled', false);
                } else {
                    $('#login_button').prop('disabled', true);
                }
            } else {
                var user_otp = $("#user_otp").val();
                if (is_email_valid && user_otp.length == 6 && emp_token != "") {
                    $('#login_button').prop('disabled', false);
                } else {
                    $('#login_button').prop('disabled', true);
                }
            }
        }

        function sendOTP() {
            var user_email = $("#user_email").val();
            if (user_email == "") {
                $("#user_email").css('border', 'solid 1px rgba(241, 6, 6, 0.7)');
                return;
            }
            var check = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!check.test(user_email)) {
                $("#user_email").css('border', 'solid 1px rgba(241, 6, 6, 0.7)');
                swal(getTranslation("email_error_message"));
                return;
            }
            
            $("#user_email").css('border', 'solid 1px rgba(197,214,222,.7)');
            $('#send_otp_btn').prop('disabled', true);
            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/login.php",
                data: JSON.stringify({ 'user_email': user_email })
            }).done(function(data) {
                if (data.status_code == "200" || data.status_code == "202") {
                    emp_token = data.emp_token;
                    startResendTimer();
                    validateForm();
                    swal(getTranslation("otp_sent_title"), getTranslation("otp_sent_message"), "success");
                } else {
                    swal(data.title, data.message, "error");
                    $('#send_otp_btn').prop('disabled', false);
                }
            }).fail(function() {
                swal("Error", "Server error. Please try again.", "error");
                $('#send_otp_btn').prop('disabled', false);
            });
        }

        function handleLogin() {
            if (currentMode === 'password') {
                loginWithPassword();
            } else {
                loginWithOTP();
            }
        }

        function loginWithPassword() {
            
            var user_email = $("#user_email").val();
            var user_password = $("#user_password").val();
            console.log("Attempting login for:", user_email);
            if (user_email == "" || user_password == "") {
                swal(getTranslation("oops_title"), "Please enter both Email and Password", "error");
                return;
            }

            $('#login_button').prop('disabled', true);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/verify_password.php",
                contentType: "application/json",
                data: JSON.stringify({
                    'user_email': user_email,
                    'password': user_password
                })
            }).done(function(data) {
                if (data.status_code == "200") {
                    if(data.language && data.language != "") {
                        try {
                            localStorage.setItem('selectedLang', data.language);
                        } catch (e) {
                            console.warn('localStorage not accessible:', e);
                        }
                    }
                    window.location.href = "home.php";
                } else {
                    swal(data.title, data.message, "error");
                    $('#login_button').prop('disabled', false);
                }
            }).fail(function() {
                swal(getTranslation("error_title"), getTranslation("error_message"), "error");
                $('#login_button').prop('disabled', false);
            });
        }

        function loginWithOTP() {
            var user_email = $("#user_email").val();
            var user_otp = $("#user_otp").val();

            if (user_email == "" || user_otp == "" || user_otp.length != 6) {
                swal(getTranslation("oops_title"), getTranslation("empty_fields_message"), "error");
                return;
            }

            $('#login_button').prop('disabled', true);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: api_path + "/distributor/verify_otp.php",
                contentType: "application/json",
                data: JSON.stringify({
                    'emp_token': emp_token,
                    'otp': user_otp
                })
            }).done(function(data) {
                if (data.status_code == "200") {
                    if(data.language && data.language != "") {
                        try {
                            localStorage.setItem('selectedLang', data.language);
                        } catch (e) {
                            console.warn('localStorage not accessible:', e);
                        }
                    }
                    window.location.href = "home.php";
                } else {
                    swal(data.title, data.message, "error");
                    $('#login_button').prop('disabled', false);
                }
            }).fail(function() {
                swal(getTranslation("error_title"), getTranslation("error_message"), "error");
                $('#login_button').prop('disabled', false);
            });
        }

        function startResendTimer() {
            var timeLeft = 60;
            $('#send_otp_btn').prop('disabled', true).text("Resend (" + timeLeft + "s)");
            if (resendTimer) clearInterval(resendTimer);
            resendTimer = setInterval(function() {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(resendTimer);
                    $('#send_otp_btn').prop('disabled', false).text("Resend OTP");
                } else {
                    $('#send_otp_btn').text("Resend (" + timeLeft + "s)");
                }
            }, 1000);
        }
    </script>
</body>

</html>