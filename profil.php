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

$users= json_decode(GetUser($_SESSION['email']->id),true);

?>
    <div class='form-container'>
        <div class='form-content-right'>
            <form class='form' method="POST">
                <h1>
                    Les informations de votre profile
                </h1>
                <br>
                <h4> Vouillez changer vos information au besoin <h4>
                  <div class='form-inputs'>
                    <label class='form-label'>Prenom</label>
                    <input class='form-input' value="<?php echo $users['prenom']; ?>"  required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='prenom' placeholder='Entrez votre prenom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Nom</label>
                    <input class='form-input' value="<?php echo $users['nom']; ?>" required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder='Entrez votre nom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Adresse</label>
                    <input class='form-input' value="<?php echo $users['adresse']; ?>" required type='text' pattern="^[a-zA-Z0-9- ]+$" title="Seulement des lettres et chiffre" name='adresse' placeholder='Entrez votre Adresse' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Telephone</label>
                    <input class='form-input' value="<?php echo $users['telephone']; ?>" required type='text' pattern="^[]*[(][0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" title="(999)-999-9999" name='telephone' placeholder='Entrez votre Telephone' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Email</label>
                    <input class='form-input' value="<?php echo $users['email']; ?>" required type='email' name='email' placeholder='Enter your email' />
                </div>
                <!-- <div class='form-inputs'>
                    <label class='form-label'>Mot de passe</label>
                    <input class='form-input' required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password' placeholder='Enter your password' />
                </div> -->
                <div>
                    <form method="POST" name="addVendeur" id="AddVendeur">
                        <button type="submit" value="<?php echo $_SESSION['email']->id?>" class="form-input-btn" name="addVendeur" id="addVendeur">Devenir vendeur</button>
                    </form>
                </div>
                <button class='form-input-btn' name='edit' type='Inscription'>
                    Sauvegarder les changements
                </button>
                <a href="index.php" class="delete-btn">Revenir</a>
                <br>
                <?php



                //include 'bd.php';
                if ($_SERVER['REQUEST_METHOD'] == "POST")
                {
                    if(isset($_POST['addVendeur'])){
                        CreateVendeur($_POST['addVendeur']);
                    }
                    else{
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $adresse = $_POST['adresse'];
                    $telephone = $_POST['telephone'];
                    $email = $_POST['email'];



                        $url = 'https://localhost:7103/api/Usager/'.$_SESSION['email']->id;
                        //print_r($url);
                        $tableau = array("nom" =>   $nom,
                        "prenom" => $prenom,
                        "email"=> $email,
                        "telephone"=> $telephone,
                        "adresse"=> $adresse);
                        $json_content = json_encode($tableau);


                        $ch = curl_init();
                        curl_setopt_array($ch, array(
                            CURLOPT_URL => $url,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_POSTFIELDS => $json_content,
                            CURLOPT_TIMEOUT => 30,
                            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                            CURLOPT_CUSTOMREQUEST => "PUT",
                            CURLOPT_HTTPHEADER => array(
                                "cache-control: no-cache",
                                "Content-Type: application/json",
                                "Authorization: Bearer " . $_SESSION['token']
                            ))
                        );

                        $result = curl_exec($ch);
                        if($errno = curl_errno($ch)){
                            $error_message = curl_strerror($errno);
                            echo "Curl error ({$errno}): \n {$error_message}";
                        }

                        curl_close($ch);
                        
                    }
                    
                    

                }

                
                    
                ?>
            </form>
        </div>
    </div>
</body>
</html>