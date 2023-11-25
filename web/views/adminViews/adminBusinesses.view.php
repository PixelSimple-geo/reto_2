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
            <th>Id cuenta</th>
            <th>Nombre</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($businesses)): ?>
            <?php foreach ($businesses as $business): ?>
                <tr>
                    <td><?=$business["businessId"]?></td>
                    <td><?=$business["accountId"]?></td>
                    <td><?=$business["name"]?></td>
                    <td><a href="/admin/businesses/delete?business_id=<?=$business["businessId"]?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
