<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require "../db.php"; ?>
        <?php require "partials/head.php" ?>
        <title>Comercios | Reto 2</title>
    </head>
    
    <body>
        <?php require "partials/navBar.php"; ?>
    
        <div class="categorias">
            <?php
            $categories = getBusinessCaregories($dbh);
            if ($categories) {
                $categoriesCount = count($categories); 
                $limit = min(8, $categoriesCount); 

                for ($i = 0; $i < $limit; $i++) {
                    $category = $categories[$i];
                    echo '<div class="categoria">';
                    //echo '<img class="product-image" src="' . htmlspecialchars($advert['cover_img']) . '" alt="' . htmlspecialchars($advert['title']) . '">';
                    echo '<h2>' . htmlspecialchars($category['name']) . '</h2>';
                    echo '</div>';
                }

            } else {
                echo '<p>No se encontraron categorías de negocios.</p>';
            }
            ?>
            <p>16</p>
            <p>12</p>
        </div>


    <?php require "partials/footer.php" ?>    

    </body>
</html>