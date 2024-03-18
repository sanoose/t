<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
 
import AppLayoutMain from  '@/Layouts/AppLayoutMain.vue';
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

function UserSearch(e) {
  form.get(route("Users.Index"), { preserveState: true });
}

function Delete(url , name ) {
    Swal.fire({
        title: "حدف المستخدم",
        icon: 'error',
        text: `؟ ${name} هل انت متأكد من حدف المستخدم  `,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            router.visit( url  , 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   , } )
        }
    });
}


function  Banned (id , deleted_name ) {
    Swal.fire({
        title: "حظر المستخدم",
        icon: 'warning',
        text: `؟ ${deleted_name} هل انت متأكد من حظر المستخدم  `,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حظر",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            router.visit(route('Users.Banned',id), 
            { method: 'get'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تمت عملية  الحظر بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحظر ")   , } )
        }
    });
}

function  UnBanned (id , deleted_name ) {
    Swal.fire({
        title: "حظر المستخدم",
        icon: 'warning',
        text: `؟ ${deleted_name} هل تريد الغاء الحظر عن حظر المستخدم  `,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "ايقاف الحظر",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            router.visit(route('Users.UnBanned',id), 
            { method: 'get'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تمت عملية ايقاف الحظر بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم ايقاف الحظر ")   , } )
        }
    });
}





</script>

<template>

<Head title="عرض المستخدمين" />

    
                  <h3> عرض  المستخدمين </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_name"  v-model="form.search_name" 
                                            placeholder="البحث بالاسم "   
                                            />
                                        </div>

                                        <div class="col-md-3">
                                          
                                            <input type="text" class="form-control" id="search_email"  v-model="form.search_email"
                                            placeholder="البحث بايميل المستخدم"   
                                               />
                                          
                                        </div>
                                  
                                        <div class="col-md-3">

                                            <button class="btn btn-primary submit" @click="UserSearch">بحث</button>
                                        </div>
                                        <div class="col-md-12"> <br> </div>
                                    </div>

                                    <table class="  table-striped">
                                        <thead>
                                            <tr>
                                            <th>الاسم الكامل</th>
                                            <th>اسم المتسخدم</th>
                                            <th>المستوى</th>
                                            <th>تابع للمكون</th>
                                            <th>أضيف بواسطة</th>
                                            <th>العمليـات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="user in props.users.data" :key="user.id" :class="user.banned == 'true' ? 'banned' : '' " >
                                            <td > {{ user.name }} </td>
                                            <td>{{ user.email }} </td>
                                            <td>{{ user.user_level  }} </td>
                                            <td>{{ user.department.name }} </td>
                                            <td>{{ user.user.name  }} </td>
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><Link class="dropdown-item btn btn_edit " :href="user.edit_id" >تعديل</Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete(user.delete_id , user.email )"
                                                      >حذف</span></li>

                                                    <li v-if="user.banned == 'false' "><span class="dropdown-item  btn btn_banned" 
                                                        @click="Banned (user.id , user.email  )"> حظر</span>
                                                    </li>

                                                    <li v-if="user.banned == 'true' "><span class="dropdown-item  btn btn_banned" 
                                                        @click="UnBanned (user.id , user.email  )">الغاء الحظر</span>
                                                    </li>

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

                  <div v-if="props.users.data.length >= 1" class="flex justify-center">
                                        <Pagination :data = "props.users"  /> 
                  </div>
     
</template>

<style scoped>

  .banned {
    background-color: #d50043 ;
  }
</style>

