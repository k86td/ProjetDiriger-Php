<?php


session_start();
include 'requete.php';




if (isset($_POST['user_delete']))
{
    $id = $_POST['user_delete'];

    DeleteUsager($id);

    header('Location: listUsers_admin.php');
}
?>