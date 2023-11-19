<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Editar Anuncio</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main class="formulario">
        <a href="/businesses">Volver a Mis Negocios</a>

        <?php
        // TODO: Necesitas la lógica para obtener los detalles del anuncio por su ID
        if (isset($_GET['id_anuncio'])) {
            $anuncioDetalles = obtenerDetallesAnuncioPorId($_GET['id_anuncio']);

            if ($anuncioDetalles) {
        ?>
        <h2>Editar Anuncio</h2>

        <form action="/guardarEdicionAnuncio" method="POST">
            <label for="titulo">Título del Anuncio:</label>
            <input type="text" id="titulo" name="titulo" placeholder="<?php echo $anuncioDetalles['titulo']; ?>" required>

            <label for="descripcion">Descripción del Anuncio:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo $anuncioDetalles['descripcion']; ?></textarea>

            <label for="cover_img">Imagen de Portada:</label>
            <input type="file" id="cover_img" name="cover_img" required>

            <button type="submit">Guardar Cambios</button>
        </form>
        <?php
            } else {
                echo '<p>El anuncio no existe.</p>';
            }
        } else {
            echo '<p>No se proporcionó un ID de anuncio válido.</p>';
        }
        ?>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
