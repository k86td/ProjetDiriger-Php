<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //echo $_SESSION['email']['id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include 'requete.php';

    CreateVoiture($_POST['annee'], $_POST['couleur'], $_POST['marque'], $_POST['modele'], $_POST['type_voiture'], $_POST['odometre'], $_POST['type'], $_POST['porte'], $_POST['siege'], $_POST['traction'], $_POST['description'], $_POST['etat'], $_POST['prix'], $_POST['postal'], $_POST['dateDebut'], $_POST['dateFin']);
    //header('Location: location.php');
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/form.css" rel="stylesheet">
</head>

<body>

    <div class='container'>
        <span class='close-btn'><a style="color: white;" href="index.php">x</a></span>
        <div class='form-content-right'>
            <div class="title">Veuillez entrez les informations de votre véhicule</div>
            <form class='form' method="POST">
                <div class="user-details">
                    <div class='input-box'>
                        <span class='details'>Année de fabrication</span>
                        <input required type='number' pattern="^[0-9]+$" title=" seulement des chiffres entre 1980 et 2023" min="1980" max="2023" name='annee' placeholder='Entrez la date de fabrication'>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Couleur</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='couleur' placeholder='Entrez la couleur' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Marque</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='marque' placeholder='Entrez la marque de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span  class='details'>Modèle</span>
                        <input required type='text' pattern="^[a-zA-Z0-9 ]+$" title="Seulement des lettres" name='modele' placeholder='Entrez le modèle de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Type de voiture</span>
                        <select required name="type_voiture">
                            <option value=1>Vus</option>
                            <option value=2>Sport</option>
                            <option value=3>Berline</option>
                            <option value=4>Hatchback</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >odomètre</span>
                        <input required type='number' pattern="^[0-9]+$" min="0" title=" seulement des chiffres" name='odometre' placeholder='Entrez odomètre du véhicule' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Type de consomation</span>
                        <select required name="type">
                            <option value="electrique">Électrique</option>
                            <option value="essence">Essence</option>
                            <option value="hybride">Hybride</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Porte</span>
                        <input required pattern="^[0-9]+$" title=" un chiffre est requis" type="number" min="0" name='porte' placeholder='Entrez le nombres de portes' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Siege</span>
                        <input required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='siege' placeholder='Entrez le nombres de sièges' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Traction</span>
                        <select required name="traction">
                            <option value="avant">Avant</option>
                            <option value="Arriere">Arrière</option>
                            <option value="4 roue motrices">4 roue motrices</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Description</span>
                        <textarea required patte name="description">

                    </textarea>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >État du véhicule</span>
                        <select required name="etat">
                            <option value="false">non-accidenté</option>
                            <option value="true">Accidenté</option>

                        </select>
                    </div>
                    <div class='input-box'>
                        <span  class='details' >prix</span>
                        <input required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='prix' placeholder='Entrez le prix par jours pour la location' />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Date de début</span>
                        <input required name='dateDebut' type="datetime-local" />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Date de fin</span>
                        <input required name='dateFin' type="datetime-local" />
                    </div>
                    <div class='input-box'>
                        <span  class='details' >Votre Code Postal</span>
                        <input required type='text' pattern="^[a-zA-Z0-9]+$" title="Seulement des lettres" name='postal' placeholder='Entrez votre code postal' />
                    </div>
                    <button class='button' type='Inscription'>
                        Ajouter l'offre
                    </button>
                    <br>
                </div>
            </form>
        </div>
    </div>
</body>