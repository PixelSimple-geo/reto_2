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
            "<form action='#' method='POST'>
                <label for='titulo'>Título del Anuncio:</label>
                <input id='titulo' name='title' required>
                
                <label for='descripcion'>Descripción del Anuncio:</label>
                <textarea id='descripcion' name='descripcion' rows='4' required></textarea>
                
                <label for='cover_img'>Imagen de Portada:</label>
                <input type=file id=cover_img name=cover_img required>
                
                <button type=submit>Guardar Cambios</button>
            </form>
            ";
        }

        ?>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
