<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Editar Perfil</title>
</head>
<body class="structure">
    <?php require "partials/navBar.php"; ?>

    <main>

        <?php if (isset($errorMessage)) : ?>
            <p class="feedbackMessage"><?= $errorMessage ?></p>
        <?php endif; ?>

        <div class="formulario">
            <h2>Editar Perfil</h2>
            <?php if (isset($userAccount)) : ?>
                <form action="/account" method="POST">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="username" placeholder="<?= $userAccount["username"] ?>">

                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" placeholder="<?= $userAccount["email"] ?>">

                    <label for="password_actual">Contraseña Actual:</label>
                    <input type="password" id="password_actual" name="password" required>

                    <label for="password_nueva">Nueva Contraseña:</label>
                    <input type="password" id="password_nueva" name="password_new">

                    <label for="password_confirmar">Confirmar Nueva Contraseña:</label>
                    <input type="password" id="password_confirmar">

                    <button type="submit">Guardar Cambios</button>
                </form>
            <?php endif; ?>
        </div>

    </main>

    <?php require "partials/footer.php" ?>

</body>
</html>
