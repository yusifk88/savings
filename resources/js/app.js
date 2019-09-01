/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import '@mdi/font/css/materialdesignicons.css'
require('./bootstrap');
import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import 'vuetify/dist/vuetify.min.css';
window.Vue = require('vue');
Vue.use(Vuetify);
Vue.use(VueRouter);

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

import Dashboard from './components/Dashboard.vue';
import Accounts from './components/Accounts.vue';
import Account from './components/Account.vue';
import moment from  'moment';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const routes = [
    { path: '/', component: Dashboard },
    { path: '/accounts', component: Accounts },
    { path: '/account/:id',
      component: Account,
        props:true

    }

];
const router = new VueRouter({
    routes,
    mode:'history'
});


const app = new Vue({
    el: '#app',
    router,
    vuetify: new Vuetify(),
    icons: {
        iconfont: 'mdi', // default - only for display purposes
    },

    data(){
        return {
          drawer:null
        }
    },
    methods:{

    },


});
Vue.filter('humanDate',(d)=>{
    if(d){

        return moment().format('MMMM Do, YYYY',d);
    }

});

