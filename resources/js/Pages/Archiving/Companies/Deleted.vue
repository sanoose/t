<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
import Navbar from  '@/Layouts/Navbar.vue';
import AsideArchive from  '@/Layouts/AsideArchive.vue';
import Pagination from  '@/Layouts/Pagination.vue';
import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';


const props = defineProps ( ["companies" , "filter" , "page_number" ] ) ; 


const form = useForm({
    search_company_name : props.filter.search_company_name ,
    page_number :  props.page_number  ,
 
});

function CompanySearch(e) {
  form.get(route("Archiving.Companies.DeletedCompanies"), { preserveState: true });
}

function CompaniesRestore(id , name ) {
    Swal.fire({
        title: "استرجاع الشركة",
        icon: 'info',
        text: `  هل تريد استعادة الشركة  ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "استرجاع",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {

            router.visit(route('Archiving.Companies.CompaniesRestore' , id ), 
            { method: 'get'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم استرجاع المستخدم بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الاسترجاع ")   , } )
        }
    });
}

 




</script>

<template>

<Head title=" عرض الشركات المحذوفة" />

        <div class="wrapper">
            <AsideArchive />          
            <div class="content" >
                <Navbar />
                <div class="main-content">
                    <h3> عرض  الشركات المحذوفة </h3>
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
                                                    <option value="1"  > 1 </option>
                                                    <option value="2"> 2 </option>
                                                    <option value="3"> 3 </option>
                                                    <option value="5"> 5 </option>
                                                    <option value="30"> 30 </option>
                                                    <option value="40"> 40 </option>
                                                    <option value="50"> 50 </option>
                                                    <option value="60"> 60 </option>
                                                    <option value="70"> 70 </option>
                                                    <option value="80"> 80 </option>
                                                    <option value="90"> 90 </option>
                                                    <option value="100"> 100 </option>
                                            </select>
                                        </div>
                                  
                                    </div>


                                    <div class="col-md-12"> <br> </div>

                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                            <th  >#</th>
                                            <th> اسم الشركة</th>
                                            <th>   كود الشركة</th>
                                            <th>الرمز</th>
                                            <th>   الإيميلات</th>
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
                                                <p v-for="company_email in  company.company_emails " :id="company_email.id">
                                                     {{  `${company_email.company_email}  -- ${company_email.for}`  }}  
                                                </p>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
 
                                                    <li><span class="dropdown-item btn_edit  btn" 
                                                            @click="CompaniesRestore(company.id , company.company_name )"
                                                      >استرجاع</span></li>
                                                 
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
</template>

<style scoped>

  .banned {
    background-color: #d50043 ;
  }
</style>

