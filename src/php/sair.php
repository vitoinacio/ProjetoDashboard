<?php
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['id']);
    header('location: ../../index.php');
?>