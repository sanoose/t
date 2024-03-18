<script setup>

import { Head ,  useForm} from "@inertiajs/vue3" ;
import {  ref  } from 'vue';
import AppLayoutArchive from  '@/Layouts/AppLayoutArchive.vue';
import { toast } from 'vue3-toastify';

defineProps({ errors: Object }) ;

let form = useForm ({
    title   : 'عنوان الإشاري' ,
    from     : 'من' , 
    to     : 'الى' ,
}); 
 
 
function  Create () {
         form.post( route('Archiving.ReferenceNumbers.store')  , { preserveState : true , 
         onSuccess : () =>  toast.success("تم اضافةالرقم الإشاري بنجاح")  ,
         onError :  (e) => { toast.error("حدث خطأ لم تتم اضافة الرقم الإشاري") ;  } ,
         onFinish : () =>   { }  ,
         }) ;
}
 

</script>

<template>
    <Head title="اضافة إشاري" />

        <AppLayoutArchive> 
                    <div class="row g-3"  >
                            <h3> إضافة إشاري  </h3>
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

