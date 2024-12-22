<?php
    
    // error_reporting(E_ALL ^ E_WARNING);
    // include_once(__DIR__."/app/controllers/BaseController.php");
    include_once(__DIR__."/system/Autoload.php");

    // echo __DIR__;die;

    define('VIEWS','projects/chatApp/app/views/');
    use App\controllers\BaseController;

    $baseController = new BaseController();

    $baseController->run();


