<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>

    <!--CSS-->
    <link rel="stylesheet" href="../statics/css/reset.css">
    <link rel="stylesheet" href="../statics/css/style.css">

    <!--JS-->
    <script src="../statics/js/logreg.js" defer></script>

</head>
<body>
        <a href="../index.php" class="home">
            <img src= "../statics/media/logo2.png" alt="Volver al Home">
        </a>
    
    <div class="login_container">
        <h2>Inicio de Sesion</h2>
        <form id="log_form" action="../index.php" method="POST" >

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" required>

            <button id="submitLog">Iniciar Sesión</button>

        </form>

        <a href="#">¿Has olvidado tu contraseña?</a>
        <a href="register.view.php">¿No tienes cuenta? Registrate</a>
        
    </div>
</body>
</html>
