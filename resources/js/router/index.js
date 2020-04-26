import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue';

Vue.use(VueRouter)

const routes = [
  {
    path: '/admin/dashboard',
    name: 'dashboard',
    component: Home
  }
]

const router = new VueRouter({
  mode:'history',
  routes
})

export default router
