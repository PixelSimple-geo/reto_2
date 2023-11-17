<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Negocios</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <a href="/businesses/account/add">+ Crear Nuevo Negocio</a>
        <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>"?>
        <h2>Mis Negocios</h2>
        <?php
            if (isset($businesses)) {
                foreach ($businesses as $business) {
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
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
