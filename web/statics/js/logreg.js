document.addEventListener('DOMContentLoaded', function() {
    // Register Form
    var submitReg = document.getElementById('submitReg');
    if (submitReg) {
        submitReg.addEventListener('click', function(event) {
            var usuarioInput = document.getElementById('usuario');
            var passwordInput = document.getElementById('password');
            var conpasswordInput = document.getElementById('conpassword');

            // Validate username
            if (!/^[a-zA-Z0-9_-]+$/.test(usuarioInput.value)) {
                alert('Usuario Incorrecto');
                event.preventDefault();
                return;
            }

            // Validate password
            var passwordValue = passwordInput.value.trim();
            if (passwordValue === '' || !/\d/.test(passwordValue)) {
                alert('La contraseña debe tener números y letras');
                event.preventDefault();
                return;
            }

            // Validate password confirmation
            if (conpasswordInput.value.trim() !== passwordValue) {
                alert('Contraseñas diferentes');
                event.preventDefault();
                return;
            }
        });
    }

    // Login Form
    var submitLog = document.getElementById('submitLog');
    if (submitLog) {
        submitLog.addEventListener('click', function(event) {
            var usuarioInput = document.getElementById('usuario');

            // Validate username
            if (!/^[a-zA-Z0-9_-]+$/.test(usuarioInput.value)) {
                alert('Usuario Incorrecto');
                event.preventDefault();
                return;
            }
        });
    }
});
