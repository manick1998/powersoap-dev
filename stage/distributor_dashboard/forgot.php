<?php
include "config.php";
include "$api_path/config/core_distributor.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="icon" href="img/icons/favicon.svg" />
    <title>Forgot Password - PowerSoaps</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>" />
    <link rel="stylesheet" href="css/forgot.css<?php echo $js_cache_string; ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>

<body>
<div class="container">
    <div class="login-container">
        <div id="output"></div>

        <!-- Email Section -->
        <div class="avatar" style="display: block;" id="email_post">
            <img class="form-logo" src="assets/logo.png" alt="logo">
            <h4 class="form-header">FORGOT PASSWORD?</h4>
            <p class="sub-header">Please enter your registered email address. We will send an OTP to reset your password.</p>
            
            <form role="form" method="post" name="loginform">
                <div class="form-group">
                    <input class="form__input email errem" type="email" placeholder=" " id="email1" required autofocus>
                    <label for="" class="form__label">Your Email Address</label>
                    <p class="text_para" id="emailErr" style="color:red;"></p>
                </div>
                <button type="button" class="primary-btn adminLoginButton" id="save" onclick="email_send()">SEND OTP</button>
            </form>
        </div>

        <!-- OTP Section (6 digits) -->
        <div class="avatar" style="display: none;" id="enter_otp">
            <img class="form-logo" src="assets/logo.png" alt="logo">
            <h4 class="form-header">Enter OTP</h4>
            <p class="sub-header">Enter the 6-digit verification code sent to your email.</p>
            
            <div class="otp-input">
                <input id="codeBox1" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <input id="codeBox2" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <input id="codeBox3" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <input id="codeBox4" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <input id="codeBox5" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                <input id="codeBox6" class="otplayout codeife" type="text" maxlength="1" oninput="this.value=this.value.replace(/[^0-9]/g,'');">
            </div>
            
            <button type="button" id="verify" class="primary-btn adminLoginButton" onclick="verify()">VERIFY OTP</button>
            <p style="margin-top:15px;">
                <a href="#" onclick="resendOTP()" style="color:#00B9F5;">Didn't receive code? Resend OTP</a>
            </p>
        </div>

        <!-- New Password Section -->
        <div class="avatar" style="display: none;" id="enter_password">
            <img class="form-logo" src="assets/logo.png" alt="logo">
            <h4 class="form-header">Create New Password</h4>
            <p class="sub-header">Please enter your new password</p>
            
            <form>
                <div class="form-group">
                    <input class="input-value lock" type="password" placeholder="New Password" id="pwd">
                    <i class="fas fa-eye-slash" id="eye"></i>
                </div>
                <div class="form-group">
                    <input class="input-value lock" type="password" placeholder="Confirm New Password" id="pwd1">
                    <i class="fas fa-eye-slash" id="eye1"></i>
                </div>
                <button type="button" id="changepass" class="primary-btn adminLoginButton" onclick="changepss()">UPDATE PASSWORD</button>
            </form>
        </div>

        <!-- Success Message -->
        <div class="avatar" style="display: none;" id="success_password">
            <img class="form-logo" src="assets/logo.png" alt="logo">
            <h4 class="form-header">Password Changed!</h4>
            <p class="sub-header">Your password has been updated successfully.</p>
            <button type="button" class="primary-btn adminLoginButton" onclick="window.location.href='login.php'">LOGIN NOW</button>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
var api_path = "<?php echo $api_path; ?>";

// OTP Input Auto Focus
var container = document.getElementsByClassName("otp-input")[0];
container.onkeyup = function(e) {
    var target = e.srcElement || e.target;
    var maxLength = parseInt(target.attributes["maxlength"].value, 10);
    var myLength = target.value.length;
    
    if (myLength >= maxLength) {
        var next = target;
        while (next = next.nextElementSibling) {
            if (next == null) break;
            if (next.tagName.toLowerCase() === "input") {
                next.focus();
                break;
            }
        }
    } else if (myLength === 0) {
        var previous = target;
        while (previous = previous.previousElementSibling) {
            if (previous == null) break;
            if (previous.tagName.toLowerCase() === "input") {
                previous.focus();
                break;
            }
        }
    }
};

// Send OTP
function email_send() {
    $('#save').prop('disabled', true);
    var email = document.getElementById("email1").value.trim();
    var mailformat = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    if (email === '') {
        document.getElementById("emailErr").innerHTML = "* Enter your email address";
        $('#save').prop('disabled', false);
    } else if (!email.match(mailformat)) {
        document.getElementById("emailErr").innerHTML = "* Enter a valid email address";
        $('#save').prop('disabled', false);
    } else {
        document.getElementById("emailErr").innerHTML = "";
        
        var datas = {'email': email, 'type': 'email_id'};
        var json_data = JSON.stringify(datas);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: api_path + "/distributor/forgot_password.php",
            data: json_data,
            success: function(data) {
                $('#save').prop('disabled', false);
                if (data.status_code == 200) {
                    $(".avatar").hide();
                    $("#enter_otp").show();
                    swal("Success", "OTP has been sent to your email", "success");
                } else {
                    swal("Error", data.message, "error");
                }
            },
            error: function() {
                $('#save').prop('disabled', false);
                swal("Error", "Something went wrong. Please try again.", "error");
            }
        });
    }
}

