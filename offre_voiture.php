<?php
session_start();
include 'requete.php';
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    //echo $_SESSION['email']['id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //include 'requete.php';
    $target_dir = "images/imagesOffres/";
    $img = $_FILES["imageInput"]["tmp_name"];
    $target_file = $target_dir . $_FILES["imageInput"]["name"];
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $randomFilename = substr(md5(mt_rand(0, 1000)), 0, 21) . '-' . $_FILES["imageInput"]["name"];
    $target_file_dir = $target_dir . $randomFilename;
    $target_file_bd = $randomFilename;
    //echo "target_file_dir: ". $target_file_dir;
    //echo "target_file_bd: ". $target_file_bd; 

    if ($_FILES["imageInput"]["size"] > 500000000) {
        echo "<script> alert('Sorry, your file is too large.') </script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) 
    {
        echo "<script> alert('Sorry, your file was not uploaded.') </script>";
      } 
      else
       {
        if (move_uploaded_file($_FILES["imageInput"]["tmp_name"], $target_file_dir)) {
            CreateVoiture($_POST['annee'], $_POST['couleur'], $_POST['marque'], $_POST['modele'], $_POST['type_voiture'], $_POST['odometre'], $_POST['type'], $_POST['porte'], $_POST['siege'], $_POST['traction'], $_POST['description'], $_POST['etat'], $_POST['prix'], $_POST['postal'], $_POST['dateDebut'], $_POST['dateFin'], $target_file_bd);
            echo "<script> console.debug('The file ". htmlspecialchars( basename( $_FILES["imageInput"]["name"])). " has been uploaded."."') </script>";
           // header('Location: mesOffres.php');
        } else {
          echo "<script> alert('Sorry, there was an error uploading your file.') </script>";
        }
      }
}


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['test'])){
    //echo $_POST['adresse'];
    GetCoordinate($_POST['adresse']);
}


?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/form.css" rel="stylesheet">
    <src link="src/createOffre.js">
</head>

<body>
    <script>
        function preview() {
            let image = document.getElementById('imageInput').files[0];
            img.src = URL.createObjectURL(event.target.files[0]);
            console.debug(image);
        }
    </script>
    <div class='container'>
        <span class='close-btn'><a style="color: white;" href="index.php">x</a></span>
     
        <div class='form-content-right'>
            <div class="title">Veuillez entrez les informations de votre véhicule</div>
            <?php 
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            echo '<div style="color: green;"> Votre location à bien été créé. Vous pouvez cliquer sur le lien pour retourner au menu principal et aller sur mes offres pour voir votre location : <a href="index.php">ici</a> </div>';
        }
        ?>
            <form class='form' method="POST" enctype="multipart/form-data">
                <div class="user-details">
                   
                    <div class='input-box'>
                        <span class='details'>Année de fabrication</span>
                        <input required type='number' pattern="^[0-9]+$" title=" seulement des chiffres entre 1980 et 2023" min="1980" max="2023" name='annee' placeholder='Entrez la date de fabrication'>
                    </div>
                    <div class='input-box'>
                        <span class='details'>Couleur</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='couleur' placeholder='Entrez la couleur' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Marque</span>
                        <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='marque' placeholder='Entrez la marque de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Modèle</span>
                        <input required type='text' pattern="^[a-zA-Z0-9 ]+$" title="Seulement des lettres" name='modele' placeholder='Entrez le modèle de votre vehicule' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Type de voiture</span>
                        <select required name="type_voiture">
                            <option value=1>Vus</option>
                            <option value=2>Sport</option>
                            <option value=3>Berline</option>
                            <option value=4>Hatchback</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='details'>odomètre</span>
                        <input required type='number' pattern="^[0-9]+$" min="0" title=" seulement des chiffres" name='odometre' placeholder='Entrez odomètre du véhicule' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Type de consomation</span>
                        <select required name="type">
                            <option value="Electrique">Électrique</option>
                            <option value="Essence">Essence</option>
                            <option value="Hybride">Hybride</option>
                            <option value="Diesel">Diesel</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='details'>Porte</span>
                        <input required pattern="^[0-9]+$" title=" un chiffre est requis" type="number" min="0" name='porte' placeholder='Entrez le nombres de portes' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Siege</span>
                        <input required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='siege' placeholder='Entrez le nombres de sièges' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Traction</span>
                        <select required name="traction">
                            <option value="Avant">Avant</option>
                            <option value="Arrière">Arrière</option>
                            <option value="4x4">4 roue motrices</option>
                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='details'>Description</span>
                        <textarea required patte name="description">

                    </textarea>
                    </div>
                    <div class='input-box'>
                        <span class='details'>État du véhicule</span>
                        <select required name="etat">
                            <option value="false">non-accidenté</option>
                            <option value="true">Accidenté</option>

                        </select>
                    </div>
                    <div class='input-box'>
                        <span class='details'>prix</span>
                        <input required pattern="^[0-9]+$" title="un chiffre est requis" type='number' min="0" name='prix' placeholder='Entrez le prix par jours pour la location' />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Date de début</span>
                        <input required name='dateDebut' type="datetime-local" />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Date de fin</span>
                        <input required name='dateFin' type="datetime-local" />
                    </div>
                    <div class='input-box'>
                        <span class='details'>Votre Adresse</span>
                        <input required type='text' title="chiffre,nom de la rue coller et pas de caractere speciaux,ville coller" pattern="^[0-9]+[,]+[A-za-z-]+[,]+[A-Z-a-z-]+$" title="Seulement des lettres" name='postal' placeholder='Entrez votre adresse' />
                    </div>

                    <div class="input-box">
                        <span class="details">Apercu de l'image</span>
                        <div class="image-preview" id="imagePreview">
                            <img src="images/placeholder-image.png" alt="" class="image-preview__image" id="img">
                        </div>
                    </div>
                    <div class="input-box">
                        <span class="details"> Ajouter une image </span>
                        <div class="button" onclick="document.getElementById('imageInput').click()">Choisir une image</div>
                        <input type="file" name="imageInput" id="imageInput" style="display:none;" onchange="preview()">
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