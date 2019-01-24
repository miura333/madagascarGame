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
        <div id="map"></div>
    </div>
</template>

<script>
export default {
    methods: {
        initMap: function () {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 2,
                center: {lat: 40.731, lng: -73.997}
            });
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;

            var self = this;

            map.addListener('click', function(e) {
                self.geocodeLatLng(geocoder, map, infowindow, e.latLng);
            });
        },
        geocodeLatLng(geocoder, map, infowindow, latLng) {
            geocoder.geocode({'location': latLng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            var addr = results[0].address_components[i];
                            var getCountry;
                            if (addr.types[0] == 'country') {
                                getCountry = addr.short_name;
                            }
                            console.log(getCountry);
                        }

                        var marker = new google.maps.Marker({
                            position: latLng,
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
