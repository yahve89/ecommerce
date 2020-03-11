import Vue from 'vue'
import Axios from 'axios'
import App from './App.vue'
import router from './router'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'font-awesome/css/font-awesome.css'
import './assets/styles/app.css';
import './assets/styles/responsive.css'
import { Base64 } from 'js-base64'
import Meta from 'vue-meta'
import VueScrollTo from 'vue-scrollto'

Vue.use(VueScrollTo)
Vue.use(Meta);
Vue.use(BootstrapVue);
Vue.config.productionTip = false;

Vue.prototype.$http = Axios;
Vue.prototype.$http.defaults.baseURL = 'http://erp.everyday-cosmetics.ru/';

if (window.location.hostname == 'localhost')
  Vue.prototype.$http.defaults.baseURL = 'http://server/';

var token = localStorage.getItem('token');

if (token)
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token;

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')