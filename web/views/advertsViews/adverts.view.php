<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Ver Anuncios</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
    <main>
        <div class="contentsContainer">
            <?php
            if (isset($business))
                echo "<a href='/adverts/account/business/add?business_id=$business[businessId]'>+ Crear Nuevo Anuncio</a>";
            ?>

            <a href="/businesses/account/get">Volver a Mis Negocios</a>
            <?php
            if (isset($business)) {
                echo "<h1>$business[name]</h1>";
                echo "<p>$business[description]</p>";
            }
            ?>
            <div class="contents">
                <?php

                //TODO necesito las funciones necesarias para que me salgan los anuncios pertenecientes a los negocios seleccionados
                if (isset($adverts)) {

                        foreach ($adverts as $advert) {
                            echo '<div>';
                            echo "<img src='$advert[coverImg]' alt='Portada del anuncio'>";
                            echo "<h2>$advert[title]</h2>";
                            echo "<p>$advert[description]</p>";
                            echo "<a href='/adverts/account/business/edit=advert_id=$advert[advertId]'>Edit anuncio</a>";
                            echo '</div>';
                        }
                }
                ?>
            </div>
        </div>
        

    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
