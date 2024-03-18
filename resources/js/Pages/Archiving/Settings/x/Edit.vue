<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

const props = defineProps(['reference_number']) ;

let form = useForm ({
    id    :  props.reference_number.id ,
    title    :  props.reference_number.title ,
    from     : props.reference_number.from , 
    to       : props.reference_number.to ,
}); 

function  Update () {
         form.put( route('Archiving.ReferenceNumbers.update' , { id : form.id })  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم تعديل   بيانات الإشاري بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم تعديل  بيانات الإشاري") ;  } ,
         onFinish : () =>   { }  ,
         }) ;
}
 

</script>

<template>
    <Head title="تعديل إشاري" />

        <AppLayoutArchive> 
                    <div class="row g-3"  >
                            <h3> تعديل  إشاري رقم {{ `${reference_number.year}/${reference_number.reference_number}` }}  </h3>
                            <hr />
                            <div class="col-md-4">
                                <label for="title" class="form-label">عنوان الإشاري</label>
                                <input type="text" class="form-control" id="title" v-model="form.title"  >
                                <div v-if = "form.errors.title" class="text-danger">{{form.errors.title}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="from" class="form-label">  من </label>
                                <input type="text" class="form-control" id="from" v-model="form.from"  >
                                <div v-if = "form.errors.from" class="text-danger">{{form.errors.from}}</div>
                            </div>

                            <div class="col-md-4">
                                <label for="to" class="form-label">  الى </label>
                                <input type="text" class="form-control" id="to" v-model="form.to"  >
                                <div v-if = "form.errors.to" class="text-danger">{{form.errors.to}}</div>
                            </div>

                            <div class="col-12">

                                <Link  :href="route('Archiving.ReferenceNumbers.index')"  class="btn btn-info">     
                                      <fa  icon = "arrow-right" />  رجوع         
                                </Link>  
                                &nbsp;

                                <button type="buttom" 
                                    @click="Update()"
                                :disabled="form.processing"   class="btn btn-primary submit"> {{ form.processing ?  'جاري التعديل ...' : 'تعديل'  }}</button>
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

