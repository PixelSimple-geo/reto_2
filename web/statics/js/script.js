/* Login y registro*/
document.addEventListener('DOMContentLoaded', function () {
    var submitReg = document.getElementById('submitReg');
    if (submitReg) {
        submitReg.addEventListener('click', function (event) {
            var usuarioInput = document.getElementById('usuario');
            var passwordInput = document.getElementById('password');
            var conpasswordInput = document.getElementById('conpassword');

            if (!/^[a-zA-Z0-9_-]+$/.test(usuarioInput.value)) {
                alert('Usuario Incorrecto');
                event.preventDefault();
                return;
            }

            var passwordValue = passwordInput.value.trim();
            if (passwordValue === '' || !/\d/.test(passwordValue)) {
                alert('La contraseña debe tener números y letras');
                event.preventDefault();
                return;
            }

            if (conpasswordInput.value.trim() !== passwordValue) {
                alert('Contraseñas diferentes');
                event.preventDefault();
                return;
            }
        });
    }

    var submitLog = document.getElementById('submitLog');
    if (submitLog) {
        submitLog.addEventListener('click', function (event) {
            var usuarioInput = document.getElementById('usuario');

            if (!/^[a-zA-Z0-9_-]+$/.test(usuarioInput.value)) {
                alert('Usuario Incorrecto');
                event.preventDefault();
                return;
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var togglePasswordButton = document.getElementById("togglePassword");

    if (togglePasswordButton) {
        togglePasswordButton.addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        });
    }
});


/* Modo */
document.addEventListener('DOMContentLoaded', function () {
    const toggleDarkModeButton = document.getElementById('toggleDarkMode');
    const body = document.body;
    const modeIcon = document.getElementById('modeIcon');

    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark');
        modeIcon.textContent = '🌙';
    }

    toggleDarkModeButton.addEventListener('click', function () {
        body.classList.toggle('dark');

        if (body.classList.contains('dark')) {
            localStorage.setItem('dark-mode', 'enabled');
            modeIcon.textContent = '🌙';
        } else {
            localStorage.setItem('dark-mode', 'disabled');
            modeIcon.textContent = '☀️';
        }
    });
});

/* Business needs */
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
    eliminarButton.setAttribute("data-script-delete-con-dir", "");

    nuevoContacto.appendChild(tipoLabel);
    nuevoContacto.appendChild(tipoInput);
    nuevoContacto.appendChild(direccionLabel);
    nuevoContacto.appendChild(direccionInput);
    nuevoContacto.appendChild(eliminarButton);

    document.getElementById('contactsContainer').appendChild(nuevoContacto);

    delete_con_dir(eliminarButton);
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
    eliminarButton.setAttribute("data-script-delete-con-dir", "");

    nuevaDireccion.appendChild(direccionLabel);
    nuevaDireccion.appendChild(direccionInput);
    nuevaDireccion.appendChild(codigoLabel);
    nuevaDireccion.appendChild(codigoInput);
    nuevaDireccion.appendChild(eliminarButton);

    document.getElementById('addressesContainer').appendChild(nuevaDireccion);

    delete_con_dir(eliminarButton);
}

document.addEventListener("DOMContentLoaded", function () {
    let botones = document.querySelectorAll('[data-script-delete-con-dir]');
    botones.forEach(function (boton) {
        delete_con_dir(boton);
    });
});

function delete_con_dir(boton) {
    boton.addEventListener("click", function () {
        boton.closest("div").remove();
    });
}

