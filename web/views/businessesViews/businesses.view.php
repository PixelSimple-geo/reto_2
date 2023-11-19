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
            <a href="/businesses/account/add">+ Crear Nuevo Negocio</a>
            <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>"?>
            <h2>Mis Negocios</h2>
            <div class="contents">
                <?php
                    $itemsPerPage = 6;
                    $totalItems = count($businesses);

                    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $offset = ($currentPage - 1) * $itemsPerPage;

                    $pagedBusinesses = array_slice($businesses, $offset, $itemsPerPage);

                    if (isset($pagedBusinesses) && !empty($pagedBusinesses)) {
                        foreach ($pagedBusinesses as $business) {
                            echo '<div>';
                            echo ' <h3>' . $business['name'] . '</h3>';
                            echo ' <p>Descripción: ' . $business['description'] . '</p>';
                            echo " <a href='/adverts/account/business?business_id=$business[businessId]'>Ver Anuncios</a>";
                            echo ' <a href="/businesses/account/edit?business_id=' . $business["businessId"] . '">Editar Negocio</a>';
                            echo ' <a href="/businesses/account/delete?business_id=' . $business["businessId"] . '">Eliminar negocio</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No tienes negocios registrados.</p>';
                    }
                ?>
            </div>
            <?php
                $totalPages = ceil($totalItems / $itemsPerPage);

                if ($totalPages > 1) {
                    echo '<ul class="paginas">';
                    for ($i = 1; $i <= $totalPages; $i++) {
                        $class = ($i == $currentPage) ? 'current' : '';
                        echo '<li><a href="?page=' . $i . '" class="' . $class . '">' . $i . '</a></li>';
                    }
                    echo '</ul>';
                }
            ?>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
