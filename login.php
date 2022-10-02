<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
  
</head>

<body>
    <div class='form-container'>
        <span class='close-btn'><a style="color: white;" href="index.php">x</a></span>
        <div class='form-content-left'>
            <img class='form-img' src='img/image_favicon.png' alt='voiture' />
        </div>
        <div class='form-content-right'>
        <form class='form' method="POST">
                <h1>
                    Connecter vous pour accÃ©der aux services offerts!
                </h1>
                <div class='form-inputs'>
                    <input class='form-input' required type='email' name='courriel' placeholder="Nom d'utilisateur"  />
                </div>
                <div class='form-inputs'>
                    <input class='form-input' required type='password' name='password' placeholder='Mot de passe'   />
                </div>
                <button class='form-input-btn' type='submit'>
                    Connexion
                </button>
                <span class='form-input-login'>
                    Pas de compte? Inscrivez-vous
                   <a href="inscription.php">ici</a>
                </span>
            </form>
        </div>
    </div>
</body>

</html>

<?php
    session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST")
 {
   include 'requete.php';
    $courriel = $_POST['courriel'];
    $password = $_POST['password'];
    $_SESSION['email'] = LoginToken($courriel,$password);
    $_SESSION['email'] = LoginNoToken($courriel,$password);

    // echo  $_SESSION['email'];
    // print_r($_SESSION);
    // header('Location: index.php');
    
}

?>