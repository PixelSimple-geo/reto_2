/* Funciones para manejar las cookies */
document.addEventListener('DOMContentLoaded', function () {
    const botonAceptarCookies = document.getElementById('btn-aceptar-cookies');
    const avisoCookies = document.getElementById('aviso-cookies');
    const fondoAvisoCookies = document.getElementById('fondo-aviso-cookies');

    dataLayer = [];

    /* Aplica el nombre valor y dias de caducidad */
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    /* Recibe la cookie para saber si ya esta aceptada o no */
    function getCookie(name) {
        const cname = name + "=";
        const decodedCookie = decodeURIComponent(document.cookie);
        const ca = decodedCookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(cname) === 0) {
                return c.substring(cname.length, c.length);
            }
        }
        return "";
    }

    /* En caso de no tenerla aceptada aplica unas clases sino no */
    if (!getCookie('cookies-aceptadas')) {
        avisoCookies.classList.add('activo');
        fondoAvisoCookies.classList.add('activo');
        avisoCookies.style.cursor = "pointer";
        fondoAvisoCookies.style.cursor = "not-allowed";

        avisoCookies.classList.add('aparecer');
    } else {
        dataLayer.push({ 'event': 'cookies-aceptadas' });
    }

    /* Pulsar el boton aceptar para aceptarlas */
    botonAceptarCookies.addEventListener('click', () => {
        avisoCookies.classList.remove('aparecer');
        avisoCookies.classList.add('desaparecer');

        setTimeout(function () {
            avisoCookies.style.display = 'none';
        }, 500);

        fondoAvisoCookies.classList.remove('activo');

        setCookie('cookies-aceptadas', 'true', 30);

        dataLayer.push({ 'event': 'cookies-aceptadas' });
    });
});
