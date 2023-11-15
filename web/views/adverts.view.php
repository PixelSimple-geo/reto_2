<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Ver Anuncios</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/businesses">+ Crear Nuevo Anuncio</a>
            <a href="/businesses">Volver a Mis Negocios</a>
            <div class="contents">
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
                            echo '<img src="' . $anuncio['cover_img'] . '" alt="Portada del Anuncio">';
                        
                            echo '  <h3>' . $anuncio['titulo'] . '</h3>';
                            echo '  <p>' . $anuncio['descripcion'] . '</p>';
                        
                            echo '  <a href="/ver_anuncio.php?id=' . $anuncio['advertId'] . '">Ver Anuncio</a>';

                            echo '  <a href="/adverts/' . $anuncio['anuncioId'] . '">Editar Anuncio</a>';

                            // TODO: Terminar el enlace de eliminación
                            echo '  <a href="/eliminar_anuncio.php?id=' . $anuncio['advertId'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este anuncio?\')" class="eliminar">Eliminar Anuncio</a>';
                            echo '</div>';
                        }
                        
                    } else {
                        echo '<p>No hay anuncios registrados para este negocio.</p>';
                    }
                } else {
                    echo '<p>No se proporcionó un ID de negocio válido.</p>';
                }
                ?>
            </div>
        </div>
        

    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
