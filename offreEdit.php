<?php
session_start();
include 'requete.php';
if (!isset($_SESSION['email'])) {
    unset($_SESSION['offreDetails']);
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $coordonner = $_POST['coordonner'];
    $type = $_SESSION['offreDetails']->idTypeOffre;
    $idCategorie = $_POST['categorie'];
    $dateDebut = $_POST['dateDebut'];
    $dateFin = $_POST['dateFin'];
    $annee = $_POST['annee'];
    $couleur = $_POST['couleur'];
    $marque = $_POST['marque'];
    $modele = $_POST['modele'];
    $odometre = $_POST['odometre'];
    $porte = $_POST['porte'];
    $siege = $_POST['siege'];
    $carburant = $_POST['carburant'];
    $traction = $_POST['traction'];
    $description = $_POST['description'];
    $accidente = $_POST['accidente'];

    UpdateVoiture($annee, $couleur, $marque, $modele, $odometre, $porte, $siege, $carburant, $traction, $description, $accidente);
    UpdateOffre($nom, $prix, $coordonner,  $idCategorie, $type, $dateDebut, $dateFin);
    $_SESSION['voiture'] = GetVoiture($_SESSION['offreDetails']->id);
    GetOffre($_SESSION['offreDetails']->id);
}
$categories = getCategoriesByType($_SESSION['offreDetails']->idTypeOffre);
$listCarburants = ["Essence", "Diesel", "Hybride", "Electrique"];
$tractions = ["Avant", "Arriere", "4x4"];
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Modification d'offre - Autorius</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
    <link rel="stylesheet" href="css/offreEdit.css">
</head>
<?php
include '_headerBar.php';
?>
<!-- PRE LOADER -->
<section class="preloader">
    <div class="spinner">
        <span class="spinner-rotate"></span>
    </div>
</section>
<section style="background: linear-gradient(135deg, #fff, #ca2929); ">
    <form class='form' method="POST">
        <h1>
            Modifications de l'offre
        </h1>
        <span class='close-btn'><a style="color: white;" href="index.php">x</a></span>
        <br>
        <div class="container text-center">
            <div class="row justify-content-evenly">
                <!--- Left --->
                <div class="col-6 col-sm-4">
                    <div class='input-box'>
                        <label class='form-label'>Nom</label>
                        <input class='form-input' value="<?php echo $_SESSION['offreDetails']->nom; ?>" required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder="Nom de l'offre" />
                    </div>
                    <div class='input-box'>
                        <label class='form-label'>Prix</label>
                        <input required pattern="^[0-9]+$" name="prix" title="un chiffre est requis" type='number' min="0" class='form-input' value="<?php echo $_SESSION['offreDetails']->prix; ?>" placeholder="Prix de l'offre" />
                    </div>
                    <div class='input-box'>
                        <label class='form-label'>Adresse</label>
                        <input class='form-input' value="<?php echo $_SESSION['offreDetails']->coordonner; ?>" required name='coordonner' />
                    </div>
                    <div class='input-box'>
                        <label class='form-label'>Date de début</label>
                        <input class='form-input' value="<?php echo date('Y-m-d\TH:i', strtotime($_SESSION['offreDetails']->dateDebut)); ?>" required name='dateDebut' type="datetime-local" />
                    </div>
                    <div class='input-box'>
                        <label class='form-label'>Date de fin</label>
                        <input class='form-input' value="<?php echo date('Y-m-d\TH:i', strtotime($_SESSION['offreDetails']->dateFin)); ?>" required name='dateFin' type="datetime-local" />
                    </div>
                </div>
                <!--- Center --->
                <div class="col-6 col-sm-4">
                    <div class='input-box'>
                        <span class='form-label'>Année de fabrication</span>
                        <input required type='number' pattern="^[0-9]+$" value="<?php echo $_SESSION['voiture']->annee ?>" title=" seulement des chiffres entre 1980 et 2023" min="1980" max="2023" name='annee' placeholder='Entrez la date de fabrication'>
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Couleur</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" value="<?php echo $_SESSION['voiture']->couleur ?>" title="Seulement des lettres" name='couleur' placeholder='Entrez la couleur' />
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Marque</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" value="<?php echo $_SESSION['voiture']->marque ?>" title="Seulement des lettres" name='marque' placeholder='Entrez la marque de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Modèle</span>
                        <input required type='text' pattern="^[a-zA-Z0-9 ]+$" value="<?php echo $_SESSION['voiture']->modele ?>" title="Seulement des lettres" name='modele' placeholder='Entrez le modèle de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Catégorie de voiture</span>
                        <select required name="categorie">
                            <?php
                            print_r($categories);
                            foreach ($categories as $categorie) {
                                if ($categorie->id == $_SESSION['offreDetails']->idCategorieOffre) {
                                    echo "<option selected value=$categorie->id>$categorie->nom</option>";
                                } else {
                                    echo "<option value=$categorie->id>$categorie->nom</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Odomètre</span>
                        <input required type='number' pattern="^[0-9]+$" value="<?php echo $_SESSION['voiture']->odometre ?>" min="0" title=" seulement des chiffres" name='odometre' placeholder='Entrez odomètre du véhicule' />
                    </div>
                </div>
                <div class="col-6 col-sm-4" style="padding-bottom: 2rem;">
                    <div class='input-box'>
                        <span class='form-label'>Type de consomation</span>
                        <select required name="carburant">
                            <?php

                            foreach ($listCarburants as $c) {
                                if ($c == $_SESSION['voiture']->carburant) {
                                    echo "<option selected value='$c'>$c</option>";
                                } else {
                                    echo "<option value='$c'>$c</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Portes</span>
                        <input required pattern="^[0-9]+$" value="<?php echo $_SESSION['voiture']->nombrePorte ?>" title=" un chiffre est requis" type="number" min="0" name='porte' placeholder='Entrez le nombres de portes' />
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Sieges</span>
                        <input required pattern="^[0-9]+$" value="<?php echo $_SESSION['voiture']->nombreSiege ?>" title="un chiffre est requis" type='number' min="0" name='siege' placeholder='Entrez le nombres de sièges' />
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Traction</span>
                        <select required name="traction">
                            <?php
                            foreach ($tractions as $traction) {
                                if ($traction == $_SESSION['voiture']->traction) {
                                    echo "<option selected value='$traction'>$traction</option>";
                                } else {
                                    echo "<option value='$traction'>$traction</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>Description</span>
                        <textarea required patte name="description"><?php echo $_SESSION['voiture']->description ?></textarea>
                    </div>
                    <div class='input-box'>
                        <span class='form-label'>État du véhicule</span>
                        <select required name="accidente">
                            <?php
                            if ($_SESSION['voiture']-> accidente == 1) {
                                echo "<option selected value=0>Accidenté</option>";
                                echo "<option value=0>Non-Accidenté</option>";
                            } else {
                                echo "<option value=1>Accidenté</option>";
                                echo "<option selected value=0>Non-Accidenté</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-evenly">
                <div class="col-6 col-sm-4">
                    <a href="mesOffres.php" class="btn">Retour</a>
                </div>
                <div class="col-6 col-sm-4"></div>
                <div class="col-6 col-sm-4">
                    <button class='btn' type='submit'>
                        Confirmer les changements
                    </button>
                </div>
            </div>
        </div>
        </div>
        <br>
    </form>
</section>
<!-- SCRIPTS -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</body>

</html>