function agregarDireccion() {
    let nuevaDireccion = document.createElement('div');

    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Dirección';

    let codigoInput = document.createElement('input');
    codigoInput.type = 'number';
    codigoInput.name = 'codigoPostal';
    codigoInput.required = true;
    codigoInput.maxLength = '5';

    let nuevoFieldset = document.createElement('fieldset');

    let guardarDireccion = document.createElement('button');
    guardarDireccion.textContent = 'Guardar';

    guardarDireccion.addEventListener('click', function () {
        let direccion = direccionInput.value;
        let codigo = codigoInput.value;

        let direccionTexto = document.createElement('p');
        direccionTexto.innerHTML = 'Dirección: ' + direccion + '<br>Código: ' + codigo;

        let eliminarButton = document.createElement('button');
        eliminarButton.textContent = 'Eliminar';
        eliminarButton.addEventListener('click', function () {
            nuevoFieldset.remove();
        });

        nuevoFieldset.appendChild(direccionTexto);
        nuevoFieldset.appendChild(eliminarButton);

        nuevaDireccion.innerHTML = '';
        nuevaDireccion.appendChild(nuevoFieldset);
    });

    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(guardarDireccion);

    nuevoFieldset.appendChild(nuevaDireccion);

    document.getElementById('addressesContainer').appendChild(nuevoFieldset);
}
