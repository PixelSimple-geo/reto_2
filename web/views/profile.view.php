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
        echo '<form action="procesar_edicion_perfil.php" method="POST">';
        echo '  <label for="nombre">Nombre:</label>';
        echo '  <input type="text" id="nombre" name="username" value="' . $userAccount["username"] . '">';

        echo '  <label for="email">Correo Electrónico:</label>';
        echo '  <input type="email" id="email" name="email" value="' . $userAccount["email"] . '">';
        
        echo '  <label for="password_actual">Contraseña Actual:</label>';
        echo '  <input type="password" id="password_actual" name="password_actual" required>';

        echo '  <label for="password_nueva">Nueva Contraseña:</label>';
        echo '  <input type="password" id="password_nueva" name="password_nueva" required>';

        echo '  <label for="password_confirmar">Confirmar Nueva Contraseña:</label>';
        echo '  <input type="password" id="password_confirmar" name="password_confirmar" required>';
        
        echo '  <button type="submit">Guardar Cambios</button>';
        echo '</form>';
    }
    ?>
</main>

    <?php require "partials/footer.php" ?>

</body>
</html>
