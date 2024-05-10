<?php
function classAutoLoader($class){
    $class = strtolower($class);
    $the_Path = "includes/{$class}.php";

    if(is_file($the_Path) && !class_exists($class)){
        require_once($the_Path);
    }else{
        die("This file named {$class}.php has not found!!!");
    }
}

spl_autoload_register('classAutoLoader');

function redirect($location){
    header("Location:" . $location);
    exit;
}

function escape($string){
    global $my_db;
    return $my_db->escape_string(trim($string));
}
?>