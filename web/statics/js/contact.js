let contactCounter = 0;

function agregarContacto() {
    let nuevoContacto = document.createElement('div');
    let contactId = 'contact_' + contactCounter;

    let tipoInput = document.createElement('input');
    tipoInput.type = 'text';
    tipoInput.placeholder = 'Tipo de contacto';
    tipoInput.name = 'contact_type[' + contactId + ']';

    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Dirección de medio';
    direccionInput.name = 'contact_value[' + contactId + ']';

    let guardarContacto = document.createElement('button');
    guardarContacto.textContent = 'Guardar';

    guardarContacto.addEventListener('click', function () {
        let tipo = tipoInput.value;
        let direccion = direccionInput.value;

        let contactoTexto = document.createElement('p');
        contactoTexto.id = contactId;
        contactoTexto.innerHTML = 'Tipo: ' + tipo + '<br>Dirección de medio: ' + direccion;

        let eliminarButton = document.createElement('button');
        eliminarButton.textContent = 'Eliminar';
        eliminarButton.addEventListener('click', function () {
            contactoTexto.remove();
        });

        nuevoContacto.appendChild(contactoTexto);
        nuevoContacto.appendChild(eliminarButton);
    });

    nuevoContacto.appendChild(tipoInput);
    nuevoContacto.appendChild(direccionInput);
    nuevoContacto.appendChild(guardarContacto);

    document.getElementById('contactsContainer').appendChild(nuevoContacto);

    contactCounter++;
}
