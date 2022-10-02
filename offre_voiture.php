<?php
       session_start();
        if ($_SERVER['REQUEST_METHOD'] == "GET")
        {
            //echo $_SESSION['email']['id'];
        }
      
       if ($_SERVER['REQUEST_METHOD'] == "POST")
        {
          include 'requete.php';
          /*
          echo $_POST['couleur'];
          echo $_POST['marque'];
          echo $_POST['modele'];
          echo $_POST['type_voiture'];
          echo $_POST['odometre'];
          echo $_POST['type'];
          echo $_POST['porte'];
          echo $_POST['siege'];
          echo $_POST['traction'];
          echo $_POST['description'];
          echo $_POST['etat'];
          echo $_POST['prix'];
          */
          
          CreateVoiture($_POST['couleur'],$_POST['marque'],$_POST['modele'],$_POST['type_voiture'], $_POST['odometre'],$_POST['type'],$_POST['porte'],$_POST['siege'],$_POST['traction'],$_POST['description'],$_POST['etat'],$_POST['prix']);
          header('Location: location.php');
        }
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
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
                    Veuillez entrez vos informations
                </h1>
                <div class='form-inputs'>
                    <label class='form-label'>Couleur</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='couleur' placeholder='Entrez la couleur' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Marque</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='marque' placeholder='Entrez la marque de votre vehicule' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Modèle</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z0-9 ]+$" title="Seulement des lettres" name='modele' placeholder='Entrez le modèle de votre vehicule' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Type de voiture</label>
                    <select required name="type_voiture" >
                        <option value=1>Vus</option>
                        <option value=2>Sport</option>
                        <option value=3>Berline</option>
                        <option value=4>Hatchback</option>
                    </select>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>odomètre</label>
                    <input class='form-input' required type='number' pattern="^[0-9]+$" min="0" title=" seulement des chiffres" name='odometre' placeholder='Entrez odomètre du véhicule' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Type de consomation</label>
                    <select required name="type" >
                        <option value="electrique">Électrique</option>
                        <option value="essence">Essence</option>
                        <option value="hybride">Hybride</option>
                    </select>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Porte</label>
                    <input class='form-input' required pattern="^[0-9]+$" title=" un chiffre est requis" type="number" min="0"  name='porte' placeholder='Entrez le nombres de portes' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Siege</label>
                    <input class='form-input' required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='siege' placeholder='Entrez le nombres de sièges' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Traction</label>
                    <select required name="traction" >
                        <option value="avant">Avant</option>
                        <option value="Arriere">Arrière</option>
                        <option value="4 roue motrices">4 roue motrices</option>
                    </select>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Description</label>
                    <textarea required patte name="description">

                    </textarea>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>État du véhicule</label>
                    <select required name="etat" >
                        <option value="false">non-accidenté</option>
                        <option value="true">Accidenté</option>
                       
                    </select>
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>prix</label>
                    <input class='form-input' required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='prix' placeholder='Entrez le prix par jours pour la location' />
                </div>
                <button class='form-input-btn' type='Inscription'>
                    Enregistrez
                </button>
                <br>
            </form>
        </div>
    </div>
</body>