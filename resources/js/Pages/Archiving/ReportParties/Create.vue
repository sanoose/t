<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

defineProps({ errors: Object }) ;

let form = useForm ({
    report_party_name : 'تونس' ,
  
    exchange_rate:  5.5 , 
    currency_name : 'تونس' ,
}); 

 
function  Create () {
 
         form.post( route('Archiving.ReportParties.store')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم اضافة الشركة بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الشركة") ;  } ,
         onFinish : () =>   {  }  ,
         }  ) ;
}
 
 


</script>

<template>
    <Head title="اضافة شركة" />

        <AppLayoutArchive> 
                    <div class="row g-3"  >
                            <h3> إضافة جهة بلاغ  </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="report_party_name" class="form-label">اسم جهة البلاغ </label>
                                <input type="text" class="form-control" id="report_party_name" v-model="form.report_party_name"  >
                                <div v-if = "form.errors.report_party_name" class="text-danger">{{form.errors.report_party_name}}</div>
                            </div>
                      
                            <div class="col-md-4">
                                <label for="exchange_rate" class="form-label">سعر الصرف مقابل الدولار</label>
                                <input type="number" min="0" step="0.1" class="form-control" id="exchange_rate"  v-model="form.exchange_rate" 
                                 placeholder="أدخل سعر صرف العملة مقابل الدولار "  />  
                                <div v-if = "form.errors.exchange_rate" class="text-danger">{{form.errors.exchange_rate}}</div>
                            </div>
                           
                            <div class="col-md-4">
                                <label for="currency_name" class="form-label">اسم العملة </label>
                                <input type="text" class="form-control" id="currency_name" v-model="form.currency_name"  >
                                <div v-if = "form.errors.report_party_name" class="text-danger">{{form.errors.currency_name}}</div>
                            </div>

                            <div class="col-12">
                                <button type="buttom" 
                                    @click="Create()"
                                :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري الحفظ ...' : 'حفظ'  }}</button>
                     
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

