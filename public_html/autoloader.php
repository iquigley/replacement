<?php
/*
 * This function parses the namespace of the file and tries to autoload it.
 * @return Boolean - true if successful. False if it cannot find the file.
 */
function autoload($class){
        $dirLocation = "../lib/" . $class . ".php";
        if (file_exists($dirLocation)) {
            require $dirLocation;
            return true;
        } else {
            // Cannot be found. Return false and try the next autoloader.
            return false;
        }
}

// Register the autoloader
spl_autoload_register("autoload");

