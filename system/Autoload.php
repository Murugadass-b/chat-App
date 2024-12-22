<?php

// class Autoload{
//     public static function classLoader($class){
        // echo $class;
        // echo CONTROLLERS;die;
        // $baseDir = __DIR__.'/../app';
//         $path = __DIR__.'/../App/Controllers/'.$class .".php";

//         if(file_exists($path)){
//             // echo $path;die;
//             include_once($path);
//         }
//         else{
//             $path = __DIR__.'/../app/models/'.$class .".php";
//             // echo $path;die;
//             include_once($path);
//         }
//         // echo $path;
        
//     }
// }
// spl_autoload_register('Autoload::classLoader');

class Autoload {
    public static function classLoader($class) {
        // Replace namespace separators with directory separators
        $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';

        if (file_exists($path)) {
            // echo $path;            
            include_once $path;
        } else {
            echo $path;
            throw new Exception("Unable to load class: $class");
        }
    }
}

spl_autoload_register('Autoload::classLoader');

?>