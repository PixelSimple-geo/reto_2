<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Negocios</title>
</head>
<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>

        <?php if(isset($errorMessage)): ?>
            <p style="color:red;"><?=($errorMessage)?></p>
        <?php endif; ?>
        <?php if(isset($feedback)): ?>
            <p style="color:orange;"><?=($feedback)?></p>
        <?php endif; ?>

        <a href="/businesses/crud/add">+ Crear Nuevo Negocio</a>
        <h2>Mis Negocios</h2>
        <div class="contents">
            <?php if (isset($businesses)): ?>
                <?php foreach ($businesses as $business): ?>
                    <div>
                        <h3><?= htmlspecialchars($business['name']) ?></h3>
                        <p><?= htmlspecialchars($business['description']) ?></p>
                        <a href="/businesses/crud/business?business_id=<?= $business['businessId'] ?>">
                            Ver Anuncios
                        </a>
                        <a href="/businesses/crud/edit?business_id=<?= $business['businessId'] ?>">
                            Editar Negocio
                        </a>
                        <a href="/businesses/crud/delete?business_id=<?= $business['businessId'] ?>">
                            Eliminar negocio
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
