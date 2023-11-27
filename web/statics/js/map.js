/* Mapa del index */
function initMap() {
    var center = { lat: 42.84998, lng: -2.67268}; 

    var map = new google.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 12 
    });

    var marker = new google.maps.Marker({
        position: center,
        map: map,
        title: 'Vitoria-Gasteiz'
    });
}