<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link href="css/form.css" rel="stylesheet">
</head>

<body>
    <script>
        function preview() {
            let image = document.getElementById('imageInput').files[0];
            img.src = URL.createObjectURL(event.target.files[0]);
            console.debug(image);
        }
    </script>
    <div class='container'>
        <span class='close-btn'><a style="color: #ca2929;" href="index.php">x</a></span>
        <?php 
                  if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $password = $_POST['password'];
                    $password2 = $_POST['password2'];
                    if ($password == $password2) {
                        echo '<div style="color: green;"> Votre compte à bien été créé. Vous pouvez cliquer sur le lien en bas du formulaire pour vous connecter</div>';
                    }
                    else
                    {
                        echo '<div style="color: red;">Les mots de passes ne sont pas identiques</div>';
                    }
                  }
                   
                 ?>
        <div class='title'>Inscription </div>
        <form class='form' method="POST" enctype="multipart/form-data">
            <div class="user-details">
                <h1>
                    Veuillez entrez vos informations
                </h1>
                <div class='input-box'>
                    <span class='details'>Prénom</span>
                    <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='prenom' placeholder='Entrer votre prénom' />
                </div>
                <div class='input-box'>
                    <span class='details'>Nom</span>
                    <input required type='text' pattern="^[a-zA-Z]+$" title="Seulement des lettres" name='nom' placeholder='Entrer votre nom' />
                </div>
                <div class='input-box'>
                    <span class='details'>Adresse</span>
                    <input required type='text' pattern="^[a-zA-Z0-9- ]+$" title="Seulement des lettres et chiffre" name='adresse' placeholder='Entrer votre Adresse' />
                </div>
                <div class='input-box'>
                    <span class='details'>Téléphone</span>
                    <input required type='text' pattern="^[]*[(][0-9]{1,4}[)]{0,1}[-\s\./0-9]*$" title="(999)-999-9999" name='telephone' placeholder='Entrer votre Téléphone' />
                </div>
                <div class='input-box'>
                    <span class='details'>Email</span>
                    <input required type='email' name='email' placeholder='Entrer votre email' />
                </div>
                <div class='input-box'>
                    <span class='details'>Password</span>
                    <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password' placeholder='Entrer votre password' />
                </div>
                <div class='input-box'>
                    <span class='details'>Confirmer Password</span>
                    <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$" title="Minimum huit caractères, au moins une lettre majuscule, une lettre minuscule et un chiffre" type='password' name='password2' placeholder='Confirmer votre password' />
                </div>
                <div class='input-box'>
                </div>
                <div class="input-box">
                    <span class="details">Apercu de l'image</span>
                    <div class="image-preview" id="imagePreview">
                        <img src="images/placeholder-image.png" alt="" class="image-preview__image" id="img">
                    </div>
                </div>
                <div class="input-box">
                    <span class="details"> Ajouter une image </span>
                    <div class="button" onclick="document.getElementById('imageInput').click()">Choisir une image</div>
                    <input type="file" name="imageInput" id="imageInput" style="display:none;" onchange="preview()">
                </div>
                <button class='button' type='Inscription'>
                    S'inscrire
                </button>
                
                <span class='form-input-login'>
                    déjà un compte? Connectez-vous
                    <a href="login.php">ici</a>
                </span>
                <br>
            </div>
        </form>
    </div>
    </div>
    <?php




    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $prenom = $_POST['prenom'];
        $nom = $_POST['nom'];
        $adresse = $_POST['adresse'];
        $telephone = $_POST['telephone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if ($password != $password2) {
           
        } else {
            $target_dir = "images/imagesProfil/";
            $img = $_FILES["imageInput"]["tmp_name"];
            $target_file = $target_dir . $_FILES["imageInput"]["name"];
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $randomFilename = substr(md5(mt_rand(0, 1000)), 0, 21) . '-' . $_FILES["imageInput"]["name"];
            $target_file_dir = $target_dir . $randomFilename;
            $target_file_bd = $randomFilename;

            if ($_FILES["imageInput"]["size"] > 500000000) {
                echo "<script> alert('Sorry, your file is too large.');  </script>";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "<script> alert('Sorry, your file was not uploaded.'); event.preventDefault();</script>";
            } else {
                if (move_uploaded_file($_FILES["imageInput"]["tmp_name"], $target_file)) {
                    include 'mailFonction.php';

                    $url = 'https://localhost:7103/api/Usager';
                    $tableau = array(
                        "nom" =>   $nom,
                        "prenom" => $prenom,
                        "email" => $email,
                        "telephone" => $telephone,
                        "password" => $password,
                        "adresse" => $adresse,
                        "imageProfil" => $target_file_bd
                    );
                    $json_content = json_encode($tableau);


                    $ch = curl_init();
                    curl_setopt_array(
                        $ch,
                        array(
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
                            )
                        )
                    );

                    $result = curl_exec($ch);
                    if ($errno = curl_errno($ch)) {
                        $error_message = curl_strerror($errno);
                        echo "Curl error ({$errno}): \n {$error_message}";
                    }

                    curl_close($ch);
                    sendMailInscription($prenom, $nom, $adresse, $telephone, $email, $mail, $webMail);
                    //header('Location: confirmation.php');
                }
            }
        }
    }
    ?>

</body>