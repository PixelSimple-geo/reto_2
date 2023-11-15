<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Editar Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <main class="formulario">

        <a href="/account/businesses">Volver a mis negocios</a>
        <h2>Editar Negocio</h2>

        <?php
            //TODO necesito la funcion para recibir los datos del negocio a editar
            if (isset($business)) {
                echo '<form action="/account/businesses/add" method="POST">';
                echo '  <label for="nombre">Nombre del Negocio:</label>';
                echo '  <input type="text" id="nombre" name="nombre" value="' . $business["name"] . '" required>';

                echo '  <label for="descripcion">Descripción del Negocio:</label>';
                echo '  <textarea id="descripcion" name="descripcion" rows="4" required>' . $business["description"] . '</textarea>';

                if (isset($categories)) {
                    echo "<label for='category'>Categorías</label>";
                    echo "<select id='category'>";
                    foreach ($categories as $category) {
                        echo "<option value='$category[categoryId]'>$category[name]</option>";
                    }
                    echo "</select>";
                }

                echo '<fieldset>';
                echo '<legend>Contacto</legend>';
                foreach ($business["contacts"] as $contact) {
                    echo "<label for='type_$contact[contactId]'>Tipo de contacto</label>";
                    echo "<input id='type_$contact[contactId]' value='$contact[type]' name='contacts[type][]'>";
                    echo "<label for='value_$contact[contactId]'>Dirección de medio</label>";
                    echo "<input id='value_$contact[contactId]' value='$contact[value]' name='contacts[value][]'>";
                }
                echo "</fieldset>";
                echo "<fieldset>";
                echo "<legend>Dirección</legend>";
                foreach ($business["addresses"] as $address) {
                    echo "<label for='address_$address[addressId]'>Tipo de contacto</label>";
                    echo "<input id='address_$address[addressId]' value='$address[address]' name='addresses[address][]'>";
                    echo "<label for='postal_code_$address[addressId]'>Dirección de medio</label>";
                    echo "<input id='postal_code_$address[addressId]' value='$address[postalCode]'>";
                }
                echo "</fieldset>";
                echo '  <button type="submit">Guardar Cambios</button>';
                echo '</form>';
            } else {
                echo '<p>El negocio no existe.</p>';
            }
        ?>
    </main>

    <?php require "partials/footer.php" ?>
</body>
</html>
