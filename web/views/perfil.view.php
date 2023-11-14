<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "../db.php"; ?>
    <?php require "partials/head.php" ?>
    <title>Editar Perfil</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main>
        <h2>Editar Perfil</h2>

        <?php
        if (isset($userAccount)) {
            // Mostrar el formulario de edición de perfil
            echo '<form action="procesar_edicion_perfil.php" method="POST">';
            echo '  <label for="nombre">Nombre:</label>';
            echo '  <input type="text" id="nombre" name="username" value="' . $userAccount["nombre"] . '">';

            echo '  <label for="email">Correo Electrónico:</label>';
            echo '  <input type="email" id="email" name="email" value="' . $userAccount["email"] . '">';

            // Puedes agregar más campos aquí

            echo '  <button type="submit">Guardar Cambios</button>';
            echo '</form>';
        }
        ?>
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
