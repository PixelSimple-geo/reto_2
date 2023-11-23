<!DOCTYPE html>
<html lang="en">

    <head>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapa.php"?>
        <title>Inicio | Reto 2</title>
    </head>

    <body class="structure">

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

        <div>    
        <div class="aviso-cookies" id="aviso-cookies">
            <img src="../statics/media/cookie.svg" alt="Galleta">
            <h3>Cookies</h3>
            <p>Utilizamos cookies propias y de terceros para mejorar nuestros servicios.</p>
            <button id="btn-aceptar-cookies">De acuerdo</button>
            <a href="avisoCookies.html">Aviso de Cookies</a>
        </div>
        
        <div class="fondo-aviso-cookies" id="fondo-aviso-cookies"></div>
        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapsJS.php" ?>    

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>    

    </body>
</html> 