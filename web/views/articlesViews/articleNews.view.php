<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Noticias | Reto 2</title>
</head>

<body class="structure">
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

        <div class="articles">
            <?php
            $itemsPerPage = 6;
            $totalItems = count($articles);

            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $pagedArticles = array_slice($articles, $offset, $itemsPerPage);

            if (isset($pagedArticles) && !empty($pagedArticles)) {
                foreach ($pagedArticles as $article) {
                    echo '<a href="/articles/article?articleId=' . urlencode($article['articleId']) . '">';
                    echo '<div class="article">';
                    echo '<h2>' . htmlspecialchars($article['title']) . '</h2>';
                    echo '<p>' . htmlspecialchars($article['description']) . '</p>';
                    echo '<p>' . htmlspecialchars($article['createdDate']) . '</p>';
                    echo '</div>';
                    echo '</a>';
                }

                // Paginación
                $totalPages = ceil($totalItems / $itemsPerPage);
                
                if ($totalPages > 1) {
                    echo '<ul class="paginas">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $class = ($i == $currentPage) ? 'current' : '';
                        echo '<li><a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a></li>';
                    }
                    echo '</ul>';
                }
            } else {
                echo '<p>No se encontraron noticias.</p>';
            }
            ?>
        </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
