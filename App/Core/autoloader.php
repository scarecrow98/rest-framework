<?php

spl_autoload_register(function($class) {
    $file = str_replace('\\', '/', $class);
    $file = $file . '.php';
    
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    throw new Exception('Class not found: ' . $class);
});