/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import Places from 'places.js';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

//Map
let map = document.querySelector('#map')
if(map !== null){
    let icon = L.icon({
    iconUrl: '/images/img/marker-icon.png',
});
    let center = [map.dataset.lat, map.dataset.lng];
    map = L.map('map').setView(center, 13)
    let token = 'pk.eyJ1Ijoia3BtbG9rIiwiYSI6ImNrcWs1ZWc1ZjA1c2Eyb3Btb3NjeDB4bmgifQ.hmfu_I3hrRoPc4kaNVXZfg'
   

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    maxZoom: 18,
        minZoom: 10,

}).addTo(map);
    L.marker(center, {icon: icon}).addTo(map)
}

//Places
let inputAddress = document.querySelector('#gite_address')
if(inputAddress !== null){
  let place = Places({
        container: inputAddress
    })
    place.on('change', function(e){
        document.querySelector("#gite_city").value = e.suggestion.city
        document.querySelector("#gite_postale_code").value = e.suggestion.postcode
        document.querySelector("#gite_lat").value = e.suggestion.latlng.lat
        document.querySelector("#gite_lng").value = e.suggestion.latlng.lng
    })
}

//Formulaire de contact
let btnContact = document.querySelector('#contact');
btnContact.addEventListener('click', function(){
    let form = document.querySelector('.form-contact');
    form.classList.remove('hidden');
    form.classList.add('visible');
    this.classList.add('hidden');
})
