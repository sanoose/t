<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
import AppLayoutMain from "../../Layouts/AppLayoutMain.vue";
import Pagination from  '@/Layouts/Pagination.vue';
import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';


const props = defineProps ( ["users" , "filter" ] ) ; 
defineOptions ({
   layout :   AppLayoutMain
})

const form = useForm({
  search_email: props.filter.search_email ,
  search_name: props.filter.search_name ,
});

function Search(e) {
  form.get(route("users.Deleted") , { preserveState: true } );
}

function  Restore(id , name ) {
    Swal.fire({
        title: "استرجاع المستخدم",
        icon: 'info',
        text: `؟ ${name} هل تريد استعادة المستخدم  `,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "استرجاع",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            router.visit(route('Users.Restore',id), 
            { method: 'get'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم استرجاع المستخدم بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الاسترجاع ")   , } )
        }
    });
}

</script>
            <template>
                    <Head title="عرض المستخدمين" />
                    <h3>   المستخدمين المحذوفين </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_name"  v-model="form.search_name"  
                                            placeholder="البحث بالاسم"   
                                            />
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_email"  v-model="form.search_email" 
                                            placeholder="البحث بايميل المستخدم"   
                                            />
                                        </div>
                                        <div class="col-md-3">
                                            <button class="btn btn-primary submit" @click="Search">بحث</button>
                                        </div>
                                        <div class="col-md-12"> <br> </div>
                                    </div>

                                    <table class=" table-striped">
                                        <thead>
                                            <tr>
                                            <th>الاسم الكامل</th>
                                            <th>اسم المتسخدم</th>
                                            <th>نوع المستخدم</th>
                                            <th>المستوى</th>
                                            <th>أضيف بواسطة</th>
                                            <th>العمليـات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in props.users.data" :key="user.id" :class="user.banned == 'true' ? 'banned' : '' " >
                                            <td > {{ user.name }} </td>
                                            <td>{{ user.email }} </td>
                                            <td>{{ user.user_type }} </td>
                                            <td>{{ user.user_level  }} </td>
                                            <td>{{ user.added_by  }} </td>
                                            <td>
                                            <button  class="btn btn-info"
                                            @click="Restore(user.id , user.name )"
                                            >استرجاع  </button>
                                            </td>
                                            </tr>
                                        </tbody>
                                    </table>

                               
                        </div>

                    
                    </div>
                  </div>

                  <div v-if="props.users.data.length >= 1" class="flex justify-center">
                                        <Pagination :data = "props.users"  /> 
                 </div>
                 
       
            </template>

<style scoped>

  .banned {
    background-color: #d50043 ;
  }
</style>

