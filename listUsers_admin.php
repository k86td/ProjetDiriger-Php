<?php

session_start();
include 'requete.php';
$users= GetAllUsers();

?>



<!DOCTYPE html>
<html lang="fr">
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
                         <li><a href="index.php">Accueil</a></li>
                         <li><a href="location.php">Offres</a></li>
                         <li><a href="about.php">À propos</a></li>
                         <?php
                              if(isset($_SESSION['email'])){
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
                                    echo '<li><a href="listUsers_admin.php">Admin</a></li>';
                                    echo ' <li><a href="deconnection.php">Se déconnecter</a></li>';
                              }
                              else{
                                   echo '<li><a href="login.php">Se connecter</a></li>';
                                   echo '<li><a href="inscription.php">Inscription</a></li>';
                                   
                              }
                         ?>
                    </ul>
               </div>

          </div>
     </section>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <br>
                <h4>List de Usagers</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Adresse</th>
                            <th>Role</th>
                            <th>Changer</th>
                            <th>Bloque</th>
                            <th>Supprimer</th>
                        </tr>
                        <?php
                            foreach ($users as $user)
                            {
                                echo "<tr>";
                                echo "<th>". $user['id'] ."\n"."</th>";
                                echo "<th>". $user['nom'] ."\n"."</th>";
                                echo "<th>". $user['prenom'] ."\n"."</th>";
                                echo "<th>". $user['email'] ."\n"."</th>";
                                echo "<th>". $user['telephone'] ."\n"."</th>";
                                echo "<th>". $user['adresse'] ."\n"."</th>";
                                
                                if($user['idRole'] == '2')
                                {
                                    echo "<th>Admin</th>";
                                }
                                else
                                {
                                    echo "<th>User</th>";
                                }
                                ?>
                                
                                
                                <th>hola</th>
                                <th>
                                    <form action='adminAction.php' method='POST'>
                                        <button type='submit' name='user_block' value=<?=$user['id'] ?> class='btn btn-danger'>Block</button>
                                    </form>
                                </th>
                                <th>
                                    <form action='adminActions.php' method='POST'>
                                        <button type='submit' name='user_delete' value=<?=$user['id'] ?> class='btn btn-danger'>Supprimer</button>
                                    </form>
                                </th>
                                
                                <?php
                                echo "<tr>";  
                            }
                        ?>        
                            
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>