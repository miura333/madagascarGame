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
        <div class="scoreCell">
            <table border="0" class="scoreCellColl">
                <tr>
                    <td width="5%"></td>
                    <td width="30%">miura</td>
                    <td width="30%">アメリカ合衆国</td>
                    <td width="30%" class="scoreTextScore">100 sec</td>
                    <td width="5%"></td>
                </tr>
            </table>
        </div>
        <div class="appHeaderBorder"></div>
    </div>
</template>
