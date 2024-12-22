<?php

namespace App\Models;

use App\Models\BaseModel;
use mysqli;

class chatModel extends BaseModel{

    private $db;
    public function __construct()
    {
        $this->db = parent::dbConnet();
    }

    public function getUserNameList(){
        $sql = "SELECT user_name FROM users";
        $res = mysqli_query($this->db,$sql);

        if($res->num_rows>0){
            return $res->fetch_all();
        }
        return [];
    }

    public function getFriendsList(){
        session_start();
        $userId = $_SESSION['userId'];
        $sql = "select u.user_id AS userId,u.user_name AS userName from users u JOIN friends f ON f.user_id_2 =  u.user_id WHERE f.user_id_1 = $userId AND f.status = 'accepted';";

        $res = mysqli_query($this->db,$sql);
        if($res->num_rows>0){
            $friends = $res->fetch_all();
            return $friends;
        }
        return [];
    }

    public function fetchMessages($data){
        $userId = $data['userId'];
        $friendId = $data['friendId'];
        // $sql = "SELECT m.message,m.created_at FROM messages m WHERE sender_id=  AND recepient_id = ";
        $sql = "SELECT m.message,m.created_at,m.sender_id FROM messages m WHERE (sender_id= $userId AND recepient_id = $friendId) OR (sender_id= $friendId AND recepient_id = $userId)";

        $res = mysqli_query($this->db,$sql);
        if($res->num_rows>0){
            return $res->fetch_all();
        }
        return [];
    }

    public function insertMessage($data){
        $userId = $data['sender'];
        $msg = $data['message'];
        $recepient = $data['recepient'];
        $sql = "INSERT INTO messages(message,sender_id,recepient_id)
                VALUES ('$msg',$userId,$recepient)";

        $res = mysqli_query($this->db,$sql);
        return $res;
    }
}

