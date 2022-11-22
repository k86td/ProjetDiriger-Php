<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
$active_link = "location";
?>

<head>
	<input hidden id="user_token" value="<?php if($_SESSION["token"] != null){echo $_SESSION["token"];} else{echo "";} ?>">
	<link href="css/location.css" rel="stylesheet">
	<link href="css/styleHome.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
	<script src="dist/main.js"></script>
	<!-- don't import this, its a module, it WONT work : <script src="src/location.js"></script> -->

</head>

<body>

	<?php include '_header.php'; //'_headerBar.php';
	?>

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

</body>

</html>