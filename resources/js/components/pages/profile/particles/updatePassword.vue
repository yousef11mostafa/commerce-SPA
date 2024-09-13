
<script setup>


 import {ref, reactive  , computed , onMounted  ,defineProps  } from 'vue';
import { useStore } from 'vuex';

 import axiosInstance from '../../../../axios';


const error=ref({})


const data=reactive({
    current_password:'',
    new_password:'',
    new_password_confirmation:'',
});








const updatePassword=async()=>{
    try{
          error.value='';
          const response=await axiosInstance.post('user/changePassword',data);
          alert("password updated successfully");
    }catch(e){
        console.log("failed to update profile"+e);
        error.value=e.response.data;
    }
}




</script>


<template>
         <div class="update-password mt-5">
        <h4>Update Password</h4>
        <!-- {{ data }} -->
         <br>
        <!-- {{ error }} -->
         <p class="text-danger text-center" v-if="error && error.message">{{error.message}}</p>
        <form @submit.prevent="updatePassword">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" v-model="data.current_password" >

          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" v-model="data.new_password">

          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" v-model="data.new_password_confirmation">

          </div>

          <button type="submit" class="btn btn-warning">Update Password</button>
        </form>
      </div>
</template>
