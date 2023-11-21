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
            <label for="rating">Valoración</label>
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
                            <input type="hidden" name="business_id" value="<?= $review["businessId"] ?>">
                            <input type="hidden" name="review_id" value="<?= $review["reviewId"] ?>">
                            <div data-check>
                                <input type="hidden" name="old_reaction" value="<?=$review["userFeedback"]?>">
                                <input type="hidden" name="new_reaction" value="">
                                <button type="submit" data-reaction="true"
                                    <?php if ($review["userFeedback"]) echo "checked"?>>
                                    Like
                                </button>
                                <button type="submit" data-reaction="false"
                                    <?php if (isset($review["userFeedback"]) && !$review["userFeedback"]) echo "checked"?>>
                                    Dislike
                                </button>
                            </div>
                        </form>

                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    </main>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
<script>

    document.querySelectorAll("[data-check] button").forEach((element => {
        element.addEventListener("click", (event) => {
            const element = event.target;
            const parent = event.target.parentNode;
            const input = parent.querySelector("input[name='new_reaction']")
            parent.querySelectorAll("button").forEach((element => {
                if (element !== event.target) element.removeAttribute("checked")
            }))
            if (element.hasAttribute("checked")) {
                element.removeAttribute("checked")
                input.value = "";
            } else {
                input.value =  element.getAttribute("data-reaction")
                element.setAttribute("checked", "");
            }
            console.log(input.value);
        });
    }));


</script>
</html>
