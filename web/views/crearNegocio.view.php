<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Crear Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <div class="formulario">
            <a href="/negocios">Volver a mis negocios</a>
            <h2>Crear Nuevo Negocio</h2>

            <form action="/negocios" method="POST">
                <label for="nombre">Nombre del Negocio:</label>
                <input type="text" id="nombre" name="nombre" required>

                <label for="descripcion">Descripción del Negocio:</label>
                <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

                <button type="submit">Crear Negocio</button>
            </form>
    </div>

    <?php require "partials/footer.php" ?>

</body>
</html>
