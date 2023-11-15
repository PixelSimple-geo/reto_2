<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Ver Anuncios</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <a href="/businesses">Volver a Mis Negocios</a>

        <?php
        //TODO necesito las funciones necesarias para que me salgan los anuncios pertenecientes a los negocios seleccionados
        if (isset($_GET['id_negocio'])) {
            $idNegocio = $_GET['id_negocio'];

            $anuncios = obtenerAnunciosPorNegocio($idNegocio);

            if ($anuncios) {
                $negocioDetalles = obtenerDetallesNegocioPorId($idNegocio);

                echo '<h2>' . $negocioDetalles['name'] . '</h2>';

                foreach ($anuncios as $anuncio) {
                    echo '<div>';
                    echo '  <h3>' . $anuncio['titulo'] . '</h3>';
                    echo '  <p>' . $anuncio['descripcion'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay anuncios registrados para este negocio.</p>';
            }
        } else {
            echo '<p>No se proporcionó un ID de negocio válido.</p>';
        }
        ?>

    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
