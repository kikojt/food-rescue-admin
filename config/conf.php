<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    define('ROOT', dirname(__DIR__));           // raiz do projeto (pasta acima de config/)
    define('DEFAULT_LANG', 'pt');               // RG-1: idioma por omissão

    spl_autoload_register(function (string $class) {
        $file = ROOT . './classes/' . $class . '.php';
        
        if (is_file($file)) {
            require_once $file;
        }
    });

    $DBH = Database::getConnection();
?>