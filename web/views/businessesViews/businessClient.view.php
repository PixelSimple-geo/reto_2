<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $businessesClient['name']; ?> - Business Details</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    
    <div class="contentsContainer">
        <a href="/comerces">Volver a los comercios</a>

        <h1><?php echo $businessesClient['name']; ?></h1>

        <p>Description: <?php echo $businessesClient['description']; ?></p>
        <h2>Adverts:</h2>

        <div class="contents">
            <?php
            foreach ($advertsByBusiness as $advert) {
                echo '<a href="#">';
                echo '<div>';
                //echo '<img src="' . htmlspecialchars($advert['cover_img']) . '" alt="' . htmlspecialchars($advert['title']) . '">';
                echo '<h3>' . $advert['title'] . '</h3>';
                echo '<p>Description: ' . $advert['description'] . '</p>';
                echo '</div>';
                echo '</a>';
            }
            ?>
        </div>
    </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
