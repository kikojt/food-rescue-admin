<?php
    include('./config/conf.php');

    Auth::logout();
    header('Location: index.php');
    exit();

?>