<!DOCTYPE html>
<html lang="en">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php"; ?>
    <title>Product Details</title>
</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <div class="contentsContainer">
        <?php if ($advert): ?>
            <div class="">
                <h3><?= htmlspecialchars($advert['title']) ?></h3>
                <img src="<?= htmlspecialchars($advert['coverImg']) ?>" alt="Product Image">
                <h4><?= htmlspecialchars($advert['description']) ?>
                <br>

                <?php if (!empty($advert['characteristics'])): ?>
                    <?php $hasNonEmptyCharacteristics = false; ?>

                    <?php foreach ($advert['characteristics'] as $char): ?>
                        <?php if (!empty(trim($char['value']))): ?>
                            <?php $hasNonEmptyCharacteristics = true; ?>
                            <?php break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($hasNonEmptyCharacteristics): ?>
                        <h4>Características:</h4>
                        <ul>
                            <?php foreach ($advert['characteristics'] as $char): ?>
                                <?php if (!empty(trim($char['value']))): ?>
                                    <li><strong><?= htmlspecialchars($char['type']) ?>: &nbsp; </strong> <?= htmlspecialchars($char['value']) ?></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <h4>Product not found.</h4>
        <?php endif; ?>

        <?php if (!empty($advert['categories'])): ?>
            <div class="categories">
                <h4>Categories:</h4>
                <ul>
                    <?php foreach ($advert['categories'] as $category): ?>
                        <?php if (is_array($category) && isset($category['name'])): ?>
                            <li><?= htmlspecialchars($category['name']) ?></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <?php if (isset($advert["images"])): ?>
        <section class="contents">
            <?php foreach ($advert['images'] as $index => $image): ?>
                <div>
                    <img src='<?= htmlspecialchars($image['url'])?>' alt='Imagen de anuncio'>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php"; ?>

</body>
</html>
