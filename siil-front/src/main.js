import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import vuetify from './plugins/vuetify';
import VueSweetalert2 from 'vue-sweetalert2';
import axios from 'axios';
import url from "./config/config.js"




Vue.use(VueSweetalert2);



Vue.config.productionTip = false

Vue.prototype.$url = url;
Vue.prototype.$http = axios;
//Vue.prototype.$http.defaults.headers.common ['Authorization'] = `Bearer ` + localStorage.getItem('token'); 
const token = localStorage.getItem('token');
if (token) {
  console.log(token);
  Vue.prototype.$http.defaults.headers.common ['Authorization'] = `Bearer ` + token ;
}

 



new Vue({
  router,
  store,
  vuetify,
  render: h => h(App)
}).$mount('#app')
