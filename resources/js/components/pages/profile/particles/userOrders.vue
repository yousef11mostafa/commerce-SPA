
<script setup>

 import {ref, reactive  , computed , onMounted } from 'vue';
import { useStore } from 'vuex';

 import axiosInstance from '../../../../axios';

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
    <div class="order-history mt-4">
  <h4>Order History</h4>
  <div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="orderHistoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
      show your Orders

    </button>
    <ul class="dropdown-menu" aria-labelledby="orderHistoryDropdown">
      <li v-for="order in orders " :key="order.id" ><p class="dropdown-item" href="#">
        Transaction_id <span class="text-primary"> {{order.transaction_id}} </span>
         Total_price <span class="text-danger">{{order.total}}</span> $
          Order_Date <span class="text-primary">{{order.created_at}}</span>
         </p>
         </li>

      <!-- Add more orders here as needed -->
    </ul>
  </div>
</div>
</template>
