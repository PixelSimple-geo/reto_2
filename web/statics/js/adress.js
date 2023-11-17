let addressCounter = 0;

function agregarDireccion() {
    let nuevaDireccion = document.createElement('div');
    let addressId = 'address_' + addressCounter;

    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Dirección';
    direccionInput.name = 'addresses[' + addressId + ']';

    let codigoInput = document.createElement('input');
    codigoInput.type = 'number';
    codigoInput.name = 'postal_codes[' + addressId + ']';
    codigoInput.required = true;
    codigoInput.maxLength = '5';

    let guardarDireccion = document.createElement('button');
    guardarDireccion.textContent = 'Guardar';

    guardarDireccion.addEventListener('click', function () {
        let direccion = direccionInput.value;
        let codigo = codigoInput.value;

        let direccionTexto = document.createElement('p');
        direccionTexto.id = addressId;
        direccionTexto.innerHTML = 'Dirección: ' + direccion + '<br>Código: ' + codigo;

        let eliminarButton = document.createElement('button');
        eliminarButton.textContent = 'Eliminar';
        eliminarButton.addEventListener('click', function () {
            direccionTexto.remove();
        });

        nuevaDireccion.appendChild(direccionTexto);
        nuevaDireccion.appendChild(eliminarButton);
    });

    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(guardarDireccion);

    document.getElementById('addressesContainer').appendChild(nuevaDireccion);

    addressCounter++;
}
