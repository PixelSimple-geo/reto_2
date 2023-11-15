<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Editar Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main class="formulario">

        <a href="/businesses">Volver a mis negocios</a>
        <h2>Editar Negocio</h2>

        <?php
            //TODO necesito la funcion para recibir los datos del negocio a editar
            if (isset($_GET['id'])) {
                $negocioId = $_GET['id'];
                $negocioDetalles = obtenerDetallesNegocioPorId($negocioId);

                if ($negocioDetalles) {
                    echo '<form action="/guardarEdicionNegocio" method="POST">';
                    echo '  <label for="nombre">Nombre del Negocio:</label>';
                    echo '  <input type="text" id="nombre" name="nombre" value="' . $negocioDetalles['name'] . '" required>';

                    echo '  <label for="descripcion">Descripción del Negocio:</label>';
                    echo '  <textarea id="descripcion" name="descripcion" rows="4" required>' . $negocioDetalles['description'] . '</textarea>';

                    echo '  <button type="submit">Guardar Cambios</button>';
                    echo '</form>';
                } else {
                    echo '<p>El negocio no existe.</p>';
                }
            } else {
                echo '<p>No se proporcionó un ID de negocio válido.</p>';
            }
        ?>
    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
