<?php
    //debut de la session
    session_name( 'ZKTeco' );
    session_start();
    if(isset($_SESSION["LoginZKTeco"]) and isset($_SESSION["NomCmpZKTeco"]))
    {
        header('Location: ./dashbord.php');
        exit();
    }
    else
    {
        header('Location: ./login.php');
        exit();
    }