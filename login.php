<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/form.css" rel="stylesheet">

</head>

<body>
    <div class='container'>
        <span class='close-btn'><a style="color: #ca2929;" href="index.php">x</a></span>
        <div class='title'>Se connecter </div>
        <form class='form' method="POST">
            <div class="user-details">
                <div class='input-box'>
                    <span class="details">Entrez-votre nom d'utilisateur</span>
                    <input required type='email' name='courriel' placeholder="Nom d'utilisateur" />
                </div>

                <div class='input-box'>
                    <span class="details">Entrez-votre mot de passe</span>
                    <input class='form-input' required type='password' name='password' placeholder='Mot de passe' />
                </div>
                <button class='button' type='submit'>
                    Connexion
                </button>
                <span class='form-input-login'>
                    Pas de compte? Inscrivez-vous
                    <a href="inscription.php">ici</a>
                </span>
            </div>
            <?php
            session_start();
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                include 'requete.php';
                $courriel = $_POST['courriel'];
                $password = $_POST['password'];
                $_SESSION['token'] = LoginToken($courriel, $password);
                $_SESSION['email'] = LoginNoToken($courriel, $password);
                if ($_SESSION['email'] == null) {
                  echo '<div style="color: red;"> Erreur votre mot de passe ou votre email est incorrect veuillez réessayer</div>';
                } else {
                    header('Location: index.php');
                }
            }

            ?>
        </form>
    </div>
</body>

</html>