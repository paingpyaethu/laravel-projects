require('./bootstrap');
window.Vue = require('vue').default;

import Swal from 'sweetalert2';

import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'
// import App from './App'

const options = {
    color: '#10d704',
    failedColor: '#874b4b',
    thickness: '2px',
    transition: {
        speed: '0.5s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
}

Vue.use(VueProgressBar, options)

// new Vue({
//     ...App
// }).$mount('#app')
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


Vue.component('pagination', require('laravel-vue-pagination-2.3.2'));
Vue.component('product-component', require('./components/ProductComponent.vue').default);

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

window.Swal = Swal;

const app = new Vue({
    el: '#app',
});
