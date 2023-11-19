<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Articulo</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="formulario">
        <a href="/articles">Volver a mis Articulos</a>
        <h2>Crear Nuevo Articulo</h2>

        <form action="/articles" method="POST">
            <label for="titulo">Titulo del Articulo:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <?php
                //TODO necesito la funcion que me devuelva las categorias de los articles
                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                }
                ?>
            </select>

            <label for="descripcion">Descripción del Articulo:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <button type="submit">Crear Articulo</button>
        </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
