<!DOCTYPE html>
<html lang="es-ES">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/navBar.php"; ?>
<main>
    <a href="/admin/adminPanel">Volver</a>
    <table>
        <thead>
        <tr>
            <th>Id</th>
            <th>Id cuenta</th>
            <th>Id negocio</th>
            <th>Título</th>
            <th>Fecha de creación</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <tr>
                    <td><?=$review["reviewId"]?></td>
                    <td><?=$review["accountId"]?></td>
                    <td><?=$review["businessId"]?></td>
                    <td><?=$review["title"]?></td>
                    <td><?=$review["creationDate"]?></td>
                    <td><a href="/admin/reviews/delete?review_id=<?=$review["reviewId"]?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
