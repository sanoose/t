<script setup>
import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;

import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';

import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import Pagination from  '@/Layouts/Pagination.vue';
import  Skeleton  from '@/Components/Skeleton.vue';


defineOptions ({
   layout :   AppLayoutArchive
})


const props = defineProps ( ["letters_types" ] ) ; 
const processing = ref(false) ;


function  Restore(  id , name ) {
    Swal.fire({
        title: "استرجاع نوع الرسالة  ",
        icon: 'info',
        text: ` هل انت متأكد من استرجاع نوع الرسالة       ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "استرجاع",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.Settings.LetterTypes.Restore',id), 
            { method: 'get'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الاسترجاع بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الاسترجاع ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

</script>

<template>
<Head title="عرض أنواع الرسائل المحذوفة " />
         
                    <h3> عرض أنوع الرسائل المحذوفة </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
   

                                    <div class="col-md-12"> <br> </div>
                                    <Skeleton  :number = "10" v-if="processing"  />
                                    <table class="  table-striped"  v-if="!processing" >
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th> نوع البريد</th>
                                   
                                            <th> العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="letter_type , i   in props.letters_types.data" :key="letter_type.id"   >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ letter_type.name }}  </td>
 
                                            <td>
                                                <button  class="btn btn-info"
                                            @click="Restore(letter_type.id , letter_type.name )"
                                            >استرجاع  </button>
                                            </td>
                                            </tr>
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                  </div>

                  <div v-if="props.letters_types.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.letters_types"  /> 
                  </div>
       

  


</template>

<style scoped>




/* 
  .fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to   {
  opacity: 0;
} */

</style>

