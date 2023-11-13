<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login y Registro</title>
 
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>" ?>
    <form action="/login" method="post">
        <h3 id="form-title">Login</h3>

        <label for="usuario">Usuario</label>
        <input type="text" id="usuario" name="username">

        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password">

        <button id="submitButton">Iniciar Sesión</button>
        <div class="social">
          <div class="enlace">¿Has olvidado tu contraseña?</div>
        </div>
    </form>

    <script>
        const formTitle = document.getElementById('form-title');
        const submitButton = document.getElementById('submitButton');

        function toggleForm() {
            if (formTitle.textContent === 'Login') {
                formTitle.textContent = 'Registro';
                submitButton.textContent = 'Registrarse';
            } else {
                formTitle.textContent = 'Login';
                submitButton.textContent = 'Iniciar Sesión';
            }
        }

        formTitle.addEventListener('click', toggleForm);
    </script>
</body>
</html>
