<script setup>
import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;

import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';

import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import Pagination from  '@/Layouts/Pagination.vue';
import  Skeleton  from '@/Components/Skeleton.vue';

const props = defineProps ( ["companies" , "filter" , "page_number" ] ) ; 
let  processing = ref(false) ;
let   email_index = ref('') ;

const form = useForm({
    search_company_name : props.filter.search_company_name ,
    page_number :  props.page_number  ,
});

function CompanySearch(e) {
  form.get(route("Archiving.Companies.index"), { preserveState: true });
}

function CompanyDelete(  id , name ) {
    Swal.fire({
        title: "حدف المستخدم",
        icon: 'error',
        text: ` هل انت متأكد من حدف الشركة باسم    ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.Companies.destroy',id), 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

function  CompanyEmailDelete(id , name ) {
    Swal.fire({
        title: "حدف إيميل الشركة",
        icon: 'error',
        text: `   ؟ ${name}  هل انت متأكد من حدف الإيميل `,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.Companies.CompanyEmailDelete',id), 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,  
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}
function ShowEmails(i) {
    email_index.value = i ;
}

function HideEmails() {
    email_index.value =  '' ;
}
</script>

<template>

<Head title="عرض الشركات" />

        <div class="wrapper">
            <AsideArchive />          
            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <h3> عرض  الشركات </h3>
                    <hr>

                 
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_company_name"  v-model="form.search_company_name" 
                                            placeholder="البحث باسم الشركة "   
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary submit" @click="CompanySearch">بحث</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 page_number" >
                                            <label for=""> عدد النتائج</label>
                                            &nbsp;
                                            <select  class="form-control"  v-model="form.page_number" @change="CompanySearch()">
                                                    <option value="1"  >  1 </option>
                                                    <option value="2"  >  2 </option>
                                                    <option value="3"  >  3 </option>
                                                    <option value="5"  >  5 </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12"> <br> </div>
                                    <Skeleton  :number = "10" v-if="processing"  />
                                    <table class="  table-striped"  v-if="!processing" >
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>اسم الشركة</th>
                                            <th>كود الشركة</th>
                                            <th>الرمز السري</th>
                                            <th>الإيميلات</th>
                                            <th>العمليـات</th>
                                            </tr>
                                        </thead>
                                     
                                        <tbody>
                                   
                                            <tr v-for="company , i   in props.companies.data" :key="company.id"   >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ company.company_name }} </td>
                                            <td>{{ company.company_code }} </td>
                                            <td>{{ company.company_password  }} </td>
                                            <td>
                                            <Transition name="bounce">
                                                <div    v-if="email_index == company.id" >
                                                    <fa  icon = "eye-slash" class="danger_hover"  @click = "HideEmails()"/> 
                                                    <p v-for="company_email in  company.company_emails " :id="company_email.id">
                                                        {{  `${company_email.company_email}  -- ${company_email.for}`  }}  
                                                        <label>
                                                            <Link :href="route('Archiving.Companies.CompanyEmailEdit' , 
                                                            [ company_email.id , company.id ] )"> 
                                                                <fa  icon = "edit" class="icon_hover" /> </Link>
                                                                &nbsp;  
                                                            <fa  icon = "trash" class="danger_hover" 
                                                            @click = "CompanyEmailDelete( company_email.id , company_email.company_email )"   /> 
                                                        </label>
                                                    </p> 
                                                </div>
                                                <div v-else> <fa  icon = "eye" class="icon_hover"  @click = "ShowEmails(company.id)"/>  </div>
                                            </Transition>
                                            </td>
                                 
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><Link class="dropdown-item btn btn_edit " 
                                                         :href="route('Archiving.Companies.CompanyEmailCreate' , company.id  )" 
                                                         >اضافة إيميل   <fa  icon = "plus" class="icon_hover" /> </Link>
                                                    </li>
                                                    <li><Link class="dropdown-item btn btn_edit " :href="route('Archiving.Companies.edit' , company.id )" >تعديل</Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="CompanyDelete(company.id , company.company_name )"
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

                  <div v-if="props.companies.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.companies"  /> 
                  </div>
                </div>
                 
            </div>
        </div>

        <div id="demo">
  

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

