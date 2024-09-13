
<script setup>

import { onMounted, ref } from "vue";
import axiosInstance from '../../../../axios';

const users = ref([]);

// Function to fetch users
const fetchUsers = async () => {
  try {
    const response = await axiosInstance.get("admin/users");
    users.value = response.data.data;
  } catch (error) {
    console.error("Error fetching users:", error);
  }
};


onMounted(async () => {
  await fetchUsers();
});


const deleteUser = async (user_id) => {
  try {
    await axiosInstance.delete(`admin/user/destroy/${user_id}`);
    await fetchUsers();
  } catch (error) {
    console.error('Error deleting user:', error);
  }
};





</script>



<template>
<div>
     hello from users
    <br>

  <div class="container mt-4">
    <h2>Users List</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Stripe ID</th>
          <th>Number of Orders</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.stripe_id }}</td>
          <td>{{ user.orders_count }}</td>
          <td>
            <button class="btn btn-danger" @click="deleteUser(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>





</div>

</template>
