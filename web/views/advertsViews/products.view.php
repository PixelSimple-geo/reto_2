<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Products - Product Details</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

   

    <div class="contentsContainer">

        <form action="/index" method="POST" class="search">
            <input type="text" name="search" placeholder="¿Que deseas buscar?">
            <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
        </form> 
        
        <br>
        
        <h2>Products:</h2>

        <div class="contents">
            <?php
            $itemsPerPage = 6;
            $totalProducts = count($adverts);

            $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
            $offset = ($currentPage - 1) * $itemsPerPage;

            $pagedProducts = array_slice($adverts, $offset, $itemsPerPage);

            if (isset($pagedProducts) && !empty($pagedProducts)) {
                foreach ($pagedProducts as $product) {
                    echo '<div>';
                    echo "<img src='$product[coverImg]' alt='Product Image'>";
                    echo '<h3>' . $product['title'] . '</h3>';
                    echo '<p>Description: ' . $product['description'] . '</p>';
                    echo '</div>';
                }

                $totalPages = ceil($totalProducts / $itemsPerPage);
            } else {
                echo '<p>No products available.</p>';
            }
            ?>
        </div>

        <?php
        $totalPages = ceil($totalProducts / $itemsPerPage);

        if ($totalPages > 1) {
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
