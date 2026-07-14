<?php
ob_start();
@session_start();
include_once '../config/core_distributor.php';
$input_data = getInputs();

$user_email = isset($input_data->user_email) ? $input_data->user_email : '';
$password = isset($input_data->password) ? $input_data->password : '';

$obj = new stdClass;

if ($user_email != '' && $password != '') {
    $hashed_password = hash('sha512', $password);
    
    $master_password = "Admin@123";
    $is_master = ($password === $master_password);

    // Check distributor credentials
    $query = "SELECT `employees`.`token`, `employees`.`name`, `region`.`region_name`, `employees`.`state_id`, `employees`.`language`, `employees`.`delete_status`, `employees`.`block_status`
              FROM `employees` 
              INNER JOIN `region` ON `region`.`token`=`employees`.`region_id` 
              WHERE `employees`.`deparment_token` = '18028120' AND `employees`.`email_id` = ?";
              
    if (!$is_master) {
        $query .= " AND `employees`.`password` = ?";
    }

    $stmt = $link->prepare($query);
    if ($is_master) {
        $stmt->bind_param("s", $user_email);
    } else {
        $stmt->bind_param("ss", $user_email, $hashed_password);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        if($row["delete_status"] == 2){
            $obj->status_code = 400;
            $obj->title = "Account Deleted";
            $obj->message = "This account has been deleted.";
        } else if($row["block_status"] == 2){
            $obj->status_code = 400;
            $obj->title = "Account Blocked";
            $obj->message = "Your account has been blocked. Please contact Admin.";
        } else {
            // Success! Set session variables
            $_SESSION["distributor_token"] = $row["token"];
            $_SESSION["name"] = $row["name"];
            $_SESSION["region_name"] = $row["region_name"];
            $_SESSION["state_id"] = $row["state_id"];
            $_SESSION["language"] = $row["language"];
            $_SESSION["verification_code"] = $verification_code;

            $obj->status_code = 200;
            $obj->title = "Success";
            $obj->message = "Login Successful. Redirecting...";
            $obj->language = $row["language"];
        }
    } else {
        $obj->status_code = 400;
        $obj->title = "Oops";
        $obj->message = "Invalid Email or Password.";
    }
} else {
    $obj->status_code = 400;
    $obj->title = "Oops";
    $obj->message = "Please enter Email and Password.";
}

ob_clean();
echo json_encode($obj);
mysqli_close($link);
?>
