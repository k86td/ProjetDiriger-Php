<?php


include 'requete.php';


require 'PhpMailer/Exception.php';
require 'PhpMailer/PHPMailer.php';
require 'PhpMailer/SMTP.php';

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
        $bodyContent = "<h2>Contactez-Nous!! </h2>";
        $bodyContent .= $userMessage;
        $bodyContent .= "<h5>Envoyez par $userEmail ($userName)</h5>";
        $mail->Body    = $bodyContent;

        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        } else {
            echo 'Message has been sent.';
            header('Location: index.php');
        }
    }

    function sendMailInscription($prenom, $nom, $adresse, $tel, $email, $mail, $webMail){
       // echo $email;
        //echo $tel;
        $mail->addAddress($email); // Add a recipient

        $mail->setFrom($webMail, 'Autorius'); // Sender info
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Autorius - Inscription!';

        // Mail body content
        $bodyContent = "<h2>Inscription Reussie !! </h2>";
        $bodyContent .= "<h5>À partir de maintenant vous pouvez avoir accès a notre site web!<br>
        Voici vos informations a fin de vérifier si tout est correcte, sinon vous pouvez toujours les changer
        sur le site dans l'option <b> profile </b>. </h5><br>
        <p> votre nom complet :$nom, $prenom <br>
        Votre adresse: $adresse <br>
        Votre numéro de téléphone: $tel <br>
        Et du moment que vous recevez ce courriel, vous êtes bien inscrit sur notre site.

        $mail->Body    = $bodyContent;

        // Send email
        if(!$mail->send()) {
            echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo;
        } else {
           // echo 'Message has been sent.';
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