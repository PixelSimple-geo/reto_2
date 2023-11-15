function agregarDireccion() {
    var newAddress = document.createElement('form');
    newAddress.action = '/account/businesses/add';
    newAddress.method = 'POST';

    // Crear la select para la ciudad
    var ciudadSelect = document.createElement('select');
    ciudadSelect.name = 'ciudad';
    ciudadSelect.required = true;

    // Agregar opciones a la select
    var ciudades = ["Ciudad 1", "Ciudad 2", "Ciudad 3"]
    for (var i = 0; i < ciudades.length; i++) {
        var opcion = document.createElement('option');
        opcion.value = ciudades[i];
        opcion.text = ciudades[i];
        ciudadSelect.appendChild(opcion);
    }

    var direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.name = 'direccion';
    direccionInput.placeholder = 'Dirección';
    direccionInput.required = true;

    var codigoInput = document.createElement('input');
    codigoInput.type = 'number';
    codigoInput.name = 'codigoPostal';
    codigoInput.maxLength = '5';
    codigoInput.required = true;

    var submitInput = document.createElement('input');
    submitInput.type = 'submit';
    submitInput.name = 'enviar';
    submitInput.value = 'enviar';

    newAddress.appendChild(ciudadSelect);
    newAddress.appendChild(direccionInput);
    newAddress.appendChild(codigoInput);
    newAddress.appendChild(submitInput);

    document.getElementById('addressesContainer').appendChild(newAddress);
}
