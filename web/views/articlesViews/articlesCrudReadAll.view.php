<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Articulos</title>
</head>
<body class="structure">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/articles/crud/add">+ Crear Nuevo Artículo</a>
            <h2>Mis Articulos</h2>
            <div class="contents">
                    <?php if(isset($articles)): ?>
                    <?php foreach ($articles as $article):?>
                        <div>
                            <article>
                                <h1><?=$article["title"]?></h1>
                                <?php if(isset($article["categoryName"])):?>
                                    <p><?=$article["categoryName"]?></p>
                                <?php endif; ?>
                                <p><?=$article["description"]?></p>
                                <div class="enlaces">
                                    <a href="/articles/crud/edit?article_id=<?=$article["articleId"]?>">
                                        Editar artículo
                                    </a>
                                    <a href="/articles/crud/delete?article_id=<?=$article["articleId"]?>">
                                        Eliminar anuncio
                                    </a>
                                </div>
                            </article>
                        </div>
                    <?php endforeach ?>

                    <?php endif; ?>
            </div>
        </div>
        
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
