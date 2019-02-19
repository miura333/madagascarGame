<template>
    <div class="appWrapper">
        <div class="appHeader">
            <div class="appHeaderTitle">
                <table border="0" width="100%">
                    <tr>
                        <td width="20%"><router-link class="linkBackButtonText" :to="{name:'root-view'}">Back</router-link></td>
                        <td width="60%">Result</td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="appHeaderBorder"></div>
        <div v-for="score in scores">
            <div class="scoreCell">
                <table border="0" class="scoreCellColl">
                    <tr>
                        <td width="5%"></td>
                        <td width="30%">{{score.user_name}}</td>
                        <td width="30%">{{getCountryName(score.country_code)}}</td>
                        <td width="30%" class="scoreTextScore">{{score.score.toFixed(1)}} sec</td>
                        <td width="5%"></td>
                    </tr>
                </table>
            </div>
            <div class="appHeaderBorder"></div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            scores: [],
            country_array: []
        };
    },
    methods: {
        getCountryName(country_code) {
            for (var i = 0; i < this.country_array.length; i++) {
                if(this.country_array[i].code == country_code) {
                    return this.country_array[i].name;
                }
            }
            return null;
        }
    },
    mounted: function () {
        var self = this;

        var url = '/api/getScoreByUser';
        url += ('/' + this.$route.params.user_id);

        axios.get(url).then(function(response){
            console.log(response);
            self.scores = response.data.score;
            self.country_array = response.data.country_array;
        });
    }
};
</script>
