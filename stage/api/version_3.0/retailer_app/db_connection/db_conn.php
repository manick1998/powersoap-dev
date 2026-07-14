<?php
require_once dirname(__FILE__) . '/../../../../database_credentials.php';
class Database {
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $db_name = DB_NAME;
    public $conn;
    private $urlLink;
    // get the database connection
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
    public function getUrl() {
        $obj = new stdClass;
        $obj->employeeUrl  = EMPLOYEE_ASSET_URL;
        return $obj;
    }
}

?>
