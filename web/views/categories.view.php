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
        <div class="contents">
            <?php
            $itemsPerPage = 6;
            $totalBusinesses = count($businessesByCategorie);

            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $pagedBusinesses = array_slice($businessesByCategorie, $offset, $itemsPerPage);

            if ($pagedBusinesses) {
                foreach ($pagedBusinesses as $business) {
                    echo '<a href="/businessClient.php?businessId=' . urlencode($business['businessId']) . '">';
                    echo '<div>';
                    echo '<h3>' . htmlspecialchars($business['name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($business['description']) . '</p>';
                    echo '</div>';
                    echo '</a>';
                }

                $totalPages = ceil($totalBusinesses / $itemsPerPage);
            } else {
                echo '<p>No businesses found in this category.</p>';
            }
            ?>
        </div>
        <?php
        if (isset($totalPages) && $totalPages > 1) {
            echo '<ul class="paginas">';
            for ($i = 1; $i <= $totalPages; $i++) {
                $class = ($i == $currentPage) ? 'current' : '';
                $queryParams = http_build_query(array_merge($_GET, ['page' => $i]));
                echo '<li><a href="?'.$queryParams.'" class="' . $class . '">' . $i . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>

</html>
