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
            <div class="formulario">
            <form method="POST" action="/admin/articlesCategories/add">
                <label for="name">Nombre de la categoría</label>
                <input id="name" name="name" required pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}" minlength="3" maxlength="50"
                    title="Patrón para Nombre: De 3 a 50 caracteres alfanuméricos">
                <button type="submit">Registrar categoría</button>
            </form>
            </div>
        
            <table>
                <thead>
                <tr>
                    <th>Id</th>
                    <td>Nombre</td>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?=$category["categoryId"]?></td>
                            <td><?=$category["name"]?></td>
                            <td><a href="/admin/articlesCategories/delete?category_id=<?=$category["categoryId"]?>">Eliminar</a></td>
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
