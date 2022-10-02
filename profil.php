<?php
session_start();
include 'requete.php';
// include 'config.php';
/*
$email = $_SESSION['email']['email'];
$password = $_SESSION['email']['password'];

$_SESSION['email']= LoginNoToken($email,$password);

$user_id = $_SESSION['email']['id'];
$nom = $_SESSION['email']['nom'];
$prenom = $_SESSION['email']['prenom'];
$email = $_SESSION['email']['email'];
$phone = $_SESSION['email']['telephone'];
$adresse = $_SESSION['email']['adresse'];
$password = $_SESSION['email']['password'];
*/

?>

<!DOCTYPE html>
<html lang="fr">

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
                    <input class='form-input' value="<?php echo $_SESSION['email']['prenom']; ?>"  required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='prenom' placeholder='Entrez votre prenom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Nom</label>
                    <input class='form-input' value="<?php echo $_SESSION['email']['nom']; ?>" required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder='Entrez votre nom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Adresse</label>
                    <input class='form-input' value="<?php echo $_SESSION['email']['adresse']; ?>" required type='text' pattern="^[a-zA-Z0-9- ]+$" title="Seulement des lettres et chiffre" name='adresse' placeholder='Entrez votre Adresse' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Telephone</label>
                    <input class='form-input' value="<?php echo $_SESSION['email']['telephone']; ?>" required type='text' pattern="^[]*[(][0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" title="(999)-999-9999" name='telephone' placeholder='Entrez votre Telephone' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Email</label>
                    <input class='form-input' value="<?php echo $_SESSION['email']['email']; ?>" required type='email' name='email' placeholder='Enter your email' />
                </div>
                <!-- <div class='form-inputs'>
                    <label class='form-label'>Mot de passe</label>
                    <input class='form-input' required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password' placeholder='Enter your password' />
                </div> -->
                <button class='form-input-btn' type='Inscription'>
                    Sauver les changements
                </button>
                <a href="index.php" class="delete-btn">Revenir</a>
                <br>
                <?php
              
                    
                
                //include 'bd.php';
                if ($_SERVER['REQUEST_METHOD'] == "POST") 
                {
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $adresse = $_POST['adresse'];
                    $telephone = $_POST['telephone'];
                    $email = $_POST['email'];

                    
                        
                        $url = 'https://localhost:7103/api/Usager/'.$_SESSION['email']['id'];
                        print_r($url);
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
                      
                    //    header('Location: confirmation.php');
                    
                    
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>