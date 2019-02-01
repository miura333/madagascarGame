<template>
    <div class="appWrapper">
        <div class="appHeader">
            <div class="appHeaderTitle">
                <table border="0" width="100%">
                    <tr>
                        <td width="20%"></td>
                        <td width="60%">Result</td>
                        <td width="20%"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="appHeaderBorder"></div>
        <div v-for="score in scores">
            <div class="scoreCell">
                <div class="scoreCellColl">
                    <table border="0" width="100%">
                        <tr>
                            <td width="5%"></td>
                            <td width="45%">{{score.user_name}}</td>
                            <td width="45%" class="scoreTextScore">{{score.score.toFixed(1)}} sec</td>
                            <td width="5%"></td>
                        </tr>
                    </table>
                </div>
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
        };
    },
    methods: {
    },
    mounted: function () {
        var self = this;

        var url = '/api/getScoreByCountry';
        url += ('/' + this.$route.params.country_code);

        axios.get(url).then(function(response){
            console.log(response);
            self.scores = response.data.score;
        });
    }
};
</script>
