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
            <h4><?=$business['description']?></h4>

            <form id="filter-form" action="/businesses/business" method="get">
                <input type="hidden" name="business_id" value="<?= rawurlencode($business['businessId']) ?>">
                
                <div class="search filter">
                    <?php
                        print_r($adverts);
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
                            <?php echo '<a href="/adverts/advert?advert_id=' . $advert['advertId'] . '">'; ?>
                                <div class="ad <?= isset($advert['categories']) && is_array($advert['categories']) ? implode(' ', $advert['categories']) : '' ?>">
                                    <?php if (isset($advert["coverImg"])): ?>
                                        <img src="<?= $advert['coverImg'] ?>" alt="Portada del anuncio">
                                    <?php endif; ?>
                                    <h3><?= $advert['title'] ?></h3>
                                    <p><?= $advert['description'] ?></p>
                                </div>
                            </a>
                        <?php endif; ?>

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
