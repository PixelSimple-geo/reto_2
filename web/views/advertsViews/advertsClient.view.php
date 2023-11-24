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
                echo '<h4>' . $advert['description'] . '</h4>';

                if (!empty($advert['characteristics'])) {
                    echo '<h4>Características:</h4>';
                    echo '<ul>';
                    foreach ($advert['characteristics'] as $char) {
                        echo '<li><strong>' . $char['type'] . ': &nbsp; </strong> ' . $char['value'] . '</li>';
                    }
                    echo '</ul>';
                }

                echo '</div>';
            } else {
                echo '<h4>Product not found.</h4>';
            }
        ?>
        <?php 
            if (!empty($advert['categories'])) {
                echo '<div class="categories">';
                echo '<h4>Categories:</h4>';
                echo '<ul>';

                foreach ($advert['categories'] as $category) {
                    if (is_array($category) && isset($category['name'])) {
                        echo '<li>' . $category['name'] . '</li>';
                    } else {
                    }
                }

                echo '</ul>';
                echo '</div>';
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
