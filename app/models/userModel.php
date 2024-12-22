<?php
    namespace App\Models;
    // include_once 'BaseModel.php';
    // echo "Sfsd";
class userModel extends BaseModel{
    
    private $db;
    public function __construct()
    {
        $this->db = parent::dbConnet();
    }

    public function validateUser($arr){
        // print_r($arr);
        $sql = "SELECT * FROM users
                    WHERE user_name = '{$arr['uname']}' AND password = '{$arr['password']}'";
        $res = mysqli_query($this->db,$sql);
        if($res->num_rows>0){
            return $res->fetch_assoc()['user_id'];
        }
        return false;
        // print_r($insert);
    }

    public function addUser($arr){
        $sql = "INSERT INTO users (user_name,password)
                    VALUES  (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ss',$arr['userName'],$arr['passWord']);
        $stmt->execute();
        $insertId = $this->db->insert_id;
        return $insertId;
    }
}