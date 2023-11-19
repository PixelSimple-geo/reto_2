<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Ver Anuncios</title>
</head>
<body>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>
<main>
    <nav>
    <?php if (isset($business)): ?>
        <a href='/adverts/crud/add?business_id=<?=$business["businessId"]?>'>+ Crear Nuevo Anuncio</a>
    <?php endif; ?>
        <a href="/businesses/crud/all">Volver a Mis Negocios</a>
    </nav>

    <?php if(!empty($feedback)): ?>
    <p style="color: red"><?=$feedback?></p>
    <?php endif; ?>

    <?php if(!empty($business)): ?>
    <h2><?= htmlspecialchars($business["name"]) ?></h2>
        <?php if(!empty($category)): ?>
            <p id=<?=$category['categoryId']?>><?=$category["name"]?></p>
        <?php endif; ?>
    <p><?= htmlspecialchars($business['description']) ?></p>
    <?php endif; ?>

    <?php if(!empty($contacts)): ?>
        <section>
            <h3>Contacto</h3>
            <?php foreach ($contacts as $contact): ?>
                <p><?php echo "$contact[type]: $contact[value]"  ?></p>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <?php if(!empty($addresses)): ?>
    <section>
        <h3>Direcciones</h3>
        <?php foreach ($addresses as $address): ?>
        <p><?php echo "$address[address], $address[postalCode]"  ?></p>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <section>
        <form action="/businesses/advertCategory/add" method="POST">
            <input type="hidden" name="business_id" value=<?= $business["businessId"] ?>>
            <label for="advert_category_name">Añadir categoría de anuncio</label>
            <input id="advert_category_name" name="name" pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}"
                   title="Ingresa entre 3 y 100 caracteres. Puedes usar letras, números caracteres y '_'">
            <button type="submit">Crear categoría</button>
        </form>
        <h3>Categorías de anuncio</h3>
        <?php if (!empty($advertCategories)): ?>
        <ul>
            <?php foreach ($advertCategories as $advertCategory): ?>
            <li id="<?= $advertCategory["categoryId"] ?>">
                <?= $advertCategory["name"] ?>
                <a href="/businesses/advertCategory/delete?category_id=<?=$advertCategory["categoryId"]?>&business_id=<?=$business["businessId"]?>"
                >Eliminar</a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </section>


    <?php if (isset($adverts)): ?>
        <div >
            <h3>Anuncios</h3>
            <div class="contents">
            <?php foreach ($adverts as $advert): ?>
                <article>
                    <img src='<?= htmlspecialchars($advert['coverImg']) ?>' alt='Portada del anuncio'>
                    <h2><?= htmlspecialchars($advert['title']) ?></h2>
                    <p><?= htmlspecialchars($advert['description']) ?></p>
                    <a href='/adverts/crud/edit?advert_id=<?= $advert['advertId'] ?>&business_id=<?=$business["businessId"]?>'>
                        Editar anuncio
                    </a>
                    <a href="/adverts/crud/delete?advert_id=<?=$advert["advertId"]?>&business_id=<?=$business["businessId"]?>">
                        Eliminar anuncio
                    </a>
                </article>
            <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>