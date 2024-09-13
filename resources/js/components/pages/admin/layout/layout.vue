<script setup>

 import navbar from '../particles/navbar.vue'
 import sidebar from '../particles/sidebar.vue'

</script>


<template>

<div>

  <!-- Sidebar -->

  <sidebar></sidebar>


  <!-- Navbar -->

     <navbar></navbar>

  <!-- Main Content -->
  <div class="content">
          <slot></slot>
  </div>

</div>



</template>


  <style scoped>
    body {
      font-family: Arial, sans-serif;
    }

    .navbar-custom {
      margin-left: 250px;
      background-color: #343a40;
      color: white;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
  </style>
