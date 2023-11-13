<!DOCTYPE html>
<html lang="en">
<head>
   
    <?php require "partials/head.php" ?>

    <title>Contacto</title>

</head>
<body>

    <?php require "partials/navvar.php"; ?>
    
    <div>

    
    </div>
    <div>
        <h3>Teléfono</h3>
        <p>Llámanos, estaremos encantados de conocerte!</p>
        <p>945 026 609</p>
    </div>

    <div>
        <h3>Email</h3>
        <p>Si prefieres escribirnos, nos pondremos en contacto contigo lo antes posible.</p>
        <p><a href="mailto:asociacioncomerciovitoria@gmail.com">asociacioncomerciovitoria@gmail.com</a></p>
    </div>

    <h3>Formulario de Contacto</h3>
    <form action="procesar_formulario.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="mensaje">Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="4" required></textarea>

        <button type="submit">Enviar</button>
    </form>

</body>
</html>
