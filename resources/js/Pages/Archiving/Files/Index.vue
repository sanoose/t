<script setup>
import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;

import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';

import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import Pagination from  '@/Layouts/Pagination.vue';
import  Skeleton  from '@/Components/Skeleton.vue';
import * as Functions from "@/jsFiles/Functions.js" ;

// import pdf from 'pdfvuer'
// import 'pdfjs-dist/build/pdf.worker.entry' // not needed since v1.9.1



// import pdf from 'vue-pdf'; // Import vue-pdf without using named import

const props = defineProps ( [ "files" , "filter" , "page_number" , "companies" ] ) ; 
let  processing = ref(false) ;
let  years =  ref (Functions.GetYears()) ;
const form = useForm({
    search_company_name       :  props.filter.search_company_name != undefined ? props.filter.search_company_name : ""  ,
    search_folder_number      :  props.filter.search_folder_number != undefined  ? props.filter.search_folder_number : ""  ,
    search_year               :  props.filter.search_year != undefined  ? props.filter.search_year : ""  ,
    search_external_reference :  props.filter.search_external_reference != undefined  ? props.filter.search_external_reference : ""  , 
    page_number               :  props.filter.page_number   ,
});
 
function FilesSearch(e) {
  form.get(route("Archiving.Files.index"), { preserveState: true });
}

function  Delete(  id , name ) {
    Swal.fire({
        title: "حدف الملف  ",
        icon: 'error',
        text: ` هل انت متأكد من حدف   الملف  رقم    ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.Files.destroy',id), 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

 
</script>

<template>

<Head title="عرض  الملفات " />
 

        <AppLayoutArchive> 
                    <h3> عرض    الملفات </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap ">
                                    <div class="row ">
                                        <div class="col-md-2">
                                            <select class="form-control"  placeholder="البحث باسم الشركة"  v-model="form.search_company_name" >
                                                  <option value=""  disabled >--البحث  باسم الشركة --</option>
                                                    <option  v-for="company , i  in  props.companies" :key="i"  
                                                    :value="company.company_name"> {{ company.company_name }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="search_folder_number"  v-model="form.search_folder_number"
                                            placeholder="البحث برقم الملف"   
                                               />
                                        </div>

                                        <div class="col-md-2">
                                            <select     class="form-control"  v-model="form.search_year" >
                                                    <option value="" disabled >--البحث  بالسنة --</option>
                                                    <option  v-for="year , i  in years " :key="i"  
                                                    :value="year"> {{  year }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-2">
                                            <button class="btn btn-primary submit" @click="FilesSearch()">بحث</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row ">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_external_reference"  v-model="form.search_external_reference"
                                            placeholder="البحث برقم المرجع الخارجي" @input="FilesSearch()"  
                                               />
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2 page_number" >
                                            <label for=""> عدد النتائج</label>
                                            &nbsp;

                                            <input type="number" min="0" class="form-control" 
                                            @input="FilesSearch()"
                                            v-model="form.page_number"
                                            placeholder=""   
                                               />

                                        </div>
                                    </div>
                                    <div class="col-md-12"> <br> </div>
                                    <Skeleton  :number = "10" v-if="processing"  />
                                    <table class="  table-striped "  v-if="!processing" >
                                        <thead class="">
                                            <tr>
                                            <th>#</th>
                                            <th>اسم الشركة </th>
                                            <th>رقم الملف</th>
                                            <th>رقم المرجع الخارجي</th>
                                            <th>تاريخ استلام البلاغ</th>
                                            <!-- <th>تاريخ البلاغ</th> -->
                                          
                                            <th>رقم البطاقة</th>
                                            <th>  تاريخ بداية التأمين</th>
                                            <th>  تاريخ انتهاء التأمين</th>
                                            <th>  تاريخ  الحادث</th>
                                            <th>اسم المؤمن</th>
                                            <!-- <th>نوع المركبة </th>
                                            <th>  رقم اللوحة </th> -->
                                            <th>  جهة البلاغ </th>
                                            <th>  الإحتياطي </th>
                                            <!-- <th>  الاحتياطي بالدينار الليبي </th> -->
                                            <th> نوع الضرر </th>
                                            <th>صورة البلاغ</th>
                                            <th> حالة الملف</th>
                                            <th>العمليـات</th>
                                            </tr>
                                        </thead>
                                     
                                        <tbody class="">
                                   
                                            <tr v-for="file , i   in  files.data" :key="i"
                                                :class= "{'shining_warning_tr'  : file.date_errors != null}"
                                            >
                                         
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ file.company_name }}  </td>
                                            <td>   {{  `${file.year}/${file.folder_number}` }}  </td>
                                            <td > {{ file.external_reference }}  </td>
                                            <td > {{ file.receive_report_date }}  </td>
                                            <!-- <td > {{ file.report_date }}  </td> -->
                                         
                                            <td > {{ file.card_number }}  </td>
                                            <td > {{ file.insurance_start_date }}  </td>
                                            <td > {{ file.insurance_end_date }}  </td>
                                            <td > {{ file.accident_date }}  </td>
                                            <td > {{ file.insurance_name }}  </td>
                                            <!-- <td > {{ file.vehicle_type }}  </td>
                                            <td > {{ file.plate_number }}  </td> -->
                                            <td > {{ file.report_party.report_party_name }}  </td>
                                            <td > {{ `${ Functions.MakeNumberLikeMony(file.reserve) }  ${file.currency_type}`}}  </td>
                                            <!-- <td > {{ file.libyan_price }} دينار ليبي  </td> -->
                                            <td > {{ file.damage_type }}  </td>
                                            <td >  <a :href="`/storage/${file.report_img}`" target="_blank"   > <fa icon = "file-pdf" /> </a>  
                                                <!-- <pdf :src="`/storage/${file.report_img}`" :key="`/storage/${file.report_img}`" /> -->
                                            </td>
                                            <td > {{  file.file_status  }}</td>
                                            
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
          
                                                    <li><Link class="dropdown-item btn btn_info " :href="route('Archiving.Files.Models.CreateReportReferralMessage' , file.id )" >انشاء رسالة إحالة بلاغ <fa icon = "file" /> </Link></li>
                                                    <li><Link class="dropdown-item btn btn_info " :href="route('Archiving.Messages.ReportsMessages.ReportMessageCreate' , file.id )" >ارسال رسالة  <fa icon = "reply" />  </Link></li>
                                                    <li><Link class="dropdown-item btn btn_info " :href="route('Archiving.Claims.ClaimCreate' , file.id )" >   انشاء مطالبة  <fa icon = "hand-holding-dollar" />  </Link></li>
                                                    <li><Link class="dropdown-item btn btn_edit " :href="route('Archiving.Files.edit' , file.id )" >تعديل   <fa icon = "edit" /> </Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete(file.id , `${file.company_name}/${file.year}/${file.folder_number}`  )"
                                                      >حذف  <fa icon = "trash" />  </span></li>
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

                  <div v-if="props.files.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.files"  /> 
                  </div>
        </AppLayoutArchive>


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

