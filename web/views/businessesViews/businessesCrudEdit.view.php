<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Editar Negocio</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="/statics/js/editBusiness.js"></script>
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
                <form method="POST">
                    <input type='hidden' name='business_id' value='<?= $business['businessId'] ?>'>
                    <label for="nombre">Nombre del Negocio:</label>
                    <input type="text" id="nombre" name="name" value="<?= $business['name'] ?>" required
                        pattern="([\u{00C0}-\u{00FF}]|\w)([\u{00C0}-\u{00FF}]|\w|\s){3,100}"
                        title="Ingresa entre 3 y 100 caracteres. Puedes usar letras, números caracteres y '_'">

                    <label for="descripcion">Descripción del Negocio:</label>
                    <textarea id="descripcion" name="description" rows="4" required minlength="5" maxlength="1500"><?= $business['description'] ?></textarea>

                    <fieldset>
                        <legend>Contacto</legend>
                        <?php foreach ($business['contacts'] as $contact): ?>
                            <div>
                                <label for='type_<?= $contact['contactId'] ?>'>Tipo de contacto</label>
                                <input id='type_<?= $contact['contactId'] ?>' value='<?= $contact['type'] ?>' name='contact_type[]'
                                    pattern="^.{1,100}$" title="Ingresa entre 1 y 100 caracteres para el tipo de contacto">
                                
                                <label for='value_<?= $contact['contactId'] ?>'>Dirección de medio</label>
                                <input id='value_<?= $contact['contactId'] ?>' value='<?= $contact['value'] ?>' name='contact_value[]'
                                    pattern="^.{1,255}$" title="Ingresa entre 1 y 255 caracteres para la dirección de medio">
                                
                                <button type='button' class='eliminarContacto'>Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>

                    <fieldset>
                        <legend>Dirección</legend>
                        <?php foreach ($business['addresses'] as $address): ?>
                            <div>
                                <label for='address_<?= $address['addressId'] ?>'>Dirección</label>
                                <input id='address_<?= $address['addressId'] ?>' value='<?= $address['address'] ?>' name='addresses[]'
                                    pattern="^.{1,100}$" title="Ingresa entre 1 y 100 caracteres para la dirección">
                                
                                <label for='postal_code_<?= $address['addressId'] ?>'>Código Postal</label>
                                <input id='postal_code_<?= $address['addressId'] ?>' value='<?= $address['postalCode'] ?>' name='postal_codes[]'
                                    pattern="[0-9]{5}" title="Ingresa un número de 5 dígitos para el código postal">
                                
                                <button type='button' class='eliminarDireccion'>Eliminar</button>
                            </div>
                        <?php endforeach; ?>
                    </fieldset>
                    <button type="button" id="agregarDireccion">Agregar Dirección</button>
                    <br>
                    <button type="submit">Guardar Cambios</button>
                </form>
            <?php endif; ?>
        </div>        
    </main>


    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
