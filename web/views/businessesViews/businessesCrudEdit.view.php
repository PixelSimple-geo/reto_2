<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Editar Negocio</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body class="structure">
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <main>

        <div class="contentsContainer">
            <a href="/businesses/crud/all">Volver a mis negocios</a>
            <h2>Editar Negocio</h2>

            <?php if(isset($feedback)): ?>
            <p style="color: red"><?=($feedback)?></p>
            <?php endif; ?>
        </div>
 
        <div class="formulario">
            <?php if (isset($business)): ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type='hidden' name='business_id' value='<?= $business['businessId'] ?>'>
                    <label for="nombre">Nombre del Negocio:</label>
                    <input type="text" id="nombre" name="name" value="<?= $business['name'] ?>" required
                        pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}"
                        title="Ingresa entre 3 y 100 caracteres. Puedes usar letras, números caracteres y '_'">

                    <label for="descripcion">Descripción del Negocio:</label>
                    <textarea id="descripcion" name="description" rows="4" required minlength="5" maxlength="1500"><?= $business['description'] ?></textarea>

                    <label for="category">Categoría</label>
                    <?php if(isset($categories)): ?>
                        <select id="category" name="business_category">
                            <?php foreach ($categories as $category): ?>
                                <?php $selected = $category["categoryId"] == $business["category"]["categoryId"]
                                    ? "selected" : ""; ?>
                                <option value="<?= $category["categoryId"] ?>" <?= $selected ?>>
                                    <?= $category["name"] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php endif; ?>

                <fieldset>
                    <legend>Contacto</legend>
                    <button type="button" onclick="agregarContacto()">+</button>
                    <div id="contactsContainer">
                        <?php foreach ($business['contacts'] as $contact): ?>
                            <div>
                                <label for='type_<?= $contact['contactId'] ?>'>Tipo de contacto</label>
                                <input id='type_<?= $contact['contactId'] ?>' value='<?= $contact['type'] ?>' name='contact_type[]'
                                    pattern="^.{1,100}$" title="Ingresa entre 1 y 100 caracteres para el tipo de contacto">
                                
                                <label for='value_<?= $contact['contactId'] ?>'>Dirección de medio</label>
                                <input id='value_<?= $contact['contactId'] ?>' value='<?= $contact['value'] ?>' name='contact_value[]'
                                    pattern="^.{1,255}$" title="Ingresa entre 1 y 255 caracteres para la dirección de medio">
                                
                                <button data-script-delete-con-dir>Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!empty($contacts)): ?>
                            <?php foreach ($contacts as $index => $value): ?>
                            <div>
                                <label for=<?=$index . "_type"?>>Tipo de contacto</label>
                                <input id=<?=$index . "_type"?> value='<?=$value["type"]?>' name="contact_type[]">
                                <label for=<?=$index . "_value"?>>Dirección de medio</label>
                                <input id=<?=$index . "_value"?> value='<?=$value["value"]?>' name="contact_value[]">
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>
                    <button type="button" onclick="agregarDireccion()">+</button>
                    <div id="addressesContainer">
                        <?php foreach ($business['addresses'] as $address): ?>
                            <div>
                                <label for='address_<?= $address['addressId'] ?>'>Dirección</label>
                                <input id='address_<?= $address['addressId'] ?>' value='<?= $address['address'] ?>' name='addresses[]'
                                    pattern="^.{1,100}$" title="Ingresa entre 1 y 100 caracteres para la dirección">
                                
                                <label for='postal_code_<?= $address['addressId'] ?>'>Código Postal</label>
                                <input id='postal_code_<?= $address['addressId'] ?>' value='<?= $address['postalCode'] ?>' name='postal_codes[]'
                                    pattern="[0-9]{5}" title="Ingresa un número de 5 dígitos para el código postal">
                                
                                <button data-script-delete-con-dir>Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                        <?php if (!empty($addresses)): ?>
                            <?php foreach ($addresses as $index => $value): ?>
                                <div>
                                    <label for=<?=$index . "_address"?>>Dirección</label>
                                    <input id=<?=$index . "_address"?> value='<?=$value["address"]?>' name="addresses[]">
                                    <label for=<?=$index . "_postal_code"?>>Código postal de medio</label>
                                    <input id=<?=$index . "_postal_code"?> value='<?=$value["postalCode"]?>' name="postal_codes[]">
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <fieldset>
                        <?php if(isset($business["coverImg"])):?>
                            <input type="hidden" name="old_cover_img" value="<?=$business["coverImg"]?>">
                            <img src="<?=$business["coverImg"]?>">
                        <?php endif;?>
                        <input type="file" accept=".gif, .png, .jpeg, .jpg" name="cover_img" id="cover_img">
                    </fieldset>
                </fieldset>
                    <br>
                    <button type="submit">Guardar Cambios</button>
                </form>
            <?php endif; ?>
        </div>        
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
