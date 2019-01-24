<template>
    <div class="appWrapper">
        <div class="appHeader">
            <div class="appHeaderTitle">
                <table border="0" width="100%">
                    <tr>
                        <td width="20%"></td>
                        <td width="60%">Title</td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="appHeaderBorder"></div>
        <div id="floating-panel">
            <input id="latlng" type="text" value="40.714224,-73.961452">
            <input id="submit" type="button" value="Reverse Geocode">
        </div>
        <div id="map"></div>
    </div>
</template>

<script>
export default {
    methods: {
        initMap: function () {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: {lat: 40.731, lng: -73.997}
            });
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;

            var self = this;

            document.getElementById('submit').addEventListener('click', function() {
                self.geocodeLatLng(geocoder, map, infowindow);
            });
        },
        geocodeLatLng(geocoder, map, infowindow) {
            var input = document.getElementById('latlng').value;
            var latlngStr = input.split(',', 2);
            var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        console.log(results[0]);
                        map.setZoom(11);
                        var marker = new google.maps.Marker({
                            position: latlng,
                            map: map
                        });
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    } else {
                        window.alert('No results found');
                    }
                } else {
                    window.alert('Geocoder failed due to: ' + status);
                }
            });
        }
    },
    mounted: function () {
        this.initMap();
    }
};
</script>
