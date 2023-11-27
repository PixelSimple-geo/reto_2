<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <script src="/statics/js/ckUnchecked.js" defer></script>
    <title><?= $business['name']; ?> - Business Details</title>
</head>

<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/businesses/all">Volver a los comercios</a>

            <h1><?= $business['name'] ?></h1>
            <p><?= $business['description'] ?></p>

            <form id="filter-form" action="/businesses/business" method="get">
                <input type="hidden" name="business_id" value="<?= $business['businessId'] ?>">

                <div class="search filter">
                    <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>
                    <div>
                        <?php
                        if (!empty($business['advertCategories'])) :
                            foreach ($business['advertCategories'] as $category) :
                        ?>
                                <label>
                                    <?= $category['name'] ?>
                                    <input type="checkbox" name="categories[]" value="<?= $category['categoryId'] ?>" <?= in_array($category['categoryId'], $_GET['categories'] ?? []) ? ' checked' : '' ?>>
                                </label>
                        <?php
                            endforeach;
                        else :
                        ?>
                            <p>No hay categorías disponibles.</p>
                        <?php endif; ?>
                    </div>
                    <button type="button" id="uncheck-all"><img src="/statics/media/x.svg" alt="desmarcar"></button>
                </div>
            </form>
            </form>

            <h2>Adverts:</h2>
            <div class="contents">
                <?php

                if (isset($adverts)) {

                    foreach ($adverts as $advert) {
                        $advertCategories = isset($advert['categories']) ? $advert['categories'] : [];

                ?>
                            <a href="/adverts/advert?advert_id=<?= $advert['advertId'] ?>">
                                <div class="ad <?= (isset($advert['categories']) && is_array($advert['categories']) ? implode(' ', $advert['categories']) : '') ?>">
                                    <?php if (isset($advert["coverImg"])) : ?>
                                        <img src="<?= $advert['coverImg'] ?>" alt="Portada del anuncio">
                                    <?php endif; ?>
                                    <h3><?= $advert['title'] ?></h3>
                                    <p><?= $advert['description'] ?></p>
                                </div>
                            </a>
                <?php
                                            }
                }
                ?>
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
                        <article id="<?= $review["reviewId"] ?>">
                            <h1>Usuario: <?= $review["username"] ?></h1>
                            
                            <?php
                                $rating = $review["rating"];
                                $ratingText = "";
                                $ratingColor = "";

                                switch ($rating) {
                                    case 1:
                                        $ratingText = "Muy Mala";
                                        $ratingColor = "red";
                                        break;
                                    case 2:
                                        $ratingText = "Mala";
                                        $ratingColor = "orange";
                                        break;
                                    case 3:
                                        $ratingText = "Media";
                                        $ratingColor = "yellow";
                                        break;
                                    case 4:
                                        $ratingText = "Buena";
                                        $ratingColor = "lightgreen";
                                        break;
                                    case 5:
                                        $ratingText = "Muy Buena";
                                        $ratingColor = "green";
                                        break;
                                    default:
                                        $ratingText = "Desconocida";
                                        $ratingColor = "black";
                                }
                            ?>

                            <p style="color: <?= $ratingColor ?>">Valoración: <?= $ratingText ?></p>

                            <h2><?= $review["title"] ?></h2>
                            <p><?= $review["description"] ?></p>
                                <form action="/reviewsLikes/crud" method="POST">
                                    <input type="hidden" name="business_id" value="<?= $review["businessId"] ?>">
                                    <input type="hidden" name="review_id" value="<?= $review["reviewId"] ?>">
                                    <section data-check>
                                        <input type="hidden" name="old_reaction" value="<?=isset($review["userFeedback"])?>">
                                        <input type="hidden" name="new_reaction" value="">
                                        <?php if(isset($userAccount)): ?>
                                        <button type="button" data-reaction="true"
                                            <?php if (isset($review["userFeedback"]) && $review["userFeedback"]) echo "checked"?>>
                                            <span><?=$review["likeCount"]?></span>
                                            <img src="/statics/media/thumb_up.svg" class="review-icon">
                                        </button>
                                        <button type="button" data-reaction="false"
                                            <?php if (isset($review["userFeedback"]) && !$review["userFeedback"])
                                                echo "checked"?>>
                                            <span><?=$review["dislikeCount"]?></span>
                                            <img src="/statics/media/thumb_down.svg" class="review-icon">
                                        </button>
                                        <?php else: ?>
                                            <button type="button"
                                                <?php if (isset($review["userFeedback"]) && $review["userFeedback"]) echo "checked"?>>
                                                <?=$review["likeCount"]?>
                                                <img src="/statics/media/thumb_up.svg" class="review-icon">
                                            </button>
                                            <button type="button"
                                                <?php if (isset($review["userFeedback"]) && !$review["userFeedback"])
                                                    echo "checked"?>>
                                                <?=$review["dislikeCount"]?>
                                                <img src="/statics/media/thumb_down.svg" class="review-icon">
                                            </button>
                                        <?php endif; ?>
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

</html>
