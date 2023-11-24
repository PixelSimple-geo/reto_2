<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>

    <?php require "partials/head.php" ?>

</head>
<body>

    <a href="/index" class="home">
        <img src= "/statics/media/comvit.png" alt="Volver al Home">
    </a>

    <div class="login_container">
        <h2>Inicio de sesión</h2>
        <?php if(isset($errorMessage)) echo $errorMessage ?>
        <form id="log_form" action="/login" method="POST" >

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" required name="username">

            <label for="password">Contraseña</label>
            <div class="passwordContainer">
                <input type="password" id="password" required name="password">
                <span id="togglePassword">👁️</span>
            </div>

            <button id="submitLog" type="submit">Iniciar Sesión</button>

        </form>

        <a href="#">¿Has olvidado tu contraseña?</a>
        <a href="/signIn">¿No tienes cuenta? Registrate</a>
        
    </div>
</body>
</html>
