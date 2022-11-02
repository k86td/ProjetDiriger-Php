<?php
session_start();
include 'requete.php';
if (isset($_SESSION['email'])) {
    GetOffresVendeur();
    
} else {
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['offreId'])) 
    {
        print_r($_POST);
        GetOffre($_POST['offreId']);
        GetVoiture($_POST['offreId']);
        header('Location:offreEdit.php');
    } 
    else if (isset($_POST['offreOfferts']))
    {
        GetDemandeOffre($_POST['offreOfferts']);
        header('Location:offreofferts.php');
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
</head>

<?php
include '_headerBar.php';
?>

    <section class="services" id="services">
        <div class="heading">
            <h1 style="margin-left: 10px;"> Vos Offres </h1>
        </div>
        <div class="services-container">

            <?php
            
            for ($i = 0; $i < count($_SESSION['offre']); $i++) {
                GetVoiture($_SESSION['offre'][$i]->id);
              
                echo '
                <div class="box">
                    <div class="box-img">
                        <img src="images/chevrolet-cruze.jpg">
                    </div>
                    <p>'. $_SESSION['voiture']->annee.'</p>
                    <h3>'. $_SESSION['voiture']->annee.' '. $_SESSION['voiture']->marque.' '. $_SESSION['voiture']->modele.'</h3>
                    <h2>'.$_SESSION['offre'][$i]->prix.'$ | <span>mois</span></h2>
                    <form action="mesOffres.php" id="'. $_SESSION['offre'][$i]->id.'" method="POST">
                    <button type="submit" id="'. $_SESSION['offre'][$i]->id.'" class="btn" value="' . $_SESSION['offre'][$i]->id . '" name="offreId">Edit</button>
                    <button type="submit"  class="btn" value="' . $_SESSION['offre'][$i]->id . '" name="offreOfferts">Voir les demandes offre</button>
                    </form>
                 </div>';
                 
            }
            ?>
        </div>
    </section>

    <!-- SCRIPTS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>

</body>

</html>

<?php
