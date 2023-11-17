<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div>
        <div class="categorias">
            <?php
            $baseURL = "/categories.view.php?categoryId=";
            if ($categories) {
                foreach ($categories as $category) {
                    echo '<a href="' . $baseURL . urlencode($category['categoryId']) . '" class="categoria">';
                    echo '<h2>' . htmlspecialchars($category['name']) . '</h2>';
                    echo '</a>';
                }
            } else {
                echo '<p>No se encontraron categorías de negocios.</p>';
            }
            ?>
        </div>
        <div class="contentsContainer">
            <div class="contents">
                <?php
                        if (isset($businesses)) {
                            foreach ($businesses as $business) {
                                echo '<a href="/businessClient.php?businessId=' . urlencode($business['businessId']) . '">';
                                echo '<div>';
                                echo ' <h3>' . $business['name'] . '</h3>';
                                echo ' <p>Descripción: ' . $business['description'] . '</p>';
                                echo '</div>';
                                echo '</a>';
                            }
                        } else {
                            echo '<p>No tienes negocios registrados.</p>';
                        }
                        
                ?>
            </div>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
