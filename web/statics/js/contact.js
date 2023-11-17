function agregarContacto() {
  let nuevoContacto = document.createElement('div');

  let tipoInput = document.createElement('input');
  tipoInput.type = 'text';
  tipoInput.placeholder = 'Tipo de contacto';
  tipoInput.name = 'contact_type[]';

  let direccionInput = document.createElement('input');
  direccionInput.type = 'text';
  direccionInput.placeholder = 'Dirección de medio';
  direccionInput.name = 'contact_value[]';

  let eliminarButton = document.createElement('button');
  eliminarButton.textContent = 'Eliminar';
  eliminarButton.addEventListener('click', function () {
    nuevoContacto.remove();
  });

  nuevoContacto.appendChild(tipoInput);
  nuevoContacto.appendChild(direccionInput);
  nuevoContacto.appendChild(eliminarButton);

  document.getElementById('contactsContainer').appendChild(nuevoContacto);
}
