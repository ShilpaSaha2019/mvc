<?php

//autoloading files withourt using require
spl_autoload_register(function ($class_name) {
    if(strstr($class_name,'Controller') !== false){
        require "Controllers/{$class_name}.php";
    }
    else if(strstr($class_name,'Model') !== false){
        require "Models/{$class_name}.php";
    }
});

//getting folder name from url
$url = $_GET['_url'];
//dividing url names seperated by /
$urlComponents = explode('/',$url);

//searching if url array index 2 exists else redirect to products
$controller = !empty($urlComponents[2]) ? $urlComponents[2] : 'products' ;
$controller = ucfirst($controller);
$method = $urlComponents[3] ?? 'index' ;

$controller = "{$controller}Controller";

$c = new $controller();
$c->{$method}();