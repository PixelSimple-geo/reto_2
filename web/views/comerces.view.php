<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Comercios | Reto 2</title>
    <style>
        .pagination {
            display: flex;
            list-style: none;
        }

        .pagination li {
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div>
        <div class="navbar">
            <?php
            $baseURL = "/categories.view.php?categoryId=";
            if ($categories) {
                foreach ($categories as $category) {
                    echo '<a href="' . $baseURL . urlencode($category['categoryId']) . '">';
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
                $itemsPerPage = 6;
                $totalItems = count($businesses);

                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $offset = ($currentPage - 1) * $itemsPerPage;

                $pagedBusinesses = array_slice($businesses, $offset, $itemsPerPage);

                if (isset($pagedBusinesses) && !empty($pagedBusinesses)) {
                    foreach ($pagedBusinesses as $business) {
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
