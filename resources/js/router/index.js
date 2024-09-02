import { createRouter, createWebHistory } from 'vue-router';

import NotFound from '../components/pages/NotFound.vue';

import HomeView from '../views/HomeView.vue'
import ShowProduct from '../components/pages/show.vue'
import Checout from '../components/pages/checkout.vue'
import Orders from '../components/pages/orders.vue'

const routes = [

    // { path: '/', component: Home },
    // { path: '/about', component: About },

    {
        path: '/',
        name: 'home',
        component: HomeView
      },

      {
        path:'/products/:slug',
        name:"showProduct",
        component:ShowProduct
      },
      {
        path:'/checkout',
        name:"Checout",
        component:Checout
      },
      {
        path:'/orders',
        name:"Orders",
        component:Orders
      },

    { path: '/:pathMatch(.*)*', component: NotFound },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
