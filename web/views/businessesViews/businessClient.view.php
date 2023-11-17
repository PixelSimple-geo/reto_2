<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?php echo $businessInfo['name']; ?> - Business Details</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    <h1><?php echo $businessInfo['name']; ?></h1>
    
    <!-- Display category navbar -->
    <?php echo $categoryNavbar; ?>

    <h2>Business Information</h2>
    <p>Description: <?php echo $businessInfo['description']; ?></p>

    <h2>Adverts</h2>
    <?php
    // Display adverts
    foreach ($businessAdverts as $advert) {
        echo '<div>';
        echo '<h3>' . $advert['title'] . '</h3>';
        echo '<p>Description: ' . $advert['description'] . '</p>';
        // Add more details as needed
        echo '</div>';
    }
    ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
