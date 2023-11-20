<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?=$business['name'];?> - Business Details</title>
</head>
<body>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>

        <div class="contentsContainer">
            <a href="/businesses/all">Volver a los comercios</a>

            <h1><?=$business['name']?></h1>

            <p><?=$business['description']?></p>
            <h2>Adverts:</h2>
            <div class="contents">
                <?php if(isset($adverts)):?>
                    <?php foreach ($adverts as $advert): ?>
                        <div>
                            <img src="<?= $advert['coverImg'] ?>" alt="Portada del anuncio">
                            <h3><?= $advert['title'] ?></h3>
                            <p>Description: <?= $advert['description'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <form action="/reviews/crud/add" method="POST">
            <input type="hidden" name="business_id" value="<?=$business["businessId"]?>">
            <label for="title">Título</label>
            <input id="title" name="title">
            <label for="body">Cuerpo</label>
            <textarea id="body" name="description" placeholder="Escribe un comentario"></textarea>
            <label for="rating">Volume</label>
            <input type="range" id="rating" name="rating" min="1" max="5" />
            <button type="submit">Enviar comentario</button>
        </form>

        <section>
            <?php if(isset($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                <article id="<?=$review["reviewId"]?>">
                    <?php if(isset($review["modifiedDate"])):?>
                    <p>Fecha: <?=$review["modifiedDate"]?></p>
                    <?php else: ?>
                        <p>Fecha: <?=$review["creationDate"]?></p>
                    <?php endif; ?>
                    <p>Valoración: <?=$review["rating"]?></p>
                    <h2><?=$review["title"]?></h2>
                    <p><?=$review["description"]?></p>
                    <p>Número de likes: <?=$review["likeCount"]?></p>
                    <p>Número de dislikes: <?=$review["dislikeCount"]?></p>
                    <form action="/likes/crud/add" method="POST">
                        <?php //TODO show if the user has already liked or disliked this review?>
                        <input type="hidden" name="business_id" value="<?=$business["businessId"]?>">
                        <input type="hidden" name="review_id" value="<?=$review["reviewId"]?>">
                        <label>Like<input type="checkbox" name="is_liked"></label>
                        <button type="submit">Enviar like</button>
                    </form>
                </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
