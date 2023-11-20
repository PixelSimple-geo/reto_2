<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Articulo</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="formulario">
        <a href="/articles/crud/all">Volver a mis Articulos</a>
        <h2>Crear Nuevo Artículo</h2>

        <form method="POST">
            <label for="title">Titulo del Articulo:</label>
            <input id="title" name="title" required>

            <?php if(!empty($categories)): ?>
                <label for="category">Categoría:</label>
                <select id="category" name="category_id" required>
                    <?php foreach($categories as $category): ?>
                    <option value="<?=$category["categoryId"]?>"><?=$category["name"]?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <label for="description">Descripción del Articulo:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit">Crear Articulo</button>
        </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
