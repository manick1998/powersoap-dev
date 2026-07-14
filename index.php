<?php require_once 'stage/database_credentials.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="" />
    <meta name="description" content="">
    <!-- Primary Meta Tags -->
    <title>Power Soaps - Welcome</title>
    <!-- ===== css ===== -->
    <link rel="shortcut icon" href="stage/assets/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .login-container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        /* Animated background */
        .login-container::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: backgroundMove 20s linear infinite;
        }

        @keyframes backgroundMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Floating shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 6s ease-in-out infinite;
        }

        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 15%;
            animation-delay: 2s;
        }

        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .login-card {
            position: relative;
            width: 90%;
            max-width: 700px;
            padding: 60px 50px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.6s ease-out;
            z-index: 10;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-section img {
            width: 120px;
            height: auto;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
            animation: logoPulse 2s ease-in-out infinite;
        }

        @keyframes logoPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .logo-section h1 {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .logo-section p {
            font-size: 16px;
            color: #718096;
            margin-top: 8px;
            font-weight: 400;
        }

        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .portal-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 35px 25px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%);
            border-radius: 16px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            overflow: hidden;
        }

        .portal-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.4s;
            z-index: 1;
        }

        .portal-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
            border-color: #667eea;
        }

        .portal-card:hover::before {
            opacity: 1;
        }

        .portal-card > * {
            position: relative;
            z-index: 2;
        }

        .portal-icon {
            width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 50%;
            margin-bottom: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.4s;
        }

        .portal-card:hover .portal-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .portal-icon img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            transition: all 0.4s;
        }

        .portal-card:hover .portal-icon img {
            filter: brightness(0) invert(1);
        }

        .portal-info {
            text-align: center;
        }

        .portal-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #667eea;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
            transition: all 0.4s;
        }

        .portal-card:hover .portal-label {
            color: rgba(255, 255, 255, 0.9);
        }

        .portal-title {
            font-size: 22px;
            font-weight: 600;
            color: #2d3748;
            margin: 0;
            transition: all 0.4s;
        }

        .portal-card:hover .portal-title {
            color: white;
        }

        .portal-arrow {
            margin-top: 15px;
            font-size: 24px;
            color: #667eea;
            transition: all 0.4s;
        }

        .portal-card:hover .portal-arrow {
            color: white;
            transform: translateX(5px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-card {
                padding: 40px 30px;
            }

            .logo-section h1 {
                font-size: 26px;
            }

            .portal-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .portal-card {
                padding: 30px 20px;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }

            .logo-section img {
                width: 100px;
            }

            .logo-section h1 {
                font-size: 22px;
            }

            .portal-icon {
                width: 70px;
                height: 70px;
            }

            .portal-icon img {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <!-- Animated background shapes -->
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>

        <div class="login-card">
            <div class="logo-section">
                <img src="stage/assets/svg/logo@2x.png" alt="Power Soaps Logo">
                <h1>Welcome to Power Soaps</h1>
                <p>Select your portal to continue</p>
            </div>

            <div class="portal-grid">
                <a href="<?php echo BASE_URL; ?>admin_dashboard/login" class="portal-card">
                    <div class="portal-icon">
                        <img src="stage/assets/admin@2x.png" alt="Administrator">
                    </div>
                    <div class="portal-info">
                        <span class="portal-label">Power Soaps</span>
                        <h3 class="portal-title">Administrator</h3>
                    </div>
                    <div class="portal-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="<?php echo BASE_URL; ?>distributor_dashboard/login" class="portal-card">
                    <div class="portal-icon">
                        <img src="stage/assets/distributor@2x.png" alt="Distributor">
                    </div>
                    <div class="portal-info">
                        <span class="portal-label">Power Soaps</span>
                        <h3 class="portal-title">Distributor</h3>
                    </div>
                    <div class="portal-arrow">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script src="stage/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        var verfication_code = "<?php echo $verification_code; ?>";
        var api_path = "<?php echo $api_path; ?>";
//        $(".toggle-password").click(function() {
//            var id = this.classList[0];
//            $(this).toggleClass("fa-eye-slash fa-eye");
//            if ($('#' + id).attr("type") == "password") {
//                $('#' + id).attr("type", "text");
//            } else {
//                $('#' + id).attr("type", "password");
//            }
//        });

//        function login() {
//            $('#login_button').prop('disabled', true);
//            var user_email = $("#user_email").val();
//            var user_password = $("#user_password").val();
//            if (user_email != "" && user_password != "") {
//                var datas = {
//                    'user_email': user_email,
//                    'user_password': user_password,
//                    'dashboard_code': verfication_code
//                }
//                var json_data = JSON.stringify(datas);
//                $.ajax({
//                    type: "POST",
//                    dataType: "json",
//                    url: api_path + "/admin/login.php",
//                    data: json_data,
//                }).done(function(data) {
//                    $('#login_button').prop('disabled', false);
//                    if (data.code == 503) {
//                        swal(data.message);
//                    } else if (data.code == 201) {
//                        $("#user_password").val('');
//                        window.location.href = "home.php";
//                    }
//                });
//            } else {
//                $('#login_button').prop('disabled', false);
//                if (user_email == "" && user_password == "") {
//                    swal("Please enter Employee id/Email address and Password!");
//                } else if (user_email == "") {
//                    swal("Please enter Employee id/Email address!");
//                } else if (user_password == "") {
//                    swal("Please enter the Password!!");
//                }
//            }
//        }
    </script>
</body>

</html>