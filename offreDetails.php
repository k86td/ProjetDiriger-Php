<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="fr">
<html>
    <head>
        <title>Autorius - Offre details</title> <!-- À changer -->
        <meta charset="UTF-8">
    </head>
    <body>
        <h2 style="width: 100%; text-align: center;">🚧 en construction 🚧</h4>
        <div class='form-content-right'>
            <form class='form' method="POST">
                <h1>
                    Modifications de l'offre
                </h1>
                <br>
                  <div class='form-inputs'>
                    <label class='form-label'>Nom</label>
                    <input class='form-input' value="<?php echo $_SESSION['offreDetails']->nom; ?>"  required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder="Nom de l'offre" />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Prix</label>
                    <input class='form-input' value="<?php echo $_SESSION['offreDetails']->prix; ?>" required type='number' pattern="[0-9]+" title="Seulement des chiffres" name='prix' placeholder="Prix de l'offre" />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Adresse</label>
                    <input class='form-input' value="<?php echo $_SESSION['offreDetails']->coordonner; ?>" required name='coordonner'/>
                </div>
                <div>
                    <!-- TODO: Modifier la date de l'offre-->
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Type</label>
                    <input class='form-input' value="<?php echo $_SESSION['offreDetails']->idTypeOffre; ?>" required name='type'/>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Categorie</label>
                    <input class='form-input' value="<?php echo $_SESSION['offreDetails']->idCategorieOffre; ?>" required name='categorie'/>
                </div>
                <button class='form-input-btn' type='submit'>
                    Confirmer les changements
                </button>
                <button>
                    <a href="mesOffres.php" class="delete-btn">Revenir</a>
                </button>
                <br>
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST") 
                {
                    $nom = $_POST['nom'];
                    $prix = $_POST['prix'];
                    $coordonner = $_POST['coordonner'];
                    $type = $_POST['coordonner'];
                    $categorie = $_POST['categorie'];
                    UpdateOffre($nom, $prix, $coordonner, $type, $categorie);
                    header("Location: mesOffres.php"); // TODO: Trouver meilleur façon de rediriger l'usager
                }
                ?>
            </form>
        </div>
    </body>
</html>
