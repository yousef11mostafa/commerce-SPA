import { createRouter, createWebHistory } from 'vue-router';


import LoginView from '../components/auth/login.vue'
import RegisterView from '../components/auth/register.vue'
import PasswordLink from '../components/auth/password-link.vue'
import PasswordReset from '../components/auth/password-reset.vue'


import HomeView from '../views/HomeView.vue'
import ShowProduct from '../components/pages/show.vue'
import Checout from '../components/pages/checkout.vue'
import Orders from '../components/pages/orders.vue'

import PostsView from '../components/pages/posts.vue'
import ProfileView from '../components/pages/profile/index.vue'



// seller
import SellerView from '../components/pages/seller/index.vue'

// admin
// import DashboardView from '../components/pages/dashboard.vue'
import DashboardView from '../components/pages/admin/index.vue'
import HomveView from '../components/pages/admin/views/home.vue'
import UsersView from '../components/pages/admin/views/users.vue'
import ProductsView from '../components/pages/admin/views/products.vue'
import OrdersView from '../components/pages/admin/views/orders.vue'
import SettingsView from '../components/pages/admin/views/settings.vue'








import NotFound from '../components/pages/NotFound.vue';
import UnAuthorized from '../components/pages/unauthorized.vue';



const routes = [

    // { path: '/', component: Home },
    // { path: '/about', component: About },

    {
        path: '/',
        name: 'home',
        component: HomeView
      },
      {
        path: '/login',
        name: 'login',
        component: LoginView,
        meta: { requiresGuest: true }
      },
      {
        path: '/register',
        name: 'register',
        component: RegisterView ,
        meta: { requiresGuest: true }
      },
      {
        path: '/forgot-password',
        name: 'passwordLink',
        component: PasswordLink ,
        // props: route => ({ token: route.query.token, email: route.query.email })
        meta: { requiresGuest: true }
      },
      {
        path: '/api/reset-password',
        name: 'passwordReset',
        component: PasswordReset ,
        meta: { requiresGuest: true }
      },
      {
        path: '/posts',
        name: 'posts',
        component: PostsView,
        meta: { requiresAuth: true },
      },
      {
        path: '/profile',
        name: 'profile',
        component: ProfileView,
        meta: { requiresAuth: true },
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



      // seller routes

      {
        path:'/seller',
        name:'sellerIndex',
        component:SellerView,
        meta:{requiresAuth:true, role:"seller"}
      },



      //admin routes

      {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
        meta: { requiresAuth: true , role:'admin' },
        children: [
            {
                path: '',
                name: 'dashboard-default',
                component: HomveView,  // Default content when no child path
                meta: { requiresAuth: true, role: 'admin' }
            },
            {
              path: 'users',
              name: 'dashboard-users',
              component: UsersView,
              meta: { requiresAuth: true, role: 'admin' }
            },
            {
              path: 'products',
              name: 'dashboard-products',
              component: ProductsView,
              meta: { requiresAuth: true, role: 'admin' }
            },
            {
              path: 'orders',
              name: 'dashboard-orders',
              component: OrdersView,
              meta: { requiresAuth: true, role: 'admin' }
            },
            {
              path: 'settings',
              name: 'dashboard-settings',
              component: SettingsView,
              meta: { requiresAuth: true, role: 'admin' }
            },
          ]
      },


      //end

    { path: '/:pathMatch(.*)*', component: NotFound },
    { path: '/unauthorized', component: UnAuthorized },

];

const router = createRouter({
  history: createWebHistory(),
  routes,
});



import store  from '../store';


router.beforeEach((to, from, next) => {

    const isAuthenticated = store.getters['auth/isAuthenticated']; // Get auth status from Vuex

    if (to.matched.some(record => record.meta.requiresAuth) && !isAuthenticated ) {
      next('/login'); // Redirect to login if not authenticated
    } else if (to.matched.some(record => record.meta.requiresGuest) && isAuthenticated) {
      next('/'); // Redirect to home if authenticated and trying to access guest-only pages
    }
    // test
    else if (to.matched.some(record => record.meta.role)) {
        const requiredRole = to.meta.role;
        console.log(requiredRole);
        const hasRole = store.getters['auth/isAuthorized'](requiredRole) // Check if user has the required role
        console.log(hasRole);

        if (hasRole) {
            next(); // Allow access if the user has the required role
        } else {
            next('/unauthorized'); // Redirect to unauthorized page if the user lacks the required role
        }
    }
    // test

    else {
      next(); // Allow access
    }
  });


export default router;
