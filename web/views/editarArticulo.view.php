<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Editar Articulo</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main class="formulario">

        <a href="/articles">Volver a mis articulos</a>
        <h2>Editar Articulo</h2>

        <?php
            //TODO necesito la funcion para recibir los datos del articulo a editar
            if (isset($_GET['id'])) {
                $articuloId = $_GET['id'];
                $articuloDetalles = obtenerDetallesArticuloPorId($articuloId);

                if ($articuloDetalles) {
                    echo '<form action="/guardarEdicionArticulo" method="POST">';
                    echo '  <label for="nombre">Nombre del Articulo:</label>';
                    echo '  <input type="text" id="nombre" name="nombre" value="' . $articuloDetalles['title'] . '" required>';

                    echo '  <label for="descripcion">Descripción del Articulo:</label>';
                    echo '  <textarea id="descripcion" name="descripcion" rows="4" required>' . $articuloDetalles['description'] . '</textarea>';

                    echo '  <button type="submit">Guardar Cambios</button>';
                    echo '</form>';
                } else {
                    echo '<p>El articulo no existe.</p>';
                }
            } else {
                echo '<p>No se proporcionó un ID de articulo válido.</p>';
            }
        ?>
    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
