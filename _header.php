<?php session_start() ?>

<?php
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

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Autorius</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a <?php echo $location_class ?? $DEFAULT_CLASS; ?> aria-current="page" href="location.php">Offres</a>
                </li>
                <li class="nav-item">
                    <a <?php echo $DEFAULT_CLASS; ?> aria-current="page" href="#">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>