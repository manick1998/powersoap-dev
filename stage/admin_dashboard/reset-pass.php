<?php
session_start();
if($_SESSION['usr_token']=='')
{
    header('Location: login.php');
}
else
{
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
        <title>Merchify | Reset Password</title>
    <link rel="shortcut icon" href="images/favi.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/general.css<?php echo $js_cache_string; ?>" />
    <link rel="stylesheet" href="css/login.css<?php echo $js_cache_string; ?>" />
          
       <style>
        .login-form .form__detail {
        position: relative;
        margin-bottom: 30px;
        }
         .form__input {
        position: relative;
        width: 100%;
        height: 100%;
        border: 1px solid #d7d9dd;
        color: #000000;
        border-radius: 5px;
        outline: none;
        padding: 15px;
        background: none;
        font-size: 16px;
        z-index: 1;
        } 
       .login-form .glyphicon {
        cursor: pointer;
        pointer-events: all;
        position: absolute;
        top: 8px;
        right: 5px;
        }  
        .eye-box {
        position: absolute;
        top: 18px;
        right: 14px;
        z-index: 999;
        cursor: pointer;
        }
        .error {
            text-align: left;
            color: red;
            padding-top: 10px;
        }
          </style>

<script src="//code.jquery.com/jquery-3.6.0.js"></script>
            <!-- JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script> -->
<script src="js/popper.min.js<?php echo $js_cache_string; ?>"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js"></script> -->
    <script src="js/bootstrap.min.js<?php echo $js_cache_string; ?>"></script>
    
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
</head>

<body>
    <div class="login">
        <form class="login-form">
            <div class="reset-logo">
                <img class="form-logo" src="img/logo.png" alt="merchify-logo">
            </div>
            <p class="sub-header">Please enter your new password and update</p>
            <h1 class="form-header">Reset Password</h1>
            <div class="form__detail input-box">
                <input type="password" id="password1" class="form__input password" placeholder="Old Password">
               <div class="eye-box">
                <img class="eye-close" src="img/icons/eye disable.svg" alt="">
                <img class="eye-open hidden" src="img/icons/eye visible.svg" alt="">
                </div>
            </div>
            <div class="form__detail input-box">
                <input type="password" id="password2" class="form__input password" placeholder="New Password">
                <div class="eye-box">
                <img class="eye-close" src="img/icons/eye disable.svg" alt="">
                <img class="eye-open hidden" src="img/icons/eye visible.svg" alt="">
                </div>
            </div>
            <div class="form__detail input-box">
                <input type="password" id="password3" class="form__input password" placeholder="Confirm New Password">
                <div class="eye-box">
                <img class="eye-close" src="img/icons/eye disable.svg" alt="">
                <img class="eye-open hidden" src="img/icons/eye visible.svg" alt="">
                </div>
            </div>
            <button class="primary-btn adminLoginButton">Update Password</button>
        </form>
    </div>
    <script>
    function myFunction(data) {
        var x = document.getElementById("password"+data);
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    
    $(".adminLoginButton").click( function(event) {
        event.preventDefault();
        update_pass();
    } )

    function update_pass()
    {
        var oldpass = $("#password1").val().trim();
        var newpass = $("#password2").val().trim();
        var reepass = $("#password3").val().trim();
        
        var pattern = new RegExp(
          "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[-+_!@#$%^&*.,?]).+$"
        );

        if( oldpass != "" && newpass != "" &&  reepass != "" && newpass == reepass ) {
            var datas = {'oldpassword' : oldpass,'newpassword' : newpass,'reepassword' : reepass}
            $.ajax({
                type : "POST",
                data : datas,
                url  : "php/reset_password_new.php"
            }).done(function(data){
                $(".error").remove();
                if(data=="success")
                {
                    swal({
                        title: "Success",
                        text: "Password Reset Successful",
                        icon: 'success'
                    }).then(function() {
                        window.location = "php/logout.php"
                    });
                }
                else
                {
                    $(".error").remove();
                    swal("",data);
                }
            })
        } else {
            $(".error").remove();
            if(!oldpass ){
                $("#password1").parent().append("<div class='error'>* Old Password is Required</div>");
            }

            if(!newpass ){
                $("#password2").parent().append("<div class='error'>* New Password is Required</div>");
            } else if(pattern.test(newpass)==false) {
                $("#password2").parent().append("<div class='error'>* Password must contains atleast one uppercase, lowercase, special character and number</div>");
            } else if( newpass.length<6 ) {
                $("#password2").parent().append("<div class='error'>* Password must contains atleast 6 digit character</div>");
            }

            if(!reepass ){
                $("#password3").parent().append("<div class='error'>* Confirm Password is Required</div>");
            } else if(pattern.test(newpass)==false) {
                $("#password3").parent().append("<div class='error'>* Password must contains atleast one uppercase, lowercase, special character and number</div>");
            } else if( newpass.length<6 ) {
                $("#password3").parent().append("<div class='error'>* Password must contains atleast 6 digit character</div>");
            } else if(reepass != newpass && reepass && newpass ){
                $("#password3").parent().append("<div class='error'>* New Password and Confirm password mismatched!</div>");
            }
        }
    }

    
    $(document).ready(function() {
        $('.glyphicon').on('click', function() {
            $(this).toggleClass('glyphicon-eye-open').toggleClass('glyphicon-eye-close');
        });
        $('.password').keypress(function(e) {
            if (e.keyCode == 13)
                $('#').click();
        });
        $('.errem').keypress(function(e) {
            if (e.keyCode == 13)
                $('#').click();
        });
    });
        
        const eyeOpen = document.querySelectorAll(".eye-open");
          const eyeClose = document.querySelectorAll(".eye-close");
          const eyeBox = document.querySelectorAll(".eye-box");
          const inputPassword = document.querySelectorAll(".password");
          const toggleEye = function () {
            for (let p = 0; p < inputPassword.length; p++) {
              eyeBox[p].addEventListener("click", () => {
                if (inputPassword[p].type === "password") {
                  eyeOpen[p].classList.remove("hidden");
                  eyeClose[p].classList.add("hidden");
                  inputPassword[p].type = "text";
                } else {
                  eyeOpen[p].classList.add("hidden");
                  eyeClose[p].classList.remove("hidden");
                  inputPassword[p].type = "password";
                }
              });
            }
          };
          toggleEye(); 
        
        
    </script>

</body>

</html>
<?php
}
?>