
<script setup>


 import {ref, reactive  , computed , onMounted  ,defineProps  } from 'vue';
import { useStore } from 'vuex';

 import axiosInstance from '../../../../axios';

const store=useStore();

const props=defineProps({
    user:Object,
})


const error=ref({})


const data=reactive({
    name:'',
    email:'',
    state:'',
    city:'',
    address:'',
    zip_code:'',
    image:'',
});



const fillUserDAta=()=>{
   data.name=props.user.name;
   data.email=props.user.email;
   data.state=props.user.state;
   data.address=props.user.address;
   data.city=props.user.city;
   data.zip_code=props.user.zip_code;
}

onMounted(()=>{
    fillUserDAta();
})


const updateProfile=async()=>{
    try{
          error.value='';
          const response=await axiosInstance.post('user/updateProfile',data);
          await store.dispatch('auth/fetchProfile');
          alert("profile updated successfully");
    }catch(e){
        console.log("failed to update profile"+e);
        error.value=e.response.data.errors;
    }
}




</script>

<template>

          <div class="update-profile mt-5">


        <h4>Update Profile</h4>
        <form @submit.prevent="updateProfile">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Enter your name" v-model="data.name">
               <p class="text-danger" v-if="error && error.name">{{error.name[0]}}</p>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Enter your email" v-model="data.email">
              <p class="text-danger" v-if="error && error.email">{{error.email[0]}}</p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="state" class="form-label">state</label>
              <input type="text" class="form-control" id="state" placeholder="Enter your state"  v-model="data.state" >
               <p class="text-danger" v-if="error && error.state">{{error.state[0]}}</p>
            </div>
            <div class="col-md-6">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" placeholder="Enter your address"  v-model="data.address">
               <p class="text-danger" v-if="error && error.address">{{error.address[0]}}</p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="city" class="form-label">city</label>
              <input type="text" class="form-control" id="city" placeholder="Enter your city "  v-model="data.city" >
               <p class="text-danger" v-if="error && error.city">{{error.city[0]}}</p>
            </div>
            <div class="col-md-6">
              <label for="zip_code" class="form-label">zip_code</label>
              <input type="text" class="form-control" id="zip_code" placeholder="Enter your zip_code"  v-model="data.zip_code">
               <p class="text-danger" v-if="error && error.zip_code">{{error.zip_code[0]}}</p>
            </div>
          </div>

          <!-- <div class="mb-3">
            <label for="profilePicture" class="form-label">Profile Picture</label>
            <input type="file" class="form-control" id="profilePicture">
          </div> -->

          <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
      </div>
</template>
