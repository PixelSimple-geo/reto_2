function agregarDireccion() {
    let nuevaDireccion = document.createElement('div');

    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Dirección';
    direccionInput.name = 'addresses[]';

    let codigoInput = document.createElement('input');
    codigoInput.type = 'number';
    codigoInput.name = 'postal_codes[]';
    codigoInput.required = true;
    codigoInput.max = '99999';

    let eliminarButton = document.createElement('button');
    eliminarButton.textContent = 'Eliminar';
    eliminarButton.addEventListener('click', function () {
        nuevaDireccion.remove();
    });

    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(eliminarButton);

    document.getElementById('addressesContainer').appendChild(nuevaDireccion);
}
