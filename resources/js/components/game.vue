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
        <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">Goooooal!</h3>
            <div slot="body">
                Your name<br>
                <input v-model="user_name"><br>
                <br>
                タイムは{{count.toFixed(1)}}秒でした。<br>
                名前を入力してタイムを登録！
            </div>
            <div slot="footer">
                <button class="modal-default-button" @click="sendResult">
                    送信
                </button>
                <button class="modal-default-button" @click="showModal = false">
                    キャンセル
                </button>
            </div>
        </modal>
        <modal v-if="showModalComplete" @close="showModalComplete = false">
            <h3 slot="header">Saved!</h3>
        </modal>
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
            showModal: false,
            user_name: '',
            showModalComplete: false,
        };
    },
    methods: {
        initMap: function () {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
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
                                    self.showModal = true;
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
        },
        sendResult() {
            this.showModal = false;

            var self = this;

            //cookieに保存
            this.$cookie.set('user_name', this.user_name, 365);
            //userIdはcookieを参照し、無かったらここで作る
            var user_id = this.$cookie.get('user_id');
            if(user_id == null) {
                this.$cookie.set('user_id', this.$uuid.v1(), 365);
            }

            let params = new URLSearchParams();
            params.append('user_id', user_id);
            params.append('user_name', this.user_name);
            params.append('country_code', this.country_code);
            params.append('score', this.count);

            var url = '/api/putScore';

            axios.post(url, params).then(function(response){
                //self.showModalComplete = true;
                //self.$router.push({ name: 'score-country-view', params:{country_code:self.country_code}});
                self.$router.push({ name: 'score-user-view', params:{user_id:user_id}});
            });
        }
    },
    mounted: function () {
        var self = this;

        var tmp_name = this.$cookie.get('user_name');
        console.log(tmp_name);
        console.log(this.$cookie.get('user_id'));
        if(tmp_name != null) {
            this.user_name = tmp_name;
        }

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
