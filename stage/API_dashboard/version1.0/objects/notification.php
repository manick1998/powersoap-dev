<?php
class Notification{
    public $conn;
    public $distributor_token;
    public $notification_token;
    public $noti_title;
    public $noti_content;

    public function __construct($db) {
        $this->conn = $db;
    }
    function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
    function creteNewNotification($notification_array){
       $query = "INSERT INTO `admin_notification`(`token`, `distributor_token`, `notification_title`, `notification_description`, `date_time`, `seen_status`, `delete_status`) VALUES ".implode(", ", $notification_array);
       $stmt = $this->conn->prepare($query);
       if($stmt->execute()){
           return true;
       }else{
           return false;
       } 
    } 
    
    function selectNotification(){
        $query1 = "SELECT `token`, `notification_title`, `notification_description`, `date_time` 
        FROM `admin_notification` 
        WHERE `delete_status` = 1 GROUP BY `token` order BY id DESC";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->execute();
        return $stmt1;
    }
    
    function selectAllDistributor(){
        $query2 = "SELECT `token` FROM `employees` WHERE `deparment_token`=18028120";
        $stmt2 = $this->conn->prepare($query2);
        $stmt2->execute();
        $array = [];
        while($row = $stmt2->fetch(PDO::FETCH_ASSOC)){  
            $token = $row['token']; 
            array_push($array, $token);
        }
        return $array;  
    }
    
    function readSelectNotification($stmt){
        $array = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $obj = new stdClass();
            $obj->notification_token = $row["token"];   
            $obj->notification_title = $row["notification_title"];   
            $obj->notification_description = $row["notification_description"];   
            $obj->onlyDate = date("d/m/Y",strtotime($row['date_time']));     
            $obj->onlyTime = date("h:i A",strtotime($row['date_time'])); 
            array_push($array, $obj);
        }
        return $array;
    }
    
    function deleteNotification(){
        $query = "UPDATE `admin_notification` SET `delete_status` = 2 WHERE `token`=?";
        $stmt3 = $this->conn->prepare($query);
        $stmt3->bindParam(1,$this->notification_token);
        $stmt3->execute();
        return $stmt3;
    }
    
    function updateSeenNotification(){
        $query = "UPDATE `admin_notification` SET `seen_status` = '1' WHERE `distributor_token`=?";
        $stmt3 = $this->conn->prepare($query);
        $stmt3->bindParam(1,$this->distributor_token);
        $stmt3->execute();
        return $stmt3;
    }
    
    function selectIndividualDistributor(){
        $query1 = "SELECT `token`, `notification_title`, `notification_description`, `date_time` 
        FROM `admin_notification` 
        WHERE `distributor_token`=? AND `delete_status` = 1 order BY id DESC";
        $stmt1 = $this->conn->prepare($query1);
        $stmt1->bindParam(1,$this->distributor_token);
        $stmt1->execute();
        return $stmt1;
    }
    
    function readSelectIndividualDistributor($stmt){
        $array = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $obj = new stdClass();
            $obj->notification_token = $row["token"];   
            $obj->notification_title = $row["notification_title"];   
            $obj->notification_description = $row["notification_description"];   
            $obj->onlyDate = date("d/m/Y",strtotime($row['date_time']));     
            $obj->onlyTime = date("h:i A",strtotime($row['date_time'])); 
            array_push($array, $obj);
        }
        return $array;
    }

    function countUnseenNotification(){
        $query = "SELECT count(`id`) AS `notification_count` FROM `admin_notification` WHERE `distributor_token`=? AND `seen_status`='0' AND `delete_status`='1'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->distributor_token);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['notification_count'];
    }
}
?>