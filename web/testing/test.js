const { agregarDireccion, delete_con_dir } = require('../statics/js/script.js');

test('agregarDireccion debería agregar una dirección al contenedor', () => {
    document.body.innerHTML = '<div id="addressesContainer"></div>';
    
    agregarDireccion();

    const addressesContainer = document.getElementById('addressesContainer');
    const direccionDiv = addressesContainer.querySelector('div');

    expect(direccionDiv).not.toBeNull();
});

test('delete_con_dir debería eliminar el div al hacer clic en el botón', () => {
    document.body.innerHTML = '<div id="addressesContainer"></div>';
    
    agregarDireccion();

    const addressesContainer = document.getElementById('addressesContainer');
    const direccionDiv = addressesContainer.querySelector('div');
    const eliminarButton = direccionDiv.querySelector('[data-script-delete-con-dir]');

    delete_con_dir(eliminarButton);

    expect(addressesContainer.contains(direccionDiv)).toBe(false);
});