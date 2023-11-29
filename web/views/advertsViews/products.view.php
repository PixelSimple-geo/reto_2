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
                <input type="text" name="q" placeholder="¿Qué deseas buscar?">
                <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
            </div>
        </form>       
        
        <br>
        
        <h2>Products:</h2>

        <div class="contents">
            <?php           

                foreach ($adverts as $product):
                    if (!empty($searchTerm) && stripos($product['title'], $searchTerm) === false):
                        continue;
                    endif;
                    ?>
                    <a href="/adverts/advert?advert_id=<?= $product['advertId'] ?>">
                        <div>
                            <img src="<?= htmlspecialchars($product['coverImg']) ?>" alt="Product Image">
                            <h3><?= htmlspecialchars($product['title']) ?></h3>
                            <p>Description: <?= htmlspecialchars($product['description']) ?></p>
                        </div>
                    </a>
                    <?php
                endforeach;
            ?>
        </div>
    </div>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>