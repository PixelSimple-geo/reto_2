<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"; ?>
    <title>Products - Product Details</title>
</head>
<body class="structure">
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">

        <form action="/products" method="GET">
            <div class="search">
                <input type="text" name="search" placeholder="¿Qué deseas buscar?">
                <button type="submit" name="submitSearch"><img src="/statics/media/search.svg" alt="search"></button>
            </div>
        </form>       
        
        <br>
        
        <h2>Products:</h2>

        <div class="contents">
            <?php           
            $itemsPerPage = 6;
            $totalProducts = count($adverts);

            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : [];

            $pagedProducts = [];

            if (!empty($selectedCategories)) {
                foreach ($adverts as $product) {
                    if (isset($product['categories']) && array_intersect($selectedCategories, $product['categories'])) {
                        $pagedProducts[] = $product;
                    }
                }
            } else {
                $pagedProducts = array_slice($adverts, $offset, $itemsPerPage);
            }

            if (isset($pagedProducts) && !empty($pagedProducts)) {
                $searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

                foreach ($pagedProducts as $product):
                    if (!empty($searchTerm) && stripos($product['title'], $searchTerm) === false):
                        continue;
                    endif;
                    ?>
                    <a href="/adverts/advert?advert_id=<?= $product['advertId'] ?>">
                        <div>
                            <img src="<?= $product['coverImg'] ?>" alt="Product Image">
                            <h3><?= $product['title'] ?></h3>
                            <p>Description: <?= $product['description'] ?></p>
                        </div>
                    </a>
                    <?php
                endforeach;

                $totalPages = ceil(count($pagedProducts) / $itemsPerPage);
            } else {
                echo '<p>No products available.</p>';
            }
            ?>
        </div>

        <?php
        $totalPages = isset($totalPages) ? $totalPages : ceil($totalProducts / $itemsPerPage);

        if ($totalPages > 1):
            ?>
            <ul class="paginas">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php
                    $class = ($i == $currentPage) ? 'current' : '';
                    $queryParams = http_build_query(array_merge($_GET, ['page' => $i]));
                    ?>
                    <li><a href="?<?= $queryParams ?>" class="<?= $class ?>"><?= $i ?></a></li>
                <?php endfor; ?>
            </ul>
        <?php endif; ?>
    </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>