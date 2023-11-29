<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"; ?>
    <title>Noticias | Reto 2</title>
</head>

<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div>
        <nav class="navbar">
            <a href="/articles/all"><h2>Todas</h2></a>
            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="/articles/all?category_id=<?= $category["categoryId"] ?>">
                        <h2><?= htmlspecialchars($category['name']) ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>

        <div class="articles">
            <?php
            $itemsPerPage = 6;
            $totalItems = count($articles);

            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $pagedArticles = array_slice($articles, $offset, $itemsPerPage);

            if (isset($pagedArticles) && !empty($pagedArticles)):
                foreach ($pagedArticles as $article):
                    ?>
                    <div class="article">
                        <a href="/articles/article?articleId=<?= urlencode($article['articleId']) ?>">
                            <h2><?= htmlspecialchars($article['title']) ?></h2>
                            <p><?= htmlspecialchars($article['description']) ?></p>
                            <p><?= htmlspecialchars($article['createdDate']) ?></p>
                        </a>
                    </div>
                    <?php
                endforeach;

                $totalPages = ceil($totalItems / $itemsPerPage);

                if ($totalPages > 1):
                    ?>
                    <ul class="paginas">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php
                            $class = ($i == $currentPage) ? 'current' : '';
                            ?>
                            <li><a href="?page=<?= $i ?>" class="<?= $class ?>"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
                <?php endif;
           
            endif;
            ?>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php"; ?>

</body>

</html>
 