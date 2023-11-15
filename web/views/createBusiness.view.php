<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Crear Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>";?>

    <div class="formulario">
            <a href="/account/businesses">Volver a mis negocios</a>
            <h2>Crear Nuevo Negocio</h2>

            <form action="/account/businesses/add" method="POST">
                <label for="nombre">Nombre del Negocio:</label>
                <input type="text" id="nombre" name="name" required>

                <label for="descripcion">Descripción del Negocio:</label>
                <textarea id="descripcion" name="description" rows="4" required></textarea>

                <?php
                if (isset($businessCategories)) {
                    echo "<label for='category'>Categoría</label>";
                    echo "<select id='category' name='business_category'>";
                    foreach ($businessCategories as $value) {
                        echo "<option value='$value[categoryId]'>$value[name]</option>";
                    }
                    echo "</select>";
                }
                ?>
                <fieldset>
                    <legend>Contacto</legend>
                    <label for="type">Tipo de contacto</label>
                    <input id="type" name="contacts[type][]">
                    <label for="value">Dirección de medio</label>
                    <input id="value" name="contacts[value][]">
                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>
                    <?php
                    if (isset($cities)) {
                        echo "<select name='addresses[city_id][]'>";
                        foreach ($cities as $city) {
                            echo "<option value='$city[cityId]'>$city[name]</option>";
                        }
                        echo "</select>";
                    }
                    ?>
                    <label for="address">Dirección</label>
                    <input id="address" name="addresses[address][]">
                    <label for="postal_code">Código postal</label>
                    <input type="number" id="postal_code" name="addresses[postal_code][]">
                </fieldset>

                <button type="submit">Crear Negocio</button>
            </form>
    </div>

    <?php require "partials/footer.php" ?>

</body>
</html>
