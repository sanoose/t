<script setup>
 import Navbar from  '@/Layouts/Navbar.vue';
import AsideMain from  '@/Layouts/AsideMain.vue';
import { onMounted } from 'vue';


</script>





<template>
              <div class="wrapper">
             <AsideMain />

            <div class="content" >
                <Navbar />
                <div class="main-content">
                       <slot />
                </div>
                 
            </div>
        </div>
</template>