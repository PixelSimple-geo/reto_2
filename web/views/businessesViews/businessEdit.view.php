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
        <a href="/businesses/account/get">Volver a mis negocios</a>
        <h2>Editar Negocio</h2>

        <?php
            //TODO necesito la funcion para recibir los datos del negocio a editar
            if (isset($business)) {
                echo '<form action="/businesses/account/edit" method="POST">';
                echo "<input type='hidden' name='business_id' value='$business[businessId]'>";
                echo '<label for="nombre">Nombre del Negocio:</label>';
                echo '<input type="text" id="nombre" name="name" value="' . $business["name"] . '" required>';
                echo '<label for="descripcion">Descripción del Negocio:</label>';
                echo '<textarea id="descripcion" name="description" rows="4" required>' . $business["description"] . '</textarea>';

                if (isset($categories)) {
                    echo '<label for="category">Categorías</label>';
                    echo '<select id="category" name="business_category">';
                    foreach ($categories as $category) {
                        if ($business["category"]["categoryId"] === $category["categoryId"])
                            echo "<option value='$category[categoryId]' selected>$category[name]</option>";
                        else
                            echo "<option value='$category[categoryId]'>$category[name]</option>";
                    }
                    echo '</select>';
                }

                echo '<fieldset>';
                echo '<legend>Contacto</legend>';
                foreach ($business["contacts"] as $contact) {
                    echo "<div>";
                    echo "<label for='type_$contact[contactId]'>Tipo de contacto</label>";
                    echo "<input id='type_$contact[contactId]' value='$contact[type]' name='contact_type[]'>";
                    echo "<label for='value_$contact[contactId]'>Dirección de medio</label>";
                    echo "<input id='value_$contact[contactId]' value='$contact[value]' name='contact_value[]'>";
                    echo "<button type='button' class='eliminarContacto'>Eliminar</button>";
                    echo "</div>";
                }
                echo "</fieldset>";
                echo '<button type="button" id="agregarContacto">Agregar Contacto</button>';

                echo '<fieldset>';
                echo '<legend>Dirección</legend>';
                foreach ($business["addresses"] as $address) {
                    echo "<div>";
                    echo "<label for='address_$address[addressId]'>Dirección</label>";
                    echo "<input id='address_$address[addressId]' value='$address[address]' name='addresses[]'>";
                    echo "<label for='postal_code_$address[addressId]'>Código Postal</label>";
                    echo "<input id='postal_code_$address[addressId]' value='$address[postalCode]' name='postal_codes[]'>";
                    echo "<button type='button' class='eliminarDireccion'>Eliminar</button>";
                    echo "</div>";
                }
                echo "</fieldset>";
                echo '<button type="button" id="agregarDireccion">Agregar Dirección</button>';
                echo '<br>';
                echo '<button type="submit">Guardar Cambios</button>';
                echo '</form>';
            } else {
                echo '<p>El negocio no existe.</p>';
            }
        ?>
    </main>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>
</body>
</html>
