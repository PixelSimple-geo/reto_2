<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Product Details</title>
</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">

        <?php
        if ($advert) {
            echo '<div class="">';
            echo '<h3>' . $advert['title'] . '</h3>';   
            echo "<img src='{$advert['coverImg']}' alt='Product Image'>";
            echo '<p>Descripcion: </p>';
            echo '<p>' . $advert['description'] . '</p>';
            echo '</div>';
        } else {
            echo '<p>Product not found.</p>';
        }
        ?>
    </div>
    <?php if(isset($advert["images"])): ?>
        <section class="contents">
            <?php foreach ($advert['images'] as $index => $image) : ?>
                <div>
                    <img src='<?= $image['url'] ?>' alt='Imagen de anuncio'>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
