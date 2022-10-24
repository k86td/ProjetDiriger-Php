<?php

session_start();
include 'requete.php';

$user_id = $_SESSION['email']['id'];
$nom = $_SESSION['email']['nom'];
$prenom = $_SESSION['email']['prenom'];
$email = $_SESSION['email']['email'];

$email;
$subject = "Nouvelle Offre";
$txt = "Vous recevez ce message de confirmation pour votre offre!";
$headers = "From: marianstici@gamil.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($email,$subject,$txt,$headers);


?>