<?php
    session_start();
    unset($_SESSION['email']);
    unset($_SESSION['token']);
    unset($_SESSION['offre']);
    header('Location: index.php');

?>