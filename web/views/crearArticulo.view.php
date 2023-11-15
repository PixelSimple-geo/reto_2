<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Crear Articulo</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <div class="formulario">
            <a href="/articulos">Volver a mis Articulos</a>
            <h2>Crear Nuevo Articulo</h2>

            <form action="/articulos" method="POST">
                <label for="nombre">Nombre del Articulo:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="descripcion">Descripción del Articulo:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

                <button type="submit">Crear Articulo</button>
            </form>
    </div>

    <?php require "partials/footer.php" ?>

</body>
</html>
