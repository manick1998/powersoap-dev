<?php
session_start();
unset($_SESSION['distributor_token']);
unset($_SESSION['name']);
unset($_SESSION['employees_code']);
unset($_SESSION['verification_code']);
unset($_SESSION['particular_shop_redirect']);
unset($_SESSION['is_redirect_retailer_sub_page']);
unset($_SESSION['retailer_token']);
session_destroy();  
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logging out...</title>
</head>
<body>
    <script>
        
        localStorage.clear(); 
        
      
        window.location.href = "../../"; 
    </script>
</body>
</html>