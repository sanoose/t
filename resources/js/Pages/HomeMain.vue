<script setup>
import { Head , useForm, usePage } from "@inertiajs/vue3" ;
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue';
import { computed, onMounted } from "vue";
import { toast } from 'vue3-toastify';
import { router } from '@inertiajs/vue3'


const  page  = usePage() ;
const  user  = computed(() => page.props.auth.user) ;

defineOptions ({
   layout :   AppLayoutMain ,
}) ;

onMounted (() => {
   if (user.value.is_new_user) {
    toast("الرجاء تغيير كلمة المرور", { onClick: () =>  router.visit(route('Users.Profile.Partials.UpdatePasswordForm')) , 
    autoClose: 10000    } , 
      );
    }
}) ;
 
</script>

<template>

<Head title=" الرئيسية" />
      <h3>   الرئيسية </h3>
      <hr>
      <div class="">
      <img class = "main_img" src="/storage/logo/logo2.png" alt="" >
      </div>
      <hr>
    

     
</template>

<style scoped>
 
</style>

