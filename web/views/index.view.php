<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"; ?>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapa.php"; ?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">

    <?php require "partials/navBar.php"; ?>

    <main>
        <div class="principal">
            <div id="map"></div>
            <div class="contents images">
                <?php
                if ($adverts):
                    $advertsCount = count($adverts);
                    $limit = min(6, $advertsCount);

                    for ($i = 0; $i < $limit; $i++):
                        $advert = $adverts[$i];
                        ?>
                        <a href="/adverts/advert?advert_id=<?= $advert['advertId'] ?>">
                            <div>
                                <img src="<?= $advert['coverImg'] ?>" alt="Portada del anuncio">
                                <h2><?= htmlspecialchars($advert['title']) ?></h2>
                                <p><?= htmlspecialchars($advert['description']) ?></p>
                            </div>
                        </a>
                        <?php
                    endfor;
                else:
                    echo '<p>No se encontraron anuncios.</p>';
                endif;
                ?>
            </div>
        </div>
    </main>

    <div>

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/mapsJS.php" ?>

        <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

    </div>
    
</body>

</html>
