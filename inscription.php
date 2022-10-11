<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <div class='form-container'>
        <span class='close-btn'><a style="color: white;" href="index.php">x</a></span>
        <div class='form-content-left'>
            <img class='form-img' src='images/image_favicon.png' alt='voiture' />
        </div>
        <div class='form-content-right'>
            <form class='form' method="POST">
                <h1>
                    Veuillez entrez vos informations
                </h1>
                <div class='form-inputs'>
                    <label class='form-label'>Prenom</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='prenom' placeholder='Entrez votre prenom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Nom</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder='Entrez votre nom' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Adresse</label>
                    <input class='form-input' required type='text' pattern="^[a-zA-Z0-9- ]+$" title="Seulement des lettres et chiffre" name='adresse' placeholder='Entrez votre Adresse' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Telephone</label>
                    <input class='form-input' required type='text' pattern="^[]*[(][0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" title="(999)-999-9999" name='telephone' placeholder='Entrez votre Telephone' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Email</label>
                    <input class='form-input' required type='email' name='email' placeholder='Enter your email' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Password</label>
                    <input class='form-input' required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password' placeholder='Enter your password' />
                </div>
                <div class='form-inputs'>
                    <label class='form-label'>Confirm Password</label>
                    <input class='form-input' required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password2' placeholder='Confirm your password' />
                </div>
                <button class='form-input-btn' type='Inscription'>
                    Inscription
                </button>
                <span class='form-input-login'>
                    déjà un compte? Connectez-vous
                    <a href="login.php">ici</a>
                </span>
                <br>
                <?php
              
                    
                
                //include 'bd.php';
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $prenom = $_POST['prenom'];
                    $nom = $_POST['nom'];
                    $adresse = $_POST['adresse'];
                    $telephone = $_POST['telephone'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];
                    if ($password != $password2) {
                        echo '<div style="color: red;">Les mots de passes ne sont pas identiques</div>';
                    } else {
                        
                        $url = 'https://localhost:7103/api/Usager';
                        $tableau = array("nom" =>   $nom,
                        "prenom" => $prenom,
                        "email"=> $email,
                        "telephone"=> $telephone,
                        "password"=> $password,
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
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_HTTPHEADER => array(
                                "cache-control: no-cache",
                                "Content-Type: application/json"
                            ))
                        );

                        $result = curl_exec($ch);
                        if($errno = curl_errno($ch)){
                            $error_message = curl_strerror($errno);
                            echo "Curl error ({$errno}): \n {$error_message}";
                        }
                        /*
                        $response = '';
                        $err = '';
                        */
                        curl_close($ch);
                      //  $response = json_decode($response, true); //because of true, it's in an array
                        //print_r($response);
                       // echo "<br>";
                        //echo 'Fail: ' . $err;
                       header('Location: confirmation.php');
                    }
                }
                ?>
            </form>
        </div>
    </div>
</body>