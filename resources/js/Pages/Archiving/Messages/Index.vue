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

const props = defineProps ( [  "messages"  , "filter" , "page_number"   ] ) ; 
let  processing = ref(false) ;
 
const form = useForm({
    search_message_title       :  props.filter.search_message_title != undefined ? props.filter.search_message_title : ""  ,
    page_number               :  props.filter.page_number   ,
});

function MessagesSearch(e) {
  form.get(route("Archiving.Messages.Index"), { preserveState: true });
}

function  Delete(  id , name ) {
    Swal.fire({
        title: "حدف الرسالة  ",
        icon: 'error',
        text: ` هل انت متأكد من حدف   الرسالة       ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            // processing.value = true ;
            // router.visit(route('Archiving.Files.destroy',id), 
            // { method: 'delete'  ,  preserveScroll: true  ,
            // onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            // onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            // onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

 
</script>

<template>

<Head title="عرض  الرسائل " />
 

        <AppLayoutArchive> 
                    <h3> عرض    الرسائل </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap ">
                                    <div class="row ">
                                   

                                        <div class="col-md-2">
                                            <input type="text" class="form-control" id="search_folder_number"  v-model="form.search_message_title"
                                            placeholder="البحث بعنوان الرسالة"  
                                               />
                                        </div>
 

                                        <div class="col-md-2">
                                            <button class="btn btn-primary submit" @click="MessagesSearch()">بحث</button>
                                        </div>
                                    </div>
                                    <br>
                           

                                    <div class="row">
                                        <div class="col-md-2 page_number" >
                                            <label for=""> عدد النتائج</label>
                                            &nbsp;
                                            <input type="number" min="0" class="form-control" 
                                            @input="MessagesSearch()"
                                            v-model="form.page_number"
                                               />
                                        </div>
                                    </div>
                                    <div class="col-md-12"> <br> </div>
                                    <Skeleton  :number = "10" v-if="processing"  />
                                    <table class="  table-striped "  v-if="!processing" >
                                        <thead class="">
                                            <tr>
                                            <th>#</th>
                                            <th>  نوع الرسالة</th>
                                            <th>  عنوان الرسالة  </th>
                                            <th>محتوى الرسالة</th>
                                            <th> المرفقات</th>
                                            <th> رقم الملف</th>
                                            <th>   ارسلت ل</th>
                                            <!-- <th>العمليـات</th> -->
                                            </tr>
                                        </thead>
                                     
                                        <tbody class="">
                                            <tr v-for="message , i   in  messages.data" :key="i"  >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ message.message_type }}  </td>
                              
                                            <td > {{ message.message_title }}  </td>
                                            <td > {{ message.message_content }}  </td>

                                            <td >  <a  v-for=" attach , i  in JSON.parse( message.message_attachments) "  :key="i" 
                                                class="icon_hover"
                                                 :href="`/storage/${attach}`" target="_blank"   > 
                                                 
                                                 <fa   class="icon_hover" icon = "file-pdf" v-if="Functions.IsImageOrPdf(attach) == 'pdf' "  /> 
                                                 <fa   class="icon_hover" icon = "image" v-if="Functions.IsImageOrPdf(attach) == 'image' "  /> 
                                                 
                                                 &nbsp; </a>   
                                            </td>

                                            <td>   {{  `${message.files.company_name}/${message.files.folder_number}/${message.files.year}` }}  </td>
                                            <td >  
                                                    <label   v-for=" email , i  in JSON.parse( message.emails) "  :key="i"  > 
                                                        {{  `${email.email}  -- ${email.for}`  }} <hr>
                                                    </label>
                                                        
                                                   
                                            </td>

                                         
                                           
                                       
                                            
                                            <!-- <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
          
                                                    <li><Link class="dropdown-item btn btn_info " :href="route('Archiving.Files.Models.CreateReportReferralMessage' , file.id )" >انشاء رسالة إحالة بلاغ <fa icon = "file" /> </Link></li>
                                                    <li><Link class="dropdown-item btn btn_info " :href="route('Archiving.Messages.ReportsMessages.Create' , file.id )" >ارسال رسالة  <fa icon = "reply" />  </Link></li>
                                                    <li><Link class="dropdown-item btn btn_edit " :href="route('Archiving.Files.edit' , file.id )" >تعديل   <fa icon = "edit" /> </Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete(file.id , `${file.company_name}/${file.year}/${file.folder_number}`  )"
                                                      >حذف  <fa icon = "trash" />  </span></li>
                                                    <li><br class="dropdown-divider" /></li>
                                                </ul>
                                                </div>
                                            </td> -->

                                            </tr>
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                  </div>

                  <div v-if="props.messages.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.messages"  /> 
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

