<?php
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>

     <title>Home - Autorius</title>

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
                         <li class="active"><a href="index.html">Accueil</a></li>
                         <li><a href="location.php">Offres</a></li>
                         <li><a href="about.php">À propos</a></li>
                         <?php
                         if (isset($_SESSION['email'])) {
                              echo '<li><a href="profil.php">Profil</a></li>';
                              echo '<li>
                                        <a class="dropdown">Ajouter une location</a>
                                        <div class="dropdown-content">
                                             <a href="#">Voiture</a>
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

     <!-- HOME -->
     <section id="home">
          <div class="caption" style="background: url(images/homeAuto.jpg) no-repeat; height: 700px;">
               <div class="container">
                    <div class="col-md-6 col-sm-12">
                         <h1>Title 1</h1>
                         <h3>Quote 1</h3>
                         <a href="location.php" class="section-btn btn btn-default">Offres</a>
                    </div>
               </div>
          </div>
          </div>
     </section>

     <main>
          <section>
               <div class="container">
                    <div class="row">
                         <div class="col-md-12 col-sm-12">
                              <div class="text-center">
                                   <h2>À propos de nous</h2>
                                   <br>
                                   <p class="lead"></p>
                              </div>
                         </div>
                    </div>
               </div>
          </section>
     </main>

     <!-- CONTACT -->
     <section id="contact">
          <div class="container">
               <div class="row">
                    <div class="col-md-6 col-sm-12">
                         <form id="contact-form" role="form" action="" method="post">
                              <div class="section-title">
                                   <h2>Contactez-nous</h2>
                              </div>

                              <div class="col-md-12 col-sm-12">
                                   <input type="text" class="form-control" placeholder="Entrez votre nom complet" name="name" required>

                                   <input type="email" class="form-control" placeholder="Entrez votre adresse courriel" name="email" required>

                                   <textarea class="form-control" rows="6" placeholder="Message" name="message" required></textarea>
                              </div>

                              <div class="col-md-4 col-sm-12">
                                   <input type="submit" class="form-control" name="message" value="Envoyer">
                              </div>

                         </form>
                    </div>

                    <div class="col-md-6 col-sm-12">
                         <div class="contact-image">
                              <img src="images/homeContact.jpg" class="img-responsive" alt="Image contact">
                         </div>
                    </div>

               </div>
          </div>
     </section>

     <!-- FOOTER -->
     <footer id="footer">
          <div class="container">
               <div class="row">
               </div>
          </div>
     </footer>

     <!-- SCRIPTS -->
     <script src="js/jquery.js"></script>
     <script src="js/bootstrap.min.js"></script>
     <script src="js/custom.js"></script>

</body>

</html>