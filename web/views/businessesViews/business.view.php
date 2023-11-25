<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?=$business['name'];?> - Business Details</title>
</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/businesses/all">Volver a los comercios</a>

            <h1><?=$business['name']?></h1>
            <p><?=$business['description']?></p>

            <form id="filter-form" action="/businesses/business" method="get">
                <input type="hidden" name="business_id" value="<?= rawurlencode($business['businessId']) ?>">
                
                <div class="search filter">
                    <?php
                        $selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : [];

                        if (isset($business['advertCategories']) && is_array($business['advertCategories'])) {
                            foreach ($business['advertCategories'] as $category) {
                                echo '<label>';
                                echo $category['name'];
                                echo '<input type="checkbox" name="categories[]" value="' . $category['categoryId'] . '"';

                                if (in_array($category['categoryId'], $selectedCategories)) {
                                    echo ' checked';
                                }

                                echo '>';
                                echo '</label>';
                            }
                        } else {
                            echo '<p>No hay categorías disponibles.</p>';
                        }
                    ?>
                    <button type="submit">Filtrar</button>
                </div>
            </form>

            <h2>Adverts:</h2>
            <div class="contents">
                <?php if (isset($adverts)): ?>
                    <?php foreach ($adverts as $advert): ?>
                        <?php
                        $advertCategories = isset($advert['categories']) ? $advert['categories'] : [];
                        $showAdvert = empty($selectedCategories) || count(array_intersect($selectedCategories, $advertCategories)) > 0;
                        ?>

                        <?php if ($showAdvert): ?>
                            <?='<a href="/adverts/advert?advert_id=' . $advert['advertId'] . '">'; ?>
                                <div class="ad <?= isset($advert['categories']) && is_array($advert['categories']) ? implode(' ', $advert['categories']) : '' ?>">
                                    <?php if (isset($advert["coverImg"])): ?>
                                        <img src="<?= $advert['coverImg'] ?>" alt="Portada del anuncio">
                                    <?php endif; ?>
                                    <h3><?= $advert['title'] ?></h3>
                                    <p><?= $advert['description'] ?></p>
                                </div>
                        <?="</a>"?>
                        <?php endif; ?>

                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <?php if(isset($userAccount)): ?>
                <div class="formulario">
                    <form action="/reviews/crud/add" method="POST">
                        <h2>Escribe una reseña</h2>
                        <input type="hidden" name="business_id" value="<?=$business["businessId"]?>">
                        <label for="title">Título</label>
                        <input id="title" name="title" required>
                        <label for="body">Cuerpo</label>
                        <textarea id="body" name="description" placeholder="Escribe un comentario" required></textarea>
                        <div>
                            <label for="rating">Valoración</label>
                            <div>
                                <input type="range" id="rating" name="rating" min="1" max="5" />
                            </div>
                        </div>
                        <button type="submit">Enviar comentario</button>
                    </form>
                </div>
            <?php else: ?>
                <p>Si inicias sesión puedes realizar reseñas</p>
            <?php endif; ?>

            <div class="contents">
                <?php if(isset($reviews)): ?>
                    <?php foreach ($reviews as $review): ?>
                        <div>
                            <article id="<?=$review["reviewId"]?>">
                                <h1>Usuario: <?=$review["username"]?></h1>
                                <p>Valoración: <?=$review["rating"]?></p>
                                <h2><?=$review["title"]?></h2>
                                <p><?=$review["description"]?></p>
                                <form action="/reviewsLikes/crud" method="POST">
                                    <input type="hidden" name="business_id" value="<?= $review["businessId"] ?>">
                                    <input type="hidden" name="review_id" value="<?= $review["reviewId"] ?>">
                                    <section data-check>
                                        <input type="hidden" name="old_reaction" value="<?=isset($review["userFeedback"])?>">
                                        <input type="hidden" name="new_reaction" value="">
                                        <button type="submit" data-reaction="true"
                                            <?php if (isset($review["userFeedback"]) && $review["userFeedback"]) echo "checked"?>>
                                            <?=$review["likeCount"]?>
                                            <img src="/statics/media/thumb_up.svg" class="review-icon">
                                        </button>
                                        <button type="submit" data-reaction="false"
                                            <?php if (isset($review["userFeedback"]) && !$review["userFeedback"])
                                                echo "checked"?>>
                                            <?=$review["dislikeCount"]?>
                                            <img src="/statics/media/thumb_down.svg" class="review-icon">
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
</body>
</html>
