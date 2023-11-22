<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Articulo</title>
</head>
<body class="structure">
    
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/articles/crud/all">Volver a mis Articulos</a>
            <h2>Editar Artículo</h2>
        </div>

        <div class="formulario">
            <?php if(isset($article)):?>
                <form method="POST">
                    <input type="hidden" name="article_id" value="<?=$article["articleId"]?>">
                    <label for="title">Titulo del Articulo:</label>
                    <input id="title" name="title" required value="<?=$article["title"]?>">

                    <?php if(!empty($categories)): ?>
                        <label for="category">Categoría:</label>
                        <select id="category" name="category_id" required>
                            <?php foreach($categories as $category): ?>
                                <?php $selected = ($category["categoryId"] == $article["categoryId"] ? "selected" : ""); ?>
                                <option value="<?=$category["categoryId"]?>" <?=$selected?>><?=$category["name"]?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                    <label for="description">Descripción del Articulo:</label>
                    <textarea id="description" name="description" rows="4" required><?=$article["description"]?></textarea>

                    <button type="submit">Modificar artículo</button>
                </form>
            <?php endif; ?>
        </div>
    </main>


<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>