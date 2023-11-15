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
        <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>"?>
        <a href="/crearNegocio">+ Crear Nuevo Negocio</a>
        <h2>Mis Negocios</h2>
        <?php
            if (isset($businesses)) {
                foreach ($businesses as $business) {
                    echo '<div>';
                    echo '  <h3>' . $business['name'] . '</h3>';
                    echo '  <p>Dirección: ' . $business['description'] . '</p>';
                    echo '  <a href="/anuncios/' . $business['businessId'] . '">Ver Anuncios</a>';
                    echo '  <a href="/editarNegocio/' . $business['businessId'] . '">Editar Negocio</a>';
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
