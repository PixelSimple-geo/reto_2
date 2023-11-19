document.addEventListener("DOMContentLoaded", function () {
    // Script para eliminar contacto
    $(document).on('click', '.eliminarContacto', function () {
        $(this).parent().remove();
    });

    // Script para agregar nuevo contacto
    $('#agregarContacto').on('click', function () {
        // Ajusta este código según tu estructura HTML
        let nuevoContacto = '<div>' +
            '<label for="nuevoTipo">Tipo de contacto</label>' +
            '<input id="nuevoTipo" name="contact_type[]">' +
            '<label for="nuevoValor">Dirección de medio</label>' +
            '<input id="nuevoValor" name="contact_value[]">' +
            '<button type="button" class="eliminarContacto">Eliminar</button>' +
            '</div>';
        $('fieldset legend:contains("Contacto")').after(nuevoContacto);
    });

    // Script para eliminar dirección
    $(document).on('click', '.eliminarDireccion', function () {
        $(this).parent().remove();
    });

    // Script para agregar nueva dirección
    $('#agregarDireccion').on('click', function () {
        // Ajusta este código según tu estructura HTML
        let nuevaDireccion = '<div>' +
            '<label for="nuevaDireccion">Dirección</label>' +
            '<input id="nuevaDireccion" name="addresses[]">' +
            '<label for="nuevoPostalCode">Código Postal</label>' +
            '<input id="nuevoPostalCode" name="postal_codes[]">' +
            '<button type="button" class="eliminarDireccion">Eliminar</button>' +
            '</div>';
        $('fieldset legend:contains("Dirección")').after(nuevaDireccion);
    });
});