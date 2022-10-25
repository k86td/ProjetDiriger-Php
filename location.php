<!DOCTYPE html>
<html lang="fr">
<?php
include '_headerBar.php';
$active_link = "location";
?>


<body>

	<?php //include '_header.php'; ?>

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