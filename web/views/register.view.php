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

    <div class="register_container">
        <h2>Registro</h2>
        <form id="reg_form" action="../index.php" method="POST">

            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" required>

            <label for="conpassword">Confirmar Contraseña</label>
            <input type="password" id="conpassword" required>

            <label for="email">Email</label>
            <input type="email" id="email" required>

            <div>
                <input id="terminos" type="checkbox" required>
                <label for="terminos">*Acepto los terminos y condiciones</label>
            </div>
            
            <button id="submitReg">Registrarse</button>

        </form>

        <a href="login.view.php">¿Ya tienes cuenta? Inicia Sesion</a>
    </div>
    
</body>
</html>
