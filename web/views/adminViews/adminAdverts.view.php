<!DOCTYPE html>
<html lang="es-ES">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">
<?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/navBar.php"; ?>
<main>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Id negocio</th>
                <th>Título</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($adverts)): ?>
            <?php foreach ($adverts as $advert): ?>
            <tr>
                <td><?=$advert["advertId"]?></td>
                <td><?=$advert["businessId"]?></td>
                <td><?=$advert["title"]?></td>
                <td><?=$advert["creationDate"]?></td>
                <td><a href="/admin/adverts/delete?advert_id=<?=$advert["advertId"]?>">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>