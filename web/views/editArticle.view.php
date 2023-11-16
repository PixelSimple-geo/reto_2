<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Editar Articulo</title>
</head>
<body>
    <?php require "partials/navBar.php"; ?>

    <main class="formulario">

        <a href="/articles">Volver a mis articulos</a>
        <h2>Editar Articulo</h2>

        <?php
            //TODO necesito la funcion para recibir los datos del articulo a editar
            if (isset($_GET['id'])) {
                $articuloId = $_GET['id'];
                $articuloDetalles = obtenerDetallesArticuloPorId($articuloId);
            
                if ($articuloDetalles) {            
                    echo '<form action="/guardarEdicionArticulo" method="POST">';
                    echo '  <label for="nombre">Nombre del Articulo:</label>';
                    echo '  <input type="text" id="nombre" name="nombre" placeholder="' . $articuloDetalles['title'] . '" required>';
            
                    echo '  <label for="categoria">Categoría:</label>';
                    echo '  <select id="categoria" name="categoria" required>';
                    
                    //TODO categorias articles
                    foreach ($categorias as $categoria) {
                        echo '<option placeholder="' . $categoria . '"';
                        if ($articuloDetalles['categoria'] == $categoria) {
                            echo ' selected';
                        }
                        echo '>' . $categoria . '</option>';
                    }
            
                    echo '  </select>';

                    echo '  <label for="descripcion">Descripción del Articulo:</label>';
                    echo '  <textarea id="descripcion" name="descripcion" rows="4" required>' . $articuloDetalles['description'] . '</textarea>';
            
                    echo '  <button type="submit">Guardar Cambios</button>';
                    echo '</form>';
                } else {
                    echo '<p>El artículo no existe.</p>';
                }
            } else {
                echo '<p>No se proporcionó un ID de artículo válido.</p>';
            }
        ?>  
    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
