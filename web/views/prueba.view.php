<!DOCTYPE html>
<html lang="es">
<head>
<?php require "partials/head.php" ?>

    <title>Editar Anuncio</title>
</head>
<body>

    <main class="formulario">
        <a href="/businesses">Volver a Mis Negocios</a>

        <h2>Editar Anuncio</h2>

        <form action="/guardarEdicionAnuncio" method="POST">
            <label for="titulo">Título del Anuncio:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Anuncio de Descuento" required>

            <label for="descripcion">Descripción del Anuncio:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <label for="cover_img">URL de la Imagen de Portada:</label>
            <input type="file" id="cover_img" name="cover_img" placeholder="ruta/a/la/imagen.jpg" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </main>

</body>
</html>
