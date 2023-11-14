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
        <button>+ Crear Nuevo Negocio</button>
        <h2>Mis Negocios</h2>
        <?php
            if (isset($negocios)) {
                foreach ($negocios as $negocio) {
                    echo '<div>';
                    echo '  <h3>' . $negocio['nombre'] . '</h3>';
                    echo '  <p>Dirección: ' . $negocio['direccion'] . '</p>';
                    echo '  <p>Categoría: ' . $negocio['categoria'] . '</p>';
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
