<!DOCTYPE html>
<html lang="es">
<head>
    <?php require "partials/head.php" ?>
    <title>Crear/Editar Negocio</title>
</head>
<body>
    <?php require "partials/navvar.php"; ?>

    <div class="formulario">
        <a href="/businesses">Volver a mis negocios</a>

        <h2><?php Editar Negocio ?></h2>

        <form action="<?php echo $accion; ?>" method="POST">
            <label for="nombre">Nombre del Negocio:</label>
            <input type="text" id="nombre" name="nombre" placeholder="<?php echo isset($negocioDetalles) ? $negocioDetalles['name'] : ''; ?>" required>

            <label for="categoria">Categoría del Negocio:</label>
            <select id="categoria" name="categoria" required>
                <?php
                // TODO: Necesitas la función que te devuelva las categorías de los negocios
                foreach ($categorias as $categoria) {
                    $selected = isset($negocioDetalles) && $negocioDetalles['category'] == $categoria ? 'selected' : '';
                    echo '<option placeholder="' . $categoria . '" ' . $selected . '>' . $categoria . '</option>';
                }
                ?>
            </select>

            <label for="direccion">Dirección del Negocio:</label>
            <input type="text" id="direccion" name="direccion" placeholder="<?php echo isset($negocioDetalles) ? $negocioDetalles['address'] : ''; ?>" required>

            <h3 for="contactos">Contacto:</h3>
            <div id="contactos">
                <div>
                    <label for="tipo_contacto1">Tipo de Contacto:</label>
                    <select id="tipo_contacto1" name="tipo_contacto[]">
                        <option placeholder="gmail" <?php echo isset($negocioDetalles) && $negocioDetalles['contact']['type'] == 'gmail' ? 'selected' : ''; ?>>Gmail</option>
                        <option placeholder="telefono" <?php echo isset($negocioDetalles) && $negocioDetalles['contact']['type'] == 'telefono' ? 'selected' : ''; ?>>Teléfono</option>
                        <option placeholder="red_social" <?php echo isset($negocioDetalles) && $negocioDetalles['contact']['type'] == 'red_social' ? 'selected' : ''; ?>>Red Social</option>
                    </select>
                    <label for="valor_contacto1">Valor de Contacto:</label>
                    <input type="text" id="valor_contacto1" name="valor_contacto[]" placeholder="<?php echo isset($negocioDetalles) ? $negocioDetalles['contact']['value'] : ''; ?>" required>
                </div>
            </div>

            <label for="descripcion">Descripción del Negocio:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?php echo isset($negocioDetalles) ? $negocioDetalles['description'] : ''; ?></textarea>

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>

    <?php require "partials/footer.php" ?>

</body>
</html>
