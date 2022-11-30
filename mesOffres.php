<?php
session_start();
include 'requete.php';
if (isset($_SESSION['email'])) {
    GetOffresVendeur();
} else {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    if (isset($_POST['offreId'])) {
        GetOffre($_POST['offreId']);
        $data = GetVoiture($_POST['offreId']);
        $_SESSION['voiture'] = $data;
        header('Location:offreEdit.php');

    } else if (isset($_POST['offreOfferts'])) {

        GetDemandeOffre($_POST['offreOfferts']);
        header('Location:offreOfferts.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Offres</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
    <link rel="stylesheet" href="css/offre.css">
    <src link="src/mesOffres.js"/>
</head>

<?php include '_headerBar.php'; ?>

<body>
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
                         <li class="active"><a href="index.php">Accueil</a></li>
                         <li><a href="location.php" style="background-color:DodgerBlue;">Offres</a></li>
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
                              echo '<li><a href="mesOffres.php">Mes Offres</a></li>';
                              echo '<li><a href="listeVendeur.php">Les Vendeurs</a></li>';
                              //print_r(gettype($_SESSION['email']->idRole));
                              if ($_SESSION['email']->idRole == 2) {
                                   echo '<li><a href="listUsers_admin.php">Admin</a></li>';
                              }
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

    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>