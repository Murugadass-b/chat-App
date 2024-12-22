<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\chatModel;

class ChatController extends BaseController
{

    private $chatModel;
    public function __construct()
    {
        $this->chatModel = new \App\Models\chatModel;
    }

    public function home()
    {

        $this->getFriendsList();
        $this->view('users/home');
    }

    public function getUserNames()
    {
        $userList = $this->chatModel->getUserNameList();
        $finalUsersArray = array();
        if(!empty($userList)){
            foreach($userList as $key=>$val){
                array_push($finalUsersArray,$val[0]);
            }
        }
        echo json_encode($finalUsersArray);
    }


    public function getFriendsList()
    {
        $friendsList = $this->chatModel->getFriendsList();
        $finalFriendsArray = array();
        foreach ($friendsList as $key => $val) {
            $finalFriendsArray[] = array(
                'id' => $val[0],
                'name' => $val[1]
            );
        }
        echo json_encode($finalFriendsArray);
    }

    public function getMessages()
    {
        session_start();
        $data = array(
            'userId' => $_SESSION['userId'],
            'friendId' => $_GET['friendId']
        );
        $messages = $this->chatModel->fetchMessages($data);

        $finalMessageArray = array();
        if (count($messages) > 0) {
            foreach ($messages as $key => $val) {
                if ($val[0]!="") {
                    $isSender = ($_SESSION['userId'] == $val[2]) ? 1 : 0;
                    $finalMessageArray[] = array(
                        'messageText' => $val[0],
                        'time' => date('h:i A', strtotime($val[1])),
                        'date' => date('d-m-Y', strtotime($val[1])),
                        'isSender' => $isSender
                    );
                }
            }
        }

        echo json_encode($finalMessageArray);
    }

    public function insertMessage()
    {
        session_start();
        print_r($_SESSION);
        print_r($_POST);
        $data = array(
            'sender' => $_SESSION['userId'],
            'message' => $_POST['message'],
            'recepient' => $_POST['recepientId']
        );
        if ($this->chatModel->insertMessage($data)) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Message inserted successfully.'
            ]);
        }
    }
}
