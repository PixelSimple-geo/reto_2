<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Editar Negocio</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="/statics/js/editBusiness.js"></script>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main class="formulario">
        <a href="/businesses/crud/all">Volver a mis negocios</a>
        <h2>Editar Negocio</h2>

        <?php if (isset($business)): ?>
            <form method="POST">
                <input type='hidden' name='business_id' value='<?= $business['businessId'] ?>'>
                <label for="nombre">Nombre del Negocio:</label>
                <input type="text" id="nombre" name="name" value="<?= $business['name'] ?>" required>
                <label for="descripcion">Descripción del Negocio:</label>
                <textarea id="descripcion" name="description" rows="4" required minlength="5" maxlength="1500"><?= $business['description'] ?></textarea>

                <?php if (isset($categories)): ?>
                    <label for="category">Categorías</label>
                    <select id="category" name="business_category">
                        <?php foreach ($categories as $category): ?>
                            <?php $isSelected = ($business['category']['categoryId'] === $category['categoryId']); ?>
                            <option value="<?= $category['categoryId'] ?>" <?= ($isSelected) ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>

                <fieldset>
                    <legend>Contacto</legend>
                    <?php foreach ($business['contacts'] as $contact): ?>
                        <div>
                            <label for='type_<?= $contact['contactId'] ?>'>Tipo de contacto</label>
                            <input id='type_<?= $contact['contactId'] ?>' value='<?= $contact['type'] ?>' name='contact_type[]'>
                            <label for='value_<?= $contact['contactId'] ?>'>Dirección de medio</label>
                            <input id='value_<?= $contact['contactId'] ?>' value='<?= $contact['value'] ?>' name='contact_value[]'>
                            <button type='button' class='eliminarContacto'>Eliminar</button>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <button type="button" id="agregarContacto">Agregar Contacto</button>

                <fieldset>
                    <legend>Dirección</legend>
                    <?php foreach ($business['addresses'] as $address): ?>
                        <div>
                            <label for='address_<?= $address['addressId'] ?>'>Dirección</label>
                            <input id='address_<?= $address['addressId'] ?>' value='<?= $address['address'] ?>' name='addresses[]'>
                            <label for='postal_code_<?= $address['addressId'] ?>'>Código Postal</label>
                            <input id='postal_code_<?= $address['addressId'] ?>' value='<?= $address['postalCode'] ?>' name='postal_codes[]'>
                            <button type='button' class='eliminarDireccion'>Eliminar</button>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
                <button type="button" id="agregarDireccion">Agregar Dirección</button>
                <br>
                <button type="submit">Guardar Cambios</button>
            </form>
        <?php endif; ?>
    </main>


    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
