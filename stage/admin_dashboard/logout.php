<?php 
setcookie("token_admin_dashboard_development", "", time() + (86400 * 30), "/");
header("Location:../../");
?>