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

        <form action="perfil.view.php" method="POST">
            <!-- Campos de formulario (puedes agregar más según tus necesidades) -->
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="Nombre Actual del Usuario">

            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="correo@ejemplo.com">


            <button type="submit">Guardar Cambios</button>
        </form>
    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
