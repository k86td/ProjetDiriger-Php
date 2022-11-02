

<?php
//session_start();
$DEFAULT_CLASS = "class='nav-link'";
$ACTIVE_CLASS = "class='nav-link active'";
if (isset($active_link)) {
    switch ($active_link) {
        case '':
            $index_class = $ACTIVE_CLASS;
            break;
        case 'location':
            $location_class = $ACTIVE_CLASS;
            break;
    }
}
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Autorius</a>
            <button 
                class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav" 
                aria-controls="navbarNav" 
                aria-expanded="false" 
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a <?php echo $location_class ?? $DEFAULT_CLASS; ?> aria-current="page" href="location.php">Offres</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</body>