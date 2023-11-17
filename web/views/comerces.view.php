<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <?php
    $baseURL = "/categories.view.php?categoria=";

    echo '<div class="categorias">';
    if ($categories) {
        $categoriesCount = count($categories);
        $limit = min(8, $categoriesCount);

        for ($i = 0; $i < $limit; $i++) {
            $category = $categories[$i];
            echo '<a href="' . $baseURL . urlencode($category['name']) . '" class="categoria">';
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
