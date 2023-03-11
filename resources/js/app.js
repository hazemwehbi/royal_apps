require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import {routes} from './routes';
import JsonCSV from 'vue-json-csv';
import store from './store'
import VueToastr from "vue-toastr";
import myUpload from 'vue-image-crop-upload';

// use plugin
Vue.use(VueToastr);

Vue.use(VueRouter);

axios.defaults.baseURL = '/api/'
const token= localStorage.getItem('token')
if(token){
  axios.defaults.headers.common['Authorization'] = token
}
Vue.use(VueAxios, axios);
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
router.beforeEach((to, from, next) => {
    console.log(to.path)
    if (to.matched.some((record) => record.meta.guest)) {
      if (store.getters['auth/isAuthenticated']) {
        next();
        return;
      }
      next('/login');
    } 
    if (to.path!=='/login' && !store.getters['auth/isAuthenticated'] && to.path!=='/register'){
    next('/login');
    return;
    }
    next()
  });
  Vue.component('my-upload', myUpload)
const app = new Vue({
    el: '#app',
    router: router,
    store: store,

    render: h => h(App),
});

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('downloadCsv', JsonCSV);
