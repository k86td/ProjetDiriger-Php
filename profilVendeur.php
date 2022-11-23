
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

</head>

<?php
session_start();
include '_headerBar.php';
include 'requete.php';
if(!isset($_SESSION['email'])){
    header('Location:index.php');
}
if (isset($_POST['view_profil']))
{
    $user = json_decode(GetUser($_SESSION['email']->id),true);
    $userPresentId = $user['id'];
    $vendeurId = $_SESSION['vendeur'];


    echo '<br><br><br>';
    echo $userPresentId;
    echo $vendeurId;
    $ratings = GetAllRatings($vendeurId);
    print_r($ratings);
    
    
    $count_r = 0;
    $moyenne_r = 0;
    $verification = '';
    if($ratings != NULL)
    {
        foreach ($ratings as $rating)
        {
        
        $count_r++;
        $moyenne_r += $rating['rating'];
        if($rating['idUsager']==$userPresentId){
            $verification = "Vous ne pouvez pas mettre plus qu'un rating";
        }
        
        }
        if($userPresentId==$vendeurId)
        {
            $verification = "Vous ne pouvez pas mettre un rating en tant que vendeur";
        }
        
        $moyenne_r = ($moyenne_r * 5) / ($count_r * 5);
    }
    
}


?>
<br><br>
<div class="row gutters-sm">
    <div class="col-md-4 mb-3">
        <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column align-items-center text-center">
            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150">
            <div class="mt-3">
                <h4><?php echo $user['nom'].", ". $user['prenom']; ?></h4>
                <p class="text-secondary mb-1">Hote</p>

                <button class="btn btn-outline-primary">Message</button>
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
                        <?php echo $user['nom'].", ". $user['prenom']; ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Email</h6>
                    </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $user['email'];?>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Phone</h6>
                </div>
                <div class="col-sm-9 text-secondary">
                    <?php echo $user['telephone'];?>
                </div>
            </div>

        </div>
    </div>
    <div>Moyenne du Rating : <?php echo $moyenne_r; ?></div>
    <div>Nombre de Ratings : <?php echo $count_r; ?></div>
    <!-- 5 Star Rating -->
    <?php 
        if($verification != ''){
            $submit = 'submit';
        }else{
            $submit = '';
        }
    ?>
    
        <?php 
            if($verification != ''){
                echo '<br><span>'. $verification .'</span>';
            }else{
                echo '<form action="ratingAction.php" method="POST">
                <input type="radio" id="1" name="rating" value="1">
                <label for="1">1</label>
                <input type="radio" id="2" name="rating" value="2">
                <label for="2">2</label>
                <input type="radio" id="3" name="rating" value="3">
                <label for="3">3</label>
                <input type="radio" id="4" name="rating" value="4">
                <label for="4">4</label>
                <input type="radio" id="5" name="rating" value="5">
                <label for="5">5</label> <br>
                <input type="text" name="comentaire">
            <button type="submit" name="rating_s" value='.$vendeurId.'>Sumetre</button>
        </form>';
            }

            // $_SESSION['rating'] = $_POST['rating'];

        ?>
    


</div>

    
</body>
</html>