function agregarContacto() {
  // Crear elementos para el nuevo contacto
  let nuevoContacto = document.createElement('div');

  let tipoInput = document.createElement('input');
  tipoInput.type = 'text';
  tipoInput.placeholder = 'Tipo de contacto';

  let direccionInput = document.createElement('input');
  direccionInput.type = 'text';
  direccionInput.placeholder = 'Dirección de medio';

  let guardarContacto = document.createElement('button');
  guardarContacto.textContent = 'Guardar';

  guardarContacto.addEventListener('click', function () {
    let tipo = tipoInput.value;
    let direccion = direccionInput.value;

    let contactoTexto = document.createElement('p');
    contactoTexto.textContent = tipo + ': ' + direccion;

    let eliminarButton = document.createElement('button');
    eliminarButton.textContent = 'Eliminar';
    eliminarButton.addEventListener('click', function () {

      nuevoContacto.remove();
    });

    nuevoContacto.innerHTML = '';
    nuevoContacto.appendChild(contactoTexto);
    nuevoContacto.appendChild(eliminarButton);
  });

  nuevoContacto.appendChild(tipoInput);
  nuevoContacto.appendChild(direccionInput);
  nuevoContacto.appendChild(guardarContacto);

  document.getElementById('contactsContainer').appendChild(nuevoContacto);
}