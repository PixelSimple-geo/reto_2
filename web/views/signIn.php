<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registro</title>
 
    <?php require "partials/head.php" ?>

</head>
<body>

        <a href="/index" class="home">
            <img src= "/statics/media/comvit.png" alt="Volver al Home">
        </a>

    <div class="register_container">
        <h2>Registro</h2>

        <?php if(isset($errorMessage)) echo $errorMessage ?>

        <form id="reg_form" action="/signIn" method="POST">

            <label for="usuario">Usuario</label>
            <?php if(isset($username)): ?>
                <input type="text" id="usuario" required name="username" value="<?=$username?>">
            <?php else: ?>
                <input type="text" id="usuario" required name="username">
            <?php endif; ?>

            <label for="password">Contraseña</label>
            <input type="password" id="password" required name="password">

            <label for="conpassword">Confirmar Contraseña</label>
            <input type="password" id="conpassword" required>

            <label for="email">Email</label>
            <?php if(isset($email)): ?>
                <input type="email" id="email" required name="email" value="<?=$email?>">
            <?php else: ?>
                <input type="email" id="email" required name="email">
            <?php endif; ?>

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
