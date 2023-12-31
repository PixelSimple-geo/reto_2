<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Negocio</title>
    <script src="/statics/js/businessNeeds.js"></script>
</head>
<body class="structure">

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main> 
        <div class="contentsContainer">
            <a href="/businesses/crud/all">Volver a mis negocios</a>
            <h2>Crear Nuevo Negocio</h2>

            <?php if(isset($feedback)): ?>
                <p class="feedbackMessage"><?=($feedback)?></p>
            <?php endif; ?>
        </div>
        <div class="formulario">

            <form method="POST" enctype="multipart/form-data">
                <label for="name">Nombre del Negocio:</label>
                <?php if(!empty($name)): ?>
                <input id="name" name="name" pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}" required
                    title="Ingresa entre 3 y 100 caracteres. Puedes usar letras, números caracteres y '_'" value="<?=$name?>">
                <?php else: ?>
                <input id="name" name="name" pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}" required
                    title="Ingresa entre 3 y 100 caracteres. Puedes usar letras, números caracteres y '_'">
                <?php endif; ?>

                <label for="description">Descripción del Negocio:</label>
                <?php if(!empty($description)): ?>
                    <textarea id="description" name="description" rows="4" required><?=$description?></textarea>
                <?php else: ?>
                    <textarea id="description" name="description" rows="4" required></textarea>
                <?php endif; ?>

                <?php if(isset($businessCategories)): ?>
                    <label for="category">Categoría</label>
                    <select id="category" name="business_category">
                        <?php foreach ($businessCategories as $businessCategory): ?>
                            <?php $selected = ($category == $businessCategory["categoryId"]) ? "selected" : ""; ?>
                            <option value="<?= $businessCategory["categoryId"] ?>" <?= $selected ?>>
                                <?= $businessCategory["name"] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <fieldset>
                    <legend>Contacto</legend>
                    <button type="button" onclick="agregarContacto()">+</button>
                    <div id="contactsContainer">
                        <?php if (!empty($contacts)): ?>
                            <?php foreach ($contacts as $index => $value): ?>
                            <div>
                                <label for=<?=$index . "_type"?>>Tipo de contacto</label>
                                <input id=<?=$index . "_type"?> value='<?=$value["type"]?>' name="contact_type[]">
                                <label for=<?=$index . "_value"?>>Dirección de medio</label>
                                <input id=<?=$index . "_value"?> value='<?=$value["value"]?>' name="contact_value[]">
                                <button data-script-delete-con-dir>Eliminar</button>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>
                    <button type="button" onclick="agregarDireccion()">+</button>
                    <div id="addressesContainer">
                        <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $index => $value): ?>
                                <div>
                                    <label for=<?=$index . "_address"?>>Dirección</label>
                                    <input id=<?=$index . "_address"?> value='<?=$value["address"]?>' name="addresses[]">
                                    <label for=<?=$index . "_postal_code"?>>Código postal de medio</label>
                                    <input id=<?=$index . "_postal_code"?> value='<?=$value["postalCode"]?>' name="postal_codes[]">
                                    <button data-script-delete-con-dir>Eliminar</button>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Imagen de portada</legend>
                    <input type="file" accept=".gif, .png, .jpeg, .jpg" name="cover_img" id="cover_img">
                </fieldset>

                <button type="submit">Crear Negocio</button>
            </form>
        </div>
        
    </main>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>