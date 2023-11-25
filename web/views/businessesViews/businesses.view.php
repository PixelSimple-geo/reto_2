<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
</head>

<body class="structure">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div>
        <nav class="navbar">
            <a href="/businesses/all"><h2>Todo</h2></a>
            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <a href="/businesses/all?category_id=<?= $category["categoryId"] ?>">
                        <h2><?= htmlspecialchars($category['name']) ?></h2>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>

        <div class="contentsContainer">
            <div class="contents">
                <?php
                $itemsPerPage = 6;
                $totalItems = count($businesses);

                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $offset = ($currentPage - 1) * $itemsPerPage;

                $pagedBusinesses = array_slice($businesses, $offset, $itemsPerPage);

                if (isset($pagedBusinesses) && !empty($pagedBusinesses)) {
                    foreach ($pagedBusinesses as $business) {
                        echo '<a href="/businesses/business?business_id=' . urlencode($business['businessId']) . '">';
                        echo '<div>';
                        if (!empty($business["coverImg"]))
                            echo '<img src="' . htmlspecialchars($business["coverImg"]) . '">';
                        echo '<h3>' . htmlspecialchars($business['name']) . '</h3>';
                        echo '<p>Descripción: ' . htmlspecialchars($business['description']) . '</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No se encontraron comercios.</p>';
                }
                ?>
            </div>
            <?php
                $totalPages = ceil($totalItems / $itemsPerPage);

                        if ($totalPages > 1) {
                            echo '<ul class="paginas">';
                            for ($i = 1; $i <= $totalPages; $i++) {
                                $class = ($i == $currentPage) ? 'current' : '';
                                echo '<li><a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a></li>';
                            }
                            echo '</ul>';
                        }
            ?>
        </div>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
