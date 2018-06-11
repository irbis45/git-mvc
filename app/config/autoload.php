<?php
/**
 * @param $class
 */
function autoload($class)
{
    if (file_exists("app/lib/" . $class . ".php")) {
        require 'app/lib/' . $class . '.php';
    } else {
        exit('The file ' . $class . '.php is missing in the lib folder.');
    }
}

spl_autoload_register("autoload");
