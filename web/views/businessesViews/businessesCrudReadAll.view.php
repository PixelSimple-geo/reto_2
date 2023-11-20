<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Negocios</title>
</head>
<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <?php if(isset($errorMessage)): ?>
                <p style="color:red;"><?=($errorMessage)?></p>
            <?php endif; ?>
            <?php if(isset($feedback)): ?>
                <p style="color:orange;"><?=($feedback)?></p>
            <?php endif; ?>

            <a href="/businesses/crud/add">+ Crear Nuevo Negocio</a>
            <h2>Mis Negocios</h2>
            <div class="contents">
                <?php
                $itemsPerPage = 6;
                $totalBusinesses = count($businesses);

                $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                $offset = ($currentPage - 1) * $itemsPerPage;

                $pagedBusinesses = array_slice($businesses, $offset, $itemsPerPage);

                if (isset($pagedBusinesses) && !empty($pagedBusinesses)) {
                    foreach ($pagedBusinesses as $business) {
                        echo '<div>';
                        echo '<h3>' . htmlspecialchars($business['name']) . '</h3>';
                        echo '<p>' . htmlspecialchars($business['description']) . '</p>';
                        echo '<a href="/businesses/crud/business?business_id=' . $business['businessId'] . '">Ver Anuncios</a>';
                        echo '<a href="/businesses/crud/edit?business_id=' . $business['businessId'] . '">Editar Negocio</a>';
                        echo '<a href="/businesses/crud/delete?business_id=' . $business['businessId'] . '">Eliminar negocio</a>';
                        echo '</div>';
                    }

                    $totalPages = ceil($totalBusinesses / $itemsPerPage);
                } else {
                    echo '<p>No tienes negocios disponibles.</p>';
                }
                ?>
            </div>
            <?php
            if (isset($totalPages) && $totalPages > 1) {
                echo '<ul class="paginas">';
                for ($i = 1; $i <= $totalPages; $i++) {
                    $class = ($i == $currentPage) ? 'current' : '';
                    $queryParams = http_build_query(array_merge($_GET, ['page' => $i]));
                    echo '<li><a href="?'.$queryParams.'" class="' . $class . '">' . $i . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
            