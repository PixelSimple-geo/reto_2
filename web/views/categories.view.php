<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Businesses in Category</title>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
        <div class="contentsContainer">
            <a href="/comerces">Volver a los comercios</a>
            <h2>Businesses in Category</h2>
            <?php
                if ($businessesByCategorie) {
                    foreach ($businessesByCategorie as $business) {
                        echo '<div">';
                        echo '<h3>' . htmlspecialchars($business['name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($business['description']) . '</p>';
                        echo ' <a href="#">Ver Negocio</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No businesses found in this category.</p>';
                }
            ?>
        </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
