<template>
    <div class="sidebar">
    <h4 class="text-center text-white">Admin Panel</h4>
    <router-link to="/dashboard" class="nav-link text-white active" aria-current="page">dashboard</router-link>
    <router-link to="/dashboard/users" class="nav-link text-white active" aria-current="page">users</router-link>
   <router-link to="/dashboard/products" class="nav-link text-white active" aria-current="page">products</router-link>
    <router-link to="/dashboard/orders" class="nav-link text-white active" aria-current="page">orders</router-link>
   <router-link to="/dashboard/settings" class="nav-link text-white active" aria-current="page">settings</router-link>
  </div>
</template>

<style scoped>
    .sidebar {
      height: 100vh;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #343a40;
      padding-top: 20px;
    }
    .sidebar a {
      padding: 15px;
      text-align: center;
      display: block;
      color: #ffffff;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #007bff;
    }
</style>
