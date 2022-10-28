<?php


include 'requete.php';
include '_headerBar.php';

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer;
$webMail = 'marianstici@gmail.com';

// Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Port = 587;
$mail->SMTPSecure = 'tls';
$mail->Username = $webMail;
$mail->Password = 'jcwwciksgjggkyhc';


    if (isset($_POST['envoyer']))
    {
        $mail->addAddress($webMail); // Add a recipient

        $userName = $_POST['name'];
        $userEmail = $_POST['email'];
        $userMessage = $_POST['message'];

        // Sender info
        $mail->setFrom($userEmail, $userName); // Sender
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Autorius - Contactez-Nous!';

        // Mail body content
        $bodyContent = '<h1>Contactez-Nous!! </h1>';
        $bodyContent .= $userMessage;
        $mail->Body    = $bodyContent;

        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            header('Location: index.php');
        }
    }

    if (isset($_POST['inscription']))
    {
        print_r($_POST);
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $tel = $_POST['telephone'];
        $email = $_POST['email'];
        $mail->addAddress($email); // Add a recipient

        $mail->setFrom($webMail, 'Autorius'); // Sender info
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Autorius - Inscription!';

        // Mail body content
        $bodyContent = "<h1>Inscription Reussie !! </h1>";
        $bodyContent .= "<h5>A partire de maintenant vous pouvez avoir accer a notre site web!<br>
        Voisi vos informations a fin de verifier si tout est correcte, si non vous pouvez toujours les changer
        sur le site dans l'option <b> Profile </b>. </h5><br>
        <p> Votre nom complet :$nom, $prenom <br>
        Votre adress: $adresse <br>
        Votre numero de telephone: $tel <br>
        Et du moment que vous resevez se courriel je suppose que vous avez bien rentrez votre adresse email.
        </p>";
        $mail->Body    = $bodyContent;

        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            // header('Location: index.php');
        }
        
    }

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