<?php
class Admin
{
    public $userEmail;
    public $userPassword;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function loginEmailCheck()
    {
        $query = "SELECT `id`,`name`,`token`,`email`,`phone_number` FROM `admin_login` WHERE `email`=:email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('email', $this->userEmail);
        $stmt->execute();
        return $stmt;
    }
    public function loginStatusCheck()
    {
        $query = "SELECT `id`,`name`,`token`,`email`,`phone_number` FROM `admin_login` WHERE `email`=:email AND `status`=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('email', $this->userEmail);
        $stmt->execute();
        return $stmt;
    }
    public function employeeLoginCheck()
    {
        $user_password = hash('sha512', $this->userPassword);
        $query = "SELECT id, name, token, email, phone_number FROM `admin_login` WHERE `email`=:email AND `password`=:password AND `status`=1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $this->userEmail);
        $stmt->bindParam(':password', $user_password);
        $stmt->execute();
        return $stmt;
    }
    
    public function readToken($stmt)
    {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $token = (int) $row['token'];
        return $token;
    }
    public function selectModule()
    {
        $query = "SELECT `id`,`module_name`,`image`,`file_name` FROM `admin_module` WHERE `status` = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function checkuser()
    {
        $query = "SELECT  * FROM admin_login WHERE `email` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->user_email);
        $stmt->execute();
        return $stmt;
    }
    public function createRole()
    {
        $query = "INSERT INTO `admin_login` SET
        `token`=?,
        `name`=?,
        `email`=?,
        `password`=?,
        `state_id`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->bindParam(2, $this->user_name);
        $stmt->bindParam(3, $this->user_email);
        $stmt->bindParam(4, $this->password);
        $stmt->bindParam(5, $this->user_state);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function selectState()
    {
        $query = "SELECT * FROM `employees__state` ORDER BY `state_name` ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //  function admin_select_State(){
    //     $query = "SELECT * FROM `employees__state` WHERE state_token =?";
    //     $stmt = $this->conn->prepare( $query );
    //     $stmt->bindParam(1,$this->admin_state_id);
    //     $stmt->execute();
    //      return $stmt;
    //  }

    public function createRoleModules()
    {
        $currentdate = date("Y-m-d H:i:s");
        $token = $this->token;
        $modules = $this->module_id;
        foreach ($modules as $moduleToken) {
            $inserts[] = "('$token','$moduleToken','$currentdate')";
        }
        $query = "INSERT INTO `admin_user_module`(`user_token`, `module_id`,`datetime`) VALUES " . implode(", ", $inserts);
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    public function fetchmodulelist()
    {
        $query = "SELECT DISTINCT `admin_login`.name,
        `admin_login`.token,
        `admin_login`.email,
        `admin_user_module`.`datetime`,
        `employees__state`.`state_name`,
        `employees__state`.`state_token`,
        GROUP_CONCAT(CONCAT(`admin_module`.`id`,'&&&',`admin_module`.`module_name`),'***') AS `modules`
        FROM `admin_login`
        INNER JOIN `admin_user_module` ON `admin_user_module`.`user_token` = `admin_login`.`token`
        INNER JOIN `admin_module` ON `admin_module`.id = `admin_user_module`.`module_id`
        INNER JOIN `employees__state` ON `admin_login`.`state_id` = `employees__state`.state_token
        WHERE `admin_user_module`.`status` = 1 AND `admin_login`.token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->admin_token);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $token = $row['token'];
            $obj1 = new StdClass();
            $obj1->token = $row["token"];
            $obj1->name = $row["name"];
            $obj1->email = $row["email"];
            $obj1->state_name = $row["state_name"];
            $obj1->state_token = $row["state_token"];
            $obj1->date_time = convertDate("Y-M-d", $row['datetime']);
            $module = rtrim($row["modules"], '***');
            $module_detail = explode('***,', $module);
            $modules = [];
            foreach ($module_detail as $module_data) {
                $obj2 = new stdClass();
                $mod_data = explode('&&&', $module_data);
                $obj2->module_id = $mod_data[0];
                $obj2->module_name = $mod_data[1];
                array_push($modules, $obj2);
            }
            $obj1->modules_data = $modules;
        }
        return $obj1;
    }

    public function allfetchmodulelist()
    {
        $query = "SELECT DISTINCT `admin_login`.name,
        `admin_login`.`token`,
        `admin_login`.`email`,
        `admin_login`.`status`,
        `admin_user_module`.`datetime`,
        `employees__state`.`state_name`,
        GROUP_CONCAT(`admin_module`.`module_name`) AS `modules`
        FROM `admin_login`
        INNER JOIN `admin_user_module` ON `admin_user_module`.`user_token` = `admin_login`.`token`
        INNER JOIN `admin_module` ON `admin_module`.id = `admin_user_module`.`module_id`
        INNER JOIN `employees__state` ON `admin_login`.`state_id` = `employees__state`.state_token
        WHERE `admin_user_module`.`status` = 1 GROUP BY `admin_login`.`token`  ORDER BY `admin_user_module`.`datetime` DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $arr = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $token = $row['token'];
            $obj1 = new StdClass();
            $obj1->token = $row["token"];
            $obj1->name = $row["name"];
            $obj1->email = $row["email"];
            $obj1->status = $row["status"];
            $obj1->state_name = $row["state_name"];
            $obj1->date_time = convertDate("Y-M-d", $row['datetime']);
            $obj1->module_name = $row['modules'];
            array_push($arr, $obj1);
        }
        return $arr;
    }

    public function updateNewData()
    {
        $query = "UPDATE `admin_user_module` set `status`='2' where `user_token`=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function updateInsertData()
    {
        $modules = $this->modules;
        foreach ($modules as $moduleValue) {
            $query = "INSERT INTO  `admin_user_module` SET `user_token`=?,`module_id`='$moduleValue',`datetime`=?,`status`='1'";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->token);
            $stmt->bindParam(2, $this->currentdate);
            $stmt->execute();
        }
        return $stmt;
    }
    //check user-role
    public function updateName()
    {
        $query1 = "UPDATE `admin_login` set `name`=?,`email`=?,`password`=? where `token`=?";
        $stmt = $this->conn->prepare($query1);
        $stmt->bindParam(1, $this->name);
        $stmt->bindParam(2, $this->email);
        $stmt->bindParam(3, $this->password);
        $stmt->bindParam(4, $this->token);
        $stmt->execute();
        return $stmt;
    }

    public function listmodule()
    {
        $query = "SELECT
        admin_module.module_name,
        admin_module.image,
        admin_module.file_name
    FROM
        admin_module
    INNER JOIN admin_user_module ON admin_module.id = admin_user_module.module_id
    INNER JOIN admin_login ON admin_user_module.user_token = admin_login.token
    WHERE
        admin_login.token = ? AND admin_user_module.status = '1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->token);
        $stmt->execute();
        return $stmt;
    }
    //status update
    public function statusupdate()
    {
        $query = "UPDATE `admin_login` SET `status`= 2 WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->admin_token);
        $stmt->execute();
        return $stmt;
    }
    public function statusrechange()
    {
        $query = "UPDATE `admin_login` SET `status`= 1 WHERE token = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->admin_token);
        $stmt->execute();
        return $stmt;
    }
}