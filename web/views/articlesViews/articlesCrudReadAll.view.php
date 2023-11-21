<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Mis Articulos</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/articles/crud/add">+ Crear Nuevo Artículo</a>
            <h2>Mis Articulos</h2>
            <div class="contents">
                <div>
                    <?php if(isset($articles)): ?>

                    <?php foreach ($articles as $article):?>
                        <article>
                            <?php if(isset($article["modifiedDate"])):?>
                                <p><?=$article["modifiedDate"]?></p>
                            <?php else: ?>
                                <p><?=$article["createdDate"]?></p>
                            <?php endif; ?>
                            <h1><?=$article["title"]?></h1>
                            <?php if(isset($article["categoryName"])):?>
                                <p><?=$article["categoryName"]?></p>
                            <?php endif; ?>
                            <p><?=$article["description"]?></p>
                            <nav>
                                <a href="/articles/crud/edit?article_id=<?=$article["articleId"]?>">
                                    Editar artículo
                                </a>
                                <a href="/articles/crud/delete?article_id=<?=$article["articleId"]?>">
                                    Eliminar anuncio
                                </a>
                            </nav>
                        </article>
                    <?php endforeach ?>

                    <?php endif; ?>
                </div>
            </div>
        </div>
        
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
