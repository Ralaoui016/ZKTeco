<?php

    session_name( 'ZKTeco' );
    session_start();
   
    $_SESSION = array();

    // Si vous voulez détruire complètement la session, effacez également
    // le cookie de session.

    session_destroy();
    header('Location: ../index.php');
    exit();
    // Finalement, on détruit la session.
