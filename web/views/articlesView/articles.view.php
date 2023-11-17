<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Articulos</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/articles">+ Crear Nuevo Articulo</a>
            <h2>Mis Articulos</h2>
            <div class="contents">
                <?php
                    if (isset($articulos)) {
                        foreach ($articulos as $articulo) {
                            echo '<div>';
                            echo '  <h3>' . $articulo['title'] . '</h3>';
                            echo '  <p>Dirección: ' . $articulo['description'] . '</p>';
                            echo '  <p>Categoría: ' . $articulo['category'] . '</p>';
                            echo '  <a href="/articles/' . $articulo['articleId'] . '">Editar Articulo</a>';
                            //TODO terminar el enlace de eliminacion
                            echo '  <a href="/.php?id=' . $articulo['articleId'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este articulo?\')" class="eliminar">Eliminar Articulo</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No tienes articulos registrados.</p>';
                    }
                ?>
            </div>
        </div>
        
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>