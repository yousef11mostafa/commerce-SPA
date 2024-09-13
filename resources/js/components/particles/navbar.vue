<script setup>

 import { computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";



  const store=useStore();

   let cnt=computed(()=>store.getters['payments/cartsize']);


const router=useRouter();

const logout=()=>{
     store.dispatch("auth/logout",router);
}

const isAuthenticated=computed(()=>store.getters["auth/isAuthenticated"]);;
const isAdminAuthorized=computed(()=>store.getters['auth/isAuthorized']("admin"));
const isSellerAuthorized=computed(()=>store.getters['auth/isAuthorized']("seller"));

const user=computed(()=>store.state.auth.user);
const roles=computed(()=>store.state.auth.roles);


</script>


<template>

<nav class="navbar  navbar-expand-lg navbar-dark bg-secondary fixed-top ">
  <div class="container">
    <!-- Navbar Text on the Left -->
    <span class="navbar-text text-light">
      <router-link to="/">Home</router-link>

    </span>

    <!-- Right-aligned Link -->
    <div class="d-flex ms-auto align-items-center">

 <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

          <li class="nav-item" v-if="!isAuthenticated">
            <router-link to="/login"  class="nav-link text-white active" aria-current="page" >login</router-link>
          </li>
          <li class="nav-item" v-if="!isAuthenticated">
            <router-link to="/register" class="nav-link text-white active" aria-current="page">register</router-link>
          </li>
          <li class="nav-item" v-if="isAuthenticated">
            <a  href="#" @click.prevent="logout()" class="nav-link text-white active" aria-current="page">logout</a>
          </li>
          <li class="nav-item" v-if="isAuthenticated">
            <router-link to="/profile" class="nav-link text-white active" aria-current="page">profile</router-link>
          </li>
          <li class="nav-item" v-if="isSellerAuthorized ">
            <router-link to="/seller" class="nav-link text-white active" aria-current="page">seller</router-link>
          </li>
          <li class="nav-item" v-if="isAdminAuthorized">
            <router-link to="/dashboard" class="nav-link text-white active" aria-current="page">dashboard</router-link>
          </li>

          <!-- start dropdown -->

          <!-- end dropdown -->

        </ul>

       <router-link :to="{name:'Checout'}">
              <img src="https://th.bing.com/th/id/OIP.WCOHmvklpfIIDeAi3TjTDgHaHa?rs=1&pid=ImgDetMain" alt="basket" style="height:50px;border-radius:20%;">
                <span class="p-1 text-light fs-5 bg-danger m-1 rounded-pill">{{cnt}}</span>
       </router-link>

    </div>
  </div>
</nav>

</template>
