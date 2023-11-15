function agregarDireccion() {
    let nuevaDireccion = document.createElement('div');
  
    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Dirección';

    let codigoInput = document.createElement('input');
    codigoInput.type = 'number';
    codigoInput.name = 'codigoPostal';
    codigoInput.required = true;
    codigoInput.maxlength = '5';
  
    let guardarDireccion = document.createElement('button');
    guardarDireccion.textContent = 'Guardar';

    guardarDireccion.addEventListener('click', function () {
      let direccion = direccionInput.value;
      let codigo = codigoInput.value;
  
      let direccionTexto = document.createElement('p');
      direccionTexto.textContent = direccion + ': ' + codigo;
  
      let eliminarButton = document.createElement('button');
      eliminarButton.textContent = 'Eliminar';
      eliminarButton.addEventListener('click', function () {
  
        nuevaDireccion.remove();
      });
  
      nuevaDireccion.innerHTML = '';
      nuevaDireccion.appendChild(direccionTexto);
      nuevaDireccion.appendChild(eliminarButton);
    });
  
    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(guardarDireccion);
  
    document.getElementById('addressesContainer').appendChild(nuevaDireccion);
  }