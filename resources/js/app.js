require('./bootstrap');
import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import Home from './views/Home.vue';
import Login from './views/Login.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home 
        },
        { 
            path: '/login', 
            name: 'login',
            component: Login
        }

    ]
});


new Vue({
    router,
    render: function(createElement){
        return createElement(App);
    }
}).$mount('#app');