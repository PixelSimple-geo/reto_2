<!DOCTYPE html>
<html lang="es-ES">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"?>
    <title>Inicio | Reto 2</title>
</head>

<body class="structure">
    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/navBar.php"; ?>

    <main>

    <?php require_once $_SERVER["DOCUMENT_ROOT"] . "/views/partials/adminNav.php"; ?>

        <div class="contentsContainer">
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Id artículo</th>
                    <th>Id comentador</th>
                    <th>Título</th>
                    <th>Fecha de creación</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($commentaries)): ?>
                    <?php foreach ($commentaries as $commentary): ?>
                        <tr>
                            <td><?=$commentary["commentaryId"]?></td>
                            <td><?=$commentary["articleId"]?></td>
                            <td><?=$commentary["commentatorId"]?></td>
                            <td><?=$commentary["title"]?></td>
                            <td><?=$commentary["creationDate"]?></td>
                            <td><a href="/admin/commentaries/delete?commentary_id=<?=$commentary["commentaryId"]?>">Eliminar</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
