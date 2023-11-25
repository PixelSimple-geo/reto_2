<!DOCTYPE html>
<html lang="en">

<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title><?= $business['name']; ?> - Business Details</title>
</head>

<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/businesses/all">Volver a los comercios</a>

            <h1><?= $business['name'] ?></h1>
            <h4><?= $business['description'] ?></h4>

            <!-- Obtener las categorías del negocio -->
            <?php
            $businessCategories = isset($business['advertCategories']) && is_array($business['advertCategories']) ? $business['advertCategories'] : [];
            ?>

            <form id="filter-form" action="/businesses/business" method="get">
                <input type="hidden" name="business_id" value="<?= rawurlencode($business['businessId']) ?>">

                <div class="search filter">
                    <button type="submit"><img src="/statics/media/search.svg" alt="search"></button>

                    <!-- Mostrar categorías del negocio -->
                    <?php
                    $selectedCategories = isset($_GET['categories']) ? $_GET['categories'] : [];

                    if (!empty($businessCategories)) :
                        foreach ($businessCategories as $category) :
                    ?>
                            <label>
                                <?= $category['name'] ?>
                                <input type="checkbox" name="categories[]" value="<?= $category['categoryId'] ?>" <?= in_array($category['categoryId'], $selectedCategories) ? ' checked' : '' ?>>
                            </label>
                    <?php
                        endforeach;
                    else :
                    ?>
                        <p>No hay categorías disponibles.</p>
                    <?php endif; ?>
                </div>
            </form>

            <h2>Adverts:</h2>
            <div class="contents">
                <?php
                if (isset($adverts)) {
                    foreach ($adverts as $advert) {
                        $advertCategories = isset($advert['categories']) ? $advert['categories'] : [];
                        $hasSelectedCategory = empty($selectedCategories) || count(array_intersect($selectedCategories, $advertCategories)) > 0;
                        /*
                        print_r($selectedCategories);
                        print_r($advertCategories);
                        */

                        if ($hasSelectedCategory) {
                            echo '<a href="/adverts/advert?advert_id=' . $advert['advertId'] . '">';
                            echo '<div' . (isset($advert['categories']) && is_array($advert['categories']) ? ' class="' . implode(' ', $advert['categories']) . '"' : '') . '>';
                            if (isset($advert["coverImg"])) {
                                echo '<img src="' . $advert['coverImg'] . '" alt="Portada del anuncio">';
                            }
                            echo '<h3>' . $advert['title'] . '</h3>';
                            echo '<p>' . $advert['description'] . '</p>';
                            echo '</div>';
                            echo '</a>';
                        }
                    }
                }
                ?>
            </div>
        </div>
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

</body>

</html>
