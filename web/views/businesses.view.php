<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Mis Negocios</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/account/businesses/add">+ Crear Nuevo Negocio</a>
            <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>"?>
            <h2>Mis Negocios</h2>
            <div class="contents">
                <?php
                    if (isset($businesses)) {
                        foreach ($businesses as $business) {
                            echo '<div>';
                            echo '  <h3>' . $business['name'] . '</h3>';
                            echo '  <p>Descripción: ' . $business['description'] . '</p>';
                            echo '  <a href="/adverts/' . $business['businessId'] . '">Ver Anuncios</a>';
                            echo '  <a href="/businesses/' . $business['businessId'] . '">Editar Negocio</a>';
                            //TODO terminar el enlace de eliminacion
                            echo '  <a href="/.php?id=' . $business['businessId'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este negocio?\')" class="eliminar">Eliminar Negocio</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No tienes negocios registrados.</p>';
                    }
                ?>
            </div>
        </div>
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
