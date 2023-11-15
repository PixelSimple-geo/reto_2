function agregarContacto() {
  let nuevoContacto = document.createElement('div');

  let tipoInput = document.createElement('input');
  tipoInput.type = 'text';
  tipoInput.placeholder = 'Tipo de contacto';

  let direccionInput = document.createElement('input');
  direccionInput.type = 'text';
  direccionInput.placeholder = 'Dirección de medio';

  let fieldsetContacto = document.createElement('fieldset');

  let guardarContacto = document.createElement('button');
  guardarContacto.textContent = 'Guardar';

  guardarContacto.addEventListener('click', function () {
    let tipo = tipoInput.value;
    let direccion = direccionInput.value;

    let contactoTexto = document.createElement('p');
    contactoTexto.innerHTML = 'Tipo: ' + tipo + '<br>Dirección de medio: ' + direccion;

    let eliminarButton = document.createElement('button');
    eliminarButton.textContent = 'Eliminar';
    eliminarButton.addEventListener('click', function () {
      fieldsetContacto.remove();
    });

    fieldsetContacto.appendChild(contactoTexto);
    fieldsetContacto.appendChild(eliminarButton);

    nuevoContacto.innerHTML = '';
    nuevoContacto.appendChild(fieldsetContacto);
  });

  nuevoContacto.appendChild(tipoInput);
  nuevoContacto.appendChild(direccionInput);
  nuevoContacto.appendChild(guardarContacto);

  document.getElementById('contactsContainer').appendChild(nuevoContacto);
}
