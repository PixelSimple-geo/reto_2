<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Anuncio</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="formulario">
        <a href=#>Volver a mis Anuncios</a>
        <h2>Crear Nuevo Anuncio</h2>

        <form action="/adverts/account/business/add" method="POST" enctype="multipart/form-data">
            <?php
            if (isset($businessId))
                echo "<input name='business_id' value='$businessId'>";
            ?>

            <label for="titulo">Titulo del Anuncio:</label>
            <input id="titulo" name="title" required>

            <label for="descripcion">Descripción del Anuncio:</label>
            <textarea id="descripcion" name="description" rows="4" required></textarea>

            <?php
            if (isset($categories)) {
                echo "<fieldset>";
                echo "<legend>Categoría</legend>";
                echo "<label for='category'>Categoría</label>";
                echo "<select id='category' name='advert_category'>";
                echo "<option value='' disabled hidden selected>Sin categoria</option>";
                foreach ($categories as $category) {
                    echo "<option value='$category[categoryId]'>$category[name]</option>";
                }
                echo "</select>";
                echo "</fieldset>";
            }
            ?>

            <fieldset>
                <legend>Características</legend>
                <label for="characteristic_type">Característica:</label>
                <input id="characteristic_type" name="characteristic_type[]">
                <label for="characteristic_value">Valor:</label>
                <input id="characteristic_value" name="characteristic_value[]">
            </fieldset>

            <label for="imagen_portada">Imagen de Portada:</label>
            <input type="file" id="imagen_portada" name="cover_img" accept="image/*">

            <label for="imagenes_anuncio">Imágenes del Anuncio:</label>
            <input type="file" id="imagenes_anuncio" name="images[]" accept="image/*" multiple>

            <button type="submit">Crear Anuncio</button>
        </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
