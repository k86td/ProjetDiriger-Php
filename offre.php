<!DOCTYPE html>
<html lang="en">
<head>
    <title>Location - Autorius</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="css/location.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
	<script src="js/jquery-3.6.1.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>
    <h4>🚧 en construction 🚧</h4>
    

     <!-- MENU -->
     <section class="navbar custom-navbar navbar-fixed-top" role="navigation">
          <div class="container">

               <div class="navbar-header">
                    <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                         <span class="icon icon-bar"></span>
                    </button>

                    <!-- lOGO TEXT HERE -->
                    <a href="#" class="navbar-brand">Autorius</a>
               </div>

               <!-- MENU LINKS -->
               <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-nav-first">
                         <li class="active"><a href="index.html">Accueil</a></li>
                         <li><a href="location.php">Offres</a></li>
                         <li><a href="about.php">À propos</a></li>
                         <?php
                         if (isset($_SESSION['email'])) {
                              echo '<li><a href="profil.php">Profil</a></li>';
                              echo '<li>
                                        <a class="dropdown">Ajouter une location</a>
                                        <div class="dropdown-content">
                                             <a href="offre_voiture.php">Voiture</a>
                                             <a href="#">Camion</a>
                                             <a href="#">Bateau</a>
                                        </div> 
                                    </li>';
                              echo ' <li><a href="deconnection.php">Se déconnecter</a></li>';
                         } else {
                              echo '<li><a href="login.php">Se connecter</a></li>';
                              echo '<li><a href="inscription.php">Inscription</a></li>';
                         }
                         ?>
                    </ul>
               </div>

          </div>
     </section>
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
</body>
</html>