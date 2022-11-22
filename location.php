<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
$active_link = "location";
include 'requete.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {

	if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['message-button'])) {

		PostMessage($_POST['message'], $_POST['date'], $_SESSION['destinataire']);
		//echo $_SESSION['message']->id ;
	} else if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['chatter'])) {
		$_SESSION['destinataire'] = $_POST['chatter'];
	}
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
	if (isset($_SESSION['email'])) {
		$_SESSION['allUser'] = GetAllUsers();
	}
}
?>

<head>
	<input hidden id="user_token" value="<?php if($_SESSION["token"] != null){echo $_SESSION["token"];} else{echo "";} ?>">
	<link href="css/location.css" rel="stylesheet">
	<link href="css/styleHome.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script src="dist/main.js"></script>
	<!-- don't import this, its a module, it WONT work : <script src="src/location.js"></script> -->
	<link rel="stylesheet" href="css/button.css">
	<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>


	<?php include '_header.php'; // include '_headerBar.php';  
	?>
	

	<div id="mainBody" class="toast-container position-fixed bottom-0 end-0 p-3"></div>

	<main class="container">
		<h2 style="width: 100%; text-align: center; margin-bottom: 25px;">🚧 en construction 🚧</h2>
		<script>

		</script>
		<div class="container row">
			<div id="filterContainer" class="col-md-4">
				<div class="categories-filter">
					<div class="type-categorie">
						<h4>Types de véhicule</h4>
						<div class="row">
							<div class="col">
								<div class="type-categorie-content">
									<!-- insert TypeCategories here -->
									<div class="spinner-border text-primary" role="status"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="categorie">
						<h4>Categories</h4>
						<div class="row">
							<div class="col">
								<div class="categorie-content">
									<!-- insert Categories here -->
								</div>
							</div>
						</div>
					</div>
					<button id="btn_appliquer" class="btn btn-primary">Appliquer</button>
				</div>
			</div>
			<div class="col-md-8">
				<div style="text-align: center;" class="main-content">
					<!-- here is the main content! -->
					<div class="spinner-border text-primary" role="status"></div>
				</div>
			</div>
		</div>
	</main>

	<section <?php if(!isset($_SESSION['email'])){echo'hidden';} ?> class="messagerie" class="chat">
		<div class="wrapper">
			<div class="title"><?php if ($_SERVER['REQUEST_METHOD'] == "GET") {
									echo 'Messagerie instantanée';
								} else {
									for ($i = 0; $i < count($_SESSION['allUser']); $i++) {
										if ($_SESSION['allUser'][$i]->id ==  $_SESSION['destinataire']) {
											echo 'Messagerie instantanée avec : ' . $_SESSION['allUser'][$i]->prenom;
										}
									}
								} ?></div>
			<form action="location.php" id="chatbox" method="POST">
				<div class="form">
					<?php
					if (isset($_SESSION['email'])) {
						if ($_SERVER['REQUEST_METHOD'] == "GET") {
							for ($i = 0; $i < count($_SESSION['allUser']); $i++) {
								if ($_SESSION['allUser'][$i]->id != $_SESSION['email']->id) {
									echo '
										<div class="box">
									   <form method="POST">
									   <div> Chatter avec ' . $_SESSION['allUser'][$i]->prenom . '</div>
										   <button class="button" type="submit" class="btn" value=' . $_SESSION['allUser'][$i]->id . ' name="chatter">Lancer la discussion</button>
										   </form>
									   </div>';
								}
							}
						} 
						else {
							$_SESSION['message'] = GetMessage();
							for ($i = 0; $i < count($_SESSION['message']); $i++) {
								if ($_SESSION['message'][$i]->idAuteur == $_SESSION['email']->id && $_SESSION['message'][$i]->idDestinataire == $_SESSION['destinataire']) {
									echo ' <div class="user-inbox inbox">
									<div class="msg-header">
										<p>' . $_SESSION['message'][$i]->contenu . '</p>
									</div>
									</div>';
								} else if ($_SESSION['message'][$i]->idAuteur == $_SESSION['destinataire'] && $_SESSION['message'][$i]->idDestinataire == $_SESSION['email']->id) {
									echo ' <div class="bot-inbox inbox">
									<div class="msg-header">
										<p>' . $_SESSION['message'][$i]->contenu . '</p>
									</div>
									</div>';
								}
							}
						}
					}


					?>

				</div>
				<div class="typing-field">
					<div class="input-data">
						<input name="message" type="text" placeholder="Chat" required>
						<input name='date' hidden type="datetime-local" value="2022-06-12T19:30" />
						<button name="message-button" type="submit">Envoyez</button>
					</div>
				</div>
			</form>
		</div>
	</section>

</body>

</html>