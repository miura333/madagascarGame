<template>
    <div class="appWrapper">
        <div class="appHeader">
            <div class="appHeaderTitle">
                <table border="0" width="100%">
                    <tr>
                        <td width="20%">{{count.toFixed(1)}}</td>
                        <td width="60%">{{country_name}}</td>
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
import axios from 'axios';

export default {
    data() {
        return {
            count: 0.0,
            country_name: '',
            country_code: '',
            timerObj: null,
        };
    },
    methods: {
        initMap: function () {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 6,
                center: {lat: 35.685529, lng: 139.752680}
            });
            var geocoder = new google.maps.Geocoder;
            var infowindow = new google.maps.InfoWindow;

            var self = this;

            map.addListener('click', function(e) {
                self.geocodeLatLng(geocoder, map, infowindow, e.latLng);
            });
        },
        geocodeLatLng(geocoder, map, infowindow, latLng) {
            var self = this;

            geocoder.geocode({'location': latLng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var marker = new google.maps.Marker({
                            position: latLng,
                            map: map
                        });
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);

                        //国名取得と判定
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            var addr = results[0].address_components[i];
                            if (addr.types[0] == 'country') {
                                var country_code = addr.short_name;
                                if(country_code == self.country_code) {
                                    clearInterval(self.timerObj);
                                }
                            }
                        }

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
        var self = this;

        axios.get('/api/getCountry').then(function(response){
            console.log(response);
            self.country_name = response.data.name;
            self.country_code = response.data.code;

            self.initMap();

            //timer
            var countup = function(){
                self.count += 0.1;
            }
            self.timerObj = setInterval(countup, 100);
        });
    }
};
</script>
