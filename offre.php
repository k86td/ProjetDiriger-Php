<?php
session_start()
?>

<!DOCTYPE html>
<html lang="fr">
<head>

     <title>Offres - Autorius</title>

     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=Edge">
     <meta name="description" content="">
     <meta name="keywords" content="">
     <meta name="author" content="">
     <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

     <link rel="stylesheet" href="css/bootstrap.min.css">
     <link rel="stylesheet" href="css/font-awesome.min.css">
     <link rel="stylesheet" href="css/styleHome.css">
</head>
<?php
include '_headerBar.php';
?>

<body>
    <h4>🚧 en construction 🚧</h4>
    <div class="container">
        <div class="main-content">
            <?php 
                include 'requete.php';

                $payload = MakeRequest("/Voiture/" . $_GET["id"], "GET");

                echo "<b>Couleur: </b>" . $payload["couleur"] . "<br>";
                echo "<b>Marque: </b>" . $payload["marque"] . "<br>";
                echo "<b>Odometre: </b>" . $payload["odometre"] . " km" . "<br>";
                echo "<b>Type Vehicule: </b>" . $payload["typeVehicule"] . "<br>";
                echo "<b>Nombre de porte: </b>" . $payload["nombrePorte"] . "<br>";
                echo "<b>Nombre de siege: </b>" . $payload["nombreSiege"] . "<br>";
                echo "<b>Traction: </b>" . $payload["traction"] . "<br>";
                echo "<b>Description: </b>" . $payload["description"] . "<br>";
                if ($payload["accidente"])
                    echo "<b>💥 Cette voiture a ete accidente.</b>" . "<br>";
            ?>
        </div>
    </div>
    <script src="js/custom.js"></script>
</body>
</html>