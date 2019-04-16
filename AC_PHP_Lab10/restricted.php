<?php
    //require_once('./dao/AbstractDAO');
    echo "echo";
    session_start();
    session_regenerate_id(false);
    echo session_id();
    
    echo "enter restricted";
    if(isset($_SESSION['user'])){
        echo "hi";
        if(!$_SESSION['user']->isAuthenticated()){
            header('Location: userlogin.php');
        }
    }else{
        header('Location: userlogin.php');
    }
?>  

    