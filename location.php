<!DOCTYPE html>
<html lang="fr">
<?php
include '_headerBar.php';
$active_link = "location";
?>

<<<<<<< HEAD
=======
<head>
	<title>Location - Autorius</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<link rel="stylesheet" href="css/location.css">

	<script src="js/jquery-3.6.1.min.js"></script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

	<script src="dist/main.js"></script>

	<link rel="stylesheet" href="css/font-awesome.min.css">

	<input id="user_token" type="hidden" value="<?php echo $_SESSION["token"]; ?>">

	<style>
	</style>
</head>
>>>>>>> a62454ddd822c6055c19d0755de9caa101420f8a

<body>

	<?php include '_header.php'; ?>

	<main class="container">
		<h2 style="width: 100%; text-align: center; margin-bottom: 25px;">🚧 en construction 🚧</h2>
		<div class="container row">
			<div class="col-md-4">
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