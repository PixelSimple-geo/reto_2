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
                    $itemsPerPage = 6;
                    $totalItems = count($articulos);

                    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $offset = ($currentPage - 1) * $itemsPerPage;

                    $pagedArticulos = array_slice($articulos, $offset, $itemsPerPage);

                    if (isset($pagedArticulos) && !empty($pagedArticulos)) {
                        foreach ($pagedArticulos as $articulo) {
                            echo '<div>';
                            echo '  <h3>' . $articulo['title'] . '</h3>';
                            echo '  <p>Dirección: ' . $articulo['description'] . '</p>';
                            echo '  <p>Categoría: ' . $articulo['category'] . '</p>';
                            echo '  <a href="/articles/' . $articulo['articleId'] . '">Editar Articulo</a>';
                            // TODO: Terminar el enlace de eliminación
                            echo '  <a href="/eliminar-articulo.php?id=' . $articulo['articleId'] . '" onclick="return confirm(\'¿Estás seguro de que deseas eliminar este artículo?\')" class="eliminar">Eliminar Articulo</a>';
                            echo '</div>';
                        }

                        $totalPages = ceil($totalItems / $itemsPerPage);

                        if ($totalPages > 1) {
                            echo '<ul class="paginas">';
                            for ($i = 1; $i <= $totalPages; $i++) {
                                $class = ($i == $currentPage) ? 'current' : '';
                                echo '<li><a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a></li>';
                            }
                            echo '</ul>';
                        }
                    } else {
                        echo '<p>No tienes artículos registrados.</p>';
                    }
                ?>
            </div>
        </div>
        
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
