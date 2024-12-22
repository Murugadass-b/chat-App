<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Controllers\ChatController;
use App\Model\userModel;

class AuthController extends BaseController
{
    public $userModel;
    public $chatController;
    public function __construct()
    {

        $this->userModel = new \App\Models\userModel;
        $this->chatController = new \App\Controllers\ChatController;
        // var_dump($this->userModel);die;
    }

    public function login()
    {
        // echo 'login';
        // header('Location:app/views/login.php');

        $this->view('users/login');
    }

    public function logoutUser()
    {
        session_destroy();
        $this->view('users/login');
    }

    public function setUserSession($uName, $uId)
    {
        session_start();
        $_SESSION['user'] = $uName;
        $_SESSION['userId'] = $uId;
    }

    public function validateUser()
    {
        if ($userId = $this->userModel->validateUser($_POST)) {
            // // print_r($userId);die;
            $this->setUserSession($_POST['uname'], $userId);
            $this->chatController->home();
        } else {
            echo 'Invalid data';
        }
    }

    public function createUser()
    {
        $data = array(
            'userName' => $_POST['uname'],
            'passWord' => $_POST['password']
        );
        $userId = $this->userModel->addUser($data);
        $this->setUserSession($_POST['uname'], $userId);
        $this->chatController->home();
        // print_r($_POST);
    }
}

// echo "auth";
