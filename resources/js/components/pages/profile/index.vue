
<script setup>
import layout from '../../layout/layout.vue';
import userData from './particles/userData.vue';
import userOrders from './particles/userOrders.vue';
import updateProfile from './particles/updateProfile.vue';
import updatePassword from './particles/updatePassword.vue';


 import {ref, reactive  , computed , onMounted } from 'vue';
import { useStore } from 'vuex';

 import axiosInstance from '../../../axios';

const store=useStore();

const user=computed(()=>store.state.auth.user);

 const orders=ref([]);

 onMounted(async()=>{
      try{
         const res=await axiosInstance.get('user/getorders');
        orders.value=res.data;
      }catch(e){
        console.log('error in fetching the user orders '+e);
      }
 });

</script>


<template>

 <layout>

     <div>
         <div class="container my-5">
    <div class="card p-4 shadow">
      <h2 class="mb-3">User Profile</h2>



      <!-- User Info Section -->

      <user-data></user-data>





      <!-- Order History Section with Dropdown -->

       <user-orders></user-orders>



      <!-- Update Profile Section -->
      <update-profile :user="user"></update-profile>



         <!-- Update Password Section -->
           <update-password></update-password>

    </div>
  </div>

     </div>

 </layout>


</template>
