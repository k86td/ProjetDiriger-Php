<?php
session_start();
include 'requete.php';
if (isset($_SESSION['email'])) {
    GetOffresVendeur();
   
} else {
    header('Location: index.php');
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
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">

    <!-- PRE LOADER -->
    <section class="preloader">
        <div class="spinner">
            <span class="spinner-rotate"></span>
        </div>
    </section>


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
                    <li class="active"><a href="index.php">Accueil</a></li>
                    <li><a href="location.php">Offres</a></li>
                    <li><a href="about.php">À propos</a></li>
                    <?php
                    if (isset($_SESSION['email'])) {
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

    <section class="services" id="services">
        <div class="heading">
            <h1> Vos Offres </h1>
        </div>
        <?php
            for ($i = 0; $i < count($_SESSION['offre']); $i++) {
                echo $_SESSION['offre'][$i]->id;
                echo  '<div class="services-container">
                <div class="box">
                    <div class="box-img">
                        <img src="images/chevrolet-cruze.jpg">
                    </div>
                    <p>2018</p>
                    <h3>Chevrolet Cruze rs</h3>
                    <h2>'.$_SESSION['offre'][$i] ->prix .' | par jours</h2>
                    <form method="POST">
                        <button type="submit" value="'.$_SESSION['offre'][$i]->id.'" name="offreDetails">Details</button>
                    </form>
                </div>
                 </div>';
            }
        ?>
    </section>

    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
    if(isset($_POST['offreDetails'])){
        GetOffre($_POST['offreDetails']);
        header('Location: offreDetails.php');
    }
}
?>