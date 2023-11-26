<!DOCTYPE html>
<html lang="en">

<head>
    <title>Recuperar Contraseña</title>
    
    <?php require "partials/head.php" ?>

</head>

<body>

    <a href="/index" class="home">
        <img src="/statics/media/comvit.png" alt="Volver al Home">
    </a>

    <div class="formulario">
        <h2>Recuperar Contraseña</h2>
        <form action="/login" method="POST">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Enviar Correo de Recuperación</button>
        </form>
    </div>

</body>

</html>
