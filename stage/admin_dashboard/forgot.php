
<!DOCTYPE html>
    <html lang="en">
    <head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Powersoaps | Forgot </title>
    <link rel="shortcut icon" href="assets/favi.png">
    
    <!-- bootstrap css  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- css files -->
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/common.css<?php echo $js_cache_string; ?>">
    <link rel="stylesheet" href="css/fonts.css<?php echo $js_cache_string; ?>" />
    <link rel="stylesheet" href="css/forgot.css<?php echo $js_cache_string; ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">     
          
</head>
<style>
 
</style>

<div class="container">
    <div class="login-container">
    <div id="output"></div>
        
   <!-- email section-->
   <div class="avatar" style="display: block;" id="email_post">
            <img class="form-logo" src="assets/logo.png" alt="logo">
            <h4 class="form-header">FORGOT PASSWORD?</h4>
            <p class="sub-header">Please enter your registered email address and we will send a OTP to reset your password</p>
            <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
            <fieldset>
            <div class="form-group">
            <input class="form__input email errem" type="text" placeholder=" " id="email1" required autofocus/>
            <label for="" class="form__label">Your Email Address</label>
            <p class="text_para" id="emailErr" style="color:red;"></p>
            </div>
            <button type="button" class="primary-btn adminLoginButton"  id="save" onclick="email_send()">SUBMIT</button>
            </fieldset>
            </form>
        </div>
        

   <!--OTP Section-->
    <div class="avatar" style="display: none;" id="enter_otp">
         <img class="form-logo" src="assets/logo.png" alt="merchify-logo">
        <h4 class="form-header">Enter Code</h4>
        <p class="sub-header">Enter the verfication code. We just sent on your registered email address.</p>
        <!-- <p>Change email address? <span><a href="#" style="color: #6276E3;">CHANGE EMAIL</a></span></p> -->
        <form role="form" action="" method="post" name="loginform">
        <fieldset>
            <div class="otp-input">
                <input
                    id = "#codeBox1"
                    class="otplayout codeife"
                    type="text"
                    maxlength="1"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                />
                <input
                    id = "#codeBox2"
                    class="otplayout codeife"
                    type="text"
                    maxlength="1"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                />
                <input
                    id = "#codeBox3"
                    class="otplayout codeife"
                    type="text"
                    maxlength="1"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                />
                <input
                    id = "#codeBox4"
                    class="otplayout codeife"
                    type="text"
                    maxlength="1"
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');"
                />
            </div>
        </fieldset>
        </form>
        
        <!-- <p>Didn't recived a code? <span><img class="clockset" src="images/clock.png" alt="clock"><a href="#" style="color: #6276E3;">29:00</a></span></p> -->
        
        <button type="button" id="verify" class="primary-btn adminLoginButton" onclick="verify()">Verify</button>
    </div>
        
    
   <!--change password-->
   <div class="avatar" style="display: none;" id="enter_password">
           <img class="form-logo" src="assets/logo.png" alt="merchify-logo">
            <h4 class="form-header">New Password!</h4>
            <p class="sub-header">Please enter the password</p>
            <form role="form" action="" method="post" name="loginform">
                <fieldset>
                    <div class="form-group">
                    <input class="input-value lock" type="password" placeholder="Enter the Password" id="pwd"/>
                    <i class="fas fa-eye-slash" id="eye"></i>
                    </div>
                    <div class="form-group">
                    <input class="input-value lock" type="password" placeholder="Re-Type the Password" id="pwd1"/>
                    <i class="fas fa-eye-slash" id="eye1"></i>
                    </div>
                    <button type="button" id="changepass" class="primary-btn adminLoginButton" onclick="changepss()">Submit</button>
                </fieldset>
            </form>
        </div>
           
        
   <!--success msg-->
  <div class="avatar" style="display: none;" id="success_password">
            <img class="form-logo" src="assets/logo.png" alt="merchify-logo">
            <h4 class="form-header">New Password!</h4>
            <p class="sub-header">Your password changed successfuly!</p>
            <form role="form" action="" method="post" name="loginform">
                <fieldset>
                 <button type="button" class="primary-btn adminLoginButton" onclick="window.location.href='login.php'">Login</button>
                </fieldset>
            </form>
        </div>
   
    </div>
    </div>
        
    
    <script src="//code.jquery.com/jquery-3.6.0.js"></script>
    
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="js/sweetalert.min.js<?php echo $js_cache_string; ?>"></script>
    
    <script type="text/javascript" src="new_js/DataTables/datatables.min.js"></script>
    <script>

    var container = document.getElementsByClassName("otp-input")[0];
    
    container.onkeyup = function(e) {
        var target = e.srcElement || e.target;
        var maxLength = parseInt(target.attributes["maxlength"].value, 10);
        var myLength = target.value.length;
        if (myLength >= maxLength) {
            var next = target;
            while (next = next.nextElementSibling) {
                if (next == null)
                    break;
                if (next.tagName.toLowerCase() === "input") {
                    next.focus();
                    break;
                }
            }
        }
        else if (myLength === 0) {
            var previous = target;
            while (previous = previous.previousElementSibling) {
                if (previous == null)
                    break;
                if (previous.tagName.toLowerCase() === "input") {
                    previous.focus();
                    break;
                }
            }
        }
    }

    function back(){
            window.location.href="login.php";
        }
    
    function email_send() {
        
        $('#save').prop('disabled', true);
        var pass=0;
        var email = document.getElementById("email1").value.trim();
        mailformat1 = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (email == '')
        {
            document.getElementById("emailErr").innerHTML = "* Enter Your Mail ID";
            pass = 0;
            $('#save').prop('disabled', false);
        } 
        else if (email.match(mailformat1)) 
        {
            document.getElementById("emailErr").innerHTML = "";
            pass++;
        } 
        else 
        {
            document.getElementById("emailErr").innerHTML = "* Enter Valid Mail-ID";
            $('#save').prop('disabled', false);
        }
        if(pass==1)
        {
            
            var datas = {'email':email};
            $.ajax({
                type: "POST",
                url: "php/forgot_password_new.php",
                data: datas
            }).done(function(data) {
                if(data=='success')
                {
                    
                    $('#save').prop('disabled', false);
                    $(".avatar").hide();
                    $("#enter_otp").show();
                }
                else
                {
                    swal("","Invalid Email ID");
                    $('#save').prop('disabled', false);
                }
            });
        }
    }
    
    function verify() {
        
        $("#verify").prop('disabled', true);
        $(".codeife").css("border", "");
        var code1=$(".otp-input input:nth-child(1)").val();
        var code2=$(".otp-input input:nth-child(2)").val();
        var code3=$(".otp-input input:nth-child(3)").val();
        var code4=$(".otp-input input:nth-child(4)").val();

        if(code1=='')
        {
            $("#codeBox1").css("border", "1px solid red");
            $("#verify").prop('disabled', false);
        }
        else if(code2=='')
        {
            $("#codeBox2").css("border", "1px solid red");
            $("#verify").prop('disabled', false);
        }
        else if(code3=='')
        {
            $("#codeBox3").css("border", "1px solid red"); 
            $("#verify").prop('disabled', false);           
        }
        else if(code4=='')
        {
            $("#codeBox4").css("border", "1px solid red");
            $("#verify").prop('disabled', false);            
        }
        else
        {
            var totalcode=code1+code2+code3+code4;
            var email = document.getElementById("email1").value.trim();

            console.log(totalcode);

            var datas={"email" : email,"opt" : totalcode}

            $.ajax({
                type : "POST",
                data : datas,
                url  : "php/verify_otp_new.php"
            }).done(function(data){
                if(data=="success")
                {
                    $(".avatar").hide();
                    $("#enter_password").show();
                    $("#verify").prop('disabled', false);
                }
                else if(data=="OTP Expired")
                {
                    swal(data);
                    $("#verify").prop('disabled', false);
                }
                else if(data=="In-valid OTP")
                {
                    swal(data);
                    $("#verify").prop('disabled', false);
                }
                else if(data=="notexist")
                {
                    swal("In-valid OTP");
                    $("#verify").prop('disabled', false);
                }
                else
                {
                    swal("Try again later!");
                    $("#verify").prop('disabled', false);
                }
            })
        }
    }

    function changepss() {
        
        $("#changepass").prop('disabled', true);
        var newpass=$("#pwd").val();
        var retypass=$("#pwd1").val();
        $(".lock").css("border", "");
        
        var pattern = new RegExp(
          "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[-+_!@#$%^&*.,?]).+$"
        );

        if(newpass=='')
        {
            $("#pwd").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);         
        }
        else if(newpass.length<6)
        {
            $("#pwd").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
            swal("","Password must contains atleast 6 digit character");
        }
        else if(pattern.test(newpass)==false)
        {
            $("#pwd").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
            swal("","Password must contains atleast one uppercase, lowercase, special character and number");
        }
        else if(retypass=='')
        {
            $("#pwd1").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
        }
        else if(retypass.length<6)
        {
            $("#pwd1").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
            swal("","Confirm password must contains atleast 6 digit character");
        }
        else if(pattern.test(retypass)==false)
        {
            $("#pwd1").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
            swal("","Confirm password must contains atleast one uppercase, lowercase, special character and number");
        }
        else if(newpass!=retypass)
        {
            $("#pwd").css("border", "1px solid red");
            $("#pwd1").css("border", "1px solid red");
            $("#changepass").prop('disabled', false);
        }
        else
        {
            var email = document.getElementById("email1").value.trim();
            var datas={"email" : email,"password" : retypass}

            $.ajax({
                type : "POST",
                data : datas,
                url  : "php/changepassword_new.php"
            }).done(function(data){
                if(data=="success")
                {
                    $(".avatar").hide();
                    $("#success_password").show();
                    $("#changepass").prop('disabled', false);
                }
                else
                {
                    swal("Try again later!");
                    $("#changepass").prop('disabled', false);
                }
            })
        }
    }
    $(function(){
    $('#eye').click(function(){
        if($(this).hasClass('fa-eye-slash')){
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('#pwd').attr('type','text');
        }else{ 
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');  
            $('#pwd').attr('type','password');
        }
    });
    $('#eye1').click(function(){
        if($(this).hasClass('fa-eye-slash')){
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
            $('#pwd1').attr('type','text');
        }else{
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');  
            $('#pwd1').attr('type','password');
        }
    });
    });
    </script> 
</html>