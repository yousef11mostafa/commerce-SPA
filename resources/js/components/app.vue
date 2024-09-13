<template>
  <!-- <h1>hello app</h1>
  <nav>
      <div>
        <router-link to="/">Home </router-link>
        <router-link to="/about">about</router-link>
      </div>
  </nav> -->

   <main>
     <router-view></router-view>
   </main>
</template>


<script setup>

import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';
const store=useStore();
const router=useRouter();
const route=useRoute();
console.log(route);
store.dispatch('auth/autoLogin',{router,route});

</script>
