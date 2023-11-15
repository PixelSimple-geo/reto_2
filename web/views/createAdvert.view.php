<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Crear Anuncio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <div class="formulario">
        <a href="/adverts">Volver a mis Anuncios</a>
        <h2>Crear Nuevo Anuncio</h2>

        <form action="/adverts" method="POST" enctype="multipart/form-data">
            <label for="titulo">Titulo del Anuncio:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <?php
                // TODO: Necesitas la función que te devuelva las categorías de los anuncios
                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                }
                ?>
            </select>

            <label for="descripcion">Descripción del Anuncio:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <label for="imagen_portada">Imagen de Portada:</label>
            <input type="file" id="imagen_portada" name="imagen_portada" accept="image/*">

            <label for="imagenes_anuncio">Imágenes del Anuncio:</label>
            <input type="file" id="imagenes_anuncio" name="imagenes_anuncio[]" accept="image/*" multiple>

            <button type="submit">Crear Anuncio</button>
        </form>
    </div>

    <?php require "partials/footer.php" ?>
</body>
</html>
