<script setup>

import {ref, reactive ,onMounted} from 'vue';
import axiosInstance from '../../../../axios';
import createProduct from './createProduct.vue';
import editproduct from './editproduct.vue';


const products=ref([]);

const fetchProducts=async()=>{
   try{
           const response=await axiosInstance.get('user/getproducts');
           products.value=response.data.data;

   }catch(e){
       console.log("failed to fetch eller products");
   }
}

onMounted(()=>{
   fetchProducts();
});



  const deleteProduct=async(product)=>{
      if(confirm("are you sure to delete this product")){
          try {
       await axiosInstance.delete(`v1/products/${product}`);
       fetchProducts();

   } catch (error) {
       console.error('Error deleting user:', error);
   }
      }
 }

  const handleEmitEvent = (data) => {
    products.value=data;
    console.log('handled');
};


</script>

<template>


    <div class="container mt-4">

        <!-- create product -->
         <!-- <createProduct @createEvent="handleEmitEvent"></createProduct> -->


         <!-- show products -->

        <h2 class="mt-3">my products</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Product price</th>

                    <th>Number of Selling</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in products" :key="product">
                    <router-link
                        :to="{
                            name: 'showProduct',
                            params: { slug: product.slug },
                        }"
                        ><td>{{ product.name }}</td></router-link
                    >
                   

                    <td>{{product.price}}</td>

                    <td>{{ product.number_of_selling }}</td>
                    <td>
                        <!-- <button class="btn btn-warning btn-sm m-1" @click="updateProduct(product.slug)">Update</button> -->
                        <editproduct :product="product"   @updateEvent="handleEmitEvent"></editproduct>
                        <button
                            class="btn btn-danger btn-sm m-1"
                            @click="deleteProduct(product.slug)"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
