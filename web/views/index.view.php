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
                                foreach ($adverts as $advert) {
                                    echo '<div class="producto">';
                                    echo '<img class="product-image" src="' . htmlspecialchars($advert['cover_img']) . '" alt="' . htmlspecialchars($advert['title']) . '">';
                                    echo '<div class="descripcion">';
                                    echo '<h2>' . htmlspecialchars($advert['title']) . '</h2>';
                                    echo '<p>' . htmlspecialchars($advert['description']) . '</p>';
                                    echo '</div>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<p>No se encontraron advert.</p>';
                            }
                        ?>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 2">
                            <div class="descripcion">
                                <h2>Producto 2</h2>
                                <p>Descripción del Producto 2.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 3">
                            <div class="descripcion">
                                <h2>Producto 3</h2>
                                <p>Descripción del Producto 3.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 4">
                            <div class="descripcion">
                                <h2>Producto 4</h2>
                                <p>Descripción del Producto 4.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 5">
                            <div class="descripcion">
                                <h2>Producto 5</h2>
                                <p>Descripción del Producto 5.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 6">
                            <div class="descripcion">
                                <h2>Producto 6</h2>
                                <p>Descripción del Producto 6.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 7">
                            <div class="descripcion">
                                <h2>Producto 7</h2>
                                <p>Descripción del Producto 7.</p>
                            </div>
                        </div>
                        <div class="producto">
                            <img src="ruta_de_la_imagen_del_producto.jpg" alt="Producto 8">
                            <div class="descripcion">
                                <h2>Producto 8</h2>
                                <p>Descripción del Producto 8.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </main>
            
            <script src="js/map.js"></script>
            <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD81ODWIXrm6wljDOEnI6Rr5OpmglGJHz8&callback=initMap"></script>

        <?php require "views/partials/footer.php" ?>    

    </body>
</html>