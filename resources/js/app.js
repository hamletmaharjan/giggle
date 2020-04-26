require('./bootstrap');
import Vue from 'vue';
import router from './router/index.js'
import Home from './views/Home.vue';


// Vue.use(VueRouter);

// const router = new VueRouter({
//     mode: 'history',
//     routes: [
//         {
//             path: '/',
//             component: Home
//         }
//     ]
// });


let app = new Vue({
    router
}).$mount('#app');
