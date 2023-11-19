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
        <a href='/adverts/account/business/add?business_id=$business[businessId]'>+ Crear Nuevo Anuncio</a>
    <?php endif; ?>
        <a href="/businesses/crud/all">Volver a Mis Negocios</a>
    </nav>

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

    <?php if (!empty($advertCategories)): ?>
    <section>
        <h3>Categorías de anuncio</h3>
        <ul>
            <?php foreach ($advertCategories as $advertCategory): ?>
            <li id="<?= $advertCategory["categoryId"] ?>"><?= $advertCategory["name"] ?></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php endif; ?>

    <?php if (isset($adverts)): ?>
        <div class="contents">
            <h3>Anuncios</h3>
            <?php foreach ($adverts as $advert): ?>
                <article>
                    <img src='<?= htmlspecialchars($advert['coverImg']) ?>' alt='Portada del anuncio'>
                    <h2><?= htmlspecialchars($advert['title']) ?></h2>
                    <p><?= htmlspecialchars($advert['description']) ?></p>
                    <a href='/adverts/account/business/edit?advert_id=<?= $advert['advertId'] ?>'>
                        Editar anuncio
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>
<?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>