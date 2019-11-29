/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import "./components/mercadoLibre/mixins/mlUpdateUserMixin";
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';
import { store } from './store/store';
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);


import swal from 'sweetalert2';
window.swal = swal;
const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);


import VueRouter from 'vue-router';

import VueProgressBar from 'vue-progressbar';
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedcolor: 'red',
    height: '2px'
})


Vue.use(VueRouter);

let routes = [
    { path: '/home', component: require('./components/Home.vue').default },
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    //   { path: '/mercadoLibre', component: require('./components/MercadoLibre.vue').default },
    {
        path: '/mercadolibre',
        component: require('./components/mercadoLibre/MLMain.vue').default,
        meta: {
            requieresAuth: true
        },
        children: [
            {
                path: '/',
                component: require('./components/mercadoLibre/MLVentas.vue').default
            },
            {
                path: 'ventas',
                component: require('./components/mercadoLibre/MLVentas.vue').default
            },
            {
                path: 'Publicaciones',
                component: require('./components/mercadoLibre/MLPublicaciones.vue').default
            }

        ]
    },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/access_token', component: require('./components/mercadoLibre/MLAccessToken.vue').default },
    { path: '/mlusers', component: require('./components/mercadoLibre/MlUsers.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }

]

const router = new VueRouter({
    mode: 'history',
    routes
})

Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('myDate', function (created) {
    return moment(created).format('MMMM Do YYYY');
});


window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
Vue.component('pagination', require('laravel-vue-pagination'));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    router,
    data: {
        search: ""
    },
    methods: {
        searchit() {
            Fire.$emit('searching');
        }
    }
});
