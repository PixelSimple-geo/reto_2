<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "/laragon/www/reto_2/web/db.php"; ?>
    <?php require "/laragon/www/reto_2/web/views/partials/head.php" ?>
    <title>Noticias | Reto 2</title>
</head>

<body>
    <?php require "/laragon/www/reto_2/web/views/partials/navvar.php"; ?>

    <div class="articles">
        <?php
        $articles = getArticles($dbh);

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

    <?php require "/laragon/www/reto_2/web/views/partials/footer.php" ?>

</body>

</html>
