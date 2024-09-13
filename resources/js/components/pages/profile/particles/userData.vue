
<script setup>

 import {computed } from 'vue';
import { useStore } from 'vuex';
const store=useStore();

const user=computed(()=>store.state.auth.user);

</script>



<template>
         <div class="user-info row mb-4">
        <div class="col-md-3 text-center">
          <!-- User Profile Picture -->
          <img src="https://via.placeholder.com/150" class="img-fluid rounded-circle" alt="User Profile Picture">
        </div>
        <div class="col-md-9">
          <p><strong>Name:</strong> {{ user.name }}</p>
          <p><strong>Email:</strong>{{ user.email}}</p>
          <p><strong>Address:</strong> {{user.address}} {{user.city}} {{ user.state }} </p>
          <p><strong>zip_code:</strong> {{user.zip_code}}  </p>

        </div>
      </div>
</template>
