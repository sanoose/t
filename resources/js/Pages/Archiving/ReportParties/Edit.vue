<script setup>

import { Head ,  Link,  useForm } from "@inertiajs/vue3" ;
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

const props = defineProps( ["report_party"] ) ;

let form = useForm ({
    id : props.report_party.id ,
    report_party_name : props.report_party.report_party_name ,
    exchange_rate : props.report_party.exchange_rate  , 
    currency_name : props.report_party.currency_name  , 
}); 

function  Update () {
         form.put( route('Archiving.ReportParties.update' , form.id )  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل الشركة جهة البلاغ بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم تعديل جهة البلاغ ") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}

 
 
</script>

<template>
    <Head title="تعديل جهة البلاغ" />
        <AppLayoutArchive> 
                    <div class="row g-3"  >
                            <h3> تعديل جهة البلاغ  </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="report_party_name" class="form-label">اسم جهة البلاغ </label>
                                <input type="text" class="form-control" id="report_party_name" v-model="form.report_party_name"  >
                                <div v-if = "form.errors.report_party_name" class="text-danger">{{form.errors.report_party_name}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="exchange_rate" class="form-label">  سعر الصرف مقابل الدولار</label>
                                <input type="text" class="form-control" id="exchange_rate"  v-model="form.exchange_rate"   />
                                <div v-if = "form.errors.exchange_rate" class="text-danger">{{form.errors.exchange_rate}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="currency_name" class="form-label">  اسم العملة</label>
                                <input type="currency_name" class="form-control" id="currency_name" v-model="form.currency_name"  />
                                <div v-if = "form.errors.currency_name" class="text-danger">{{form.errors.currency_name}}</div>
                            </div>

                            <div class="col-12">

                                <Link  :href="route('Archiving.ReportParties.index')"  class="btn btn-info">     
                                      <fa  icon = "arrow-right" />  رجوع         
                                </Link>  
                                &nbsp;
                                <button type="buttom"  @click="Update()" class="btn btn-primary "
                                 :disabled ="form.processing"  > {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }} </button>
                            </div>

                        </div>
         </AppLayoutArchive>
</template>

<style scoped>

.main-content {
     height: fit-content;
}

form {
    gap: 10px;
}
</style>

