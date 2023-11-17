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

        <h2>Editar Anuncio</h2>

        <?php
        if (isset($advert)) {
            echo
            "<form action='#' method='POST' enctype='multipart/form-data'>
                <label for='title'>Título del Anuncio:</label>
                <input id='title' name='title' required value='$advert[title]'>
                
                <label for='description'>Descripción del Anuncio:</label>
                <textarea id='description' name='description' rows='4' required>$advert[description]</textarea>";

            foreach ($advert["characteristics"] as $index => $characteristic) {
                echo "
                <fieldset>
                    <legend>Características</legend>
                    <label for=characteristic_type_$characteristic[characteristicId]>Característica:</label>
                    <input id=characteristic_type_$characteristic[characteristicId] name=characteristic_type[] value=$characteristic[type]>
                    <label for=characteristic_value_$characteristic[characteristicId]>Valor:</label>
                    <input id=characteristic_value_$characteristic[characteristicId] name=characteristic_value[] value=$characteristic[value]>
                 </fieldset>
                ";
            }

                 echo "
                
                <label for='cover_img'>Imagen de Portada:</label>
                <img src='$advert[coverImg]' alt='Imagen de portada'>
                <input type=file id=cover_img name=cover_img accept='image/*' required>
                ";

            foreach ($advert["images"] as $index => $image) {
                echo "<img src='$image[url]' alt='Imagen de anuncio'>";
            }

            echo "<label for='images'>Imagenes</label>
                <input type='file' id='images' name='images[]' accept='image/*' multiple>
                
                <button type=submit>Guardar Cambios</button>
            </form>
            ";
        }

        ?>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
