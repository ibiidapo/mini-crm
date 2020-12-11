import 'babel-polyfill';
//vue js
import Vue from 'vue';
//bootstrap 4 for vue js
import BootstrapVue from 'bootstrap-vue';
//validation library for vue
import Vuelidate from 'vuelidate';
//font awesome icons
import '@fortawesome/fontawesome-free/css/all.css';

window.Vue = Vue;
Vue.use(BootstrapVue);
Vue.use(Vuelidate);
