<?php
session_start();
include 'requete.php';

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['refuser'])) {
    
    DeleteOffreDemande($_SESSION['offreid'], $_POST['refuser']);
    GetDemandeOffre($_SESSION['offreid']);
    // VoidAuthorizedPayments($_POST['accepter']);
}
else
{
    if(isset($_SESSION['offreid'])){
        GetDemandeOffre($_SESSION['offreid']);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
    <link rel="stylesheet" href="css/offre.css">
    <script src="dist/main.js"></script>
    <title>Demande Offre</title>
</head>

<body id="top" data-spy="scroll" data-target=".navbar-collapse" data-offset="50">
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
            <?php  if($_SESSION['demandeOffre'] == null){ echo ' <h1> Aucune demande de location sur ce véhicule à été effectuée actuellement </h1>';}else{echo'<h1> Vos offres recu pour cette voiture </h1>';} ?>

            <div class="services-container">
                <?php
                if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['accepter'])) 
                {
                    //print_r($_SESSION['demandeOffre']);
                    AccepterDemande($_SESSION['offreid'], $_POST['accepter']);
                    header('Location: offreOfferts.php');
                } 
                else
                {
                    if($_SESSION['demandeOffre'] == null)
                    {

                    }
                    else
                    {
                        echo '<input hidden id="offreId" type="text" value="' . $_SESSION['demandeOffre'][0]->idOffre . '">';
                        for ($i = 0; $i < count($_SESSION['demandeOffre']); $i++) {
                            $_SESSION['offreid'] = $_SESSION['demandeOffre'][$i]->idOffre;
                            GetUser($_SESSION['demandeOffre'][$i]->idUsager);
                            if($_SESSION['demandeOffre'][$i]->accepter == null)
                            {
                                echo '
                                <div class="box">
                                    <form method="POST">
                                    <div>' . $_SESSION['User']->prenom . ' vous a envoyez une offre sur cette location.</div>
                                    <br>
                                        
                                        <button type="submit" class="btn" value="' . $_SESSION['demandeOffre'][$i]->idUsager . '" name="refuser">Refuser</button>
                                        <button type="submit" class="btn" value="' . $_SESSION['demandeOffre'][$i]->idUsager . '" name="accepter">Accepter</button>
                                    </form>
                                </div>';
                            }
                            else
                            {
                                echo '
                                <div class="box">
                                    <div> vous avez accepter la demande de ' . $_SESSION['User']->prenom . ' une confirmation de transaction seras administrée sous peu.</div>
                                </div>';
                            }
                        }
                    }
                  
                }
                ?>
            </div>
        </div>

    </section>

    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>