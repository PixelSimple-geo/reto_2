<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"; ?>
    <title>Ver Anuncios</title>
</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    <main>
        <div class="contentsContainer">
            <?php if (isset($business)): ?>
                <?= "<a href='/adverts/account/business/add?business_id={$business['businessId']}'>+ Crear Nuevo Anuncio</a>" ?>
                <br>
                <br>
                <a href="/businesses/account/get">Volver a Mis Negocios</a>
                <?= "<h1>{$business['name']}</h1>" ?>
                <?= "<p>{$business['description']}</p>" ?>
                <div class="contents">
                    <?php
                        if (isset($adverts)) {
                            foreach ($adverts as $advert) {
                                ?>
                                <div>
                                    <img src='<?= $advert['coverImg'] ?>' alt='Portada del anuncio'>
                                    <?= "<h2>{$advert['title']}</h2>" ?>
                                    <?= "<p>{$advert['description']}</p>" ?>
                                    <?= "<a href='/adverts/account/business/edit?advert_id={$advert['advertId']}'>Edit anuncio</a>" ?>
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php"; ?>
</body>
</html>
