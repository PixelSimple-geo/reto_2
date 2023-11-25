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
                <th>Título</th>
                <th>Fecha de creación</th>
            </tr>
        </thead>
        <tbody>
        <?php if(isset($articles)): ?>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?=$article["articleId"]?></td>
                <td><?=$article["accountId"]?></td>
                <td><?=$article["title"]?></td>
                <td><?=$article["createdDate"]?></td>
                <td><a href="/admin/articles/delete?article_id=<?=$article["articleId"]?>">Eliminar</a></td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>