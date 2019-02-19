
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueRouter from 'vue-router';
import VueCookie from 'vue-cookie';
import VueUUID from 'vue-uuid';

import game from './components/game.vue';
import modalDialog from './components/modalDialog.vue';
import scoreCountry from './components/scoreCountry.vue';
import scoreUser from './components/scoreUser.vue';
import scoreUserTest from './components/scoreUserTest.vue';

//require('./bootstrap');

require('../../public/css/madagascar.css');
require('../../public/css/vue-transition.css');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('modal', modalDialog);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(VueCookie);
Vue.use(VueUUID);

const routes = [
    { path: '/', name: 'root-view', component: game },
    { path: '/score/country', name: 'score-country-view', component: scoreCountry },
    { path: '/score/user', name: 'score-user-view', component: scoreUser }
];

const router = new VueRouter({
    routes // `routes: routes` の短縮表記
});

const app = new Vue({
    el: '#app',
    router: router,
    data: {
        pageTransition: 'forward'
    },
    watch: {
        '$route': function (to, from) {
            if(to.path == '/') {
                this.pageTransition = 'back';
            }else{
                this.pageTransition = 'forward';
            }
        }
    }
});
