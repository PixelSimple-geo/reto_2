<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registro</title>
 
    <!--CSS-->
    <link rel="stylesheet" href="../statics/css/reset.css">
    <link rel="stylesheet" href="../statics/css/style.css">

    <!--JS-->
    <script src="../statics/js/logreg.js" defer></script>

</head>
<body>

        <a href="/index" class="home">
            <img src= "../statics/media/logo2.png" alt="Volver al Home">
        </a>

    <div class="register_container">
        <h2>Registro</h2>

        <?php if(isset($errorMessage)) echo $errorMessage ?>

        <form id="reg_form" action="/signIn" method="POST">

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" required name="username">

            <label for="password">Contraseña</label>
            <input type="password" id="password" required name="password">

            <label for="conpassword">Confirmar Contraseña</label>
            <input type="password" id="conpassword" required>

            <label for="email">Email</label>
            <input type="email" id="email" required name="email">

            <div>
                <input id="terminos" type="checkbox" required>
                <label for="terminos">*Acepto los terminos y condiciones</label>
            </div>
            
            <button id="submitReg" type="submit">Registrarse</button>

        </form>

        <a href="/login">¿Ya tienes cuenta? Inicia Sesion</a>
    </div>
    
</body>
</html>
