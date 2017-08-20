<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author Paul
 */
class Database {

    //put your code here
    private $host = "localhost";
    private $db_name = "forum";
    private $username = "test";
    private $password = "test";
    public $conn;

    public function DbConnection() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        } catch (Exception $ex) {
            echo "Connection error: " . $ex->getMessage();
        }
        return $this->conn;
    }
}

$database = new Database();
$db = $database->DbConnection();
