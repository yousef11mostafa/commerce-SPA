<script setup>
    import navbar from '../particles/navbar.vue'
</script>

<template>
        
     <navbar></navbar>
    <div class="container" style="margin-top:100px;">
        <slot></slot>
    </div>
</template>
