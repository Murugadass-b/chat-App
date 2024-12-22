<?php
namespace App\Controllers;

// include_once(__DIR__.'/../config/Routes.php');
include_once(__DIR__.'/../config/Constants.php');

use App\config\Routes;
class BaseController{

    use Routes;

    public $controller;
    public $route;
    public function __construct() {
    }

    public function view($viewFilePath,$data = null){
        $path =  VIEWS.$viewFilePath.'.php';
        // echo  $path;die;
        header("Location: http://localhost/".$path);
    }
    

    public function run(){
        
        $this->route = $this->setRoute();
// echo $this->route;
        $queryString = explode('/', $this->route);
        $cont = $queryString[0];
        $func = $queryString[1];

        $this->controller = "App\\Controllers\\".$cont;
        $controller = new $this->controller;
        call_user_func([$controller,$func]);
        
    }


    
}
?>