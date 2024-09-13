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

const user=computed(()=>store.state.auth.user);
const roles=computed(()=>store.state.auth.roles);


</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark navbar-dark bg-secondary  navbar-custom">
    <div class="container-fluid">
       <router-link to="/dashboard" class="nav-link text-white active" aria-current="page">Admin Dashboard</router-link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
           <router-link to="/" class="nav-link text-white active" aria-current="page">website</router-link>
          </li>
          <li class="nav-item">
           <router-link to="/profile" class="nav-link text-white active" aria-current="page">profile</router-link>
          </li>
          <li class="nav-item">
             <a  href="#" @click.prevent="logout()" class="nav-link text-white active" aria-current="page">logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
