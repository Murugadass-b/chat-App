<?php

    namespace App\Models;
    class BaseModel{
        
        private $conn;
        public function __construct()
        {
            // $this->conn = self::dbConnet();
        }
        public function dbConnet(){
            $server = "localhost";
            $user = "root";
            $password = "pass123";
            $db = "chat_app";
            return mysqli_connect($server,$user,$password,$db);  
        }
    }
?>  