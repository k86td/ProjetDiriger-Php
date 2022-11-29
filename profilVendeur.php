<!DOCTYPE html>
<html lang="fr">

<head>

    <title>Autorius</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/styleHome.css">
    <link rel="stylesheet" href="C:/fontawesome-free-5.13.0-web/css/all.css">
    <link rel="stylesheet" href="css/rating.css">

</head>

<body>
    <?php
    session_start();
    include '_headerBar.php';
    include 'requete.php';
    if (!isset($_SESSION['email'])) {
        header('Location:index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['rating1'])) {
        // echo $_SESSION['view_profil']->id;
        // echo $_SESSION["email"]->id;
        // echo  $_POST['rating1'];
        // echo $_POST['commentaire'];

        AddRating($_SESSION['view_profil']->id, $_SESSION["email"]->id, $_POST['rating1'], $_POST['commentaire']);
        $_SESSION['rating'] = GetRating($_SESSION['view_profil']->id);
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['view_profil'])) {
        $_SESSION['view_profil'] = json_decode(GetUser($_POST['view_profil']));
        $_SESSION['rating'] = GetRating($_SESSION["User"]->id);
    }

    // $user = json_decode(GetUser($_SESSION['email']->id), true);
    //$userPresentId = $user['id'];

    $vendeurId = $_SESSION['vendeur'];


    echo '<br><br><br>';
    //print_r($user);
    //echo $userPresentId;
    //echo $vendeurId;
    $ratings = GetAllRatings($vendeurId);
    //print_r($ratings);

    ?>
    <br><br>
    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <?php echo ' <img src="images/imagesProfil/' . $_SESSION['view_profil']->imageProfil . '" alt="Admin" class="rounded-circle" width="150">' ?>
                        <div class="mt-3">
                            <h4><?php echo $_SESSION['view_profil']->nom . ", " . $_SESSION['view_profil']->prenom; ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nom complet</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['view_profil']->nom . ", " . $_SESSION['view_profil']->prenom; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['view_profil']->email; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $_SESSION['view_profil']->telephone; ?>
                        </div>
                    </div>

                </div>
            </div>
            <div>Moyenne du Rating : 
            <?php
            $moyenne = 0;
             for ($i = 0; $i < count($_SESSION['rating']); $i++) {
                $moyenne = $moyenne + $_SESSION['rating'][$i]->rating;
             }
             if($moyenne == 0) 
             {
                
                echo'<img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>';
             }
            else
            {
                $moyenne = floor($moyenne / count($_SESSION['rating'])) ;
                if( $moyenne == 1)
                {
                   echo'<img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>';
                }
                else if($moyenne == 2)
                {
                   echo'<img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>';
                }
                else if($moyenne == 3)
                {
                   echo'<img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>';
                }
                else if($moyenne == 4)
                {
                   echo'<img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"></div>';
                }
                else if($moyenne == 5)
                {
                   echo'<img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"></div>';
                }
                else if ($moyenne == 0)
                {
                   echo'<img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>';
                }
            }
            
            ?>
             <div>Nombre de Rating : <?php echo count($_SESSION['rating']); ?> </div> 
            <br> <br> <br> <br>
            </div>
            <br> <br> <br> <br>
            <!-- 5 Star Rating -->
            <br>
            <?php
            if ($_SESSION["User"]->id == $_SESSION['email']->id) {
            } else if (count($_SESSION['rating']) > 0) {
                $deja_commentaire = false;
                for ($i = 0; $i < count($_SESSION['rating']); $i++) {

                    if ($_SESSION['rating'][$i]->idUsager == $_SESSION['email']->id) {
                        $deja_commentaire = true;
                    }
                }
                if ($deja_commentaire == true) {
                } else {
                    echo '<form class="form" method="POST">
                        <div class="title">Moyenne de votre évaluation</div>
                        <div class="rating-css">
                            <div class="star-icon">
                                <input type="radio" name="rating1" id="rating1" value="1">
                                <label for="rating1" class="fa fa-star"></label>
                                <input type="radio" name="rating1" id="rating2" value="2">
                                <label for="rating2" class="fa fa-star"></label>
                                <input type="radio" name="rating1" id="rating3" value="3">
                                <label for="rating3" class="fa fa-star"></label>
                                <input type="radio" name="rating1" id="rating4" value="4">
                                <label for="rating4" class="fa fa-star"></label>
                                <input type="radio" name="rating1" id="rating5" value="5">
                                <label for="rating5" class="fa fa-star"></label>
                            </div>
                            <textarea name="commentaire" placeholder="ecrivez votre commentaire ici"></textarea>
                            <br>
                            <button name="submit" type="submit">envoyez</button>
                            
                        </div>
                    </form>';
                }
            } else {
                echo '<form class="form" method="POST">
                    <div class="title">Moyenne de votre évaluation</div>
                    <div class="rating-css">
                        <div class="star-icon">
                            <input type="radio" name="rating1" id="rating1" value="1">
                            <label for="rating1" class="fa fa-star"></label>
                            <input type="radio" name="rating1" id="rating2" value="2">
                            <label for="rating2" class="fa fa-star"></label>
                            <input type="radio" name="rating1" id="rating3" value="3">
                            <label for="rating3" class="fa fa-star"></label>
                            <input type="radio" name="rating1" id="rating4" value="4">
                            <label for="rating4" class="fa fa-star"></label>
                            <input type="radio" name="rating1" id="rating5" value="5">
                            <label for="rating5" class="fa fa-star"></label>
                        </div>
                        <textarea name="commentaire" placeholder="ecrivez votre commentaire ici"></textarea>
                        <br>
                        <button name="submit" type="submit">envoyez</button>
                        
                    </div>
                </form>';
            }

            ?>
            <br>
        </div>
        <div>

            <?php
            for ($i = 0; $i < count($_SESSION['rating']); $i++) {

                GetUser($_SESSION['rating'][$i]->idUsager);
                if ($_SESSION['rating'][$i]->rating == 1) {
                    echo ' <div class="commentaire">
                        <div class="title-commentaire">' . $_SESSION["User"]->prenom . ' ' . $_SESSION["User"]->nom . '  <img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>
                        <p class="texte-commentaire">' . $_SESSION['rating'][$i]->conversation . '</p>
                        
                        </div><br>';
                } else if ($_SESSION['rating'][$i]->rating == 2) {
                    echo ' <div class="commentaire">
                    <div class="title-commentaire">' . $_SESSION["User"]->prenom . ' ' . $_SESSION["User"]->nom . '  <img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>
                    <p class="texte-commentaire">' . $_SESSION['rating'][$i]->conversation . '</p>
                    
                    </div><br>';
                } else if ($_SESSION['rating'][$i]->rating == 3) {
                    echo ' <div class="commentaire">
                    <div class="title-commentaire">' . $_SESSION["User"]->prenom . ' ' . $_SESSION["User"]->nom . '  <img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"><img class="image"src="images/rating_image_empty.png"></div>
                    <p class="texte-commentaire">' . $_SESSION['rating'][$i]->conversation . '</p>
                    
                    </div><br>';
                } else if ($_SESSION['rating'][$i]->rating == 4) {
                    echo ' <div class="commentaire">
                    <div class="title-commentaire">' . $_SESSION["User"]->prenom . ' ' . $_SESSION["User"]->nom . '  <img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image_empty.png"></div>
                    <p class="texte-commentaire">' . $_SESSION['rating'][$i]->conversation . '</p>
                    
                    </div><br>';
                } else if ($_SESSION['rating'][$i]->rating == 5) {
                    echo ' <div class="commentaire">
                    <div class="title-commentaire">' . $_SESSION["User"]->prenom . ' ' . $_SESSION["User"]->nom . '  <img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"><img class="image"src="images/rating_image.png"></div>
                    <p class="texte-commentaire">' . $_SESSION['rating'][$i]->conversation . '</p>
                    
                    </div><br>';
                }
            }
            ?>
        </div>


</html>
<img src="">
<img src="">