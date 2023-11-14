<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Mis Negocios</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <a href="/crearNegocio">+ Crear Nuevo Negocio</a>
        <h2>Mis Negocios</h2>

        <div>
            <h3>Nombre del Negocio 1</h3>
            <p>Dirección: Descripción del Negocio 1</p>
            <a href="/anuncios/1">Ver Anuncios</a>
        </div>

        <div>
            <h3>Nombre del Negocio 2</h3>
            <p>Dirección: Descripción del Negocio 2</p>
            <a href="/anuncios/2">Ver Anuncios</a>
        </div>

        <!-- Puedes agregar más bloques similares según sea necesario -->

        <!-- O, si no hay negocios registrados -->
        <!-- <p>No tienes negocios registrados.</p> -->
    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
