<!DOCTYPE html>
<html lang="fr">
<?php
session_start();
$active_link = "location";
?>

<head>
	<input hidden id="user_token" value="<?php echo $_SESSION["token"]; ?>">
	<link href="css/location.css" rel="stylesheet">

	<script src="dist/main.js"></script>
	<script src="src/location.js"></script>
	
</head>
<body>

	<?php include '_header.php'; // include '_headerBar.php';  ?>

	<main class="container">
		<h2 style="width: 100%; text-align: center; margin-bottom: 25px;">🚧 en construction 🚧</h2>
		<script>

		</script>
		<div class="container row">
			<div id="filterContainer" class="col-md-4">
				<div class="categories-filter">
					<div class="type-categorie">
						<h4>Type categories</h4>
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