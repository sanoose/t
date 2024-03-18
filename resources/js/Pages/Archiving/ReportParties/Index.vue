<script setup>
import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;

import { defineProps , ref  } from 'vue';
import Swal from 'sweetalert2'
import { toast } from 'vue3-toastify';
import {  router   } from '@inertiajs/vue3';

import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';

import Pagination from  '@/Layouts/Pagination.vue';
import  Skeleton  from '@/Components/Skeleton.vue';

const props = defineProps ( ["report_parties" , "filter" , "page_number" ] ) ; 
let  processing = ref(false) ;
 
const form = useForm({
    search_report_party_name : props.filter.search_report_party_name ,
    page_number :  props.page_number  ,
});

function ReportPartySearch(e) {
  form.get(route("Archiving.ReportParties.index"), { preserveState: true });
}

function  Delete(  id , name ) {
    Swal.fire({
        title: "حدف جهة البلاغ",
        icon: 'error',
        text: ` هل انت متأكد من حدف جهة البلاغ  باسم    ${name}  ؟`,
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "حذف",
        cancelButtonText: "إلغاء",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            processing.value = true ;
            router.visit(route('Archiving.ReportParties.destroy',id), 
            { method: 'delete'  ,  preserveScroll: true  ,
            onSuccess : () =>  toast.success("تم الحذف بنجاح") ,
            onError   : () =>  toast.error("خطأ لم يتم الحذف ")   ,
            onFinish   : () =>      processing.value = true    ,    } )
        }
    });
}

 
</script>

<template>

<Head title="عرض جهات البلاغ" />

            <AppLayoutArchive> 
                    <h3> عرض  جهات البلاغ </h3>
                    <hr>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="table-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="text" class="form-control" id="search_report_party_name"  v-model="form.search_report_party_name" 
                                            placeholder="البحث باسم جهة البلاغ "   
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary submit" @click="ReportPartySearch()">بحث</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2 page_number" >
                                            <label for=""> عدد النتائج</label>
                                            &nbsp;
                                            <select  class="form-control"  v-model="form.page_number" @change="ReportPartySearch()">
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
                                            <th>اسم جهة البلاغ</th>
                                            <th>  سعر الصرف مقابل الدولار</th>
                                            <th>العمليـات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="report_party , i   in props.report_parties.data" :key="report_party.id"   >
                                            <td  >  {{  i + 1  }}  </td>
                                            <td > {{ report_party.report_party_name }}  </td>
                                            <td>{{ `${report_party.exchange_rate}   ${report_party.currency_name} ` }}  </td>
                                   
                                            <td>
                                                <div class="btn-group">
                                                <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    العمليات
                                                </button>
                                                <ul class="dropdown-menu">
          
                                                    <li><Link class="dropdown-item btn btn_edit " :href="route('Archiving.ReportParties.edit' , report_party.id )" >تعديل</Link></li>
                                                    <li><span class="dropdown-item btn_delete btn" 
                                                            @click="Delete(report_party.id , report_party.report_party_name )"
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

                  <div v-if="props.report_parties.data.length >= 1" class="flex justify-center">
                       <Pagination :data = "props.report_parties"  /> 
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

