require('./bootstrap');
import Vue from 'vue';

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify);
import Toasted from 'vue-toasted';
  
Vue.config.productionTip = false
Vue.use(Toasted, {
  duration: 1000
})


window.Vue = require('vue');
Vue.component('user-body', require('./components/UserBody.vue').default);
Vue.component('header-user', require('./components/Header.vue').default);
Vue.component('footer-user', require('./components/Footer.vue').default);
Vue.component('generic-component', require('./components/GenericComponent.vue').default);
const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});

