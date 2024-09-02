<script setup>

 import { computed } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

  const store=useStore();

   let cnt=computed(()=>store.getters['payments/cartsize']);


</script>


<template>
<nav class="navbar  navbar-expand-lg navbar-dark bg-info fixed-top ">
  <div class="container">
    <!-- Navbar Text on the Left -->
    <span class="navbar-text text-light">
      <router-link to="/">Products</router-link>
    </span>

    <!-- Right-aligned Link -->
    <div class="d-flex ms-auto align-items-center">



       <router-link :to="{name:'Checout'}">
              <img src="https://th.bing.com/th/id/OIP.WCOHmvklpfIIDeAi3TjTDgHaHa?rs=1&pid=ImgDetMain" alt="basket" style="height:50px;border-radius:20%;">
                <span class="p-1 text-light fs-5 bg-danger m-1 rounded-pill">{{cnt}}</span>
       </router-link>

    </div>
  </div>
</nav>

</template>
