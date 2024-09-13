<script setup >

 import {ref , onMounted ,computed } from 'vue';
import { useStore } from 'vuex';

import editorders from '../components/editorders.vue'

 const store=useStore();

 const orders=ref([]);

  const fetchorders=async()=>{
      await store.dispatch("orders/getorders").then(()=>{
         orders.value=store.getters['orders/getorders'];
      });

  }

  const deleteOrder=async(order)=>{
       if(confirm("are you sure to delete this order")){
             await store.dispatch("orders/deleteOrder",order);
             fetchorders();
       }
  }

  onMounted(()=>{
     fetchorders();
  })


</script>


<template>


  <!-- {{ orders }} -->


  <div class="container mt-4">
    <h2>orders List</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>transaction_id</th>

          <th>Total</th>
          <th>User Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody v-if="orders  && orders.data && orders.data.data">
        <tr  v-for="order in orders.data.data" :key="order">
          <td>{{order.transaction_id}}</td>

          <td>{{ order.total }} </td>

          <td v-if="order.user">{{ order.user.name }}</td>
          <td v-else></td>
          <td>
              <!-- <editorders :order="order"  ></editorders> -->
            <button class="btn btn-danger btn-sm m-1" @click="deleteOrder(order.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>




</template>
