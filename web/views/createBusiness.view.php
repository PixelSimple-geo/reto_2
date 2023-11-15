<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Crear Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <div class="formulario">
        <a href="/businesses">Volver a mis negocios</a>
        <h2>Crear Nuevo Negocio</h2>

        <form action="/businesses" method="POST">
            <label for="nombre">Nombre del Negocio:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="categoria">Categoría del Negocio:</label>
            <select id="categoria" name="categoria" required>
                <?php
                // TODO: Necesitas la función que te devuelva las categorías de los negocios
                foreach ($categorias as $categoria) {
                    echo '<option value="' . $categoria . '">' . $categoria . '</option>';
                }
                ?>
            </select>

            <label for="direccion">Dirección del Negocio:</label>
            <input type="text" id="direccion" name="direccion" required>

            <h3 for="contactos">Contacto:</h3>
            <div id="contactos">
                <div>
                    <label for="tipo_contacto1">Tipo de Contacto:</label>
                    <select id="tipo_contacto1" name="tipo_contacto[]">
                        <option value="gmail">Gmail</option>
                        <option value="telefono">Teléfono</option>
                        <option value="red_social">Red Social</option>
                    </select>
                    <label for="valor_contacto1">Valor de Contacto:</label>
                    <input type="text" id="valor_contacto1" name="valor_contacto[]" required>
                </div>
            </div>

            <label for="descripcion">Descripción del Negocio:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required></textarea>

            <button type="submit">Crear Negocio</button>
        </form>
    </div>

    <?php require "partials/footer.php" ?>

</body>
</html>
