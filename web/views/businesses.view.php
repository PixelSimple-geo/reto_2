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
        <a href="/businesses">+ Crear Nuevo Negocio</a>
        <h2>Mis Negocios</h2>
        <?php
            if (isset($negocios)) {
                foreach ($negocios as $negocio) {
                    echo '<div>';
                    echo '  <h3>' . $negocio['name'] . '</h3>';
                    echo '  <p>Dirección: ' . $negocio['description'] . '</p>';
                    echo '  <a href="/articles/' . $negocio['id'] . '">Ver Anuncios</a>';
                    echo '  <a href="/businesses/' . $negocio['id'] . '">Editar Negocio</a>';
                    echo '</div>';
                }
            } else {
                echo '<p>No tienes negocios registrados.</p>';
            }
        ?>
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