// Verify OTP (6 digits)
function verify() {
    $("#verify").prop('disabled', true);
    $(".codeife").css("border", "");

    var code1 = $("#codeBox1").val();
    var code2 = $("#codeBox2").val();
    var code3 = $("#codeBox3").val();
    var code4 = $("#codeBox4").val();
    var code5 = $("#codeBox5").val();
    var code6 = $("#codeBox6").val();

    if (!code1 || !code2 || !code3 || !code4 || !code5 || !code6) {
        $(".codeife").css("border", "1px solid red");
        $("#verify").prop('disabled', false);
        swal("Error", "Please enter all 6 digits", "error");
        return;
    }

    var totalcode = code1 + code2 + code3 + code4 + code5 + code6;
    var email = document.getElementById("email1").value.trim();

    var datas1 = {
        "email": email,
        "otp": totalcode,
        "type": "otp_verify"
    };

    var json_data = JSON.stringify(datas1);

    $.ajax({
        type: "POST",
        dataType: "json",
        data: json_data,
        url: api_path + "/distributor/forgot_password.php",
        success: function(data) {
            $("#verify").prop('disabled', false);
            if (data.status_code == 200) {
                $(".avatar").hide();
                $("#enter_password").show();
            } else {
                swal("Error", data.message, "error");
            }
        },
        error: function() {
            $("#verify").prop('disabled', false);
            swal("Error", "Something went wrong", "error");
        }
    });
}

// Resend OTP
function resendOTP() {
    var email = document.getElementById("email1").value.trim();
    var datas = {'email': email, 'type': 'email_id'};
    var json_data = JSON.stringify(datas);

    $.ajax({
        type: "POST",
        dataType: "json",
        url: api_path + "/distributor/forgot_password.php",
        data: json_data,
        success: function(data) {
            if (data.status_code == 200) {
                swal("Success", "OTP resent successfully", "success");
            } else {
                swal("Error", data.message, "error");
            }
        }
    });
}

// Change Password
function changepss() {
    $("#changepass").prop('disabled', true);
    
    var newpass = $("#pwd").val();
    var retypass = $("#pwd1").val();
    $(".lock").css("border", "");

    var pattern = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[-+_!@#$%^&*.,?]).+$");

    if (newpass === '') {
        $("#pwd").css("border", "1px solid red");
        $("#changepass").prop('disabled', false);
    } else if (newpass.length < 6) {
        $("#pwd").css("border", "1px solid red");
        $("#changepass").prop('disabled', false);
        swal("Error", "Password must be at least 6 characters", "error");
    } else if (!pattern.test(newpass)) {
        $("#pwd").css("border", "1px solid red");
        $("#changepass").prop('disabled', false);
        swal("Error", "Password must contain uppercase, lowercase, number and special character", "error");
    } else if (retypass === '') {
        $("#pwd1").css("border", "1px solid red");
        $("#changepass").prop('disabled', false);
    } else if (newpass !== retypass) {
        $("#pwd").css("border", "1px solid red");
        $("#pwd1").css("border", "1px solid red");
        $("#changepass").prop('disabled', false);
        swal("Error", "Passwords do not match", "error");
    } else {
        var email = document.getElementById("email1").value.trim();
        var datas2 = {
            "email": email,
            "password": retypass,
            "type": "change_password"
        };
        var json_data2 = JSON.stringify(datas2);

        $.ajax({
            type: "POST",
            dataType: "json",
            data: json_data2,
            url: api_path + "/distributor/forgot_password.php",
            success: function(data) {
                $("#changepass").prop('disabled', false);
                if (data.status_code == 200) {
                    $(".avatar").hide();
                    $("#success_password").show();
                } else {
                    swal("Error", data.message, "error");
                }
            }
        });
    }
}

// Show/Hide Password
$(function() {
    $('#eye').click(function() {
        if ($(this).hasClass('fa-eye-slash')) {
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            $('#pwd').attr('type', 'text');
        } else {
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            $('#pwd').attr('type', 'password');
        }
    });

    $('#eye1').click(function() {
        if ($(this).hasClass('fa-eye-slash')) {
            $(this).removeClass('fa-eye-slash').addClass('fa-eye');
            $('#pwd1').attr('type', 'text');
        } else {
            $(this).removeClass('fa-eye').addClass('fa-eye-slash');
            $('#pwd1').attr('type', 'password');
        }
    });
});
</script>
</body>
</html>