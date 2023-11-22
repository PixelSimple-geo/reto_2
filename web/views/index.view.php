<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapa.php"?>
        <title>Inicio | Reto 2</title>
    </head>

<<<<<<< HEAD
    <body class="grid-page-structure">
=======
    <body class="structure">
>>>>>>> client_develop

           <?php require "partials/navBar.php"; ?>

           <main>
                <div class="principal">
                    <div id="map"></div>
                    <div class="contents">
                        <?php
                            if ($adverts) {
                                $advertsCount = count($adverts); 
                                $limit = min(6, $advertsCount); 

                                for ($i = 0; $i < $limit; $i++) {
                                    $advert = $adverts[$i];
                                    echo '<a href="/adverts/advert?advert_id=' . $advert['advertId'] . '">';
                                    echo '<div>';
                                    echo "<img src='$advert[coverImg]' alt='Portada del anuncio'>";
                                    echo '<h2>' . htmlspecialchars($advert['title']) . '</h2>';
                                    echo '<p>' . htmlspecialchars($advert['description']) . '</p>';
                                    echo '</div>';
                                    echo '</a>';
                                }
                            } else {
                                echo '<p>No se encontraron anuncios.</p>';
                            }
                        ?>
                    </div>
                </div>
            </main>

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapsJS.php" ?>    

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>    

    </body>
</html> 