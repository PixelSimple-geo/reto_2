<!DOCTYPE html>
<html lang="es">
<head>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/head.php" ?>
    <title>Crear Negocio</title>

    <script src="/statics/js/contact.js"></script>
    <script src="/statics/js/adress.js"></script>

</head>
<body>
    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/navBar.php"; ?>

    <?php if(isset($errorMessage)) echo "<p>$errorMessage</p>";?>

    <div class="formulario">
            <a href="/account/businesses">Volver a mis negocios</a>
            <h2>Crear Nuevo Negocio</h2>

            <form action="/businesses/account/add" method="POST">
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
                    <button type="button" onclick="agregarContacto()">+</button>
                    <div id="contactsContainer"></div>

                </fieldset>

                <fieldset>
                    <legend>Dirección</legend>
                    <button type="button" onclick="agregarDireccion()">+</button>
                    <div id="addressesContainer"></div>
                </fieldset>

                <button type="submit">Crear Negocio</button>
            </form>
    </div>

    <?php require $_SERVER['DOCUMENT_ROOT'] . "/views/partials/footer.php" ?>

</body>
</html>