<script setup>
import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;

import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';

import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import Pagination from  '@/Layouts/Pagination.vue';
import  Skeleton  from '@/Components/Skeleton.vue';

const props = defineProps ( ["letters_types" ] ) ; 
const processing = ref(false) ;


defineOptions ({
   layout :   AppLayoutArchive
})

function  Delete(  id , name ) {
    Swal.fire({
        title: "حدف نوع الرسالة  ",
        icon: 'error',
        text: ` هل انت متأكد من حدف نوع الرسالة       ${name}  ؟`,
        type: "warning",
        showCancelButton: true ,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(id, 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

</script>

<template>
<Head title="عرض أنوع الرسائل " />
      
                    <h3> عرض أنوع الرسائل </h3>
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
                                            <th> نوع الرسالة</th>
                                            <th> العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="letter_type , i   in props.letters_types.data" :key="letter_type.id"   >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ letter_type.name }}  </td>
 
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
          
                                                    <li><Link class="dropdown-item btn btn_edit " 
                                                      :href="letter_type.edit_id " >تعديل</Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete( letter_type.delete_id , 
                                                            `
                                                            رقم ${letter_type.id}   
                                                            باسم ${letter_type.name } 
                                                            `)"
                                                      >حذف</span></li>
                                                    <li><br class="dropdown-divider" /></li>
                                                </ul>
                                                </div>
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

