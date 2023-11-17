<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $businessesClient['name']; ?> - Business Details</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    <a href="/comerces">Volver a los comercios</a>

    <h1><?php echo $businessesClient['name']; ?></h1>

    <h2>Business Information</h2>
    <p>Description: <?php echo $businessesClient['description']; ?></p>

    <h2>Adverts</h2>
    <!-- TODO
    <?php
    foreach ($businessAdverts as $advert) {
        echo '<div>';
        echo '<h3>' . $advert['title'] . '</h3>';
        echo '<p>Description: ' . $advert['description'] . '</p>';
        echo '</div>';
    }
    ?>
    -->
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
