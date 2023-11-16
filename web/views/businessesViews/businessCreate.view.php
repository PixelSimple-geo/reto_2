<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Negocio</title>
</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>";?>

    <div class="formulario">
            <a href="/businesses/account/get">Volver a mis negocios</a>
            <h2>Crear Nuevo Negocio</h2>

            <form action="/businesses/account/add" method="POST">
                <label for="nombre">Nombre del Negocio:</label>
                <input type="text" id="nombre" name="name" required>

                <label for="descripcion">Descripción del Negocio:</label>
                <textarea id="descripcion" name="description" rows="4" required></textarea>

                <?php
                if (!empty($businessCategories)) {
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
                    <input id="type" name="contact_type[]">
                    <label for="value">Dirección de medio</label>
                    <input id="value" name="contact_value[]">
                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>
                    <label for="address">Dirección</label>
                    <input id="address" name="addresses[]">
                    <label for="postal_code">Código postal</label>
                    <input type="number" id="postal_code" name="postal_codes[]">
                </fieldset>

                <button type="submit">Crear Negocio</button>
            </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>
