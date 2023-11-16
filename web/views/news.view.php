<!DOCTYPE html>
<html lang="en">

<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Noticias | Reto 2</title>
</head>

<body>
    <?php require "partials/navBar.php"; ?>

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

    <?php require "partials/footer.php" ?>

</body>

</html>
