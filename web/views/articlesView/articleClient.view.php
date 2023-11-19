<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Noticias | Reto 2</title>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="articles">
        <?php
        if ($articles) {
            foreach ($articles as $article) {
                echo '<div class="article">';
                    echo '<h2>' . htmlspecialchars($article['title']) . '</h2>';
                    echo '<p>' . htmlspecialchars($article['description']) . '</p>';
                    echo '<p>' . htmlspecialchars($article['created_date']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No se encontraron noticias.</p>';
        }
        ?>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
