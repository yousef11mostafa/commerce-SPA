<script setup >

  import { useStore } from "vuex";
 import {ref, computed} from 'vue';
 import axiosInstance from '../../../../axios';

 import editproduct from '../components/editproduct.vue';

  const store=useStore();

   const products=ref([]);
   products.value = store.getters["products/getproducts"];

  const deleteProduct=async(product)=>{
       if(confirm("are you sure to delete this product")){
           try {
        await axiosInstance.delete(`v1/products/${product}`);
        await store.dispatch("products/getproducts").then(() => {
        products.value = store.getters["products/getproducts"];
    });
    } catch (error) {
        console.error('Error deleting user:', error);
    }
       }
  }


  const handleEmitEvent = (data) => {
    products.value=data;
};


</script>


<template>




       <div class="container mt-4">
    <h2>Products List</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Product Name</th>

          <th>Seller Name</th>
          <th>Number of Selling</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <router-link :to="{ name:'showProduct' , params: { slug: product.slug } }"><td>{{ product.name }}</td></router-link>

          <td v-if="product.user">{{ product.user.name  }}</td>
          <td v-else>notfound</td>
          <td>{{ product.number_of_selling }}</td>
          <td>
              <!-- <button class="btn btn-warning btn-sm m-1" @click="updateProduct(product.slug)">Update</button> -->
              <editproduct :product="product"   @updateEvent="handleEmitEvent"></editproduct>
            <button class="btn btn-danger btn-sm m-1" @click="deleteProduct(product.slug)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>






</template>
