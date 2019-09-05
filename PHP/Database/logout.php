<?php
    // destroy the session varaibles
    session_start();
    session_unset();
    header('location: login.php');
?>
