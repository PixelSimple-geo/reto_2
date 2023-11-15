<!DOCTYPE html>
<html lang="es">
<head>
<?php require "partials/head.php" ?>

    <title>Editar Articulo</title>
</head>
<body>

    <main class="formulario">

        <a href="/articles">Volver a mis articulos</a>
        <h2>Editar Articulo</h2>

        <form action="/guardarEdicionArticulo" method="POST">
            <label for="titulo">Titulo del Articulo:</label>
            <input type="text" id="titulo" name="titulo" value="Mi Articulo" required>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria" required>
                <option value="tecnologia" selected>Tecnología</option>
                <option value="moda">Moda</option>
                <option value="deporte">Deporte</option>
            </select>

            <label for="descripcion">Descripción del Articulo:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required>Descripción de mi artículo.</textarea>


            <button type="submit">Guardar Cambios</button>
        </form>
        
    </main>

</body>
</html>
