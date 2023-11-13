<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login y Registro</title>
 
    <link rel="stylesheet" href="../statics/css/reset.css">
    <link rel="stylesheet" href="../statics/css/style.css">

</head>
<body>
    <div>
        <button id="login">Inicior Sesion</button>
        <button id="register">Registrarse</button>

        <form id="log_form" action="../index.php" method="POST">

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario">

            <label for="password">Contraseña</label>
            <input type="password" id="password">

            <button id="submitLog">Iniciar Sesión</button>
            <a href="#">¿Has olvidado tu contraseña?</a>

        </form>

        <form id="reg_form" action="../index.php" method="POST">

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario">

            <label for="password">Contraseña</label>
            <input type="password" id="password">

            <label for="conpassword">Confirmar Contraseña</label>
            <input type="password" id="conpassword">

            <button id="submitReg">Registrarse</button>

            <input id="terminos" type="checkbox">
            <label for="terminos">Acepto los <a href="#">terminos y condiciones</a></label>

        </form>
    </div>
    
</body>
</html>
