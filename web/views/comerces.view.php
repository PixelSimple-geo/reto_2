<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require "/laragon/www/reto_2/web/db.php"; ?>
        <?php require "/laragon/www/reto_2/web/views/partials/head.php" ?>
        <title>Comercios | Reto 2</title>
    </head>
    
    <body>
        <?php require "/laragon/www/reto_2/web/views/partials/navvar.php"; ?>
    
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


    <?php require "/laragon/www/reto_2/web/views/partials/footer.php" ?>    

    </body>
</html>