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
        <div class="formulario">
            <form action="/reviews/crud/add" method="POST">
                <input type="hidden" name="business_id" value="<?=$business["businessId"]?>">
                <label for="title">Título</label>
                <input id="title" name="title" required>
                <label for="body">Cuerpo</label>
                <textarea id="body" name="description" placeholder="Escribe un comentario" required></textarea>
                <div>
                    <label for="rating">Valoración</label>
                    <input type="range" id="rating" name="rating" min="1" max="5" />
                </div>
                <button type="submit">Enviar comentario</button>
            </form>
        </div>
        <div class="contentsContainer">
            <div class="contents">
                    <?php if(isset($reviews)): ?>
                        <?php foreach ($reviews as $review): ?>
                            <div>
                                <article id="<?=$review["reviewId"]?>">
                                    <!--TODO: esta bugeado, userAccount te coje la cuenta que esta iniciada, no la cuenta que ha hecho la review -->
                                    <?php if(isset($userAccount["username"])):?>
                                    <h2><?=$userAccount["username"]?></h2>
                                    <?php endif; ?>
                                    <p>Valoración: <?=$review["rating"]?></p>
                                    <h2><?=$review["title"]?></h2>
                                    <p><?=$review["description"]?></p>
                                    <form action="/likes/crud/add" method="POST">
                                        <input type="hidden" name="business_id" value="<?= $review["businessId"] ?>">
                                        <input type="hidden" name="review_id" value="<?= $review["reviewId"] ?>">
                                        <section data-check>
                                            <input type="hidden" name="old_reaction" value="<?=isset($review["userFeedback"])?>">
                                            <input type="hidden" name="new_reaction" value="">
                                            <button type="submit" data-reaction="true"
                                                <?php if ($review["userFeedback"]) echo "checked"?>>
                                                <?=$review["likeCount"]?>
                                                Like
                                            </button>
                                            <button type="submit" data-reaction="false"
                                                <?php if (isset($review["userFeedback"]) && !$review["userFeedback"])
                                                    echo "checked"?>>
                                                <?=$review["dislikeCount"]?>
                                                Dislike
                                            </button>
                                        </section>
                                    </form>
                                    <?php if(isset($review["modifiedDate"])):?>
                                        <p>Fecha: <?= date("Y-m-d", strtotime($review["modifiedDate"])) ?></p>
                                    <?php else: ?>
                                        <p>Fecha: <?= date("Y-m-d", strtotime($review["creationDate"])) ?></p>
                                    <?php endif; ?>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
            </div>
        </div>
            
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
