<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <?php
    $baseURL = "/categories.view.php?categoryId=";

    echo '<div class="categorias">';
    if ($categories) {
        foreach ($categories as $category) {
            echo '<a href="' . $baseURL . urlencode($category['categoryId']) . '" class="categoria">';
            echo '<h2>' . htmlspecialchars($category['name']) . '</h2>';
            echo '</a>';
        }
    } else {
        echo '<p>No se encontraron categorías de negocios.</p>';
    }
    echo '<p>16</p>';
    echo '<p>12</p>';
    echo '</div>';
    ?>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
