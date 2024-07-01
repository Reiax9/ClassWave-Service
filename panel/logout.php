<?php
    require "../lib/ssh/remotescript.php";
    session_start();
    if(isset($_SESSION['course'])){
        startDocker($_SESSION['course'],$_SESSION['alumno'],$_SESSION['user'],$_SERVER["REMOTE_ADDR"],FALSE);
        session_unset();
        session_destroy();
        setcookie('session', '', time() - 3600, '/');
    }
    header('Location: ../index.php');
    exit();
?>
