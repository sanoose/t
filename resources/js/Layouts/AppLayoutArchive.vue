<script setup>
 import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
</script>





<template>
              <div class="wrapper">
             <AsideArchive />

            <div class="content" >
                <Navbar />
                <div class="main-content">
                       <slot />
                </div>
                 
            </div>
        </div>
</template>


