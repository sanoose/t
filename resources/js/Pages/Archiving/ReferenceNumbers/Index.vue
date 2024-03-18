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


const props = defineProps ( ["reference_numbers" , "filter" , "page_number" ] ) ; 
let  processing = ref(false) ;
let  years =  ref (Functions.GetYears()) ;

const form = useForm({
    search_reference_number : props.filter.search_reference_number != undefined ? props.filter.search_reference_number : ""   ,
    search_year  :  props.filter.search_year != undefined ? props.filter.search_year : ""   ,
    search_title :  props.filter.search_title != undefined ? props.filter.search_title : ""   ,
    page_number  :  props.filter.page_number != undefined ? props.filter.page_number : ""   ,
});

function ReferenceNumberSearch(e) {
  form.get(route("Archiving.ReferenceNumbers.index"), { preserveState: true  });
}

function  Delete(  id , name ) {
    Swal.fire({
        title: "حدف جهة البلاغ",
        icon: 'error',
        text: ` هل انت متأكد من حدف   الإشاري       ${name}  ؟`,
        type: "warning",
        showCancelButton: true ,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.ReferenceNumbers.destroy',id), 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

 
</script>

<template>

<Head title="عرض الأرقام الإشارية " />

           <AppLayoutArchive>
                    <h3> عرض   الأرقام الإشارية   </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_reference_number"  v-model="form.search_reference_number" 
                                            placeholder="البحث بالرقم الإشاري "   
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <select     class="form-control"  v-model="form.search_year" >
                                                    <option value="" disabled >--البحث  بالسنة --</option>
                                                    <option  v-for="year , i  in years " :key="i"  
                                                    :value="year"> {{  year }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_title"  v-model="form.search_title" 
                                            placeholder="البحث   بالعنوان   "   
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary submit" @click="ReferenceNumberSearch()" 
                                            :disabled="form.processing">بحث</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-2 page_number" >
                                        <label for=""> عدد النتائج</label>
                                        &nbsp;

                                        <input type="number" min="0" class="form-control"  @input="ReferenceNumberSearch()"
                                        v-model="form.page_number" placeholder=""   :disabled="form.processing" />

                                    </div>
                                    </div>
                                    <div class="col-md-12"> <br> </div>
                                    <Skeleton  :number = "10" v-if="processing"  />
                                    <table class="  table-striped"  v-if="!processing" >
                                        <thead>
                                            <tr>
                                            <th>#</th>
                                            <th> عنوان الإشاري</th>
                                            <th>من</th>
                                            <th>الى</th>
                                            <th>رقم الإشاري</th>
                                            <th> العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="reference_number , i   in props.reference_numbers.data" :key="reference_number.id"   >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ reference_number.title }}  </td>
                                            <td>{{ reference_number.from}}  </td>
                                            <td>{{ reference_number.to}}  </td>
                                            <td>{{ `${reference_number.year}/${reference_number.reference_number}` }}  </td>
                                   
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
          
                                                    <li><Link class="dropdown-item btn btn_edit " :href="route('Archiving.ReferenceNumbers.edit' , reference_number.id )" >تعديل</Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete(reference_number.id , 
                                                            `
                                                            رقم ${reference_number.year}/${reference_number.reference_number}   
                                                            بعنوان ${reference_number.title } 
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

                  <div v-if="props.reference_numbers.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.reference_numbers"  /> 
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

