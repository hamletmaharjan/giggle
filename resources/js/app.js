require('./bootstrap');
import Vue from 'vue';
import App from './App.vue';


new Vue({
    render: function(createElement){
        return createElement(App);
    }
}).$mount('#app');