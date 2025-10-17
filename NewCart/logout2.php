<!--WORKED FROM LOCAL MACHINE BY DIEGO STILL NEED TO CHANGE TO MAKE IT WORK ON OUR SERVER-->
<!--THIS IS A VERY BASIC LOGOUT PAGE-->
<?php
    session_start();

    $_SESSION = [];     // clear all session data
    session_destroy();  // cleanup session ID

    include('home2.php');
?>