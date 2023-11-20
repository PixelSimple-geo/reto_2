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
        <form method="POST">
            <label for="title">Título</label>
            <input id="title" name="title">
            <label for="body">Cuerpo</label>
            <textarea id="body" name="body" placeholder="Escribe un comentario"></textarea>
            <button type="submit"></button>
        </form>
    </main>
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
