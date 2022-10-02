<?php
session_start();
include 'bd.php';
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <?php
    if (!isset($message)) {
        $message = "";
    }
    GetInfosJoueur($_SESSION['IdJoueur']);
    ?>
    <form action="modifierProfil.php" method="POST">
        <fieldset>
            <legend>Formulaire d'inscription</legend>
            <label for="nom">Votre nom : </label><input value="<?php echo $_SESSION['nomAModifier'] ?>" type="text" name="nom" id="nom" pattern="[A-Za-z]{1,15}" title="Seulement les lettres anglaises sont permises" placeholder="Nom" required><br><br>
            <label for="prenom">Votre prenom : </label><input value="<?php echo $_SESSION['prenomAModifier'] ?>" type="text" pattern="[A-Za-z]{1,15}" title="Seulement les lettres anglaises sont permises" name="prenom" id="prenom" placeholder="Prénom" required><br><br>
            <label for="pseudo">Votre alias : </label><input value="<?php echo $_SESSION['aliasAModifier'] ?>" type="text" name="pseudo" id="pseudo" placeholder="Alias" required><br><br>
            <label for="mdp">Votre mot de passe : </label><input value="<?php echo $_SESSION['mdpAModifier'] ?>" type="password" name="mdp" id="mdp" placeholder="Mot de passe" required><br><br>
            <label for="mdp2">Confirmer votre mot de passe : </label><input value="<?php echo $_SESSION['mdpAModifier'] ?>" type="password" name="mdp2" id="mdp2" placeholder="Mot de passe" required><br><br>
            <label for="email">Votre adresse courriel : </label><input value="<?php echo $_SESSION['emailAModifier'] ?>" type="email" name="email" id="email" placeholder="Email@exemple.com" required><br><br>
            <input type="submit" value="Modifier votre compte" class="ref"><br><br>
            <button><a href="index.php">Retour à l'accueil</a></button>
            <?php

            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $pseudo = $_POST['pseudo'];
                $mdp = $_POST['mdp'];
                $mdp2 = $_POST['mdp2'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                if ($pseudo === ' ' || $mdp === ' ' || $nom === ' ' || $prenom === ' ' || $email === ' ') {
                    $message = '<div style="color: red;">Veuillez inséré des valeurs dans les champs vacants</div>';
                } else if ($mdp != $mdp2) {
                    $message = '<div style="color: red;">Les mots de passes ne sont pas identiques</div>';
                } else {
                    try {
                        $message = '<div style="color: green;">votre profile a été modifier avec succès</div>';
                        ModifierJoueur($_SESSION['IdJoueur'], $nom, $prenom, $pseudo, $mdp, $email);
                    } catch (Exception $e) {
                        $message = '<div style="color: red;">Cet alias a déjà été choisi</div>';
                    }
                    $_SESSION['alias'] = $pseudo;
                }
            }
            ?>

            <p><?php echo $message ?></p>
        </fieldset>
    </form>
</body>

</html>