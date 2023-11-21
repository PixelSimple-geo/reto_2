function agregarContacto() {
    let nuevoContacto = document.createElement('div');
  
    let tipoLabel = document.createElement('label');
    tipoLabel.textContent = 'Tipo de contacto:';
    tipoLabel.htmlFor = 'tipoInput'; 
  
    let tipoInput = document.createElement('input');
    tipoInput.type = 'text';
    tipoInput.placeholder = 'Tipo de contacto';
    tipoInput.name = 'contact_type[]';
    tipoInput.pattern = '^.{1,100}$';
    tipoInput.title = 'Inserte un máximo de 100 caracteres';
    tipoInput.id = 'tipoInput';
  
    let direccionLabel = document.createElement('label');
    direccionLabel.textContent = 'Dirección de medio:';
    direccionLabel.htmlFor = 'direccionInput'; 
  
    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Ejemplo de dirección';
    direccionInput.name = 'contact_value[]';
    direccionInput.id = 'direccionInput';
    direccionInput.pattern = '^.{1,255}$';
    direccionInput.title = 'Inserte un máximo de 255 caracteres';
  
    let eliminarButton = document.createElement('button');
    eliminarButton.textContent = 'Eliminar';
    eliminarButton.addEventListener('click', function () {
      nuevoContacto.remove();
    });
  
    nuevoContacto.appendChild(tipoLabel);
    nuevoContacto.appendChild(tipoInput);
    nuevoContacto.appendChild(direccionLabel);
    nuevoContacto.appendChild(direccionInput);
    nuevoContacto.appendChild(eliminarButton);
  
    document.getElementById('contactsContainer').appendChild(nuevoContacto);
  }
  
  function agregarDireccion() {
    let nuevaDireccion = document.createElement('div');
  
    let direccionLabel = document.createElement('label');
    direccionLabel.textContent = 'Dirección:';
    direccionLabel.htmlFor = 'direccionInput'; 
  
    let direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.placeholder = 'Ejemplo de dirección';
    direccionInput.name = 'addresses[]';
    direccionInput.id = 'direccionInput';
    direccionInput.pattern = '^.{1,100}$';
    direccionInput.title = 'Inserte un máximo de 100 caracteres';
  
    let codigoLabel = document.createElement('label');
    codigoLabel.textContent = 'Código Postal:';
    codigoLabel.htmlFor = 'codigoInput'; 
  
    let codigoInput = document.createElement('input');
    codigoInput.type = 'text'; 
    codigoInput.name = 'postal_codes[]';
    codigoInput.required = true;
    codigoInput.pattern = '[0-9]{5}'; 
    codigoInput.title = 'Inserte un número de 5 dígitos';
    codigoInput.id = 'codigoInput';
  
    let eliminarButton = document.createElement('button');
    eliminarButton.textContent = 'Eliminar';
    eliminarButton.addEventListener('click', function () {
      nuevaDireccion.remove();
    });
  
    nuevaDireccion.appendChild(direccionLabel);
    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoLabel);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(eliminarButton);
  
    document.getElementById('addressesContainer').appendChild(nuevaDireccion);
  }