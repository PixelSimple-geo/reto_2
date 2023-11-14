<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Mis Articulos</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <a href="/crearArticulo">+ Crear Nuevo Articulo</a>
        <h2>Mis Articulos</h2>
        
        <div>
            <h3>Articulo 1</h3>
            <p>Descripción del Articulo 1</p>
            <a href="/editarArticulo/1">Editar</a>
        </div>

        <div>
            <h3>Articulo 2</h3>
            <p>Descripción del Articulo 2</p>
            <a href="/editarArticulo/2">Editar</a>
        </div>

        <!-- Puedes agregar más bloques similares según sea necesario -->

        <!-- O, si no hay artículos registrados -->
        <!-- <p>No tienes artículos registrados.</p> -->
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
