document.addEventListener('DOMContentLoaded', function () {
    const toggleDarkModeButton = document.getElementById('toggleDarkMode');
    const body = document.body;

    // Verificar si el usuario ha elegido un modo en el pasado
    if (localStorage.getItem('dark-mode') === 'enabled') {
        body.classList.add('dark');
    }

    // Agregar un event listener al botón
    toggleDarkModeButton.addEventListener('click', function () {
        // Alternar entre las clases 'dark' y 'light'
        body.classList.toggle('dark');

        // Guardar la elección del usuario en el almacenamiento local
        if (body.classList.contains('dark')) {
            localStorage.setItem('dark-mode', 'enabled');
        } else {
            localStorage.setItem('dark-mode', 'disabled');
        }
    });
});
