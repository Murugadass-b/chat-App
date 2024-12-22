<?php

namespace App\config;

trait Routes
{
    public function setRoute()
    {
        // $queryString = $_GET;
        // print_r($_SERVER['QUERY_STRING']);
        $queryString = explode('&', $_SERVER['QUERY_STRING']);
        $queryString = $queryString[0];
        // var_dump($queryString);
        // print_r($queryString);die;


        switch ($queryString) {
            case null:
                return 'AuthController/login';
            case 'login':
                return 'AuthController/validateUser';
            case 'signUp':
                return 'AuthController/createUser';
            case 'logout':
                return 'AuthController/logoutUser';
            case 'getFriends':
                return 'ChatController/getFriendsList';
            case 'insertMessage':
                return 'ChatController/insertMessage';
            case 'getMessages':
                return 'ChatController/getMessages';
            case 'getUserNames':
                return 'ChatController/getUserNames';
            default:
                echo 'default';
                break;
        }
    }
}
