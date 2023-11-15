function agregarContacto() {
    var nuevoContacto = document.createElement('form');
    nuevoContacto.action = '/account/businesses/add'; 
    nuevoContacto.method = 'POST';
  
    var tipoInput = document.createElement('input');
    tipoInput.type = 'text';
    tipoInput.name = 'tipo'; 
    tipoInput.placeholder = 'Tipo de contacto';
    tipoInput.required = true; 
  
    var direccionInput = document.createElement('input');
    direccionInput.type = 'text';
    direccionInput.name = 'direccion'; 
    direccionInput.placeholder = 'Dirección de medio';
    direccionInput.required = true; 
  
    var submitInput = document.createElement('input');
    submitInput.type = 'submit';
    submitInput.name = 'enviar'; 
    submitInput.value = 'enviar'; 
  
    nuevoContacto.appendChild(tipoInput);
    nuevoContacto.appendChild(direccionInput);
    nuevoContacto.appendChild(submitInput);
  
    document.getElementById('contactsContainer').appendChild(nuevoContacto);
  }
  