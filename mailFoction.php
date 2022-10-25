<?php

session_start();
include 'requete.php';

    $user_id = $_SESSION['email']['id'];
    $nom = $_SESSION['email']['nom'];
    $prenom = $_SESSION['email']['prenom'];
    $email = $_SESSION['email']['email'];

if (isset($_POST['offre_appli'])){

    $id_offre= $_POST['offre_appli'];
    $offre = json_decode(GetOffre($id),true);
    $dateDebut = $offre['dateDebut'];
    $dateFin = $offre['dateFin'];
    
    $subject = "Nouvelle Offre";
    $txt = "Bonjour $nom $prenom. Vous recevez ce message de confirmation pour votre offre de votre ____ vendu par 
    ____. Vous voulez avoir ceci du $dateDebut jusqu'au $dateFin";
    $headers = "From: marianstici@gamil.com" . "\r\n" .
    "CC: somebodyelse@example.com";
    
    mail($email,$subject,$txt,$headers);
}



?>