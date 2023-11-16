<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Mis Articulos</title>
</head>
<body>
    <?php require "partials/navBar.php"; ?>

    <main>
        <a href="/articles">+ Crear Nuevo Articulo</a>
        <h2>Mis Articulos</h2>
        <?php
            if (isset($articulos)) {
                foreach ($articulos as $articulo) {
                    echo '<div>';
                    echo '  <h3>' . $articulo['title'] . '</h3>';
                    echo '  <p>Dirección: ' . $articulo['description'] . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tienes articulos registrados.</p>';
            }
        ?>
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>