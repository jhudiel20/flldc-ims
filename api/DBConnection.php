<?php
// Define constants for database connection
if(!defined('host')) define('host', "ep-wild-tree-a4wwmube.us-east-1.aws.neon.tech");
if(!defined('username')) define('username', "default");
if(!defined('password')) define('password', "N7EiwAoCcI0h");
if(!defined('db_tbl')) define('db_tbl', "verceldb");
if(!defined('port')) define('port', 5432);

Class DBConnection{
    public $conn;
    function __construct(){
        try {
            $this->conn = new PDO("pgsql:host=".host.";port=".port.";dbname=".db_tbl.";sslmode=require", username, password);
            // Set error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Connection Error: " . $e->getMessage());
        }
    }
    function __destruct(){
         $this->conn = null; // Close the connection
    }

}

$db = new DBConnection();
$conn = $db->conn;


    // Method to check if the connection is alive
    // public function checkConnection() {
    //     try {
    //         $stmt = $this->conn->query("SELECT 1");
    //         if ($stmt) {
    //             return "Connection is alive.";
    //         } else {
    //             return "Connection is not alive.";
    //         }
    //     } catch (PDOException $e) {
    //         return "Connection check failed: " . $e->getMessage();
    //     }
    // }

// Check if the connection is alive
// echo $db->checkConnection();

// If you have a second connection to another database, replicate the same structure.
