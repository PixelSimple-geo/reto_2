<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Editar Anuncio</title>
</head>
<body class="structure">
    
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>
        <div class="contentsContainer">
            <a href="/businesses/crud/business?business_id=<?=$businessId?>">Volver a Mis Negocios</a>
            <h2>Editar Anuncio</h2>
        </div>

        <div class="formulario">
            <?php if (isset($advert)) : ?>
                <form method='POST' enctype='multipart/form-data' id="form">
                    <input type="hidden" name="business_id" value=<?=$businessId?>>
                    <input type="hidden" name="advert_id" value=<?=$advert["advertId"]?>>
                    <label for='title'>Título del Anuncio:</label>
                    <input id='title' name='title' required value='<?= $advert['title'] ?>'>

                    <label for='description'>Descripción del Anuncio:</label>
                    <textarea id='description' name='description' rows='4' required><?= $advert['description'] ?></textarea>

                    <?php if (isset($categories)): ?>
                        <fieldset>
                            <legend>Categoría</legend>
                            <label for='category'>Categoría</label>
                            <select id='category' name='advert_category'>
                                <option value=''>Sin categoría</option>
                                <?php foreach ($categories as $category): ?>
                                    <?php
                                    $selected = (in_array($category["categoryId"], $advertSelectedCategories)
                                        ? "selected" : "");
                                    ?>
                                    <option value='<?= $category['categoryId'] ?>' <?= $selected ?>>
                                        <?= $category['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </fieldset>
                    <?php endif; ?>


                    <fieldset>
                        <legend>Características</legend>
                        <?php foreach ($advert['characteristics'] as $index => $characteristic) : ?>
                        <label for='characteristic_type_<?= $characteristic['characteristicId'] ?>'>Característica:</label>
                        <input id='characteristic_type_<?= $characteristic['characteristicId'] ?>'
                            name='characteristic_type[]' value='<?= $characteristic['type'] ?>'>
                        <label for='characteristic_value_<?= $characteristic['characteristicId'] ?>'>Valor:</label>
                        <input id='characteristic_value_<?= $characteristic['characteristicId'] ?>'
                            name='characteristic_value[]' value='<?= $characteristic['value'] ?>'>
                        <?php endforeach; ?>
                    </fieldset>

                    <label for='cover_img'>Imagen de Portada:</label>
                    <?php if(isset($advert["coverImg"])): ?>
                    <div data-img>
                        <img src='<?= $advert['coverImg'] ?>' alt='Imagen de portada'>
                        <input type="hidden" name="cover_img_url" value="<?= $advert['coverImg'] ?>">
                        <button type="button" data-delete_img>Eliminar</button>
                    </div>
                    <?php endif; ?>
                    <input type='file' id='cover_img' name='cover_img' accept='image/*'>

                    <label for='images'>Imágenes</label>
                    <?php if(isset($advert["images"])): ?>
                        <section class="imgAdvertsCrud">
                            <?php foreach ($advert['images'] as $index => $image) : ?>
                            <div data-img >
                                <img src='<?= $image['url'] ?>' alt='Imagen de anuncio'>
                                <button type="button" data-delete_img="<?=$image["imageId"]?>">Eliminar</button>
                            </div>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                    <input type='file' id='images' name='images[]' accept='image/*' multiple>

                    <button type='submit'>Guardar Cambios</button>
                </form>
            <?php endif; ?>
        </div>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
<script defer>

    document.querySelectorAll("[data-delete_img]").forEach(element => {
        element.addEventListener("click", () => {
            const url = element.getAttribute("data-delete_img");
            document.getElementById("form")
                .insertAdjacentHTML("beforeend", `<input type="hidden" name="images_ids[]" value="${url}">`)
            element.closest("[data-img]").remove()
        });
    });

</script>
</html>
