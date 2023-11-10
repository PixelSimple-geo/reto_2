<!DOCTYPE html>
<html lang="en">

    <?php require "db.php"; ?>
    <?php require "views/partials/head.php" ?>

    <body>

           <?php require "/laragon/www/reto_2/web/views/partials/navvar.php"; ?>

           <main>
                <div class="principal">
                    <div id="map"></div>
                    <div class="productos">
                        <?php
                        $adverts = getAdverts($dbh);
                        if ($adverts) {
                            $advertsCount = count($adverts); 
                            $limit = min(8, $advertsCount); 

                            for ($i = 0; $i < $limit; $i++) {
                                $advert = $adverts[$i];
                                echo '<div class="producto">';
                                echo '<img src="' . htmlspecialchars($advert['cover_img']) . '" alt="' . htmlspecialchars($advert['title']) . '">';
                                echo '<div class="descripcion">';
                                echo '<h2>' . htmlspecialchars($advert['title']) . '</h2>';
                                echo '<p>' . htmlspecialchars($advert['description']) . '</p>';
                                echo '</div>';
                                echo '</div>';
                            }

                        } else {
                            echo '<p>No se encontraron anuncios.</p>';
                        }
                        ?>
                    </div>
                </div>
            </main>

            
            <script src="js/map.js"></script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD81ODWIXrm6wljDOEnI6Rr5OpmglGJHz8&callback=initMap"></script>

        <?php require "views/partials/footer.php" ?>    

    </body>
</html>